<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MW
 * @subpackage Session
 */


namespace Aimeos\MW\Session;


/**
 * Implementation using Laravel 5 sessions.
 *
 * @package MW
 * @subpackage Session
 */
class Laravel5
	implements \Aimeos\MW\Session\Iface
{
	private $object;


	/**
	 * Initializes the object.
	 *
	 * @param \Illuminate\Session\Store $object Laravel session object
	 */
	public function __construct( \Illuminate\Session\Store $object )
	{
		$this->object = $object;
	}


	/**
	 * Returns the value of the requested session key.
	 *
	 * If the returned value wasn't a string, it's decoded from its string representation.
	 *
	 * @param string $name Key of the requested value in the session
	 * @param mixed $default Value returned if requested key isn't found
	 * @return mixed Value associated to the requested key
	 */
	public function get( $name, $default = null )
	{
		return $this->object->get( $name, $default );
	}


	/**
	 * Sets the value for the specified key.
	 *
	 * If the value isn't a string, it's serialized and decoded again when using the get() method.
	 *
	 * @param string $name Key to the value which should be stored in the session
	 * @param mixed $value Value that should be associated with the given key
	 * @return \Aimeos\MW\Session\Iface Session instance for method chaining
	 */
	public function set( $name, $value )
	{
		$this->object->put( $name, $value );
		return $this;
	}
}
