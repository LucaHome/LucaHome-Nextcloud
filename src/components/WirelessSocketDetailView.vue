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
                  <md-input name="name" id="name" v-model="form.name" :disabled="sending"/>
                  <span class="md-error" v-if="!$v.form.name.required">The name is required</span>
                  <span class="md-error" v-else-if="!$v.form.name.minlength">Invalid name length</span>
                </md-field>
              </div>

              <div class="md-layout-item md-small-size-100">
                <md-field :class="getValidationClass('code')">
                  <label for="code">Code</label>
                  <md-input name="code" id="code" v-model="form.code" :disabled="sending"/>
                  <span class="md-error" v-if="!$v.form.code.required">The code is required</span>
                  <span
                    class="md-error"
                    v-else-if="!$v.form.code.minlength"
                  >Invalid code length (too short)</span>
                  <span
                    class="md-error"
                    v-else-if="!$v.form.code.maxlength"
                  >Invalid code length (too long)</span>
                </md-field>
              </div>

              <div class="md-layout-item md-small-size-100">
                <md-field :class="getValidationClass('area')">
                  <label for="area">Area</label>
                  <md-input name="area" id="area" v-model="form.area" :disabled="sending"/>
                  <span class="md-error" v-if="!$v.form.area.required">The area is required</span>
                  <span class="md-error" v-else-if="!$v.form.area.minlength">Invalid area length</span>
                </md-field>
              </div>
            </div>

            <div class="md-layout-item md-small-size-100">
              <md-field>
                <label for="description">Description</label>
                <md-input
                  name="description"
                  id="description"
                  v-model="form.description"
                  :disabled="sending"
                />
              </md-field>
            </div>

            <div class="md-layout-item md-small-size-100">
              <md-field>
                <label for="icon">Icon</label>
                <md-input name="icon" id="icon" v-model="form.icon" :disabled="sending"/>
                <i :class="form.icon"/>
              </md-field>
              <a
                href="https://fontawesome.com/icons?d=gallery&m=free"
                target="_"
              >Get Icons from here</a>
            </div>
          </div>
        </md-card-content>

        <md-progress-bar md-mode="indeterminate" v-if="sending"/>

        <md-card-actions>
          <md-button
            class="md-primary"
            @click="showPeriodicTasks()"
          >Periodic Tasks</md-button>
        </md-card-actions>

        <md-card-actions>
          <md-button
            type="submit"
            class="md-primary"
            :disabled="sending || !hasChanges()"
          >Save wireless socket</md-button>
        </md-card-actions>

        <md-card-actions v-if="wirelessSocketSelected.deletable === 1 || wirelessSocketSelected.deletable === '1'">
          <md-button
            class="md-accent"
            :disabled="sending || hasChanges()"
            @click="deleteWirelessSocketDialogActive = true"
          >Delete wireless socket</md-button>
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
      name: null,
      code: null,
      area: null,
      state: false,
      description: null,
      icon: null
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
      icon: {
        required,
        minLength: minLength(8),
        maxLength: maxLength(32)
      }
    }
  },
  methods: {
    getValidationClass(fieldName) {
      const field = this.$v.form[fieldName];
      if (field) {
        return {
          "md-invalid": field.$invalid && field.$dirty
        };
      }
    },
    clearForm() {
      this.$v.$reset();
      this.setFormData(this.wirelessSocketSelected);
    },
    save() {
      this.sending = true;
      var wirelessSocket = {
        id: this.wirelessSocketSelected.id,
        name: this.form.name,
        code: this.form.code,
        area: this.form.area,
        state: false,
        description: this.form.description,
        icon: this.form.icon,
        deletable: this.$store.getters.wirelessSocketSelected.deletable
      };
      this.$store.dispatch("updateWirelessSocket", wirelessSocket);

      this.saved = true;
      this.sending = false;
      this.clearForm();
    },
    onDeleteYes() {
      this.$store.dispatch("deleteWirelessSocket", this.wirelessSocketSelected);
    },
    validate() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.save();
      }
    },
    setFormData(wirelessSocket) {
      if (wirelessSocket) {
        this.form.name = wirelessSocket.name;
        this.form.code = wirelessSocket.code;
        this.form.area = wirelessSocket.area;
        this.form.description = wirelessSocket.description;
        this.form.icon = wirelessSocket.icon;
      } else {
        this.form.name = null;
        this.form.code = null;
        this.form.area = null;
        this.form.description = null;
        this.form.icon = null;
      }
    },
    hasChanges() {
      const hasChanges = (
        this.form.name !== this.wirelessSocketSelected.name ||
        this.form.code !== this.wirelessSocketSelected.code ||
        this.form.area !== this.wirelessSocketSelected.area ||
        this.form.description !== this.wirelessSocketSelected.description ||
        this.form.icon !== this.wirelessSocketSelected.icon
      );

      this.$store.dispatch("setWirelessSocketInEdit", hasChanges);

      return hasChanges;
    },
    showPeriodicTasks() {
      this.$emit('showPeriodicTasks');
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
  }
};
</script>