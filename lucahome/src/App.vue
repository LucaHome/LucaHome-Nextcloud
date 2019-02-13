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

    <ListView class="list-view"></ListView>
    <BottomBar class="bottom-bar"></BottomBar>
  </div>
</template>

<script>
import BottomBar from "./components/BottomBar.vue";
import ListView from "./components/ListView.vue";

export default {
  components: {
    BottomBar,
    ListView
  }
};
</script>

<style lang="scss">
@import "~vue-material/dist/theme/engine";
@import "~vue-material/dist/theme/all";

body {
  font-family: Helvetica, sans-serif;
}

.bottom-bar {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
}

.list-view {
  height: calc(100vh - 3.5rem);
}

.selected {
  background-color: dimgrey;
  cursor: default;
}

.selectable {
  cursor: pointer;
}
</style>