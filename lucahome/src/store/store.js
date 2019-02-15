import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

var preselectedArea = {
    id: 0,
    filter: "",
    name: "All"
};

var areaList = [
    preselectedArea,
    {
        id: 1,
        filter: "Sleeping Room",
        name: "Sleeping Room"
    },
    {
        id: 2,
        filter: "Living Room",
        name: "Living Room"
    },
    {
        id: 3,
        filter: "Working Room",
        name: "Working Room"
    },
    {
        id: 4,
        filter: "Kitchen",
        name: "Kitchen"
    }
];

var preselectedWirelessSocket = {
    id: 0,
    icon: require("@/assets/img/wireless_socket/light_on.png"),
    name: "Light Sleeping",
    area: "Sleeping Room",
    code: "11010A",
    state: false,
    description: ""
};

var wirelessSocketList = [
    preselectedWirelessSocket,
    {
        id: 1,
        icon: require("@/assets/img/wireless_socket/sound_on.png"),
        name: "Sound TV",
        area: "Living Room",
        code: "11010B",
        state: false,
        description: ""
    },
    {
        id: 2,
        icon: require("@/assets/img/wireless_socket/raspberry_on.png"),
        name: "Raspberry Pi MediaCenter",
        area: "Living Room",
        code: "11010C",
        state: false,
        description: ""
    },
    {
        id: 3,
        icon: require("@/assets/img/wireless_socket/light_on.png"),
        name: "Light Couch",
        area: "Living Room",
        code: "11010D",
        state: true,
        description: ""
    },
    {
        id: 4,
        icon: require("@/assets/img/wireless_socket/storage_off.png"),
        name: "Backup Drive",
        area: "Working Room",
        code: "11010E",
        state: false,
        description: ""
    },
    {
        id: 5,
        icon: require("@/assets/img/wireless_socket/mediamirror_off.png"),
        name: "Media Mirror Kitchen",
        area: "Kitchen",
        code: "11011A",
        state: true,
        description: ""
    },
    {
        id: 6,
        icon: require("@/assets/img/wireless_socket/light_off.png"),
        name: "Light Ceiling",
        area: "Living Room",
        code: "11000A",
        state: false,
        description: ""
    }
];

export default new Vuex.Store({
    state: {
        areaList: areaList,
        selectedArea: preselectedArea,
        wirelessSocketList: wirelessSocketList,
        visibleWirelessSocketList: wirelessSocketList,
        selectedWirelessSocket: preselectedWirelessSocket
    },
    mutations: {
        SELECT_AREA(state, area) {
            state.selectedArea = area

            var wirelessSocketList = area.filter === "" ? state.wirelessSocketList : state.wirelessSocketList.filter(x => x.area === area.filter)
            var selectedWirelessSocket = wirelessSocketList.length > 0 ? wirelessSocketList[0] : null
            state.visibleWirelessSocketList = wirelessSocketList
            state.selectedWirelessSocket = selectedWirelessSocket
        },
        ADD_AREA(state) {
            var area = {
                id: state.areaList.length,
                filter: "",
                name: ""
            };
            state.areaList.push(area)
            state.selectedArea = area

            state.visibleWirelessSocketList = null
            state.selectedWirelessSocket = null
        },
        REMOVE_AREA(state, area) {
            var areaList = state.areaList
            areaList.splice(areaList.indexOf(area), 1)
            state.areaList = areaList
            state.selectedArea = null

            var wirelessSocketList = area.filter === "" ? state.wirelessSocketList : state.wirelessSocketList.filter(x => x.area !== area.filter)
            state.wirelessSocketList = wirelessSocketList
            state.visibleWirelessSocketList = null
            state.selectedWirelessSocket = null
        },
        SAVE_AREA(state, name) {
            var areaList = state.areaList
            areaList[areaList.length - 1] = {
                id: areaList.length,
                filter: name,
                name: name
            };
            state.areaList = areaList
            state.selectedArea = areaList[areaList.length - 1]
        },
        SELECT_WIRELESS_SOCKET(state, wirelessSocket) {
            state.selectedWirelessSocket = wirelessSocket
        },
        ADD_WIRELESS_SOCKET(state) {
            var wirelessSocket = {
                id: state.wirelessSocketList.length,
                icon: require("@/assets/img/wireless_socket/light_off.png"),
                name: "",
                area: "",
                code: "",
                state: false,
                description: ""
            };
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
        selectArea({
            commit
        }, area) {
            commit('SELECT_AREA', area)
        },
        addArea({
            commit
        }) {
            commit('ADD_AREA')
        },
        removeArea({
            commit
        }, area) {
            commit('REMOVE_AREA', area)
        },
        saveArea({
            commit
        }, name) {
            commit('SAVE_AREA', name)
        },
        selectWirelessSocket({
            commit
        }, wirelessSocket) {
            commit('SELECT_WIRELESS_SOCKET', wirelessSocket)
        },
        addWirelessSocket({
            commit
        }) {
            commit('ADD_WIRELESS_SOCKET')
        },
        removeWirelessSocket({
            commit
        }, wirelessSocket) {
            commit('REMOVE_WIRELESS_SOCKET', wirelessSocket)
        },
        toggleWirelessSocketState({
            commit
        }, wirelessSocket) {
            commit('TOGGLE_WIRELESS_SOCKET_STATE', wirelessSocket)
        }
    },
    getters: {
        areaList: state => state.areaList,
        selectedArea: state => state.selectedArea,
        wirelessSocketList: state => state.wirelessSocketList,
        visibleWirelessSocketList: state => state.visibleWirelessSocketList,
        selectedWirelessSocket: state => state.selectedWirelessSocket
    }
})