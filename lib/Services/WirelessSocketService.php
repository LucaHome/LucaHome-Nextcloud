<?php

namespace OCA\WirelessControl\Services;

use OCA\WirelessControl\Adapter\PiAdapter;
use OCA\WirelessControl\Enums\ErrorCode;
use OCA\WirelessControl\Entities\WirelessSocket;
use OCA\WirelessControl\Repositories\PeriodicTaskRepository;
use OCA\WirelessControl\Repositories\WirelessSocketRepository;
use OCP\IConfig;
use OCP\ILogger;

class WirelessSocketService implements IWirelessSocketService {

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
	public function __construct(IConfig $settings, string $appName, PiAdapter $piAdapter, WirelessSocketRepository $wirelessSocketRepository, PeriodicTaskRepository $periodicTaskRepository, ILogger $logger) {
		$this->settings = $settings;
		$this->appName = $appName;
		$this->piAdapter = $piAdapter;
		$this->wirelessSocketRepository = $wirelessSocketRepository;
		$this->periodicTaskRepository = $periodicTaskRepository;
		$this->logger = $logger;
    }
    
	/**
	 * @brief returns all wireless sockets
	 * @return array WirelessSocket
	 */
	public function get() {
		$this->logger->info('WirelessSocketService: Get', ['app' => $this->appName]);
        return $this->wirelessSocketRepository->get();
    }
    
	/**
	 * @brief returns single wirelessSocket by id
	 * @param int id WirelessSocket ID to get
	 * @return WirelessSocket WirelessSocket
	 */
	public function getById(int $id) {
		$this->logger->info('WirelessSocketService: GetById: '.$id, ['app' => $this->appName]);
        return $this->wirelessSocketRepository->getById($id);
    }

	/**
	 * Add a WirelessSocket
	 * @param WirelessSocket wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
	public function add(WirelessSocket $wirelessSocket) {
		$this->logger->info('WirelessSocketService: Add: '.$wirelessSocket, ['app' => $this->appName]);
        return $this->wirelessSocketRepository->add($wirelessSocket);
    }
    
    /**
	 * Update a WirelessSocket
	 * @param WirelessSocket wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
    public function update(WirelessSocket $wirelessSocket) {
		$this->logger->info('WirelessSocketService: Update: '.$wirelessSocket, ['app' => $this->appName]);
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
	public function delete(int $id) {
		$this->logger->info('WirelessSocketService: Delete: '.$id, ['app' => $this->appName]);

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