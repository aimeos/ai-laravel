<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2021
 */


namespace Aimeos\Upscheme\Task;


/**
 * Removes constraints from users_* tables before migrating to bigint (Laravel 8)
 */
class CustomerRemoveConstraints extends Base
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

		if( !$db->hasColumn( 'users', 'id' ) || $db->table( 'users')->col( 'id' )->type() === 'bigint' ) {
			return;
		}

		$this->info( sprintf( 'Remove constraints in users related tables' ), 'v' );

		$db->dropForeign( 'users_address', 'fk_lvuad_pid' );
		$db->dropForeign( 'users_property', 'fk_lvupr_pid' );
		$db->dropForeign( 'users_list', 'fk_lvuli_pid' );
	}
}
