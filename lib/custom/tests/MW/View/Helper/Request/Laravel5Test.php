<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2016
 */


namespace Aimeos\MW\View\Helper\Request;


class Laravel5Test extends \PHPUnit_Framework_TestCase
{
	private $object;
	private $mock;


	protected function setUp()
	{
		if( !class_exists( '\Illuminate\Http\Request' ) ) {
			$this->markTestSkipped( '\Illuminate\Http\Request is not available' );
		}

		if( !class_exists( '\Zend\Diactoros\Response' ) ) {
			$this->markTestSkipped( '\Zend\Diactoros\Response is not available' );
		}

		$view = new \Aimeos\MW\View\Standard();
		$param = array( 'HTTP_HOST' => 'localhost', 'REMOTE_ADDR' => '127.0.0.1' );
		$request = new \Illuminate\Http\Request( array(), array(), array(), array(), array(), $param, 'Content' );

		$this->object = new \Aimeos\MW\View\Helper\Request\Laravel5( $view, $request );
	}


	protected function tearDown()
	{
		unset( $this->object, $this->mock );
	}


	public function testTransform()
	{
		$this->assertInstanceOf( '\Aimeos\MW\View\Helper\Request\Laravel5', $this->object->transform() );
	}


	public function testGetClientAddress()
	{
		$this->assertEquals( '127.0.0.1', $this->object->getClientAddress() );
	}


	public function testGetTarget()
	{
		$this->assertEquals( null, $this->object->getTarget() );
	}
}
