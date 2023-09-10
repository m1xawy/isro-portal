export default {
  fetchAvailableResources(resourceName, fieldAttribute, options) {
    return Nova.request().get(`/nova-api/${resourceName}/associatable/${fieldAttribute}`, options)
  },

  determineIfSoftDeletes(resourceName) {
    return Nova.request().get(`/nova-api/${resourceName}/soft-deletes`)
  },
}
