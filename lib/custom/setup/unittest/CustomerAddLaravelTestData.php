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
	protected function _process()
	{
		$iface = 'MShop_Context_Item_Interface';
		if( !( $this->_additional instanceof $iface ) ) {
			throw new MW_Setup_Exception( sprintf( 'Additionally provided object is not of type "%1$s"', $iface ) );
		}

		$this->_msg( 'Adding Laravel customer test data', 0 );
		$this->_additional->setEditor( 'ai-laravel:unittest' );

		$parentIds = array();
		$ds = DIRECTORY_SEPARATOR;
		$path = __DIR__ . $ds . 'data' . $ds . 'customer.php';

		if( ( $testdata = include( $path ) ) == false ){
			throw new MShop_Exception( sprintf( 'No file "%1$s" found for customer domain', $path ) );
		}


		$customerManager = MShop_Customer_Manager_Factory::createManager( $this->_additional, 'Laravel' );
		$customerAddressManager = $customerManager->getSubManager( 'address', 'Laravel' );

		$this->_cleanupCustomerData( $customerManager, $customerAddressManager );

		$this->_conn->begin();

		$parentIds = $this->_addCustomerData( $testdata, $customerManager, $customerAddressManager->createItem() );
		$this->_addCustomerAddressData( $testdata, $customerAddressManager, $parentIds );

		$this->_conn->commit();


		$this->_status( 'done' );
	}


	/**
	 * Removes all customer unit test entries
	 *
	 * @param MShop_Common_Manager_Interface $customerManager Customer manager
	 * @param MShop_Common_Manager_Interface $customerAddressManager Customer address manager
	 */
	protected function _cleanupCustomerData( MShop_Common_Manager_Interface $customerManager, MShop_Common_Manager_Interface $customerAddressManager )
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
