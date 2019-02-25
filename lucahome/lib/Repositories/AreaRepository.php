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
            ->from('lucahome_area');
        $areas = $qb->execute()->fetchAll();
        return $areas;
    }

	/**
	 * Add an Area
	 * @param Area area
	 * @return ErrorCode Success or failure of action
	 */
	public function add(Area $area) {
        $qb = $this->db->getQueryBuilder();
		$qb
			->insert('lucahome_area')
			->values([
				'name' => $qb->createNamedParameter(trim($area->getName())),
				'filter' => $qb->createNamedParameter(trim($area->getFilter())),
				'deletable' => $qb->createNamedParameter($area->getDeletable())
			]);

		if ($qb->execute()) {
			return $qb->getLastInsertId();
		} else {
			return false;
		}
	}

	/**
	 * Update an Area
	 * @param Area area
	 * @return ErrorCode Success or failure of action
	 */
	public function update(Area $area) {
        $errorCode = $this->validate($area);
        if($errorCode !== ErrorCode::NoError){
            return $errorCode;
        }
        
		$qb = $this->db->getQueryBuilder();
		$qb
			->update('lucahome_area')
            ->set('name', $qb->createNamedParameter(trim($area->getName())))
            ->set('filter', $qb->createNamedParameter(trim($area->getFilter())))
            ->set('deletable', $qb->createNamedParameter($area->getDeletable()))
			->where($qb->expr()->eq('id', $qb->createNamedParameter($area->getId())));

		if ($qb->execute() === 0) {
			return ErrorCode::AreaDbUpdateError;
		}

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
			->delete('lucahome_area')
			->where($qb->expr()->eq('id', $qb->createNamedParameter($id)))
			->andWhere($qb->expr()->eq('deletable', 1));
		
		if ($qb->execute() === 0) {
			return ErrorCode::AreaDoesNotExist;
		}

        return ErrorCode::NoError;
    }
    
	/**
	 * @brief Validates Area
	 * @param Area $area
	 * @return ErrorCode Area is valid or not
	 */
    private function validate(Area $area) {
        if($this->nameInUse($area->getName()) === true) {
            return ErrorCode::AreaNameAlreadyInUse;
        }

        if($this->filterInUse($area->getFilter()) === true) {
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
			->from('lucahome_area')
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
			->from('lucahome_area')
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
