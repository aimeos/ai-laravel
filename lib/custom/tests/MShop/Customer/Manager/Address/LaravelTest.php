<?php

namespace Aimeos\MShop\Customer\Manager\Address;


/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */
class LaravelTest extends \PHPUnit_Framework_TestCase
{
	private $fixture = null;
	private $object = null;
	private $editor = 'ai-laravel:unittest';


	/**
	 * Sets up the fixture. This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$context = \TestHelper::getContext();
		$this->editor = $context->getEditor();
		$customer = new \Aimeos\MShop\Customer\Manager\Laravel( $context );

		$search = $customer->createSearch();
		$conditions = array(
			$search->compare( '==', 'customer.code', 'unitCustomer1' ),
			$search->compare( '==', 'customer.editor', $this->editor )
		);
		$search->setConditions( $search->combine( '&&', $conditions ) );
		$result = $customer->searchItems( $search );

		if( ( $customerItem = reset( $result ) ) === false ) {
			throw new \Exception( sprintf( 'No customer item found for code "%1$s"', 'unitCustomer1' ) );
		}

		$this->fixture = array(
			'customer.address.parentid' => $customerItem->getId(),
			'customer.address.company' => 'ABC GmbH',
			'customer.address.vatid' => 'DE999999999',
			'customer.address.salutation' => \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_MR,
			'customer.address.title' => 'Herr',
			'customer.address.firstname' => 'firstunit',
			'customer.address.lastname' => 'lastunit',
			'customer.address.address1' => 'unit str.',
			'customer.address.address2' => ' 166',
			'customer.address.address3' => '4.OG',
			'customer.address.postal' => '22769',
			'customer.address.city' => 'Hamburg',
			'customer.address.state' => 'Hamburg',
			'customer.address.countryid' => 'de',
			'customer.address.languageid' => 'de',
			'customer.address.telephone' => '05554433221',
			'customer.address.email' => 'unittest@aimeos.org',
			'customer.address.telefax' => '05554433222',
			'customer.address.website' => 'unittest.aimeos.org',
			'customer.address.position' => 1,
			'customer.address.siteid' => $context->getLocale()->getSiteId(),
		);

		$this->object = $customer->getSubManager( 'address', 'Laravel' );
	}


	/**
	 * Tears down the fixture. This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		unset( $this->object, $this->fixture );
	}


	public function testCleanup()
	{
		$this->object->cleanup( array( -1 ) );
	}

	public function testGetSearchAttributes()
	{
		foreach( $this->object->getSearchAttributes() as $attribute ) {
			$this->assertInstanceOf( '\\Aimeos\\MW\\Criteria\\Attribute\\Iface', $attribute );
		}
	}

	public function testCreateItem()
	{
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Common\\Item\\Address\\Iface', $this->object->createItem() );
	}

	public function testGetItem()
	{
		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '~=', 'customer.address.company', 'ABC GmbH' ) );

		$items = $this->object->searchItems( $search );

		if( ( $item = reset( $items ) ) === false ) {
			throw new \Exception( 'No address item with company "ABC" found' );
		}

		$this->assertEquals( $item, $this->object->getItem( $item->getId() ) );
	}

	public function testGetSubManager()
	{
		$this->setExpectedException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getSubManager( 'unknown' );
	}

	public function testSaveUpdateDeleteItem()
	{
		$item = new \Aimeos\MShop\Common\Item\Address\Standard( 'customer.address.', $this->fixture );
		$item->setId( null );
		$this->object->saveItem( $item );
		$itemSaved = $this->object->getItem( $item->getId() );

		$itemExp = clone $itemSaved;
		$itemExp->setPosition( 1 );
		$itemExp->setCity( 'Berlin' );
		$itemExp->setState( 'Berlin' );
		$this->object->saveItem( $itemExp );
		$itemUpd = $this->object->getItem( $itemExp->getId() );

		$this->object->deleteItem( $itemSaved->getId() );


		$this->assertTrue( $item->getId() !== null );
		$this->assertEquals( $item->getId(), $itemSaved->getId() );
		$this->assertEquals( $item->getParentId(), $itemSaved->getParentId());
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

		$this->assertEquals( $this->editor, $itemSaved->getEditor() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeCreated() );
		$this->assertRegExp('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeModified());

		$this->assertEquals( $itemExp->getId(), $itemUpd->getId() );
		$this->assertEquals( $itemExp->getParentId(), $itemUpd->getParentId());
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

		$this->assertEquals( $this->editor, $itemUpd->getEditor() );
		$this->assertEquals( $itemExp->getTimeCreated(), $itemUpd->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemUpd->getTimeModified() );

		$this->setExpectedException('\\Aimeos\\MShop\\Exception');
		$this->object->getItem( $itemSaved->getId() );
	}

	public function testCreateSearch()
	{
		$this->assertInstanceOf( '\\Aimeos\\MW\\Criteria\\Iface', $this->object->createSearch() );
	}


	public function testSearchItem()
	{
		$search = $this->object->createSearch();

		$conditions = array(
			$search->compare( '==', 'customer.address.company', 'ABC' ),
			$search->compare( '==', 'customer.address.editor', $this->editor )
		);
		$search->setConditions( $search->combine( '&&', $conditions ) );
		$this->assertEquals( 1, count( $this->object->searchItems( $search ) ) );
	}


	public function testSearchItemTotal()
	{
		$total = 0;
		$search = $this->object->createSearch();

		$conditions = array(
			$search->compare( '~=', 'customer.address.company', 'ABC GmbH' ),
			$search->compare( '==', 'customer.address.editor', $this->editor )
		);

		$search->setConditions( $search->combine( '&&', $conditions ) );
		$search->setSlice( 0, 1 );

		$results = $this->object->searchItems( $search, array(), $total );

		$this->assertEquals( 1, count( $results ) );
		$this->assertEquals( 2, $total );

		foreach( $results as $id => $item ) {
			$this->assertEquals( $id, $item->getId() );
		}
	}
}
