<?php

namespace Aimeos\MW\View\Helper\Request;


/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */
class Laravel5Test extends \PHPUnit_Framework_TestCase
{
	private $object;
	private $mock;


	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	protected function setUp()
	{
		if( !class_exists( '\\Illuminate\\Http\\Request' ) ) {
			$this->markTestSkipped( '\\Illuminate\\Http\\Request is not available' );
		}

		$view = new \Aimeos\MW\View\Standard();

		$this->mock = $this->getMockBuilder( '\\Illuminate\\Http\\Request' )
			->setMethods( array( 'file' ) )->getMock();

		$this->mock->expects( $this->once() )->method( 'file' )->will( $this->returnValue( array() ) );

		$this->object = new \Aimeos\MW\View\Helper\Request\Laravel5( $view, $this->mock );
	}


	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
	{
		unset( $this->object, $this->mock );
	}


	public function testTransform()
	{
		$this->assertInstanceOf( '\\Aimeos\\MW\\View\\Helper\\Request\\Laravel5', $this->object->transform() );
	}


	public function testGetBody()
	{
		$this->mock->expects( $this->once() )->method( 'getContent' )
			->will( $this->returnValue( 'body' ) );

		$this->assertEquals( 'body', $this->object->transform()->getBody() );
	}


	public function testGetClientAddress()
	{
		$this->mock->expects( $this->once() )->method( 'ip' )
			->will( $this->returnValue( '127.0.0.1' ) );

		$this->assertEquals( '127.0.0.1', $this->object->transform()->getClientAddress() );
	}


	public function testGetTarget()
	{
		$this->mock->expects( $this->once() )->method( 'route' )
			->will( $this->returnValue( null ) );

		$this->assertEquals( null, $this->object->transform()->getTarget() );
	}


	public function testGetUploadedFiles()
	{
		$this->assertEquals( array(), $this->object->transform()->getUploadedFiles() );
	}
}
