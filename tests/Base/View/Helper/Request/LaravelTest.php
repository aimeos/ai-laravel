<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2026
 */


namespace Aimeos\Base\View\Helper\Request;


class LaravelTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;


	protected function setUp() : void
	{
		$view = new \Aimeos\Base\View\Standard();
		$param = array( 'HTTP_HOST' => 'localhost', 'REMOTE_ADDR' => '127.0.0.1' );
		$request = new \Illuminate\Http\Request( [], [], [], [], [], $param, 'Content' );

		$this->object = new \Aimeos\Base\View\Helper\Request\Laravel( $view, $request );
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->mock );
	}


	public function testTransform()
	{
		$this->assertInstanceOf( '\Aimeos\Base\View\Helper\Request\Laravel', $this->object->transform() );
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
