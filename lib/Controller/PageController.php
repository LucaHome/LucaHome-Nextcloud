<?php

namespace OCA\WirelessControl\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\IRequest;

/**
 * Controller class for main page.
 */
class PageController extends Controller {

	/**
	 * @param string $appName
	 * @param IRequest $request an instance of the request
	 */
	public function __construct(string $appName, IRequest $request) {
		parent::__construct($appName, $request);
	}

	/**
	 * @NoAdminRequired
     * @NoCSRFRequired
	 *
	 * @return TemplateResponse
	 */
	public function index() {
		return new TemplateResponse('wirelesscontrol', 'index');  // templates/index.php
	}
}