'use strict'

import Vue from 'vue'
import Vuex from 'vuex'

import areas from './areas'
import settings from './settings'
import wirelessSockets from './wireless-sockets'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        areas,
        settings,
        wirelessSockets
    }
})