<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2024
 */


namespace Aimeos\Base\Session;


class LaravelTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;


	protected function setUp() : void
	{
		if( class_exists( '\Illuminate\Session\Store' ) === false ) {
			$this->markTestSkipped( 'Class \Illuminate\Session\Store not found' );
		}

		$this->mock = $this->getMockBuilder( \Illuminate\Session\Store::class )
			->disableOriginalConstructor()
			->getMock();

		$this->object = new \Aimeos\Base\Session\Laravel( $this->mock );
	}


	protected function tearDown() : void
	{
		unset( $this->object );
	}


	public function testDel()
	{
		$this->mock->expects( $this->once() )->method( 'forget' )
			->with( $this->equalTo( 'test' ) )->will( $this->returnSelf() );

		$this->assertInstanceOf( \Aimeos\Base\Session\Iface::class, $this->object->del( 'test' ) );
	}


	public function testGet()
	{
		$this->mock->expects( $this->once() )->method( 'get' )
			->with( $this->equalTo( 'test' ) )->will( $this->returnValue( '123456789' ) );

		$this->assertEquals( '123456789', $this->object->get( 'test' ) );
	}


	public function testPull()
	{
		$this->mock->expects( $this->once() )->method( 'pull' )
			->with( $this->equalTo( 'test' ) )->will( $this->returnValue( '123456789' ) );

		$this->assertEquals( '123456789', $this->object->pull( 'test' ) );
	}


	public function testRemove()
	{
		$this->mock->expects( $this->once() )->method( 'forget' )
			->with( $this->equalTo( 'test' ) )->will( $this->returnSelf() );

		$this->assertInstanceOf( \Aimeos\Base\Session\Iface::class, $this->object->remove( ['test'] ) );
	}


	public function testSet()
	{
		$this->mock->expects( $this->once() )->method( 'put' )
			->with( $this->equalTo( 'test' ), $this->equalTo( '123456789' ) );

		$this->assertInstanceOf( \Aimeos\Base\Session\Iface::class, $this->object->set( 'test', '123456789' ) );
	}
}
