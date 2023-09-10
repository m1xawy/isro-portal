<template>
  <div>
    <CheckboxWithLabel
      v-bind="{ ...$attrs }"
      :dusk="`${resourceName}-with-trashed-checkbox`"
      :checked="withTrashed"
      @input="toggleWithTrashed"
    >
      <span>{{ __('With Trashed') }}</span>
    </CheckboxWithLabel>
  </div>
</template>

<script>
export default {
  emits: ['input'],

  inheritAttrs: false,

  props: {
    resourceName: String,
    withTrashed: Boolean,
  },

  methods: {
    toggleWithTrashed() {
      this.$emit('input')
    },
  },
}
</script>
