import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        wirelessSocketList: [],
        selectedWirelessSocket: {}
    },
    mutations: {
        SELECT_WIRELESS_SOCKET(state, wirelessSocket) {
            state.selectedWirelessSocket = wirelessSocket
        },
        ADD_WIRELESS_SOCKET(state, wirelessSocket) {
            state.wirelessSocketList.push(wirelessSocket)
        },
        REMOVE_WIRELESS_SOCKET(state, wirelessSocket) {
            var wirelessSocketList = state.wirelessSocketList
            wirelessSocketList.splice(wirelessSocketList.indexOf(wirelessSocket), 1)
            state.wirelessSocketList = wirelessSocketList
        }
    },
    actions: {
        selectWirelessSocket({commit}, wirelessSocket) {
            commit('SELECT_WIRELESS_SOCKET', wirelessSocket)
        },
        addWirelessSocket({commit}) {
            commit('ADD_WIRELESS_SOCKET')
        },
        removeWirelessSocket({commit}, wirelessSocket) {
            commit('REMOVE_WIRELESS_SOCKET', wirelessSocket)
        }
    },
    getters: {
        wirelessSocketList: state => state.wirelessSocketList,
        selectedWirelessSocket: state => state.selectedWirelessSocket
    }
})