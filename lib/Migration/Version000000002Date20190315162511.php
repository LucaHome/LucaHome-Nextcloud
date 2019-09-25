<?php

/**
 * Helpful: https://github.com/nextcloud/bookmarks/blob/master/lib/Migration/Version000014000Date20181002094721.php
 */

namespace OCA\WirelessControl\Migration;

use OCP\DB\ISchemaWrapper;
use OCP\Migration\SimpleMigrationStep;
use OCP\Migration\IOutput;
use OCP\IDBConnection;

/**
 * Auto-generated migration step: Please modify to your needs!
 */
class Version000000002Date20190315162511 extends SimpleMigrationStep
{
	private $db;

	public function __construct(IDBConnection $db)
	{
		$this->db = $db;
	}

	/**
	 * @param IOutput $output
	 * @param \Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 */
	public function preSchemaChange(IOutput $output, \Closure $schemaClosure, array $options)
	{ }

	/**
	 * @param IOutput $output
	 * @param \Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 * @return null|ISchemaWrapper
	 */
	public function changeSchema(IOutput $output, \Closure $schemaClosure, array $options)
	{
		/** @var ISchemaWrapper $schema */
		$schema = $schemaClosure();

		if (!$schema->hasTable('wireless_control_periodic_tasks')) {
			$table = $schema->createTable('wireless_control_periodic_tasks');
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
			$table->addColumn('wirelessSocketId', 'bigint', [
				'notnull' => true,
				'length' => 64,
				'default' => -1,
			]);
			$table->addColumn('wirelessSocketState', 'smallint', [
				'notnull' => true,
				'length' => 1,
				'default' => 1,
			]);
			$table->addColumn('weekday', 'bigint', [
				'notnull' => true,
				'length' => 64,
				'default' => -1,
			]);
			$table->addColumn('hour', 'bigint', [
				'notnull' => true,
				'length' => 64,
				'default' => -1,
			]);
			$table->addColumn('minute', 'bigint', [
				'notnull' => true,
				'length' => 64,
				'default' => -1,
			]);
			$table->addColumn('periodic', 'smallint', [
				'notnull' => true,
				'length' => 1,
				'default' => 1,
			]);
			$table->addColumn('active', 'smallint', [
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
	public function postSchemaChange(IOutput $output, \Closure $schemaClosure, array $options)
	{ }
}
