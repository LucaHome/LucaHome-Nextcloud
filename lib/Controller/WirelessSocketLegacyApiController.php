<?php

namespace OCA\WirelessControl\Controller;

use OCA\WirelessControl\Entities\WirelessSocketLegacy;
use OCA\WirelessControl\Services\WirelessSocketLegacyService;
use OCP\AppFramework\ApiController;
use OCP\IRequest;

class WirelessSocketLegacyApiController extends ApiController
{
	/** @var WirelessSocketLegacyService */
	private $service;

	use Response;

	/**
	 * @param string $appName
	 * @param IRequest $request
	 * @param WirelessSocketLegacyService $service
	 */
	public function __construct(string $appName, IRequest $request, WirelessSocketLegacyService $service)
	{
		parent::__construct($appName, $request);
		$this->service = $service;
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function index()
	{
		return $this->generateResponse("success", function () {
			return $this->service->get();
		}, '');
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 *
	 * @param int $id
	 */
	public function show(int $id)
	{
		return $this->generateResponse("success", function () use ($id) {
			return $this->service->getById($id);
		}, '');
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 * 
	 * @param string name
	 * @param string code
	 * @param string area
	 * @param int state
	 * @param string description
	 * @param string icon
	 * @param int deletable
	 */
	public function create(string $name, string $code, string $area, int $state, string $description, string $icon, int $deletable)
	{
		$wirelessSocket = new WirelessSocketLegacy();
		$wirelessSocket->id = -1;
		$wirelessSocket->name = $name;
		$wirelessSocket->code = $code;
		$wirelessSocket->area = $area;
		$wirelessSocket->state = $state;
		$wirelessSocket->description = $description;
		$wirelessSocket->icon = $icon;
		$wirelessSocket->deletable = $deletable;

		return $this->generateResponse("success", function () use ($wirelessSocket) {
			return $this->service->add($wirelessSocket);
		}, '');
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 * 
	 * @param int $id
	 * @param string name
	 * @param string code
	 * @param string area
	 * @param int state
	 * @param string description
	 * @param string icon
	 * @param int deletable
	 */
	public function update(int $id, string $name, string $code, string $area, int $state, string $description, string $icon, int $deletable)
	{
		$wirelessSocket = new WirelessSocketLegacy();
		$wirelessSocket->id = $id;
		$wirelessSocket->name = $name;
		$wirelessSocket->code = $code;
		$wirelessSocket->area = $area;
		$wirelessSocket->state = $state;
		$wirelessSocket->description = $description;
		$wirelessSocket->icon = $icon;
		$wirelessSocket->deletable = $deletable;

		return $this->generateResponse("success", function () use ($wirelessSocket) {
			return $this->service->update($wirelessSocket);
		}, '');
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 * 
	 * @param int $id
	 */
	public function destroy(int $id)
	{
		return $this->generateResponse("success", function () use ($id) {
			return $this->service->delete($id);
		}, '');
	}
}
