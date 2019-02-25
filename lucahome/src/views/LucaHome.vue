<template>
  <app-content app-name="lucahome">
    <link
      rel="stylesheet"
      href="//fonts.googleapis.com/css?family=Roboto:400,500,700,400italic|Material+Icons"
    >
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
      integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
      crossorigin="anonymous"
    >

    <template slot="navigation">
      <AreaListView class="area-list-view"/>
      <WirelessSocketListView class="wireless-socket-list-view"/>
    </template>

    <template slot="content">
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
