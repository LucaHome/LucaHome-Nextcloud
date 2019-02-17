'use strict'

import Vue from 'vue'
import Vuex from 'vuex'
import Requests from '../services/requests'

Vue.use(Vuex)

const state = {
    areas: [],
    areaSelected: null
}

const getters = {
    areas: state => state.areas,
    areaSelected: state => state.areaSelected
}

const mutations = {
    /**
     * Stores all available areas in the state
     *
     * @param {Object} state The store data
     * @param {Object} payload The collections payload
     */
    setAreas(state, payload) {
        state.areas = payload.areas;
    },

    /**
     * Stores selected area in the state
     *
     * @param {Object} state The store data
     * @param {Object} payload The collections payload
     */
    setAreaSelected(state, payload) {
        state.areaSelected = payload.area;
    },

    /**
     * Adds the area to the list of the state
     *
     * @param {Object} state The store data
     * @param {Object} payload The collections payload
     */
    addArea(state, payload) {
        state.areas.push(payload.area);
        state.areaSelected = payload.area;
    },

    /**
     * Updates the area in the list of the state
     *
     * @param {Object} state The store data
     * @param {Object} payload The collections payload
     */
    updateArea(state, payload) {
        var areas = state.areas;
        var index = areas.map(x => x.id).indexOf(payload.area.id);
        areas[index] = payload.area;
        state.areas = areas;
        state.areaSelected = payload.area;
    },

    /**
     * Deletes the area from the list of the state
     *
     * @param {Object} state The store data
     * @param {Object} payload The collections payload
     */
    deleteArea(state, payload) {
        var areas = state.areas;
        areas.splice(areas.indexOf(payload.area), 1);
        state.areas = areas;
        var areaSelected = areas.length > 0 ? areas[0] : null;
        state.areaSelected = areaSelected;
    }
}

const actions = {
    /**
     * Requests all areas from the server
     *
     * @param {Object} commit The store mutations
     * @returns {Promise}
     */
    loadAreas({commit}) {
        return new Promise(function (resolve) {
            Requests.get(OC.generateUrl('apps/lucahome/api/v1/area'))
                .then(response => {
                    commit('setAreas', {
                        areas: response.data
                    });
                    resolve();
                });
        });
    },

    /**
     * Selects an area
     *
     * @param {Object} commit The store mutations
     * @param {Object} area The selected area
     * @returns {Promise}
     */
    selectWirelessSocket({commit}, area) {
        commit('setAreaSelected', {
            area: area
        });
        resolve();
    },

    /**
     * Adds an area
     *
     * @param {Object} commit The store mutations
     * @returns {Promise}
     */
    addArea({commit}) {
        var area = {
            id: -1,
            name: "",
            filter: ""
        };

        return new Promise(function (resolve) {
            Requests.put(OC.generateUrl('apps/lucahome/api/v1/area'), area)
                .then(response => {
                    if(response.status === "success" && response.data >= 0) {
                        area.id = response.data;
                        commit('addArea', {
                            area: area
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
     * Updates an area
     *
     * @param {Object} commit The store mutations
     * @param {Object} area The selected area
     * @returns {Promise}
     */
    updateArea({commit}, area) {
        return new Promise(function (resolve) {
            Requests.post(OC.generateUrl('apps/lucahome/api/v1/area'), area)
                .then(response => {
                    if(response.status === "success" && response.data === 0) {
                        commit('updateArea', {
                            area: area
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
     * Deletes an area
     *
     * @param {Object} commit The store mutations
     * @param {Object} area The selected area
     * @returns {Promise}
     */
    deleteArea({commit}, area) {
        return new Promise(function (resolve) {
            Requests.delete(OC.generateUrl('apps/lucahome/api/v1/area'), area.id)
                .then(response => {
                    if(response.status === "success" && response.data === 0) {
                        commit('deleteArea', {
                            area: area
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