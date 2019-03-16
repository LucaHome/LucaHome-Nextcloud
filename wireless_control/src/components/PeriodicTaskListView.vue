<template>
  <div>
    <md-list class="md-triple-line">
      <div v-for="(periodicTask, index) in periodicTasksForArea" :key="index">
        <md-list-item
          @click="select(periodicTask)"
          :class="{selected: periodicTask.id === periodicTaskSelected.id, selectable: periodicTask.id !== periodicTaskSelected.id}"
        >
          <md-avatar>
            <md-icon v-if="!!periodicTask.active">timer</md-icon>
            <md-icon v-else>timer_off</md-icon>
          </md-avatar>

          <div class="md-list-item-text">
            <span>{{ periodicTask.name }}</span>
            <span>{{ periodicTask.weekday }}, {{ periodicTask.hour }}:{{ periodicTask.minute }}</span>
            <p>State: {{ periodicTask.wirelessSocketState }}</p>
            <p>Periodic: {{ periodicTask.periodic }}</p>
          </div>
          
          <md-button class="md-icon-button md-raised add-button md-primary" @click="editPeriodicTask(periodicTask)">
            <md-icon>edit</md-icon>
          </md-button>

          <md-button class="md-icon-button md-raised delete-button md-primary" @click="deletePeriodicTask(periodicTask)">
            <md-icon>delete</md-icon>
          </md-button>
        </md-list-item>

        <md-divider class="md-inset"/>
      </div>
    </md-list>

    <md-button class="md-icon-button md-raised add-button md-primary" @click="addPeriodicTask()">
      <md-icon>add</md-icon>
    </md-button>

    <md-dialog-confirm
      :md-active.sync="addPeriodicTaskDialogActive"
      md-title="Add new periodic task"
      md-content="<div>TODO: Add form here</div>"
      md-confirm-text="Save"
      md-cancel-text="Cancel"
      @md-confirm="onAddSave({}/* TODO */)"
    />

    <md-dialog-confirm
      :md-active.sync="editPeriodicTaskDialogActive"
      md-title="Edit periodic task"
      md-content="<div>TODO: Add form here</div>"
      md-confirm-text="Update"
      md-cancel-text="Cancel"
      @md-confirm="onEditSave({}/* TODO */)"
    />

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
export default {
  name: "PeriodicTaskListView",
  data: () => ({
    addPeriodicTaskDialogActive: false,
    editPeriodicTaskDialogActive: false,
    deletePeriodicTaskDialogActive: false,
    interval: null
  }),
  computed: {
    periodicTasksForArea() {
      var periodicTasks = this.$store.getters.periodicTasks;
      var wirelessSocketSelected = this.$store.getters.wirelessSocketSelected;

      var periodicTasksForArea =
        wirelessSocketSelected !== null
          ? periodicTasks.filter(x => x.wirelessSocketId === wirelessSocketSelected.id)
          : [];

      this.select(periodicTasksForArea.length === 0 ? null : periodicTasksForArea[0]);

      return periodicTasksForArea;
    },
    periodicTaskSelected() {
      return this.$store.getters.periodicTaskSelected;
    }
  },
  beforeDestroy: function() {
    clearInterval(this.interval);
  },
  created() {
    this.interval = setInterval(() => this.$store.dispatch("loadPeriodicTasks"), 15 * 1000);
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
        id: periodicTasks.length > 0 ? Math.max(...periodicTasks.map(x => x.id)) + 1 : 0,
        name: '',
        wirelessSocketId: wirelessSocket.id,
        wirelessSocketState: 1,
        // The php server side counts from 1 - Monday to 7 - Sunday
        weekday: now.getDay() === 0 ? 7 : now.getDay(),
        hour: now.getHours(),
        minute: now.getMinutes(),
        periodic: 1,
        active: 0
      };
      this.$store.dispatch("selectPeriodicTask", periodicTask);
      this.addPeriodicTaskDialogActive = true;
    },
    onAddSave(periodicTask) {
      this.$store.dispatch("addPeriodicTask", periodicTask);
    },

    editPeriodicTask(periodicTask) {
      this.$store.dispatch("selectPeriodicTask", periodicTask);
      this.editPeriodicTaskDialogActive = true;
    },
    onEditSave(periodicTask) {
      this.$store.dispatch("updatePeriodicTask", periodicTask);
    },

    deletePeriodicTask(periodicTask) {
      this.$store.dispatch("selectPeriodicTask", periodicTask);
      this.deletePeriodicTaskDialogActive = true;
    },
    onDeleteYes() {
      this.$store.dispatch("deletePeriodicTask", this.$store.getters.periodicTaskSelected);
    }
  }
};
</script>