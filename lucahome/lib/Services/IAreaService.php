<?php

namespace OCA\LucaHome\Services;

use \OCA\LucaHome\Enums\ErrorCode;
use \OCA\LucaHome\Entities\Area;
use \OCA\LucaHome\Repositories\AreaRepository;

interface IAreaService {

	/**
     * @param string userId
	 * @return array Area
	 */
	public function get($userId = null);

	/**
     * @param int id
     * @param string userId
	 * @return array Area
	 */
	public function getForId(int $id, $userId = null);

	/**
	 * @param Area area
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
	public function add(Area $area, $userId = null);
    
    /**
	 * @param Area area
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
    public function update(Area $area, $userId = null);
    
	/**
	 * @param int id Area ID to delete
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(int $id, $userId = null);
}