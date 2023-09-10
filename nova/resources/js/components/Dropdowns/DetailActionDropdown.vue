<template>
  <div>
    <ActionDropdown
      class="mt-1 md:mt-0 md:ml-2 md:mr-2"
      v-if="resource"
      :resource="resource"
      :actions="actions"
      :via-resource="viaResource"
      :via-resource-id="viaResourceId"
      :via-relationship="viaRelationship"
      :resource-name="resourceName"
      @actionExecuted="$emit('actionExecuted')"
      :selected-resources="[resource.id.value]"
      :trigger-dusk-attribute="`${resource.id.value}-control-selector`"
    >
      <template #sr-only>
        <span class="sr-only">{{ __('Actions') }}</span>
      </template>

      <div
        class="py-1"
        v-if="
          resource.authorizedToReplicate ||
          (currentUser.canImpersonate && resource.authorizedToImpersonate) ||
          (resource.authorizedToDelete && !resource.softDeleted) ||
          (resource.authorizedToRestore && resource.softDeleted) ||
          resource.authorizedToForceDelete
        "
      >
        <!-- Replicate Resource Link -->
        <DropdownMenuItem
          v-if="resource.authorizedToReplicate"
          :dusk="`${resource.id.value}-replicate-button`"
          :href="
            $url(`/resources/${resourceName}/${resource.id.value}/replicate`, {
              viaResource,
              viaResourceId,
              viaRelationship,
            })
          "
          :title="__('Replicate')"
        >
          {{ __('Replicate') }}
        </DropdownMenuItem>

        <!-- Impersonate Resource Button -->
        <DropdownMenuItem
          as="button"
          v-if="currentUser.canImpersonate && resource.authorizedToImpersonate"
          :dusk="`${resource.id.value}-impersonate-button`"
          @click.prevent="
            startImpersonating({
              resource: resourceName,
              resourceId: resource.id.value,
            })
          "
          :title="__('Impersonate')"
        >
          {{ __('Impersonate') }}
        </DropdownMenuItem>

        <DropdownMenuItem
          v-if="resource.authorizedToDelete && !resource.softDeleted"
          data-testid="open-delete-modal"
          dusk="open-delete-modal-button"
          @click.prevent="openDeleteModal"
          :destructive="true"
        >
          {{ __('Delete Resource') }}
        </DropdownMenuItem>

        <DropdownMenuItem
          as="button"
          v-if="resource.authorizedToRestore && resource.softDeleted"
          class="block text-sm text-left w-full px-3 py-1 font-semibold text-red-400 hover:text-red-300 focus:text-red-600 focus:outline-none focus:ring ring-inset"
          data-testid="open-restore-modal"
          dusk="open-restore-modal-button"
          @click.prevent="openRestoreModal"
        >
          {{ __('Restore Resource') }}
        </DropdownMenuItem>

        <DropdownMenuItem
          as="button"
          v-if="resource.authorizedToForceDelete"
          class="block text-sm text-left w-full px-3 py-1 font-semibold text-red-400 hover:text-red-300 focus:text-red-600 focus:outline-none focus:ring ring-inset"
          data-testid="open-force-delete-modal"
          dusk="open-force-delete-modal-button"
          @click.prevent="openForceDeleteModal"
          :destructive="true"
        >
          {{ __('Force Delete Resource') }}
        </DropdownMenuItem>
      </div>
    </ActionDropdown>

    <DeleteResourceModal
      :show="deleteModalOpen"
      mode="delete"
      @close="closeDeleteModal"
      @confirm="confirmDelete"
    />

    <RestoreResourceModal
      :show="restoreModalOpen"
      @close="closeRestoreModal"
      @confirm="confirmRestore"
    />

    <DeleteResourceModal
      :show="forceDeleteModalOpen"
      mode="force delete"
      @close="closeForceDeleteModal"
      @confirm="confirmForceDelete"
    />
  </div>
</template>

<script>
import { Deletable, InteractsWithResourceInformation, mapProps } from '@/mixins'
import { mapGetters, mapActions } from 'vuex'

export default {
  emits: ['actionExecuted', 'resource-deleted', 'resource-restored'],

  inheritAttrs: false,

  mixins: [Deletable, InteractsWithResourceInformation],

  props: {
    resource: { type: Object },
    actions: { type: Array },
    viaManyToMany: { type: Boolean },

    ...mapProps([
      'resourceName',
      'viaResource',
      'viaResourceId',
      'viaRelationship',
    ]),
  },

  data: () => ({
    deleteModalOpen: false,
    restoreModalOpen: false,
    forceDeleteModalOpen: false,
  }),

  methods: {
    ...mapActions(['startImpersonating']),

    /**
     * Show the confirmation modal for deleting or detaching a resource
     */
    async confirmDelete() {
      this.deleteResources([this.resource], response => {
        Nova.success(
          this.__('The :resource was deleted!', {
            resource: this.resourceInformation.singularLabel.toLowerCase(),
          })
        )

        if (response && response.data && response.data.redirect) {
          Nova.visit(response.data.redirect)
          return
        }

        if (!this.resource.softDeletes) {
          Nova.visit(`/resources/${this.resourceName}`)
          return
        }

        this.closeDeleteModal()
        this.$emit('resource-deleted')
      })
    },

    /**
     * Open the delete modal
     */
    openDeleteModal() {
      this.deleteModalOpen = true
    },

    /**
     * Close the delete modal
     */
    closeDeleteModal() {
      this.deleteModalOpen = false
    },

    /**
     * Show the confirmation modal for restoring a resource
     */
    async confirmRestore() {
      this.restoreResources([this.resource], () => {
        Nova.success(
          this.__('The :resource was restored!', {
            resource: this.resourceInformation.singularLabel.toLowerCase(),
          })
        )

        this.closeRestoreModal()
        this.$emit('resource-restored')
      })
    },

    /**
     * Open the restore modal
     */
    openRestoreModal() {
      this.restoreModalOpen = true
    },

    /**
     * Close the restore modal
     */
    closeRestoreModal() {
      this.restoreModalOpen = false
    },

    /**
     * Show the confirmation modal for force deleting
     */
    async confirmForceDelete() {
      this.forceDeleteResources([this.resource], response => {
        Nova.success(
          this.__('The :resource was deleted!', {
            resource: this.resourceInformation.singularLabel.toLowerCase(),
          })
        )

        if (response && response.data && response.data.redirect) {
          Nova.visit(response.data.redirect)
          return
        }

        Nova.visit(`/resources/${this.resourceName}`)
      })
    },

    /**
     * Open the force delete modal
     */
    openForceDeleteModal() {
      this.forceDeleteModalOpen = true
    },

    /**
     * Close the force delete modal
     */
    closeForceDeleteModal() {
      this.forceDeleteModalOpen = false
    },
  },

  computed: mapGetters(['currentUser']),
}
</script>
