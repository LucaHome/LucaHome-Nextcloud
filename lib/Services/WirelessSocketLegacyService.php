<?php

namespace OCA\WirelessControl\Services;

use OCA\WirelessControl\Adapter\PiAdapter;
use OCA\WirelessControl\Enums\ErrorCode;
use OCA\WirelessControl\Entities\WirelessSocketLegacy;
use OCA\WirelessControl\Repositories\PeriodicTaskRepository;
use OCA\WirelessControl\Repositories\WirelessSocketRepository;
use OCP\IConfig;
use OCP\ILogger;

class WirelessSocketLegacyService implements IWirelessSocketLegacyService
{
	/**
	 * @var IConfig
	 */
	private $settings;

	/**
	 * @var string
	 */
	private $appName;

	/** 
	 * @var PiAdapter 
	 * */
	private $piAdapter;

	/** 
	 * @var WirelessSocketRepository 
	 * */
	private $wirelessSocketRepository;

	/** 
	 * @var PeriodicTaskRepository 
	 * */
	private $periodicTaskRepository;

	/** 
	 * @var ILogger 
	 * */
	private $logger;

	/**
	 * @param IConfig $settings
	 * @param string $appName
	 * @param PiAdapter $piAdapter
	 * @param WirelessSocketRepository $wirelessSocketRepository
	 * @param PeriodicTaskRepository $periodicTaskRepository
	 * @param ILogger $logger
	 */
	public function __construct(IConfig $settings, string $appName, PiAdapter $piAdapter, WirelessSocketRepository $wirelessSocketRepository, PeriodicTaskRepository $periodicTaskRepository, ILogger $logger)
	{
		$this->settings = $settings;
		$this->appName = $appName;
		$this->piAdapter = $piAdapter;
		$this->wirelessSocketRepository = $wirelessSocketRepository;
		$this->periodicTaskRepository = $periodicTaskRepository;
		$this->logger = $logger;
	}

	/**
	 * @brief returns all wireless sockets
	 * @return array WirelessSocketLegacy
	 */
	public function get()
	{
		$this->logger->info('WirelessSocketService: Get', ['app' => $this->appName]);
		$wirelessSocketArray  = $this->wirelessSocketRepository->get();
		$wirelessSocketLegacyArray = array();
		foreach ($wirelessSocketArray as $index => $value) {
			array_push($wirelessSocketLegacyArray, WirelessSocketLegacy::fromWirelessSocket($value));
		}
		return $wirelessSocketLegacyArray;
	}

	/**
	 * @brief returns single wirelessSocket by id
	 * @param int id WirelessSocket ID to get
	 * @return WirelessSocketLegacy WirelessSocket
	 */
	public function getById(int $id)
	{
		$this->logger->info('WirelessSocketService: GetById: ' . $id, ['app' => $this->appName]);
		$wirelessSocket = $this->wirelessSocketRepository->getById($id);
		return WirelessSocketLegacy::fromWirelessSocket($wirelessSocket);
	}

	/**
	 * Add a WirelessSocket
	 * @param WirelessSocketLegacy wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
	public function add(WirelessSocketLegacy $wirelessSocketLegacy)
	{
		$wirelessSocket = WirelessSocketLegacy::toWirelessSocket($wirelessSocketLegacy);
		$this->logger->info('WirelessSocketService: Add: ' . $wirelessSocket, ['app' => $this->appName]);
		return $this->wirelessSocketRepository->add($wirelessSocket);
	}

	/**
	 * Update a WirelessSocket
	 * @param WirelessSocketLegacy wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
	public function update(WirelessSocketLegacy $wirelessSocketLegacy)
	{
		$wirelessSocket = WirelessSocketLegacy::toWirelessSocket($wirelessSocketLegacy);
		$this->logger->info('WirelessSocketService: Update: ' . $wirelessSocket, ['app' => $this->appName]);
		// $gpioPin = (int)$this->settings->getUserValue($this->userId, $this->appName,'various_wirelessSocketGpioPin');
		$gpioPin = 17;
		$this->piAdapter->send433MHz($gpioPin, $wirelessSocket->getCode(), $wirelessSocket->getState());
		return $this->wirelessSocketRepository->update($wirelessSocket);
	}

	/**
	 * @brief Delete WirelessSocket with specific id
	 * @param int $id WirelessSocket ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(int $id)
	{
		$this->logger->info('WirelessSocketService: Delete: ' . $id, ['app' => $this->appName]);

		$wirelessSocketToBeDeleted = $this->wirelessSocketRepository->getById($id);
		if ($wirelessSocketToBeDeleted === NULL) {
			return ErrorCode::WirelessSocketDoesNotExist;
		}

		$wirelessSocketDeleteResult = $this->wirelessSocketRepository->delete($wirelessSocketToBeDeleted['id']);
		if ($wirelessSocketDeleteResult !== 0) {
			return $wirelessSocketDeleteResult;
		}

		return $this->periodicTaskRepository->deleteByWirelessSocketId($wirelessSocketToBeDeleted['id']);
	}
}
