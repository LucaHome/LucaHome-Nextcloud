<?php

/**
 * Helpful: https://github.com/nextcloud/bookmarks/blob/master/lib/Migration/Version000014000Date20181002094721.php
 */

namespace OCA\LucaHome\Migration;

use \OCP\DB\ISchemaWrapper;
use \OCP\Migration\SimpleMigrationStep;
use \OCP\Migration\IOutput;
use \OCP\IDBConnection;

/**
 * Auto-generated migration step: Please modify to your needs!
 */
class Version000000001Date20190215233732 extends SimpleMigrationStep {
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
        
		if (!$schema->hasTable('wirelesssockets')) {
			$table = $schema->createTable('wirelesssockets');
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
			
			$table->setPrimaryKey(['id']);
        }
        
		if (!$schema->hasTable('areas')) {
			$table = $schema->createTable('areas');
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
	}
}