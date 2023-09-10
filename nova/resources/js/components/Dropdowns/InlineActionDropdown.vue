<template>
  <ActionDropdown
    :resource="resource"
    :actions="actions"
    :via-resource="viaResource"
    :via-resource-id="viaResourceId"
    :via-relationship="viaRelationship"
    :resource-name="resourceName"
    @actionExecuted="$emit('actionExecuted')"
    :selected-resources="[resource.id.value]"
  >
    <template #sr-only>
      <span class="sr-only">{{ __('Resource Row Dropdown') }}</span>
    </template>

    <template #trigger>
      <DropdownTrigger
        :dusk="`${resource.id.value}-control-selector`"
        :show-arrow="false"
      >
        <span class="py-0.5 px-2 rounded">
          <Icon :solid="true" type="dots-horizontal" />
        </span>
      </DropdownTrigger>
    </template>

    <div
      class="py-1"
      v-if="
        (resource.authorizedToView && resource.previewHasFields) ||
        resource.authorizedToReplicate ||
        (currentUser.canImpersonate && resource.authorizedToImpersonate)
      "
    >
      <!-- Preview Resource Link -->
      <DropdownMenuItem
        v-if="resource.authorizedToView && resource.previewHasFields"
        :data-testid="`${resource.id.value}-preview-button`"
        :dusk="`${resource.id.value}-preview-button`"
        as="button"
        @click.prevent="$emit('show-preview')"
        :title="__('Preview')"
      >
        {{ __('Preview') }}
      </DropdownMenuItem>

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
    </div>
  </ActionDropdown>
</template>

<script>
import { mapProps } from '@/mixins'
import { mapGetters, mapActions } from 'vuex'

export default {
  emits: ['actionExecuted', 'show-preview'],

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

  methods: mapActions(['startImpersonating']),

  computed: mapGetters(['currentUser']),
}
</script>
