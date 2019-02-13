<template>
  <div>
    <md-list class="md-triple-line">
      <div v-for="(item, index) in items" :key="index">
        <md-list-item :class="{selected:item.selected, selectable:!item.selected}">
          <md-avatar @click="select(item)">
            <img :src="item.icon">
          </md-avatar>

          <div class="md-list-item-text" @click="select(item)">
            <span>{{item.name}}</span>
            <span>{{item.area}}</span>
            <p>{{item.code}}</p>
          </div>

          <md-button class="md-icon-button md-raised" @click="switchState(item)">
            <md-icon :class="{'fas fa-toggle-on':item.state,'fas fa-toggle-off':!item.state}"></md-icon>
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
var exampleData = [
  {
    icon: require("@/assets/wireless_socket_light_on.png"),
    name: "Light Sleeping",
    area: "Sleeping Room",
    code: "11010A",
    state: false,
    selected: false
  },
  {
    icon: require("@/assets/wireless_socket_sound_on.png"),
    name: "Sound TV",
    area: "Living Room",
    code: "11010B",
    state: false,
    selected: false
  },
  {
    icon: require("@/assets/wireless_socket_raspberry_on.png"),
    name: "Raspberry Pi MediaCenter",
    area: "Living Room",
    code: "11010C",
    state: false,
    selected: false
  },
  {
    icon: require("@/assets/wireless_socket_light_on.png"),
    name: "Light Couch",
    area: "Living Room",
    code: "11010D",
    state: true,
    selected: true
  },
  {
    icon: require("@/assets/wireless_socket_storage_off.png"),
    name: "Backup Drive",
    area: "Working Room",
    code: "11010E",
    state: false,
    selected: false
  },
  {
    icon: require("@/assets/wireless_socket_mediamirror_off.png"),
    name: "Media Mirror Kitchen",
    area: "Kitchen",
    code: "11011A",
    state: true,
    selected: false
  },
  {
    icon: require("@/assets/wireless_socket_light_off.png"),
    name: "Light Ceiling",
    area: "Living Room",
    code: "11000A",
    state: false,
    selected: false
  }
];

export default {
  name: "ListView",
  methods: {
    select(item) {
      exampleData.forEach(item => (item.selected = false));
      item.selected = true;
    },
    switchState(item) {
      item.state = !item.state;
    },
    addWirelessSocket() {
      // TODO
      // eslint-disable-next-line
      console.log("Add");
    }
  },
  data: () => ({
    items: exampleData
  })
};
</script>

<style lang="scss" scoped>
.md-list {
  min-width: 20rem;
  width: 20rem;
  max-width: 20rem;
  min-height: 100%;
  height: 100%;
  max-height: 100%;
  display: inline-block;
  vertical-align: top;
  border: 0.0625rem solid rgba(#000, 0.12);
}

.add-button {
  position: absolute;
  left: 16rem;
  bottom: 1rem;
}
</style>
