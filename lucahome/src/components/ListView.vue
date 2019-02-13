<template>
  <div>
    <md-list class="md-triple-line">
      <div v-for="(wirelessSocket, index) in wirelessSocketList" :key="index">
        <md-list-item :class="{selected: wirelessSocket.id === selectedWirelessSocket.id, selectable: wirelessSocket.id !== selectedWirelessSocket.id}">
          <md-avatar @click="select(wirelessSocket)">
            <img :src="wirelessSocket.icon">
          </md-avatar>

          <div class="md-list-item-text" @click="select(wirelessSocket)">
            <span>{{wirelessSocket.name}}</span>
            <span>{{wirelessSocket.area}}</span>
            <p>{{wirelessSocket.code}}</p>
          </div>

          <md-button class="md-icon-button md-raised" @click="toggleState(wirelessSocket)">
            <md-icon :class="{'fas fa-toggle-on':wirelessSocket.state,'fas fa-toggle-off':!wirelessSocket.state}"></md-icon>
          </md-button>
        </md-list-item>

        <md-divider class="md-inset"></md-divider>
      </div>
    </md-list>

    <md-button class="md-icon-button md-raised add-button" @click="addWirelessSocket">
      <md-icon class="fas fa-plus-circle"></md-icon>
    </md-button>
  </div>
</template>

<script>
export default {
  name: "ListView",
  methods: {
    select(wirelessSocket) {
      this.$store.dispatch("selectWirelessSocket", wirelessSocket);
    },
    toggleState(wirelessSocket) {
      this.$store.dispatch("toggleWirelessSocketState", wirelessSocket);
    },
    addWirelessSocket() {
      this.$store.dispatch("addWirelessSocket");
    }
  },
  computed: {
    wirelessSocketList() {
      return this.$store.getters.wirelessSocketList;
    },
    selectedWirelessSocket() {
      return this.$store.getters.selectedWirelessSocket;
    }
  }
};
</script>

<style lang="scss" scoped>
.md-list {
  min-width: 20rem;
  width: 20rem;
  max-width: 20rem;
  display: inline-block;
  vertical-align: top;
}

.add-button {
  position: fixed;
  left: 16rem;
  bottom: 1rem;
}
</style>
