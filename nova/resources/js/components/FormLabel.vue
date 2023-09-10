<template>
  <label :for="labelFor" class="inline-block leading-tight">
    <slot />
  </label>
</template>

<script>
export default {
  props: {
    labelFor: {
      type: String,
    },
  },
}
</script>
