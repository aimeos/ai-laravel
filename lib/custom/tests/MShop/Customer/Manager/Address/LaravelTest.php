<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2022
 */


namespace Aimeos\MShop\Customer\Manager\Address;


class LaravelTest extends \PHPUnit\Framework\TestCase
{
	private $fixture = null;
	private $object = null;
	private $editor = '';


	protected function setUp() : void
	{
		$context = \TestHelper::context();
		$this->editor = $context->editor();
		$customer = new \Aimeos\MShop\Customer\Manager\Laravel( $context );

		$search = $customer->filter();
		$conditions = array(
			$search->compare( '==', 'customer.code', 'test@example.com' ),
			$search->compare( '==', 'customer.editor', $this->editor )
		);
		$search->setConditions( $search->and( $conditions ) );

		if( ( $item = $customer->search( $search )->first() ) === null ) {
			throw new \RuntimeException( sprintf( 'No customer item found for code "%1$s"', 'test@example.com' ) );
		}

		$this->fixture = array(
			'customer.address.parentid' => $item->getId(),
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
			'customer.address.longitude' => '10.0',
			'customer.address.latitude' => '50.0',
			'customer.address.position' => 1,
			'customer.address.latitude' => '2000-01-01',
			'customer.address.siteid' => $context->locale()->getSiteId(),
		);

		$this->object = $customer->getSubManager( 'address', 'Laravel' );
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->fixture );
	}


	public function testClear()
	{
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->clear( array( -1 ) ) );
	}


	public function testGetSearchAttributes()
	{
		foreach( $this->object->getSearchAttributes() as $attribute ) {
			$this->assertInstanceOf( '\\Aimeos\\MW\\Criteria\\Attribute\\Iface', $attribute );
		}
	}


	public function testGetSubManager()
	{
		$this->expectException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getSubManager( 'unknown' );
	}


	public function testCreateItem()
	{
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Common\\Item\\Address\\Iface', $this->object->create() );
	}


	public function testGetItem()
	{
		$search = $this->object->filter()->slice( 0, 1 );
		$search->setConditions( $search->compare( '~=', 'customer.address.company', 'Example company' ) );

		if( ( $item = $this->object->search( $search )->first() ) === null ) {
			throw new \RuntimeException( 'No address item found' );
		}

		$this->assertEquals( $item, $this->object->get( $item->getId() ) );
	}


	public function testSaveUpdateDeleteItem()
	{
		$item = new \Aimeos\MShop\Common\Item\Address\Standard( 'customer.address.', $this->fixture );
		$item->setId( null );
		$resultSaved = $this->object->save( $item );
		$itemSaved = $this->object->get( $item->getId() );

		$itemExp = clone $itemSaved;
		$itemExp->setPosition( 1 );
		$itemExp->setCity( 'Berlin' );
		$itemExp->setState( 'Berlin' );
		$resultUpd = $this->object->save( $itemExp );
		$itemUpd = $this->object->get( $itemExp->getId() );

		$this->object->delete( $itemSaved->getId() );


		$this->assertTrue( $item->getId() !== null );
		$this->assertEquals( $item->getId(), $itemSaved->getId() );
		$this->assertEquals( $item->getParentId(), $itemSaved->getParentId() );
		$this->assertEquals( $item->getPosition(), $itemSaved->getPosition() );
		$this->assertEquals( $item->getCompany(), $itemSaved->getCompany() );
		$this->assertEquals( $item->getVatID(), $itemSaved->getVatID() );
		$this->assertEquals( $item->getSalutation(), $itemSaved->getSalutation() );
		$this->assertEquals( $item->getTitle(), $itemSaved->getTitle() );
		$this->assertEquals( $item->getFirstname(), $itemSaved->getFirstname() );
		$this->assertEquals( $item->getLastname(), $itemSaved->getLastname() );
		$this->assertEquals( $item->getAddress1(), $itemSaved->getAddress1() );
		$this->assertEquals( $item->getAddress2(), $itemSaved->getAddress2() );
		$this->assertEquals( $item->getAddress3(), $itemSaved->getAddress3() );
		$this->assertEquals( $item->getPostal(), $itemSaved->getPostal() );
		$this->assertEquals( $item->getCity(), $itemSaved->getCity() );
		$this->assertEquals( $item->getState(), $itemSaved->getState() );
		$this->assertEquals( $item->getCountryId(), $itemSaved->getCountryId() );
		$this->assertEquals( $item->getLanguageId(), $itemSaved->getLanguageId() );
		$this->assertEquals( $item->getTelephone(), $itemSaved->getTelephone() );
		$this->assertEquals( $item->getEmail(), $itemSaved->getEmail() );
		$this->assertEquals( $item->getTelefax(), $itemSaved->getTelefax() );
		$this->assertEquals( $item->getWebsite(), $itemSaved->getWebsite() );
		$this->assertEquals( $item->getLongitude(), $itemSaved->getLongitude() );
		$this->assertEquals( $item->getLatitude(), $itemSaved->getLatitude() );
		$this->assertEquals( $item->getBirthday(), $itemSaved->getBirthday() );

		$this->assertEquals( $this->editor, $itemSaved->editor() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeModified() );

		$this->assertEquals( $itemExp->getId(), $itemUpd->getId() );
		$this->assertEquals( $itemExp->getParentId(), $itemUpd->getParentId() );
		$this->assertEquals( $itemExp->getPosition(), $itemUpd->getPosition() );
		$this->assertEquals( $itemExp->getCompany(), $itemUpd->getCompany() );
		$this->assertEquals( $itemExp->getVatID(), $itemUpd->getVatID() );
		$this->assertEquals( $itemExp->getSalutation(), $itemUpd->getSalutation() );
		$this->assertEquals( $itemExp->getTitle(), $itemUpd->getTitle() );
		$this->assertEquals( $itemExp->getFirstname(), $itemUpd->getFirstname() );
		$this->assertEquals( $itemExp->getLastname(), $itemUpd->getLastname() );
		$this->assertEquals( $itemExp->getAddress1(), $itemUpd->getAddress1() );
		$this->assertEquals( $itemExp->getAddress2(), $itemUpd->getAddress2() );
		$this->assertEquals( $itemExp->getAddress3(), $itemUpd->getAddress3() );
		$this->assertEquals( $itemExp->getPostal(), $itemUpd->getPostal() );
		$this->assertEquals( $itemExp->getCity(), $itemUpd->getCity() );
		$this->assertEquals( $itemExp->getState(), $itemUpd->getState() );
		$this->assertEquals( $itemExp->getCountryId(), $itemUpd->getCountryId() );
		$this->assertEquals( $itemExp->getLanguageId(), $itemUpd->getLanguageId() );
		$this->assertEquals( $itemExp->getTelephone(), $itemUpd->getTelephone() );
		$this->assertEquals( $itemExp->getEmail(), $itemUpd->getEmail() );
		$this->assertEquals( $itemExp->getTelefax(), $itemUpd->getTelefax() );
		$this->assertEquals( $itemExp->getWebsite(), $itemUpd->getWebsite() );
		$this->assertEquals( $itemExp->getLongitude(), $itemUpd->getLongitude() );
		$this->assertEquals( $itemExp->getLatitude(), $itemUpd->getLatitude() );
		$this->assertEquals( $itemExp->getBirthday(), $itemUpd->getBirthday() );

		$this->assertEquals( $this->editor, $itemUpd->editor() );
		$this->assertEquals( $itemExp->getTimeCreated(), $itemUpd->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemUpd->getTimeModified() );

		$this->assertInstanceOf( \Aimeos\MShop\Common\Item\Iface::class, $resultSaved );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Item\Iface::class, $resultUpd );

		$this->expectException( '\\Aimeos\\MShop\\Exception' );
		$this->object->get( $itemSaved->getId() );
	}


	public function testCreateSearch()
	{
		$this->assertInstanceOf( '\\Aimeos\\MW\\Criteria\\Iface', $this->object->filter() );
	}


	public function testSearchItem()
	{
		$search = $this->object->filter();

		$conditions = array(
			$search->compare( '!=', 'customer.address.id', null ),
			$search->compare( '!=', 'customer.address.parentid', null ),
			$search->compare( '==', 'customer.address.company', 'Example company' ),
			$search->compare( '==', 'customer.address.vatid', 'DE999999999' ),
			$search->compare( '==', 'customer.address.salutation', 'mr' ),
			$search->compare( '==', 'customer.address.title', 'Dr' ),
			$search->compare( '==', 'customer.address.firstname', 'Our' ),
			$search->compare( '==', 'customer.address.lastname', 'Unittest' ),
			$search->compare( '==', 'customer.address.address1', 'Pickhuben' ),
			$search->compare( '==', 'customer.address.address2', '2-4' ),
			$search->compare( '==', 'customer.address.address3', '' ),
			$search->compare( '==', 'customer.address.postal', '20457' ),
			$search->compare( '==', 'customer.address.city', 'Hamburg' ),
			$search->compare( '==', 'customer.address.state', 'Hamburg' ),
			$search->compare( '==', 'customer.address.countryid', 'DE' ),
			$search->compare( '==', 'customer.address.languageid', 'de' ),
			$search->compare( '==', 'customer.address.telephone', '055544332211' ),
			$search->compare( '==', 'customer.address.email', 'test@example.com' ),
			$search->compare( '==', 'customer.address.telefax', '055544332212' ),
			$search->compare( '==', 'customer.address.website', 'www.example.com' ),
			$search->compare( '==', 'customer.address.longitude', '10.0' ),
			$search->compare( '==', 'customer.address.latitude', '50.0' ),
			$search->compare( '==', 'customer.address.birthday', '2000-01-01' ),
			$search->compare( '>=', 'customer.address.mtime', '1970-01-01 00:00:00' ),
			$search->compare( '>=', 'customer.address.ctime', '1970-01-01 00:00:00' ),
			$search->compare( '==', 'customer.address.editor', $this->editor ),
		);
		$search->setConditions( $search->and( $conditions ) );
		$this->assertEquals( 1, count( $this->object->search( $search ) ) );
	}


	public function testSearchItemTotal()
	{
		$total = 0;
		$search = $this->object->filter();

		$conditions = array(
			$search->compare( '~=', 'customer.address.company', 'Example company' ),
			$search->compare( '==', 'customer.address.editor', $this->editor )
		);

		$search->setConditions( $search->and( $conditions ) );
		$search->slice( 0, 2 );

		$results = $this->object->search( $search, [], $total );

		$this->assertEquals( 2, count( $results ) );
		$this->assertEquals( 3, $total );

		foreach( $results as $id => $item ) {
			$this->assertEquals( $id, $item->getId() );
		}
	}
}
