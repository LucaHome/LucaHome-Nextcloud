<?php

namespace OCA\WirelessControl\Services;

use OCA\WirelessControl\Adapter\PiAdapter;
use OCA\WirelessControl\Enums\ErrorCode;
use OCA\WirelessControl\Entities\WirelessSocket;
use OCA\WirelessControl\Repositories\WirelessSocketRepository;
use OCP\IConfig;

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
	private $repository;

	/**
	 * @param IConfig $settings
	 * @param string $appName
	 * @param PiAdapter $piAdapter
	 * @param WirelessSocketRepository $repository
	 */
	public function __construct(IConfig $settings, string $appName, PiAdapter $piAdapter, WirelessSocketRepository $repository) {
		$this->settings = $settings;
		$this->appName = $appName;
		$this->piAdapter = $piAdapter;
		$this->repository = $repository;
    }
    
	/**
	 * @brief returns all wireless sockets
	 * @return array WirelessSocket
	 */
	public function get() {
        return $this->repository->get();
    }

	/**
	 * Add a WirelessSocket
	 * @param WirelessSocket wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
	public function add(WirelessSocket $wirelessSocket) {
        return $this->repository->add($wirelessSocket);
    }
    
    /**
	 * Update a WirelessSocket
	 * @param WirelessSocket wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
    public function update(WirelessSocket $wirelessSocket) {
		// $gpioPin = (int)$this->settings->getUserValue($this->userId, $this->appName,'various_wirelessSocketGpioPin');
		$gpioPin = 17;
		$this->piAdapter->send433MHz($gpioPin, $wirelessSocket->getCode(), $wirelessSocket->getState());
		return $this->repository->update($wirelessSocket);
    }
    
	/**
	 * @brief Delete WirelessSocket with specific id
	 * @param int $id WirelessSocket ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(int $id) {
        return $this->repository->delete($id);
    }
}