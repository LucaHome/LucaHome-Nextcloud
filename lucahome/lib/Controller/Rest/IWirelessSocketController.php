<?php

namespace OCA\LucaHome\Controller\Rest;

use \OCA\LucaHome\Enums\ErrorCode;
use \OCA\LucaHome\Entities\WirelessSocket;
use \OCA\LucaHome\Services\WirelessSocketService;

interface IWirelessSocketController {

	/**
     * @param string userId
	 * @return JSONResponse
	 */
	public function get($userId = null);

	/**
     * @param string userId
	 * @return JSONResponse
	 */
	public function getForUser($userId = null);

	/**
	 * @param string name
	 * @param string code
	 * @param string area
	 * @param string description
	 * @param int public
	 * @param string userId
	 * @return JSONResponse
	 */
	public function addWirelessSocket($name, $code, $area, $description, int $public, $userId = null);
    
    /**
	 * @param int id
	 * @param string name
	 * @param string code
	 * @param string area
	 * @param string description
	 * @param int public
	 * @param string userId
	 * @return JSONResponse
	 */
    public function updateWirelessSocket(int $id, $name, $code, $area, $description, int $public, $userId = null);
    
    /**
	 * @param int id
	 * @param int newState
	 * @param string userId
	 * @return JSONResponse
	 */
    public function setWirelessSocketState(int $id, int $newState, $userId = null);
    
	/**
	 * @param int id
	 * @param string userId
	 * @return JSONResponse
	 */
	public function deleteWirelessSocket(int $id, $userId = null);
}