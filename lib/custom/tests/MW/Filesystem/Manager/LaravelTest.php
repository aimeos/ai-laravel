<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 */


namespace Aimeos\MW\Filesystem\Manager;


class LaravelTest extends \PHPUnit\Framework\TestCase
{
	private $config;
	private $object;
	private $storage;


	protected function setUp() : void
	{
		if( !class_exists( '\Illuminate\Filesystem\FilesystemManager' ) ) {
			$this->markTestSkipped( 'Install the Laravel framework first' );
		}

		$this->storage = $this->getMockBuilder( \Illuminate\Filesystem\FilesystemManager::class )
			->setMethods( array( 'get' ) )
			->disableOriginalConstructor()
			->getMock();

		$this->config = new \Aimeos\MW\Config\Decorator\Memory( new \Aimeos\MW\Config\PHPArray( [], [] ) );
		$this->object = new \Aimeos\MW\Filesystem\Manager\Laravel( $this->storage, $this->config, sys_get_temp_dir() );
	}


	protected function tearDown() : void
	{
		unset( $this->config, $this->object, $this->storage );
	}


	public function testGet()
	{
		$fs = $this->getMockBuilder( 'Illuminate\Contracts\Filesystem\Filesystem' )
			->disableOriginalConstructor()
			->getMock();

		$this->storage->expects( $this->once() )->method( 'get' )
			->will( $this->returnValue( $fs ) );

		$this->config->set( 'resource/fs-media', 'local' );
		$this->assertInstanceof( 'Aimeos\MW\Filesystem\Iface', $this->object->get( 'fs-media' ) );
	}


	public function testGetFallback()
	{
		$this->config->set( 'resource/fs', array( 'adapter' => 'Standard', 'basedir' => __DIR__ ) );
		$this->assertInstanceof( 'Aimeos\MW\Filesystem\Iface', $this->object->get( 'fs-media' ) );
	}


	public function testGetException()
	{
		$this->expectException( 'Aimeos\MW\Filesystem\Exception' );
		$this->object->get( 'fs-media' );
	}
}
