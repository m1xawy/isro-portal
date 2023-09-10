<template>
  <div :class="`text-${field.textAlign}`">
    <p v-if="fieldHasValue" class="flex items-center">
      <a
        v-if="fieldHasValue"
        @click.stop
        :href="`mailto:${field.value}`"
        class="link-default whitespace-nowrap"
      >
        {{ fieldValue }}
      </a>

      <CopyButton
        v-if="fieldHasValue && field.copyable && !shouldDisplayAsHtml"
        @click.prevent.stop="copy"
        v-tooltip="__('Copy to clipboard')"
        class="mx-0"
      />
    </p>
    <p v-else>&mdash;</p>
  </div>
</template>

<script>
import { CopiesToClipboard, FieldValue } from '@/mixins'

export default {
  mixins: [CopiesToClipboard, FieldValue],

  props: ['resourceName', 'field'],

  methods: {
    copy() {
      this.copyValueToClipboard(this.field.value)
    },
  },
}
</script>
