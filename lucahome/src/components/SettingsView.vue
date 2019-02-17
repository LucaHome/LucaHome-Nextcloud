<template>
  <div id="app-settings" class="reactive">
    <div id="app-settings-header">
      <button class="settings-button" data-apps-slide-toggle="#app-settings-content">
        <span>{{ t('tasks', 'Settings') }}</span>
      </button>
    </div>
    <div id="app-settings-content">
      <ul>
        <li>
          <label for="defaultCalendar">{{ t('tasks', 'Default list') }}</label>
          <select id="defaultCalendar" v-model="defaultCalendarId">
            <option
              v-for="calendar in calendars"
              :key="calendar.id"
              :value="calendar.id"
            >{{ calendar.displayName }}</option>
          </select>
        </li>
        <li class="headline">{{ t('tasks', 'Visibility of Smart Collections') }}</li>
        <li v-for="collection in collections" :key="collection.id">
          <div class="label-container">
            <span :class="collection.icon" class="icon icon-bw">
              <span v-if="collection.id=='today'">{{ dayOfMonth }}</span>
            </span>
            <label
              :for="'visibilityCollection-' + collection.id"
              class="title"
            >{{ collection.displayName }}</label>
          </div>
          <select
            :id="'visibilityCollection-' + collection.id"
            :value="collection.show"
            @change="setVisibility({ id: collection.id, show: +$event.target.value })"
          >
            <option
              v-for="collectionOption in collectionOptions"
              :key="collectionOption.id"
              :value="collectionOption.id"
            >{{ collectionOption.name }}</option>
          </select>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from "vuex";
export default {
  data: function() {
    return {
      collectionOptions: [
        {
          id: 0,
          name: t("tasks", "Hidden")
        },
        {
          id: 1,
          name: t("tasks", "Visible")
        },
        {
          id: 2,
          name: t("tasks", "Automatic")
        }
      ],
      dayOfMonth: moment().date()
    };
  },
  computed: {
    defaultCalendarId: {
      get() {
        var cal = this.$store.getters.getDefaultCalendar;
        return cal ? cal.id : "";
      },
      set(value) {
        this.$store.dispatch("setSetting", {
          type: "defaultCalendarId",
          value: value
        });
      }
    },
    ...mapState({
      collections: state => state.collections.collections
    }),
    ...mapGetters({
      calendars: "getSortedCalendars"
    })
  },
  methods: mapActions(["setVisibility"])
};
</script>