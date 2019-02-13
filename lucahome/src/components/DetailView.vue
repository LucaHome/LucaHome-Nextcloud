<template>
  <div>
    <form novalidate class="md-layout" @submit.prevent="validate">
      <md-card class="md-layout-item md-size-95 md-small-size-100">
        <md-card-header>
          <div class="md-title">WirelessSocket Data</div>
        </md-card-header>

        <md-card-content>
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
        </md-card-content>

        <md-progress-bar md-mode="indeterminate" v-if="sending"/>

        <md-card-actions>
          <md-button type="submit" class="md-primary" :disabled="sending">Save wireless socket</md-button>
        </md-card-actions>
      </md-card>

      <md-snackbar :md-active.sync="saved">The wireless socket was saved with success!</md-snackbar>
    </form>
  </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required, minLength, maxLength } from "vuelidate/lib/validators";

export default {
  name: "FormValidation",
  mixins: [validationMixin],
  data: () => ({
    form: {
      name: null,
      code: null,
      area: null,
      state: false,
      userId: null,
      description: null,
      public: true,
      added: null,
      lastmodified: null,
      clickcount: 0
    },
    saved: false,
    sending: false
  }),
  validations: {
    form: {
      name: {
        required,
        minLength: minLength(3)
      },
      code: {
        required,
        minLength: minLength(6),
        maxLength: maxLength(6)
      },
      area: {
        required,
        maxLength: minLength(3)
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
      this.form.name = null;
      this.form.code = null;
      this.form.area = null;
      this.form.gender = null;
      this.form.state = false;
      this.form.userId = null;
      this.form.description = null;
      this.form.public = true;
      this.form.added = null;
      this.form.lastmodified = null;
      this.form.clickcount = 0;
    },
    save() {
      this.sending = true;

      // Instead of this timeout, here we have to call the API
      window.setTimeout(() => {
        this.saved = true;
        this.sending = false;
        this.clearForm();
      }, 1500);
    },
    validate() {
      this.$v.$touch();

      if (!this.$v.$invalid) {
        this.save();
      }
    }
  },
  watch: {
    selectedWirelessSocket(wirelessSocket) {
      this.form.name = wirelessSocket.name;
    }
  },
  created() {
    var wirelessSocket = this.$store.getters.selectedWirelessSocket;
    this.form.name = wirelessSocket.name;
  },
  computed: {
    selectedWirelessSocket() {
      return this.$store.getters.selectedWirelessSocket;
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
