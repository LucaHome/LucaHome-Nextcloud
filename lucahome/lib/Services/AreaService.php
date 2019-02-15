<?php

namespace OCA\LucaHome\Services;

use \OC\User\Manager;
use \OCA\LucaHome\Enums\ErrorCode;
use \OCA\LucaHome\Entities\Area;
use \OCA\LucaHome\Repositories\AreaRepository;
use OCP\ILogger;

class AreaService implements IAreaService {

	/** @var Manager  */
    private $userManager;
    
	/** @var ILogger */
	private $logger;

	/** @var AreaRepository */
	private $repository;

	public function __construct(Manager $userManager, ILogger $logger, AreaRepository $repository) {
		$this->userManager = $userManager;
		$this->logger = $logger;
		$this->repository = $repository;
    }
    
	/**
	 * @brief returns all areas
     * @param string userId
	 * @return array Area
	 */
	public function get($userId = null) {
        $errorCode = validateUserId($userId);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }

        return $this->repository->get();
    }

	/**
     * @brief returns single area for the id and userId
     * @param int id
     * @param string userId
	 * @return array Area
	 */
	public function getForId(int $id, $userId = null) {
        $errorCode = validateUserId($userId);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }

        return $this->respository->getForId($id);
    }

	/**
	 * Add an Area
	 * @param Area area
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
	public function add(Area $area, $userId = null) {
        $errorCode = validateUserId($userId);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }

        return $this->repository->add($userId, $area);
    }
    
    /**
	 * Update an Area
	 * @param Area area
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
    public function update(Area $area, $userId = null) {
        $errorCode = validateUserId($userId);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }

        return $this->repository->update($userId, $area);
    }
    
	/**
	 * @brief Delete Area with specific id
	 * @param int $id Area ID to delete
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(int $id, $userId = null) {
        $errorCode = validateUserId($userId);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }

        return $this->repository->delete($userId, $id);
    }

	/**
	 * @brief Checks if userId is valid
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
    private function validateUserId($userId = null) {
        if ($userId === null) {
			$this->logger->warn("No userId provided", ['app' => 'lucahome']);
			return ErrorCode::InvalidUserNull;
		} else {
			if ($this->userManager->userExists($userId) === false) {
                $this->logger->warn("UserId does not exist", ['app' => 'lucahome']);
				return ErrorCode::UserDoesNotExist;
			}
        }
        
        return ErrorCode::NoError;
    }
}