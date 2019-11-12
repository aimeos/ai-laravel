<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Removes address and list records without users entry
 */
class CustomerRemoveLostUserDataLaravel extends \Aimeos\MW\Setup\Task\Base
{
	private $sql = [
		'users_address' => 'DELETE FROM "users_address" WHERE NOT EXISTS ( SELECT "id" FROM "users" AS u WHERE "parentid"=u."id" )',
		'users_list' => 'DELETE FROM "users_list" WHERE NOT EXISTS ( SELECT "id" FROM "users" AS u WHERE "parentid"=u."id" )',
		'users_property' => 'DELETE FROM "users_property" WHERE NOT EXISTS ( SELECT "id" FROM "users" AS u WHERE "parentid"=u."id" )',
	];


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return string[] List of task names
	 */
	public function getPostDependencies() : array
	{
		return ['TablesCreateMShop'];
	}


	/**
	 * Migrate database schema
	 */
	public function migrate()
	{
		$this->msg( 'Remove left over Laravel user references', 0, '' );

		foreach( $this->sql as $table => $stmt )
		{
			$this->msg( sprintf( 'Remove unused %1$s records', $table ), 1 );

			if( $this->schema->tableExists( 'users' ) && $this->schema->tableExists( $table ) )
			{
				$this->execute( $stmt );
				$this->status( 'done' );
			}
			else
			{
				$this->status( 'OK' );
			}
		}
	}
}
