<?php

namespace OCA\LucaHome\Services;

use \OCA\LucaHome\Enums\ErrorCode;
use \OCA\LucaHome\Entities\Area;
use \OCA\LucaHome\Repositories\AreaRepository;

interface IAreaService {

	/**
	 * @return array Area
	 */
	public function get();

	/**
	 * @param Area area
	 * @return ErrorCode Success or failure of action
	 */
	public function add(Area $area);
    
    /**
	 * @param Area area
	 * @return ErrorCode Success or failure of action
	 */
    public function update(Area $area);
    
	/**
	 * @param int id Area ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(int $id);
}