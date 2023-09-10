import { Errors } from '@/mixins'
import { computed, reactive } from 'vue'
import find from 'lodash/find'
import filter from 'lodash/filter'
import isNil from 'lodash/isNil'
import tap from 'lodash/tap'
import { useQueryParams } from '@/composables/useQueryParams'
import each from 'lodash/each'
import { useLocalization } from '@/composables/useLocalization'

const { __ } = useLocalization()

export function useActions(props, emitter, store) {
  const { params } = useQueryParams()

  const state = reactive({
    working: false,
    errors: new Errors(),
    actionModalVisible: false,
    responseModalVisible: false,
    selectedActionKey: '',
    endpoint: props.endpoint || `/nova-api/${props.resourceName}/action`,
    actionResponseData: null,
  })

  const selectedResources = computed(() => props.selectedResources)

  const selectedAction = computed(() => {
    if (state.selectedActionKey) {
      return find(allActions.value, a => a.uriKey === state.selectedActionKey)
    }
  })

  const allActions = computed(() =>
    props.actions.concat(props.pivotActions?.actions || [])
  )

  const encodedFilters = computed(
    () => store.getters[`${props.resourceName}/currentEncodedFilters`]
  )

  const searchParameter = computed(() =>
    props.viaRelationship
      ? props.viaRelationship + '_search'
      : props.resourceName + '_search'
  )

  const currentSearch = computed(() => params[searchParameter.value] || '')

  const trashedParameter = computed(() =>
    props.viaRelationship
      ? props.viaRelationship + '_trashed'
      : props.resourceName + '_trashed'
  )

  const currentTrashed = computed(() => params[trashedParameter.value] || '')

  const availableActions = computed(() => {
    return filter(
      props.actions,
      action => selectedResources.value.length > 0 && !action.standalone
    )
  })

  const availablePivotActions = computed(() => {
    if (!props.pivotActions) {
      return []
    }

    return filter(props.pivotActions.actions, action => {
      if (selectedResources.value.length === 0) {
        return action.standalone
      }

      return true
    })
  })

  const hasPivotActions = computed(() => availablePivotActions.value.length > 0)

  const selectedActionIsPivotAction = computed(() => {
    return (
      hasPivotActions.value &&
      Boolean(find(props.pivotActions.actions, a => a === selectedAction.value))
    )
  })

  const actionRequestQueryString = computed(() => {
    return {
      action: state.selectedActionKey,
      pivotAction: selectedActionIsPivotAction.value,
      search: currentSearch.value,
      filters: encodedFilters.value,
      trashed: currentTrashed.value,
      viaResource: props.viaResource,
      viaResourceId: props.viaResourceId,
      viaRelationship: props.viaRelationship,
    }
  })

  const actionFormData = computed(() => {
    return tap(new FormData(), formData => {
      formData.append('resources', selectedResources.value)

      each(selectedAction.value.fields, field => {
        field.fill(formData)
      })
    })
  })

  function determineActionStrategy() {
    if (selectedAction.value.withoutConfirmation) {
      executeAction()
    } else {
      openConfirmationModal()
    }
  }

  function openConfirmationModal() {
    state.actionModalVisible = true
  }

  function closeConfirmationModal() {
    state.actionModalVisible = false
  }

  function openResponseModal() {
    state.responseModalVisible = true
  }

  function closeResponseModal() {
    state.responseModalVisible = false
  }

  function emitResponseCallback(callback) {
    emitter('actionExecuted')
    Nova.$emit('action-executed')

    if (typeof callback === 'function') {
      callback()
    }
  }

  function executeAction(then) {
    state.working = true
    Nova.$progress.start()

    let responseType = selectedAction.value.responseType ?? 'json'

    Nova.request({
      method: 'post',
      url: state.endpoint,
      params: actionRequestQueryString.value,
      data: actionFormData.value,
      responseType,
    })
      .then(async response => {
        closeConfirmationModal()
        handleActionResponse(response.data, response.headers, then)
      })
      .catch(error => {
        if (error.response && error.response.status === 422) {
          if (responseType === 'blob') {
            error.response.data.text().then(data => {
              state.errors = new Errors(JSON.parse(data).errors)
            })
          } else {
            state.errors = new Errors(error.response.data.errors)
          }

          Nova.error(__('There was a problem executing the action.'))
        }
      })
      .finally(() => {
        state.working = false
        Nova.$progress.done()
      })
  }

  function handleActionResponse(data, headers, then) {
    let contentDisposition = headers['content-disposition']

    if (
      data instanceof Blob &&
      isNil(contentDisposition) &&
      data.type === 'application/json'
    ) {
      data.text().then(jsonStringData => {
        handleActionResponse(JSON.parse(jsonStringData), headers)
      })

      return
    }

    if (data instanceof Blob) {
      return emitResponseCallback(() => {
        let fileName = 'unknown'
        let url = window.URL.createObjectURL(new Blob([data]))
        let link = document.createElement('a')
        link.href = url

        if (contentDisposition) {
          let fileNameMatch = contentDisposition.match(/filename="(.+)"/)
          if (fileNameMatch.length === 2) fileName = fileNameMatch[1]
        }

        link.setAttribute('download', fileName)
        document.body.appendChild(link)
        link.click()
        link.remove()
        window.URL.revokeObjectURL(url)
      })
    }

    if (data.modal) {
      state.actionResponseData = data

      return openResponseModal()
    }

    if (data.message) {
      return emitResponseCallback(() => Nova.success(data.message))
    }

    if (data.deleted) {
      return emitResponseCallback()
    }

    if (data.download) {
      return emitResponseCallback(() => {
        let link = document.createElement('a')
        link.href = data.download
        link.download = data.name
        document.body.appendChild(link)
        link.click()
        document.body.removeChild(link)
      })
    }

    if (data.deleted) {
      return emitResponseCallback()
    }

    if (data.danger) {
      return emitResponseCallback(() => Nova.error(data.danger))
    }

    if (data.redirect) {
      window.location = data.redirect
    }

    if (data.visit) {
      return Nova.visit({
        url: Nova.url(data.visit.path, data.visit.options),
        remote: false,
      })
    }

    if (data.openInNewTab) {
      return emitResponseCallback(() =>
        window.open(data.openInNewTab, '_blank')
      )
    }

    let message = data.message || __('The action was executed successfully.')
    return emitResponseCallback(() => Nova.success(message))
  }

  function handleActionClick(uriKey) {
    state.selectedActionKey = uriKey
    determineActionStrategy()
  }

  function setSelectedActionKey(key) {
    state.selectedActionKey = key
  }

  return {
    errors: computed(() => state.errors),
    working: computed(() => state.working),
    actionModalVisible: computed(() => state.actionModalVisible),
    responseModalVisible: computed(() => state.responseModalVisible),
    selectedActionKey: computed(() => state.selectedActionKey),
    determineActionStrategy,
    setSelectedActionKey,
    openConfirmationModal,
    closeConfirmationModal,
    openResponseModal,
    closeResponseModal,
    handleActionClick,
    selectedAction,
    allActions,
    availableActions,
    availablePivotActions,
    executeAction,
    actionResponseData: computed(() => state.actionResponseData),
  }
}
