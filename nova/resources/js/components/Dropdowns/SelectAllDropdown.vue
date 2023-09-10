<template>
  <div>
    <Dropdown
      :handle-internal-clicks="false"
      dusk="select-all-dropdown"
      placement="bottom-start"
      :trigger-override-function="
        selectedResourcesCount > 0 ? () => $emit('deselect') : null
      "
    >
      <span class="sr-only">{{ __('Select All Dropdown') }}</span>
      <div
        v-if="selectedResourcesCount > 0"
        class="rounded-lg h-9 inline-flex items-center px-2 space-x-2 bg-gray-50 text-gray-600 dark:bg-gray-700 dark:text-gray-400 group"
        type="button"
      >
        <FakeCheckbox
          :checked="selectAllAndSelectAllMatchingChecked"
          :indeterminate="selectAllIndeterminate"
        />
        <span class="font-bold">{{
          __(':amount selected', {
            amount: selectAllMatchingChecked
              ? allMatchingResourceCount
              : selectedResourcesCount,
            label: singularOrPlural(selectedResourcesCount, 'resources'),
          })
        }}</span>
        <Icon
          type="x-circle"
          solid
          class="text-gray-400 group-hover:text-gray-500"
        />
      </div>
      <DropdownTrigger
        v-else
        class="h-9 px-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded space-x-2"
        :show-arrow="!selectedResourcesCount > 0"
      >
        <FakeCheckbox
          :aria-label="__('Select this page')"
          :checked="selectAllAndSelectAllMatchingChecked"
          :indeterminate="selectAllIndeterminate"
        />
      </DropdownTrigger>

      <template #menu>
        <DropdownMenu direction="ltr" width="250">
          <div class="p-4">
            <ul>
              <li class="flex items-center mb-4">
                <CheckboxWithLabel
                  :checked="selectAllChecked"
                  dusk="select-all-button"
                  @input="e => $emit('toggle-select-all', e)"
                >
                  <span>
                    {{ __('Select this page') }}
                  </span>
                  <CircleBadge>
                    {{ currentPageCount }}
                  </CircleBadge>
                </CheckboxWithLabel>
              </li>

              <li class="flex items-center">
                <CheckboxWithLabel
                  :checked="selectAllMatchingChecked"
                  dusk="select-all-matching-button"
                  @input="e => $emit('toggle-select-all-matching', e)"
                >
                  <span>
                    {{ __('Select all') }}
                  </span>
                  <CircleBadge dusk="select-all-matching-count">
                    {{ allMatchingResourceCount }}
                  </CircleBadge>
                </CheckboxWithLabel>
              </li>
            </ul>
          </div>
        </DropdownMenu>
      </template>
    </Dropdown>
  </div>
</template>

<script setup>
import { inject } from 'vue'
import { singularOrPlural } from '@/util'

defineEmits(['toggle-select-all', 'toggle-select-all-matching', 'deselect'])

const selectedResourcesCount = inject('selectedResourcesCount')
const selectAllChecked = inject('selectAllChecked')
const selectAllMatchingChecked = inject('selectAllMatchingChecked')
const selectAllAndSelectAllMatchingChecked = inject(
  'selectAllAndSelectAllMatchingChecked'
)
const selectAllOrSelectAllMatchingChecked = inject(
  'selectAllOrSelectAllMatchingChecked'
)
const selectAllIndeterminate = inject('selectAllIndeterminate')

defineProps({
  currentPageCount: { type: Number, default: 0 },
  allMatchingResourceCount: { type: Number, default: 0 },
})
</script>
