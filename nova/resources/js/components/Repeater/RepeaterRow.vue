<template>
  <div
    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded divide-y divide-gray-200 dark:divide-gray-700"
  >
    <div
      class="flex items-center bg-gray-50 dark:bg-gray-800 py-2 px-3 rounded-t"
    >
      <div class="flex items-center space-x-2">
        <IconButton
          v-if="sortable"
          @click="$emit('move-up', index)"
          iconType="arrow-up"
          solid
          small
        />
        <IconButton
          v-if="sortable"
          @click="$emit('move-down', index)"
          iconType="arrow-down"
          solid
          small
        />
      </div>

      <IconButton
        @click.stop.prevent="beforeRemove"
        class="ml-auto"
        iconType="trash"
        solid
        small
      />
    </div>

    <div
      class="grid grid-cols-full divide-y divide-gray-100 dark:divide-gray-700"
    >
      <div v-for="(field, fieldIndex) in item.fields">
        <component
          :ref="fieldRefs[`fields.${field.attribute}`]"
          :is="'form-' + field.component"
          :field="field"
          :index="index"
          :errors="errors"
          :show-help-text="true"
          @file-deleted="$emit('file-deleted')"
          :nested="true"
          :resource-name="resourceName"
          :resource-id="resourceId"
          :shown-via-new-relation-modal="shownViaNewRelationModal"
          :via-resource="viaResource"
          :via-resource-id="viaResourceId"
          :via-relationship="viaRelationship"
        />
        <!--        :related-resource-name="relatedResourceName"-->
        <!--        :related-resource-id="relatedResourceId"-->
        <!--        syncEndpoint,-->
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, provide, computed, inject } from 'vue'
import fromPairs from 'lodash/fromPairs'
import first from 'lodash/first'
const emit = defineEmits(['click', 'move-up', 'move-down', 'file-deleted'])

const props = defineProps({
  field: { type: Object, required: true },
  index: { type: Number, required: true },
  item: { type: Object, required: true },
  errors: { type: Object, required: true },
  sortable: { type: Boolean, required: false },
  viaParent: { type: String },
})

provide(
  'viaParent',
  computed(() => props.viaParent)
)
provide(
  'index',
  computed(() => props.index)
)

const fieldKeys = props.item.fields.map(f => f.attribute)
const fieldRefs = fromPairs(fieldKeys.map(k => [`fields.${k}`, ref(null)]))

const resourceName = inject('resourceName')
const resourceId = inject('resourceId')
const shownViaNewRelationModal = inject('shownViaNewRelationModal')
const viaResource = inject('viaResource')
const viaResourceId = inject('viaResourceId')
const viaRelationship = inject('viaRelationship')

const beforeRemove = () =>
  props.item.confirmBeforeRemoval
    ? confirm('Are you sure you want to remove this block?')
      ? remove()
      : null
    : remove()

const remove = () =>
  Object.keys(fieldRefs).forEach(async k => {
    // await fieldRefs[k]?.value[0]?.beforeRemove?()
    emit('click', props.index)
  })
</script>
