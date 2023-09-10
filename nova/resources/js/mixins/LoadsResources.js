import { mapProps } from './propTypes'

export default {
  props: mapProps(['resourceName', 'viaRelationship']),

  computed: {
    localStorageKey() {
      let name = this.resourceName

      if (this.viaRelationship) {
        name = `${name}.${this.viaRelationship}`
      }

      return `nova.resources.${name}.collapsed`
    },
  },
}
