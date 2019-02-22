<?php

namespace OCA\LucaHome\Repositories;

use OCA\LucaHome\Enums\ErrorCode;
use OCA\LucaHome\Entities\WirelessSocket;

interface IWirelessSocketRepository {

	/**
	 * @return array WirelessSocket
	 */
	public function get();

	/**
	 * @param string userId
	 * @param WirelessSocket wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
	public function add(string $userId, WirelessSocket $wirelessSocket);
    
    /**
	 * @param string userId
	 * @param WirelessSocket wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
    public function update(string $userId, WirelessSocket $wirelessSocket);
    
	/**
	 * @param string userId UserId
	 * @param int id WirelessSocket ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(string $userId, int $id);
}