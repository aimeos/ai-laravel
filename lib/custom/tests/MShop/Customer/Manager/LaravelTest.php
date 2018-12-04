<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2018
 */


namespace Aimeos\MShop\Customer\Manager;


class LaravelTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $fixture;
	private $address;
	private $editor = '';


	protected function setUp()
	{
		$context = \TestHelper::getContext();
		$this->editor = $context->getEditor();
		$this->object = new \Aimeos\MShop\Customer\Manager\Laravel( $context );

		$this->fixture = array(
			'label' => 'unitTest',
			'status' => 2,
		);

		$this->address = new \Aimeos\MShop\Common\Item\Address\Standard( 'common.address.' );
	}


	protected function tearDown()
	{
		unset( $this->object, $this->fixture, $this->address );
	}


	public function testCleanup()
	{
		$this->object->cleanup( array( -1 ) );
	}


	public function testGetSearchAttributes()
	{
		foreach( $this->object->getSearchAttributes() as $attribute )
		{
			$this->assertInstanceOf( '\\Aimeos\\MW\\Criteria\\Attribute\\Iface', $attribute );
		}
	}


	public function testCreateItem()
	{
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Customer\\Item\\Iface', $this->object->createItem() );
	}


	public function testGetItem()
	{
		$search = $this->object->createSearch();
		$conditions = array(
			$search->compare( '==', 'customer.code', 'UTC003' ),
			$search->compare( '==', 'customer.editor', $this->editor )
		);
		$search->setConditions( $search->combine( '&&', $conditions ) );
		$items = $this->object->searchItems( $search, array( 'text' ) );

		if( ( $expected = reset( $items ) ) === false ) {
			throw new \RuntimeException( 'No customer item with code "UTC003" found' );
		}

		$actual = $this->object->getItem( $expected->getId(), array( 'text' ) );

		$this->assertEquals( $expected, $actual );
		$this->assertEquals( 3, count( $actual->getListItems( 'text' ) ) );
		$this->assertEquals( 3, count( $actual->getRefItems( 'text' ) ) );
	}


	public function testSaveUpdateDeleteItem()
	{
		$item = $this->object->createItem();

		$item->setCode( 'unitTest' );
		$item->setLabel( 'unitTest' );
		$item = $this->object->saveItem( $item );
		$itemSaved = $this->object->getItem( $item->getId() );

		$itemExp = clone $itemSaved;
		$itemExp->setCode( 'unitTest2' );
		$itemExp->setLabel( 'unitTest2' );
		$itemExp = $this->object->saveItem( $itemExp );
		$itemUpd = $this->object->getItem( $itemExp->getId() );

		$this->object->deleteItem( $item->getId() );


		$this->assertInstanceOf( \Aimeos\MShop\Common\Item\Iface::class, $item );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Item\Iface::class, $itemExp );

		$this->assertTrue( $item->getId() !== null );
		$this->assertEquals( $item->getId(), $itemSaved->getId() );
		$this->assertEquals( $item->getSiteId(), $itemSaved->getSiteId() );
		$this->assertEquals( $item->getStatus(), $itemSaved->getStatus() );
		$this->assertEquals( $item->getCode(), $itemSaved->getCode() );
		$this->assertEquals( $item->getLabel(), $itemSaved->getLabel() );
		$this->assertEquals( $item->getBirthday(), $itemSaved->getBirthday() );
		$this->assertEquals( $item->getPassword(), $itemSaved->getPassword() );

		$this->assertEquals( $this->editor, $itemSaved->getEditor() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeModified() );

		$this->assertEquals( $itemExp->getId(), $itemUpd->getId() );
		$this->assertEquals( $itemExp->getSiteId(), $itemUpd->getSiteId() );
		$this->assertEquals( $itemExp->getStatus(), $itemUpd->getStatus() );
		$this->assertEquals( $itemExp->getCode(), $itemUpd->getCode() );
		$this->assertEquals( $itemExp->getLabel(), $itemUpd->getLabel() );
		$this->assertEquals( $itemExp->getBirthday(), $itemUpd->getBirthday() );
		$this->assertEquals( $itemExp->getPassword(), $itemUpd->getPassword() );

		$this->assertEquals( $this->editor, $itemUpd->getEditor() );
		$this->assertEquals( $itemExp->getTimeCreated(), $itemUpd->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemUpd->getTimeModified() );


		$this->setExpectedException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getItem( $item->getId() );
	}


	public function testGetSaveAddressItems()
	{
		$item = $this->object->findItem( 'UTC001', ['customer/address'] );

		$item->setId( null )->setCode( 'xyz' );
		$item->getPaymentAddress()->setEmail( 'unittest@xyz.com' );
		$item->addAddressItem( new \Aimeos\MShop\Common\Item\Address\Standard( 'customer.address.' ) );
		$this->object->saveItem( $item );

		$item2 = $this->object->findItem( 'xyz', ['customer/address'] );

		$this->object->deleteItem( $item->getId() );

		$this->assertEquals( 2, count( $item->getAddressItems() ) );
		$this->assertEquals( 2, count( $item2->getAddressItems() ) );
	}


	public function testGetSavePropertyItems()
	{
		$item = $this->object->findItem( 'UTC001', ['customer/property'] );

		$item->setId( null )->setCode( 'xyz' );
		$item->getPaymentAddress()->setEmail( 'unittest@xyz.com' );
		$this->object->saveItem( $item );

		$item2 = $this->object->findItem( 'xyz', ['customer/property'] );

		$this->object->deleteItem( $item->getId() );

		$this->assertEquals( 1, count( $item->getPropertyItems() ) );
		$this->assertEquals( 1, count( $item2->getPropertyItems() ) );
	}


	public function testCreateSearch()
	{
		$this->assertInstanceOf( '\\Aimeos\\MW\\Criteria\\Iface', $this->object->createSearch() );
	}


	public function testSearchItems()
	{
		$total = 0;
		$search = $this->object->createSearch();

		$expr = [];
		$expr[] = $search->compare( '!=', 'customer.id', null );
		$expr[] = $search->compare( '==', 'customer.label', 'unitCustomer2' );
		$expr[] = $search->compare( '==', 'customer.code', 'UTC002' );

		$expr[] = $search->compare( '>=', 'customer.salutation', '' );
		$expr[] = $search->compare( '>=', 'customer.company', '' );
		$expr[] = $search->compare( '>=', 'customer.vatid', '' );
		$expr[] = $search->compare( '>=', 'customer.title', '' );
		$expr[] = $search->compare( '>=', 'customer.firstname', '' );
		$expr[] = $search->compare( '>=', 'customer.lastname', '' );
		$expr[] = $search->compare( '>=', 'customer.address1', '' );
		$expr[] = $search->compare( '>=', 'customer.address2', '' );
		$expr[] = $search->compare( '>=', 'customer.address3', '' );
		$expr[] = $search->compare( '>=', 'customer.postal', '' );
		$expr[] = $search->compare( '>=', 'customer.city', '' );
		$expr[] = $search->compare( '>=', 'customer.state', '' );
		$expr[] = $search->compare( '!=', 'customer.languageid', null );
		$expr[] = $search->compare( '>=', 'customer.countryid', '' );
		$expr[] = $search->compare( '>=', 'customer.telephone', '' );
		$expr[] = $search->compare( '>=', 'customer.email', '' );
		$expr[] = $search->compare( '>=', 'customer.telefax', '' );
		$expr[] = $search->compare( '>=', 'customer.website', '' );
		$expr[] = $search->compare( '>=', 'customer.longitude', '10.0' );
		$expr[] = $search->compare( '>=', 'customer.latitude', '50.0' );

		$expr[] = $search->compare( '==', 'customer.birthday', '1970-01-01' );
		$expr[] = $search->compare( '>=', 'customer.password', '' );
		$expr[] = $search->compare( '==', 'customer.status', 0 );
		$expr[] = $search->compare( '!=', 'customer.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '!=', 'customer.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'customer.editor', $this->editor );

		$expr[] = $search->compare( '!=', 'customer.address.id', null );
		$expr[] = $search->compare( '!=', 'customer.address.parentid', null );
		$expr[] = $search->compare( '==', 'customer.address.company', 'ABC GmbH' );
		$expr[] = $search->compare( '==', 'customer.address.vatid', 'DE999999999' );
		$expr[] = $search->compare( '==', 'customer.address.salutation', 'mr' );
		$expr[] = $search->compare( '==', 'customer.address.title', 'Dr.' );
		$expr[] = $search->compare( '==', 'customer.address.firstname', 'Good' );
		$expr[] = $search->compare( '==', 'customer.address.lastname', 'Unittest' );
		$expr[] = $search->compare( '==', 'customer.address.address1', 'Pickhuben' );
		$expr[] = $search->compare( '==', 'customer.address.address2', '2-4' );
		$expr[] = $search->compare( '==', 'customer.address.address3', '' );
		$expr[] = $search->compare( '==', 'customer.address.postal', '11099' );
		$expr[] = $search->compare( '==', 'customer.address.city', 'Berlin' );
		$expr[] = $search->compare( '==', 'customer.address.state', 'Berlin' );
		$expr[] = $search->compare( '==', 'customer.address.languageid', 'de' );
		$expr[] = $search->compare( '==', 'customer.address.countryid', 'DE' );
		$expr[] = $search->compare( '==', 'customer.address.telephone', '055544332221' );
		$expr[] = $search->compare( '==', 'customer.address.email', 'unitCustomer2@aimeos.org' );
		$expr[] = $search->compare( '==', 'customer.address.telefax', '055544333212' );
		$expr[] = $search->compare( '==', 'customer.address.website', 'unittest.aimeos.org' );
		$expr[] = $search->compare( '>=', 'customer.address.longitude', '10.0' );
		$expr[] = $search->compare( '>=', 'customer.address.latitude', '50.0' );
		$expr[] = $search->compare( '==', 'customer.address.position', 1 );
		$expr[] = $search->compare( '!=', 'customer.address.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '!=', 'customer.address.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'customer.address.editor', $this->editor );

		$search->setConditions( $search->combine( '&&', $expr ) );
		$result = $this->object->searchItems( $search, [], $total );
		$this->assertEquals( 1, count( $result ) );
	}


	public function testSearchItemsTotal()
	{
		$total = 0;

		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'customer.address.editor', $this->editor ) );
		$search->setSlice( 0, 2 );

		$results = $this->object->searchItems( $search, [], $total );
		$this->assertEquals( 2, count( $results ) );
		$this->assertEquals( 3, $total );

		foreach($results as $itemId => $item) {
			$this->assertEquals( $itemId, $item->getId() );
		}
	}


	public function testSearchItemsCriteria()
	{
		$search = $this->object->createSearch( true );
		$conditions = array(
			$search->compare( '==', 'customer.address.editor', $this->editor ),
			$search->getConditions()
		);
		$search->setConditions( $search->combine( '&&', $conditions ) );
		$this->assertEquals( 2, count( $this->object->searchItems( $search, [], $total ) ) );
	}


	public function testSearchItemsRef()
	{
		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'customer.code', 'UTC001' ) );

		$results = $this->object->searchItems( $search, ['customer/address', 'text'] );

		if( ( $item = reset( $results ) ) === false ) {
			throw new \Exception( 'No customer item for "UTC001" available' );
		}

		$this->assertEquals( 1, count( $item->getRefItems( 'text' ) ) );
		$this->assertEquals( 1, count( $item->getAddressItems() ) );
	}


	public function testGetSubManager()
	{
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Common\\Manager\\Iface', $this->object->getSubManager( 'address' ) );
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Common\\Manager\\Iface', $this->object->getSubManager( 'address', 'Standard' ) );

		$this->setExpectedException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getSubManager( 'unknown' );
	}


	public function testGetSubManagerInvalidName()
	{
		$this->setExpectedException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getSubManager( 'address', 'unknown' );
	}
}
