<template>
  <div>
    <md-list class="md-single-line">
      <div v-for="(area, index) in areaList" :key="index">
        <md-list-item
          :class="{selected: area.id === selectedArea.id, selectable: area.id !== selectedArea.id}"
        >
          <div v-if="area.name" class="md-list-item-text" @click="select(area)">
            <span>{{area.name}}</span>
          </div>

          <md-field v-else>
            <label>Name</label>
            <md-input v-model="newAreaName"></md-input>
            <md-button class="md-icon-button save-button md-primary" @click="saveArea">
              <md-icon>save</md-icon>
            </md-button>
          </md-field>
        </md-list-item>

        <md-divider class="md-inset"></md-divider>
      </div>
    </md-list>

    <md-button class="md-icon-button md-raised add-button md-primary" @click="addArea">
      <md-icon>add</md-icon>
    </md-button>
  </div>
</template>

<script>
export default {
  name: "AreaListView",
  data: () => ({
    newAreaName: null
  }),
  methods: {
    select(area) {
      this.$store.dispatch("selectArea", area);
    },
    addArea() {
      this.$store.dispatch("addArea");
    },
    saveArea() {
      if (this.newAreaName.length > 0) {
        this.$store.dispatch("saveArea", {
          id: this.$store.getters.selectedArea.id,
          name: this.newAreaName,
          filter: this.newAreaName
        });
      }
    }
  },
  computed: {
    areaList() {
      return this.$store.getters.areaList;
    },
    selectedArea() {
      return this.$store.getters.selectedArea;
    }
  }
};
</script>