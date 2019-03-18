<template>
  <app-content app-name="wirelesscontrol">
    <template slot="navigation">
      <AreaListView class="area-list-view" />
    </template>

    <template slot="content">
      <WirelessSocketListView class="wireless-socket-list-view" />
      <WirelessSocketDetailView class="detail-view" v-on:showPeriodicTasks="showPeriodicTasks = true" />
      <PeriodicTaskListView class="periodic-task-list-view" v-if="showPeriodicTasks" v-on:closePeriodicTaskListView="showPeriodicTasks = false" />
    </template>
  </app-content>
</template>

<script>
import { AppContent } from "nextcloud-vue";
import AreaListView from "../components/AreaListView.vue";
import PeriodicTaskListView from "../components/PeriodicTaskListView.vue";
import WirelessSocketDetailView from "../components/WirelessSocketDetailView.vue";
import WirelessSocketListView from "../components/WirelessSocketListView.vue";

export default {
  name: "WirelessControl",

  data: () => ({
    showPeriodicTasks: false
  }),

  components: {
    AppContent,
    AreaListView,
    PeriodicTaskListView,
    WirelessSocketDetailView,
    WirelessSocketListView
  },

  // TODO: Check if we need that
  /*
  // passed by the router
  props: {
    selectedArea: {
      type: String,
      default: undefined,
      required: true
    },
    selectedWirelessSocket: {
      type: String,
      default: undefined
    }
  },
  */

  beforeMount() {
    this.$store.dispatch("loadAreas");
    this.$store.dispatch("loadWirelessSockets");
    this.$store.dispatch("loadPeriodicTasks");
  }
};
</script>
