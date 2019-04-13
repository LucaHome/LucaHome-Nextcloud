'use strict'

import Vue from 'vue'
import Vuex from 'vuex'
import Requests from '../services/requests'
import Converter from '../utils/converter.utils'

Vue.use(Vuex)

const state = {
    wirelessSockets: [],
    wirelessSocketSelected: null,
    wirelessSocketInEdit: false
}

const getters = {
    wirelessSockets: state => state.wirelessSockets,
    wirelessSocketSelected: state => state.wirelessSocketSelected,
    wirelessSocketInEdit: state => state.wirelessSocketInEdit
}

const mutations = {
    /**
     * Stores flag for wirelessSocketInEdit in the state
     *
     * @param {Object} state The store data
     * @param {Object} payload The collections payload
     */
    setWirelessSocketInEdit(state, payload) {
        state.wirelessSocketInEdit = payload.wirelessSocketInEdit;
    },

    /**
     * Stores all available wireless sockets in the state
     *
     * @param {Object} state The store data
     * @param {Object} payload The collections payload
     */
    setWirelessSockets(state, payload) {
        state.wirelessSockets = payload.wirelessSockets;
        if(!state.wirelessSocketInEdit && (!state.wirelessSocketSelected || state.wirelessSockets.filter(x => x.id == state.wirelessSocketSelected.id).length === 0)) {
            state.wirelessSocketSelected = state.wirelessSockets.length > 0 ? state.wirelessSockets[0] : null;
        }
    },

    /**
     * Stores selected wireless socket in the state
     *
     * @param {Object} state The store data
     * @param {Object} payload The collections payload
     */
    setWirelessSocketSelected(state, payload) {
        state.wirelessSocketSelected = payload.wirelessSocket;
    },

    /**
     * Adds the wireless socket to the list of the state
     *
     * @param {Object} state The store data
     * @param {Object} payload The collections payload
     */
    addWirelessSocket(state, payload) {
        state.wirelessSockets.push(payload.wirelessSocket);
        state.wirelessSocketSelected = payload.wirelessSocket;
    },

    /**
     * Updates the wireless socket in the list of the state
     *
     * @param {Object} state The store data
     * @param {Object} payload The collections payload
     */
    updateWirelessSocket(state, payload) {
        var wirelessSockets = state.wirelessSockets;
        var index = wirelessSockets.map(x => x.id).indexOf(payload.wirelessSocket.id);
        wirelessSockets[index] = payload.wirelessSocket;
        state.wirelessSockets = wirelessSockets;
        state.wirelessSocketSelected = payload.wirelessSocket;
    },

    /**
     * Deletes the wireless socket from the list of the state
     *
     * @param {Object} state The store data
     * @param {Object} payload The collections payload
     */
    deleteWirelessSocket(state, payload) {
        var wirelessSockets = state.wirelessSockets;
        wirelessSockets.splice(wirelessSockets.indexOf(payload.wirelessSocket), 1);
        state.wirelessSockets = wirelessSockets;
        var wirelessSocketSelected = wirelessSockets.length > 0 ? wirelessSockets[0] : null;
        state.wirelessSocketSelected = wirelessSocketSelected;
    }
}

const actions = {
    /**
     * Set wirelessSocketInEdit
     *
     * @param {Object} commit The store mutations
     * @param {Object} wirelessSocketInEdit The wirelessSocketInEdit
     * @returns {Promise}
     */
    setWirelessSocketInEdit({ commit }, wirelessSocketInEdit) {
        commit('setWirelessSocketInEdit', {
            wirelessSocketInEdit: wirelessSocketInEdit
        });
    },

    /**
     * Requests all wireless sockets from the server
     *
     * @param {Object} commit The store mutations
     * @returns {Promise}
     */
    loadWirelessSockets({ commit }) {
        return new Promise(function (resolve) {
            Requests.get('wireless_socket')
                .then(response => {
                    response = Converter.convertWirelessSocketLoadResponse(response);

                    if(response.data === false){
                        // eslint-disable-next-line
                        console.error(JSON.stringify(response));
                        commit('setWirelessSockets', {
                            wirelessSockets: []
                        });
                    } else {
                        commit('setWirelessSockets', {
                            wirelessSockets: !!response.data ? response.data : []
                        });
                    }

                    resolve();
                });
        });
    },

    /**
     * Selects a wirelessSocket
     *
     * @param {Object} commit The store mutations
     * @param {Object} wirelessSocket The selected wireless socket
     * @returns {Promise}
     */
    selectWirelessSocket({ commit }, wirelessSocket) {
        commit('setWirelessSocketSelected', {
            wirelessSocket: wirelessSocket
        });
    },

    /**
     * Adds a wireless socket
     *
     * @param {Object} commit The store mutations
     * @param {String} area The area
     * @returns {Promise}
     */
    addWirelessSocket({ commit }, area) {
        var wirelessSocket = {
            id: this.getters.wirelessSockets.length > 0 ? Math.max(...this.getters.wirelessSockets.map(x => x.id)) + 1 : 0,
            name: "",
            code: "",
            area: area === "All" ? "" : area,
            state: 0,
            description: "",
            icon: "",
            deletable: 1
        };

        return new Promise(function (resolve) {
            Requests.post('wireless_socket', wirelessSocket)
                .then(response => {
                    response = Converter.convertNumberResponse(response);

                    if(response.data === false){
                        // eslint-disable-next-line
                        console.error(JSON.stringify(response));
                        return;
                    }

                    if (response.status === "success" && response.data >= 0) {
                        wirelessSocket.id = response.data;
                        commit('addWirelessSocket', {
                            wirelessSocket: wirelessSocket
                        });
                        resolve();
                    } else {
                        // eslint-disable-next-line
                        console.error(JSON.stringify(response));
                    }
                });
        });
    },

    /**
     * Updates a wireless socket
     *
     * @param {Object} commit The store mutations
     * @param {Object} wirelessSocket The selected wireless socket
     * @returns {Promise}
     */
    updateWirelessSocket({ commit }, wirelessSocket) {
        return new Promise(function (resolve) {
            Requests.put('wireless_socket', wirelessSocket)
                .then(response => {
                    response = Converter.convertNumberResponse(response);

                    if(response.data === false){
                        // eslint-disable-next-line
                        console.error(JSON.stringify(response));
                        return;
                    }

                    if (response.status === "success" && response.data === 0) {
                        commit('updateWirelessSocket', {
                            wirelessSocket: wirelessSocket
                        });
                        resolve();
                    } else {
                        // eslint-disable-next-line
                        console.error(JSON.stringify(response));
                    }
                });
        });
    },

    /**
     * Deletes a wireless socket
     *
     * @param {Object} commit The store mutations
     * @param {Object} wirelessSocket The selected wireless socket
     * @returns {Promise}
     */
    deleteWirelessSocket({ commit }, wirelessSocket) {
        return new Promise(function (resolve) {
            Requests.delete('wireless_socket', wirelessSocket.id)
                .then(response => {
                    response = Converter.convertNumberResponse(response);

                    if(response.data === false){
                        // eslint-disable-next-line
                        console.error(JSON.stringify(response));
                        return;
                    }

                    if (response.status === "success" && response.data === 0) {
                        commit('deleteWirelessSocket', {
                            wirelessSocket: wirelessSocket
                        });
                        resolve();
                    } else {
                        // eslint-disable-next-line
                        console.error(JSON.stringify(response));
                    }
                });
        });
    }
}

export default {
    state,
    getters,
    mutations,
    actions
}