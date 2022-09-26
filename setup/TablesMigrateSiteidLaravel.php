<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2019-2022
 */


namespace Aimeos\Upscheme\Task;


/**
 * Updates site ID columns
 */
class TablesMigrateSiteidLaravel extends TablesMigrateSiteid
{
	private $resources = [
		'db-customer' => [
			'users_list_type', 'users_property_type',
			'users_property', 'users_list', 'users_address', 'users',
		],
	];


	/**
	 * Returns the list of task names which depend on this task.
	 *
	 * @return string[] List of task names
	 */
	public function before() : array
	{
		return ['Customer', 'TablesMigrateSiteid'];
	}


	/**
	 * Executes the task
	 */
	public function up()
	{
		$db = $this->db( 'db-locale' );

		if( !$db->hasTable( 'mshop_locale_site' ) || $db->hasColumn( 'mshop_locale_site', 'siteid' ) ) {
			return;
		}

		$this->info( 'Update Laravel "siteid" columns', 'vv' );

		$this->process( $this->resources );

		$db = $this->db( 'db-customer' );

		if( $db->hasColumn( 'users', 'siteid' ) ) {
			$db->exec( 'UPDATE users SET siteid=\'\' WHERE siteid IS NULL' );
		}
	}
}
