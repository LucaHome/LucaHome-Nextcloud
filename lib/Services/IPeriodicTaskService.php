<?php

namespace OCA\WirelessControl\Services;

use OCA\WirelessControl\Enums\ErrorCode;
use OCA\WirelessControl\Entities\PeriodicTask;

interface IPeriodicTaskService
{
	/**
	 * @return array PeriodicTask
	 */
	public function get();

	/**
	 * @param int id PeriodicTask ID to get
	 * @return PeriodicTask PeriodicTask
	 */
	public function getById(int $id);

	/**
	 * @param PeriodicTask periodicTask
	 * @return ErrorCode Success or failure of action
	 */
	public function add(PeriodicTask $periodicTask);

	/**
	 * @param PeriodicTask periodicTask
	 * @return ErrorCode Success or failure of action
	 */
	public function update(PeriodicTask $periodicTask);

	/**
	 * @param int id PeriodicTask ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(int $id);
}
