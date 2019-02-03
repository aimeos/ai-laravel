<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2018
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds Laravel customer test data.
 */
class CustomerAddLaravelTestData extends \Aimeos\MW\Setup\Task\CustomerAddTestData
{
	/**
	 * Adds customer test data
	 */
	public function migrate()
	{
		\Aimeos\MW\Common\Base::checkClass( \Aimeos\MShop\Context\Item\Iface::class, $this->additional );

		$this->msg( 'Adding Laravel customer test data', 0 );

		$this->additional->setEditor( 'ai-laravel:unittest' );
		$this->process( __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'customer.php' );

		$this->status( 'done' );
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
			return \Aimeos\MShop\Customer\Manager\Factory::create( $this->additional, 'Laravel' );
		}

		return parent::getManager( $domain );
	}
}
