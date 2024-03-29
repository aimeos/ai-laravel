<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018-2024
 * @package MShop
 * @subpackage Customer
 */


namespace Aimeos\MShop\Customer\Manager\Property\Type;


/**
 * Default customer property type manager
 *
 * @package MShop
 * @subpackage Customer
 */
class Laravel
	extends \Aimeos\MShop\Customer\Manager\Property\Type\Standard
{
	private array $searchConfig = array(
		'customer.property.type.id' => array(
			'code' => 'customer.property.type.id',
			'internalcode' => 'mcusprty."id"',
			'label' => 'Property type ID',
			'type' => 'int',
			'public' => false,
		),
		'customer.property.type.siteid' => array(
			'code' => 'customer.property.type.siteid',
			'internalcode' => 'mcusprty."siteid"',
			'label' => 'Property type site ID',
			'type' => 'string',
			'public' => false,
		),
		'customer.property.type.label' => array(
			'code' => 'customer.property.type.label',
			'internalcode' => 'mcusprty."label"',
			'label' => 'Property type label',
			'type' => 'string',
		),
		'customer.property.type.code' => array(
			'code' => 'customer.property.type.code',
			'internalcode' => 'mcusprty."code"',
			'label' => 'Property type code',
			'type' => 'string',
		),
		'customer.property.type.domain' => array(
			'code' => 'customer.property.type.domain',
			'internalcode' => 'mcusprty."domain"',
			'label' => 'Property type domain',
			'type' => 'string',
		),
		'customer.property.type.status' => array(
			'code' => 'customer.property.type.status',
			'internalcode' => 'mcusprty."status"',
			'label' => 'Property type status',
			'type' => 'int',
		),
		'customer.property.type.position' => array(
			'code' => 'customer.property.type.position',
			'internalcode' => 'mcusprty."pos"',
			'label' => 'Property type position',
			'type' => 'int',
		),
		'customer.property.type.ctime' => array(
			'code' => 'customer.property.type.ctime',
			'internalcode' => 'mcusprty."ctime"',
			'label' => 'Property type create date/time',
			'type' => 'datetime',
			'public' => false,
		),
		'customer.property.type.mtime' => array(
			'code' => 'customer.property.type.mtime',
			'internalcode' => 'mcusprty."mtime"',
			'label' => 'Property type modify date',
			'type' => 'datetime',
			'public' => false,
		),
		'customer.property.type.editor' => array(
			'code' => 'customer.property.type.editor',
			'internalcode' => 'mcusprty."editor"',
			'label' => 'Property type editor',
			'type' => 'string',
			'public' => false,
		),
		'customer.property.type.i18n' => array(
			'internalcode' => 'mcusprty."i18n"',
			'label' => 'Type translation',
			'public' => false,
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
		$path = 'mshop/customer/manager/property/type/submanagers';
		foreach( $this->context()->config()->get( $path, [] ) as $domain ) {
			$this->object()->getSubManager( $domain )->clear( $siteids );
		}

		return $this->clearBase( $siteids, 'mshop/customer/manager/property/type/laravel/delete' );
	}


	/**
	 * Returns the attributes that can be used for searching.
	 *
	 * @param boolean $withsub Return also attributes of sub-managers if true
	 * @return array Returns a list of attribtes implementing \Aimeos\Base\Criteria\Attribute\Iface
	 */
	public function getSearchAttributes( bool $withsub = true ) : array
	{
		$path = 'mshop/customer/manager/property/type/submanagers';

		return $this->getSearchAttributesBase( $this->searchConfig, $path, [], $withsub );
	}


	/**
	 * Returns a new manager for customer type extensions.
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager for different extensions, e.g types, lists etc.
	 */
	public function getSubManager( string $manager, string $name = null ) : \Aimeos\MShop\Common\Manager\Iface
	{
		return $this->getSubManagerBase( 'customer', 'property/type/' . $manager, ( $name === null ? 'Laravel' : $name ) );
	}


	/**
	 * Returns the config path for retrieving the configuration values.
	 *
	 * @return string Configuration path
	 */
	protected function getConfigPath() : string
	{
		return 'mshop/customer/manager/property/type/laravel/';
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
