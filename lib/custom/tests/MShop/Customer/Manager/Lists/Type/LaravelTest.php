<?php

namespace Aimeos\MShop\Customer\Manager\Lists\Type;


/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2017
 */
class LaravelTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $editor = 'ai-laravel:unittest';


	protected function setUp()
	{
		$this->editor = \TestHelper::getContext()->getEditor();
		$manager = \Aimeos\MShop\Customer\Manager\Factory::createManager( \TestHelper::getContext(), 'Laravel' );

		$listManager = $manager->getSubManager( 'lists', 'Laravel' );
		$this->object = $listManager->getSubManager( 'type', 'Laravel' );
	}


	protected function tearDown()
	{
		unset( $this->object );
	}


	public function testCleanup()
	{
		$this->object->cleanup( array( -1 ) );
	}


	public function testCreateItem()
	{
		$item = $this->object->createItem();
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Common\\Item\\Type\\Iface', $item );
	}


	public function testGetItem()
	{
		$search = $this->object->createSearch();
		$search->setSlice(0, 1);
		$results = $this->object->searchItems($search);

		if( ( $expected = reset($results) ) === false ) {
			throw new \RuntimeException( 'No list type item found' );
		}

		$this->assertEquals( $expected, $this->object->getItem( $expected->getId() ) );
	}


	public function testGetSubManager()
	{
		$this->setExpectedException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getSubManager( 'unknown' );
	}


	public function testSaveUpdateDeleteItem()
	{
		$search = $this->object->createSearch();
		$search->setSlice(0, 1);
		$results = $this->object->searchItems($search);

		if( ( $item = reset($results) ) === false ) {
			throw new \RuntimeException( 'No type item found' );
		}

		$item->setId(null);
		$item->setCode( 'unitTestInit' );
		$resultSaved = $this->object->saveItem( $item );
		$itemSaved = $this->object->getItem( $item->getId() );

		$itemExp = clone $itemSaved;
		$itemExp->setCode( 'unitTestSave' );
		$resultUpd = $this->object->saveItem( $itemExp );
		$itemUpd = $this->object->getItem( $itemExp->getId() );

		$this->object->deleteItem( $itemSaved->getId() );


		$this->assertTrue( $item->getId() !== null );
		$this->assertEquals( $item->getId(), $itemSaved->getId() );
		$this->assertEquals( $item->getSiteId(), $itemSaved->getSiteId() );
		$this->assertEquals( $item->getCode(), $itemSaved->getCode() );
		$this->assertEquals( $item->getDomain(), $itemSaved->getDomain() );
		$this->assertEquals( $item->getLabel(), $itemSaved->getLabel() );
		$this->assertEquals( $item->getStatus(), $itemSaved->getStatus() );

		$this->assertEquals( $this->editor, $itemSaved->getEditor() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeModified() );

		$this->assertEquals( $itemExp->getId(), $itemUpd->getId() );
		$this->assertEquals( $itemExp->getSiteId(), $itemUpd->getSiteId() );
		$this->assertEquals( $itemExp->getCode(), $itemUpd->getCode() );
		$this->assertEquals( $itemExp->getDomain(), $itemUpd->getDomain() );
		$this->assertEquals( $itemExp->getLabel(), $itemUpd->getLabel() );
		$this->assertEquals( $itemExp->getStatus(), $itemUpd->getStatus() );

		$this->assertEquals( $this->editor, $itemUpd->getEditor() );
		$this->assertEquals( $itemExp->getTimeCreated(), $itemUpd->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemUpd->getTimeModified() );

		$this->assertInstanceOf( '\Aimeos\MShop\Common\Item\Iface', $resultSaved );
		$this->assertInstanceOf( '\Aimeos\MShop\Common\Item\Iface', $resultUpd );

		$this->setExpectedException('\\Aimeos\\MShop\\Exception');
		$this->object->getItem( $itemSaved->getId() );
	}


	public function testSearchItems()
	{
		$total = 0;
		$search = $this->object->createSearch();

		$expr = [];
		$expr[] = $search->compare( '!=', 'customer.lists.type.id', 0 );
		$expr[] = $search->compare( '!=', 'customer.lists.type.siteid', null );
		$expr[] = $search->compare( '==', 'customer.lists.type.code', 'default' );
		$expr[] = $search->compare( '==', 'customer.lists.type.domain', 'text' );
		$expr[] = $search->compare( '==', 'customer.lists.type.label', 'Standard' );
		$expr[] = $search->compare( '==', 'customer.lists.type.status', 1 );
		$expr[] = $search->compare( '>=', 'customer.lists.type.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>=', 'customer.lists.type.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'customer.lists.type.editor', $this->editor );

		$search->setConditions( $search->combine( '&&', $expr ) );
		$search->setSlice(0, 1);

		$results = $this->object->searchItems( $search, [], $total );
		$this->assertEquals( 1, count( $results ) );
		$this->assertEquals( 1, $total );

		foreach($results as $itemId => $item) {
			$this->assertEquals( $itemId, $item->getId() );
		}
	}

}
