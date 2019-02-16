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
     * @param int id
	 * @return JSONResponse
	 */
	public function getForId(int $id);

	/**
	 * @param string name
	 * @param string code
	 * @param string area
	 * @param string description
	 * @return JSONResponse
	 */
	public function add($name, $code, $area, $description);
    
    /**
	 * @param int id
	 * @param string name
	 * @param string code
	 * @param string area
	 * @param string description
	 * @return JSONResponse
	 */
    public function update(int $id, $name, $code, $area, $description);
    
	/**
	 * @param int id
	 * @return JSONResponse
	 */
	public function delete(int $id);
}