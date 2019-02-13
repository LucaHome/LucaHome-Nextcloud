import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        view: "list",
        wirelessSockets: [],
        newWirelessSocket: {}
    },
    mutations: {
        CHANGE_VIEW(state, view) {
            state.view = view
        },
        GET_WIRELESS_SOCKET(state, wirelessSocket) {
            state.newWirelessSocket = wirelessSocket
        },
        ADD_WIRELESS_SOCKET(state) {
            state.wirelessSockets.push(state.newWirelessSocket)
        },
        EDIT_WIRELESS_SOCKET(state, wirelessSocket) {
            var wirelessSockets = state.wirelessSockets
            wirelessSockets.splice(wirelessSockets.indexOf(wirelessSocket), 1)
            state.wirelessSockets = wirelessSockets
            state.newWirelessSocket = wirelessSocket
        },
        REMOVE_WIRELESS_SOCKET(state, wirelessSocket) {
            var wirelessSockets = state.wirelessSockets
            wirelessSockets.splice(wirelessSockets.indexOf(wirelessSocket), 1)
            state.wirelessSockets = wirelessSockets
        }
    },
    actions: {
        changeView({commit}, view) {
            commit('CHANGE_VIEW', view)
        },
        getWirelessSocket({commit}, wirelessSocket) {
            commit('GET_WIRELESS_SOCKET', wirelessSocket)
        },
        addWirelessSocket({commit}) {
            commit('ADD_WIRELESS_SOCKET')
        },
        editWirelessSocket({commit}, wirelessSocket) {
            commit('EDIT_WIRELESS_SOCKET', wirelessSocket)
        },
        removeWirelessSocket({commit}, wirelessSocket) {
            commit('REMOVE_WIRELESS_SOCKET', wirelessSocket)
        }
    },
    getters: {
        view: state => state.view,
        wirelessSockets: state => state.wirelessSockets,
        newWirelessSocket: state => state.newWirelessSocket
    }
})