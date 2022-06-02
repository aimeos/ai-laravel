<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2022
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
		return ['Customer', 'Text', 'ProductAddTestData'];
	}


	/**
	 * Adds customer test data
	 */
	public function up()
	{
		$this->info( 'Adding Laravel customer test data', 'vv' );

		$this->db( 'db-customer' )->exec( "DELETE FROM users WHERE email LIKE 'test%@example.com'" );

		$this->context()->setEditor( 'ai-laravel:lib/custom' );
		$this->process();
	}


	/**
	 * Returns the manager for the current setup task
	 *
	 * @param string $domain Domain name of the manager
	 * @param string $name Specific manager implemenation
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager object
	 */
	protected function getManager( string $domain, string $name = 'Standard' ) : \Aimeos\MShop\Common\Manager\Iface
	{
		if( $domain === 'customer' ) {
			return parent::getManager( $domain, 'Laravel' );
		}

		return parent::getManager( $domain );
	}
}
