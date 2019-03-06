<template>
  <div>
    <md-list class="md-single-line">
      <div v-for="(area, index) in areas" :key="index">
        <md-list-item
          :class="{selected: area.id === areaSelected.id, selectable: area.id !== areaSelected.id}"
        >
          <div v-if="area.name" class="md-list-item-text" @click="select(area)">
            <span>{{area.name}}</span>
          </div>

          <md-field v-else>
            <label>Name</label>
            <md-input v-model="newAreaName"></md-input>
            <md-button class="md-icon-button save-button md-primary" @click="updateArea(area)">
              <md-icon>save</md-icon>
            </md-button>
          </md-field>
        </md-list-item>

        <md-divider class="md-inset"></md-divider>
      </div>
    </md-list>

    <md-button
      class="md-icon-button md-raised add-button md-primary"
      @click="addArea"
      :disabled="adding"
    >
      <md-icon>add</md-icon>
    </md-button>
  </div>
</template>

<script>
export default {
  name: "AreaListView",
  data: () => ({
    newAreaName: null,
    adding: false
  }),
  methods: {
    select(area) {
      if (!this.adding) {
        this.$store.dispatch("selectArea", area);
      }
    },
    addArea() {
      if (!this.adding) {
        this.$store.dispatch("addArea");
        this.adding = true;
      }
    },
    updateArea(area) {
      if (this.newAreaName.length > 0) {
        this.$store.dispatch("updateArea", {
          id: area.id,
          name: this.newAreaName,
          filter: this.newAreaName,
          deletable: area.deletable
        });
        this.newAreaName = "";
        this.adding = false;
      }
    }
  },
  computed: {
    areas() {
      return this.$store.getters.areas;
    },
    areaSelected() {
      return this.$store.getters.areaSelected;
    }
  }
};
</script>