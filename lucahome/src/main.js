import Vue from 'vue'
import App from './App.vue'

import store from './store/store'

import VueMaterial from 'vue-material'
import Vuelidate from 'vuelidate'

import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default-dark.css'


// CSP config for webpack dynamic chunk loading
// eslint-disable-next-line
__webpack_nonce__ = btoa(OC.requestToken)

// Correct the root of the app for chunk loading
// OC.linkTo matches the apps folders
// OC.generateUrl ensure the index.php (or not)
// We do not want the index.php since we're loading files
// eslint-disable-next-line
__webpack_public_path__ = OC.linkTo('lucahome', 'js/')

Vue.use(VueMaterial)
Vue.use(Vuelidate)

if (!OCA.LucaHome) {
	/**
	 * @namespace OCA.LucaHome
	 */
	OCA.LucaHome = {}
}

Vue.prototype.OC = OC
Vue.prototype.OCA = OCA

OCA.LucaHome.App = new Vue({
	el: '.app-lucahome',
	store,
	data: function () {},
	mounted: function () {},
	beforeMount() {
		this.$store.dispatch('loadAreas')
		this.$store.dispatch('loadWirelessSockets')
	},
	methods: {},
	render: h => h(App)
})