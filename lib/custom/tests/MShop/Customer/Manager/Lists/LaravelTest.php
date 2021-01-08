<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 */


 namespace Aimeos\MShop\Customer\Manager\Lists;


class LaravelTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $context;
	private $editor = 'ai-laravel:lib/custom';


	protected function setUp() : void
	{
		$this->context = \TestHelper::getContext();
		$this->editor = $this->context->getEditor();
		$manager = \Aimeos\MShop\Customer\Manager\Factory::create( $this->context, 'Laravel' );
		$this->object = $manager->getSubManager( 'lists', 'Laravel' );
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->context );
	}


	public function testClear()
	{
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->clear( array( -1 ) ) );
	}


	public function testAggregate()
	{
		$search = $this->object->filter( true );
		$expr = array(
			$search->getConditions(),
			$search->compare( '==', 'customer.lists.editor', 'ai-laravel:lib/custom' ),
		);
		$search->setConditions( $search->and( $expr ) );

		$result = $this->object->aggregate( $search, 'customer.lists.domain' )->toArray();

		$this->assertEquals( 2, count( $result ) );
		$this->assertArrayHasKey( 'text', $result );
		$this->assertEquals( 4, $result['text'] );
	}


	public function testCreateItem()
	{
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Common\\Item\\Lists\\Iface', $this->object->create() );
	}


	public function testGetItem()
	{
		$search = $this->object->filter()->slice( 0, 1 );

		if( ( $item = $this->object->search( $search )->first() ) === null ) {
			throw new \RuntimeException( 'No item found' );
		}

		$this->assertEquals( $item, $this->object->get( $item->getId() ) );
	}


	public function testSaveUpdateDeleteItem()
	{
		$search = $this->object->filter()->slice( 0, 1 );

		if( ( $item = $this->object->search( $search )->first() ) === null ) {
			throw new \RuntimeException( 'No item found' );
		}

		$item->setId( null );
		$item->setDomain( 'unittest' );
		$resultSaved = $this->object->save( $item );
		$itemSaved = $this->object->get( $item->getId() );

		$itemExp = clone $itemSaved;
		$itemExp->setDomain( 'unittest2' );
		$resultUpd = $this->object->save( $itemExp );
		$itemUpd = $this->object->get( $itemExp->getId() );

		$this->object->delete( $itemSaved->getId() );


		$this->assertTrue( $item->getId() !== null );
		$this->assertEquals( $item->getId(), $itemSaved->getId() );
		$this->assertEquals( $item->getSiteId(), $itemSaved->getSiteId() );
		$this->assertEquals( $item->getParentId(), $itemSaved->getParentId() );
		$this->assertEquals( $item->getType(), $itemSaved->getType() );
		$this->assertEquals( $item->getRefId(), $itemSaved->getRefId() );
		$this->assertEquals( $item->getDomain(), $itemSaved->getDomain() );
		$this->assertEquals( $item->getDateStart(), $itemSaved->getDateStart() );
		$this->assertEquals( $item->getDateEnd(), $itemSaved->getDateEnd() );
		$this->assertEquals( $item->getPosition(), $itemSaved->getPosition() );
		$this->assertEquals( $this->editor, $itemSaved->getEditor() );
		$this->assertStringStartsWith( date( 'Y-m-d', time() ), $itemSaved->getTimeCreated() );
		$this->assertStringStartsWith( date( 'Y-m-d', time() ), $itemSaved->getTimeModified() );

		$this->assertEquals( $this->editor, $itemSaved->getEditor() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeModified() );

		$this->assertEquals( $itemExp->getId(), $itemUpd->getId() );
		$this->assertEquals( $itemExp->getSiteId(), $itemUpd->getSiteId() );
		$this->assertEquals( $itemExp->getParentId(), $itemUpd->getParentId() );
		$this->assertEquals( $itemExp->getType(), $itemUpd->getType() );
		$this->assertEquals( $itemExp->getRefId(), $itemUpd->getRefId() );
		$this->assertEquals( $itemExp->getDomain(), $itemUpd->getDomain() );
		$this->assertEquals( $itemExp->getDateStart(), $itemUpd->getDateStart() );
		$this->assertEquals( $itemExp->getDateEnd(), $itemUpd->getDateEnd() );
		$this->assertEquals( $itemExp->getPosition(), $itemUpd->getPosition() );

		$this->assertEquals( $this->editor, $itemUpd->getEditor() );
		$this->assertEquals( $itemExp->getTimeCreated(), $itemUpd->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemUpd->getTimeModified() );

		$this->assertInstanceOf( \Aimeos\MShop\Common\Item\Iface::class, $resultSaved );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Item\Iface::class, $resultUpd );

		$this->expectException( '\\Aimeos\\MShop\\Exception' );
		$this->object->get( $itemSaved->getId() );
	}


	public function testSearchItems()
	{
		$total = 0;
		$search = $this->object->filter();

		$expr = [];
		$expr[] = $search->compare( '!=', 'customer.lists.id', null );
		$expr[] = $search->compare( '!=', 'customer.lists.siteid', null );
		$expr[] = $search->compare( '!=', 'customer.lists.parentid', null );
		$expr[] = $search->compare( '!=', 'customer.lists.key', null );
		$expr[] = $search->compare( '==', 'customer.lists.domain', 'text' );
		$expr[] = $search->compare( '==', 'customer.lists.type', 'default' );
		$expr[] = $search->compare( '>', 'customer.lists.refid', 0 );
		$expr[] = $search->compare( '==', 'customer.lists.datestart', '2010-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'customer.lists.dateend', '2098-01-01 00:00:00' );
		$expr[] = $search->compare( '!=', 'customer.lists.config', null );
		$expr[] = $search->compare( '>', 'customer.lists.position', 0 );
		$expr[] = $search->compare( '==', 'customer.lists.status', 1 );
		$expr[] = $search->compare( '>=', 'customer.lists.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>=', 'customer.lists.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'customer.lists.editor', $this->editor );

		$search->setConditions( $search->and( $expr ) );
		$search->slice( 0, 2 );
		$results = $this->object->search( $search, [], $total );
		$this->assertEquals( 2, count( $results ) );
		$this->assertEquals( 3, $total );

		foreach( $results as $itemId => $item ) {
			$this->assertEquals( $itemId, $item->getId() );
		}
	}


	public function testSearchItemsAll()
	{
		//search without base criteria
		$search = $this->object->filter();
		$search->setConditions( $search->compare( '==', 'customer.lists.editor', $this->editor ) );
		$result = $this->object->search( $search );
		$this->assertEquals( 5, count( $result ) );
	}


	public function testSearchItemsBase()
	{
		//search with base criteria
		$search = $this->object->filter( true );
		$conditions = array(
			$search->compare( '==', 'customer.lists.editor', $this->editor ),
			$search->getConditions()
		);
		$search->setConditions( $search->and( $conditions ) );
		$this->assertEquals( 5, count( $this->object->search( $search ) ) );
	}


	public function testGetSubManager()
	{
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Common\\Manager\\Iface', $this->object->getSubManager( 'type' ) );
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Common\\Manager\\Iface', $this->object->getSubManager( 'type', 'Standard' ) );

		$this->expectException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getSubManager( 'unknown' );
	}
}
