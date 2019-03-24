<?php

namespace OCA\WirelessControl\Services;

use OCA\WirelessControl\Enums\ErrorCode;
use OCA\WirelessControl\Entities\Area;
use OCA\WirelessControl\Repositories\AreaRepository;

interface IAreaService {

	/**
	 * @return array Area
	 */
	public function get();

	/**
	 * @param int id Area ID to get
	 * @return Area Area
	 */
	public function getById(int $id);

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