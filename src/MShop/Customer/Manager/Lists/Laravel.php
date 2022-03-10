<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2022
 * @package MShop
 * @subpackage Customer
 */


namespace Aimeos\MShop\Customer\Manager\Lists;


/**
 * Laravel implementation of the customer list class.
 *
 * @package MShop
 * @subpackage Customer
 */
class Laravel
	extends \Aimeos\MShop\Customer\Manager\Lists\Standard
{
	private $searchConfig = array(
		'customer.lists.id' => array(
			'code' =>'customer.lists.id',
			'internalcode' =>'mcusli."id"',
			'internaldeps' => array( 'LEFT JOIN "users_list" AS mcusli ON ( mcus."id" = mcusli."parentid" )' ),
			'label' =>'Customer list ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\Base\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.lists.siteid' => array(
			'code' =>'customer.lists.siteid',
			'internalcode' =>'mcusli."siteid"',
			'label' =>'Customer list site ID',
			'type' => 'string',
			'internaltype' => \Aimeos\Base\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'customer.lists.parentid' => array(
			'code' =>'customer.lists.parentid',
			'internalcode' =>'mcusli."parentid"',
			'label' =>'Customer list parent ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\Base\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.lists.key' => array(
			'code' => 'customer.lists.key',
			'internalcode' => 'mcusli."key"',
			'label' => 'Unique key',
			'type' => 'string',
			'internaltype' => \Aimeos\Base\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'customer.lists.domain' => array(
			'code' =>'customer.lists.domain',
			'internalcode' =>'mcusli."domain"',
			'label' =>'Customer list domain',
			'type' => 'string',
			'internaltype' => \Aimeos\Base\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.type' => array(
			'code' =>'customer.lists.type',
			'internalcode' =>'mcusli."type"',
			'label' =>'Customer list type',
			'type' => 'string',
			'internaltype' => \Aimeos\Base\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.refid' => array(
			'code' =>'customer.lists.refid',
			'internalcode' =>'mcusli."refid"',
			'label' =>'Customer list reference ID',
			'type' => 'string',
			'internaltype' => \Aimeos\Base\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.datestart' => array(
			'code' =>'customer.lists.datestart',
			'internalcode' =>'mcusli."start"',
			'label' =>'Customer list start date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\Base\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.dateend' => array(
			'code' =>'customer.lists.dateend',
			'internalcode' =>'mcusli."end"',
			'label' =>'Customer list end date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\Base\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.config' => array(
			'code' =>'customer.lists.config',
			'internalcode' =>'mcusli."config"',
			'label' =>'Customer list position',
			'type' => 'string',
			'internaltype' => \Aimeos\Base\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.position' => array(
			'code' =>'customer.lists.position',
			'internalcode' =>'mcusli."pos"',
			'label' =>'Customer list position',
			'type' => 'integer',
			'internaltype' => \Aimeos\Base\DB\Statement\Base::PARAM_INT,
		),
		'customer.lists.status' => array(
			'code' =>'customer.lists.status',
			'internalcode' =>'mcusli."status"',
			'label' =>'Customer list status',
			'type' => 'integer',
			'internaltype' => \Aimeos\Base\DB\Statement\Base::PARAM_INT,
		),
		'customer.lists.ctime' => array(
			'code' =>'customer.lists.ctime',
			'internalcode' =>'mcusli."ctime"',
			'label' =>'Customer list create date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\Base\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.mtime' => array(
			'code' =>'customer.lists.mtime',
			'internalcode' =>'mcusli."mtime"',
			'label' =>'Customer list modification date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\Base\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.editor' => array(
			'code' =>'customer.lists.editor',
			'internalcode' =>'mcusli."editor"',
			'label' =>'Customer list editor',
			'type' => 'string',
			'internaltype' => \Aimeos\Base\DB\Statement\Base::PARAM_STR,
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
		$path = 'mshop/customer/manager/lists/submanagers';
		foreach( $this->context()->config()->get( $path, ['type'] ) as $domain ) {
			$this->object()->getSubManager( $domain )->clear( $siteids );
		}

		return $this->clearBase( $siteids, 'mshop/customer/manager/lists/laravel/delete' );
	}


	/**
	 * Returns the list attributes that can be used for searching.
	 *
	 * @param bool $withsub Return also attributes of sub-managers if true
	 * @return array List of attribute items implementing \Aimeos\MW\Criteria\Attribute\Iface
	 */
	public function getSearchAttributes( bool $withsub = true ) : array
	{
		$path = 'mshop/customer/manager/lists/submanagers';

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
		return $this->getSubManagerBase( 'customer', 'lists/' . $manager, ( $name === null ? 'Laravel' : $name ) );
	}


	/**
	 * Returns the config path for retrieving the configuration values.
	 *
	 * @return string Configuration path (mshop/customer/manager/lists/laravel/)
	 */
	protected function getConfigPath() : string
	{
		return 'mshop/customer/manager/lists/laravel/';
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
