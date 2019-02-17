<?php

namespace OCA\LucaHome\Controller;

use \OCA\LucaHome\Entities\WirelessSocket;
use \OCA\LucaHome\Services\WirelessSocketService;
use \OCP\AppFramework\Controller;
use \OCP\IRequest;

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
	 * @brief returns all WirelessSockets
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function get() {
		return $this->generateResponse("success", function () {
			return $this->service->get();
		}, null);
    }
    
	/**
	 * @brief Add a WirelessSocket
	 * @param WirelessSocket wirelessSocket
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function add(WirelessSocket $wirelessSocket) {
		return $this->generateResponse("success", function () {
			return $this->service->add($wirelessSocket);
		}, null);
    }
    
	/**
	 * @brief Update a WirelessSocket
	 * @param WirelessSocket wirelessSocket
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function update(WirelessSocket $wirelessSocket) {
		return $this->generateResponse("success", function () {
			return $this->service->update($wirelessSocket);
		}, null);
    }
    
	/**
	 * @brief Delete a WirelessSocket
	 * @param int id
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function delete(int $id) {
		return $this->generateResponse("success", function () {
			return $this->service->delete($id);
		}, null);
    }
}