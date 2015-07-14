<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */


class MShop_Customer_Manager_Address_LaravelTest extends MW_Unittest_Testcase
{
	private $_fixture = null;
	private $_object = null;
	private $_editor = 'ai-laravel:unittest';


	/**
	 * Sets up the fixture. This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$context = TestHelper::getContext();
		$this->_editor = $context->getEditor();
		$customer = new MShop_Customer_Manager_Laravel( $context );

		$search = $customer->createSearch();
		$conditions = array(
			$search->compare( '==', 'customer.label', 'unitCustomer1' ),
			$search->compare( '==', 'customer.editor', $this->_editor )
		);
		$search->setConditions( $search->combine( '&&', $conditions ) );
		$result = $customer->searchItems( $search );

		if( ( $customerItem = reset( $result ) ) === false ) {
			throw new Exception( sprintf( 'No customer item found for label "%1$s"', 'unitCustomer1' ) );
		}

		$this->_fixture = array(
			'refid' => $customerItem->getId(),
			'company' => 'ABC GmbH',
			'vatid' => 'DE999999999',
			'salutation' => MShop_Common_Item_Address_Abstract::SALUTATION_MR,
			'title' => 'Herr',
			'firstname' => 'firstunit',
			'lastname' => 'lastunit',
			'address1' => 'unit str.',
			'address2' => ' 166',
			'address3' => '4.OG',
			'postal' => '22769',
			'city' => 'Hamburg',
			'state' => 'Hamburg',
			'countryid' => 'de',
			'langid' => 'de',
			'telephone' => '05554433221',
			'email' => 'unittest@aimeos.org',
			'telefax' => '05554433222',
			'website' => 'unittest.aimeos.org',
			'position' => 1,
			'siteid' => $context->getLocale()->getSiteId(),
		);

		$this->_object = $customer->getSubManager( 'address', 'Laravel' );
	}


	/**
	 * Tears down the fixture. This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		unset( $this->_object, $this->_fixture );
	}


	public function testCleanup()
	{
		$this->_object->cleanup( array( -1 ) );
	}

	public function testGetSearchAttributes()
	{
		foreach( $this->_object->getSearchAttributes() as $attribute ) {
			$this->assertInstanceOf( 'MW_Common_Criteria_Attribute_Interface', $attribute );
		}
	}

	public function testCreateItem()
	{
		$this->assertInstanceOf( 'MShop_Common_Item_Address_Interface', $this->_object->createItem() );
	}

	public function testGetItem()
	{
		$search = $this->_object->createSearch();
		$search->setConditions( $search->compare( '~=', 'customer.address.company', 'ABC GmbH' ) );

		$items = $this->_object->searchItems( $search );

		if( ( $item = reset( $items ) ) === false ) {
			throw new Exception( 'No address item with company "ABC" found' );
		}

		$this->assertEquals( $item, $this->_object->getItem( $item->getId() ) );
	}

	public function testGetSubManager()
	{
		$this->setExpectedException( 'MShop_Exception' );
		$this->_object->getSubManager( 'unknown' );
	}

	public function testSaveUpdateDeleteItem()
	{
		$item = new MShop_Common_Item_Address_Default( 'customer.address.', $this->_fixture );
		$item->setId( null );
		$this->_object->saveItem( $item );
		$itemSaved = $this->_object->getItem( $item->getId() );

		$itemExp = clone $itemSaved;
		$itemExp->setPosition( 1 );
		$itemExp->setCity( 'Berlin' );
		$itemExp->setState( 'Berlin' );
		$this->_object->saveItem( $itemExp );
		$itemUpd = $this->_object->getItem( $itemExp->getId() );

		$this->_object->deleteItem( $itemSaved->getId() );


		$this->assertTrue( $item->getId() !== null );
		$this->assertEquals( $item->getId(), $itemSaved->getId() );
		$this->assertEquals( $item->getRefId(), $itemSaved->getRefId());
		$this->assertEquals( $item->getPosition(), $itemSaved->getPosition());
		$this->assertEquals( $item->getCompany(), $itemSaved->getCompany());
		$this->assertEquals( $item->getVatID(), $itemSaved->getVatID());
		$this->assertEquals( $item->getSalutation(), $itemSaved->getSalutation());
		$this->assertEquals( $item->getTitle(), $itemSaved->getTitle());
		$this->assertEquals( $item->getFirstname(), $itemSaved->getFirstname());
		$this->assertEquals( $item->getLastname(), $itemSaved->getLastname());
		$this->assertEquals( $item->getAddress1(), $itemSaved->getAddress1());
		$this->assertEquals( $item->getAddress2(), $itemSaved->getAddress2());
		$this->assertEquals( $item->getAddress3(), $itemSaved->getAddress3());
		$this->assertEquals( $item->getPostal(), $itemSaved->getPostal());
		$this->assertEquals( $item->getCity(), $itemSaved->getCity());
		$this->assertEquals( $item->getState(), $itemSaved->getState());
		$this->assertEquals( $item->getCountryId(), $itemSaved->getCountryId());
		$this->assertEquals( $item->getLanguageId(), $itemSaved->getLanguageId());
		$this->assertEquals( $item->getTelephone(), $itemSaved->getTelephone());
		$this->assertEquals( $item->getEmail(), $itemSaved->getEmail());
		$this->assertEquals( $item->getTelefax(), $itemSaved->getTelefax());
		$this->assertEquals( $item->getWebsite(), $itemSaved->getWebsite());
		$this->assertEquals( $item->getFlag(), $itemSaved->getFlag());

		$this->assertEquals( $this->_editor, $itemSaved->getEditor() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeCreated() );
		$this->assertRegExp('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeModified());

		$this->assertEquals( $itemExp->getId(), $itemUpd->getId() );
		$this->assertEquals( $itemExp->getRefId(), $itemUpd->getRefId());
		$this->assertEquals( $itemExp->getPosition(), $itemUpd->getPosition());
		$this->assertEquals( $itemExp->getCompany(), $itemUpd->getCompany());
		$this->assertEquals( $itemExp->getVatID(), $itemUpd->getVatID());
		$this->assertEquals( $itemExp->getSalutation(), $itemUpd->getSalutation());
		$this->assertEquals( $itemExp->getTitle(), $itemUpd->getTitle());
		$this->assertEquals( $itemExp->getFirstname(), $itemUpd->getFirstname());
		$this->assertEquals( $itemExp->getLastname(), $itemUpd->getLastname());
		$this->assertEquals( $itemExp->getAddress1(), $itemUpd->getAddress1());
		$this->assertEquals( $itemExp->getAddress2(), $itemUpd->getAddress2());
		$this->assertEquals( $itemExp->getAddress3(), $itemUpd->getAddress3());
		$this->assertEquals( $itemExp->getPostal(), $itemUpd->getPostal());
		$this->assertEquals( $itemExp->getCity(), $itemUpd->getCity());
		$this->assertEquals( $itemExp->getState(), $itemUpd->getState());
		$this->assertEquals( $itemExp->getCountryId(), $itemUpd->getCountryId());
		$this->assertEquals( $itemExp->getLanguageId(), $itemUpd->getLanguageId());
		$this->assertEquals( $itemExp->getTelephone(), $itemUpd->getTelephone());
		$this->assertEquals( $itemExp->getEmail(), $itemUpd->getEmail());
		$this->assertEquals( $itemExp->getTelefax(), $itemUpd->getTelefax());
		$this->assertEquals( $itemExp->getWebsite(), $itemUpd->getWebsite());
		$this->assertEquals( $itemExp->getFlag(), $itemUpd->getFlag());

		$this->assertEquals( $this->_editor, $itemUpd->getEditor() );
		$this->assertEquals( $itemExp->getTimeCreated(), $itemUpd->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemUpd->getTimeModified() );

		$this->setExpectedException('MShop_Exception');
		$this->_object->getItem( $itemSaved->getId() );
	}

	public function testCreateSearch()
	{
		$this->assertInstanceOf( 'MW_Common_Criteria_Interface', $this->_object->createSearch() );
	}


	public function testSearchItem()
	{
		$search = $this->_object->createSearch();

		$conditions = array(
			$search->compare( '==', 'customer.address.company', 'ABC' ),
			$search->compare( '==', 'customer.address.editor', $this->_editor )
		);
		$search->setConditions( $search->combine( '&&', $conditions ) );
		$this->assertEquals( 1, count( $this->_object->searchItems( $search ) ) );
	}


	public function testSearchItemTotal()
	{
		$total = 0;
		$search = $this->_object->createSearch();

		$conditions = array(
			$search->compare( '~=', 'customer.address.company', 'ABC GmbH' ),
			$search->compare( '==', 'customer.address.editor', $this->_editor )
		);

		$search->setConditions( $search->combine( '&&', $conditions ) );
		$search->setSlice( 0, 1 );

		$results = $this->_object->searchItems( $search, array(), $total );

		$this->assertEquals( 1, count( $results ) );
		$this->assertEquals( 2, $total );

		foreach( $results as $id => $item ) {
			$this->assertEquals( $id, $item->getId() );
		}
	}
}
