<template>
  <div class="flex items-center">
    <button
      :key="tool.action"
      @click.prevent="handleAction(tool.action)"
      v-for="tool in tools"
      class="rounded-none w-10 h-10 ico-button inline-flex items-center justify-center px-2 text-sm border-l border-gray-200 dark:border-gray-700 focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600"
    >
      <component :is="tool.icon" :dusk="tool.action" class="w-4 h-4" />
    </button>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const emit = defineEmits(['action'])

const tools = computed(() => [
  {
    name: 'bold',
    action: 'bold',
    icon: 'icon-bold',
  },
  {
    name: 'italicize',
    action: 'italicize',
    icon: 'icon-italic',
  },
  {
    name: 'link',
    action: 'link',
    icon: 'icon-link',
  },
  {
    name: 'image',
    action: 'image',
    icon: 'icon-image',
  },
  {
    name: 'fullScreen',
    action: 'toggleFullScreen',
    icon: 'icon-full-screen',
  },
])

const handleAction = action => emit('action', action)
</script>
