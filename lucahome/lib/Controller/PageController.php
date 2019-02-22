<?php

namespace OCA\LucaHome\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\IRequest;

/**
 * Controller class for main page.
 */
class PageController extends Controller {

	/**
	 * @var String
	 */
	protected $appName;

	/**
	 * @var IConfig
	 */
	private $config;

	/**
	 * @param string $appName
	 * @param IRequest $request an instance of the request
	 * @param IConfig $config
	 */
	public function __construct(string $appName, IRequest $request, IConfig $config) {
		parent::__construct($appName, $request);
		$this->appName = $appName;
		$this->config = $config;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 *
	 * @return TemplateResponse
	 */
	public function index() {
		return new TemplateResponse('lucahome', 'index');  // templates/index.php
	}
}