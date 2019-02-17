<?php

namespace OCA\LucaHome\Services;

use \OCA\LucaHome\Enums\ErrorCode;
use \OCA\LucaHome\Entities\Area;
use \OCA\LucaHome\Repositories\AreaRepository;

class AreaService implements IAreaService {

	/** 
	 * @var string  
	 * */
    private $userId;

	/**
	 * @var AreaRepository 
	 * */
	private $repository;

	/**
	 * @param string $userId
	 * @param AreaRepository $repository
	 */
	public function __construct(string $userId, AreaRepository $repository) {
		$this->userId = $userId;
		$this->repository = $repository;
    }
    
	/**
	 * @brief returns all areas
	 * @return array Area
	 */
	public function get() {
        return $this->repository->get();
    }

	/**
	 * Add an Area
	 * @param Area area
	 * @return ErrorCode Success or failure of action
	 */
	public function add(Area $area) {
        return $this->repository->add($this->userId, $area);
    }
    
    /**
	 * Update an Area
	 * @param Area area
	 * @return ErrorCode Success or failure of action
	 */
    public function update(Area $area) {
        return $this->repository->update($this->userId, $area);
    }
    
	/**
	 * @brief Delete Area with specific id
	 * @param int $id Area ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(int $id) {
        return $this->repository->delete($this->userId, $id);
    }
}