<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2021
 */


namespace Aimeos\Upscheme\Task;


/**
 * Adds Laravel customer test data.
 */
class CustomerAddLaravelTestData extends CustomerAddTestData
{
	/**
	 * Returns the list of task names which this task depends on
	 *
	 * @return string[] List of task names
	 */
	public function after() : array
	{
		return ['ProductAddTestData'];
	}


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return string[] List of task names
	 */
	public function before() : array
	{
		return ['CustomerAddTestData'];
	}


	/**
	 * Adds customer test data
	 */
	public function up()
	{
		$this->info( 'Adding Laravel customer test data', 'v' );

		$dbm = $this->context()->getDatabaseManager();
		$conn = $dbm->acquire( 'db-customer' );
		$conn->create( 'DELETE FROM "users" WHERE "email" LIKE \'test%@example.com\'' )->execute()->finish();
		$dbm->release( $conn, 'db-customer' );

		$this->context()->setEditor( 'ai-laravel:lib/custom' );
		$this->process( __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'customer.php' );
	}


	/**
	 * Returns the manager for the current setup task
	 *
	 * @param string $domain Domain name of the manager
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager object
	 */
	protected function getManager( $domain )
	{
		if( $domain === 'customer' ) {
			return \Aimeos\MShop\Customer\Manager\Factory::create( $this->context(), 'Laravel' );
		}

		return parent::getManager( $domain );
	}
}
