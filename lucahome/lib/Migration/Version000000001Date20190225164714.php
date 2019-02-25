<?php

/**
 * Helpful: https://github.com/nextcloud/bookmarks/blob/master/lib/Migration/Version000014000Date20181002094721.php
 */

namespace OCA\LucaHome\Migration;

use OCP\DB\ISchemaWrapper;
use OCP\Migration\SimpleMigrationStep;
use OCP\Migration\IOutput;
use OCP\IDBConnection;

/**
 * Auto-generated migration step: Please modify to your needs!
 */
class Version000000001Date20190225164714 extends SimpleMigrationStep {
    private $db;
    
	public function __construct(IDBConnection $db) {
		$this->db = $db;
    }
    
	/**
	 * @param IOutput $output
	 * @param \Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 */
	public function preSchemaChange(IOutput $output, \Closure $schemaClosure, array $options) {
    }
    
	/**
	 * @param IOutput $output
	 * @param \Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 * @return null|ISchemaWrapper
	 */
	public function changeSchema(IOutput $output, \Closure $schemaClosure, array $options) {
		/** @var ISchemaWrapper $schema */
        $schema = $schemaClosure();
        
		if (!$schema->hasTable('lh_wireless_socket')) {
			$table = $schema->createTable('lh_wireless_socket');
			$table->addColumn('id', 'bigint', [
				'autoincrement' => true,
				'notnull' => true,
				'length' => 64,
            ]);
            
			$table->addColumn('name', 'string', [
				'notnull' => true,
				'length' => 128,
				'default' => '',
			]);
			$table->addColumn('code', 'string', [
				'notnull' => true,
				'length' => 6,
				'default' => '',
			]);
			$table->addColumn('area', 'string', [
				'notnull' => true,
				'length' => 128,
				'default' => '',
			]);
			$table->addColumn('state', 'smallint', [
				'notnull' => true,
				'length' => 1,
				'default' => 0,
            ]);
			$table->addColumn('description', 'string', [
				'notnull' => true,
				'length' => 4096,
				'default' => '',
			]);
			$table->addColumn('icon', 'string', [
				'notnull' => true,
				'length' => 32,
				'default' => '',
			]);
			$table->addColumn('deletable', 'smallint', [
				'notnull' => true,
				'length' => 1,
				'default' => 1,
            ]);
			
			$table->setPrimaryKey(['id']);
        }
        
		if (!$schema->hasTable('lh_area')) {
			$table = $schema->createTable('lh_area');
			$table->addColumn('id', 'bigint', [
				'autoincrement' => true,
				'notnull' => true,
				'length' => 64,
            ]);
            
			$table->addColumn('name', 'string', [
				'notnull' => true,
				'length' => 128,
				'default' => '',
			]);
			$table->addColumn('filter', 'string', [
				'notnull' => true,
				'length' => 128,
				'default' => '',
			]);
			$table->addColumn('deletable', 'smallint', [
				'notnull' => true,
				'length' => 1,
				'default' => 1,
            ]);

			$table->setPrimaryKey(['id']);
        }
        
		return $schema;
    }
    
	/**
	 * @param IOutput $output
	 * @param \Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 */
	public function postSchemaChange(IOutput $output, \Closure $schemaClosure, array $options) {
		// Add area "All"
        $qb = $this->db->getQueryBuilder();
		$qb->insert('lh_area')
			->values([
				'name' => $qb->createNamedParameter('All'),
				'filter' => $qb->createNamedParameter(''),
				'deletable' => $qb->createNamedParameter(0)
			])
			->execute();

		// Add area "LivingRoom"
		$qb = $this->db->getQueryBuilder();
		$qb->insert('lh_area')
			->values([
				'name' => $qb->createNamedParameter('LivingRoom'),
				'filter' => $qb->createNamedParameter('LivingRoom'),
				'deletable' => $qb->createNamedParameter(1)
			])
			->execute();

		// Add area "SleepingRoom"
		$qb = $this->db->getQueryBuilder();
		$qb->insert('lh_area')
			->values([
				'name' => $qb->createNamedParameter('SleepingRoom'),
				'filter' => $qb->createNamedParameter('SleepingRoom'),
				'deletable' => $qb->createNamedParameter(1)
			])
			->execute();

		// Add area "Kitchen"
		$qb = $this->db->getQueryBuilder();
		$qb->insert('lh_area')
			->values([
				'name' => $qb->createNamedParameter('Kitchen'),
				'filter' => $qb->createNamedParameter('Kitchen'),
				'deletable' => $qb->createNamedParameter(1)
			])
			->execute();

		// Add area "Bath"
		$qb = $this->db->getQueryBuilder();
		$qb->insert('lh_area')
			->values([
				'name' => $qb->createNamedParameter('Bath'),
				'filter' => $qb->createNamedParameter('Bath'),
				'deletable' => $qb->createNamedParameter(1)
			])
			->execute();

		// Add wireless socket "PC"
		$qb = $this->db->getQueryBuilder();
		$qb->insert('lh_wireless_socket')
			->values([
				'name' => $qb->createNamedParameter('PC'),
				'code' => $qb->createNamedParameter('11110A'),
				'area' => $qb->createNamedParameter('LivingRoom'),
				'state' => $qb->createNamedParameter(0),
				'description' => $qb->createNamedParameter(''),
				'icon' => $qb->createNamedParameter('fas fa-desktop'),
				'deletable' => $qb->createNamedParameter(1)
			])
			->execute();

		// Add wireless socket "TV"
		$qb = $this->db->getQueryBuilder();
		$qb->insert('lh_wireless_socket')
			->values([
				'name' => $qb->createNamedParameter('TV'),
				'code' => $qb->createNamedParameter('11110B'),
				'area' => $qb->createNamedParameter('LivingRoom'),
				'state' => $qb->createNamedParameter(0),
				'description' => $qb->createNamedParameter(''),
				'icon' => $qb->createNamedParameter('fas fa-tv'),
				'deletable' => $qb->createNamedParameter(1)
			])
			->execute();

		// Add wireless socket "LightCouch"
		$qb = $this->db->getQueryBuilder();
		$qb->insert('lh_wireless_socket')
			->values([
				'name' => $qb->createNamedParameter('LightCouch'),
				'code' => $qb->createNamedParameter('11110C'),
				'area' => $qb->createNamedParameter('LivingRoom'),
				'state' => $qb->createNamedParameter(0),
				'description' => $qb->createNamedParameter(''),
				'icon' => $qb->createNamedParameter('fas fa-lightbulb'),
				'deletable' => $qb->createNamedParameter(1)
			])
			->execute();

		// Add wireless socket "OSMC"
		$qb = $this->db->getQueryBuilder();
		$qb->insert('lh_wireless_socket')
			->values([
				'name' => $qb->createNamedParameter('OSMC'),
				'code' => $qb->createNamedParameter('11110D'),
				'area' => $qb->createNamedParameter('LivingRoom'),
				'state' => $qb->createNamedParameter(0),
				'description' => $qb->createNamedParameter(''),
				'icon' => $qb->createNamedParameter('fas fa-film'),
				'deletable' => $qb->createNamedParameter(1)
			])
			->execute();

		// Add wireless socket "NintendoSwitch"
		$qb = $this->db->getQueryBuilder();
		$qb->insert('lh_wireless_socket')
			->values([
				'name' => $qb->createNamedParameter('NintendoSwitch'),
				'code' => $qb->createNamedParameter('11011A'),
				'area' => $qb->createNamedParameter('LivingRoom'),
				'state' => $qb->createNamedParameter(0),
				'description' => $qb->createNamedParameter(''),
				'icon' => $qb->createNamedParameter('fab fa-nintendo-switch'),
				'deletable' => $qb->createNamedParameter(1)
			])
			->execute();
	}
}
