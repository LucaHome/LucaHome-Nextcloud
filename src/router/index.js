import Vue from 'vue';
import Router from 'vue-router';
import { generateUrl } from 'nextcloud-server/dist/router';
import WirelessControl from '@views/WirelessControl';

Vue.use(Router)

export default new Router({
	mode: 'history',
	// if index.php is in the url AND we got this far, then it's working:
	// let's keep using index.php in the url
	base: generateUrl('/apps/wirelesscontrol', ''),
	linkActiveClass: 'active',
	routes: [{
		path: '/',
		component: WirelessControl,
		props: true,
		name: 'root',
		// always load default group
		redirect: {
			name: 'area',
			params: {
				selectedArea: t('wirelesscontrol', '')
			}
		},
		children: [{
				path: ':selectedArea',
				name: 'area',
				component: WirelessControl
			},
			{
				path: ':selectedArea/:selectedWirelessSocket',
				name: 'wireless_socket',
				component: WirelessControl
			}
		]
	}]
})
