<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2024
 * @package MShop
 * @subpackage Customer
 */


namespace Aimeos\MShop\Customer\Manager;


/**
 * Customer class implementation for Laravel.
 *
 * @package MShop
 * @subpackage Customer
 */
class Laravel
	extends \Aimeos\MShop\Customer\Manager\Standard
{
	/**
	 * Counts the number items that are available for the values of the given key.
	 *
	 * @param \Aimeos\Base\Criteria\Iface $search Search criteria
	 * @param array|string $key Search key or list of key to aggregate items for
	 * @param string|null $value Search key for aggregating the value column
	 * @param string|null $type Type of the aggregation, empty string for count or "sum" or "avg" (average)
	 * @return \Aimeos\Map List of the search keys as key and the number of counted items as value
	 */
	public function aggregate( \Aimeos\Base\Criteria\Iface $search, $key, string $value = null, string $type = null ) : \Aimeos\Map
	{
		/** mshop/customer/manager/laravel/aggregate/mysql
		 * Counts the number of records grouped by the values in the key column and matched by the given criteria
		 *
		 * @see mshop/customer/manager/laravel/aggregate/ansi
		 */

		/** mshop/customer/manager/laravel/aggregate/ansi
		 * Counts the number of records grouped by the values in the key column and matched by the given criteria
		 *
		 * Groups all records by the values in the key column and counts their
		 * occurence. The matched records can be limited by the given criteria
		 * from the customer database. The records must be from one of the sites
		 * that are configured via the context item. If the current site is part
		 * of a tree of sites, the statement can count all records from the
		 * current site and the complete sub-tree of sites.
		 *
		 * As the records can normally be limited by criteria from sub-managers,
		 * their tables must be joined in the SQL context. This is done by
		 * using the "internaldeps" property from the definition of the ID
		 * column of the sub-managers. These internal dependencies specify
		 * the JOIN between the tables and the used columns for joining. The
		 * ":joins" placeholder is then replaced by the JOIN strings from
		 * the sub-managers.
		 *
		 * To limit the records matched, conditions can be added to the given
		 * criteria object. It can contain comparisons like column names that
		 * must match specific values which can be combined by AND, OR or NOT
		 * operators. The resulting string of SQL conditions replaces the
		 * ":cond" placeholder before the statement is sent to the database
		 * server.
		 *
		 * This statement doesn't return any records. Instead, it returns pairs
		 * of the different values found in the key column together with the
		 * number of records that have been found for that key values.
		 *
		 * The SQL statement should conform to the ANSI standard to be
		 * compatible with most relational database systems. This also
		 * includes using double quotes for table and column names.
		 *
		 * @param string SQL statement for aggregating customer items
		 * @since 2021.04
		 * @category Developer
		 * @see mshop/customer/manager/laravel/insert/ansi
		 * @see mshop/customer/manager/laravel/update/ansi
		 * @see mshop/customer/manager/laravel/newid/ansi
		 * @see mshop/customer/manager/laravel/delete/ansi
		 * @see mshop/customer/manager/laravel/search/ansi
		 * @see mshop/customer/manager/laravel/count/ansi
		 */

		$cfgkey = 'mshop/customer/manager/laravel/aggregate' . $type;
		return $this->aggregateBase( $search, $key, $cfgkey, ['customer'], $value );
	}


	/**
	 * Removes old entries from the storage.
	 *
	 * @param iterable $siteids List of IDs for sites whose entries should be deleted
	 * @return \Aimeos\MShop\Common\Manager\Iface Same object for fluent interface
	 */
	public function clear( iterable $siteids ) : \Aimeos\MShop\Common\Manager\Iface
	{
		$path = 'mshop/customer/manager/submanagers';
		$default = ['address', 'lists', 'property'];

		foreach( $this->context()->config()->get( $path, $default ) as $domain ) {
			$this->object()->getSubManager( $domain )->clear( $siteids );
		}

		return $this->clearBase( $siteids, 'mshop/customer/manager/laravel/clear' );
	}


	/**
	 * Removes multiple items.
	 *
	 * @param \Aimeos\MShop\Common\Item\Iface[]|string[] $itemIds List of item objects or IDs of the items
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager object for chaining method calls
	 */
	public function delete( $itemIds ) : \Aimeos\MShop\Common\Manager\Iface
	{
		$path = 'mshop/customer/manager/laravel/delete';
		return $this->deleteItemsBase( $itemIds, $path )->deleteRefItems( $itemIds );
	}


	/**
	 * Returns the list attributes that can be used for searching.
	 *
	 * @param bool $withsub Return also attributes of sub-managers if true
	 * @return array List of attribute items implementing \Aimeos\Base\Criteria\Attribute\Iface
	 */
	public function getSearchAttributes( bool $withsub = true ) : array
	{
		$level = \Aimeos\MShop\Locale\Manager\Base::SITE_ALL;
		$level = $this->context()->config()->get( 'mshop/customer/manager/sitemode', $level );

		return array_replace( parent::getSearchAttributes( $withsub ), $this->createAttributes( [
			'customer.code' => [
				'label' => 'Username',
				'internalcode' => 'email',
			],
			'customer.label' => [
				'label' => 'Label',
				'internalcode' => 'name',
			],
			'customer.dateverified' => [
				'label' => 'Customer verification date',
				'internalcode' => 'mcus."email_verified_at"',
				'type' => 'date',
			],
			'customer.ctime' => [
				'label' => 'Customer creation time',
				'internalcode' => 'mcus."created_at"',
				'type' => 'datetime',
			],
			'customer.mtime' => [
				'label' => 'Customer modification time',
				'internalcode' => 'mcus."updated_at"',
				'type' => 'datetime',
			],
			'customer:has' => [
				'code' => 'customer:has()',
				'internalcode' => ':site AND :key AND mcusli."id"',
				'internaldeps' => ['LEFT JOIN "users_list" AS mcusli ON ( mcusli."parentid" = mcus."id" )'],
				'label' => 'Customer has list item, parameter(<domain>[,<list type>[,<reference ID>)]]',
				'type' => 'null',
				'public' => false,
				'function' => function( &$source, array $params ) use ( $level ) {
					$keys = [];

					foreach( (array) ( $params[1] ?? '' ) as $type ) {
						foreach( (array) ( $params[2] ?? '' ) as $id ) {
							$keys[] = $params[0] . '|' . ( $type ? $type . '|' : '' ) . $id;
						}
					}

					$sitestr = $this->siteString( 'mcusli."siteid"', $level );
					$keystr = $this->toExpression( 'mcusli."key"', $keys, ( $params[2] ?? null ) ? '==' : '=~' );
					$source = str_replace( [':site', ':key'], [$sitestr, $keystr], $source );

					return $params;
				}
			],
			'customer:prop' => [
				'code' => 'customer:prop()',
				'internalcode' => ':site AND :key AND mcuspr."id"',
				'internaldeps' => ['LEFT JOIN "users_property" AS mcuspr ON ( mcuspr."parentid" = mcus."id" )'],
				'label' => 'Customer has property item, parameter(<property type>[,<language code>[,<property value>]])',
				'type' => 'null',
				'public' => false,
				'function' => function( &$source, array $params ) use ( $level ) {
					$keys = [];
					$langs = array_key_exists( 1, $params ) ? ( $params[1] ?? 'null' ) : '';

					foreach( (array) $langs as $lang ) {
						foreach( (array) ( $params[2] ?? '' ) as $val ) {
							$keys[] = substr( $params[0] . '|' . ( $lang === null ? 'null|' : ( $lang ? $lang . '|' : '' ) ) . $val, 0, 255 );
						}
					}

					$sitestr = $this->siteString( 'mcuspr."siteid"', $level );
					$keystr = $this->toExpression( 'mcuspr."key"', $keys, ( $params[2] ?? null ) ? '==' : '=~' );
					$source = str_replace( [':site', ':key'], [$sitestr, $keystr], $source );

					return $params;
				}
			],
		] ) );
	}


	/**
	 * Saves a customer item object.
	 *
	 * @param \Aimeos\MShop\Customer\Item\Iface $item Customer item object
	 * @param boolean $fetch True if the new ID should be returned in the item
	 * @return \Aimeos\MShop\Customer\Item\Iface $item Updated item including the generated ID
	 */
	protected function saveItem( \Aimeos\MShop\Customer\Item\Iface $item, bool $fetch = true ) : \Aimeos\MShop\Customer\Item\Iface
	{
		$item = $this->addGroups( $item );

		if( !$item->isModified() ) {
			return $this->saveDeps( $item, $fetch );
		}

		$context = $this->context();
		$conn = $context->db( $this->getResourceName() );

		$id = $item->getId();
		$billingAddress = $item->getPaymentAddress();
		$columns = $this->object()->getSaveAttributes();

		if( $id === null )
		{
			/** mshop/customer/manager/laravel/insert
			 * Inserts a new customer record into the database table
			 *
			 * Items with no ID yet (i.e. the ID is NULL) will be created in
			 * the database and the newly created ID retrieved afterwards
			 * using the "newid" SQL statement.
			 *
			 * The SQL statement must be a string suitable for being used as
			 * prepared statement. It must include question marks for binding
			 * the values from the customer item to the statement before they are
			 * sent to the database server. The number of question marks must
			 * be the same as the number of columns listed in the INSERT
			 * statement. The order of the columns must correspond to the
			 * order in the save() method, so the correct values are
			 * bound to the columns.
			 *
			 * The SQL statement should conform to the ANSI standard to be
			 * compatible with most relational database systems. This also
			 * includes using double quotes for table and column names.
			 *
			 * @param string SQL statement for inserting records
			 * @since 2015.01
			 * @category Developer
			 * @see mshop/customer/manager/laravel/update
			 * @see mshop/customer/manager/laravel/newid
			 * @see mshop/customer/manager/laravel/delete
			 * @see mshop/customer/manager/laravel/search
			 * @see mshop/customer/manager/laravel/count
			 */
			$path = 'mshop/customer/manager/laravel/insert';
			$sql = $this->addSqlColumns( array_keys( $columns ), $this->getSqlConfig( $path ) );
		}
		else
		{
			/** mshop/customer/manager/laravel/update
			 * Updates an existing customer record in the database
			 *
			 * Items which already have an ID (i.e. the ID is not NULL) will
			 * be updated in the database.
			 *
			 * The SQL statement must be a string suitable for being used as
			 * prepared statement. It must include question marks for binding
			 * the values from the customer item to the statement before they are
			 * sent to the database server. The order of the columns must
			 * correspond to the order in the save() method, so the
			 * correct values are bound to the columns.
			 *
			 * The SQL statement should conform to the ANSI standard to be
			 * compatible with most relational database systems. This also
			 * includes using double quotes for table and column names.
			 *
			 * @param string SQL statement for updating records
			 * @since 2015.01
			 * @category Developer
			 * @see mshop/customer/manager/laravel/insert
			 * @see mshop/customer/manager/laravel/newid
			 * @see mshop/customer/manager/laravel/delete
			 * @see mshop/customer/manager/laravel/search
			 * @see mshop/customer/manager/laravel/count
			 */
			$path = 'mshop/customer/manager/laravel/update';
			$sql = $this->addSqlColumns( array_keys( $columns ), $this->getSqlConfig( $path ), false );
		}

		$idx = 1;
		$stmt = $this->getCachedStatement( $conn, $path, $sql );

		foreach( $columns as $name => $entry ) {
			$stmt->bind( $idx++, $item->get( $name ), \Aimeos\Base\Criteria\SQL::type( $entry->getType() ) );
		}

		$stmt->bind( $idx++, $item->getLabel() );
		$stmt->bind( $idx++, $item->getCode() );
		$stmt->bind( $idx++, $billingAddress->getCompany() );
		$stmt->bind( $idx++, $billingAddress->getVatID() );
		$stmt->bind( $idx++, $billingAddress->getSalutation() );
		$stmt->bind( $idx++, $billingAddress->getTitle() );
		$stmt->bind( $idx++, $billingAddress->getFirstname() );
		$stmt->bind( $idx++, $billingAddress->getLastname() );
		$stmt->bind( $idx++, $billingAddress->getAddress1() );
		$stmt->bind( $idx++, $billingAddress->getAddress2() );
		$stmt->bind( $idx++, $billingAddress->getAddress3() );
		$stmt->bind( $idx++, $billingAddress->getPostal() );
		$stmt->bind( $idx++, $billingAddress->getCity() );
		$stmt->bind( $idx++, $billingAddress->getState() );
		$stmt->bind( $idx++, $billingAddress->getCountryId() );
		$stmt->bind( $idx++, $billingAddress->getLanguageId() );
		$stmt->bind( $idx++, $billingAddress->getTelephone() );
		$stmt->bind( $idx++, $billingAddress->getTelefax() );
		$stmt->bind( $idx++, $billingAddress->getMobile() );
		$stmt->bind( $idx++, $billingAddress->getWebsite() );
		$stmt->bind( $idx++, $billingAddress->getLongitude(), \Aimeos\Base\DB\Statement\Base::PARAM_FLOAT );
		$stmt->bind( $idx++, $billingAddress->getLatitude(), \Aimeos\Base\DB\Statement\Base::PARAM_FLOAT );
		$stmt->bind( $idx++, $billingAddress->getBirthday() );
		$stmt->bind( $idx++, $item->getStatus(), \Aimeos\Base\DB\Statement\Base::PARAM_INT );
		$stmt->bind( $idx++, $item->getDateVerified() );
		$stmt->bind( $idx++, $item->getPassword() );
		$stmt->bind( $idx++, $context->datetime() ); // Modification time
		$stmt->bind( $idx++, $context->editor() );

		if( $id !== null ) {
			$stmt->bind( $idx++, $context->locale()->getSiteId() . '%' );
			$stmt->bind( $idx++, (string) $this->getUser()?->getSiteId() );
			$stmt->bind( $idx++, $id, \Aimeos\Base\DB\Statement\Base::PARAM_INT );
			$item->setId( $id );
		} else {
			$stmt->bind( $idx++, $this->siteId( $item->getSiteId(), \Aimeos\MShop\Locale\Manager\Base::SITE_SUBTREE ) );
			$stmt->bind( $idx++, $context->datetime() ); // Creation time
		}

		$stmt->execute()->finish();

		if( $id === null && $fetch === true )
		{
			/** mshop/customer/manager/laravel/newid
			 * Retrieves the ID generated by the database when inserting a new record
			 *
			 * As soon as a new record is inserted into the database table,
			 * the database server generates a new and unique identifier for
			 * that record. This ID can be used for retrieving, updating and
			 * deleting that specific record from the table again.
			 *
			 * For MySQL:
			 *  SELECT LAST_INSERT_ID()
			 * For PostgreSQL:
			 *  SELECT currval('seq_mcus_id')
			 * For SQL Server:
			 *  SELECT SCOPE_IDENTITY()
			 * For Oracle:
			 *  SELECT "seq_mcus_id".CURRVAL FROM DUAL
			 *
			 * There's no way to retrive the new ID by a SQL statements that
			 * fits for most database servers as they implement their own
			 * specific way.
			 *
			 * @param string SQL statement for retrieving the last inserted record ID
			 * @since 2015.01
			 * @category Developer
			 * @see mshop/customer/manager/laravel/insert
			 * @see mshop/customer/manager/laravel/update
			 * @see mshop/customer/manager/laravel/delete
			 * @see mshop/customer/manager/laravel/search
			 * @see mshop/customer/manager/laravel/count
			 */
			$path = 'mshop/customer/manager/laravel/newid';
			$id = $this->newId( $conn, $path );
		}

		return $this->saveDeps( $item->setId( $id ), $fetch );
	}


	/**
	 * Returns the full configuration key for the passed last part
	 *
	 * @param string $name Configuration last part
	 * @return string Full configuration key
	 */
	protected function getConfigKey( string $name, string $default = '' ) : string
	{
		if( $this->context()->config()->get( 'mshop/customer/manager/laravel/' . $name ) ) {
			return 'mshop/customer/manager/laravel/' . $name;
		}

		return parent::getConfigKey( $name, $default );
	}


	/**
	 * Returns a new manager for customer extensions
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
	 * @return mixed Manager for different extensions, e.g stock, tags, locations, etc.
	 */
	public function getSubManager( string $manager, string $name = null ) : \Aimeos\MShop\Common\Manager\Iface
	{
		return $this->getSubManagerBase( 'customer', $manager, $name ?: 'Laravel' );
	}


	/**
	 * Returns the name of the used table
	 *
	 * @return string Table name
	 */
	protected function table() : string
	{
		return 'users';
	}
}
