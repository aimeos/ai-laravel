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
		$this->msg( sprintf( 'Remove constraints in users related tables' ), 0, '' );

		$rname = 'db-customer';
		$schema = $this->getSchema( $rname );

		if( $schema->tableExists( 'users' ) && $schema->columnExists( 'users', 'id' )
			&& $schema->getColumnDetails( 'users', 'id' )->getDataType() !== 'bigint'
		) {
			$conn = $this->acquire( $rname );
			$dbal = $conn->getRawObject();

			if( !( $dbal instanceof \Doctrine\DBAL\Connection ) ) {
				throw new \Aimeos\MW\Setup\Exception( 'Not a DBAL connection' );
			}

			$dbalManager = $dbal->getSchemaManager();
			$dbalManager->tryMethod( 'dropForeignKey', 'fk_lvuad_pid', 'users_address' );
			$dbalManager->tryMethod( 'dropForeignKey', 'fk_lvupr_pid', 'users_property' );
			$dbalManager->tryMethod( 'dropForeignKey', 'fk_lvuli_pid', 'users_list' );
		}
	}
}
