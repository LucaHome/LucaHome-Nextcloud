<?php

/**
 * Helpful: https://docs.nextcloud.com/server/stable/developer_manual/app/storage/database.html
 */

namespace OCA\LucaHome\Repositories;

use \OCA\LucaHome\Enums\ErrorCode;
use \OCA\LucaHome\Entities\WirelessSocket;
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
            ->from('wirelesssockets');

        $cursor = $qb->execute();
        $result = $cursor->fetch();
        $cursor->closeCursor();

        return $result;
    }

	/**
	 * @brief returns single wireless socket for a userId and the id
     * @param string userId
     * @param int id
	 * @return array WirelessSocket
	 */
    public function getForId($userId, int $id) {
        $qb = $this->db->getQueryBuilder();
        $qb
            ->select('*')
            ->from('wirelesssockets')
            ->where($qb->expr()->eq('id', $qb->createNamedParameter($id, IQueryBuilder::PARAM_INT)));

        $cursor = $qb->execute();
        $result = $cursor->fetch();
        $cursor->closeCursor();

        return $result;
    }

	/**
	 * Add a WirelessSocket
	 * @param string userId
	 * @param WirelessSocket wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
	public function add(string $userId, WirelessSocket $wirelessSocket) {
        $errorCode = validate($wirelessSocket);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }
        
        $qb = $this->db->getQueryBuilder();
		$qb
			->insert('wirelesssockets')
			->values([
				'name' => $qb->createParameter('name'),
				'code' => $qb->createParameter('code'),
				'area' => $qb->createParameter('area'),
                'state' => $qb->createParameter('state'),
                'description' => $qb->createParameter('description')
			])
			->where($qb->expr()->eq('user_id', $qb->createParameter('user_id')));
        
        $qb->setParameters([
			'name' => $wirelessSocket->getName(),
			'code' => $wirelessSocket->getCode(),
			'area' => $wirelessSocket->getArea(),
            'state' => $wirelessSocket->getState(),
			'description' => $wirelessSocket->getDescription()
        ]);
        
        $cursor = $qb->execute();

		$insertId = $qb->getLastInsertId();
		if ($insertId !== false) {
			$this->eventDispatcher->dispatch(
				'\OCA\LucaHome::onWirelessSocketCreate',
				new GenericEvent(null, ['id' => $insertId, 'userId' => $userid])
            );
            
            $cursor->closeCursor();
			return $insertId;
        }
        
        return ErrorCode::WirelessSocketDbCreateError;
	}

	/**
	 * Update a WirelessSocket
	 * @param string userId
	 * @param WirelessSocket wirelessSocket
	 * @return ErrorCode Success or failure of action
	 */
	public function update(string $userId, WirelessSocket $wirelessSocket) {
        $errorCode = validate($wirelessSocket);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }
        
		$qb = $this->db->getQueryBuilder();
		$qb
			->update('wirelesssockets')
            ->set('name', $qb->createNamedParameter($wirelessSocket->getName()))
            ->set('code', $qb->createNamedParameter($wirelessSocket->getCode()))
            ->set('area', $qb->createNamedParameter($wirelessSocket->getArea()))
            ->set('state', $qb->createNamedParameter($wirelessSocket->getState()))
            ->set('description', $qb->createNamedParameter($wirelessSocket->getDescription()))
			->where($qb->expr()->eq('id', $qb->createNamedParameter($id)));

        $cursor = $qb->execute();

		if ($cursor === 0) {
			return ErrorCode::WirelessSocketDbUpdateError;
		}

        $cursor->closeCursor();
        
		$this->eventDispatcher->dispatch(
			'\OCA\LucaHome::onWirelessSocketUpdate',
			new GenericEvent(null, ['id' => $id, 'userId' => $userid])
		);
        
        return ErrorCode::NoError;
	}
	
	/**
	 * @brief Delete WirelessSocket with specific id
	 * @param string userId UserId
	 * @param int id WirelessSocket ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(string $userId, int $id) {
		$qb = $this->db->getQueryBuilder();
		$qb
			->select('id')
			->from('wirelesssockets')
			->where($qb->expr()->eq('id', $qb->createNamedParameter($id)));

		$id = $qb->execute()->fetchColumn();
		if ($id === false) {
			return ErrorCode::WirelessSocketDoesNotExist;
		}

		$qb = $this->db->getQueryBuilder();
		$qb
			->delete('wirelesssockets')
			->where($qb->expr()->eq('id', $qb->createNamedParameter($id)));
		$qb->execute();

		$this->eventDispatcher->dispatch(
			'\OCA\LucaHome::onWirelessSocketDelete',
			new GenericEvent(null, ['id' => $id, 'userId' => $userId])
		);

		return ErrorCode::NoError;
    }
    
	/**
	 * @brief Validates WirelessSocket
	 * @param WirelessSocket $wirelessSocket
	 * @return ErrorCode WirelessSocket is valid or not
	 */
    private function validate(WirelessSocket $wirelessSocket) {
        if(nameInUse($wirelessSocket->getCode()) !== true) {
            return ErrorCode::WirelessSocketNameAlreadyInUse;
        }

        if(codeInUse($wirelessSocket->getCode()) !== true) {
            return ErrorCode::WirelessSocketCodeAlreadyInUse;
        }

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

        return ErrorCode::NoError;
    }

	/**
	 * @brief check if an wireless socket name is already in use
	 * @param string $code WirelessSocket name possible in use
	 * @return bool|int the wireless socket id if existing, false otherwise
	 */
	private function nameInUse($code) {
		$qb = $this->db->getQueryBuilder();
		$qb
			->select('id')
			->from('wirelesssockets')
			->where($qb->expr()->eq('name', $qb->createNamedParameter($code)));

        $cursor = $qb->execute();
        $result = $cursor->fetch();
        $cursor->closeCursor();
        
		if ($result) {
			return $result['id'];
        } 
        
        return false;
	}

	/**
	 * @brief check if an wireless socket code is already in use
	 * @param string $code WirelessSocket code possible in use
	 * @return bool|int the wireless socket id if existing, false otherwise
	 */
	private function codeInUse($code) {
		$qb = $this->db->getQueryBuilder();
		$qb
			->select('id')
			->from('wirelesssockets')
			->where($qb->expr()->eq('code', $qb->createNamedParameter($code)));

        $cursor = $qb->execute();
        $result = $cursor->fetch();
        $cursor->closeCursor();
        
		if ($result) {
			return $result['id'];
        } 
        
        return false;
	}
}
