import Vue from 'vue';
import Router from 'vue-router';
import { generateUrl } from 'nextcloud-server/dist/router';
import LucaHome from '../views/LucaHome';

Vue.use(Router)

export default new Router({
	mode: 'history',
	// if index.php is in the url AND we got this far, then it's working:
	// let's keep using index.php in the url
	base: generateUrl('/apps/lucahome', ''),
	linkActiveClass: 'active',
	routes: [{
		path: '/',
		component: LucaHome,
		props: true,
		name: 'root',
		// always load default group
		redirect: {
			name: 'area',
			params: {
				selectedArea: t('lucahome', 'All')
			}
		},
		children: [{
				path: ':selectedArea',
				name: 'area',
				component: LucaHome
			},
			{
				path: ':selectedArea/:selectedWirelessSocket',
				name: 'wireless_socket',
				component: LucaHome
			}
		]
	}]
})
