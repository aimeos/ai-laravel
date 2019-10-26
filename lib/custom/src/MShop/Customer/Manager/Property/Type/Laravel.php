<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018
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
	private $searchConfig = array(
		'customer.property.type.id' => array(
			'code' => 'customer.property.type.id',
			'internalcode' => 'lvuprty."id"',
			'label' => 'Property type ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.property.type.siteid' => array(
			'code' => 'customer.property.type.siteid',
			'internalcode' => 'lvuprty."siteid"',
			'label' => 'Property type site ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.property.type.label' => array(
			'code' => 'customer.property.type.label',
			'internalcode' => 'lvuprty."label"',
			'label' => 'Property type label',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.property.type.code' => array(
			'code' => 'customer.property.type.code',
			'internalcode' => 'lvuprty."code"',
			'label' => 'Property type code',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.property.type.domain' => array(
			'code' => 'customer.property.type.domain',
			'internalcode' => 'lvuprty."domain"',
			'label' => 'Property type domain',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.property.type.status' => array(
			'code' => 'customer.property.type.status',
			'internalcode' => 'lvuprty."status"',
			'label' => 'Property type status',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'customer.property.type.position' => array(
			'code' => 'customer.property.type.position',
			'internalcode' => 'lvuprty."pos"',
			'label' => 'Property type position',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'customer.property.type.ctime' => array(
			'code' => 'customer.property.type.ctime',
			'internalcode' => 'lvuprty."ctime"',
			'label' => 'Property type create date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'customer.property.type.mtime' => array(
			'code' => 'customer.property.type.mtime',
			'internalcode' => 'lvuprty."mtime"',
			'label' => 'Property type modify date',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'customer.property.type.editor' => array(
			'code' => 'customer.property.type.editor',
			'internalcode' => 'lvuprty."editor"',
			'label' => 'Property type editor',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
	);


	/**
	 * Removes old entries from the storage.
	 *
	 * @param array $siteids List of IDs for sites whose entries should be deleted
	 */
	public function clear( array $siteids )
	{
		$path = 'mshop/customer/manager/property/type/submanagers';
		foreach( $this->getContext()->getConfig()->get( $path, [] ) as $domain ) {
			$this->getObject()->getSubManager( $domain )->clear( $siteids );
		}

		$this->cleanupBase( $siteids, 'mshop/customer/manager/property/type/laravel/delete' );
	}


	/**
	 * Returns the attributes that can be used for searching.
	 *
	 * @param boolean $withsub Return also attributes of sub-managers if true
	 * @return array Returns a list of attribtes implementing \Aimeos\MW\Criteria\Attribute\Iface
	 */
	public function getSearchAttributes( $withsub = true )
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
	public function getSubManager( $manager, $name = null )
	{
		return $this->getSubManagerBase( 'customer', 'property/type/' . $manager, ( $name === null ? 'Laravel' : $name ) );
	}


	/**
	 * Returns the config path for retrieving the configuration values.
	 *
	 * @return string Configuration path
	 */
	protected function getConfigPath()
	{
		return 'mshop/customer/manager/property/type/laravel/';
	}


	/**
	 * Returns the search configuration for searching items.
	 *
	 * @return array Associative list of search keys and search definitions
	 */
	protected function getSearchConfig()
	{
		return $this->searchConfig;
	}
}
