<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2020
 * @package MW
 * @subpackage Filesystem
 */


namespace Aimeos\MW\Filesystem\Manager;


/**
 * Laravel file system manager
 *
 * @package MW
 * @subpackage Filesystem
 */
class Laravel extends Standard implements Iface
{
	private $fsm;
	private $objects = [];
	private $tempdir;


	/**
	 * Initializes the object
	 *
	 * @param \Illuminate\Filesystem\FilesystemManager $fsm Laravel file system manager object
	 * @param \Aimeos\MW\Config\Iface $config Configuration object
	 * @param string $tempdir Directory for storing temporary files
	 */
	public function __construct( \Illuminate\Filesystem\FilesystemManager $fsm, \Aimeos\MW\Config\Iface $config, $tempdir )
	{
		parent::__construct( $config );

		$this->fsm = $fsm;
		$this->tempdir = $tempdir;
	}


	/**
	 * Cleans up the object
	 */
	public function __destruct()
	{
		foreach( $this->objects as $key => $object ) {
			unset( $this->objects[$key] );
		}
	}


	/**
	 * Clean up the objects inside
	 */
	public function __sleep()
	{
		$this->__destruct();

		$this->objects = [];

		return get_object_vars( $this );
	}


	/**
	 * Returns the file system for the given name
	 *
	 * @param string $name Key for the file system
	 * @return \Aimeos\MW\Filesystem\Iface File system object
	 * @throws \Aimeos\MW\Filesystem\Exception If an no configuration for that name is found
	 */
	public function get( string $name ) : \Aimeos\MW\Filesystem\Iface
	{
		$key = $this->getConfig( $name );

		if( is_string( $key ) )
		{
			if( !isset( $this->objects[$key] ) ) {
				$this->objects[$key] = new \Aimeos\MW\Filesystem\Laravel( $this->fsm->disk( $key ), $this->tempdir );
			}

			return $this->objects[$key];
		}

		return parent::get( $name );
	}
}
