import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

var preselectedWirelessSocket = {
    id: 0,
    icon: require("@/assets/wireless_socket_light_on.png"),
    name: "Light Sleeping",
    area: "Sleeping Room",
    code: "11010A",
    state: false
};

export default new Vuex.Store({
    state: {
        wirelessSocketList: [
            preselectedWirelessSocket,
            {
                id: 1,
                icon: require("@/assets/wireless_socket_sound_on.png"),
                name: "Sound TV",
                area: "Living Room",
                code: "11010B",
                state: false
            },
            {
                id: 2,
                icon: require("@/assets/wireless_socket_raspberry_on.png"),
                name: "Raspberry Pi MediaCenter",
                area: "Living Room",
                code: "11010C",
                state: false
            },
            {
                id: 3,
                icon: require("@/assets/wireless_socket_light_on.png"),
                name: "Light Couch",
                area: "Living Room",
                code: "11010D",
                state: true
            },
            {
                id: 4,
                icon: require("@/assets/wireless_socket_storage_off.png"),
                name: "Backup Drive",
                area: "Working Room",
                code: "11010E",
                state: false
            },
            {
                id: 5,
                icon: require("@/assets/wireless_socket_mediamirror_off.png"),
                name: "Media Mirror Kitchen",
                area: "Kitchen",
                code: "11011A",
                state: true
            },
            {
                id: 6,
                icon: require("@/assets/wireless_socket_light_off.png"),
                name: "Light Ceiling",
                area: "Living Room",
                code: "11000A",
                state: false
            }
        ],
        selectedWirelessSocket: preselectedWirelessSocket
    },
    mutations: {
        SELECT_WIRELESS_SOCKET(state, wirelessSocket) {
            state.selectedWirelessSocket = wirelessSocket
        },
        ADD_WIRELESS_SOCKET(state) {
            var wirelessSocket = {
                id: state.wirelessSocketList.length,
                icon: require("@/assets/wireless_socket_light_off.png"),
                name: "",
                area: "",
                code: "",
                state: false};
            state.wirelessSocketList.push(wirelessSocket)
            state.selectedWirelessSocket = wirelessSocket
        },
        REMOVE_WIRELESS_SOCKET(state, wirelessSocket) {
            var wirelessSocketList = state.wirelessSocketList
            wirelessSocketList.splice(wirelessSocketList.indexOf(wirelessSocket), 1)
            state.wirelessSocketList = wirelessSocketList
        },
        TOGGLE_WIRELESS_SOCKET_STATE(state, wirelessSocket) {
            wirelessSocket.state = !wirelessSocket.state
            var wirelessSocketList = state.wirelessSocketList
            const index = wirelessSocketList.findIndex(entry => entry.id === wirelessSocket.id)
            if (index !== -1) {
                wirelessSocketList[index] = wirelessSocket;
            }
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
        },
        toggleWirelessSocketState({commit}, wirelessSocket) {
            commit('TOGGLE_WIRELESS_SOCKET_STATE', wirelessSocket)
        }
    },
    getters: {
        wirelessSocketList: state => state.wirelessSocketList,
        selectedWirelessSocket: state => state.selectedWirelessSocket
    }
})