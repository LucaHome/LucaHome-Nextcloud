<?php

namespace OCA\LucaHome\Services;

use OCA\LucaHome\Adapter\PiAdapter;
use OCA\LucaHome\Enums\ErrorCode;
use OCA\LucaHome\Entities\WirelessSocket;
use OCA\LucaHome\Repositories\WirelessSocketRepository;

interface IWirelessSocketService {

	/**
	 * @return array WirelessSocket
	 */
	public function get();

	/**
	 * @param WirelessSocket wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
	public function add(WirelessSocket $wirelessSocket);
    
    /**
	 * @param WirelessSocket wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
    public function update(WirelessSocket $wirelessSocket);
    
	/**
	 * @param int id WirelessSocket ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(int $id);
}