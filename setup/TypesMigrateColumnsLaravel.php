<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018-2023
 */


namespace Aimeos\Upscheme\Task;


/**
 * Adds the new type columns
 */
class TypesMigrateColumnsLaravel extends TypesMigrateColumns
{
	private $tables = [
		'db-customer' => ['users_list', 'users_property'],
	];

	private $constraints = [
		'db-customer' => ['users_list' => 'unq_lvuli_sid_dm_rid_tid_pid', 'users_property' => 'unq_lvupr_sid_tid_lid_value'],
	];

	private $migrations = [
		'db-customer' => [
			'users_list' => 'UPDATE users_list SET type = ( SELECT code FROM users_list_type AS t WHERE t.id = typeid AND t.domain = domain ) WHERE type = \'\'',
			'users_property' => 'UPDATE users_property SET type = ( SELECT code FROM users_property_type AS t WHERE t.id = typeid AND t.domain = domain ) WHERE type = \'\'',
		],
	];

	private $drops = [
		'db-customer' => ['users_list' => 'fk_lvuli_typeid', 'users_property' => 'fk_lvupr_typeid'],
	];


	/**
	 * Executes the task
	 */
	public function up()
	{
		$db = $this->db( 'db-customer' );

		if( !$db->hasTable( 'users' ) ) {
			return;
		}

		$this->info( 'Migrate typeid to type for Laravel', 'vv' );

		$this->info( 'Add new type columns for Laravel', 'vv', 1 );

		foreach( $this->tables as $rname => $list ) {
			$this->addColumn( $rname, $list );
		}

		$this->info( 'Drop old unique indexes for Laravel', 'vv', 1 );

		foreach( $this->constraints as $rname => $list ) {
			$this->dropIndex( $rname, $list );
		}

		$this->info( 'Migrate typeid to type for Laravel', 'vv', 1 );

		foreach( $this->migrations as $rname => $list ) {
			$this->migrateData( $rname, $list );
		}

		$this->info( 'Drop typeid columns for Laravel', 'vv', 1 );

		foreach( $this->drops as $rname => $list ) {
			$this->dropColumn( $rname, $list );
		}
	}
}
