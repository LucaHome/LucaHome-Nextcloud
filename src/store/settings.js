'use strict'

import Vue from 'vue'
import Vuex from 'vuex'
import Requests from '@services/requests'

Vue.use(Vuex)

const state = {
	settings: {}
}

const getters = {
	/**
	 * Returns the sort order how to sort areas
	 *
	 * @param {Object} state The store data
	 * @returns {String} The sort order
	 */
	sortOrderArea: (state) => state.settings.sortOrderArea,

	/**
	 * Returns the sort direction how to sort areas
	 *
	 * @param {Object} state The store data
	 * @returns {String} The sort direction
	 */
    sortDirectionArea: (state) => state.settings.sortDirectionArea,
    
	/**
	 * Returns the sort order how to sort wirelessSockets
	 *
	 * @param {Object} state The store data
	 * @returns {String} The sort order
	 */
	sortOrderWirelessSocket: (state) => state.settings.sortOrderWirelessSocket,

	/**
	 * Returns the sort direction how to sort wirelessSockets
	 *
	 * @param {Object} state The store data
	 * @returns {String} The sort direction
	 */
	sortDirectionWirelessSocket: (state) => state.settings.sortDirectionWirelessSocket,

	/**
	 * Returns the gpio pin to send from
	 *
	 * @param {Object} state The store data
	 * @returns {Number} The pin
	 */
	wirelessSocketGpioPin: (state) => state.settings.wirelessSocketGpioPin
}

const mutations = {
	/**
	 * Sets all settings
	 *
	 * @param {Object} state Default state
	 * @param {Object} payload The settings object
	 */
	setSettings(state, payload) {
		state.settings = payload.settings
	},

	/**
	 * Sets a setting value
	 *
	 * @param {Object} state Default state
	 * @param {Object} payload The setting object
	 */
	setSetting(state, payload) {
		state.settings[payload.type] = payload.value
	}
}

const actions = {
	/**
	 * Writes a setting to the server
	 *
	 * @param {Object} context The store context
	 * @param {Object} payload The setting to save
	 * @returns {Promise}
	 */
	setSetting(context, payload) {
		context.commit('setSetting', payload)
		// TODO
		//return new Promise(function() {
		//	Requests.post(OC.generateUrl('apps/lucahome/settings/{type}/{value}', payload), {})
		//})
	},

	/**
	 * Requests all app settings from the server
	 *
	 * @param {Object} commit The store mutations
	 * @returns {Promise}
	 */
	loadSettings({ commit }) {
		return new Promise(function(resolve) {
			//Requests.get(OC.generateUrl('apps/lucahome/settings'))
			Requests.get('apps/lucahome/settings')
				.then(response => {
					commit('setSettings', { settings: response.data })
					resolve()
				})
		})
	}
}

export default { state, getters, mutations, actions }