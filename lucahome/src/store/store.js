import Vue from 'vue'
import Vuex from 'vuex'

import axiosService from '../services/axios.service'

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
            axiosService.get("area").then((areaResponse) => {
                if(areaResponse.status === "success") {
                    var areaList = [preselectedArea];
                    state.areaList = areaList.concat(areaResponse.response);
                } else {
                    state.areaList = [preselectedArea];
                    // eslint-disable-next-line
                    console.error(JSON.stringify(areaResponse));
                }
                state.selectedArea = state.areaList[0];

                axiosService.get("wireless_socket").then((wirelessSocketResponse) => {
                    if(wirelessSocketResponse.status === "success") {
                        state.wirelessSocketList = wirelessSocketResponse.response;
                    } else {
                        state.wirelessSocketList = [];
                        // eslint-disable-next-line
                        console.error(JSON.stringify(wirelessSocketResponse));
                    }

                    var visibleWirelessSocketList = state.selectedArea.filter === "" ? state.wirelessSocketList : state.wirelessSocketList.filter(x => x.area === state.selectedArea.filter);
                    state.visibleWirelessSocketList = visibleWirelessSocketList;
        
                    var selectedWirelessSocket = visibleWirelessSocketList.length > 0 ? visibleWirelessSocketList[0] : null;
                    state.selectedWirelessSocket = selectedWirelessSocket;
                });
            });
        },

        SELECT_AREA(state, area) {
            state.selectedArea = area;

            var visibleWirelessSocketList = area.filter === "" ? state.wirelessSocketList : state.wirelessSocketList.filter(x => x.area === area.filter);
            state.visibleWirelessSocketList = visibleWirelessSocketList;

            var selectedWirelessSocket = visibleWirelessSocketList.length > 0 ? visibleWirelessSocketList[0] : null;
            state.selectedWirelessSocket = selectedWirelessSocket;
        },
        ADD_AREA(state) {
            var area = {
                id: Math.max(...state.areaList.map(x => x.id)) + 1,
                filter: "",
                name: ""
            };

            axiosService.put("area", area).then((response) => {
                if(response.status === "success" && response.response >= 0) {
                    area.id = response.response;
                    state.areaList.push(area);
                    state.selectedArea = area;
        
                    state.visibleWirelessSocketList = null;
                    state.selectedWirelessSocket = null;
                } else {
                    // eslint-disable-next-line
                    console.error(JSON.stringify(response));
                }
            });
        },
        SAVE_AREA(state, area) {
            axiosService.post("area", area).then((response) => {
                if(response.status === "success"  && response.response === 0) {
                    var areaList = state.areaList;
                    var index = areaList.map(x => x.id).indexOf(area.id);

                    areaList[index] = area;
                    state.areaList = areaList;
                    state.selectedArea = area;
                } else {
                    // eslint-disable-next-line
                    console.error(JSON.stringify(response));
                }
            });
        },
        REMOVE_AREA(state, area) {
            axiosService.delete("area", area.id).then((response) => {
                if(response.status === "success"  && response.response === 0) {
                    var areaList = state.areaList;
                    areaList.splice(areaList.indexOf(area), 1);
                    state.areaList = areaList;
                    state.selectedArea = null;
        
                    var wirelessSocketList = area.filter === "" ? state.wirelessSocketList : state.wirelessSocketList.filter(x => x.area !== area.filter);
                    state.wirelessSocketList = wirelessSocketList;
                    state.visibleWirelessSocketList = null;
                    state.selectedWirelessSocket = null;
                } else {
                    // eslint-disable-next-line
                    console.error(JSON.stringify(response));
                }
            });
        },

        SELECT_WIRELESS_SOCKET(state, wirelessSocket) {
            state.selectedWirelessSocket = wirelessSocket;
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
            
            axiosService.put("wireless_socket", wirelessSocket).then((response) => {
                if(response.status === "success" && response.response >= 0) {
                    state.wirelessSocketList.push(wirelessSocket);
        
                    var visibleWirelessSocketList = state.selectedArea.filter === "" ? state.wirelessSocketList : state.wirelessSocketList.filter(x => x.area === state.selectedArea.filter);
                    state.visibleWirelessSocketList = visibleWirelessSocketList;
        
                    state.selectedWirelessSocket = wirelessSocket;
                } else {
                    // eslint-disable-next-line
                    console.error(JSON.stringify(response));
                }
            });
        },
        SAVE_WIRELESS_SOCKET(state, wirelessSocket) {
            axiosService.post("wireless_socket", wirelessSocket).then((response) => {
                if(response.status === "success"  && response.response === 0) {
                    var wirelessSocketList = state.wirelessSocketList;
                    var index = wirelessSocketList.map(x => x.id).indexOf(wirelessSocket.id);
                    wirelessSocketList[index] = wirelessSocket;

                    state.wirelessSocketList = wirelessSocketList;
        
                    var visibleWirelessSocketList = state.selectedArea.filter === "" ? state.wirelessSocketList : state.wirelessSocketList.filter(x => x.area === state.selectedArea.filter);
                    state.visibleWirelessSocketList = visibleWirelessSocketList;
        
                    state.selectedWirelessSocket = wirelessSocket;
                } else {
                    // eslint-disable-next-line
                    console.error(JSON.stringify(response));
                }
            });
        },
        TOGGLE_WIRELESS_SOCKET_STATE(state, wirelessSocket) {
            wirelessSocket.state = !wirelessSocket.state;
            axiosService.post("wireless_socket", wirelessSocket).then((response) => {
                if(response.status === "success"  && response.response === 0) {
                    var wirelessSocketList = state.wirelessSocketList;
                    var index = wirelessSocketList.map(x => x.id).indexOf(wirelessSocket.id);
                    wirelessSocketList[index] = wirelessSocket;

                    state.wirelessSocketList = wirelessSocketList;
        
                    var visibleWirelessSocketList = state.selectedArea.filter === "" ? state.wirelessSocketList : state.wirelessSocketList.filter(x => x.area === state.selectedArea.filter);
                    state.visibleWirelessSocketList = visibleWirelessSocketList;
        
                    state.selectedWirelessSocket = wirelessSocket;
                } else {
                    // eslint-disable-next-line
                    console.error(JSON.stringify(response));
                }
            });
        },
        REMOVE_WIRELESS_SOCKET(state, wirelessSocket) {
            axiosService.delete("wireless_socket", wirelessSocket.id).then((response) => {
                if(response.status === "success"  && response.response === 0) {
                    var wirelessSocketList = state.wirelessSocketList;
                    wirelessSocketList.splice(wirelessSocketList.indexOf(wirelessSocket), 1);
                    state.wirelessSocketList = wirelessSocketList;
        
                    var visibleWirelessSocketList = state.selectedArea.filter === "" ? state.wirelessSocketList : state.wirelessSocketList.filter(x => x.area === state.selectedArea.filter);
                    state.visibleWirelessSocketList = visibleWirelessSocketList;
        
                    var selectedWirelessSocket = visibleWirelessSocketList.length > 0 ? visibleWirelessSocketList[0] : null;
                    state.selectedWirelessSocket = selectedWirelessSocket;
                } else {
                    // eslint-disable-next-line
                    console.error(JSON.stringify(response));
                }
            });
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
        saveArea({commit}, area) {
            commit('SAVE_AREA', area)
        },
        removeArea({commit}, area) {
            commit('REMOVE_AREA', area)
        },

        selectWirelessSocket({commit}, wirelessSocket) {
            commit('SELECT_WIRELESS_SOCKET', wirelessSocket)
        },
        addWirelessSocket({commit}) {
            commit('ADD_WIRELESS_SOCKET')
        },
        saveWirelessSocket({commit}, wirelessSocket) {
            commit('SAVE_WIRELESS_SOCKET', wirelessSocket)
        },
        toggleWirelessSocketState({commit}, wirelessSocket) {
            commit('TOGGLE_WIRELESS_SOCKET_STATE', wirelessSocket)
        },
        removeWirelessSocket({commit}, wirelessSocket) {
            commit('REMOVE_WIRELESS_SOCKET', wirelessSocket)
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