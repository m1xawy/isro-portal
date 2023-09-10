<template>
  <div :class="alignmentClass" class="flex">
    <audio
      v-if="hasPreviewableAudio"
      v-bind="defaultAttributes"
      class="rounded rounded-full"
      :src="field.previewUrl"
      controls
      controlslist="nodownload"
    />

    <p v-else :class="`text-${field.textAlign}`">&mdash;</p>
  </div>
</template>

<script>
import isNil from 'lodash/isNil'
import { FieldValue } from '@/mixins'

export default {
  mixins: [FieldValue],

  props: ['viaResource', 'viaResourceId', 'resourceName', 'field'],

  computed: {
    hasPreviewableAudio() {
      return !isNil(this.field.previewUrl)
    },

    defaultAttributes() {
      return {
        autoplay: false,
        preload: this.field.preload,
      }
    },

    alignmentClass() {
      return {
        left: 'items-center justify-start',
        center: 'items-center justify-center',
        right: 'items-center justify-end',
      }[this.field.textAlign]
    },
  },
}
</script>
