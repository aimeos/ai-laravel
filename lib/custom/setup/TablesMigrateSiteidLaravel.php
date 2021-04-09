<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2019-2021
 */


namespace Aimeos\MW\Setup\Task;


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
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies() : array
	{
		return ['TablesMigrateSiteid'];
	}


	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
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
		$this->msg( 'Update Laravel "siteid" columns', 0, '' );

		$this->process( $this->resources );

		if( $this->getSchema( 'db-customer' )->tableExists( 'users' ) !== false ) {
			$this->execute( 'UPDATE users SET siteid=\'\' WHERE siteid IS NULL' );
		}
	}
}
