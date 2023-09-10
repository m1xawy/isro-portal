import { Errors } from 'form-backend-validation'

export default {
  props: {
    errors: { default: () => new Errors() },
  },

  inject: { index: { default: null }, viaParent: { default: null } },

  data: () => ({
    errorClass: 'form-input-border-error',
  }),

  computed: {
    errorClasses() {
      return this.hasError ? [this.errorClass] : []
    },

    fieldAttribute() {
      return this.field.attribute
    },

    validationKey() {
      return this.nestedValidationKey || this.field.validationKey
    },

    hasError() {
      return this.errors.has(this.validationKey)
    },

    firstError() {
      if (this.hasError) {
        return this.errors.first(this.validationKey)
      }
    },

    nestedAttribute() {
      if (this.viaParent) {
        return `${this.viaParent}[${this.index}][${this.field.attribute}]`
      }
    },

    nestedValidationKey() {
      if (this.viaParent) {
        return `${this.viaParent}.${this.index}.fields.${this.field.attribute}`
      }
    },
  },
}
