<?php

namespace OCA\LucaHome\Controller;

use \OCP\AppFramework\Controller;
use \OCP\AppFramework\Http\TemplateResponse;
use \OCP\IRequest;
use \OCP\IUserSession;
use \OCP\IConfig;

/**
 * Controller class for main page.
 */
class PageController extends Controller {

	/**
	 * @var IUserSession
	 */
	private $userSession;

	/**
	 * @var IConfig
	 */
	private $config;

	/**
	 * @param string $appName
	 * @param IRequest $request an instance of the request
	 * @param IUserSession $userSession
	 * @param IConfig $config
	 */
	public function __construct(string $appName, IRequest $request, IUserSession $userSession, IConfig $config) {
		parent::__construct($appName, $request);
		$this->userSession = $userSession;
		$this->config = $config;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 *
	 * @return TemplateResponse
	 */
	public function index():TemplateResponse {
		\OCP\Util::connectHook('\OCP\Config', 'js', $this, 'addJavaScriptVariablesForIndex');
		return new TemplateResponse('lucahome', 'index');
	}

	/**
	 * Add parameters to javascript for user sites
	 *
	 * @param array $array
	 */
	public function addJavaScriptVariablesForIndex(array $array) {
		$user = $this->userSession->getUser();
		if ($user === null) {
			return;
		}
		$appversion = $this->config->getAppValue($this->appName, 'installed_version');
		$array['array']['oca_lucahome'] = \json_encode([
			'versionstring' => $appversion,
		]);
	}
}