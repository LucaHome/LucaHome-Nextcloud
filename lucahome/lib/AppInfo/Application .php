<?php
/**
* Nextcloud - LucaHome
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

namespace OCA\LucaHome\AppInfo;

use OCA\LucaHome\Adapter\PiAdapter;
use OCA\LucaHome\Controller\AreaController;
use OCA\LucaHome\Controller\PageController;
use OCA\LucaHome\Controller\SettingsController;
use OCA\LucaHome\Controller\WirelessSocketController;
use OCA\LucaHome\Repositories\AreaRepository;
use OCA\LucaHome\Repositories\WirelessSocketRepository;
use OCA\LucaHome\Services\AreaService;
use OCA\LucaHome\Services\SettingsService;
use OCA\LucaHome\Services\WirelessSocketService;
use OCP\AppFramework\App;
use OCP\AppFramework\IAppContainer;
use OCP\IURLGenerator;
use OCP\INavigationManager;

class Application extends App {

	public function __construct (array $urlParams=array()) {
		parent::__construct('LucaHome', $urlParams);

		$container = $this->getContainer();

		/**
		 * Controller
		 */
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

		$container->registerService('SettingsController', function(IAppContainer $c) {
			return new SettingsController(
				$c->query('AppName'),
				$c->query('Request'),
				$c->query('SettingsService')
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
				'id' => 'lucahome',
				'order' => 10,
				'href' => $urlGenerator->linkToRoute('lucahome.page.index'),
				'icon' => $urlGenerator->imagePath('lucahome', 'app.svg'),
				'name' => 'Luca Home',
			];
		});
	}
}
