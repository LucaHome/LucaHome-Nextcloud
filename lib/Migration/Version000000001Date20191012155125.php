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
class Version000000001Date20190306220234 extends SimpleMigrationStep
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
	{
		/** @var ISchemaWrapper $schema */
		$schema = $schemaClosure();

		if ($schema->hasTable('wireless_control_sockets')) {
			$schema->dropTable('wireless_control_sockets');
		}

		if ($schema->hasTable('wireless_control_areas')) {
			$schema->dropTable('wireless_control_areas');
		}

		if ($schema->hasTable('wireless_control_periodictasks')) {
			$schema->dropTable('wireless_control_periodictasks');
		}
	}

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

		if (!$schema->hasTable('wc_sockets')) {
			$table = $schema->createTable('wc_sockets');
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
			$table->addColumn('lastToggled', 'bigint', [
				'notnull' => true,
				'length' => 64,
			]);
			$table->addColumn('group', 'string', [
				'notnull' => true,
				'length' => 64,
				'default' => '',
			]);

			$table->setPrimaryKey(['id']);
		}

		if (!$schema->hasTable('wc_areas')) {
			$table = $schema->createTable('wc_areas');
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

		if (!$schema->hasTable('wc_ptasks')) {
			$table = $schema->createTable('wc_ptasks');
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
	{
		// Add area "All"
		$qb = $this->db->getQueryBuilder();
		$qb->insert('wc_areas')
			->values([
				'name' => $qb->createNamedParameter('All'),
				'filter' => $qb->createNamedParameter(''),
				'deletable' => $qb->createNamedParameter(0)
			])
			->execute();

		// Add area "Living Room"
		$qb = $this->db->getQueryBuilder();
		$qb->insert('wc_areas')
			->values([
				'name' => $qb->createNamedParameter('Living Room'),
				'filter' => $qb->createNamedParameter('Living Room'),
				'deletable' => $qb->createNamedParameter(1)
			])
			->execute();

		// Add area "Sleeping Room"
		$qb = $this->db->getQueryBuilder();
		$qb->insert('wc_areas')
			->values([
				'name' => $qb->createNamedParameter('Sleeping Room'),
				'filter' => $qb->createNamedParameter('Sleeping Room'),
				'deletable' => $qb->createNamedParameter(1)
			])
			->execute();

		// Add area "Kitchen"
		$qb = $this->db->getQueryBuilder();
		$qb->insert('wc_areas')
			->values([
				'name' => $qb->createNamedParameter('Kitchen'),
				'filter' => $qb->createNamedParameter('Kitchen'),
				'deletable' => $qb->createNamedParameter(1)
			])
			->execute();

		// Add area "Bath"
		$qb = $this->db->getQueryBuilder();
		$qb->insert('wc_areas')
			->values([
				'name' => $qb->createNamedParameter('Bath'),
				'filter' => $qb->createNamedParameter('Bath'),
				'deletable' => $qb->createNamedParameter(1)
			])
			->execute();

		// Add wireless socket "PC"
		$qb = $this->db->getQueryBuilder();
		$qb->insert('wc_sockets')
			->values([
				'name' => $qb->createNamedParameter('PC'),
				'code' => $qb->createNamedParameter('11110A'),
				'area' => $qb->createNamedParameter('Living Room'),
				'state' => $qb->createNamedParameter(0),
				'description' => $qb->createNamedParameter(''),
				'icon' => $qb->createNamedParameter('fas fa-desktop'),
				'deletable' => $qb->createNamedParameter(1),
				'lastToggled' => $qb->createNamedParameter(time()),
				'group' =>  $qb->createNamedParameter('')
			])
			->execute();

		// Add wireless socket "TV"
		$qb = $this->db->getQueryBuilder();
		$qb->insert('wc_sockets')
			->values([
				'name' => $qb->createNamedParameter('TV'),
				'code' => $qb->createNamedParameter('11110B'),
				'area' => $qb->createNamedParameter('Living Room'),
				'state' => $qb->createNamedParameter(0),
				'description' => $qb->createNamedParameter(''),
				'icon' => $qb->createNamedParameter('fas fa-tv'),
				'deletable' => $qb->createNamedParameter(1),
				'lastToggled' => $qb->createNamedParameter(time()),
				'group' =>  $qb->createNamedParameter('')
			])
			->execute();

		// Add wireless socket "Light Couch"
		$qb = $this->db->getQueryBuilder();
		$qb->insert('wc_sockets')
			->values([
				'name' => $qb->createNamedParameter('Light Couch'),
				'code' => $qb->createNamedParameter('11110C'),
				'area' => $qb->createNamedParameter('Living Room'),
				'state' => $qb->createNamedParameter(0),
				'description' => $qb->createNamedParameter(''),
				'icon' => $qb->createNamedParameter('fas fa-lightbulb'),
				'deletable' => $qb->createNamedParameter(1),
				'lastToggled' => $qb->createNamedParameter(time()),
				'group' =>  $qb->createNamedParameter('')
			])
			->execute();

		// Add wireless socket "Nintendo Switch"
		$qb = $this->db->getQueryBuilder();
		$qb->insert('wc_sockets')
			->values([
				'name' => $qb->createNamedParameter('Nintendo Switch'),
				'code' => $qb->createNamedParameter('11011A'),
				'area' => $qb->createNamedParameter('Living Room'),
				'state' => $qb->createNamedParameter(0),
				'description' => $qb->createNamedParameter(''),
				'icon' => $qb->createNamedParameter('fab fa-nintendo-switch'),
				'deletable' => $qb->createNamedParameter(1),
				'lastToggled' => $qb->createNamedParameter(time()),
				'group' =>  $qb->createNamedParameter('')
			])
			->execute();

		// Add wireless socket "Light Bed"
		$qb = $this->db->getQueryBuilder();
		$qb->insert('wc_sockets')
			->values([
				'name' => $qb->createNamedParameter('Light Bed'),
				'code' => $qb->createNamedParameter('11011D'),
				'area' => $qb->createNamedParameter('Sleeping Room'),
				'state' => $qb->createNamedParameter(0),
				'description' => $qb->createNamedParameter(''),
				'icon' => $qb->createNamedParameter('fas fa-lightbulb'),
				'deletable' => $qb->createNamedParameter(1),
				'lastToggled' => $qb->createNamedParameter(time()),
				'group' =>  $qb->createNamedParameter('')
			])
			->execute();
	}
}
