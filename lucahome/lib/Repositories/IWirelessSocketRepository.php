<?php

namespace OCA\LucaHome\Repositories;

use \OCA\LucaHome\Enums\ErrorCode;
use \OCA\LucaHome\Entities\WirelessSocket;

interface IWirelessSocketRepository {

	/**
	 * @return array WirelessSocket
	 */
	public function get();

	/**
     * @param string userId
	 * @return array WirelessSocket
	 */
	public function getForUser($userId);

	/**
     * @param string userId
     * @param int id
	 * @return array WirelessSocket
	 */
	public function getForId($userId, int $id);

	/**
	 * @param string userId
	 * @param WirelessSocket wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
	public function addWirelessSocket($userId, WirelessSocket $wirelessSocket);
    
    /**
	 * @param string userId
	 * @param WirelessSocket wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
    public function updateWirelessSocket($userId, WirelessSocket $wirelessSocket);
    
	/**
	 * @param string userId UserId
	 * @param int id WirelessSocket ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function deleteWirelessSocket($userId, int $id);
}