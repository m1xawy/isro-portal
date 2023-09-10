<template>
  <div
    class="bg-gray-200 dark:bg-gray-900 w-full overflow-hidden h-4 flex rounded-full"
    :title="title"
  >
    <div :class="color" :style="`width:${value}%`" />
  </div>
</template>

<script setup>
const props = defineProps({
  title: { type: String, required: true },
  color: { type: String, required: true },
  value: { type: [String, Number], required: true },
})
</script>
