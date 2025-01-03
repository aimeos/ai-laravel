<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018-2025
 * @package MShop
 * @subpackage Customer
 */


namespace Aimeos\MShop\Customer\Manager\Property;


/**
 * Laravel customer property manager implementation.
 *
 * @package MShop
 * @subpackage Customer
 */
class Laravel
	extends \Aimeos\MShop\Customer\Manager\Property\Standard
	implements \Aimeos\MShop\Customer\Manager\Property\Iface
{
	/**
	 * Returns a new manager for customer extensions
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
	 * @return mixed Manager for different extensions, e.g stock, tags, locations, etc.
	 */
	public function getSubManager( string $manager, ?string $name = null ) : \Aimeos\MShop\Common\Manager\Iface
	{
		return parent::getSubManager( $manager, $name ?: 'Laravel' );
	}


	/**
	 * Returns the name of the used table
	 *
	 * @return string Table name
	 */
	protected function table() : string
	{
		return 'users_property';
	}
}
