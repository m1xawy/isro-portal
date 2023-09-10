<script>
import { DateTime } from 'luxon'
import DateField from '@/fields/Filter/DateField'

export default {
  extends: DateField,

  methods: {
    fromDateTimeISO(value) {
      return DateTime.fromISO(value, {
        setZone: true,
      }).setZone(this.timezone)
    },

    toDateTimeISO(value, range) {
      let isoDate = DateTime.fromISO(value, {
        zone: this.timezone,
        setZone: true,
      })

      if (range === 'end') {
        isoDate = isoDate.endOf('day')
      } else {
        isoDate = isoDate.startOf('day')
      }

      return isoDate.setZone(Nova.config('timezone')).toISO()
    },
  },

  computed: {
    timezone() {
      return Nova.config('userTimezone') || Nova.config('timezone')
    },
  },
}
</script>
