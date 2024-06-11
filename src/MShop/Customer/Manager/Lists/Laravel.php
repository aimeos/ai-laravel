<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2024
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
	 * Returns the name of the used table
	 *
	 * @return string Table name
	 */
	protected function getTable() : string
	{
		return 'users_list';
	}
}
