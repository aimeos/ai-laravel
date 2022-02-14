<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2022
 * @package MW
 * @subpackage Session
 */


namespace Aimeos\Base\Session;


/**
 * Implementation using Laravel 5 sessions.
 *
 * @package MW
 * @subpackage Session
 */
class Laravel extends Base implements \Aimeos\Base\Session\Iface
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
	 * Sets a list of key/value pairs.
	 *
	 * @param array $values Associative list of key/value pairs
	 * @return \Aimeos\Base\Session\Iface Session instance for method chaining
	 */
	public function apply( array $values ) : Iface
	{
		$this->object->put( $values );
		return $this;
	}


	/**
	 * Remove the given key from the session.
	 *
	 * @param string $name Key of the requested value in the session
	 * @return \Aimeos\Base\Session\Iface Session instance for method chaining
	 */
	public function del( string $name ) : Iface
	{
		$this->object->forget( $name );
		return $this;
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
	public function get( string $name, $default = null )
	{
		return $this->object->get( $name, $default );
	}


	/**
	 * Returns the value of the requested session key and remove it from the session.
	 *
	 * If the returned value wasn't a string, it's decoded from its serialized
	 * representation.
	 *
	 * @param string $name Key of the requested value in the session
	 * @param mixed $default Value returned if requested key isn't found
	 * @return mixed Value associated to the requested key
	 */
	public function pull( string $name, $default = null )
	{
		return $this->object->pull( $name, $default );
	}


	/**
	 * Remove the list of keys from the session.
	 *
	 * @param array $name Keys to remove from the session
	 * @return \Aimeos\Base\Session\Iface Session instance for method chaining
	 */
	public function remove( array $names ) : Iface
	{
		foreach( $names as $name ) {
			$this->object->forget( $name );
		}

		return $this;
	}


	/**
	 * Sets the value for the specified key.
	 *
	 * If the value isn't a string, it's serialized and decoded again when using the get() method.
	 *
	 * @param string $name Key to the value which should be stored in the session
	 * @param mixed $value Value that should be associated with the given key
	 * @return \Aimeos\Base\Session\Iface Session instance for method chaining
	 */
	public function set( string $name, $value ) : Iface
	{
		$this->object->put( $name, $value );
		return $this;
	}
}
