<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2025
 */


namespace Aimeos\MShop\Customer\Manager;


class LaravelTest extends \PHPUnit\Framework\TestCase
{
	private $context;
	private $object;


	protected function setUp() : void
	{
		$this->context = \TestHelper::context();

		$this->object = new \Aimeos\MShop\Customer\Manager\Laravel( $this->context );
		$this->object = new \Aimeos\MShop\Common\Manager\Decorator\Lists( $this->object, $this->context );
		$this->object = new \Aimeos\MShop\Common\Manager\Decorator\Property( $this->object, $this->context );
		$this->object = new \Aimeos\MShop\Common\Manager\Decorator\Address( $this->object, $this->context );
		$this->object->setObject( $this->object );
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->context );
	}


	public function testAggregate()
	{
		$search = $this->object->filter();
		$result = $this->object->aggregate( $search, 'customer.salutation' );

		$this->assertEquals( 2, count( $result ) );
		$this->assertArrayHasKey( 'mr', $result );
		$this->assertEquals( 1, $result->get( 'mr' ) );
	}


	public function testAggregateMultiple()
	{
		$cols = ['customer.salutation', 'customer.title'];
		$search = $this->object->filter()->order( $cols );
		$result = $this->object->aggregate( $search, $cols );

		$this->assertEquals( ['mr' => ['Dr' => 1], '' => ['' => 2]], $result->toArray() );
	}


	public function testClear()
	{
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->clear( array( -1 ) ) );
	}


	public function testGetSearchAttributes()
	{
		foreach( $this->object->getSearchAttributes() as $attribute )
		{
			$this->assertInstanceOf( '\\Aimeos\\Base\\Criteria\\Attribute\\Iface', $attribute );
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
		$item = $this->object->save( $item );
		$itemSaved = $this->object->get( $item->getId() );

		$itemExp = clone $itemSaved;
		$itemExp->setCode( 'unitTest2@example.com' );
		$itemExp->setLabel( 'unitTest2' );
		$itemExp = $this->object->save( $itemExp );
		$itemUpd = $this->object->get( $itemExp->getId() );

		$this->object->delete( $item->getId() );

		$this->assertInstanceOf( \Aimeos\MShop\Common\Item\Iface::class, $item );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Item\Iface::class, $itemExp );

		$this->assertTrue( $item->getId() !== null );
		$this->assertEquals( $item->getId(), $itemSaved->getId() );
		$this->assertEquals( $item->getSiteId(), $itemSaved->getSiteId() );
		$this->assertEquals( $item->getStatus(), $itemSaved->getStatus() );
		$this->assertEquals( $item->getCode(), $itemSaved->getCode() );
		$this->assertEquals( $item->getLabel(), $itemSaved->getLabel() );
		$this->assertEquals( $item->getPassword(), $itemSaved->getPassword() );

		$this->assertEquals( $this->context->editor(), $itemSaved->editor() );
		$this->assertMatchesRegularExpression( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeCreated() );
		$this->assertMatchesRegularExpression( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeModified() );

		$this->assertEquals( $itemExp->getId(), $itemUpd->getId() );
		$this->assertEquals( $itemExp->getSiteId(), $itemUpd->getSiteId() );
		$this->assertEquals( $itemExp->getStatus(), $itemUpd->getStatus() );
		$this->assertEquals( $itemExp->getCode(), $itemUpd->getCode() );
		$this->assertEquals( $itemExp->getLabel(), $itemUpd->getLabel() );
		$this->assertEquals( $itemExp->getPassword(), $itemUpd->getPassword() );

		$this->assertEquals( $this->context->editor(), $itemUpd->editor() );
		$this->assertEquals( $itemExp->getTimeCreated(), $itemUpd->getTimeCreated() );
		$this->assertMatchesRegularExpression( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemUpd->getTimeModified() );


		$this->expectException( '\\Aimeos\\MShop\\Exception' );
		$this->object->get( $item->getId() );
	}


	public function testGetSaveAddressItems()
	{
		$item = $this->object->find( 'test@example.com', ['customer/address'] );

		$item->setId( null )->setCode( 'unittest@xyz.com' );
		$item->getPaymentAddress()->setEmail( 'unittest@xyz.com' );
		$item->addAddressItem( new \Aimeos\MShop\Customer\Item\Address\Standard( 'customer.address.' ) );
		$this->object->save( $item );

		$item2 = $this->object->find( 'unittest@xyz.com', ['customer/address'] );

		$this->object->delete( $item->getId() );

		$this->assertEquals( 2, count( $item->getAddressItems() ) );
		$this->assertEquals( 2, count( $item2->getAddressItems() ) );
	}


	public function testGetSavePropertyItems()
	{
		$item = $this->object->find( 'test@example.com', ['customer/property'] );

		$item->setId( null )->setCode( 'unittest@xyz.com' );
		$item->getPaymentAddress()->setEmail( 'unittest@xyz.com' );
		$this->object->save( $item );

		$item2 = $this->object->find( 'unittest@xyz.com', ['customer/property'] );

		$this->object->delete( $item->getId() );

		$this->assertEquals( 1, count( $item->getPropertyItems() ) );
		$this->assertEquals( 1, count( $item2->getPropertyItems() ) );
	}


	public function testCreateSearch()
	{
		$this->assertInstanceOf( '\\Aimeos\\Base\\Criteria\\Iface', $this->object->filter() );
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
		$expr[] = $search->compare( '!=', 'customer.editor', '' );

		$expr[] = $search->compare( '==', 'customer.salutation', 'mr' );
		$expr[] = $search->compare( '==', 'customer.address.type', 'delivery' );
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
		$expr[] = $search->compare( '==', 'customer.telefax', '055544332212' );
		$expr[] = $search->compare( '==', 'customer.mobile', '055544332213' );
		$expr[] = $search->compare( '==', 'customer.email', 'test@example.com' );
		$expr[] = $search->compare( '==', 'customer.website', 'www.example.com' );
		$expr[] = $search->compare( '==', 'customer.longitude', '10.0' );
		$expr[] = $search->compare( '==', 'customer.latitude', '50.0' );
		$expr[] = $search->compare( '==', 'customer.birthday', '1999-01-01' );

		$param = ['text', 'default', $listItem->getRefId()];
		$expr[] = $search->compare( '!=', $search->make( 'customer:has', $param ), null );

		$param = ['text', 'default'];
		$expr[] = $search->compare( '!=', $search->make( 'customer:has', $param ), null );

		$param = ['text'];
		$expr[] = $search->compare( '!=', $search->make( 'customer:has', $param ), null );

		$param = ['newsletter', null, '1'];
		$expr[] = $search->compare( '!=', $search->make( 'customer:prop', $param ), null );

		$param = ['newsletter', null];
		$expr[] = $search->compare( '!=', $search->make( 'customer:prop', $param ), null );

		$param = ['newsletter'];
		$expr[] = $search->compare( '!=', $search->make( 'customer:prop', $param ), null );

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
		$expr[] = $search->compare( '==', 'customer.address.telefax', '055544332212' );
		$expr[] = $search->compare( '==', 'customer.address.mobile', '055544332213' );
		$expr[] = $search->compare( '==', 'customer.address.email', 'test@example.com' );
		$expr[] = $search->compare( '==', 'customer.address.website', 'www.example.com' );
		$expr[] = $search->compare( '==', 'customer.address.longitude', '10.0' );
		$expr[] = $search->compare( '==', 'customer.address.latitude', '50.0' );
		$expr[] = $search->compare( '==', 'customer.address.position', 0 );
		$expr[] = $search->compare( '==', 'customer.address.birthday', '2000-01-01' );
		$expr[] = $search->compare( '>=', 'customer.address.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>=', 'customer.address.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '!=', 'customer.address.editor', '' );

		$search->setConditions( $search->and( $expr ) );
		$result = $this->object->search( $search );
		$this->assertEquals( 1, count( $result ) );
	}


	public function testSearchItemsTotal()
	{
		$total = 0;
		$search = $this->object->filter()->slice( 0, 2 );

		$results = $this->object->search( $search, [], $total );

		$this->assertEquals( 2, count( $results ) );
		$this->assertEquals( 3, $total );

		foreach( $results as $itemId => $item ) {
			$this->assertEquals( $itemId, $item->getId() );
		}
	}


	public function testSearchItemsCriteria()
	{
		$this->assertEquals( 2, count( $this->object->search( $this->object->filter( true ) ) ) );
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

		$this->expectException( \LogicException::class );
		$this->object->getSubManager( 'unknown' );
	}


	public function testGetSubManagerInvalidName()
	{
		$this->expectException( \LogicException::class );
		$this->object->getSubManager( 'address', 'unknown' );
	}
}
