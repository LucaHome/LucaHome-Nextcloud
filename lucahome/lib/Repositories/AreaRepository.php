<?php

/**
 * Helpful: https://docs.nextcloud.com/server/stable/developer_manual/app/storage/database.html
 */

namespace OCA\LucaHome\Repositories;

use OCA\LucaHome\Enums\ErrorCode;
use OCA\LucaHome\Entities\Area;
use OCP\DB\QueryBuilder\IQueryBuilder;
use OCP\IDBConnection;

class AreaRepository implements IAreaRepository {

    /** @var IDBConnection */
    private $db;

    public function __construct(IDBConnection $db) {
        $this->db = $db;
    }

	/**
	 * @brief returns all areas
	 * @return array Area
	 */
    public function get() {
        $qb = $this->db->getQueryBuilder();
        $qb
            ->select('*')
            ->from('areas');

        $cursor = $qb->execute();
        $result = $cursor->fetch();
        $cursor->closeCursor();

        return $result;
    }

	/**
	 * Add an Area
	 * @param Area area
	 * @return ErrorCode Success or failure of action
	 */
	public function add(Area $area) {
        $errorCode = validate($area);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }
        
        $qb = $this->db->getQueryBuilder();
		$qb
			->insert('areas')
			->values([
				'name' => $qb->createParameter('name'),
				'filter' => $qb->createParameter('filter')
			]);
        
        $qb->setParameters([
			'name' => trim($area->getName()),
			'filter' => trim($area->getFilter())
        ]);
        
        $cursor = $qb->execute();

		$insertId = $qb->getLastInsertId();
		if ($insertId !== false) {
			$this->eventDispatcher->dispatch(
				'\OCA\LucaHome::onAreaCreate',
				new GenericEvent(null, ['id' => $insertId])
            );
            
            $cursor->closeCursor();
			return $insertId;
        }
        
        return ErrorCode::AreaDbCreateError;
	}

	/**
	 * Update an Area
	 * @param Area area
	 * @return ErrorCode Success or failure of action
	 */
	public function update(Area $area) {
        $errorCode = validate($area);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }
        
		$qb = $this->db->getQueryBuilder();
		$qb
			->update('areas')
            ->set('name', $qb->createNamedParameter(trim($area->getName())))
            ->set('filter', $qb->createNamedParameter(trim($area->getFilter())))
			->where($qb->expr()->eq('id', $qb->createNamedParameter($id)));

        $cursor = $qb->execute();

		if ($cursor === 0) {
			return ErrorCode::AreaDbUpdateError;
		}

        $cursor->closeCursor();
        
		$this->eventDispatcher->dispatch(
			'\OCA\LucaHome::onAreaUpdate',
			new GenericEvent(null, ['id' => $id])
		);
        
        return ErrorCode::NoError;
	}
	
	/**
	 * @brief Delete Area with specific id
	 * @param int id Area ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(int $id) {
		$qb = $this->db->getQueryBuilder();
		$qb
			->select('id')
			->from('areas')
			->where($qb->expr()->eq('id', $qb->createNamedParameter($id)));

		$id = $qb->execute()->fetchColumn();
		if ($id === false) {
			return ErrorCode::AreaDoesNotExist;
		}

		$qb = $this->db->getQueryBuilder();
		$qb
			->delete('areas')
			->where($qb->expr()->eq('id', $qb->createNamedParameter($id)));
		$qb->execute();

		$this->eventDispatcher->dispatch(
			'\OCA\LucaHome::onAreaDelete',
			new GenericEvent(null, ['id' => $id])
		);

		return ErrorCode::NoError;
    }
    
	/**
	 * @brief Validates Area
	 * @param Area $area
	 * @return ErrorCode Area is valid or not
	 */
    private function validate(Area $area) {
        if(nameInUse($area->getName()) === true) {
            return ErrorCode::AreaNameAlreadyInUse;
        }

        if(codeInUse($area->getFilter()) === true) {
            return ErrorCode::AreaFilterAlreadyInUse;
        }

        if(strlen($area->getName()) > 128) {
            return ErrorCode::AreaNameTooLong;
        }

        if(strlen($area->getFilter()) > 128) {
            return ErrorCode::AreaFilterTooLong;
        }

        return ErrorCode::NoError;
    }

	/**
	 * @brief check if an area name is already in use
	 * @param string $name Area name possible in use
	 * @return bool|int the area id if existing, false otherwise
	 */
	private function nameInUse($name) {
		$qb = $this->db->getQueryBuilder();
		$qb
			->select('id')
			->from('areas')
			->where($qb->expr()->eq('name', $qb->createNamedParameter($name)));

        $cursor = $qb->execute();
        $result = $cursor->fetch();
        $cursor->closeCursor();
        
		if ($result) {
			return $result['id'];
        } 
        
        return false;
	}

	/**
	 * @brief check if an area filter is already in use
	 * @param string $filter Area filter possible in use
	 * @return bool|int the area id if existing, false otherwise
	 */
	private function filterInUse($filter) {
		$qb = $this->db->getQueryBuilder();
		$qb
			->select('id')
			->from('areas')
			->where($qb->expr()->eq('filter', $qb->createNamedParameter($filter)));

        $cursor = $qb->execute();
        $result = $cursor->fetch();
        $cursor->closeCursor();
        
		if ($result) {
			return $result['id'];
        } 
        
        return false;
	}
}
