<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2021
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Removes constraints from users_* tables before migrating to bigint (Laravel 8)
 */
class CustomerRemoveConstraints extends \Aimeos\MW\Setup\Task\Base
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies() : array
	{
		return ['CustomerChangeAddressRefidParentidLaravel'];
	}


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
		$schema = $this->getSchema( 'db-customer' );
		$type = $schema->getColumnDetails( 'users', 'id' )->getDataType();

		if( $type !== 'bigint' )
		{
			$this->msg( sprintf( 'Remove constraints in users related tables' ), 0 );
			$this->status( '' );


			$this->msg( 'Checking constraint in "users_address"', 1 );

			if( $schema->constraintExists( 'users_address', 'fk_lvuad_pid' ) )
			{
				$this->execute( 'ALTER TABLE "users_address" DROP FOREIGN KEY "fk_lvuad_pid"', 'db-customer' );
				$this->status( 'done' );
			}
			else
			{
				$this->status( 'OK' );
			}


			$this->msg( 'Checking constraint in "users_list"', 1 );

			if( $schema->constraintExists( 'users_list', 'fk_lvuli_pid' ) )
			{
				$this->execute( 'ALTER TABLE "users_list" DROP FOREIGN KEY "fk_lvuli_pid"', 'db-customer' );
				$this->status( 'done' );
			}
			else
			{
				$this->status( 'OK' );
			}


			$this->msg( 'Checking constraint in "users_property"', 1 );

			if( $schema->constraintExists( 'users_property', 'fk_lvupr_pid' ) )
			{
				$this->execute( 'ALTER TABLE "users_property" DROP FOREIGN KEY "fk_lvupr_pid"', 'db-customer' );
				$this->status( 'done' );
			}
			else
			{
				$this->status( 'OK' );
			}
		}
	}
}
