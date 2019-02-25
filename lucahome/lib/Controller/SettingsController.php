<?php

namespace OCA\LucaHome\Controller;

use OCA\LucaHome\Services\SettingsService;
use OCP\AppFramework\Controller;
use OCP\IRequest;

class SettingsController extends Controller {
	
	/**
	 * @var SettingsService
	 */
	private $settingsService;

	use Response;

	/**
	 * @param string $appName
	 * @param IRequest $request an instance of the request
	 * @param SettingsService $settingsService
	 */
	public function __construct(string $appName, IRequest $request, SettingsService $settingsService){
		parent::__construct($appName, $request);
		$this->settingsService = $settingsService;
	}

	/**
	 * @NoAdminRequired
	 */
	public function get() {
		return $this->generateResponse("success", function () {
			return $this->settingsService->get();
		}, '');
	}

	/**
	 * @NoAdminRequired
	 */
	public function set($setting, $value) {
		return $this->generateResponse("success", function () use ($setting, $value) {
			return $this->settingsService->set($setting, $value);
		}, '');
	}
}