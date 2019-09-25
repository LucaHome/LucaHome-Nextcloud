'use strict'

import Vue from 'vue'
import Vuex from 'vuex'
import Requests from '@services/requests'
import { convertAreaLoadResponse, convertNumberResponse } from '@utils/converter.utils'

Vue.use(Vuex)

const state = {
    areas: [],
    areaSelected: null,
    areaInEdit: false
}

const getters = {
    areas: state => state.areas,
    areaSelected: state => state.areaSelected,
    areaInEdit: state => state.areaInEdit
}

const mutations = {
    /**
     * Stores flag for areaInEdit in the state
     *
     * @param {Object} state The store data
     * @param {Object} payload The collections payload
     */
    setAreaInEdit(state, payload) {
        state.areaInEdit = payload.areaInEdit;
    },

    /**
     * Stores all available areas in the state
     *
     * @param {Object} state The store data
     * @param {Object} payload The collections payload
     */
    setAreas(state, payload) {
        state.areas = payload.areas;
        if (!state.areaInEdit && (!state.areaSelected || state.areas.filter(x => x.id == state.areaSelected.id).length === 0)) {
            state.areaSelected = state.areas[0];
        }
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
     * Set areaInEdit
     *
     * @param {Object} commit The store mutations
     * @param {Object} areaInEdit The areaInEdit
     * @returns {Promise}
     */
    setAreaInEdit({ commit }, areaInEdit) {
        commit('setAreaInEdit', { areaInEdit: areaInEdit });
    },

    /**
     * Requests all areas from the server
     *
     * @param {Object} commit The store mutations
     * @returns {Promise}
     */
    loadAreas({ commit }) {
        return new Promise(function (resolve) {
            Requests.get('area')
                .then(response => {
                    response = convertAreaLoadResponse(response);

                    if (response.data === false) {
                        // eslint-disable-next-line
                        console.error(JSON.stringify(response));
                        commit('setAreas', { areas: [] });
                    } else {
                        commit('setAreas', { areas: !!response.data ? response.data : [] });
                    }

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
    selectArea({ commit }, area) {
        commit('setAreaSelected', { area: area });
    },

    /**
     * Adds an area
     *
     * @param {Object} commit The store mutations
     * @returns {Promise}
     */
    addArea({ commit }) {
        var area = {
            id: this.getters.areas.length > 0 ? Math.max(...this.getters.areas.map(x => x.id)) + 1 : 0,
            name: "",
            filter: "",
            deletable: 1
        };

        return new Promise(function (resolve) {
            Requests.post('area', area)
                .then(response => {
                    response = convertNumberResponse(response);

                    if (response.data === false) {
                        // eslint-disable-next-line
                        console.error(JSON.stringify(response));
                    } else {
                        if (response.status === "success" && response.data >= 0) {
                            area.id = response.data;
                            commit('addArea', { area: area });
                        } else {
                            // eslint-disable-next-line
                            console.error(JSON.stringify(response));
                        }
                    }

                    resolve();
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
    updateArea({ commit }, area) {
        return new Promise(function (resolve) {
            Requests.put('area', area)
                .then(response => {
                    response = convertNumberResponse(response);

                    if (response.data === false) {
                        // eslint-disable-next-line
                        console.error(JSON.stringify(response));
                    } else {
                        if (response.status === "success" && response.data === 0) {
                            commit('updateArea', { area: area });
                        } else {
                            // eslint-disable-next-line
                            console.error(JSON.stringify(response));
                        }
                    }

                    resolve();
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
    deleteArea({ commit }, area) {
        return new Promise(function (resolve) {
            Requests.delete('area', area.id)
                .then(response => {
                    response = convertNumberResponse(response);

                    if (response.data === false) {
                        // eslint-disable-next-line
                        console.error(JSON.stringify(response));
                    } else {
                        if (response.status === "success" && response.data === 0) {
                            commit('deleteArea', { area: area });
                        } else {
                            // eslint-disable-next-line
                            console.error(JSON.stringify(response));
                        }
                    }

                    resolve();
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