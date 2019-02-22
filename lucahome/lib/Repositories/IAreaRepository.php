<?php

namespace OCA\LucaHome\Repositories;

use OCA\LucaHome\Enums\ErrorCode;
use OCA\LucaHome\Entities\Area;

interface IAreaRepository {

	/**
	 * @return array Area
	 */
	public function get();

	/**
	 * @param string userId
	 * @param Area area
	 * @return ErrorCode Success or failure of action
	 */
	public function add(string $userId, Area $area);
    
    /**
	 * @param string userId
	 * @param Area area
	 * @return ErrorCode Success or failure of action
	 */
    public function update(string $userId, Area $area);
    
	/**
	 * @param string userId UserId
	 * @param int id Area ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(string $userId, int $id);
}