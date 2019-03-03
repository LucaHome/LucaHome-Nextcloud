<?php

/**
 * Helpful: https://docs.nextcloud.com/server/stable/developer_manual/app/storage/database.html
 */

namespace OCA\LucaHome\Repositories;

use OCA\LucaHome\Enums\ErrorCode;
use OCA\LucaHome\Entities\WirelessSocket;
use OCP\DB\QueryBuilder\IQueryBuilder;
use OCP\IDBConnection;

class WirelessSocketRepository implements IWirelessSocketRepository {

    /** @var IDBConnection */
    private $db;

    public function __construct(IDBConnection $db) {
        $this->db = $db;
    }

	/**
	 * @brief returns all wireless sockets
	 * @return array WirelessSocket
	 */
    public function get() {
        $qb = $this->db->getQueryBuilder();
        $qb
            ->select('*')
            ->from('lh_wireless_socket');
        $areas = $qb->execute()->fetchAll();
		return $areas;
    }

	/**
	 * Add a WirelessSocket
	 * @param WirelessSocket wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
	public function add(WirelessSocket $wirelessSocket) {
        $qb = $this->db->getQueryBuilder();
		$qb
			->insert('lh_wireless_socket')
			->values([
				'name' => $qb->createNamedParameter(trim($wirelessSocket->getName())),
				'code' => $qb->createNamedParameter(trim($wirelessSocket->getCode())),
				'area' => $qb->createNamedParameter(trim($wirelessSocket->getArea())),
				'state' => $qb->createNamedParameter($wirelessSocket->getState()),
				'description' => $qb->createNamedParameter(trim($wirelessSocket->getDescription())),
				'icon' => $qb->createNamedParameter(trim($wirelessSocket->getIcon())),
				'deletable' => $qb->createNamedParameter($wirelessSocket->getDeletable())
			]);

		if ($qb->execute()) {
			return $qb->getLastInsertId();
		} else {
			return false;
		}
	}

	/**
	 * Update a WirelessSocket
	 * @param WirelessSocket wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
	public function update(WirelessSocket $wirelessSocket) {
        $errorCode = $this->validate($wirelessSocket);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }
        
		$qb = $this->db->getQueryBuilder();
		$qb
			->update('lh_wireless_socket')
            ->set('name', $qb->createNamedParameter(trim($wirelessSocket->getName())))
            ->set('code', $qb->createNamedParameter(trim($wirelessSocket->getCode())))
            ->set('area', $qb->createNamedParameter(trim($wirelessSocket->getArea())))
            ->set('state', $qb->createNamedParameter($wirelessSocket->getState()))
            ->set('description', $qb->createNamedParameter(trim($wirelessSocket->getDescription())))
            ->set('icon', $qb->createNamedParameter(trim($wirelessSocket->getIcon())))
            ->set('deletable', $qb->createNamedParameter($wirelessSocket->getDeletable()))
			->where($qb->expr()->eq('id', $qb->createNamedParameter($wirelessSocket->getId())));

		if ($qb->execute() === 0) {
			return ErrorCode::WirelessSocketDbUpdateError;
		}
        
        return ErrorCode::NoError;
	}
	
	/**
	 * @brief Delete WirelessSocket with specific id
	 * @param int id WirelessSocket ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(int $id) {
		$qb = $this->db->getQueryBuilder();
		$qb
			->delete('lh_wireless_socket')
			->where($qb->expr()->eq('id', $qb->createNamedParameter($id)))
			->andWhere($qb->expr()->eq('deletable', 1));

		if ($qb->execute() === 0) {
			return ErrorCode::WirelessSocketDoesNotExist;
		}

        return ErrorCode::NoError;
    }
    
	/**
	 * @brief Validates WirelessSocket
	 * @param WirelessSocket $wirelessSocket
	 * @return ErrorCode WirelessSocket is valid or not
	 */
    private function validate(WirelessSocket $wirelessSocket) {
        if(strlen($wirelessSocket->getName()) > 4096) {
            return ErrorCode::WirelessSocketNameTooLong;
        }

        if(strlen($wirelessSocket->getCode()) !== 6) {
            return ErrorCode::WirelessSocketCodeLengthInvalid;
        }

        if(strlen($wirelessSocket->getArea()) > 4096) {
            return ErrorCode::WirelessSocketAreaTooLong;
        }

        if(strlen($wirelessSocket->getDescription()) > 4096) {
            return ErrorCode::WirelessSocketDescriptionTooLong;
        }

        if(strlen($wirelessSocket->getIcon()) > 32) {
            return ErrorCode::WirelessSocketIconTooLong;
        }

        return ErrorCode::NoError;
    }
}
