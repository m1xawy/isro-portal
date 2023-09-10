<template>
  <div v-if="field.visible" :class="fieldWrapperClasses">
    <div v-if="field.withLabel" :class="labelClasses">
      <slot>
        <FormLabel
          :label-for="labelFor || field.uniqueKey"
          class="space-x-1"
          :class="{ 'mb-2': shouldShowHelpText }"
        >
          <span>
            {{ fieldLabel }}
          </span>
          <span v-if="field.required" class="text-red-500 text-sm">
            {{ __('*') }}
          </span>
        </FormLabel>
      </slot>
    </div>

    <div :class="controlWrapperClasses">
      <slot name="field" />

      <HelpText class="help-text-error" v-if="showErrors && hasError">
        {{ firstError }}
      </HelpText>

      <HelpText
        class="help-text"
        v-if="shouldShowHelpText"
        v-html="field.helpText"
      />
    </div>
  </div>
</template>

<script>
import { HandlesValidationErrors, mapProps } from '@/mixins'

export default {
  mixins: [HandlesValidationErrors],

  props: {
    field: { type: Object, required: true },
    fieldName: { type: String },
    showErrors: { type: Boolean, default: true },
    fullWidthContent: { type: Boolean, default: false },
    labelFor: { default: null },
    ...mapProps(['showHelpText']),
  },

  computed: {
    fieldWrapperClasses() {
      // prettier-ignore
      return [
        'md:flex md:flex-row space-y-2 md:space-y-0',
        this.field.withLabel && !this.field.inline && !this.field.compact && 'py-5',
        this.field.withLabel && !this.field.inline && this.field.compact && 'py-3',
        this.field.stacked && 'md:flex-col md:space-y-2',
      ]
    },

    labelClasses() {
      // prettier-ignore
      return [
        'w-full',
        this.field.stacked && '',
        !this.field.stacked && 'md:mt-2',
        this.field.stacked && !this.field.inline && 'px-6 md:px-8',
        !this.field.stacked && !this.field.inline && 'px-6 md:px-8',
        this.field.compact && '!px-3 md:!px-6',
        !this.field.stacked && !this.field.inline && 'md:w-1/5',
      ]
    },

    controlWrapperClasses() {
      // prettier-ignore
      return [
        'w-full space-y-2',
        this.field.stacked && !this.field.inline && 'px-6 md:px-8',
        !this.field.stacked && !this.field.inline && 'px-6 md:px-8',
        this.field.compact && '!px-3 md:!px-4',
         !this.field.stacked && !this.field.inline && !this.field.fullWidth && 'md:w-3/5',
        this.field.stacked && !this.field.inline && !this.field.fullWidth && 'md:w-3/5',
        !this.field.stacked && !this.field.inline && this.field.fullWidth && 'md:w-4/5',
      ]
    },

    /**
     * Return the label that should be used for the field.
     */
    fieldLabel() {
      // If the field name is purposefully an empty string, then let's show it as such
      if (this.fieldName === '') {
        return ''
      }

      return this.fieldName || this.field.name || this.field.singularLabel
    },

    /**
     * Determine help text should be shown.
     */
    shouldShowHelpText() {
      return this.showHelpText && this.field.helpText?.length > 0
    },
  },
}
</script>
