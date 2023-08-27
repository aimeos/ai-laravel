<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2023
 * @package MShop
 * @subpackage Customer
 */


namespace Aimeos\MShop\Customer\Manager\Address;


/**
 * Laravel implementation of the customer address class.
 *
 * @package MShop
 * @subpackage Customer
 */
class Laravel
	extends \Aimeos\MShop\Customer\Manager\Address\Standard
{
	private array $searchConfig = array(
		'customer.address.id' => array(
			'label' => 'Customer address ID',
			'code' => 'customer.address.id',
			'internalcode' => 'mcusad."id"',
			'internaldeps' => array( 'LEFT JOIN "users_address" AS mcusad ON ( mcus."id" = mcusad."parentid" )' ),
			'type' => 'int',
			'public' => false,
		),
		'customer.address.siteid' => array(
			'code' =>'customer.address.siteid',
			'internalcode' =>'mcusad."siteid"',
			'label' =>'Customer address site ID',
			'type' => 'string',
			'public' => false,
		),
		'customer.address.refid' => array(
			'label' => 'Customer address parent ID',
			'code' => 'customer.address.parentid',
			'internalcode' => 'mcusad."parentid"',
			'type' => 'int',
			'public' => false,
		),
		'customer.address.company' => array(
			'label' => 'Customer address company',
			'code' => 'customer.address.company',
			'internalcode' => 'mcusad."company"',
			'type' => 'string',
		),
		'customer.address.vatid' => array(
			'label' => 'Customer address VAT ID',
			'code' => 'customer.address.vatid',
			'internalcode' => 'mcusad."vatid"',
			'type' => 'string',
		),
		'customer.address.salutation' => array(
			'label' => 'Customer address salutation',
			'code' => 'customer.address.salutation',
			'internalcode' => 'mcusad."salutation"',
			'type' => 'string',
		),
		'customer.address.title' => array(
			'label' => 'Customer address title',
			'code' => 'customer.address.title',
			'internalcode' => 'mcusad."title"',
			'type' => 'string',
		),
		'customer.address.firstname' => array(
			'label' => 'Customer address firstname',
			'code' => 'customer.address.firstname',
			'internalcode' => 'mcusad."firstname"',
			'type' => 'string',
		),
		'customer.address.lastname' => array(
			'label' => 'Customer address lastname',
			'code' => 'customer.address.lastname',
			'internalcode' => 'mcusad."lastname"',
			'type' => 'string',
		),
		'customer.address.address1' => array(
			'label' => 'Customer address address part one',
			'code' => 'customer.address.address1',
			'internalcode' => 'mcusad."address1"',
			'type' => 'string',
		),
		'customer.address.address2' => array(
			'label' => 'Customer address address part two',
			'code' => 'customer.address.address2',
			'internalcode' => 'mcusad."address2"',
			'type' => 'string',
		),
		'customer.address.address3' => array(
			'label' => 'Customer address address part three',
			'code' => 'customer.address.address3',
			'internalcode' => 'mcusad."address3"',
			'type' => 'string',
		),
		'customer.address.postal' => array(
			'label' => 'Customer address postal',
			'code' => 'customer.address.postal',
			'internalcode' => 'mcusad."postal"',
			'type' => 'string',
		),
		'customer.address.city' => array(
			'label' => 'Customer address city',
			'code' => 'customer.address.city',
			'internalcode' => 'mcusad."city"',
			'type' => 'string',
		),
		'customer.address.state' => array(
			'label' => 'Customer address state',
			'code' => 'customer.address.state',
			'internalcode' => 'mcusad."state"',
			'type' => 'string',
		),
		'customer.address.languageid' => array(
			'label' => 'Customer address language',
			'code' => 'customer.address.languageid',
			'internalcode' => 'mcusad."langid"',
			'type' => 'string',
		),
		'customer.address.countryid' => array(
			'label' => 'Customer address country',
			'code' => 'customer.address.countryid',
			'internalcode' => 'mcusad."countryid"',
			'type' => 'string',
		),
		'customer.address.telephone' => array(
			'label' => 'Customer address telephone',
			'code' => 'customer.address.telephone',
			'internalcode' => 'mcusad."telephone"',
			'type' => 'string',
		),
		'customer.address.telefax' => array(
			'label' => 'Customer address telefax',
			'code' => 'customer.address.telefax',
			'internalcode' => 'mcusad."telefax"',
			'type' => 'string',
		),
		'customer.address.mobile' => array(
			'label' => 'Customer address mobile number',
			'code' => 'customer.address.mobile',
			'internalcode' => 'mcusad."mobile"',
			'type' => 'string',
		),
		'customer.address.email' => array(
			'label' => 'Customer address email',
			'code' => 'customer.address.email',
			'internalcode' => 'mcusad."email"',
			'type' => 'string',
		),
		'customer.address.website' => array(
			'label' => 'Customer address website',
			'code' => 'customer.address.website',
			'internalcode' => 'mcusad."website"',
			'type' => 'string',
		),
		'customer.address.longitude' => array(
			'label' => 'Customer address longitude',
			'code' => 'customer.address.longitude',
			'internalcode' => 'mcusad."longitude"',
			'type' => 'float',
		),
		'customer.address.latitude' => array(
			'label' => 'Customer address latitude',
			'code' => 'customer.address.latitude',
			'internalcode' => 'mcusad."latitude"',
			'type' => 'float',
		),
		'customer.address.position' => array(
			'label' => 'Customer address position',
			'code' => 'customer.address.position',
			'internalcode' => 'mcusad."pos"',
			'type' => 'int',
		),
		'customer.address.birthday' => array(
			'label' => 'Customer address birthday',
			'code' => 'customer.address.birthday',
			'internalcode' => 'mcusad."birthday"',
			'type' => 'date',
		),
		'customer.address.ctime' => array(
			'label' =>'Customer address create date/time',
			'code' =>'customer.address.ctime',
			'internalcode' =>'mcusad."ctime"',
			'type' => 'datetime',
		),
		'customer.address.mtime' => array(
			'label' =>'Customer address modification date/time',
			'code' =>'customer.address.mtime',
			'internalcode' =>'mcusad."mtime"',
			'type' => 'datetime',
		),
		'customer.address.editor' => array(
			'label' =>'Customer address editor',
			'code' =>'customer.address.editor',
			'internalcode' =>'mcusad."editor"',
			'type' => 'string',
		),
	);


	/**
	 * Removes old entries from the storage.
	 *
	 * @param iterable $siteids List of IDs for sites whose entries should be deleted
	 * @return \Aimeos\MShop\Common\Manager\Iface Same object for fluent interface
	 */
	public function clear( iterable $siteids ) : \Aimeos\MShop\Common\Manager\Iface
	{
		$path = 'mshop/customer/manager/address/submanagers';
		foreach( $this->context()->config()->get( $path, [] ) as $domain ) {
			$this->object()->getSubManager( $domain )->clear( $siteids );
		}

		return $this->clearBase( $siteids, 'mshop/customer/manager/address/laravel/clear' );
	}


	/**
	 * Returns the list attributes that can be used for searching.
	 *
	 * @param bool $withsub Return also attributes of sub-managers if true
	 * @return array List of attribute items implementing \Aimeos\Base\Criteria\Attribute\Iface
	 */
	public function getSearchAttributes( bool $withsub = true ) : array
	{
		$path = 'mshop/customer/manager/address/submanagers';

		return $this->getSearchAttributesBase( $this->searchConfig, $path, [], $withsub );
	}


	/**
	 * Returns a new manager for customer extensions
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager for different extensions, e.g stock, tags, locations, etc.
	 */
	public function getSubManager( string $manager, string $name = null ) : \Aimeos\MShop\Common\Manager\Iface
	{
		return $this->getSubManagerBase( 'customer', 'address/' . $manager, ( $name === null ? 'Laravel' : $name ) );
	}


	/**
	 * Returns the config path for retrieving the configuration values.
	 *
	 * @return string Configuration path (mshop/customer/manager/address/laravel/)
	 */
	protected function getConfigPath() : string
	{
		return 'mshop/customer/manager/address/laravel/';
	}


	/**
	 * Returns the search configuration for searching items.
	 *
	 * @return array Associative list of search keys and search definitions
	 */
	protected function getSearchConfig() : array
	{
		return $this->searchConfig;
	}
}
