export default {
  data: () => ({ collapsed: false }),

  created() {
    const value = localStorage.getItem(this.localStorageKey)

    if (value !== 'undefined') {
      this.collapsed = JSON.parse(value) ?? this.collapsedByDefault
    }
  },

  unmounted() {
    localStorage.setItem(this.localStorageKey, this.collapsed)
  },

  methods: {
    toggleCollapse() {
      this.collapsed = !this.collapsed
      localStorage.setItem(this.localStorageKey, this.collapsed)
    },
  },

  computed: {
    ariaExpanded() {
      return this.collapsed === false ? 'true' : 'false'
    },

    shouldBeCollapsed() {
      return this.collapsed
    },

    localStorageKey() {
      return `nova.navigation.${this.item.key}.collapsed`
    },

    collapsedByDefault() {
      return false
    },
  },
}
