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

use OCP\AppFramework\App;

class Application extends App {

	/**
	 * @param array $params
	 */
	public function __construct(array $params=[]) {
		parent::__construct('lucahome', $params);
    }
    
	/**
	 * Register navigation
	 */
	public function registerNavigation() {
		$appName = $this->getContainer()->getAppName();
		$server = $this->getContainer()->getServer();
		$urlGenerator = $server->getURLGenerator();
		$server->getNavigationManager()->add(function() use ($appName, $server, $urlGenerator) {
			return [
				'id' => $appName,
				'order' => 100,
				'href' => $urlGenerator->linkToRoute('lucahome.page.index'),
				'icon' => $urlGenerator->imagePath($appName, 'lucahome.svg'),
				'name' => $server->getL10N($appName)->t('LucaHome'),
			];
		});
	}
}