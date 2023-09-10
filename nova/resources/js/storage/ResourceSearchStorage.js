export default {
  fetchAvailableResources(resourceName, options) {
    return Nova.request().get(`/nova-api/${resourceName}/search`, options)
  },

  determineIfSoftDeletes(resourceName) {
    return Nova.request().get(`/nova-api/${resourceName}/soft-deletes`)
  },
}
