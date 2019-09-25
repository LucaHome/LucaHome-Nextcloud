<?php

namespace OCA\WirelessControl\Services;

use OCA\WirelessControl\Enums\ErrorCode;
use OCA\WirelessControl\Entities\PeriodicTask;
use OCA\WirelessControl\Repositories\PeriodicTaskRepository;
use OCP\ILogger;

class PeriodicTaskService implements IPeriodicTaskService
{
	/**
	 * @var string
	 */
	private $appName;

	/** 
	 * @var PeriodicTaskRepository 
	 * */
	private $periodicTaskRepository;

	/** 
	 * @var ILogger 
	 * */
	private $logger;

	/**
	 * @param string $appName
	 * @param PeriodicTaskRepository $periodicTaskRepository
	 * @param ILogger $logger
	 */
	public function __construct(string $appName, PeriodicTaskRepository $periodicTaskRepository, ILogger $logger)
	{
		$this->appName = $appName;
		$this->periodicTaskRepository = $periodicTaskRepository;
		$this->logger = $logger;
	}

	/**
	 * @brief returns all PeriodicTasks
	 * @return array PeriodicTask
	 */
	public function get()
	{
		$this->logger->info('PeriodicTaskService: Get', ['app' => $this->appName]);
		return $this->periodicTaskRepository->get();
	}

	/**
	 * @brief returns single PeriodicTask by id
	 * @param int id PeriodicTask ID to get
	 * @return PeriodicTask PeriodicTask
	 */
	public function getById(int $id)
	{
		$this->logger->info('PeriodicTaskService: GetById: ' . $id, ['app' => $this->appName]);
		return $this->periodicTaskRepository->getById($id);
	}

	/**
	 * Add an PeriodicTask
	 * @param PeriodicTask periodicTask
	 * @return ErrorCode Success or failure of action
	 */
	public function add(PeriodicTask $periodicTask)
	{
		$this->logger->info('PeriodicTaskService: Add: ' . $periodicTask, ['app' => $this->appName]);
		return $this->periodicTaskRepository->add($periodicTask);
	}

	/**
	 * Update an APeriodicTaskrea
	 * @param PeriodicTask periodicTask
	 * @return ErrorCode Success or failure of action
	 */
	public function update(PeriodicTask $periodicTask)
	{
		$this->logger->info('PeriodicTaskService: Update: ' . $periodicTask, ['app' => $this->appName]);
		return $this->periodicTaskRepository->update($periodicTask);
	}

	/**
	 * @brief Delete PeriodicTask with specific id
	 * @param int $id PeriodicTask ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(int $id)
	{
		$this->logger->info('PeriodicTaskService: Delete: ' . $id, ['app' => $this->appName]);
		return $this->periodicTaskRepository->delete($id);
	}
}
