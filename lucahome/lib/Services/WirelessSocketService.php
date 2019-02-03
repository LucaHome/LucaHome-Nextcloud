<?php

namespace OCA\LucaHome\Services;

use \OC\User\Manager;
use \OCA\LucaHome\Enums\ErrorCode;
use \OCA\LucaHome\Entities\WirelessSocket;
use \OCA\LucaHome\Repositories\WirelessSocketRepository;
use OCP\ILogger;

class WirelessSocketService implements IWirelessSocketService {

	/** @var Manager  */
    private $userManager;
    
	/** @var ILogger */
	private $logger;

	/** @var WirelessSocketRepository */
	private $repository;

	public function __construct(Manager $userManager, ILogger $logger, WirelessSocketRepository $repository) {
		$this->userManager = $userManager;
		$this->logger = $logger;
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
     * @brief returns all wireless sockets for a userId and the public
     * @param string userId
	 * @return array WirelessSocket
	 */
	public function getForUser($userId = null) {
        $errorCode = validateUserId($userId);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }

        return $this->repository->getForUser($userId);
    }

	/**
	 * Add a WirelessSocket
	 * @param WirelessSocket wirelessSocket
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
	public function addWirelessSocket(WirelessSocket $wirelessSocket, $userId = null) {
        $errorCode = validateUserId($userId);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }

        return $this->repository->addWirelessSocket($userId, $wirelessSocket);
    }
    
    /**
	 * Update a WirelessSocket
	 * @param WirelessSocket wirelessSocket
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
    public function updateWirelessSocket(WirelessSocket $wirelessSocket, $userId = null) {
        $errorCode = validateUserId($userId);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }

        return $this->repository->updateWirelessSocket($userId, $wirelessSocket);
    }
    
    /**
	 * Sets a new WirelessSocket state
	 * @param int id
     * @param int newState
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
    public function setWirelessSocketState(int $id, int $newState, $userId = null) {
        $errorCode = validateUserId($userId);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }

        $wirelessSocket = $this->respository->getForId($userId, $id);
        $wirelessSocket->setState($newState);
        // TODO: Send real code over 433MHz
        // http://www.robertprice.co.uk/robblog/controlling-a-led-on-a-raspberry-pi-with-php/
        // https://pi-buch.info/gpio-steuerung-in-php-scripts/

        return $this->repository->updateWirelessSocket($userId, $wirelessSocket);
    }
    
	/**
	 * @brief Delete WirelessSocket with specific id
	 * @param int $id WirelessSocket ID to delete
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
	public function deleteWirelessSocket(int $id, $userId = null) {
        $errorCode = validateUserId($userId);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }

        return $this->repository->deleteWirelessSocket($userId, $wirelessSocket->getId());
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