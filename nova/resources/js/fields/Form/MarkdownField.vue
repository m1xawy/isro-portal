<template>
  <DefaultField
    :field="currentField"
    :errors="errors"
    :full-width-content="fullWidthContent"
    :show-help-text="showHelpText"
  >
    <template #field>
      <MarkdownEditor
        ref="theMarkdownEditor"
        v-show="currentlyIsVisible"
        :class="{ 'form-input-border-error': hasError }"
        :id="field.attribute"
        :previewer="previewer"
        :uploader="uploader"
        :readonly="currentlyIsReadonly"
        @initialize="initialize"
        @change="handleChange"
      />
    </template>
  </DefaultField>
</template>

<script>
import isNil from 'lodash/isNil'
import {
  DependentFormField,
  HandlesFieldAttachments,
  HandlesValidationErrors,
  mapProps,
} from '@/mixins'

export default {
  mixins: [
    HandlesValidationErrors,
    HandlesFieldAttachments,
    DependentFormField,
  ],

  props: mapProps(['resourceName', 'resourceId', 'mode']),

  beforeUnmount() {
    Nova.$off(this.fieldAttributeValueEventName, this.listenToValueChanges)
  },

  methods: {
    initialize() {
      this.$refs.theMarkdownEditor.setValue(
        this.value ?? this.currentField.value
      )

      Nova.$on(this.fieldAttributeValueEventName, this.listenToValueChanges)
    },

    fill(formData) {
      this.fillIfVisible(formData, this.fieldAttribute, this.value || '')

      this.fillAttachmentDraftId(formData)
    },

    handleChange(value) {
      this.value = value

      if (this.field) {
        this.emitFieldValueChange(this.fieldAttribute, this.value)
      }
    },

    onSyncedField() {
      if (this.currentlyIsVisible && this.$refs.theMarkdownEditor) {
        this.$refs.theMarkdownEditor.setValue(
          this.currentField.value ?? this.value
        )
        this.$refs.theMarkdownEditor.setOption(
          'readOnly',
          this.currentlyIsReadonly
        )
      }
    },

    listenToValueChanges(value) {
      if (this.currentlyIsVisible) {
        this.$refs.theMarkdownEditor.setValue(value)
      }

      this.handleChange(value)
    },

    async fetchPreviewContent(value) {
      Nova.$progress.start()

      const {
        data: { preview },
      } = await Nova.request().post(
        `/nova-api/${this.resourceName}/field/${this.fieldAttribute}/preview`,
        { value },
        {
          params: {
            editing: true,
            editMode: isNil(this.resourceId) ? 'create' : 'update',
          },
        }
      )

      Nova.$progress.done()

      return preview
    },
  },

  computed: {
    previewer() {
      if (!this.isActionRequest) {
        return this.fetchPreviewContent
      }
    },

    uploader() {
      if (!this.isActionRequest && this.field.withFiles) {
        return this.uploadAttachment
      }
    },
  },
}
</script>
