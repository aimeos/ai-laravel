<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2019
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Updates the charset and collations
 */
class TablesUpdateCharsetCollationLaravel extends \Aimeos\MW\Setup\Task\TablesUpdateCharsetCollation
{
	private $tables = [
		'db-customer' => [
			'users' => 'code', 'users_address' => 'email',
			'users_list_type' => 'code', 'users_list' => 'refid',
			'users_property_type' => 'code', 'users_property' => 'value',
		],
	];


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return array List of task names
	 */
	public function getPostDependencies() : array
	{
		return ['TablesCreateMShop'];
	}


	/**
	 * Executes the task
	 */
	public function migrate()
	{
		$this->msg( 'Update charset and collation for Laravel tables', 0 );
		$this->status( '' );

		foreach( $this->tables as $rname => $list ) {
			$this->checkTables( $list, $rname );
		}
	}
}
