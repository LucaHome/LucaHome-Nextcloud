<?php

namespace OCA\LucaHome\Repositories;

use \OCA\LucaHome\Enums\ErrorCode;
use \OCA\LucaHome\Entities\Area;

interface IAreaRepository {

	/**
	 * @return array Area
	 */
	public function get();

	/**
     * @param int id
	 * @return array Area
	 */
	public function getForId(int $id);

	/**
	 * @param string userId
	 * @param Area area
	 * @return ErrorCode Success or failure of action
	 */
	public function add($userId, Area $area);
    
    /**
	 * @param string userId
	 * @param Area area
	 * @return ErrorCode Success or failure of action
	 */
    public function update($userId, Area $area);
    
	/**
	 * @param string userId UserId
	 * @param int id Area ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function delete($userId, int $id);
}