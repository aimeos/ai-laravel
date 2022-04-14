<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018-2022
 */


namespace Aimeos\Upscheme\Task;


/**
 * Removes address and list records without users entry
 */
class CustomerRemoveLostUserDataLaravel extends Base
{
	private $sql = [
		'users_address' => [
			'fk_lvuad_pid' => 'DELETE FROM users_address WHERE NOT EXISTS ( SELECT id FROM users AS u WHERE parentid=u.id )'
		],
		'users_list' => [
			'fk_lvuli_pid' => 'DELETE FROM users_list WHERE NOT EXISTS ( SELECT id FROM users AS u WHERE parentid=u.id )'
		],
		'users_property' => [
			'fk_lvupr_pid' => 'DELETE FROM users_property WHERE NOT EXISTS ( SELECT id FROM users AS u WHERE parentid=u.id )'
		],
	];


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return string[] List of task names
	 */
	public function before() : array
	{
		return ['Customer'];
	}


	/**
	 * Migrate database schema
	 */
	public function up()
	{
		$db = $this->db( 'db-customer' );

		if( !$db->hasTable( 'users' ) ) {
			return;
		}

		$this->info( 'Remove left over Laravel user references', 'vv' );

		foreach( $this->sql as $table => $map )
		{
			foreach( $map as $constraint => $sql )
			{
				if( $db->hasTable( $table ) && !$db->hasForeign( $table, $constraint ) )
				{
					$this->info( sprintf( 'Remove records from %1$s', $table ), 'vv', 1 );
					$db->exec( $sql );
				}
			}
		}
	}
}
