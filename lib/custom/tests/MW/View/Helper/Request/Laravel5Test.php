<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */


class MW_View_Helper_Request_Laravel5Test extends PHPUnit_Framework_TestCase
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
		if( !class_exists( '\Illuminate\Http\Request' ) ) {
			$this->markTestSkipped( '\Illuminate\Http\Request is not available' );
		}

		$view = new \MW_View_Default();
		$this->mock = $this->getMock( '\Illuminate\Http\Request' );
		$this->object = new MW_View_Helper_Request_Laravel5( $view, $this->mock, array() );
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
		$this->assertInstanceOf( 'MW_View_Helper_Request_Laravel5', $this->object->transform() );
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
}
