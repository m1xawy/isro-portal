<template>
  <div>
    <!-- Confirm Action Modal -->
    <component
      v-if="actionModalVisible"
      :show="actionModalVisible"
      class="text-left"
      :is="selectedAction?.component"
      :working="working"
      :selected-resources="selectedResources"
      :resource-name="resourceName"
      :action="selectedAction"
      :errors="errors"
      @confirm="runAction"
      @close="closeConfirmationModal"
    />

    <component
      v-if="responseModalVisible"
      :show="responseModalVisible"
      :is="actionResponseData?.modal"
      @confirm="handleResponseModalConfirm"
      @close="handleResponseModalClose"
      :data="actionResponseData"
    />

    <Dropdown class="h-9">
      <slot name="sr-only">
        <span class="sr-only">{{ __('Standalone Actions') }}</span>
      </slot>
      <slot name="trigger">
        <DropdownTrigger
          :dusk="triggerDuskAttribute"
          :show-arrow="false"
          class="rounded hover:bg-gray-200 dark:hover:bg-gray-800 focus:outline-none focus:ring"
        >
          <BasicButton component="span">
            <Icon :solid="true" type="dots-horizontal" />
          </BasicButton>
        </DropdownTrigger>
      </slot>

      <template #menu>
        <DropdownMenu width="auto" class="px-1">
          <ScrollWrap
            :height="250"
            class="divide-y divide-gray-100 dark:divide-gray-800 divide-solid"
          >
            <slot />

            <div v-if="actions.length > 0" class="py-1">
              <DropdownMenuItem
                v-for="action in actions"
                :key="action.uriKey"
                :data-action-id="action.uriKey"
                as="button"
                class="border-none"
                @click="() => handleActionClick(action.uriKey)"
                :title="action.name"
                :destructive="action.destructive"
              >
                {{ action.name }}
              </DropdownMenuItem>
            </div>
          </ScrollWrap>
        </DropdownMenu>
      </template>
    </Dropdown>
  </div>
</template>

<script setup>
import { useActions } from '@/composables/useActions'
import { useStore } from 'vuex'
const store = useStore()

const emitter = defineEmits(['actionExecuted'])

const props = defineProps({
  resourceName: {},
  viaResource: {},
  viaResourceId: {},
  viaRelationship: {},
  relationshipType: {},
  actions: { type: Array, default: [] },
  selectedResources: { type: [Array, String], default: () => [] },
  endpoint: { type: String, default: null },
  triggerDuskAttribute: { type: String, default: null },
})

const {
  errors,
  actionModalVisible,
  responseModalVisible,
  openConfirmationModal,
  closeConfirmationModal,
  closeResponseModal,
  handleActionClick,
  selectedAction,
  working,
  executeAction,
  actionResponseData,
} = useActions(props, emitter, store)

const runAction = () => executeAction(() => emitter('actionExecuted'))

const handleResponseModalConfirm = () => {
  closeResponseModal()
  emitter('actionExecuted')
}

const handleResponseModalClose = () => {
  closeResponseModal()
  emitter('actionExecuted')
}
</script>
