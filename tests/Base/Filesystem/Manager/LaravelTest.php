<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2023
 */


namespace Aimeos\Base\Filesystem\Manager;


class LaravelTest extends \PHPUnit\Framework\TestCase
{
	private $storage;


	protected function setUp() : void
	{
		if( !class_exists( '\Illuminate\Filesystem\FilesystemManager' ) ) {
			$this->markTestSkipped( 'Install the Laravel framework first' );
		}

		$this->storage = $this->getMockBuilder( \Illuminate\Filesystem\FilesystemManager::class )
			->onlyMethods( array( 'get' ) )
			->disableOriginalConstructor()
			->getMock();
	}


	protected function tearDown() : void
	{
		unset( $this->storage );
	}


	public function testGet()
	{
		$fs = $this->getMockBuilder( 'Illuminate\Contracts\Filesystem\Filesystem' )
			->disableOriginalConstructor()
			->getMock();

		$this->storage->expects( $this->once() )->method( 'get' )
			->will( $this->returnValue( $fs ) );

		$object = new \Aimeos\Base\Filesystem\Manager\Laravel( $this->storage, ['fs-media' => 'local'], sys_get_temp_dir() );

		$this->assertInstanceof( 'Aimeos\Base\Filesystem\Iface', $object->get( 'fs-media' ) );
	}


	public function testGetFallback()
	{
		$config = ['fs' => ['adapter' => 'Standard', 'basedir' => __DIR__]];
		$object = new \Aimeos\Base\Filesystem\Manager\Laravel( $this->storage, $config, sys_get_temp_dir() );

		$this->assertInstanceof( 'Aimeos\Base\Filesystem\Iface', $object->get( 'fs-media' ) );
	}


	public function testGetException()
	{
		$object = new \Aimeos\Base\Filesystem\Manager\Laravel( $this->storage, [], sys_get_temp_dir() );

		$this->expectException( 'Aimeos\Base\Filesystem\Exception' );
		$object->get( 'fs-media' );
	}
}
