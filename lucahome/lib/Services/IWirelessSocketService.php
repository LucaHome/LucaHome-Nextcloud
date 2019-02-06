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
     * @param int id
     * @param string userId
	 * @return array WirelessSocket
	 */
	public function getForId(int $id, $userId = null);

	/**
	 * @param WirelessSocket wirelessSocket
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
	public function add(WirelessSocket $wirelessSocket, $userId = null);
    
    /**
	 * @param WirelessSocket wirelessSocket
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
    public function update(WirelessSocket $wirelessSocket, $userId = null);
    
    /**
	 * @param int id
     * @param int newState
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
    public function setState(int $id, int $newState, $userId = null);
    
	/**
	 * @param int id WirelessSocket ID to delete
     * @param string userId
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(int $id, $userId = null);
}