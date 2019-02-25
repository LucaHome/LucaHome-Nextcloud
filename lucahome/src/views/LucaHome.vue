<template>
  <app-content app-name="lucahome">
    <template slot="navigation">
      <AreaListView class="area-list-view"/>
    </template>

    <template slot="content">
      <WirelessSocketListView class="wireless-socket-list-view"/>
      <WirelessSocketDetailView class="detail-view"/>
    </template>
  </app-content>
</template>

<script>
import { AppContent } from "nextcloud-vue";
import AreaListView from "../components/AreaListView.vue";
import WirelessSocketDetailView from "../components/WirelessSocketDetailView.vue";
import WirelessSocketListView from "../components/WirelessSocketListView.vue";

export default {
  name: "LucaHome",

  components: {
    AppContent,
    AreaListView,
    WirelessSocketDetailView,
    WirelessSocketListView
  },

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

  beforeMount() {
    this.$store.dispatch("loadAreas");
    this.$store.dispatch("loadWirelessSockets");
  }
};
</script>
