<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2020
 */


namespace Aimeos\MShop\Customer\Manager;


class LaravelTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $fixture;
	private $address;
	private $editor = '';


	protected function setUp() : void
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


	protected function tearDown() : void
	{
		unset( $this->object, $this->fixture, $this->address );
	}


	public function testClear()
	{
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->clear( array( -1 ) ) );
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
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Customer\\Item\\Iface', $this->object->create() );
	}


	public function testGetItem()
	{
		$domains = ['text', 'customer/property' => ['newsletter']];
		$expected = $this->object->find( 'test@example.com', $domains );
		$actual = $this->object->get( $expected->getId(), $domains );

		$this->assertEquals( $expected, $actual );
		$this->assertEquals( 1, count( $actual->getListItems( 'text' ) ) );
		$this->assertEquals( 1, count( $actual->getRefItems( 'text' ) ) );
		$this->assertEquals( 1, count( $actual->getPropertyItems() ) );
	}


	public function testSaveUpdateDeleteItem()
	{
		$item = $this->object->create();

		$item->setCode( 'unitTest@example.com' );
		$item->setLabel( 'unitTest' );
		$item = $this->object->saveItem( $item );
		$itemSaved = $this->object->get( $item->getId() );

		$itemExp = clone $itemSaved;
		$itemExp->setCode( 'unitTest2@example.com' );
		$itemExp->setLabel( 'unitTest2' );
		$itemExp = $this->object->saveItem( $itemExp );
		$itemUpd = $this->object->get( $itemExp->getId() );

		$this->object->deleteItem( $item->getId() );


		$this->assertInstanceOf( \Aimeos\MShop\Common\Item\Iface::class, $item );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Item\Iface::class, $itemExp );

		$this->assertTrue( $item->getId() !== null );
		$this->assertEquals( $item->getId(), $itemSaved->getId() );
		$this->assertEquals( $item->getSiteId(), $itemSaved->getSiteId() );
		$this->assertEquals( $item->getStatus(), $itemSaved->getStatus() );
		$this->assertEquals( $item->getCode(), $itemSaved->getCode() );
		$this->assertEquals( $item->getLabel(), $itemSaved->getLabel() );
		$this->assertEquals( $item->getPassword(), $itemSaved->getPassword() );

		$this->assertEquals( $this->editor, $itemSaved->getEditor() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeModified() );

		$this->assertEquals( $itemExp->getId(), $itemUpd->getId() );
		$this->assertEquals( $itemExp->getSiteId(), $itemUpd->getSiteId() );
		$this->assertEquals( $itemExp->getStatus(), $itemUpd->getStatus() );
		$this->assertEquals( $itemExp->getCode(), $itemUpd->getCode() );
		$this->assertEquals( $itemExp->getLabel(), $itemUpd->getLabel() );
		$this->assertEquals( $itemExp->getPassword(), $itemUpd->getPassword() );

		$this->assertEquals( $this->editor, $itemUpd->getEditor() );
		$this->assertEquals( $itemExp->getTimeCreated(), $itemUpd->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemUpd->getTimeModified() );


		$this->expectException( '\\Aimeos\\MShop\\Exception' );
		$this->object->get( $item->getId() );
	}


	public function testGetSaveAddressItems()
	{
		$item = $this->object->find( 'test@example.com', ['customer/address'] );

		$item->setId( null )->setCode( 'unittest@xyz.com' );
		$item->getPaymentAddress()->setEmail( 'unittest@xyz.com' );
		$item->addAddressItem( new \Aimeos\MShop\Common\Item\Address\Standard( 'customer.address.' ) );
		$this->object->saveItem( $item );

		$item2 = $this->object->find( 'unittest@xyz.com', ['customer/address'] );

		$this->object->deleteItem( $item->getId() );

		$this->assertEquals( 2, count( $item->getAddressItems() ) );
		$this->assertEquals( 2, count( $item2->getAddressItems() ) );
	}


	public function testGetSavePropertyItems()
	{
		$item = $this->object->find( 'test@example.com', ['customer/property'] );

		$item->setId( null )->setCode( 'unittest@xyz.com' );
		$item->getPaymentAddress()->setEmail( 'unittest@xyz.com' );
		$this->object->saveItem( $item );

		$item2 = $this->object->find( 'unittest@xyz.com', ['customer/property'] );

		$this->object->deleteItem( $item->getId() );

		$this->assertEquals( 1, count( $item->getPropertyItems() ) );
		$this->assertEquals( 1, count( $item2->getPropertyItems() ) );
	}


	public function testCreateSearch()
	{
		$this->assertInstanceOf( '\\Aimeos\\MW\\Criteria\\Iface', $this->object->filter() );
	}


	public function testSearchItems()
	{
		$item = $this->object->find( 'test@example.com', ['text'] );
		$listItem = $item->getListItems( 'text', 'default' )->first( new \RuntimeException( 'No list item found' ) );

		$search = $this->object->filter();

		$expr = [];
		$expr[] = $search->compare( '!=', 'customer.id', null );
		$expr[] = $search->compare( '==', 'customer.label', 'unitCustomer001' );
		$expr[] = $search->compare( '==', 'customer.code', 'test@example.com' );
		$expr[] = $search->compare( '>=', 'customer.password', '' );
		$expr[] = $search->compare( '==', 'customer.status', 1 );
		$expr[] = $search->compare( '>', 'customer.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>', 'customer.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'customer.editor', $this->editor );

		$expr[] = $search->compare( '==', 'customer.salutation', 'mr' );
		$expr[] = $search->compare( '==', 'customer.company', 'Example company' );
		$expr[] = $search->compare( '==', 'customer.vatid', 'DE999999999' );
		$expr[] = $search->compare( '==', 'customer.title', 'Dr' );
		$expr[] = $search->compare( '==', 'customer.firstname', 'Our' );
		$expr[] = $search->compare( '==', 'customer.lastname', 'Unittest' );
		$expr[] = $search->compare( '==', 'customer.address1', 'Pickhuben' );
		$expr[] = $search->compare( '==', 'customer.address2', '2-4' );
		$expr[] = $search->compare( '==', 'customer.address3', '' );
		$expr[] = $search->compare( '==', 'customer.postal', '20457' );
		$expr[] = $search->compare( '==', 'customer.city', 'Hamburg' );
		$expr[] = $search->compare( '==', 'customer.state', 'Hamburg' );
		$expr[] = $search->compare( '==', 'customer.languageid', 'de' );
		$expr[] = $search->compare( '==', 'customer.countryid', 'DE' );
		$expr[] = $search->compare( '==', 'customer.telephone', '055544332211' );
		$expr[] = $search->compare( '==', 'customer.email', 'test@example.com' );
		$expr[] = $search->compare( '==', 'customer.telefax', '055544332212' );
		$expr[] = $search->compare( '==', 'customer.website', 'www.example.com' );
		$expr[] = $search->compare( '==', 'customer.longitude', '10.0' );
		$expr[] = $search->compare( '==', 'customer.latitude', '50.0' );
		$expr[] = $search->compare( '==', 'customer.birthday', '1999-01-01' );

		$param = ['text', 'default', $listItem->getRefId()];
		$expr[] = $search->compare( '!=', $search->createFunction( 'customer:has', $param ), null );

		$param = ['text', 'default'];
		$expr[] = $search->compare( '!=', $search->createFunction( 'customer:has', $param ), null );

		$param = ['text'];
		$expr[] = $search->compare( '!=', $search->createFunction( 'customer:has', $param ), null );

		$param = ['newsletter', null, '1'];
		$expr[] = $search->compare( '!=', $search->createFunction( 'customer:prop', $param ), null );

		$param = ['newsletter', null];
		$expr[] = $search->compare( '!=', $search->createFunction( 'customer:prop', $param ), null );

		$param = ['newsletter'];
		$expr[] = $search->compare( '!=', $search->createFunction( 'customer:prop', $param ), null );

		$expr[] = $search->compare( '!=', 'customer.address.id', null );
		$expr[] = $search->compare( '!=', 'customer.address.parentid', null );
		$expr[] = $search->compare( '==', 'customer.address.salutation', 'mr' );
		$expr[] = $search->compare( '==', 'customer.address.company', 'Example company' );
		$expr[] = $search->compare( '==', 'customer.address.vatid', 'DE999999999' );
		$expr[] = $search->compare( '==', 'customer.address.title', 'Dr' );
		$expr[] = $search->compare( '==', 'customer.address.firstname', 'Our' );
		$expr[] = $search->compare( '==', 'customer.address.lastname', 'Unittest' );
		$expr[] = $search->compare( '==', 'customer.address.address1', 'Pickhuben' );
		$expr[] = $search->compare( '==', 'customer.address.address2', '2-4' );
		$expr[] = $search->compare( '==', 'customer.address.address3', '' );
		$expr[] = $search->compare( '==', 'customer.address.postal', '20457' );
		$expr[] = $search->compare( '==', 'customer.address.city', 'Hamburg' );
		$expr[] = $search->compare( '==', 'customer.address.state', 'Hamburg' );
		$expr[] = $search->compare( '==', 'customer.address.languageid', 'de' );
		$expr[] = $search->compare( '==', 'customer.address.countryid', 'DE' );
		$expr[] = $search->compare( '==', 'customer.address.telephone', '055544332211' );
		$expr[] = $search->compare( '==', 'customer.address.email', 'test@example.com' );
		$expr[] = $search->compare( '==', 'customer.address.telefax', '055544332212' );
		$expr[] = $search->compare( '==', 'customer.address.website', 'www.example.com' );
		$expr[] = $search->compare( '==', 'customer.address.longitude', '10.0' );
		$expr[] = $search->compare( '==', 'customer.address.latitude', '50.0' );
		$expr[] = $search->compare( '==', 'customer.address.position', 0 );
		$expr[] = $search->compare( '==', 'customer.address.birthday', '2000-01-01' );
		$expr[] = $search->compare( '>=', 'customer.address.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>=', 'customer.address.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'customer.address.editor', $this->editor );

		$search->setConditions( $search->combine( '&&', $expr ) );
		$result = $this->object->search( $search );
		$this->assertEquals( 1, count( $result ) );
	}


	public function testSearchItemsTotal()
	{
		$total = 0;

		$search = $this->object->filter();
		$search->setConditions( $search->compare( '==', 'customer.address.editor', $this->editor ) );
		$search->setSlice( 0, 2 );

		$results = $this->object->search( $search, [], $total );
		$this->assertEquals( 2, count( $results ) );
		$this->assertEquals( 3, $total );

		foreach( $results as $itemId => $item ) {
			$this->assertEquals( $itemId, $item->getId() );
		}
	}


	public function testSearchItemsCriteria()
	{
		$search = $this->object->filter( true );
		$conditions = array(
			$search->compare( '==', 'customer.address.editor', $this->editor ),
			$search->getConditions()
		);
		$search->setConditions( $search->combine( '&&', $conditions ) );
		$this->assertEquals( 2, count( $this->object->search( $search, [], $total ) ) );
	}


	public function testSearchItemsRef()
	{
		$search = $this->object->filter();
		$search->setConditions( $search->compare( '==', 'customer.code', 'test@example.com' ) );

		if( ( $item = $this->object->search( $search, ['customer/address', 'text'] )->first() ) === null ) {
			throw new \Exception( 'No customer item for "test@example.com" available' );
		}

		$this->assertEquals( 1, count( $item->getRefItems( 'text' ) ) );
		$this->assertEquals( 1, count( $item->getAddressItems() ) );
	}


	public function testGetSubManager()
	{
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Common\\Manager\\Iface', $this->object->getSubManager( 'address' ) );
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Common\\Manager\\Iface', $this->object->getSubManager( 'address', 'Standard' ) );

		$this->expectException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getSubManager( 'unknown' );
	}


	public function testGetSubManagerInvalidName()
	{
		$this->expectException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getSubManager( 'address', 'unknown' );
	}
}
