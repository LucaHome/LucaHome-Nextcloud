'use strict'

import Vue from 'vue'
import Vuex from 'vuex'

import areas from './areas'
import periodicTasks from './periodic-tasks'
import settings from './settings'
import wirelessSockets from './wireless-sockets'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        areas,
        periodicTasks,
        settings,
        wirelessSockets
    }
})