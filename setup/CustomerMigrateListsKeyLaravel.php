<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2019-2024
 */


namespace Aimeos\Upscheme\Task;


/**
 * Updates key columns
 */
class CustomerMigrateListsKeyLaravel extends TablesMigrateListsKey
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function after() : array
	{
		return ['TablesMigrateListsKey'];
	}


	/**
	 * Executes the task
	 */
	public function up()
	{
		$this->info( 'Update Laravel lists "key" columns', 'vv' );

		$this->process( ['db-customer' => 'users_list'] );
	}
}
