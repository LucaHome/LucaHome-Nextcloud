<template>
  <md-bottom-bar class="md-accent centered" md-type="shift" @md-changed="reloadList">
    <md-bottom-bar-item id="list" @click="showList">
      <md-icon class="fas fa-list-ul"></md-icon>
      <span class="md-bottom-bar-label">List</span>
    </md-bottom-bar-item>

    <md-bottom-bar-item id="edit" @click="showEdit">
      <md-icon class="fas fa-edit"></md-icon>
      <span class="md-bottom-bar-label">Edit</span>
    </md-bottom-bar-item>
  </md-bottom-bar>
</template>

<script>
export default {
  name: "BottomBar",
  data: () => ({
    checkInterval: null
  }),
  methods: {
    showList() {
      this.clearReload();
      this.$store.dispatch("changeView", "list");
    },
    showEdit() {
      this.clearReload();
      this.$store.dispatch("changeView", "edit");
    },
    clearReload() {
      window.clearInterval(this.checkInterval);
      this.checkInterval = null;
    },
    reloadList() {
      if (!this.checkInterval) {
        this.checkInterval = window.setInterval(() => {
          // TODO
        }, 1000);
      }
    }
  },
  mounted() {
    this.reloadList();
  }
};
</script>
