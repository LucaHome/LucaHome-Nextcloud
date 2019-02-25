import Vue from 'vue'
import App from './App.vue'

import store from './store'

import VueMaterial from 'vue-material'
import Vuelidate from 'vuelidate'

import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default-dark.css'

Vue.use(VueMaterial)
Vue.use(Vuelidate)

export default new Vue({
	el: '#app',
	store,
	beforeMount() {
		this.$store.dispatch('loadAreas')
		this.$store.dispatch('loadWirelessSockets')
	},
	render: h => h(App)
})
