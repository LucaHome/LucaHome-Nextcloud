<template>
  <div v-if="wirelessSocketSelected">
    <form novalidate class="md-layout" style="margin: 1rem;" @submit.prevent="validate">
      <md-card class="md-layout-item md-size-95 md-small-size-100">
        <md-card-header>
          <div class="md-title">WirelessSocket Data</div>
        </md-card-header>

        <md-card-content>
          <div>
            <div class="md-layout md-gutter">
              <div class="md-layout-item md-small-size-100">
                <md-field :class="getValidationClass('name')">
                  <label for="name">Name</label>
                  <md-input name="name" id="name" v-model="form.name" :disabled="sending" />
                  <span class="md-error" v-if="!$v.form.name.required">The name is required</span>
                  <span class="md-error" v-else-if="!$v.form.name.minlength">Invalid name length</span>
                </md-field>
              </div>

              <div class="md-layout-item md-small-size-100">
                <md-field :class="getValidationClass('code')">
                  <label for="code">Code</label>
                  <md-input name="code" id="code" v-model="form.code" :disabled="sending" />
                  <span class="md-error" v-if="!$v.form.code.required">The code is required</span>
                  <span class="md-error" v-else-if="!$v.form.code.minlength">Invalid code length (too short)</span>
                  <span class="md-error" v-else-if="!$v.form.code.maxlength">Invalid code length (too long)</span>
                </md-field>
              </div>

              <div class="md-layout-item md-small-size-100">
                <md-field :class="getValidationClass('area')">
                  <label for="area">Area</label>
                  <md-input name="area" id="area" v-model="form.area" :disabled="sending" />
                  <span class="md-error" v-if="!$v.form.area.required">The area is required</span>
                  <span class="md-error" v-else-if="!$v.form.area.minlength">Invalid area length</span>
                </md-field>
              </div>

              <div class="md-layout-item md-small-size-100">
                <md-field :class="getValidationClass('group')">
                  <label for="group">Group</label>
                  <md-input name="group" id="group" v-model="form.group" :disabled="sending" />
                  <span class="md-error" v-if="!$v.form.group.required">The group is required</span>
                  <span class="md-error" v-else-if="!$v.form.group.minlength">Invalid group length</span>
                </md-field>
              </div>
            </div>

            <div class="md-layout-item md-small-size-100">
              <md-field>
                <label for="description">Description</label>
                <md-input name="description" id="description" v-model="form.description" :disabled="sending"/>
              </md-field>
            </div>

            <div class="md-layout-item md-small-size-100">
              <md-field>
                <label for="icon">Icon</label>
                <md-input name="icon" id="icon" v-model="form.icon" :disabled="sending"/>
                <i :class="form.icon" />
              </md-field>
              <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_">Get Icons from here</a>
            </div>

            <div class="md-layout-item md-small-size-100">
              <md-field>
                <label for="lastToggled">Last toggled</label>
                <md-input name="lastToggled" id="lastToggled" v-model="form.lastToggled" :disabled="true"/>
              </md-field>
            </div>
          </div>
        </md-card-content>

        <md-progress-bar md-mode="indeterminate" v-if="sending" />

        <md-card-actions>
          <md-button class="md-primary" @click="showPeriodicTasks()">Periodic Tasks</md-button>
        </md-card-actions>

        <md-card-actions>
          <md-button type="submit" class="md-primary" :disabled="sending || !hasChanges()">Save wireless socket</md-button>
        </md-card-actions>

        <md-card-actions v-if="wirelessSocketSelected | canBeDeleted">
          <md-button class="md-accent" :disabled="sending || hasChanges()" @click="deleteWirelessSocketDialogActive = true">Delete wireless socket</md-button>
        </md-card-actions>
      </md-card>

      <md-snackbar :md-active.sync="saved">The wireless socket was saved with success!</md-snackbar>
    </form>

    <md-dialog-confirm
      :md-active.sync="deleteWirelessSocketDialogActive"
      md-title="Delete?"
      md-content="Do you want to delete this wireless socket?"
      md-confirm-text="Yes"
      md-cancel-text="No"
      @md-confirm="onDeleteYes"
    />
  </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required, minLength, maxLength } from "vuelidate/lib/validators";

export default {
  name: "WirelessSocketDetailView",
  mixins: [validationMixin],
  data: () => ({
    form: {
      name: undefined,
      code: undefined,
      area: undefined,
      group: undefined,
      lastToggled: undefined,
      state: false,
      description: undefined,
      icon: undefined
    },
    saved: false,
    sending: false,
    deleteWirelessSocketDialogActive: false
  }),
  validations: {
    form: {
      name: {
        required,
        minLength: minLength(3),
        maxLength: maxLength(128)
      },
      code: {
        required,
        minLength: minLength(6),
        maxLength: maxLength(6)
      },
      area: {
        required,
        minLength: minLength(3),
        maxLength: maxLength(128)
      },
      group: {
        required,
        minLength: minLength(3),
        maxLength: maxLength(128)
      },
      icon: {
        required,
        minLength: minLength(8),
        maxLength: maxLength(32)
      }
    }
  },
  methods: {
    clearForm() {
      this.$v.$reset();
      this.setFormData(this.wirelessSocketSelected);
    },
    getValidationClass(fieldName) {
      const field = this.$v.form[fieldName];
      if (!!field) {
        return { "md-invalid": field.$invalid && field.$dirty };
      }
    },
    hasChanges() {
      const hasChanges = this.form.name !== this.wirelessSocketSelected.name 
        || this.form.code !== this.wirelessSocketSelected.code 
        || this.form.area !== this.wirelessSocketSelected.area 
        || this.form.group !== this.wirelessSocketSelected.group 
        || this.form.description !== this.wirelessSocketSelected.description 
        || this.form.icon !== this.wirelessSocketSelected.icon;

      this.$store.dispatch("setWirelessSocketInEdit", hasChanges);

      return hasChanges;
    },
    onDeleteYes() {
      this.$store.dispatch("deleteWirelessSocket", this.wirelessSocketSelected);
    },
    save() {
      this.sending = true;
      var wirelessSocket = {
        id: this.wirelessSocketSelected.id,
        name: this.form.name,
        code: this.form.code,
        area: this.form.area,
        state: this.wirelessSocketSelected.state,
        description: this.form.description,
        icon: this.form.icon,
        deletable: this.$store.getters.wirelessSocketSelected.deletable,
        lastToggled: this.form.lastToggled.getTime(),
        group: this.form.group
      };
      this.$store.dispatch("updateWirelessSocket", wirelessSocket);

      this.saved = true;
      this.sending = false;
      this.clearForm();
    },
    setFormData(wirelessSocket) {
      if (!!wirelessSocket) {
        this.form.name = wirelessSocket.name;
        this.form.code = wirelessSocket.code;
        this.form.area = wirelessSocket.area;
        this.form.group = wirelessSocket.group;
        this.form.lastToggled = !!wirelessSocket.lastToggled
          ? new Date(wirelessSocket.lastToggled)
          : new Date(Date.now());
        this.form.description = wirelessSocket.description;
        this.form.icon = wirelessSocket.icon;
      } else {
        this.form.name = undefined;
        this.form.code = undefined;
        this.form.area = undefined;
        this.form.group = undefined;
        this.form.lastToggled = new Date(Date.now());
        this.form.description = undefined;
        this.form.icon = undefined;
      }
    },
    showPeriodicTasks() {
      this.$emit("showPeriodicTasks");
    },
    validate() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.save();
      }
    }
  },
  watch: {
    wirelessSocketSelected(wirelessSocket) {
      this.setFormData(wirelessSocket);
    }
  },
  created() {
    this.setFormData(this.$store.getters.wirelessSocketSelected);
  },
  computed: {
    areaSelected() {
      return this.$store.getters.areaSelected;
    },
    wirelessSocketSelected() {
      return this.$store.getters.wirelessSocketSelected;
    }
  },
  filters: {
    canBeDeleted: function(wirelessSocket) {
      return wirelessSocket.deletable === 1;
    }
  }
};
</script>