import forEach from 'lodash/forEach'
import { Inertia } from '@inertiajs/inertia'
import filled from '../util/filled'

let compiledSearchParams = null

export default {
  created() {
    let searchParams = new URLSearchParams(window.location.search)

    compiledSearchParams = searchParams.toString()
  },

  beforeUnmount() {
    compiledSearchParams = null
  },

  methods: {
    /**
     * Update the given query string values.
     */
    updateQueryString(value) {
      let searchParams = new URLSearchParams(window.location.search)
      let page = Inertia.page

      forEach(value, (v, i) => {
        if (!filled(v)) {
          searchParams.delete(i)
        } else {
          searchParams.set(i, v || '')
        }
      })

      if (compiledSearchParams !== searchParams.toString()) {
        if (page.url !== `${window.location.pathname}?${searchParams}`) {
          page.url = `${window.location.pathname}?${searchParams}`

          window.history.pushState(
            page,
            '',
            `${window.location.pathname}?${searchParams}`
          )
        }

        compiledSearchParams = searchParams.toString()
      }

      Nova.$emit('query-string-changed', searchParams)

      return new Promise((resolve, reject) => {
        resolve(searchParams)
      })
    },
  },
}
