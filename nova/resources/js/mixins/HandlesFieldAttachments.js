import { Errors } from 'form-backend-validation'
import isNil from 'lodash/isNil'
import { mapProps } from './propTypes'

export default {
  emits: ['file-upload-started', 'file-upload-finished'],

  props: mapProps(['resourceName']),

  async created() {
    if (this.field.withFiles) {
      const {
        data: { draftId },
      } = await Nova.request().get(
        `/nova-api/${this.resourceName}/field-attachment/${this.fieldAttribute}/draftId`
      )

      this.draftId = draftId
    }
  },

  data: () => ({ draftId: null }),

  methods: {
    /**
     * Upload an attachment
     */
    uploadAttachment(file, { onUploadProgress, onCompleted, onFailure }) {
      const data = new FormData()
      data.append('Content-Type', file.type)
      data.append('attachment', file)
      data.append('draftId', this.draftId)

      if (isNil(onUploadProgress)) {
        onUploadProgress = () => {}
      }

      if (isNil(onFailure)) {
        onFailure = () => {}
      }

      if (isNil(onCompleted)) {
        throw 'Missing onCompleted parameter'
      }

      this.$emit('file-upload-started')

      Nova.request()
        .post(
          `/nova-api/${this.resourceName}/field-attachment/${this.fieldAttribute}`,
          data,
          { onUploadProgress }
        )
        .then(({ data: { url } }) => {
          const response = onCompleted(url)

          this.$emit('file-upload-finished')

          return response
        })
        .catch(error => {
          onFailure(error)

          if (error.response.status == 422) {
            const validationErrors = new Errors(error.response.data.errors)

            Nova.error(
              this.__('An error occurred while uploading the file: :error', {
                error: validationErrors.first('attachment'),
              })
            )
          } else {
            Nova.error(this.__('An error occurred while uploading the file.'))
          }
        })
    },

    /**
     * Remove an attachment from the server
     */
    removeAttachment(attachmentUrl) {
      Nova.request()
        .delete(
          `/nova-api/${this.resourceName}/field-attachment/${this.fieldAttribute}`,
          { params: { attachmentUrl } }
        )
        .then(response => {})
        .catch(error => {})
    },

    /**
     * Purge pending attachments for the draft
     */
    clearAttachments() {
      if (this.field.withFiles) {
        Nova.request()
          .delete(
            `/nova-api/${this.resourceName}/field-attachment/${this.fieldAttribute}/${this.draftId}`
          )
          .then(response => {})
          .catch(error => {})
      }
    },

    /**
     * Fill draft id for the field
     */
    fillAttachmentDraftId(formData) {
      let attribute = this.fieldAttribute

      let [name, ...nested] = attribute.split('[')

      if (!isNil(nested) && nested.length > 0) {
        let last = nested.pop()

        if (nested.length > 0) {
          attribute = `${name}[${nested.join('[')}[${last.slice(0, -1)}DraftId]`
        } else {
          attribute = `${name}[${last.slice(0, -1)}DraftId]`
        }
      } else {
        attribute = `${attribute}DraftId`
      }

      this.fillIfVisible(formData, attribute, this.draftId)
    },
  },
}
