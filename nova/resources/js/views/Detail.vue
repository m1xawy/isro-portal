<template>
  <LoadingView :loading="initialLoading">
    <template v-if="shouldOverrideMeta && resourceInformation && title">
      <Head
        :title="
          __(':resource Details: :title', {
            resource: resourceInformation.singularLabel,
            title: title,
          })
        "
      />
    </template>

    <div v-if="shouldShowCards && hasDetailOnlyCards">
      <Cards
        v-if="cards.length > 0"
        :cards="cards"
        :only-on-detail="true"
        :resource="resource"
        :resource-id="resourceId"
        :resource-name="resourceName"
      />
    </div>

    <!-- Resource Detail -->
    <div
      :class="{
        'mt-6': shouldShowCards && hasDetailOnlyCards && cards.length > 0,
      }"
      :dusk="resourceName + '-detail-component'"
    >
      <component
        :is="resolveComponentName(panel)"
        v-for="panel in panels"
        :key="panel.id"
        :panel="panel"
        :resource="resource"
        :resource-id="resourceId"
        :resource-name="resourceName"
        class="mb-8"
      >
        <div v-if="panel.showToolbar" class="md:flex items-center mb-3">
          <div class="flex flex-auto truncate items-center">
            <Heading :level="1" v-text="panel.name" />
            <Badge
              v-if="resource.softDeleted"
              :label="__('Soft Deleted')"
              class="bg-red-100 text-red-500 dark:bg-red-400 dark:text-red-900 rounded px-2 py-0.5 ml-3"
            />
          </div>

          <div class="ml-auto flex items-center">
            <!-- Actions Menu -->
            <DetailActionDropdown
              v-if="shouldShowActionDropdown"
              :resource="resource"
              :actions="actions"
              :via-resource="viaResource"
              :via-resource-id="viaResourceId"
              :via-relationship="viaRelationship"
              :resource-name="resourceName"
              class="mt-1 md:mt-0 md:ml-2 md:mr-2"
              @actionExecuted="actionExecuted"
              @resource-deleted="getResource"
              @resource-restored="getResource"
            />

            <Link
              v-if="showViewLink"
              v-tooltip="{
                placement: 'bottom',
                distance: 10,
                skidding: 0,
                content: __('View'),
              }"
              :href="$url(`/resources/${resourceName}/${resourceId}`)"
              class="rounded hover:bg-gray-200 dark:hover:bg-gray-800 focus:outline-none focus:ring"
              data-testid="view-resource"
              dusk="view-resource-button"
              tabindex="1"
            >
              <BasicButton component="span">
                <Icon type="eye" />
              </BasicButton>
            </Link>

            <Link
              v-if="resource.authorizedToUpdate"
              v-tooltip="{
                placement: 'bottom',
                distance: 10,
                skidding: 0,
                content: __('Edit'),
              }"
              :href="$url(`/resources/${resourceName}/${resourceId}/edit`)"
              class="rounded hover:bg-gray-200 dark:hover:bg-gray-800 focus:outline-none focus:ring"
              data-testid="edit-resource"
              dusk="edit-resource-button"
              tabindex="1"
            >
              <BasicButton component="span">
                <Icon type="pencil-alt" />
              </BasicButton>
            </Link>
          </div>
        </div>
      </component>
    </div>
  </LoadingView>
</template>

<script>
import isNil from 'lodash/isNil'
import {
  Errors,
  HasCards,
  InteractsWithResourceInformation,
  mapProps,
} from '@/mixins'
import { minimum } from '@/util'
import { mapGetters, mapActions } from 'vuex'

export default {
  props: {
    shouldOverrideMeta: { type: Boolean, default: false },
    showViewLink: { type: Boolean, default: false },
    shouldEnableShortcut: { type: Boolean, default: false },

    ...mapProps([
      'resourceName',
      'resourceId',
      'viaResource',
      'viaResourceId',
      'viaRelationship',
      'relationshipType',
    ]),
  },

  mixins: [HasCards, InteractsWithResourceInformation],

  data: () => ({
    initialLoading: true,
    loading: true,

    title: null,
    resource: null,
    panels: [],
    actions: [],
    actionValidationErrors: new Errors(),
  }),

  /**
   * Bind the keydown even listener when the component is created
   */
  created() {
    if (Nova.missingResource(this.resourceName)) return Nova.visit('/404')

    if (this.shouldEnableShortcut === true) {
      Nova.addShortcut('e', this.handleKeydown)
    }
  },

  /**
   * Unbind the keydown even listener when the before component is destroyed
   */
  beforeUnmount() {
    if (this.shouldEnableShortcut === true) {
      Nova.disableShortcut('e')
    }
  },

  /**
   * Mount the component.
   */
  mounted() {
    this.initializeComponent()
  },

  methods: {
    ...mapActions(['startImpersonating']),

    /**
     * Initialize the component's data.
     */
    handleResourceLoaded() {
      this.loading = false

      Nova.$emit('resource-loaded', {
        resourceName: this.resourceName,
        resourceId: this.resourceId.toString(),
        mode: 'detail',
      })
    },

    /**
     * Handle the keydown event
     */
    handleKeydown(e) {
      if (
        this.resource.authorizedToUpdate &&
        e.target.tagName != 'INPUT' &&
        e.target.tagName != 'TEXTAREA' &&
        e.target.contentEditable != 'true'
      ) {
        Nova.visit(`/resources/${this.resourceName}/${this.resourceId}/edit`)
      }
    },

    /**
     * Initialize the component's data.
     */
    async initializeComponent() {
      await this.getResource()
      await this.getActions()

      this.initialLoading = false
    },

    /**
     * Get the resource information.
     */
    getResource() {
      this.loading = true
      this.panels = null
      this.resource = null

      return minimum(
        Nova.request().get(
          '/nova-api/' + this.resourceName + '/' + this.resourceId,
          {
            params: {
              viaResource: this.viaResource,
              viaResourceId: this.viaResourceId,
              viaRelationship: this.viaRelationship,
              relationshipType: this.relationshipType,
            },
          }
        )
      )
        .then(({ data: { title, panels, resource } }) => {
          this.title = title
          this.panels = panels
          this.resource = resource

          this.handleResourceLoaded()
        })
        .catch(error => {
          if (error.response.status >= 500) {
            Nova.$emit('error', error.response.data.message)
            return
          }

          if (error.response.status === 404 && this.initialLoading) {
            Nova.visit('/404')
            return
          }

          if (error.response.status === 403) {
            Nova.visit('/403')
            return
          }

          if (error.response.status === 401) return Nova.redirectToLogin()

          Nova.error(this.__('This resource no longer exists'))

          Nova.visit(`/resources/${this.resourceName}`)
        })
    },

    /**
     * Get the available actions for the resource.
     */
    async getActions() {
      this.actions = []

      try {
        const response = await Nova.request().get(
          '/nova-api/' + this.resourceName + '/actions',
          {
            params: {
              resourceId: this.resourceId,
              editing: true,
              editMode: 'create',
              display: 'detail',
            },
          }
        )

        this.actions = response.data?.actions
      } catch (error) {
        console.log(error)
        Nova.error(this.__('Unable to load actions for this resource'))
      }
    },

    /**
     * Handle an action executed event.
     */
    async actionExecuted() {
      await this.getResource()
      await this.getActions()
    },

    /**
     * Resolve the component name.
     */
    resolveComponentName(panel) {
      return isNil(panel.prefixComponent) || panel.prefixComponent
        ? 'detail-' + panel.component
        : panel.component
    },
  },

  computed: {
    ...mapGetters(['currentUser']),

    canBeImpersonated() {
      return (
        this.currentUser.canImpersonate && this.resource.authorizedToImpersonate
      )
    },

    shouldShowActionDropdown() {
      return (
        this.resource && (this.actions.length > 0 || this.canModifyResource)
      )
    },

    canModifyResource() {
      return (
        this.resource.authorizedToReplicate ||
        this.canBeImpersonated ||
        (this.resource.authorizedToDelete && !this.resource.softDeleted) ||
        (this.resource.authorizedToRestore && this.resource.softDeleted) ||
        this.resource.authorizedToForceDelete
      )
    },

    /**
     * Determine whether this is a detail view for an Action Event
     */
    isActionDetail() {
      return this.resourceName === 'action-events'
    },

    /**
     * Get the endpoint for this resource's metrics.
     */
    cardsEndpoint() {
      return `/nova-api/${this.resourceName}/cards`
    },

    /**
     * Get the extra card params to pass to the endpoint.
     */
    extraCardParams() {
      return {
        resourceId: this.resourceId,
      }
    },
  },
}
</script>
