# TODO

## Server side

These are Todos for the Server side, written in PHP

- [X] Add possibility to create tasks setting wireless socket states automatically
    - [X] Test It
    - [ ] Fix Bugs
        - [ ] Fix background job
- [ ] ...

## Website

These are Todos for the Website, written in JS using Vue.js, Vue-Material and Nextcloud-libraries

- [X] Add possibility to create tasks setting wireless socket states automatically
    - [X] Task-Button next to the other buttons in a wireless socket details card ✔
        - [X] Display periodic task content, only after click on this button (throw event to tell main component to display this, v-if) ✔
    - [X] List of tasks for a wireless socket will be similar to a sidenav in material design on the right side of the screen
        - [X] container for a list of material cards with information for periodic task (Name ✔, Weekday ✔, Hour ✔, Minute ✔, State to set ✔, Active (inidicated by icon) ✔, Periodic ✔)
        - [X] each material card will have a edit ✔ and delete ✔ button
            - [X] edit button opens a dialog to edit the properties
            - [X] delete button asks for deletion of periodic tasks
        - [X additional add button ✔ in material action button design (see other add buttons) at the bottom of the sidenav (opens a dialog to edit the properties)
    - [X] Test It
    - [ ] Fix Bugs
        - [X] Fix Bug: TypeError: "this.periodicTaskSelected is null" in PeriodicTaskEditDialogView.vue:190
        - [X] Fix Bug: TypeError: "this.periodicTaskSelected is null" in PeriodicTaskEditDialogView.vue:194
            - [X] Timing problem: 2nd time pressing add button is successful (previous selection is in state)
    - [ ] Fix time display in periodic task card (single minute or hour is displayed without prefix '0')
    - [ ] Type variance in periodicTask from server and newly created leads to display bugs in edit dialog for periodic tasks
- [X] Clean up
- [ ] ...
