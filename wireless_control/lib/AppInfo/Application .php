<?php
/**
* WirelessControl
*
* @author Jonas Schubert
* @copyright 2019 Jonas Schubert <guepardoapps@gmail.com>
*
* MIT License
* Copyright (c) 2019 GuepardoApps (Jonas Schubert)
* Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

namespace OCA\WirelessControl\AppInfo;

use OCA\WirelessControl\Adapter\PiAdapter;
use OCA\WirelessControl\Controller\AreaApiController;
use OCA\WirelessControl\Controller\AreaController;
use OCA\WirelessControl\Controller\PageController;
use OCA\WirelessControl\Controller\PingApiController;
use OCA\WirelessControl\Controller\SettingsController;
use OCA\WirelessControl\Controller\WirelessSocketApiController;
use OCA\WirelessControl\Controller\WirelessSocketController;
use OCA\WirelessControl\Repositories\AreaRepository;
use OCA\WirelessControl\Repositories\WirelessSocketRepository;
use OCA\WirelessControl\Services\AreaService;
use OCA\WirelessControl\Services\SettingsService;
use OCA\WirelessControl\Services\WirelessSocketService;
use OCP\AppFramework\App;
use OCP\AppFramework\IAppContainer;
use OCP\IURLGenerator;
use OCP\INavigationManager;

class Application extends App {

	public function __construct (array $urlParams=array()) {
		parent::__construct('WirelessControl', $urlParams);

		$container = $this->getContainer();

		/**
		 * Controller
		 */
		$container->registerService('AreaApiController', function(IAppContainer $c) {
			return new AreaApiController(
				$c->query('AppName'),
				$c->query('Request'),
				$c->query('AreaService')
			);
		});

		$container->registerService('AreaController', function(IAppContainer $c) {
			return new AreaController(
				$c->query('AppName'),
				$c->query('Request'),
				$c->query('AreaService')
			);
		});

		$container->registerService('PageController', function(IAppContainer $c) {
			return new PageController(
				$c->query('AppName'),
				$c->query('Request'),
				$c->query('ServerContainer')->getConfig()
			);
		});

		$container->registerService('PingApiController', function(IAppContainer $c) {
			return new PingApiController(
				$c->query('AppName'),
				$c->query('Request')
			);
		});

		$container->registerService('SettingsController', function(IAppContainer $c) {
			return new SettingsController(
				$c->query('AppName'),
				$c->query('Request'),
				$c->query('SettingsService')
			);
		});

		$container->registerService('WirelessSocketApiController', function(IAppContainer $c) {
			return new WirelessSocketApiController(
				$c->query('AppName'),
				$c->query('Request'),
				$c->query('WirelessSocketService')
			);
		});

		$container->registerService('WirelessSocketController', function(IAppContainer $c) {
			return new WirelessSocketController(
				$c->query('AppName'),
				$c->query('Request'),
				$c->query('WirelessSocketService')
			);
		});

		/**
		 * Services
		 */

		$container->registerService('AreaService', function(IAppContainer $c) {
			return new AreaService(
				$c->query('UserId'),
				$c->query('AreaRepository')
			);
		});

		$container->registerService('SettingsService', function(IAppContainer $c) {
			return new SettingsService(
				$c->query('UserId'),
				$c->query('Settings'),
				$c->query('AppName')
			);
		});

		$container->registerService('WirelessSocketService', function(IAppContainer $c) {
			return new WirelessSocketService(
				$c->query('UserId'),
				$c->query('Settings'),
				$c->query('AppName'),
				$c->query('PiAdapter'),
				$c->query('WirelessSocketRepository')
			);
		});

		/**
		 * Repositories
		 */

		$container->registerService('AreaRepository', function(IAppContainer $c) {
			return new AreaRepository(
				$c->query('ServerContainer')->getDatabaseConnection()
			);
		});

		$container->registerService('WirelessSocketRepository', function(IAppContainer $c) {
			return new WirelessSocketRepository(
				$c->query('ServerContainer')->getDatabaseConnection()
			);
		});

		/**
		 * Adapter
		 */

		$container->registerService('PiAdapter', function(IAppContainer $c) {
			return new PiAdapter();
		});

		/**
		 * Core
		 */
		$container->registerService('UserId', function(IAppContainer $c) {
			$user = $c->query('ServerContainer')->getUserSession()->getUser();
			return ($user) ? $user->getUID() : '';
		});

		$container->registerService('Settings', function(IAppContainer $c) {
			return $c->query('ServerContainer')->getConfig();
		});
	}

	public function registerNavigationEntry() {
		$container = $this->getContainer();
		$container->query(INavigationManager::class)->add(function() use ($container) {
			$urlGenerator = $container->query(IURLGenerator::class);
			return [
				'id' => 'wirelesscontrol',
				'order' => 10,
				'href' => $urlGenerator->linkToRoute('wirelesscontrol.page.index'),
				'icon' => $urlGenerator->imagePath('wirelesscontrol', 'app.svg'),
				'name' => 'Wireless Control',
			];
		});
	}
}
