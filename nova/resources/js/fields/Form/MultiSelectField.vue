<template>
  <DefaultField
    :field="currentField"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <!-- Select Input Field -->
      <MultiSelectControl
        :id="currentField.uniqueKey"
        :dusk="field.attribute"
        v-model:selected="value"
        @change="handleChange"
        class="w-full"
        :class="errorClasses"
        :options="currentField.options"
        :disabled="currentlyIsReadonly"
      >
        <option
          v-if="shouldShowPlaceholder"
          value=""
          :selected="!hasValue"
          :disabled="!currentField.nullable"
        >
          {{ placeholder }}
        </option>
      </MultiSelectControl>
    </template>
  </DefaultField>
</template>

<script>
import filter from 'lodash/filter'
import map from 'lodash/map'
import merge from 'lodash/merge'
import { DependentFormField, HandlesValidationErrors } from '@/mixins'
import filled from '@/util/filled'

export default {
  mixins: [HandlesValidationErrors, DependentFormField],

  data: () => ({
    value: [],
    search: '',
  }),

  methods: {
    /*
     * Set the initial value for the field
     */
    setInitialValue() {
      let values = !(
        this.currentField.value === undefined ||
        this.currentField.value === null ||
        this.currentField.value === ''
      )
        ? merge(this.currentField.value || [], this.value)
        : this.value

      let selectedOptions = filter(
        this.currentField.options ?? [],
        v => values.indexOf(v.value) >= 0
      )

      this.value = map(selectedOptions, o => o.value)
    },

    /**
     * Provide a function that fills a passed FormData object with the
     * field's internal value attribute. Here we are forcing there to be a
     * value sent to the server instead of the default behavior of
     * `this.value || ''` to avoid loose-comparison issues if the keys
     * are truthy or falsey
     */
    fill(formData) {
      this.fillIfVisible(
        formData,
        this.fieldAttribute,
        JSON.stringify(this.value)
      )
    },

    /**
     * Set the search string to be used to filter the select field.
     */
    performSearch(event) {
      this.search = event
    },

    /**
     * Handle the selection change event.
     */
    handleChange(value) {
      this.value = value

      if (this.field) {
        this.emitFieldValueChange(this.fieldAttribute, this.value)
      }
    },

    onSyncedField() {
      this.setInitialValue()
    },
  },

  computed: {
    /**
     * Return the field options filtered by the search string.
     */
    filteredOptions() {
      let options = this.currentField.options || []

      return options.filter(option => {
        return (
          option.label.toLowerCase().indexOf(this.search.toLowerCase()) > -1
        )
      })
    },

    /**
     * Return the placeholder text for the field.
     */
    placeholder() {
      return this.currentField.placeholder || this.__('Choose an option')
    },

    /**
     * Return value has been setted.
     */
    hasValue() {
      return Boolean(
        !(this.value === undefined || this.value === null || this.value === '')
      )
    },

    shouldShowPlaceholder() {
      return filled(this.currentField.placeholder) || this.currentField.nullable
    },
  },
}
</script>
