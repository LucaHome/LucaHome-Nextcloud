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
  components: {
    AreaListView,
    WirelessSocketDetailView,
    WirelessSocketListView
  }
};
</script>

<style lang="scss">
@import "~vue-material/dist/theme/engine";
@import "~vue-material/dist/theme/all";

body {
  font-family: Helvetica, sans-serif;
}

.area-list-view {
  position: absolute;
  min-width: 15rem;
  width: 15rem;
  max-width: 15rem;
  height: 100vh;
  background-color: rgb(66, 66, 66);
  border: 0.0625rem solid rgba(#000, 0.12);
}

.wireless-socket-list-view {
  position: absolute;
  min-width: 20rem;
  width: 20rem;
  max-width: 20rem;
  height: 100vh;
  background-color: rgb(66, 66, 66);
  border: 0.0625rem solid rgba(#000, 0.12);
  left: 15.5rem;
}

.detail-view {
  position: absolute;
  height: 100vh;
  width: calc(100vw - 36rem);
  background-color: rgb(66, 66, 66);
  left: 36rem;
  top: 0;
}

.selected {
  background-color: dimgrey;
  cursor: default;
}

.selectable {
  cursor: pointer;
}
</style>