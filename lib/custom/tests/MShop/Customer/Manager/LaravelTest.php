<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */


class MShop_Customer_Manager_LaravelTest extends MW_Unittest_Testcase
{
	private $_object;
	private $_fixture;
	private $_address;
	private $_editor = 'ai-laravel:unittest';


	/**
	 * Sets up the fixture. This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$context = TestHelper::getContext();
		$this->_editor = $context->getEditor();
		$this->_object = new MShop_Customer_Manager_Laravel( $context );

		$this->_fixture = array(
			'label' => 'unitTest',
			'status' => 2,
		);

		$this->_address = new MShop_Common_Item_Address_Default( 'common.address.' );
	}


	/**
	 * Tears down the fixture. This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		unset( $this->_object, $this->_fixture, $this->_address );
	}


	public function testCleanup()
	{
		$this->_object->cleanup( array( -1 ) );
	}


	public function testGetSearchAttributes()
	{
		foreach( $this->_object->getSearchAttributes() as $attribute )
		{
			$this->assertInstanceOf( 'MW_Common_Criteria_Attribute_Interface', $attribute );
		}
	}


	public function testCreateItem()
	{
		$this->assertInstanceOf( 'MShop_Customer_Item_Interface', $this->_object->createItem() );
	}


	public function testGetItem()
	{
		$search = $this->_object->createSearch();
		$conditions = array(
			$search->compare( '==', 'customer.code', 'unitCustomer3' ),
			$search->compare( '==', 'customer.editor', $this->_editor )
		);
		$search->setConditions( $search->combine( '&&', $conditions ) );
		$items = $this->_object->searchItems( $search, array( 'text' ) );

		if( ( $expected = reset( $items ) ) === false ) {
			throw new Exception( 'No customer item with code "unitCustomer3" found' );
		}

		$actual = $this->_object->getItem( $expected->getId(), array( 'text' ) );

		$this->assertEquals( $expected, $actual );
		$this->assertEquals( 3, count( $actual->getListItems( 'text' ) ) );
		$this->assertEquals( 3, count( $actual->getRefItems( 'text' ) ) );
	}


	public function testSaveUpdateDeleteItem()
	{
		$item = $this->_object->createItem();

		$item->setCode( 'unitTest' );
		$item->setLabel( 'unitTest' );
		$this->_object->saveItem( $item );
		$itemSaved = $this->_object->getItem( $item->getId() );

		$itemExp = clone $itemSaved;
		$itemExp->setCode( 'unitTest2' );
		$itemExp->setLabel( 'unitTest2' );
		$this->_object->saveItem( $itemExp );
		$itemUpd = $this->_object->getItem( $itemExp->getId() );

		$this->_object->deleteItem( $item->getId() );

		$this->assertTrue( $item->getId() !== null );
		$this->assertEquals( $item->getId(), $itemSaved->getId() );
		$this->assertEquals( $item->getSiteId(), $itemSaved->getSiteId() );
		$this->assertEquals( $item->getStatus(), $itemSaved->getStatus() );
		$this->assertEquals( $item->getCode(), $itemSaved->getCode() );
		$this->assertEquals( $item->getLabel(), $itemSaved->getLabel() );
		$this->assertEquals( $item->getPaymentAddress(), $itemSaved->getPaymentAddress() );
		$this->assertEquals( $item->getBirthday(), $itemSaved->getBirthday() );
		$this->assertEquals( $item->getPassword(), $itemSaved->getPassword() );

		$this->assertEquals( $this->_editor, $itemSaved->getEditor() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeModified() );

		$this->assertEquals( $itemExp->getId(), $itemUpd->getId() );
		$this->assertEquals( $itemExp->getSiteId(), $itemUpd->getSiteId() );
		$this->assertEquals( $itemExp->getStatus(), $itemUpd->getStatus() );
		$this->assertEquals( $itemExp->getCode(), $itemUpd->getCode() );
		$this->assertEquals( $itemExp->getLabel(), $itemUpd->getLabel() );
		$this->assertEquals( $itemExp->getPaymentAddress(), $itemUpd->getPaymentAddress() );
		$this->assertEquals( $itemExp->getBirthday(), $itemUpd->getBirthday() );
		$this->assertEquals( $itemExp->getPassword(), $itemUpd->getPassword() );

		$this->assertEquals( $this->_editor, $itemUpd->getEditor() );
		$this->assertEquals( $itemExp->getTimeCreated(), $itemUpd->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemUpd->getTimeModified() );

		$this->setExpectedException( 'MShop_Exception' );
		$this->_object->getItem( $item->getId() );
	}


	public function testCreateSearch()
	{
		$this->assertInstanceOf( 'MW_Common_Criteria_Interface', $this->_object->createSearch() );
	}


	public function testSearchItems()
	{
		$total = 0;
		$search = $this->_object->createSearch();

		$expr = array();
		$expr[] = $search->compare( '!=', 'customer.id', null );
		$expr[] = $search->compare( '==', 'customer.label', 'Erika Mustermann' );
		$expr[] = $search->compare( '==', 'customer.code', 'unitCustomer2' );

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

		$expr[] = $search->compare( '==', 'customer.birthday', '1970-01-01' );
		$expr[] = $search->compare( '>=', 'customer.password', '' );
		$expr[] = $search->compare( '==', 'customer.status', 0 );
		$expr[] = $search->compare( '!=', 'customer.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '!=', 'customer.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'customer.editor', $this->_editor );

		$expr[] = $search->compare( '!=', 'customer.address.id', null );
		$expr[] = $search->compare( '!=', 'customer.address.refid', null );
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
		$expr[] = $search->compare( '==', 'customer.address.countryid', 'de' );
		$expr[] = $search->compare( '==', 'customer.address.telephone', '055544332221' );
		$expr[] = $search->compare( '==', 'customer.address.email', 'unitCustomer2@aimeos.org' );
		$expr[] = $search->compare( '==', 'customer.address.telefax', '055544333212' );
		$expr[] = $search->compare( '==', 'customer.address.website', 'unittest.aimeos.org' );
		$expr[] = $search->compare( '==', 'customer.address.flag', 0 );
		$expr[] = $search->compare( '==', 'customer.address.position', 1 );
		$expr[] = $search->compare( '!=', 'customer.address.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '!=', 'customer.address.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'customer.address.editor', $this->_editor );

		$search->setConditions( $search->combine( '&&', $expr ) );
		$result = $this->_object->searchItems( $search, array(), $total );
		$this->assertEquals( 1, count( $result ) );
	}


	public function testSearchItemsNoCriteria()
	{
		$total = 0;

		$search = $this->_object->createSearch();
		$search->setConditions( $search->compare( '==', 'customer.address.editor', $this->_editor ) );
		$search->setSlice( 0, 2 );

		$results = $this->_object->searchItems( $search, array(), $total );
		$this->assertEquals( 2, count( $results ) );
		$this->assertEquals( 3, $total );

		foreach($results as $itemId => $item) {
			$this->assertEquals( $itemId, $item->getId() );
		}
	}


	public function testSearchItemsBaseCriteria()
	{
		$search = $this->_object->createSearch( true );
		$conditions = array(
			$search->compare( '==', 'customer.address.editor', $this->_editor ),
			$search->getConditions()
		);
		$search->setConditions( $search->combine( '&&', $conditions ) );
		$this->assertEquals( 2, count( $this->_object->searchItems( $search, array(), $total ) ) );
	}


	public function testGetSubManager()
	{
		$this->assertInstanceOf( 'MShop_Common_Manager_Interface', $this->_object->getSubManager( 'address' ) );
		$this->assertInstanceOf( 'MShop_Common_Manager_Interface', $this->_object->getSubManager( 'address', 'Default' ) );

		$this->setExpectedException( 'MShop_Exception' );
		$this->_object->getSubManager( 'unknown' );
	}


	public function testGetSubManagerInvalidName()
	{
		$this->setExpectedException( 'MShop_Exception' );
		$this->_object->getSubManager( 'address', 'unknown' );
	}
}
