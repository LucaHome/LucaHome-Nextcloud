<?php

/**
 * Helpful: https://docs.nextcloud.com/server/stable/developer_manual/app/storage/database.html
 */

namespace OCA\WirelessControl\Repositories;

use OCA\WirelessControl\Enums\ErrorCode;
use OCA\WirelessControl\Entities\Area;
use OCP\IDBConnection;
use OCP\ILogger;

class AreaRepository implements IAreaRepository
{
	/**
	 * @var string
	 */
	private $appName;

	/** @var IDBConnection */
	private $db;

	/** 
	 * @var ILogger 
	 * */
	private $logger;

	/**
	 * @param string $appName
	 * @param IDBConnection $db
	 * @param ILogger $logger
	 */
	public function __construct(string $appName, IDBConnection $db, ILogger $logger)
	{
		$this->appName = $appName;
		$this->db = $db;
		$this->logger = $logger;
	}

	/**
	 * @brief returns all areas
	 * @return array Area
	 */
	public function get()
	{
		$this->logger->info('AreaRepository: Get', ['app' => $this->appName]);

		$qb = $this->db->getQueryBuilder();
		$qb
			->select('*')
			->from('wireless_control_areas');
		$areas = $qb->execute()->fetchAll();
		return $areas;
	}

	/**
	 * @brief returns single area by id
	 * @param int id Area ID to get
	 * @return Area Area
	 */
	public function getById(int $id)
	{
		$this->logger->info('AreaRepository: GetById: ' . $id, ['app' => $this->appName]);

		$qb = $this->db->getQueryBuilder();
		$qb
			->select('*')
			->from('wireless_control_areas')
			->where($qb->expr()->eq('id', $qb->createNamedParameter($id)));
		$areas = $qb->execute()->fetchAll();
		return reset($areas);
	}

	/**
	 * Add an Area
	 * @param Area area
	 * @return ErrorCode Success or failure of action
	 */
	public function add(Area $area)
	{
		$this->logger->info('AreaRepository: Add: ' . $area, ['app' => $this->appName]);

		$qb = $this->db->getQueryBuilder();
		$qb
			->insert('wireless_control_areas')
			->values([
				'name' => $qb->createNamedParameter(trim($area->getName())),
				'filter' => $qb->createNamedParameter(trim($area->getFilter())),
				'deletable' => $qb->createNamedParameter($area->getDeletable())
			]);

		if ($qb->execute()) {
			return $qb->getLastInsertId();
		} else {
			$this->logger->info('AreaRepository: Add: Failed: ' . ErrorCode::AreaDbAddError, ['app' => $this->appName]);
			return ErrorCode::AreaDbAddError;
		}
	}

	/**
	 * Update an Area
	 * @param Area area
	 * @return ErrorCode Success or failure of action
	 */
	public function update(Area $area)
	{
		$this->logger->info('AreaRepository: Update: ' . $area, ['app' => $this->appName]);

		$errorCode = $this->validate($area);
		if ($errorCode !== ErrorCode::NoError) {
			$this->logger->info('AreaRepository: Update: Validation: ' . $errorCode, ['app' => $this->appName]);
			return $errorCode;
		}

		$qb = $this->db->getQueryBuilder();
		$qb
			->update('wireless_control_areas')
			->set('name', $qb->createNamedParameter(trim($area->getName())))
			->set('filter', $qb->createNamedParameter(trim($area->getFilter())))
			->set('deletable', $qb->createNamedParameter($area->getDeletable()))
			->where($qb->expr()->eq('id', $qb->createNamedParameter($area->getId())));

		if ($qb->execute() === 0) {
			$this->logger->info('AreaRepository: Update: Failed: ' . ErrorCode::AreaDbUpdateError, ['app' => $this->appName]);
			return ErrorCode::AreaDbUpdateError;
		}

		return ErrorCode::NoError;
	}

	/**
	 * @brief Delete Area with specific id
	 * @param int id Area ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(int $id)
	{
		$this->logger->info('AreaRepository: Delete: ' . $id, ['app' => $this->appName]);
		$deletable = 1;

		$qb = $this->db->getQueryBuilder();
		$qb
			->delete('wireless_control_areas')
			->where($qb->expr()->eq('id', $qb->createNamedParameter($id)))
			->andWhere($qb->expr()->eq('deletable', $qb->createNamedParameter($deletable)));

		if ($qb->execute() === 0) {
			$this->logger->info('AreaRepository: Delete: Failed: ' . ErrorCode::AreaDoesNotExist, ['app' => $this->appName]);
			return ErrorCode::AreaDoesNotExist;
		}

		return ErrorCode::NoError;
	}

	/**
	 * @brief Validates Area
	 * @param Area $area
	 * @return ErrorCode Area is valid or not
	 */
	private function validate(Area $area)
	{
		if (strlen($area->getName()) > 128) {
			return ErrorCode::AreaNameTooLong;
		}

		if (strlen($area->getFilter()) > 128) {
			return ErrorCode::AreaFilterTooLong;
		}

		return ErrorCode::NoError;
	}
}
