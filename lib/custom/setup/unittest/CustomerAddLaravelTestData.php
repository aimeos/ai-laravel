<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014
 */


/**
 * Adds Laravel customer test data.
 */
class MW_Setup_Task_CustomerAddLaravelTestData extends MW_Setup_Task_CustomerAddTestData
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
		$iface = 'MShop_Context_Item_Interface';
		if( !( $this->additional instanceof $iface ) ) {
			throw new MW_Setup_Exception( sprintf( 'Additionally provided object is not of type "%1$s"', $iface ) );
		}

		$this->msg( 'Adding Laravel customer test data', 0 );
		$this->additional->setEditor( 'ai-laravel:unittest' );

		$parentIds = array();
		$ds = DIRECTORY_SEPARATOR;
		$path = __DIR__ . $ds . 'data' . $ds . 'customer.php';

		if( ( $testdata = include( $path ) ) == false ){
			throw new MShop_Exception( sprintf( 'No file "%1$s" found for customer domain', $path ) );
		}


		$customerManager = MShop_Customer_Manager_Factory::createManager( $this->additional, 'Laravel' );
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
	 * @param MShop_Common_Manager_Interface $customerManager Customer manager
	 * @param MShop_Common_Manager_Interface $customerAddressManager Customer address manager
	 */
	protected function cleanupCustomerData( MShop_Common_Manager_Interface $customerManager, MShop_Common_Manager_Interface $customerAddressManager )
	{
		$search = $customerManager->createSearch();
		$search->setConditions( $search->compare( '==', 'customer.website', 'unittest.aimeos.org' ) );
		$customerItems = $customerManager->searchItems( $search );

		$search = $customerAddressManager->createSearch();
		$search->setConditions( $search->compare( '==', 'customer.address.website', 'unittest.aimeos.org' ) );
		$addressItems = $customerAddressManager->searchItems( $search );

		$customerAddressManager->deleteItems( array_keys( $addressItems ) );
		$customerManager->deleteItems( array_keys( $customerItems ) );
	}
}
