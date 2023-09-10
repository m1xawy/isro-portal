<template>
  <label class="flex items-center select-none space-x-2">
    <Checkbox
      @input="$emit('input', $event)"
      :checked="checked"
      :name="name"
      :disabled="disabled"
    />
    <slot />
  </label>
</template>

<script>
export default {
  emits: ['input'],

  props: {
    checked: Boolean,
    name: { type: String, required: false },
    disabled: {
      type: Boolean,
      default: false,
    },
  },
}
</script>
