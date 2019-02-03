<?php

namespace OCA\LucaHome\Services;

use \OCA\LucaHome\Enums\ErrorCode;
use \OCA\LucaHome\Entities\WirelessSocket;
use \OCA\LucaHome\Repositories\WirelessSocketRepository;

interface IWirelessSocketService {

	/**
     * @param string userId
	 * @return array WirelessSocket
	 */
	public function get($userId = null);

	/**
     * @param string userId
	 * @return array WirelessSocket
	 */
	public function getForUser($userId = null);

	/**
	 * @param WirelessSocket $wirelessSocket
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
	public function addWirelessSocket(WirelessSocket $wirelessSocket, $userId = null);
    
    /**
	 * @param WirelessSocket $wirelessSocket
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
    public function updateWirelessSocket(WirelessSocket $wirelessSocket, $userId = null);
    
    /**
	 * @param WirelessSocket $wirelessSocket
     * @param int NewState
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
    public function setWirelessSocketState(WirelessSocket $wirelessSocket, int $newState, $userId = null);
    
	/**
	 * @param int $id WirelessSocket ID to delete
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
	public function deleteWirelessSocket(int $id, $userId = null);
}