import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

var preselectedArea = {
    id: 0,
    filter: "",
    name: "All"
};

export default new Vuex.Store({
    state: {
        areaList: [],
        selectedArea: null,
        wirelessSocketList: [],
        visibleWirelessSocketList: [],
        selectedWirelessSocket: null
    },
    mutations: {
        INIT(state) {
            this.$axiosService.get("area").then((areaResponse) => {
                state.areaList = areaResponse;
                state.selectedArea = areaResponse.length > 0 ? areaResponse[0] : null;

                if(areaResponse.length > 0) {
                    this.$axiosService.get("wireless_socket").then((wirelessSocketResponse) => {
                        state.wirelessSocketList = wirelessSocketResponse

                        var visibleWirelessSocketList = state.selectedArea.filter === "" ? state.wirelessSocketList : state.wirelessSocketList.filter(x => x.area === state.selectedArea.filter)
                        state.visibleWirelessSocketList = visibleWirelessSocketList
            
                        var selectedWirelessSocket = visibleWirelessSocketList.length > 0 ? visibleWirelessSocketList[0] : null
                        state.selectedWirelessSocket = selectedWirelessSocket
                    });
                } else {
                    state.wirelessSocketList = []
                    state.visibleWirelessSocketList = []
                    state.selectedWirelessSocket = null
                }
            });
        },
        SELECT_AREA(state, area) {
            state.selectedArea = area

            var visibleWirelessSocketList = area.filter === "" ? state.wirelessSocketList : state.wirelessSocketList.filter(x => x.area === area.filter)
            state.visibleWirelessSocketList = visibleWirelessSocketList

            var selectedWirelessSocket = visibleWirelessSocketList.length > 0 ? visibleWirelessSocketList[0] : null
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
                area: state.selectedArea !== preselectedArea ? state.selectedArea.name : "",
                code: "",
                state: false,
                description: ""
            };
            state.wirelessSocketList.push(wirelessSocket)

            var visibleWirelessSocketList = state.selectedArea.filter === "" ? state.wirelessSocketList : state.wirelessSocketList.filter(x => x.area === state.selectedArea.filter)
            state.visibleWirelessSocketList = visibleWirelessSocketList

            state.selectedWirelessSocket = wirelessSocket
        },
        REMOVE_WIRELESS_SOCKET(state, wirelessSocket) {
            var wirelessSocketList = state.wirelessSocketList
            wirelessSocketList.splice(wirelessSocketList.indexOf(wirelessSocket), 1)
            state.wirelessSocketList = wirelessSocketList

            var visibleWirelessSocketList = state.selectedArea.filter === "" ? state.wirelessSocketList : state.wirelessSocketList.filter(x => x.area === state.selectedArea.filter)
            state.visibleWirelessSocketList = visibleWirelessSocketList

            var selectedWirelessSocket = visibleWirelessSocketList.length > 0 ? visibleWirelessSocketList[0] : null
            state.selectedWirelessSocket = selectedWirelessSocket
        },
        SAVE_WIRELESS_SOCKET(state, wirelessSocket) {
            var wirelessSocketList = state.wirelessSocketList.filter(x => x.id !== wirelessSocket.id)
            wirelessSocketList.push(wirelessSocket)
            state.wirelessSocketList = wirelessSocketList

            var visibleWirelessSocketList = state.selectedArea.filter === "" ? state.wirelessSocketList : state.wirelessSocketList.filter(x => x.area === state.selectedArea.filter)
            state.visibleWirelessSocketList = visibleWirelessSocketList

            state.selectedWirelessSocket = wirelessSocket
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
        init({commit}) {
            commit('INIT')
        },
        selectArea({commit}, area) {
            commit('SELECT_AREA', area)
        },
        addArea({commit}) {
            commit('ADD_AREA')
        },
        removeArea({commit}, area) {
            commit('REMOVE_AREA', area)
        },
        saveArea({commit}, name) {
            commit('SAVE_AREA', name)
        },
        selectWirelessSocket({commit}, wirelessSocket) {
            commit('SELECT_WIRELESS_SOCKET', wirelessSocket)
        },
        addWirelessSocket({commit}) {
            commit('ADD_WIRELESS_SOCKET')
        },
        removeWirelessSocket({commit}, wirelessSocket) {
            commit('REMOVE_WIRELESS_SOCKET', wirelessSocket)
        },
        saveWirelessSocket({commit}, wirelessSocket) {
            commit('SAVE_WIRELESS_SOCKET', wirelessSocket)
        },
        toggleWirelessSocketState({commit}, wirelessSocket) {
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