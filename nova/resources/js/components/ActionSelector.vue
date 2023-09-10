<template>
  <SelectControl
    v-bind="$attrs"
    v-if="actionsForSelect.length > 0"
    ref="actionSelectControl"
    size="xs"
    @change="handleSelectionChange"
    :options="actionsForSelect"
    data-testid="action-select"
    dusk="action-select"
    selected=""
    :class="{ 'max-w-[6rem]': width === 'auto', 'w-full': width === 'full' }"
    :aria-label="__('Select Action')"
  >
    <option value="" disabled selected>{{ __('Actions') }}</option>
  </SelectControl>

  <!-- Confirm Action Modal -->
  <component
    class="text-left"
    v-if="actionModalVisible"
    :show="actionModalVisible"
    :is="selectedAction?.component"
    :working="working"
    :selected-resources="selectedResources"
    :resource-name="resourceName"
    :action="selectedAction"
    :errors="errors"
    @confirm="executeAction"
    @close="closeConfirmationModal"
  />

  <component
    v-if="responseModalVisible"
    :show="responseModalVisible"
    :is="actionResponseData?.modal"
    @confirm="closeResponseModal"
    @close="closeResponseModal"
    :data="actionResponseData"
  />
</template>

<script setup>
import { useActions } from '@/composables/useActions'
import { useStore } from 'vuex'
import { computed, ref } from 'vue'

// Elements
const actionSelectControl = ref(null)

const store = useStore()

const emitter = defineEmits(['actionExecuted'])

const props = defineProps({
  width: { type: String, default: 'auto' },
  pivotName: { type: String, default: null },

  resourceName: {},
  viaResource: {},
  viaResourceId: {},
  viaRelationship: {},
  relationshipType: {},
  pivotActions: {
    type: Object,
    default: () => ({ name: 'Pivot', actions: [] }),
  },
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
  setSelectedActionKey,
  determineActionStrategy,
  working,
  executeAction,
  availableActions,
  availablePivotActions,
  actionResponseData,
} = useActions(props, emitter, store)

const handleSelectionChange = event => {
  setSelectedActionKey(event)
  determineActionStrategy()

  actionSelectControl.value.resetSelection()
}

const actionsForSelect = computed(() => [
  ...availableActions.value.map(a => ({ value: a.uriKey, label: a.name })),
  ...availablePivotActions.value.map(a => ({
    group: props.pivotName,
    value: a.uriKey,
    label: a.name,
  })),
])
</script>
