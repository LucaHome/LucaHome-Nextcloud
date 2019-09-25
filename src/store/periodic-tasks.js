'use strict'

import Vue from 'vue'
import Vuex from 'vuex'
import Requests from '@services/requests'
import { convertNumberResponse, convertPeriodicTaskLoadResponse } from '@utils/converter.utils'

Vue.use(Vuex)

const state = {
    periodicTasks: [],
    periodicTaskSelected: null,
    periodicTaskInEdit: false
}

const getters = {
    periodicTasks: state => state.periodicTasks,
    periodicTaskSelected: state => state.periodicTaskSelected,
    periodicTaskInEdit: state => state.periodicTaskInEdit
}

const mutations = {
    /**
     * Stores flag for periodicTaskInEdit in the state
     *
     * @param {Object} state The store data
     * @param {Object} payload The collections payload
     */
    setPeriodicTaskInEdit(state, payload) {
        state.periodicTaskInEdit = payload.periodicTaskInEdit;
    },

    /**
     * Stores all available periodicTasks in the state
     *
     * @param {Object} state The store data
     * @param {Object} payload The collections payload
     */
    setPeriodicTasks(state, payload) {
        state.periodicTasks = payload.periodicTasks;
        if (!state.periodicTaskInEdit && (!state.periodicTaskSelected || state.periodicTasks.filter(x => x.id == state.periodicTaskSelected.id).length === 0)) {
            state.periodicTaskSelected = state.periodicTasks.length > 0 ? state.periodicTasks[0] : null;
        }
    },

    /**
     * Stores selected periodicTask in the state
     *
     * @param {Object} state The store data
     * @param {Object} payload The collections payload
     */
    setPeriodicTaskSelected(state, payload) {
        state.periodicTaskSelected = payload.periodicTask;
    },

    /**
     * Adds the periodicTask to the list of the state
     *
     * @param {Object} state The store data
     * @param {Object} payload The collections payload
     */
    addPeriodicTask(state, payload) {
        state.periodicTasks.push(payload.periodicTask);
        state.periodicTaskSelected = payload.periodicTask;
    },

    /**
     * Updates the periodicTask in the list of the state
     *
     * @param {Object} state The store data
     * @param {Object} payload The collections payload
     */
    updatePeriodicTask(state, payload) {
        var periodicTasks = state.periodicTasks;
        var index = periodicTasks.map(x => x.id).indexOf(payload.periodicTask.id);
        periodicTasks[index] = payload.periodicTask;
        state.periodicTasks = periodicTasks;
        state.periodicTaskSelected = payload.periodicTask;
    },

    /**
     * Deletes the periodicTask from the list of the state
     *
     * @param {Object} state The store data
     * @param {Object} payload The collections payload
     */
    deletePeriodicTask(state, payload) {
        var periodicTasks = state.periodicTasks;
        periodicTasks.splice(periodicTasks.indexOf(payload.periodicTask), 1);
        state.periodicTasks = periodicTasks;
        var periodicTaskSelected = periodicTasks.length > 0 ? periodicTasks[0] : null;
        state.periodicTaskSelected = periodicTaskSelected;
    }
}

const actions = {
    /**
     * Set periodicTaskInEdit
     *
     * @param {Object} commit The store mutations
     * @param {Object} periodicTaskInEdit The periodicTaskInEdit
     * @returns {Promise}
     */
    setPeriodicTaskInEdit({ commit }, periodicTaskInEdit) {
        commit('setPeriodicTaskInEdit', { periodicTaskInEdit: periodicTaskInEdit });
    },

    /**
     * Requests all periodicTasks from the server
     *
     * @param {Object} commit The store mutations
     * @returns {Promise}
     */
    loadPeriodicTasks({ commit }) {
        return new Promise(function (resolve) {
            Requests.get('periodic_task')
                .then(response => {
                    response = convertPeriodicTaskLoadResponse(response);

                    if (response.data === false) {
                        // eslint-disable-next-line
                        console.error(JSON.stringify(response));
                        commit('setPeriodicTasks', { periodicTasks: [] });
                    } else {
                        commit('setPeriodicTasks', { periodicTasks: !!response.data ? response.data : [] });
                    }

                    resolve();
                });
        });
    },

    /**
     * Selects an periodicTask
     *
     * @param {Object} commit The store mutations
     * @param {Object} periodicTask The selected periodicTask
     * @returns {Promise}
     */
    selectPeriodicTask({ commit }, periodicTask) {
        commit('setPeriodicTaskSelected', { periodicTask: periodicTask });
    },

    /**
     * Adds a periodicTask
     *
     * @param {Object} commit The store mutations
     * @param {Object} periodicTask The selected periodicTask
     * @returns {Promise}
     */
    addPeriodicTask({ commit }, periodicTask) {
        return new Promise(function (resolve) {
            Requests.post('periodic_task', periodicTask)
                .then(response => {
                    response = convertNumberResponse(response);

                    if (response.data === false) {
                        // eslint-disable-next-line
                        console.error(JSON.stringify(response));
                    } else {
                        if (response.status === "success" && response.data >= 0) {
                            periodicTask.id = response.data;
                            commit('addPeriodicTask', { periodicTask: periodicTask });
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
     * Updates a periodicTask
     *
     * @param {Object} commit The store mutations
     * @param {Object} periodicTask The selected periodicTask
     * @returns {Promise}
     */
    updatePeriodicTask({ commit }, periodicTask) {
        return new Promise(function (resolve) {
            Requests.put('periodic_task', periodicTask)
                .then(response => {
                    response = convertNumberResponse(response);

                    if (response.data === false) {
                        // eslint-disable-next-line
                        console.error(JSON.stringify(response));
                    } else {
                        if (response.status === "success" && response.data === 0) {
                            commit('updatePeriodicTask', { periodicTask: periodicTask });
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
     * Deletes a periodicTask
     *
     * @param {Object} commit The store mutations
     * @param {Object} periodicTask The selected periodicTask
     * @returns {Promise}
     */
    deletePeriodicTask({ commit }, periodicTask) {
        return new Promise(function (resolve) {
            Requests.delete('periodic_task', periodicTask.id)
                .then(response => {
                    response = convertNumberResponse(response);

                    if (response.data === false) {
                        // eslint-disable-next-line
                        console.error(JSON.stringify(response));
                    } else {
                        if (response.status === "success" && response.data === 0) {
                            commit('deletePeriodicTask', { periodicTask: periodicTask });
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