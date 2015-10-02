<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014
 */


/**
 * Adds customer list test data.
 */
class MW_Setup_Task_CustomerListAddLaravelTestData
	extends MW_Setup_Task_CustomerListAddTestData
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies()
	{
		return array( 'TablesCreateLaravel', 'CustomerAddLaravelTestData', 'LocaleAddTestData', 'TextAddTestData' );
	}


	/**
	 * Adds customer test data.
	 */
	protected function process()
	{
		$iface = 'MShop_Context_Item_Interface';
		if( !( $this->additional instanceof $iface ) ) {
			throw new MW_Setup_Exception( sprintf( 'Additionally provided object is not of type "%1$s"', $iface ) );
		}

		$this->msg( 'Adding customer-list Laravel test data', 0 );
		$this->additional->setEditor( 'ai-laravel:unittest' );

		$ds = DIRECTORY_SEPARATOR;
		$path = __DIR__ . $ds . 'data' . $ds . 'customer-list.php';

		if( ( $testdata = include( $path ) ) == false ){
			throw new MShop_Exception( sprintf( 'No file "%1$s" found for customer list domain', $path ) );
		}

		$refKeys = array();
		foreach( $testdata['customer/list'] as $dataset ) {
			$refKeys[ $dataset['domain'] ][] = $dataset['refid'];
		}

		$refIds = array();
		$refIds['text'] = $this->getTextData( $refKeys['text'] );
		$this->addCustomerListData( $testdata, $refIds, 'Laravel' );

		$this->status( 'done' );
	}
}