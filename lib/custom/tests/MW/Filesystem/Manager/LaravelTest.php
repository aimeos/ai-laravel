<?php

namespace Aimeos\MW\Filesystem\Manager;


class LaravelTest extends \PHPUnit_Framework_TestCase
{
	private $config;
	private $object;
	private $storage;


	protected function setUp()
	{
		if( !class_exists( '\Illuminate\Filesystem\FilesystemManager' ) ) {
			$this->markTestSkipped( 'Install the Laravel framework first' );
		}

		$this->storage = $this->getMockBuilder( '\Illuminate\Filesystem\FilesystemManager' )
			->setMethods( array( 'get' ) )
			->disableOriginalConstructor()
			->getMock();

		$this->config = new \Aimeos\MW\Config\PHPArray( array(), array() );
		$this->object = new \Aimeos\MW\Filesystem\Manager\Laravel( $this->storage, $this->config, sys_get_temp_dir() );
	}


	protected function tearDown()
	{
		$this->config->set( 'resource/fs-media', null );
		$this->config->set( 'resource/fs', null );

		unset( $this->object, $this->storage );
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
		$this->setExpectedException( 'Aimeos\MW\Filesystem\Exception' );
		$this->object->get( 'fs-media' );
	}
}
