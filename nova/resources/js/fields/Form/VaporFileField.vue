<script>
import FileField from '@/fields/Form/FileField'

export default {
  extends: FileField,

  computed: {
    /**
     * Determining if the field is a Vapor field.
     */
    isVaporField() {
      return true
    },
  },
}
</script>
