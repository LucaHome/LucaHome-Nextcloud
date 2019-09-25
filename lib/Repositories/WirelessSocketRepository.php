<?php

/**
 * Helpful: https://docs.nextcloud.com/server/stable/developer_manual/app/storage/database.html
 */

namespace OCA\WirelessControl\Repositories;

use OCA\WirelessControl\Enums\ErrorCode;
use OCA\WirelessControl\Entities\WirelessSocket;
use OCP\IDBConnection;
use OCP\ILogger;

class WirelessSocketRepository implements IWirelessSocketRepository
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
	 * @brief returns all wireless sockets
	 * @return array WirelessSocket
	 */
	public function get()
	{
		$this->logger->info('WirelessSocketRepository: Get', ['app' => $this->appName]);

		$qb = $this->db->getQueryBuilder();
		$qb
			->select('*')
			->from('wireless_control_sockets');
		$wirelessSockets = $qb->execute()->fetchAll();
		return $wirelessSockets;
	}

	/**
	 * @brief returns single WirelessSocket by id
	 * @param int id WirelessSocket ID to get
	 * @return WirelessSocket WirelessSocket
	 */
	public function getById(int $id)
	{
		$this->logger->info('WirelessSocketRepository: GetById: ' . $id, ['app' => $this->appName]);

		$qb = $this->db->getQueryBuilder();
		$qb
			->select('*')
			->from('wireless_control_sockets')
			->where($qb->expr()->eq('id', $qb->createNamedParameter($id)));
		$wirelessSockets = $qb->execute()->fetchAll();
		return reset($wirelessSockets);
	}

	/**
	 * @brief returns all wireless sockets for an area
	 * @param string area Get WirelessSockets by this area
	 * @return array WirelessSocket for area
	 */
	public function getByArea(string $area)
	{
		$this->logger->info('WirelessSocketRepository: GetByArea: ' . $area, ['app' => $this->appName]);

		$qb = $this->db->getQueryBuilder();
		$qb
			->select('*')
			->from('wireless_control_sockets')
			->where($qb->expr()->eq('area', $qb->createNamedParameter($area)));
		$wirelessSockets = $qb->execute()->fetchAll();
		return $wirelessSockets;
	}

	/**
	 * Add a WirelessSocket
	 * @param WirelessSocket wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
	public function add(WirelessSocket $wirelessSocket)
	{
		$this->logger->info('WirelessSocketRepository: Add: ' . $wirelessSocket, ['app' => $this->appName]);

		$qb = $this->db->getQueryBuilder();
		$qb
			->insert('wireless_control_sockets')
			->values([
				'name' => $qb->createNamedParameter(trim($wirelessSocket->getName())),
				'code' => $qb->createNamedParameter(trim($wirelessSocket->getCode())),
				'area' => $qb->createNamedParameter(trim($wirelessSocket->getArea())),
				'state' => $qb->createNamedParameter($wirelessSocket->getState()),
				'description' => $qb->createNamedParameter(trim($wirelessSocket->getDescription())),
				'icon' => $qb->createNamedParameter(trim($wirelessSocket->getIcon())),
				'deletable' => $qb->createNamedParameter($wirelessSocket->getDeletable()),
				'lastToggled' => $qb->createNamedParameter($wirelessSocket->getLastToggled()),
				'group' => $qb->createNamedParameter(trim($wirelessSocket->getGroup()))
			]);

		if ($qb->execute()) {
			return $qb->getLastInsertId();
		} else {
			$this->logger->info('WirelessSocketRepository: Add: Failed: ' . ErrorCode::WirelessSocketDbAddError, ['app' => $this->appName]);
			return ErrorCode::WirelessSocketDbAddError;
		}
	}

	/**
	 * Update a WirelessSocket
	 * @param WirelessSocket wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
	public function update(WirelessSocket $wirelessSocket)
	{
		$this->logger->info('WirelessSocketRepository: Update: ' . $wirelessSocket, ['app' => $this->appName]);

		$errorCode = $this->validate($wirelessSocket);
		if ($errorCode !== ErrorCode::NoError) {
			$this->logger->info('WirelessSocketRepository: Update: Validation: ' . $errorCode, ['app' => $this->appName]);
			return $errorCode;
		}

		$qb = $this->db->getQueryBuilder();
		$qb
			->update('wireless_control_sockets')
			->set('name', $qb->createNamedParameter(trim($wirelessSocket->getName())))
			->set('code', $qb->createNamedParameter(trim($wirelessSocket->getCode())))
			->set('area', $qb->createNamedParameter(trim($wirelessSocket->getArea())))
			->set('state', $qb->createNamedParameter($wirelessSocket->getState()))
			->set('description', $qb->createNamedParameter(trim($wirelessSocket->getDescription())))
			->set('icon', $qb->createNamedParameter(trim($wirelessSocket->getIcon())))
			->set('deletable', $qb->createNamedParameter($wirelessSocket->getDeletable()))
			->set('lastToggled', $qb->createNamedParameter($wirelessSocket->getLastToggled()))
			->set('group', $qb->createNamedParameter($wirelessSocket->getGroup()))
			->where($qb->expr()->eq('id', $qb->createNamedParameter($wirelessSocket->getId())));

		if ($qb->execute() === 0) {
			$this->logger->info('WirelessSocketRepository: Update: Failed: ' . ErrorCode::WirelessSocketDbUpdateError, ['app' => $this->appName]);
			return ErrorCode::WirelessSocketDbUpdateError;
		}

		return ErrorCode::NoError;
	}

	/**
	 * @brief Delete WirelessSocket with specific id
	 * @param int id WirelessSocket ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(int $id)
	{
		$this->logger->info('WirelessSocketRepository: Delete: ' . $id, ['app' => $this->appName]);
		$deletable = 1;

		$qb = $this->db->getQueryBuilder();
		$qb
			->delete('wireless_control_sockets')
			->where($qb->expr()->eq('id', $qb->createNamedParameter($id)))
			->andWhere($qb->expr()->eq('deletable', $qb->createNamedParameter($deletable)));

		if ($qb->execute() === 0) {
			$this->logger->info('WirelessSocketRepository: Delete: Failed: ' . ErrorCode::WirelessSocketDoesNotExist, ['app' => $this->appName]);
			return ErrorCode::WirelessSocketDoesNotExist;
		}

		return ErrorCode::NoError;
	}

	/**
	 * @brief Delete WirelessSocket with specific area
	 * @param string area Delete WirelessSockets by this area
	 * @return ErrorCode Success or failure of action
	 */
	public function deleteByArea(string $area)
	{
		$this->logger->info('WirelessSocketRepository: DeleteByArea: ' . $area, ['app' => $this->appName]);
		$deletable = 1;

		$qb = $this->db->getQueryBuilder();
		$qb
			->delete('wireless_control_sockets')
			->where($qb->expr()->eq('area', $qb->createNamedParameter($area)))
			->andWhere($qb->expr()->eq('deletable', $qb->createNamedParameter($deletable)));
		$qb->execute();

		return ErrorCode::NoError;
	}

	/**
	 * @brief Validates WirelessSocket
	 * @param WirelessSocket $wirelessSocket
	 * @return ErrorCode WirelessSocket is valid or not
	 */
	private function validate(WirelessSocket $wirelessSocket)
	{
		if (strlen($wirelessSocket->getName()) > 4096) {
			return ErrorCode::WirelessSocketNameTooLong;
		}

		if (strlen($wirelessSocket->getCode()) !== 6) {
			return ErrorCode::WirelessSocketCodeLengthInvalid;
		}

		if (strlen($wirelessSocket->getArea()) > 4096) {
			return ErrorCode::WirelessSocketAreaTooLong;
		}

		if (strlen($wirelessSocket->getDescription()) > 4096) {
			return ErrorCode::WirelessSocketDescriptionTooLong;
		}

		if (strlen($wirelessSocket->getIcon()) > 32) {
			return ErrorCode::WirelessSocketIconTooLong;
		}

		if (strlen($wirelessSocket->getGroup()) > 64) {
			return ErrorCode::WirelessSocketInvalidGroup;
		}

		return ErrorCode::NoError;
	}
}
