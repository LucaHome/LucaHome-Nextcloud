<template>
  <div>
    <md-list class="md-triple-line">
      <div v-for="(wirelessSocket, index) in wirelessSocketsForArea" :key="index">
        <md-list-item
          :class="{selected: wirelessSocket.id === wirelessSocketSelected.id, selectable: wirelessSocket.id !== wirelessSocketSelected.id}"
        >
          <md-avatar @click="select(wirelessSocket)">
            <md-icon :class="wirelessSocket.icon" />
          </md-avatar>

          <div class="md-list-item-text" @click="select(wirelessSocket)">
            <span>{{ wirelessSocket.name }}</span>
            <span>{{ wirelessSocket.area }}</span>
            <p>{{ wirelessSocket.code }}</p>
          </div>

          <md-button class="md-icon-button md-raised" @click="toggleState(wirelessSocket)">
            <md-icon :class="{'fas fa-toggle-on':wirelessSocket.state,'fas fa-toggle-off':!wirelessSocket.state}" />
          </md-button>
        </md-list-item>

        <md-divider class="md-inset" />
      </div>
    </md-list>

    <md-button class="md-icon-button md-raised add-button md-primary" @click="addWirelessSocket">
      <md-icon>add</md-icon>
    </md-button>
  </div>
</template>

<script>
export default {
  name: "WirelessSocketListView",
  computed: {
    wirelessSocketsForArea() {
      var wirelessSockets = this.$store.getters.wirelessSockets;
      var areaSelected = this.$store.getters.areaSelected;

      var wirelessSocketsForArea =
        areaSelected !== null
          ? areaSelected.filter === ""
            ? wirelessSockets
            : wirelessSockets.filter(x => x.area === areaSelected.filter)
          : [];

      this.$store.dispatch(
        "selectWirelessSocket",
        wirelessSocketsForArea.length === 0 ? null : wirelessSocketsForArea[0]
      );

      return wirelessSocketsForArea;
    },
    wirelessSocketSelected() {
      return this.$store.getters.wirelessSocketSelected;
    }
  },
  methods: {
    select(wirelessSocket) {
      this.$store.dispatch("selectWirelessSocket", wirelessSocket);
    },
    addWirelessSocket() {
      this.$store.dispatch(
        "addWirelessSocket",
        this.$store.getters.areaSelected.name
      );
    },
    toggleState(wirelessSocket) {
      wirelessSocket.state = wirelessSocket.state === 1 ? 0 : 1;
      this.$store.dispatch("updateWirelessSocket", wirelessSocket);
    }
  }
};
</script>