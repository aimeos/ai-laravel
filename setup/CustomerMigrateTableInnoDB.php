<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2022-2023
 */


namespace Aimeos\Upscheme\Task;


/**
 * Changes the table type to InnoDB
 */
class CustomerMigrateTableInnoDB extends Base
{
	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return array List of task names
	 */
	public function before() : array
	{
		return ['Customer'];
	}


	/**
	 * Executes the task
	 */
	public function up()
	{
		$db = $this->db( 'db-customer' );

		if( !$db->hasTable( 'users' ) ) {
			return;
		}

		$this->info( sprintf( 'Migrate users table engine to InnoDB' ), 'vv' );

		$db->for( 'mysql', 'ALTER TABLE users ENGINE=InnoDB' );
	}
}
