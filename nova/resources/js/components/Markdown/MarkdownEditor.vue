<template>
  <div
    :dusk="id"
    class="bg-white dark:bg-gray-900 rounded-lg"
    :class="{
      'markdown-fullscreen fixed inset-0 z-50 overflow-x-hidden overflow-y-auto':
        isFullScreen,
      'form-input form-input-bordered px-0 overflow-hidden': !isFullScreen,
      'outline-none ring ring-primary-100 dark:ring-gray-700': isFocused,
    }"
    @dragenter.prevent="handleOnDragEnter"
    @dragleave.prevent="handleOnDragLeave"
    @dragover.prevent
    @drop.prevent="handleOnDrop"
  >
    <header
      class="bg-white dark:bg-gray-900 flex items-center content-center justify-between border-b border-gray-200 dark:border-gray-700"
      :class="{
        'fixed top-0 w-full z-10': isFullScreen,
        'bg-gray-100': readonly,
      }"
    >
      <div class="w-full flex items-center content-center">
        <button
          type="button"
          :class="{ 'text-primary-500 font-bold': visualMode === 'write' }"
          @click.stop="setWriteVisualMode"
          class="ml-1 px-3 h-10 focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600"
        >
          {{ __('Write') }}
        </button>
        <button
          v-if="previewer"
          type="button"
          :class="{ 'text-primary-500 font-bold': visualMode === 'preview' }"
          @click.stop="setPreviewVisualMode"
          class="px-3 h-10 focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600"
        >
          {{ __('Preview') }}
        </button>
      </div>

      <MarkdownEditorToolbar
        v-if="!readonly"
        @action="handleAction"
        dusk="markdown-toolbar"
      />
    </header>

    <div
      v-show="visualMode == 'write'"
      @click="isFocused = true"
      class="dark:bg-gray-900"
      :class="{
        'mt-6': isFullScreen,
        'readonly bg-gray-100': readonly,
      }"
      :dusk="isFullScreen ? `markdown-fullscreen-editor` : `markdown-editor`"
    >
      <div class="p-4">
        <textarea ref="theTextarea" :class="{ 'bg-gray-100': readonly }" />
      </div>
      <label
        v-if="props.uploader"
        @change.prevent="handleFileSelectionClick"
        class="cursor-pointer block bg-gray-100 dark:bg-gray-700 text-gray-400 text-xxs px-2 py-1"
        :class="{ hidden: isFullScreen }"
        :dusk="`${id}-file-picker`"
      >
        <span>{{ statusContent }}</span>
        <input
          ref="fileInput"
          type="file"
          class="hidden"
          accept="image/*"
          :multiple="true"
          @change.prevent="handleFileChange"
        />
      </label>
    </div>

    <div
      v-show="visualMode == 'preview'"
      class="prose prose-sm dark:prose-invert overflow-auto max-w-none p-4"
      :class="{ 'mt-6': isFullScreen }"
      :dusk="
        isFullScreen ? `markdown-fullscreen-previewer` : `markdown-previewer`
      "
      v-html="previewContent"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { useDragAndDrop } from '@/composables/useDragAndDrop'
import { useLocalization } from '@/composables/useLocalization'
import { useMarkdownEditing } from '@/composables/useMarkdownEditing'

const { __ } = useLocalization()

const emit = defineEmits(['initialize', 'change'])

const props = defineProps({
  id: { type: String, required: true },
  readonly: { type: Boolean, default: false },
  previewer: { type: [Object, Function], required: false, default: null },
  uploader: { type: [Object, Function], required: false, default: null },
})

const {
  createMarkdownEditor,
  isFullScreen,
  isFocused,
  isEditable,
  visualMode,
  previewContent,
  statusContent,
} = useMarkdownEditing(emit, props)

let markdown = null
const theTextarea = ref(null)
const fileInput = ref(null)

const handleFileSelectionClick = () => fileInput.value.click()
const handleFileChange = () => {
  if (props.uploader && markdown.actions) {
    const items = fileInput.value.files

    for (let i = 0; i < items.length; i++) {
      markdown.actions.uploadAttachment(items[i])
    }

    fileInput.value.files = null
  }
}

const { startedDrag, handleOnDragEnter, handleOnDragLeave } =
  useDragAndDrop(emit)

const handleOnDrop = e => {
  if (props.uploader && markdown.actions) {
    const items = e.dataTransfer.files

    for (let i = 0; i < items.length; i++) {
      if (items[i].type.indexOf('image') !== -1) {
        markdown.actions.uploadAttachment(items[i])
      }
    }
  }
}

onMounted(() => {
  markdown = createMarkdownEditor(this, theTextarea)

  emit('initialize')
})

onBeforeUnmount(() => markdown.unmount())

const setWriteVisualMode = () => {
  visualMode.value = 'write'
  markdown.actions.refresh()
}

const setPreviewVisualMode = async () => {
  previewContent.value = await props.previewer(markdown.editor.getValue() ?? '')
  visualMode.value = 'preview'
}

const handleAction = action => {
  markdown.actions.handle(this, action)
}

defineExpose({
  setValue(value) {
    if (markdown?.actions) {
      markdown.actions.setValue(value)
    }
  },
  setOption(key, value) {
    if (markdown?.editor) {
      markdown.editor.setOption(key, value)
    }
  },
})
</script>
