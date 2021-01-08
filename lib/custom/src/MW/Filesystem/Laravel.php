<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 * @package MW
 * @subpackage Filesystem
 */


namespace Aimeos\MW\Filesystem;


/**
 * Implementation of Laravel file system adapter
 *
 * @package MW
 * @subpackage Filesystem
 */
class Laravel implements Iface, DirIface, MetaIface
{
	private $fs;
	private $tempdir;


	/**
	 * Initializes the object
	 *
	 * @param \Illuminate\Contracts\Filesystem\Filesystem $fs Laravel file system object
	 * @param string $tempdir Directory for storing temporary files
	 */
	public function __construct( \Illuminate\Contracts\Filesystem\Filesystem $fs, $tempdir )
	{
		$this->fs = $fs;
		$this->tempdir = $tempdir;
	}


	/**
	 * Tests if the given path is a directory
	 *
	 * @param string $path Path to the file or directory
	 * @return bool True if directory, false if not
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function isdir( string $path ) : bool
	{
		return in_array( basename( $path ), $this->fs->directories( dirname( $path ) ) );
	}


	/**
	 * Creates a new directory for the given path
	 *
	 * @param string $path Path to the directory
	 * @return \Aimeos\MW\Filesystem\DirIface Filesystem object for fluent interface
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function mkdir( string $path ) : DirIface
	{
		try {
			$this->fs->makeDirectory( $path );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		return $this;
	}


	/**
	 * Deletes the directory for the given path
	 *
	 * @param string $path Path to the directory
	 * @return \Aimeos\MW\Filesystem\DirIface Filesystem object for fluent interface
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function rmdir( string $path ) : DirIface
	{
		try {
			$this->fs->deleteDirectory( $path );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		return $this;
	}


	/**
	 * Returns an iterator over the entries in the given path
	 *
	 * {@inheritDoc}
	 *
	 * @param string $path Path to the filesystem or directory
	 * @return iterable Iterator over the entries or array with entries
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function scan( string $path = null ) : iterable
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
	public function size( string $path ) : int
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
	public function time( string $path ) : int
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
	 * @return \Aimeos\MW\Filesystem\Iface Filesystem object for fluent interface
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function rm( string $path ) : Iface
	{
		try {
			$this->fs->delete( $path );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		return $this;
	}


	/**
	 * Tests if a file exists at the given path
	 *
	 * @param string $path Path to the file
	 * @return bool True if it exists, false if not
	 */
	public function has( string $path ) : bool
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
	public function read( string $path ) : string
	{
		try {
			return $this->fs->get( $path );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}
	}


	/**
	 * Reads the content of the remote file and writes it to a local one
	 *
	 * @param string $path Path to the remote file
	 * @return string Path of the local file
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function readf( string $path ) : string
	{
		if( ( $filename = tempnam( $this->tempdir, 'ai-' ) ) === false ) {
			throw new Exception( sprintf( 'Unable to create file in "%1$s"', $this->tempdir ) );
		}

		if( @file_put_contents( $filename, $this->fs->get( $path ) ) === false ) {
			throw new Exception( sprintf( 'Couldn\'t write file "%1$s"', $filename ) );
		}

		return $filename;
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
	public function reads( string $path )
	{
		try {
			$content = $this->fs->get( $path );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		if( ( $stream = tmpfile() ) === false ) {
			throw new Exception( 'Couldn\'t create temporary file' );
		}

		if( fwrite( $stream, $content ) === false ) {
			throw new Exception( 'Couldn\'t write to temporary file' );
		}

		if( rewind( $stream ) === false ) {
			throw new Exception( 'Couldn\'t rewind temporary file' );
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
	 * @return \Aimeos\MW\Filesystem\Iface Filesystem object for fluent interface
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function write( string $path, string $content ) : Iface
	{
		try {
			$this->fs->put( $path, $content );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		return $this;
	}


	/**
	 * Writes the content of the local file to the remote path
	 *
	 * {@inheritDoc}
	 *
	 * @param string $path Path to the remote file
	 * @param string $local Path to the local file
	 * @return \Aimeos\MW\Filesystem\Iface Filesystem object for fluent interface
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function writef( string $path, string $local ) : Iface
	{
		if( ( $content = @file_get_contents( $local ) ) === false ) {
			throw new Exception( sprintf( 'Couldn\'t read file "%1$s"', $local ) );
		}

		return $this->write( $path, $content );
	}


	/**
	 * Write the content of the stream descriptor into the remote file
	 *
	 * {@inheritDoc}
	 *
	 * @param string $path Path to the file
	 * @param resource $stream File stream descriptor
	 * @return \Aimeos\MW\Filesystem\Iface Filesystem object for fluent interface
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function writes( string $path, $stream ) : Iface
	{
		if( ( $content = @fread( $stream, 0x7ffffffd ) ) === false ) {
			$error = error_get_last();
			throw new Exception( $error['message'] );
		}

		try {
			$this->fs->put( $path, $content );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		return $this;
	}


	/**
	 * Renames a file, moves it to a new location or both at once
	 *
	 * @param string $from Path to the original file
	 * @param string $to Path to the new file
	 * @return \Aimeos\MW\Filesystem\Iface Filesystem object for fluent interface
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function move( string $from, string $to ) : Iface
	{
		try {
			$this->fs->move( $from, $to );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		return $this;
	}


	/**
	 * Copies a file to a new location
	 *
	 * @param string $from Path to the original file
	 * @param string $to Path to the new file
	 * @return \Aimeos\MW\Filesystem\Iface Filesystem object for fluent interface
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function copy( string $from, string $to ) : Iface
	{
		try {
			$this->fs->copy( $from, $to );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		return $this;
	}
}
