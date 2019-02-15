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
     * @param int id
	 * @return array WirelessSocket
	 */
	public function getForId(int $id);

	/**
	 * @param string userId
	 * @param WirelessSocket wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
	public function add($userId, WirelessSocket $wirelessSocket);
    
    /**
	 * @param string userId
	 * @param WirelessSocket wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
    public function update($userId, WirelessSocket $wirelessSocket);
    
	/**
	 * @param string userId UserId
	 * @param int id WirelessSocket ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function delete($userId, int $id);
}