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
class Version000000001Date20190225144525 extends SimpleMigrationStep {
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
        
		if (!$schema->hasTable('lucahome_wireless_socket')) {
			$table = $schema->createTable('lucahome_wireless_socket');
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
        
		if (!$schema->hasTable('lucahome_area')) {
			$table = $schema->createTable('lucahome_area');
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
		$qb->insert('lucahome_area')
			->values([
				'name' => $qb->createNamedParameter('All'),
				'filter' => $qb->createNamedParameter(''),
				'deletable' => $qb->createNamedParameter(0)
			])
			->execute();
	}
}
