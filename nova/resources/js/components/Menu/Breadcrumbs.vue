<template>
  <nav
    v-if="hasItems"
    class="text-gray-500 font-semibold"
    aria-label="breadcrumb"
  >
    <ol>
      <li
        v-for="(item, index) in breadcrumbs"
        class="inline-block"
        v-bind="{
          'aria-current': index === breadcrumbs.length - 1 ? 'page' : null,
        }"
      >
        <div class="flex items-center">
          <Link
            :href="$url(item.path)"
            v-if="item.path !== null && index < breadcrumbs.length - 1"
            class="link-default"
          >
            {{ item.name }}
          </Link>
          <span v-else>{{ item.name }}</span>
          <Icon
            type="chevron-right"
            v-if="index < breadcrumbs.length - 1"
            class="w-4 h-4 mx-2 text-gray-300 dark:text-gray-700"
          />
        </div>
      </li>
    </ol>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters(['breadcrumbs']),

    hasItems() {
      return this.breadcrumbs.length > 0
    },
  },
}
</script>
