<template>
  <div>
    <md-button
      class="md-icon-button md-raised close-button md-primary"
      @click="closePeriodicTaskListView()"
    >
      <md-icon>close</md-icon>
    </md-button>

    <md-list class="md-triple-line">
      <div v-for="(periodicTask, index) in periodicTasksForWirelessSocket" :key="index">
        <md-list-item
          :class="{selected: periodicTask.id === periodicTaskSelected.id, selectable: periodicTask.id !== periodicTaskSelected.id}"
        >
          <md-avatar @click="select(periodicTask)">
            <md-icon v-if="!!periodicTask.active">timer</md-icon>
            <md-icon v-else>timer_off</md-icon>
          </md-avatar>

          <div class="md-list-item-text" @click="select(periodicTask)">
            <span>{{ periodicTask.name }}</span>
            <span>{{ numberToWeekday(periodicTask.weekday) }}, {{ getTimeString(periodicTask) }}</span>
            <p>{{ periodicTask.wirelessSocketState === 1 ? 'Activate' : 'Deactivate' }}{{ periodicTask.periodic === 1 ? ', Periodic' : '' }}</p>
          </div>

          <md-button
            class="md-icon-button md-raised add-button md-primary periodic-task-button-edit"
            @click="editPeriodicTask(periodicTask)"
          >
            <md-icon>edit</md-icon>
          </md-button>

          <md-button
            class="md-icon-button md-raised delete-button md-primary periodic-task-button-delete"
            @click="deletePeriodicTask(periodicTask)"
          >
            <md-icon>delete</md-icon>
          </md-button>
        </md-list-item>

        <md-divider class="md-inset"/>
      </div>
    </md-list>

    <md-button class="md-icon-button md-raised add-button md-primary" @click="addPeriodicTask()">
      <md-icon>add</md-icon>
    </md-button>

    <md-dialog :md-active.sync="addEditPeriodicTaskDialogActive">
      <PeriodicTaskEditDialogView
        v-on:closePeriodicTaskDialog="addEditPeriodicTaskDialogActive = false"
      />
    </md-dialog>

    <md-dialog-confirm
      :md-active.sync="deletePeriodicTaskDialogActive"
      md-title="Delete?"
      md-content="Do you want to delete this periodic task?"
      md-confirm-text="Yes"
      md-cancel-text="No"
      @md-confirm="onDeleteYes"
    />
  </div>
</template>

<script>
import PeriodicTaskEditDialogView from "./PeriodicTaskEditDialogView.vue";
import DateTimeString from "../utils/date-time-string.utils";

export default {
  name: "PeriodicTaskListView",
  data: () => ({
    addEditPeriodicTaskDialogActive: false,
    deletePeriodicTaskDialogActive: false
  }),
  components: {
    PeriodicTaskEditDialogView
  },
  computed: {
    periodicTasksForWirelessSocket() {
      var periodicTaskInEdit = this.$store.getters.periodicTaskInEdit;
      var periodicTasks = this.$store.getters.periodicTasks;
      var periodicTaskSelected = this.$store.getters.periodicTaskSelected;
      var wirelessSocketSelected = this.$store.getters.wirelessSocketSelected;

      var periodicTasksForWirelessSocket =
        wirelessSocketSelected !== null
          ? periodicTasks.filter(
              x => x.wirelessSocketId === wirelessSocketSelected.id
            )
          : [];

      if (
        !periodicTaskInEdit &&
        (!periodicTaskSelected ||
          periodicTasksForWirelessSocket.filter(
            x => x.id == periodicTaskSelected.id
          ).length === 0)
      ) {
        this.select(
          periodicTasksForWirelessSocket.length === 0
            ? null
            : periodicTasksForWirelessSocket[0]
        );
      }

      return periodicTasksForWirelessSocket;
    },
    periodicTaskSelected() {
      return this.$store.getters.periodicTaskSelected;
    }
  },
  methods: {
    select(periodicTask) {
      this.$store.dispatch("selectPeriodicTask", periodicTask);
    },
    addPeriodicTask() {
      var now = new Date();
      var periodicTasks = this.$store.getters.periodicTasks;
      var wirelessSocket = this.$store.getters.wirelessSocketSelected;

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
      this.$store.dispatch("selectPeriodicTask", periodicTask);
      this.addEditPeriodicTaskDialogActive = true;
    },
    editPeriodicTask(periodicTask) {
      this.$store.dispatch("selectPeriodicTask", periodicTask);
      this.addEditPeriodicTaskDialogActive = true;
    },
    deletePeriodicTask(periodicTask) {
      this.$store.dispatch("selectPeriodicTask", periodicTask);
      this.deletePeriodicTaskDialogActive = true;
    },
    onDeleteYes() {
      this.$store.dispatch(
        "deletePeriodicTask",
        this.$store.getters.periodicTaskSelected
      );
    },
    closePeriodicTaskListView() {
      this.$emit("closePeriodicTaskListView");
    },
    getTimeString(periodicTask) {
      return DateTimeString.getTimeString(periodicTask);
    },
    numberToWeekday(number) {
      return DateTimeString.numberToWeekday(number);
    }
  }
};
</script>