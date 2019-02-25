<?php

namespace OCA\LucaHome\Controller;

use OCA\LucaHome\Entities\WirelessSocket;
use OCA\LucaHome\Services\WirelessSocketService;
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
    public function show($id) {
		return $this->generateResponse("error", function () {
			return "Not implemented";
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
	 */
	public function create($name, $code, $area, $state, $description, $icon) {
		$wirelessSocket = new WirelessSocket();
		$wirelessSocket->id = -1;
		$wirelessSocket->name = $name;
		$wirelessSocket->code = $code;
		$wirelessSocket->area = $area;
		$wirelessSocket->state = $state;
		$wirelessSocket->description = $description;
		$wirelessSocket->icon = $icon;

		return $this->generateResponse("success", function () {
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
	 */
	public function update($id, $name, $code, $area, $state, $description, $icon) {
		$wirelessSocket = new WirelessSocket();
		$wirelessSocket->id = $id;
		$wirelessSocket->name = $name;
		$wirelessSocket->code = $code;
		$wirelessSocket->area = $area;
		$wirelessSocket->state = $state;
		$wirelessSocket->description = $description;
		$wirelessSocket->icon = $icon;

		return $this->generateResponse("success", function () {
			return $this->service->update($wirelessSocket);
		}, '');
    }
    
	/**
     * @NoAdminRequired
     * @NoCSRFRequired
	 * 
     * @param int $id
	 */
	public function destroy($id) {
		return $this->generateResponse("success", function () {
			return $this->service->delete($id);
		}, '');
    }
}