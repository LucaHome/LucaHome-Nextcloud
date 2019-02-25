import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'
import { sync } from 'vuex-router-sync'
import { generateFilePath } from 'nextcloud-server/dist/router'

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
__webpack_public_path__ = generateFilePath('lucahome', '', 'js/')

Vue.use(VueMaterial)
Vue.use(Vuelidate)

sync(store, router)

Vue.prototype.t = t
Vue.prototype.n = n
// eslint-disable-next-line
Vue.prototype.oc_onfig = oc_config
Vue.prototype.OC = OC
Vue.prototype.OCA = OCA

if (window.location.pathname.split('/')[1] === 'index.php' && oc_config.modRewriteWorking) {
	router.push({
		name: 'area',
		params: {
			selectedArea: t('lucahome', 'All')
		}
	})
}

export default new Vue({
	el: '#content',
	router,
	store,
	render: h => h(App)
})
