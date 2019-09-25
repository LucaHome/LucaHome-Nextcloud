<?php

namespace OCA\WirelessControl\Services;

use OCA\WirelessControl\Enums\ErrorCode;
use OCA\WirelessControl\Entities\WirelessSocket;

interface IWirelessSocketService
{
	/**
	 * @return array WirelessSocket
	 */
	public function get();

	/**
	 * @param int id WirelessSocket ID to get
	 * @return WirelessSocket WirelessSocket
	 */
	public function getById(int $id);

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
