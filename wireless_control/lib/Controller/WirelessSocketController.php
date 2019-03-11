<?php

namespace OCA\WirelessControl\Controller;

use OCA\WirelessControl\Entities\WirelessSocket;
use OCA\WirelessControl\Services\WirelessSocketService;
use OCP\AppFramework\Controller;
use OCP\IRequest;

class WirelessSocketController extends Controller {

	/** @var WirelessSocketService */
	private $service;
	
	use Response;

	/**
	 * @param string $appName
	 * @param IRequest $request
	 * @param WirelessSocketService $service
	 */
	public function __construct(string $appName, IRequest $request, WirelessSocketService $service) {
		parent::__construct($appName, $request);
		$this->service = $service;
    }
    
	/**
     * @NoAdminRequired
     * @NoCSRFRequired
	 */
	public function index() {
		return $this->generateResponse("success", function () {
			return $this->service->get();
		}, '');
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     *
     * @param int $id
     */
    public function show(int $id) {
		return $this->generateResponse("success", function () use ($id) {
			return $this->service->getById($id);
		}, '');
    }
    
	/**
     * @NoAdminRequired
     * @NoCSRFRequired
	 * 
	 * @param string name
	 * @param string code
	 * @param string area
	 * @param int state
	 * @param string description
	 * @param string icon
	 * @param int deletable
	 */
	public function create(string $name, string $code, string $area, int $state, string $description, string $icon, int $deletable) {
		$wirelessSocket = new WirelessSocket();
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
     * @NoAdminRequired
     * @NoCSRFRequired
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
	public function update(int $id, string $name, string $code, string $area, int $state, string $description, string $icon, int $deletable) {
		$wirelessSocket = new WirelessSocket();
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
     * @NoAdminRequired
     * @NoCSRFRequired
	 * 
     * @param int $id
	 */
	public function destroy(int $id) {
		return $this->generateResponse("success", function () use ($id) {
			return $this->service->delete($id);
		}, '');
    }
}