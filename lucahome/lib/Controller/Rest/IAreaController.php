<?php

namespace OCA\LucaHome\Controller\Rest;

use \OCA\LucaHome\Enums\ErrorCode;
use \OCA\LucaHome\Entities\Area;
use \OCA\LucaHome\Services\AreaService;

interface IAreaController {

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
	 * @param string filter
	 * @return JSONResponse
	 */
	public function add($name, $filter);
    
    /**
	 * @param int id
	 * @param string name
	 * @param string filter
	 * @return JSONResponse
	 */
    public function update(int $id, $name, $filter);
    
	/**
	 * @param int id
	 * @return JSONResponse
	 */
	public function delete(int $id);
}