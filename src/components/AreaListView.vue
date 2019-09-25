<template>
  <div>
    <md-list class="md-single-line">
      <div v-for="(area, index) in areas" :key="index">
        <md-list-item :class="area | listItemClass">
          <div v-if="!!area.name" class="md-list-item-text" @click="select(area)">
            <span>{{area.name}}</span>
          </div>

          <md-field v-else>
            <label>Name</label>
            <md-input v-model="newAreaName"></md-input>
            <md-button class="md-icon-button save-button md-primary" @click="updateArea(area)">
              <md-icon>save</md-icon>
            </md-button>
          </md-field>

          <md-button v-if="area | canBeDeleted" class="md-icon-button delete-button md-accent" @click="requestDelete(area)">
            <md-icon>delete_forever</md-icon>
          </md-button>
        </md-list-item>

        <md-divider class="md-inset"></md-divider>
      </div>
    </md-list>

    <md-button class="md-icon-button md-raised add-button md-primary" @click="addArea" :disabled="adding">
      <md-icon>add</md-icon>
    </md-button>

    <md-dialog-confirm
      :md-active.sync="deleteAreaDialogActive"
      md-title="Delete?"
      md-content="Do you want to delete this area?"
      md-confirm-text="Yes"
      md-cancel-text="No"
      @md-confirm="onDeleteYes"
    />
  </div>
</template>

<script>
export default {
  name: "AreaListView",
  data: () => ({
    adding: false,
    deleteAreaDialogActive: false,
    newAreaName: undefined,
    selectedDeleteArea: undefined
  }),
  computed: {
    areas() {
      return this.$store.getters.areas;
    },
    areaSelected() {
      return this.$store.getters.areaSelected;
    }
  },
  methods: {
    addArea() {
      if (!this.adding) {
        this.$store.dispatch("addArea");
        this.adding = true;
      }
    },
    onDeleteYes() {
      this.$store.dispatch("deleteArea", this.selectedDeleteArea);
    },
    requestDelete(area) {
      this.selectedDeleteArea = area;
      this.deleteAreaDialogActive = true;
    },
    select(area) {
      if (!this.adding) {
        this.$store.dispatch("selectArea", area);
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
  filters: {
    canBeDeleted: function(area) {
      return area.deletable === 1;
    },
    listItemClass: function(area) {
      return area.id === this.areaSelected.id ? "selected" : "selectable";
    }
  }
};
</script>