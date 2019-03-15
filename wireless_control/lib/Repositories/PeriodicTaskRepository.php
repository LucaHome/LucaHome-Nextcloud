<?php

/**
 * Helpful: https://docs.nextcloud.com/server/stable/developer_manual/app/storage/database.html
 */

namespace OCA\WirelessControl\Repositories;

use OCA\WirelessControl\Enums\ErrorCode;
use OCA\WirelessControl\Entities\PeriodicTask;
use OCP\DB\QueryBuilder\IQueryBuilder;
use OCP\IDBConnection;
use OCP\ILogger;

class PeriodicTaskRepository implements IPeriodicTaskRepository {

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
    public function __construct(string $appName, IDBConnection $db, ILogger $logger) {
        $this->appName = $appName;
        $this->db = $db;
        $this->logger = $logger;
    }

	/**
	 * @brief returns all PeriodicTasks
	 * @return array PeriodicTask
	 */
    public function get() {
		$this->logger->info('PeriodicTaskRepository: Get', ['app' => $this->appName]);

        $qb = $this->db->getQueryBuilder();
        $qb
            ->select('*')
            ->from('wireless_control_periodic_tasks');
        $periodicTasks = $qb->execute()->fetchAll();
        return $periodicTasks;
    }

	/**
	 * @brief returns single PeriodicTask by id
	 * @param int id PeriodicTask ID to get
	 * @return PeriodicTask PeriodicTask
	 */
    public function getById(int $id) {
		$this->logger->info('PeriodicTaskRepository: GetById: '.$id, ['app' => $this->appName]);

        $qb = $this->db->getQueryBuilder();
        $qb
            ->select('*')
            ->from('wireless_control_periodic_tasks')
			->where($qb->expr()->eq('id', $qb->createNamedParameter($id)));
        $periodicTasks = $qb->execute()->fetchAll();
        return reset($periodicTasks);
    }

	/**
	 * Add a PeriodicTask
	 * @param PeriodicTask periodicTask
	 * @return ErrorCode Success or failure of action
	 */
	public function add(PeriodicTask $periodicTask) {
		$this->logger->info('PeriodicTaskRepository: Add: '.$periodicTask, ['app' => $this->appName]);

        $qb = $this->db->getQueryBuilder();
		$qb
			->insert('wireless_control_periodic_tasks')
			->values([
				'name' => $qb->createNamedParameter(trim($periodicTask->getName())),
				'wirelessSocketId' => $qb->createNamedParameter($periodicTask->getWirelessSocketId()),
				'wirelessSocketState' => $qb->createNamedParameter($periodicTask->getWirelessSocketState()),
				'weekday' => $qb->createNamedParameter($periodicTask->getWeekday()),
				'hour' => $qb->createNamedParameter($periodicTask->getHour()),
				'minute' => $qb->createNamedParameter($periodicTask->getMinute()),
				'periodic' => $qb->createNamedParameter($periodicTask->getPeriodic()),
				'active' => $qb->createNamedParameter($periodicTask->getActive())
			]);

		if ($qb->execute()) {
			return $qb->getLastInsertId();
		} else {
			$this->logger->info('PeriodicTaskRepository: Add: Failed: '.ErrorCode::PeriodicTaskDbAddError, ['app' => $this->appName]);
			return ErrorCode::PeriodicTaskDbAddError;
		}
	}

	/**
	 * Update a PeriodicTask
	 * @param PeriodicTask periodicTask
	 * @return ErrorCode Success or failure of action
	 */
	public function update(PeriodicTask $periodicTask) {
		$this->logger->info('PeriodicTaskRepository: Update: '.$periodicTask, ['app' => $this->appName]);

        $errorCode = $this->validate($periodicTask);
        if($errorCode !== ErrorCode::NoError){
			$this->logger->info('PeriodicTaskRepository: Update: Validation: '.$errorCode, ['app' => $this->appName]);
            return $errorCode;
        }
        
		$qb = $this->db->getQueryBuilder();
		$qb
			->update('wireless_control_periodic_tasks')
            ->set('name', $qb->createNamedParameter(trim($periodicTask->getName())))
            ->set('wirelessSocketId', $qb->createNamedParameter($periodicTask->getWirelessSocketId()))
            ->set('wirelessSocketState', $qb->createNamedParameter($periodicTask->getWirelessSocketState()))
            ->set('weekday', $qb->createNamedParameter($periodicTask->getWeekday()))
            ->set('hour', $qb->createNamedParameter($periodicTask->getHour()))
            ->set('minute', $qb->createNamedParameter($periodicTask->getMinute()))
            ->set('periodic', $qb->createNamedParameter($periodicTask->getPeriodic()))
            ->set('active', $qb->createNamedParameter($periodicTask->getActive()))
			->where($qb->expr()->eq('id', $qb->createNamedParameter($periodicTask->getId())));

		if ($qb->execute() === 0) {
			$this->logger->info('PeriodicTaskRepository: Update: Failed: '.ErrorCode::PeriodicTaskDbUpdateError, ['app' => $this->appName]);
			return ErrorCode::PeriodicTaskDbUpdateError;
		}

        return ErrorCode::NoError;
	}
	
	/**
	 * @brief Delete PeriodicTask with specific id
	 * @param int id PeriodicTask ID to delete
	 * @return ErrorCode Success or failure of action
	 */
	public function delete(int $id) {
		$this->logger->info('PeriodicTaskRepository: Delete: '.$id, ['app' => $this->appName]);

		$qb = $this->db->getQueryBuilder();
		$qb
			->delete('wireless_control_periodic_tasks')
			->where($qb->expr()->eq('id', $qb->createNamedParameter($id)));
		
		if ($qb->execute() === 0) {
			$this->logger->info('PeriodicTaskRepository: Delete: Failed: '.ErrorCode::PeriodicTaskDoesNotExist, ['app' => $this->appName]);
			return ErrorCode::PeriodicTaskDoesNotExist;
		}

        return ErrorCode::NoError;
    }
	
	/**
	 * @brief Delete PeriodicTask with specific wirelessSocketId
	 * @param int wirelessSocketId Delete PeriodicTasks by this wirelessSocketId
	 * @return ErrorCode Success or failure of action
	 */
	public function deleteByWirelessSocketId(int $wirelessSocketId) {
		$this->logger->info('PeriodicTaskRepository: DeleteByWirelessSocketId: '.$wirelessSocketId, ['app' => $this->appName]);

		$qb = $this->db->getQueryBuilder();
		$qb
			->delete('wireless_control_periodic_tasks')
			->where($qb->expr()->eq('wirelessSocketId', $qb->createNamedParameter($wirelessSocketId)));
		$qb->execute();

        return ErrorCode::NoError;
    }
    
	/**
	 * @brief Validates PeriodicTask
	 * @param PeriodicTask $periodicTask
	 * @return ErrorCode PeriodicTask is valid or not
	 */
    private function validate(PeriodicTask $periodicTask) {
        if(strlen($periodicTask->getName()) > 128) {
            return ErrorCode::PeriodicTaskNameTooLong;
        }

        if($periodicTask->getWirelessSocketState() < 0 || $periodicTask->getWirelessSocketState() > 1) {
            return ErrorCode::PeriodicTaskInvalidWirelessSocketState;
        }

        if($periodicTask->getWeekday() < 1 || $periodicTask->getWeekday() > 7) {
            return ErrorCode::PeriodicTaskInvalidWeekday;
        }

        if($periodicTask->getHour() < 0 || $periodicTask->getHour() > 23) {
            return ErrorCode::PeriodicTaskInvalidHour;
        }

        if($periodicTask->getMinute() < 0 || $periodicTask->getMinute() > 59) {
            return ErrorCode::PeriodicTaskInvalidMinute;
        }

        if($periodicTask->getPeriodic() < 0 || $periodicTask->getPeriodic() > 1) {
            return ErrorCode::PeriodicTaskInvalidPeriodic;
        }

        if($periodicTask->getActive() < 0 || $periodicTask->getActive() > 1) {
            return ErrorCode::PeriodicTaskInvalidActive;
        }

        return ErrorCode::NoError;
    }
}
