<?php

namespace OCA\LucaHome\Controller\Rest;

use \OCA\LucaHome\Enums\ErrorCode;
use \OCA\LucaHome\Entities\WirelessSocket;
use \OCA\LucaHome\Services\WirelessSocketService;

interface IWirelessSocketController {

	/**
	 * @return JSONResponse
	 */
	public function get();

	/**
	 * @return JSONResponse
	 */
	public function getForUser();

	/**
     * @param int id
	 * @return JSONResponse
	 */
	public function getForId(int $id);

	/**
	 * @param string name
	 * @param string code
	 * @param string area
	 * @param string description
	 * @param int public
	 * @return JSONResponse
	 */
	public function add($name, $code, $area, $description, int $public);
    
    /**
	 * @param int id
	 * @param string name
	 * @param string code
	 * @param string area
	 * @param string description
	 * @param int public
	 * @return JSONResponse
	 */
    public function update(int $id, $name, $code, $area, $description, int $public);
    
    /**
	 * @param int id
	 * @param int newState
	 * @return JSONResponse
	 */
    public function setState(int $id, int $newState);
    
	/**
	 * @param int id
	 * @return JSONResponse
	 */
	public function delete(int $id);
}