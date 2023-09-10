<template>
  <div>
    <div :class="`text-${field.textAlign}`">
      <span v-if="fieldHasValue" class="whitespace-nowrap">
        {{ formattedDate }}
      </span>
      <span v-else>&mdash;</span>
    </div>
  </div>
</template>

<script>
import { DateTime } from 'luxon'
import { FieldValue } from '@/mixins'

export default {
  mixins: [FieldValue],

  props: ['resourceName', 'field'],

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
