<?php

namespace OCA\LucaHome\Services;

use \OC\User\Manager;
use \OCA\LucaHome\Adapter\PiAdapter;
use \OCA\LucaHome\Enums\ErrorCode;
use \OCA\LucaHome\Entities\WirelessSocket;
use \OCA\LucaHome\Repositories\WirelessSocketRepository;
use OCP\ILogger;

class WirelessSocketService implements IWirelessSocketService {

	/** @var Manager  */
    private $userManager;
    
	/** @var ILogger */
	private $logger;

	/** @var PiAdapter */
	private $piAdapter;

	/** @var WirelessSocketRepository */
	private $repository;

	public function __construct(Manager $userManager, ILogger $logger, PiAdapter $piAdapter, WirelessSocketRepository $repository) {
		$this->userManager = $userManager;
		$this->logger = $logger;
		$this->piAdapter = $piAdapter;
		$this->repository = $repository;
    }
    
	/**
	 * @brief returns all wireless sockets
     * @param string userId
	 * @return array WirelessSocket
	 */
	public function get($userId = null) {
        $errorCode = validateUserId($userId);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }

        return $this->repository->get();
    }

	/**
     * @brief returns single wireless sockets for the id and userId
     * @param int id
     * @param string userId
	 * @return array WirelessSocket
	 */
	public function getForId(int $id, $userId = null) {
        $errorCode = validateUserId($userId);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }

        return $this->respository->getForId($id);
    }

	/**
	 * Add a WirelessSocket
	 * @param WirelessSocket wirelessSocket
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
	public function add(WirelessSocket $wirelessSocket, $userId = null) {
        $errorCode = validateUserId($userId);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }

        return $this->repository->add($userId, $wirelessSocket);
    }
    
    /**
	 * Update a WirelessSocket
	 * @param WirelessSocket wirelessSocket
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
    public function update(WirelessSocket $wirelessSocket, $userId = null) {
        $errorCode = validateUserId($userId);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }

        return $this->repository->update($userId, $wirelessSocket);
    }
    
    /**
	 * Sets a new WirelessSocket state
	 * @param int id
     * @param int newState
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
    public function setState(int $id, int $newState, $userId = null) {
        $errorCode = validateUserId($userId);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }

        $wirelessSocket = $this->respository->getForId($id);
        $wirelessSocket->setState($newState);
        $databaseSuccess = $this->repository->update($userId, $wirelessSocket);

        $response = $this->piAdapter->send433MHz(17, $wirelessSocket->getCode(), $newState);
        $adapterSuccess = json_decode($response)->{'Success'};

        return $databaseSuccess && $adapterSuccess;
    }
    
	/**
	 * @brief Delete WirelessSocket with specific id
	 * @param int $id WirelessSocket ID to delete
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