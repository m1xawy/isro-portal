<template>
  <div class="flex items-center">
    <Badge class="whitespace-nowrap flex items-center" :class="typeClasses">
      <span class="mr-1 -ml-1">
        <Loader v-if="field.type == 'loading'" width="20" class="mr-1" />
        <Icon
          v-if="field.type == 'failed'"
          :solid="true"
          type="exclamation-circle"
        />
        <Icon
          v-if="field.type == 'success'"
          :solid="true"
          type="check-circle"
        />
      </span>
      {{ fieldValue }}
    </Badge>
  </div>
</template>

<script>
import { FieldValue } from '@/mixins'

export default {
  mixins: [FieldValue],

  props: ['resourceName', 'field'],

  computed: {
    typeClasses() {
      return [
        this.field.textAlign === 'center' && 'mx-auto',
        this.field.textAlign === 'right' && 'ml-auto mr-0',
        this.field.textAlign === 'left' && 'ml-0 mr-auto',
        this.field.typeClass,
      ]
    },
  },
}
</script>
