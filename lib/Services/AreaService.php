<?php

namespace OCA\WirelessControl\Services;

use OCA\WirelessControl\Enums\ErrorCode;
use OCA\WirelessControl\Entities\Area;
use OCA\WirelessControl\Repositories\AreaRepository;
use OCA\WirelessControl\Repositories\PeriodicTaskRepository;
use OCA\WirelessControl\Repositories\WirelessSocketRepository;
use OCP\ILogger;

class AreaService implements IAreaService {
    
	/**
	 * @var string
	 */
    private $appName;

	/**
	 * @var AreaRepository 
	 * */
	private $areaRepository;

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
	 * @param string $appName
	 * @param AreaRepository $areaRepository
	 * @param WirelessSocketRepository $wirelessSocketRepository
	 * @param PeriodicTaskRepository $periodicTaskRepository
	 * @param ILogger $logger
	 */
	public function __construct(string $appName, AreaRepository $areaRepository, WirelessSocketRepository $wirelessSocketRepository, PeriodicTaskRepository $periodicTaskRepository, ILogger $logger) {
		$this->appName = $appName;
		$this->areaRepository = $areaRepository;
		$this->wirelessSocketRepository = $wirelessSocketRepository;
		$this->periodicTaskRepository = $periodicTaskRepository;
		$this->logger = $logger;
    }
    
	/**
	 * @brief returns all areas
	 * @return array Area
	 */
	public function get() {
		$this->logger->info('AreaService: Get', ['app' => $this->appName]);
        return $this->areaRepository->get();
    }
    
	/**
	 * @brief returns single area by id
	 * @param int id Area ID to get
	 * @return Area Area
	 */
	public function getById(int $id) {
		$this->logger->info('AreaService: GetById: '.$id, ['app' => $this->appName]);
        return $this->areaRepository->getById($id);
    }

	/**
	 * Add an Area
	 * @param Area area
	 * @return ErrorCode Success or failure of action
	 */
	public function add(Area $area) {
		$this->logger->info('AreaService: Add: '.$area, ['app' => $this->appName]);
        return $this->areaRepository->add($area);
    }
    
    /**
	 * Update an Area
	 * @param Area area
	 * @return ErrorCode Success or failure of action
	 */
    public function update(Area $area) {
		$this->logger->info('AreaService: Update: '.$area, ['app' => $this->appName]);
        return $this->areaRepository->update($area);
    }
    
	/**
	 * @brief Delete Area with specific id
	 * @param int $id Area ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(int $id) {
		$this->logger->info('AreaService: Delete: '.$id, ['app' => $this->appName]);

		$areaToBeDeleted = $this->areaRepository->getById($id);
		if ($areaToBeDeleted === NULL) {
			return ErrorCode::AreaDoesNotExist;
		}

		$areaDeleteResult = $this->areaRepository->delete($areaToBeDeleted['id']);
		if ($areaDeleteResult !== 0) {
			return $areaDeleteResult;
		}

		$wirelessSocketsToBeDeleted = $this->wirelessSocketRepository->getByArea($areaToBeDeleted['name']);
		$wirelessSocketsDeleteResult =  $this->wirelessSocketRepository->deleteByArea($areaToBeDeleted['name']);
		if ($wirelessSocketsDeleteResult !== 0) {
			return $wirelessSocketsDeleteResult;
		}

		for ($index = 0; $index < sizeof($wirelessSocketsToBeDeleted); $index++) {
			$this->periodicTaskRepository->deleteByWirelessSocketId($wirelessSocketsToBeDeleted[$index]['id']);
		} 
		
		return ErrorCode::NoError;
    }
}