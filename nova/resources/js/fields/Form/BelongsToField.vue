<template>
  <DefaultField
    :field="currentField"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <div class="flex items-center space-x-2">
        <SearchInput
          v-if="useSearchInput"
          :data-testid="`${field.resourceName}-search-input`"
          :disabled="currentlyIsReadonly"
          @input="performResourceSearch"
          @clear="clearResourceSelection"
          @selected="selectResource"
          :error="hasError"
          :debounce="currentField.debounce"
          :value="selectedResource"
          :data="filteredResources"
          :clearable="
            currentField.nullable ||
            editingExistingResource ||
            viaRelatedResource ||
            createdViaRelationModal
          "
          trackBy="value"
          class="w-full"
          :mode="mode"
        >
          <div v-if="selectedResource" class="flex items-center">
            <div v-if="selectedResource.avatar" class="mr-3">
              <img
                :src="selectedResource.avatar"
                class="w-8 h-8 rounded-full block"
              />
            </div>

            {{ selectedResource.display }}
          </div>

          <template #option="{ selected, option }">
            <SearchInputResult
              :option="option"
              :selected="selected"
              :with-subtitles="currentField.withSubtitles"
            />
          </template>
        </SearchInput>

        <SelectControl
          v-else
          class="w-full"
          :select-classes="{ 'form-input-border-error': hasError }"
          :data-testid="field.resourceName"
          :dusk="`${field.resourceName}-select`"
          :disabled="currentlyIsReadonly"
          :options="availableResources"
          v-model:selected="selectedResourceId"
          @change="selectResourceFromSelectControl"
          label="display"
        >
          <option value="" selected :disabled="!currentField.nullable">
            {{ placeholder }}
          </option>
        </SelectControl>

        <CreateRelationButton
          v-if="canShowNewRelationModal"
          v-tooltip="__('Create :resource', { resource: field.singularLabel })"
          @click="openRelationModal"
          :dusk="`${field.attribute}-inline-create`"
        />
      </div>

      <CreateRelationModal
        :show="canShowNewRelationModal && relationModalOpen"
        :size="field.modalSize"
        @set-resource="handleSetResource"
        @create-cancelled="closeRelationModal"
        :resource-name="field.resourceName"
        :resource-id="resourceId"
        :via-relationship="viaRelationship"
        :via-resource="viaResource"
        :via-resource-id="viaResourceId"
      />

      <TrashedCheckbox
        v-if="shouldShowTrashed"
        class="mt-3"
        :resource-name="field.resourceName"
        :checked="withTrashed"
        @input="toggleWithTrashed"
      />
    </template>
  </DefaultField>
</template>

<script>
import find from 'lodash/find'
import isNil from 'lodash/isNil'
import storage from '@/storage/BelongsToFieldStorage'
import {
  DependentFormField,
  HandlesValidationErrors,
  InteractsWithQueryString,
  PerformsSearches,
  TogglesTrashed,
} from '@/mixins'
import filled from '@/util/filled'

export default {
  mixins: [
    DependentFormField,
    HandlesValidationErrors,
    InteractsWithQueryString,
    PerformsSearches,
    TogglesTrashed,
  ],

  props: {
    resourceId: {},
  },

  data: () => ({
    availableResources: [],
    initializingWithExistingResource: false,
    createdViaRelationModal: false,
    selectedResource: null,
    selectedResourceId: null,
    softDeletes: false,
    withTrashed: false,
    search: '',
    relationModalOpen: false,
  }),

  /**
   * Mount the component.
   */
  mounted() {
    this.initializeComponent()
  },

  methods: {
    initializeComponent() {
      this.withTrashed = false

      this.selectedResourceId = this.currentField.value

      if (this.editingExistingResource) {
        // If a user is editing an existing resource with this relation
        // we'll have a belongsToId on the field, and we should prefill
        // that resource in this field
        this.initializingWithExistingResource = true
        this.selectedResourceId = this.currentField.belongsToId
      } else if (this.viaRelatedResource) {
        // If the user is creating this resource via a related resource's index
        // page we'll have a viaResource and viaResourceId in the params and
        // should prefill the resource in this field with that information
        this.initializingWithExistingResource = true
        this.selectedResourceId = this.viaResourceId
      }

      if (this.shouldSelectInitialResource) {
        if (this.useSearchInput) {
          // If we should select the initial resource and the field is
          // searchable, we won't load all the resources but we will select
          // the initial option.
          this.getAvailableResources().then(() => this.selectInitialResource())
        } else {
          // If we should select the initial resource but the field is not
          // searchable we should load all of the available resources into the
          // field first and select the initial option.
          this.initializingWithExistingResource = false

          this.getAvailableResources().then(() => this.selectInitialResource())
        }
      } else if (!this.isSearchable) {
        // If we don't need to select an initial resource because the user
        // came to create a resource directly and there's no parent resource,
        // and the field is searchable we'll just load all of the resources.
        this.getAvailableResources()
      }

      this.determineIfSoftDeletes()

      this.field.fill = this.fill
    },

    /**
     * Select a resource using the <select> control
     */
    selectResourceFromSelectControl(value) {
      this.selectedResourceId = value
      this.selectInitialResource()

      if (this.field) {
        this.emitFieldValueChange(this.fieldAttribute, this.selectedResourceId)
      }
    },

    /**
     * Fill the forms formData with details from this field
     */
    fill(formData) {
      this.fillIfVisible(
        formData,
        this.fieldAttribute,
        this.selectedResource ? this.selectedResource.value : ''
      )
      this.fillIfVisible(
        formData,
        `${this.fieldAttribute}_trashed`,
        this.withTrashed
      )
    },

    /**
     * Get the resources that may be related to this resource.
     */
    getAvailableResources() {
      Nova.$progress.start()

      return storage
        .fetchAvailableResources(this.resourceName, this.fieldAttribute, {
          params: this.queryParams,
        })
        .then(({ data: { resources, softDeletes, withTrashed } }) => {
          Nova.$progress.done()

          if (this.initializingWithExistingResource || !this.isSearchable) {
            this.withTrashed = withTrashed
          }

          if (this.viaRelatedResource) {
            let selectedResource = find(resources, r =>
              this.isSelectedResourceId(r.value)
            )

            if (
              isNil(selectedResource) &&
              !this.shouldIgnoresViaRelatedResource
            ) {
              return Nova.visit('/404')
            }
          }

          // Turn off initializing the existing resource after the first time
          if (this.useSearchInput) {
            this.initializingWithExistingResource = false
          }
          this.availableResources = resources
          this.softDeletes = softDeletes
        })
        .catch(e => {
          Nova.$progress.done()
        })
    },

    /**
     * Determine if the relatd resource is soft deleting.
     */
    determineIfSoftDeletes() {
      return storage
        .determineIfSoftDeletes(this.field.resourceName)
        .then(response => {
          this.softDeletes = response.data.softDeletes
        })
    },

    /**
     * Determine if the given value is numeric.
     */
    isNumeric(value) {
      return !isNaN(parseFloat(value)) && isFinite(value)
    },

    /**
     * Select the initial selected resource
     */
    selectInitialResource() {
      this.selectedResource = find(this.availableResources, r =>
        this.isSelectedResourceId(r.value)
      )
    },

    /**
     * Toggle the trashed state of the search
     */
    toggleWithTrashed() {
      // Reload the data if the component doesn't have selected resource
      if (!filled(this.selectedResource)) {
        this.withTrashed = !this.withTrashed

        if (!this.useSearchInput) {
          this.getAvailableResources()
        }
      }
    },

    openRelationModal() {
      Nova.$emit('create-relation-modal-opened')
      this.relationModalOpen = true
    },

    closeRelationModal() {
      this.relationModalOpen = false
      Nova.$emit('create-relation-modal-closed')
    },

    handleSetResource({ id }) {
      this.closeRelationModal()
      this.selectedResourceId = id
      this.initializingWithExistingResource = true
      this.createdViaRelationModal = true
      this.getAvailableResources().then(() => {
        this.selectInitialResource()

        this.emitFieldValueChange(this.fieldAttribute, this.selectedResourceId)
      })
    },

    performResourceSearch(search) {
      if (this.useSearchInput) {
        this.performSearch(search)
      } else {
        this.search = search
      }
    },

    clearResourceSelection() {
      this.clearSelection()

      if (this.viaRelatedResource && !this.createdViaRelationModal) {
        this.updateQueryString({
          viaResource: null,
          viaResourceId: null,
          viaRelationship: null,
          relationshipType: null,
        }).then(() => {
          Nova.$router.reload({
            onSuccess: () => {
              this.initializingWithExistingResource = false
              this.initializeComponent()
            },
          })
        })
      } else {
        if (this.createdViaRelationModal) {
          this.createdViaRelationModal = false
          this.initializingWithExistingResource = false
        }

        this.getAvailableResources()
      }
    },

    onSyncedField() {
      if (this.viaRelatedResource) {
        return
      }

      this.initializeComponent()
    },

    emitOnSyncedFieldValueChange() {
      if (this.viaRelatedResource) {
        return
      }

      this.emitFieldValueChange(this.fieldAttribute, this.selectedResourceId)
    },

    syncedFieldValueHasNotChanged() {
      return this.isSelectedResourceId(this.currentField.value)
    },

    isSelectedResourceId(value) {
      return (
        !isNil(value) &&
        value?.toString() === this.selectedResourceId?.toString()
      )
    },
  },

  computed: {
    /**
     * Determine if we are editing and existing resource
     */
    editingExistingResource() {
      return filled(this.field.belongsToId)
    },

    /**
     * Determine if we are creating a new resource via a parent relation
     */
    viaRelatedResource() {
      return Boolean(
        this.viaResource === this.field.resourceName &&
          this.field.reverse &&
          this.viaResourceId
      )
    },

    /**
     * Determine if we should select an initial resource when mounting this field
     */
    shouldSelectInitialResource() {
      return Boolean(
        this.editingExistingResource ||
          this.viaRelatedResource ||
          this.currentField.value
      )
    },

    /**
     * Determine if the related resources is searchable
     */
    isSearchable() {
      return Boolean(this.currentField.searchable)
    },

    /**
     * Get the query params for getting available resources
     */
    queryParams() {
      return {
        current: this.selectedResourceId,
        first: this.shouldLoadFirstResource,
        search: this.search,
        withTrashed: this.withTrashed,
        resourceId: this.resourceId,
        viaResource: this.viaResource,
        viaResourceId: this.viaResourceId,
        viaRelationship: this.viaRelationship,
        component: this.field.dependentComponentKey,
        dependsOn: this.encodedDependentFieldValues,
        editing: true,
        editMode:
          isNil(this.resourceId) || this.resourceId === ''
            ? 'create'
            : 'update',
      }
    },

    shouldLoadFirstResource() {
      return (
        (this.initializingWithExistingResource &&
          !this.shouldIgnoresViaRelatedResource) ||
        Boolean(this.currentlyIsReadonly && this.selectedResourceId)
      )
    },

    shouldShowTrashed() {
      return (
        this.softDeletes &&
        !this.viaRelatedResource &&
        !this.currentlyIsReadonly &&
        this.currentField.displaysWithTrashed
      )
    },

    authorizedToCreate() {
      return find(Nova.config('resources'), resource => {
        return resource.uriKey === this.field.resourceName
      }).authorizedToCreate
    },

    canShowNewRelationModal() {
      return (
        this.currentField.showCreateRelationButton &&
        !this.shownViaNewRelationModal &&
        !this.viaRelatedResource &&
        !this.currentlyIsReadonly &&
        this.authorizedToCreate
      )
    },

    /**
     * Return the placeholder text for the field.
     */
    placeholder() {
      return this.currentField.placeholder || this.__('—')
    },

    /**
     * Return the field options filtered by the search string.
     */
    filteredResources() {
      if (!this.isSearchable) {
        return this.availableResources.filter(option => {
          return (
            option.display.toLowerCase().indexOf(this.search.toLowerCase()) >
              -1 || new String(option.value).indexOf(this.search) > -1
          )
        })
      }

      return this.availableResources
    },

    shouldIgnoresViaRelatedResource() {
      return this.viaRelatedResource && filled(this.search)
    },

    useSearchInput() {
      return this.isSearchable || this.viaRelatedResource
    },
  },
}
</script>
