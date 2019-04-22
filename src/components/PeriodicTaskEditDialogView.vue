<template>
  <form novalidate class="md-layout" style="margin: 1rem;" @submit.prevent="validate">
    <md-card class="md-layout-item md-size-100 md-small-size-100">
      <md-card-header>
        <div class="md-title">Edit Periodic Task</div>
      </md-card-header>

      <md-card-content>
        <div>
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-item-min-width-75">
              <md-field :class="getValidationClass('name')">
                <label for="name">Name</label>
                <md-input name="name" id="name" v-model="form.name" :disabled="sending"/>
                <span class="md-error" v-if="!$v.form.name.required">The name is required</span>
                <span class="md-error" v-else-if="!$v.form.name.minlength">Invalid name length</span>
              </md-field>
            </div>

            <div class="md-layout-item md-item-min-width-25">
              <md-checkbox
                v-model="form.wirelessSocketState"
                class="md-primary"
                :disabled="sending"
              >State</md-checkbox>
            </div>

            <div class="md-layout-item md-item-min-width-33">
              <md-field :class="getValidationClass('weekday')">
                <md-select
                  v-model="form.weekday"
                  name="weekday"
                  id="weekday"
                  placeholder="Select a weekday"
                  :disabled="sending"
                >
                  <md-option value="1">Monday</md-option>
                  <md-option value="2">Tuesday</md-option>
                  <md-option value="3">Wednesday</md-option>
                  <md-option value="4">Thursday</md-option>
                  <md-option value="5">Friday</md-option>
                  <md-option value="6">Saturday</md-option>
                  <md-option value="7">Sunday</md-option>
                </md-select>
              </md-field>
            </div>

            <div class="md-layout-item md-item-min-width-33">
              <md-field :class="getValidationClass('hour')">
                <label for="hour">Hour</label>
                <md-input name="hour" id="hour" v-model="form.hour" :disabled="sending"/>
                <span class="md-error" v-if="!$v.form.hour.required">The hour is required</span>
                <span class="md-error" v-else-if="!$v.form.hour.range">Invalid hour range (0-23)</span>
              </md-field>
            </div>

            <div class="md-layout-item md-item-min-width-33">
              <md-field :class="getValidationClass('minute')">
                <label for="minute">Minute</label>
                <md-input name="minute" id="minute" v-model="form.minute" :disabled="sending"/>
                <span class="md-error" v-if="!$v.form.minute.required">The minute is required</span>
                <span class="md-error" v-else-if="!$v.form.minute.range">Invalid minute range (0-59)</span>
              </md-field>
            </div>

            <div class="md-layout-item md-item-min-width-50">
              <md-checkbox v-model="form.periodic" class="md-primary" :disabled="sending">Periodic</md-checkbox>
            </div>

            <div class="md-layout-item md-item-min-width-50">
              <md-checkbox v-model="form.active" class="md-primary" :disabled="sending">Active</md-checkbox>
            </div>
          </div>
        </div>
      </md-card-content>

      <md-progress-bar md-mode="indeterminate" v-if="sending"/>

      <md-card-actions>
        <md-button type="submit" class="md-primary" :disabled="sending || !hasChanges()">Save</md-button>
      </md-card-actions>

      <md-card-actions>
        <md-button class="md-primary" @click="close()">Cancel</md-button>
      </md-card-actions>
    </md-card>
  </form>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required, minLength, maxLength } from "vuelidate/lib/validators";

export default {
  name: "PeriodicTaskEditDialogView",
  mixins: [validationMixin],
  data: () => ({
    form: {
      name: null,
      wirelessSocketState: null,
      weekday: false,
      hour: null,
      minute: null,
      periodic: null,
      active: null
    },
    modeAdd: true,
    sending: false
  }),
  validations: {
    form: {
      name: {
        required,
        minLength: minLength(3),
        maxLength: maxLength(128)
      },
      weekday: {
        required
      },
      hour: {
        required,
        range: value => value >= 0 && value <= 23
      },
      minute: {
        required,
        range: value => value >= 0 && value <= 59
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
    close() {
      this.$store.dispatch("setPeriodicTaskInEdit", false);
      this.$emit("closePeriodicTaskDialog");
    },
    save() {
      this.sending = true;

      var periodicTask = {
        id: this.periodicTaskSelected.id,
        name: this.form.name,
        wirelessSocketId: this.periodicTaskSelected.wirelessSocketId,
        wirelessSocketState: this.form.wirelessSocketState ? 1 : 0,
        weekday: this.form.weekday,
        hour: this.form.hour,
        minute: this.form.minute,
        periodic: this.form.periodic ? 1 : 0,
        active: this.form.active ? 1 : 0
      };

      if (this.modeAdd) {
        this.$store.dispatch("addPeriodicTask", periodicTask);
      } else {
        this.$store.dispatch("updatePeriodicTask", periodicTask);
      }

      this.$store.dispatch("setPeriodicTaskInEdit", false);

      this.sending = false;
      this.close();
    },
    validate() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.save();
      }
    },
    setFormData(periodicTask) {
      if (periodicTask) {
        this.form.name = periodicTask.name;
        this.form.wirelessSocketId = periodicTask.wirelessSocketId;
        this.form.wirelessSocketState = periodicTask.wirelessSocketState === 1;
        this.form.weekday = periodicTask.weekday;
        this.form.hour = periodicTask.hour;
        this.form.minute = periodicTask.minute;
        this.form.periodic = periodicTask.periodic === 1;
        this.form.active = periodicTask.active === 1;
      } else {
        this.form.name = null;
        this.form.wirelessSocketId = null;
        this.form.wirelessSocketState = false;
        this.form.weekday = 1;
        this.form.hour = 0;
        this.form.minute = 0;
        this.form.periodic = false;
        this.form.active = false;
      }
    },
    hasChanges() {
      return (
        !!this.periodicTaskSelected &&
        (this.form.name !== this.periodicTaskSelected.name ||
          this.form.wirelessSocketId !==
          this.periodicTaskSelected.wirelessSocketId ||
          this.form.wirelessSocketState !==
          this.periodicTaskSelected.wirelessSocketState ||
          this.form.weekday !== this.periodicTaskSelected.weekday ||
          this.form.hour !== this.periodicTaskSelected.hour ||
          this.form.minute !== this.periodicTaskSelected.minute ||
          this.form.periodic !== this.periodicTaskSelected.periodic ||
          this.form.active !== this.periodicTaskSelected.active)
      );
    }
  },
  watch: {
    periodicTaskSelected(periodicTask) {
      this.setFormData(periodicTask);
    }
  },
  created() {
    this.$store.dispatch("setPeriodicTaskInEdit", true);

    if (!!this.$store.getters.periodicTaskSelected) {
      this.modeAdd = this.$store.getters.periodicTaskSelected.name === "";
      this.setFormData(this.$store.getters.periodicTaskSelected);
    } else {
      var now = new Date();
      var periodicTasks = this.$store.getters.periodicTasks;
      var wirelessSocket = this.$store.getters.wirelessSocketSelected;

      this.modeAdd = true;

      var periodicTask = {
        id:
          periodicTasks.length > 0
            ? Math.max(...periodicTasks.map(x => x.id)) + 1
            : 0,
        name: "",
        wirelessSocketId: wirelessSocket.id,
        wirelessSocketState: true,
        // The php server side counts from 1 - Monday to 7 - Sunday
        weekday: now.getDay() === 0 ? 7 : now.getDay(),
        hour: now.getHours(),
        minute: now.getMinutes(),
        periodic: true,
        active: true
      };

      this.setFormData(periodicTask);
      this.$store.dispatch("selectPeriodicTask", periodicTask);
    }
  },
  computed: {
    periodicTaskSelected() {
      return this.$store.getters.periodicTaskSelected;
    }
  }
};
</script>