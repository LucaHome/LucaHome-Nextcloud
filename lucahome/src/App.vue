<template>
  <div id="app">
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

    <AreaListView class="area-list-view"></AreaListView>
    <WirelessSocketListView class="wireless-socket-list-view"></WirelessSocketListView>
    <WirelessSocketDetailView class="detail-view"></WirelessSocketDetailView>
  </div>
</template>

<script>
import AreaListView from "./components/AreaListView.vue";
import WirelessSocketDetailView from "./components/WirelessSocketDetailView.vue";
import WirelessSocketListView from "./components/WirelessSocketListView.vue";

export default {
  name: "App",
  components: {
    AreaListView,
    WirelessSocketDetailView,
    WirelessSocketListView
  }
};
</script>
<style lang="scss">
@import "../css/lucahome";
</style>
