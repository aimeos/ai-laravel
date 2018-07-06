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
		'address' => 'DELETE FROM "users_address" WHERE NOT EXISTS ( SELECT "id" FROM "users" AS u WHERE "parentid"=u."id" )',
		'list' => 'DELETE FROM "users_list" WHERE NOT EXISTS ( SELECT "id" FROM "users" AS u WHERE "parentid"=u."id" )',
	];


	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return array List of task names
	 */
	public function getPreDependencies()
	{
		return [];
	}


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return string[] List of task names
	 */
	public function getPostDependencies()
	{
		return array( 'TablesCreateMShop' );
	}


	/**
	 * Migrate database schema
	 */
	public function migrate()
	{
		$this->msg( 'Remove left over Laravel user address records', 0 );

		if( $this->schema->tableExists( 'users' ) && $this->schema->tableExists( 'users_address' ) )
		{
			$this->execute( $this->sql['address'] );
			$this->status( 'done' );
		}
		else
		{
			$this->status( 'OK' );
		}


		$this->msg( 'Remove left over Laravel user list records', 0 );

		if( $this->schema->tableExists( 'users' ) && $this->schema->tableExists( 'users_list' ) )
		{
			$this->execute( $this->sql['list'] );
			$this->status( 'done' );
		}
		else
		{
			$this->status( 'OK' );
		}
	}
}
