<?php

/**
 * Helpful: https://github.com/nextcloud/bookmarks/blob/master/lib/Migration/Version000014000Date20181002094721.php
 * https://docs.nextcloud.com/server/15/developer_manual/app/storage/migrations.html
 */

namespace OCA\WirelessControl\Migration;

use OCP\DB\ISchemaWrapper;
use OCP\Migration\SimpleMigrationStep;
use OCP\Migration\IOutput;
use OCP\IDBConnection;

/**
 * Auto-generated migration step: Please modify to your needs!
 */
class Version000000003Date20190923213615 extends SimpleMigrationStep
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

		$table = $schema->getTable('wireless_control_sockets');

		$table->addColumn('lastToggled', 'bigint', [
			'notnull' => true,
			'length' => 64,
		]);

		$table->addColumn('group', 'string', [
			'notnull' => true,
			'length' => 64,
			'default' => '',
		]);

		return $schema;
	}

	/**
	 * @param IOutput $output
	 * @param \Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 */
	public function postSchemaChange(IOutput $output, \Closure $schemaClosure, array $options)
	{
		$query = $this->db->getQueryBuilder();
		$query->update('wireless_control_sockets')->set('lastToggled', time());
		$query->execute();
	}
}
