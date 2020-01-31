<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2020
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds Laravel customer test data.
 */
class CustomerAddLaravelTestData extends \Aimeos\MW\Setup\Task\CustomerAddTestData
{
	/**
	 * Returns the list of task names which this task depends on
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies() : array
	{
		return ['MShopSetLocale'];
	}


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return string[] List of task names
	 */
	public function getPostDependencies() : array
	{
		return ['CustomerAddTestData'];
	}


	/**
	 * Adds customer test data
	 */
	public function migrate()
	{
		\Aimeos\MW\Common\Base::checkClass( \Aimeos\MShop\Context\Item\Iface::class, $this->additional );

		$this->msg( 'Adding Laravel customer test data', 0 );

		$this->additional->setEditor( 'ai-laravel:lib/custom' );
		$this->process( __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'customer.php' );

		$this->status( 'done' );
	}


	/**
	 * Adds the customer data
	 *
	 * @param string $path Path to data file
	 * @throws \Aimeos\MShop\Exception
	 */
	protected function process( $path )
	{
		if( ( $testdata = include( $path ) ) == false ) {
			throw new \Aimeos\MShop\Exception( sprintf( 'No file "%1$s" found for customer domain', $path ) );
		}

		$manager = $this->getManager( 'customer' );
		$listManager = $manager->getSubManager( 'lists' );
		$groupManager = $manager->getSubManager( 'group' );
		$addrManager = $manager->getSubManager( 'address' );
		$propManager = $manager->getSubManager( 'property' );

		$manager->begin();

		$search = $manager->createSearch();
		$search->setConditions( $search->compare( '=~', 'customer.code', 'test' ) );
		$manager->deleteItems( $manager->searchItems( $search )->toArray() );

		$this->storeTypes( $testdata, ['customer/lists/type', 'customer/property/type'] );
		$this->addGroupItems( $groupManager, $testdata );

		$items = [];
		foreach( $testdata['customer'] as $entry )
		{
			$item = $manager->createItem()->fromArray( $entry, true );
			$item = $this->addGroupData( $groupManager, $item, $entry );
			$item = $this->addPropertyData( $propManager, $item, $entry );
			$item = $this->addAddressData( $addrManager, $item, $entry );
			$items[] = $this->addListData( $listManager, $item, $entry );
		}

		$manager->saveItems( $items );
		$manager->commit();
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


	/**
	 * Adds the customer group test data.
	 *
	 * @param array $testdata Associative list of key/list pairs
	 * @param \Aimeos\MShop\Common\Manager\Iface $customerGroupManager Customer group manager
	 * @throws \Aimeos\MW\Setup\Exception If a required ID is not available
	 */
	protected function addCustomerGroupData( array $testdata, \Aimeos\MShop\Common\Manager\Iface $customerGroupManager )
	{
	}
}
