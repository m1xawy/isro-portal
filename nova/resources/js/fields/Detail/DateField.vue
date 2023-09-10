<template>
  <PanelItem :index="index" :field="field">
    <template #value>
      <p v-if="fieldHasValue || usesCustomizedDisplay" :title="field.value">
        {{ formattedDate }}
      </p>
      <p v-else>&mdash;</p>
    </template>
  </PanelItem>
</template>

<script>
import { DateTime } from 'luxon'
import { FieldValue } from '@/mixins'

export default {
  mixins: [FieldValue],

  props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],

  computed: {
    formattedDate() {
      if (this.field.usesCustomizedDisplay) {
        return this.field.displayedAs
      }

      let isoDate = DateTime.fromISO(this.field.value)

      return isoDate.toLocaleString({
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
      })
    },
  },
}
</script>
