<template>
  <div v-if="selectedWirelessSocket">
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
          </div>
        </md-card-content>

        <md-progress-bar md-mode="indeterminate" v-if="sending"/>

        <md-card-actions>
          <md-button
            type="submit"
            class="md-primary"
            :disabled="sending || !hasChanges()"
          >Save wireless socket</md-button>
        </md-card-actions>

        <md-card-actions>
          <md-button
            class="md-accent"
            :disabled="sending || hasChanges()"
            @click="deleteDialogActive = true"
          >Delete wireless socket</md-button>
        </md-card-actions>
      </md-card>

      <md-snackbar :md-active.sync="saved">The wireless socket was saved with success!</md-snackbar>
    </form>

    <md-dialog-confirm
      :md-active.sync="deleteDialogActive"
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
      description: null
    },
    saved: false,
    sending: false,
    deleteDialogActive: false
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
      this.setFormData(this.selectedWirelessSocket);
    },
    save() {
      this.sending = true;

      // Instead of this timeout, here we have to call the API
      window.setTimeout(() => {
        var wirelessSocket = {
          id: this.selectedWirelessSocket.id,
          icon: "fas fa-lightbulb",
          name: this.form.name,
          area: this.form.area,
          code: this.form.code,
          state: false,
          description: this.form.description
        };
        this.$store.dispatch("saveWirelessSocket", wirelessSocket);

        this.saved = true;
        this.sending = false;
        this.clearForm();
      }, 1500);
    },
    onDeleteYes() {
      this.$store.dispatch("removeWirelessSocket", this.selectedWirelessSocket);
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
      } else {
        this.form.name = null;
        this.form.code = null;
        this.form.area = null;
        this.form.description = null;
      }
    },
    hasChanges() {
      return (
        this.form.name !== this.selectedWirelessSocket.name ||
        this.form.code !== this.selectedWirelessSocket.code ||
        this.form.area !== this.selectedWirelessSocket.area ||
        this.form.description !== this.selectedWirelessSocket.description
      );
    }
  },
  watch: {
    selectedWirelessSocket(wirelessSocket) {
      this.setFormData(wirelessSocket);
    }
  },
  created() {
    var wirelessSocket = this.$store.getters.selectedWirelessSocket;
    this.setFormData(wirelessSocket);
  },
  computed: {
    selectedWirelessSocket() {
      return this.$store.getters.selectedWirelessSocket;
    },
    selectedArea() {
      return this.$store.getters.selectedArea;
    }
  }
};
</script>

<style lang="scss" scoped>
.md-progress-bar {
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
}
</style>
