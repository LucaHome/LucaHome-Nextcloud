<template>
  <div>
    <md-list class="md-triple-line">
      <div v-for="(wirelessSocket, index) in wirelessSocketsForArea" :key="index">
        <md-list-item
          @click="select(wirelessSocket)"
          :class="{selected: wirelessSocket.id === wirelessSocketSelected.id, selectable: wirelessSocket.id !== wirelessSocketSelected.id}"
        >
          <md-avatar>
            <i :class="wirelessSocket.icon"/>
          </md-avatar>

          <div class="md-list-item-text">
            <span>{{ wirelessSocket.name }}</span>
            <span>{{ wirelessSocket.area }}</span>
            <p>{{ wirelessSocket.code }}</p>
          </div>

          <md-button
            v-if="!!wirelessSocket.code"
            class="md-icon-button md-raised"
            @click="toggleState(wirelessSocket)"
          >
            <i
              :class="{'fas fa-toggle-on': wirelessSocket.state == '1', 'fas fa-toggle-off': wirelessSocket.state == '0'}"
            />
          </md-button>
        </md-list-item>

        <md-divider class="md-inset"/>
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
      var wirelessSocketInEdit = this.$store.getters.wirelessSocketInEdit;
      var wirelessSockets = this.$store.getters.wirelessSockets;
      var wirelessSocketSelected = this.$store.getters.wirelessSocketSelected;
      var areaSelected = this.$store.getters.areaSelected;

      var wirelessSocketsForArea =
        areaSelected !== null
          ? areaSelected.filter === ""
            ? wirelessSockets
            : wirelessSockets.filter(x => x.area === areaSelected.filter)
          : [];

      if(!wirelessSocketInEdit && (!wirelessSocketSelected || wirelessSocketsForArea.filter(x => x.id == wirelessSocketSelected.id).length === 0)) {
        this.$store.dispatch("selectWirelessSocket",wirelessSocketsForArea.length === 0 ? null : wirelessSocketsForArea[0]);
      }

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
      this.$store.dispatch("addWirelessSocket",this.$store.getters.areaSelected.name);
    },
    toggleState(wirelessSocket) {
      wirelessSocket.state = wirelessSocket.state === "1" ? "0" : "1";
      this.$store.dispatch("updateWirelessSocket", wirelessSocket);
    }
  }
};
</script>