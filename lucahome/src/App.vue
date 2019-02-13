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
  </div>
</template>

<script>
import ListView from "./components/ListView.vue";

export default {
  components: {
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

.list-view {
  min-width: 20rem;
  width: 20rem;
  max-width: 20rem;
  height: 100vh;
  background-color: rgb(66, 66, 66);
  border: 0.0625rem solid rgba(#000, 0.12);
}

.selected {
  background-color: dimgrey;
  cursor: default;
}

.selectable {
  cursor: pointer;
}
</style>