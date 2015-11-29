<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds Laravel customer test data.
 */
class CustomerAddLaravelTestData extends \Aimeos\MW\Setup\Task\CustomerAddTestData
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies()
	{
		return array( 'TablesAddLaravelTestData' );
	}


	/**
	 * Adds customer TYPO3 test data.
	 */
	protected function process()
	{
		$iface = '\\Aimeos\\MShop\\Context\\Item\\Iface';
		if( !( $this->additional instanceof $iface ) ) {
			throw new \Aimeos\MW\Setup\Exception( sprintf( 'Additionally provided object is not of type "%1$s"', $iface ) );
		}

		$this->msg( 'Adding Laravel customer test data', 0 );
		$this->additional->setEditor( 'ai-laravel:unittest' );

		$parentIds = array();
		$ds = DIRECTORY_SEPARATOR;
		$path = __DIR__ . $ds . 'data' . $ds . 'customer.php';

		if( ( $testdata = include( $path ) ) == false ){
			throw new \Aimeos\MShop\Exception( sprintf( 'No file "%1$s" found for customer domain', $path ) );
		}


		$customerManager = \Aimeos\MShop\Customer\Manager\Factory::createManager( $this->additional, 'Laravel' );
		$customerAddressManager = $customerManager->getSubManager( 'address', 'Laravel' );

		$this->cleanupCustomerData( $customerManager, $customerAddressManager );

		$this->conn->begin();

		$parentIds = $this->addCustomerData( $testdata, $customerManager, $customerAddressManager->createItem() );
		$this->addCustomerAddressData( $testdata, $customerAddressManager, $parentIds );

		$this->conn->commit();


		$this->status( 'done' );
	}


	/**
	 * Removes all customer unit test entries
	 *
	 * @param \Aimeos\MShop\Common\Manager\Iface $customerManager Customer manager
	 * @param \Aimeos\MShop\Common\Manager\Iface $customerAddressManager Customer address manager
	 */
	protected function cleanupCustomerData( \Aimeos\MShop\Common\Manager\Iface $customerManager, \Aimeos\MShop\Common\Manager\Iface $customerAddressManager )
	{
		$search = $customerManager->createSearch();
		$search->setConditions( $search->compare( '=~', 'customer.code', 'unitCustomer' ) );
		$customerItems = $customerManager->searchItems( $search );

		$search = $customerAddressManager->createSearch();
		$search->setConditions( $search->compare( '=~', 'customer.address.email', 'unitCustomer' ) );
		$addressItems = $customerAddressManager->searchItems( $search );

		$customerAddressManager->deleteItems( array_keys( $addressItems ) );
		$customerManager->deleteItems( array_keys( $customerItems ) );
	}
}
