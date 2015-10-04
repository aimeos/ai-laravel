<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */


class MShop_Customer_Manager_List_LaravelTest extends PHPUnit_Framework_TestCase
{
	private $object;
	private $context;
	private $editor = 'ai-laravel:unittest';


	/**
	 * Sets up the fixture.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	protected function setUp()
	{
		$this->context = TestHelper::getContext();
		$this->editor = $this->context->getEditor();
		$manager = MShop_Customer_Manager_Factory::createManager( $this->context, 'Laravel' );
		$this->object = $manager->getSubManager( 'list', 'Laravel' );
	}


	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
	{
		unset( $this->object, $this->context );
	}


	public function testCleanup()
	{
		$this->object->cleanup( array( -1 ) );
	}


	public function testAggregate()
	{
		$search = $this->object->createSearch( true );
		$expr = array(
			$search->getConditions(),
			$search->compare( '==', 'customer.list.editor', 'ai-laravel:unittest' ),
		);
		$search->setConditions( $search->combine( '&&', $expr ) );

		$result = $this->object->aggregate( $search, 'customer.list.domain' );

		$this->assertEquals( 1, count( $result ) );
		$this->assertArrayHasKey( 'text', $result );
		$this->assertEquals( 4, $result['text'] );
	}


	public function testCreateItem()
	{
		$this->assertInstanceOf( 'MShop_Common_Item_List_Interface', $this->object->createItem() );
	}


	public function testGetItem()
	{
		$search = $this->object->createSearch();
		$search->setSlice(0, 1);
		$results = $this->object->searchItems( $search );

		if( ( $item = reset( $results ) ) === false ) {
			throw new Exception( 'No item found' );
		}

		$this->assertEquals( $item, $this->object->getItem( $item->getId() ) );
	}


	public function testSaveUpdateDeleteItem()
	{
		$search = $this->object->createSearch();
		$search->setSlice(0, 1);
		$items = $this->object->searchItems( $search );

		if( ( $item = reset( $items ) ) === false ) {
			throw new Exception( 'No item found' );
		}

		$item->setId( null );
		$item->setDomain( 'unittest' );
		$this->object->saveItem( $item );
		$itemSaved = $this->object->getItem( $item->getId() );

		$itemExp = clone $itemSaved;
		$itemExp->setDomain( 'unittest2' );
		$this->object->saveItem( $itemExp );
		$itemUpd = $this->object->getItem( $itemExp->getId() );

		$this->object->deleteItem( $itemSaved->getId() );


		$this->assertTrue( $item->getId() !== null );
		$this->assertTrue( $itemSaved->getType() !== null );
		$this->assertEquals( $item->getId(), $itemSaved->getId() );
		$this->assertEquals( $item->getSiteId(), $itemSaved->getSiteId() );
		$this->assertEquals( $item->getParentId(), $itemSaved->getParentId() );
		$this->assertEquals( $item->getTypeId(), $itemSaved->getTypeId() );
		$this->assertEquals( $item->getRefId(), $itemSaved->getRefId() );
		$this->assertEquals( $item->getDomain(), $itemSaved->getDomain() );
		$this->assertEquals( $item->getDateStart(), $itemSaved->getDateStart() );
		$this->assertEquals( $item->getDateEnd(), $itemSaved->getDateEnd() );
		$this->assertEquals( $item->getPosition(), $itemSaved->getPosition() );
		$this->assertEquals( $this->editor, $itemSaved->getEditor() );
		$this->assertStringStartsWith(date('Y-m-d', time()), $itemSaved->getTimeCreated());
		$this->assertStringStartsWith(date('Y-m-d', time()), $itemSaved->getTimeModified());

		$this->assertEquals( $this->editor, $itemSaved->getEditor() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeCreated() );
		$this->assertRegExp('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeModified() );

		$this->assertTrue( $itemUpd->getType() !== null );
		$this->assertEquals( $itemExp->getId(), $itemUpd->getId() );
		$this->assertEquals( $itemExp->getSiteId(), $itemUpd->getSiteId() );
		$this->assertEquals( $itemExp->getParentId(), $itemUpd->getParentId() );
		$this->assertEquals( $itemExp->getTypeId(), $itemUpd->getTypeId() );
		$this->assertEquals( $itemExp->getRefId(), $itemUpd->getRefId() );
		$this->assertEquals( $itemExp->getDomain(), $itemUpd->getDomain() );
		$this->assertEquals( $itemExp->getDateStart(), $itemUpd->getDateStart() );
		$this->assertEquals( $itemExp->getDateEnd(), $itemUpd->getDateEnd() );
		$this->assertEquals( $itemExp->getPosition(), $itemUpd->getPosition() );

		$this->assertEquals( $this->editor, $itemUpd->getEditor() );
		$this->assertEquals( $itemExp->getTimeCreated(), $itemUpd->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemUpd->getTimeModified() );

		$this->setExpectedException('MShop_Exception');
		$this->object->getItem( $itemSaved->getId() );
	}


	public function testMoveItemLastToFront()
	{
		$listItems = $this->getListItems();
		$this->assertGreaterThan( 1, count( $listItems ) );

		if( ( $first = reset( $listItems ) ) === false ) {
			throw new Exception( 'No first customer list item' );
		}

		if( ( $last = end( $listItems ) ) === false ) {
			throw new Exception( 'No last customer list item' );
		}

		$this->object->moveItem( $last->getId(), $first->getId() );

		$newFirst = $this->object->getItem( $last->getId() );
		$newSecond = $this->object->getItem( $first->getId() );

		$this->object->moveItem( $last->getId() );

		$this->assertEquals( 0, $newFirst->getPosition() );
		$this->assertEquals( 1, $newSecond->getPosition() );
	}


	public function testMoveItemFirstToLast()
	{
		$listItems = $this->getListItems();
		$this->assertGreaterThan( 1, count( $listItems ) );

		if( ( $first = reset( $listItems ) ) === false ) {
			throw new Exception( 'No first customer list item' );
		}

		if( ( $second = next( $listItems ) ) === false ) {
			throw new Exception( 'No second customer list item' );
		}

		if( ( $last = end( $listItems ) ) === false ) {
			throw new Exception( 'No last customer list item' );
		}

		$this->object->moveItem( $first->getId() );

		$newBefore = $this->object->getItem( $last->getId() );
		$newLast = $this->object->getItem( $first->getId() );

		$this->object->moveItem( $first->getId(), $second->getId() );

		$this->assertEquals( $last->getPosition() - 1, $newBefore->getPosition() );
		$this->assertEquals( $last->getPosition(), $newLast->getPosition() );
	}


	public function testMoveItemFirstUp()
	{
		$listItems = $this->getListItems();
		$this->assertGreaterThan( 1, count( $listItems ) );

		if( ( $first = reset( $listItems ) ) === false ) {
			throw new Exception( 'No first customer list item' );
		}

		if( ( $second = next( $listItems ) ) === false ) {
			throw new Exception( 'No second customer list item' );
		}

		if( ( $last = end( $listItems ) ) === false ) {
			throw new Exception( 'No last customer list item' );
		}

		$this->object->moveItem( $first->getId(), $last->getId() );

		$newLast = $this->object->getItem( $last->getId() );
		$newUp = $this->object->getItem( $first->getId() );

		$this->object->moveItem( $first->getId(), $second->getId() );

		$this->assertEquals( $last->getPosition() - 1, $newUp->getPosition() );
		$this->assertEquals( $last->getPosition(), $newLast->getPosition() );
	}


	public function testSearchItems()
	{
		$total = 0;
		$search = $this->object->createSearch();

		$expr = array();
		$expr[] = $search->compare( '!=', 'customer.list.id', null );
		$expr[] = $search->compare( '!=', 'customer.list.siteid', null );
		$expr[] = $search->compare( '>', 'customer.list.parentid', 0 );
		$expr[] = $search->compare( '==', 'customer.list.domain', 'text' );
		$expr[] = $search->compare( '>', 'customer.list.typeid', 0 );
		$expr[] = $search->compare( '>', 'customer.list.refid', 0 );
		$expr[] = $search->compare( '==', 'customer.list.datestart', '2010-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'customer.list.dateend', '2100-01-01 00:00:00' );
		$expr[] = $search->compare( '!=', 'customer.list.config', null );
		$expr[] = $search->compare( '>', 'customer.list.position', 0 );
		$expr[] = $search->compare( '==', 'customer.list.status', 1 );
		$expr[] = $search->compare( '>=', 'customer.list.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>=', 'customer.list.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'customer.list.editor', $this->editor );

		$expr[] = $search->compare( '!=', 'customer.list.type.id', 0 );
		$expr[] = $search->compare( '!=', 'customer.list.type.siteid', null );
		$expr[] = $search->compare( '==', 'customer.list.type.code', 'default' );
		$expr[] = $search->compare( '==', 'customer.list.type.domain', 'text' );
		$expr[] = $search->compare( '==', 'customer.list.type.label', 'Default' );
		$expr[] = $search->compare( '==', 'customer.list.type.status', 1 );
		$expr[] = $search->compare( '>=', 'customer.list.type.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>=', 'customer.list.type.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'customer.list.type.editor', $this->editor );

		$search->setConditions( $search->combine( '&&', $expr ) );
		$search->setSlice(0, 2);
		$results = $this->object->searchItems( $search, array(), $total );
		$this->assertEquals( 2, count( $results ) );
		$this->assertEquals( 3, $total );

		foreach($results as $itemId => $item) {
			$this->assertEquals( $itemId, $item->getId() );
		}
	}


	public function testSearchItemsNoCriteria()
	{
		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'customer.list.editor', $this->editor ) );
		$this->assertEquals( 4, count( $this->object->searchItems($search) ) );
	}


	public function testSearchItemsBaseCriteria()
	{
		$search = $this->object->createSearch(true);
		$conditions = array(
			$search->compare( '==', 'customer.list.editor', $this->editor ),
			$search->getConditions()
		);
		$search->setConditions( $search->combine( '&&', $conditions ) );
		$this->assertEquals( 4, count( $this->object->searchItems($search) ) );
	}


	public function testGetSubManager()
	{
		$this->assertInstanceOf( 'MShop_Common_Manager_Interface', $this->object->getSubManager('type') );
		$this->assertInstanceOf( 'MShop_Common_Manager_Interface', $this->object->getSubManager('type', 'Default') );

		$this->setExpectedException( 'MShop_Exception' );
		$this->object->getSubManager( 'unknown' );
	}


	protected function getListItems()
	{
		$manager = MShop_Customer_Manager_Factory::createManager( $this->context, 'Laravel' );

		$search = $manager->createSearch();
		$search->setConditions( $search->compare( '==', 'customer.code', 'unitCustomer3' ) );
		$search->setSlice( 0, 1 );

		$results = $manager->searchItems( $search );

		if( ( $item = reset( $results ) ) === false ) {
			throw new Exception( 'No customer item found' );
		}

		$search = $this->object->createSearch();
		$expr = array(
			$search->compare( '==', 'customer.list.parentid', $item->getId() ),
			$search->compare( '==', 'customer.list.domain', 'text' ),
			$search->compare( '==', 'customer.list.editor', $this->editor ),
			$search->compare( '==', 'customer.list.type.code', 'default' ),
		);
		$search->setConditions( $search->combine( '&&', $expr ) );
		$search->setSortations( array( $search->sort( '+', 'customer.list.position' ) ) );

		return $this->object->searchItems( $search );
	}
}
