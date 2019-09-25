<?php

namespace OCA\WirelessControl\Services;

use OCA\WirelessControl\Enums\ErrorCode;
use OCA\WirelessControl\Entities\WirelessSocketLegacy;

interface IWirelessSocketLegacyService
{
	/**
	 * @return array WirelessSocketLegacy
	 */
	public function get();

	/**
	 * @param int id WirelessSocketLegacy ID to get
	 * @return WirelessSocketLegacy wirelessSocket
	 */
	public function getById(int $id);

	/**
	 * @param WirelessSocketLegacy wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
	public function add(WirelessSocketLegacy $wirelessSocketLegacy);

	/**
	 * @param WirelessSocketLegacy wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
	public function update(WirelessSocketLegacy $wirelessSocketLegacy);

	/**
	 * @param int id WirelessSocketLegacy ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(int $id);
}
