<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 * @package MW
 * @subpackage Filesystem
 */


namespace Aimeos\MW\Filesystem;


/**
 * Implementation of basic file system methods
 *
 * @package MW
 * @subpackage Filesystem
 */
class Laravel implements BasicIface, DirIface, MetaIface
{
	private $fs;


	/**
	 * Initializes the object
	 *
	 * @param string $basepath Root path to the file system
	 */
	public function __construct( \Illuminate\Contracts\Filesystem\Filesystem $fs )
	{
		$this->fs = $fs;
	}


	/**
	 * Tests if the given path is a directory
	 *
	 * @param string $path Path to the file or directory
	 * @return boolean True if directory, false if not
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function isdir( $path )
	{
		return in_array( basename( $path ), $this->fs->directories( dirname( $path ) ) );
	}


	/**
	 * Creates a new directory for the given path
	 *
	 * @param string $path Path to the directory
	 * @return void
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	*/
	public function mkdir( $path )
	{
		try {
			$this->fs->makeDirectory( $path );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}
	}


	/**
	 * Deletes the directory for the given path
	 *
	 * @param string $path Path to the directory
	 * @return void
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	*/
	public function rmdir( $path )
	{
		try {
			$this->fs->deleteDirectory( $path );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}
	}


	/**
	 * Returns an iterator over the entries in the given path
	 *
	 * {@inheritDoc}
	 *
	 * @param string $path Path to the filesystem or directory
	 * @return \Iterator|array Iterator over the entries or array with entries
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function scan( $path = null )
	{
		try {
			return array_merge( $this->fs->directories( $path ), $this->fs->files( $path ) );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}
	}


	/**
	 * Returns the file size
	 *
	 * @param string $path Path to the file
	 * @return integer Size in bytes
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function size( $path )
	{
		try {
			return $this->fs->size( $path );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}
	}


	/**
	 * Returns the Unix time stamp for the file
	 *
	 * @param string $path Path to the file
	 * @return integer Unix time stamp in seconds
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function time( $path )
	{
		try {
			return $this->fs->lastModified( $path );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}
	}


	/**
	 * Deletes the file for the given path
	 *
	 * @param string $path Path to the file
	 * @return void
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function rm( $path )
	{
		try {
			$this->fs->delete( $path );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}
	}


	/**
	 * Tests if a file exists at the given path
	 *
	 * @param string $path Path to the file
	 * @return boolean True if it exists, false if not
	 */
	public function has( $path )
	{
		return $this->fs->exists( $path );
	}


	/**
	 * Returns the content of the file
	 *
	 * {@inheritDoc}
	 *
	 * @param string $path Path to the file
	 * @return string File content
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function read( $path )
	{
		try {
			return $this->fs->get( $path );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}
	}


	/**
	 * Returns the stream descriptor for the file
	 *
	 * {@inheritDoc}
	 *
	 * @param string $path Path to the file
	 * @return resource File stream descriptor
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function reads( $path )
	{
		try {
			$content = $this->fs->get( $path );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		if( ( $stream = tmpfile() ) === false ) {
			$error = error_get_last();
			throw new Exception( $error['message'] );
		}

		if( fwrite( $stream, $content ) === false ) {
			$error = error_get_last();
			throw new Exception( $error['message'] );
		}

		if( rewind( $stream ) === false ) {
			$error = error_get_last();
			throw new Exception( $error['message'] );
		}

		return $stream;
	}


	/**
	 * Writes the given content to the file
	 *
	 * {@inheritDoc}
	 *
	 * @param string $path Path to the file
	 * @param string $content New file content
	 * @return void
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function write( $path, $content )
	{
		try {
			$this->fs->put( $path, $content );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}
	}


	/**
	 * Write the content of the stream descriptor into the remote file
	 *
	 * {@inheritDoc}
	 *
	 * @param string $path Path to the file
	 * @param resource $stream File stream descriptor
	 * @return void
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function writes( $path, $stream )
	{
		if( ( $content = @fread( $stream, 0x7fffffff ) ) === false ) {
			$error = error_get_last();
			throw new Exception( $error['message'] );
		}

		try {
			$content = $this->fs->put( $path, $content );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}
	}


	/**
	 * Renames a file, moves it to a new location or both at once
	 *
	 * @param string $from Path to the original file
	 * @param string $to Path to the new file
	 * @return void
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function move( $from, $to )
	{
		try {
			$this->fs->move( $from, $to );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}
	}


	/**
	 * Copies a file to a new location
	 *
	 * @param string $from Path to the original file
	 * @param string $to Path to the new file
	 * @return void
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function copy( $from, $to )
	{
		try {
			$this->fs->copy( $from, $to );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}
	}
}
