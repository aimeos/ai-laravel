<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017
 */

namespace Aimeos\MW\View\Engine;


class BladeTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;


	protected function setUp()
	{
		if( !class_exists( '\Illuminate\View\Factory' ) ) {
			$this->markTestSkipped( '\Illuminate\View\Factory is not available' );
		}

		$this->mock = $this->getMockBuilder( '\Illuminate\View\Factory' )
			->setMethods( array( 'file' ) )
			->disableOriginalConstructor()
			->getMock();

		$this->object = new \Aimeos\MW\View\Engine\Blade( $this->mock );
	}


	protected function tearDown()
	{
		unset( $this->object, $this->mock );
	}


	public function testRender()
	{
		$v = new \Aimeos\MW\View\Standard( [] );

		$view = $this->getMockBuilder( '\Illuminate\View\View' )
			->setMethods( array( 'render' ) )
			->disableOriginalConstructor()
			->getMock();

		$view->expects( $this->once() )->method( 'render' )
			->will( $this->returnValue( 'test' ) );

		$this->mock->expects( $this->once() )->method( 'file' )
			->will( $this->returnValue( $view) );

		$result = $this->object->render( $v, 'filepath', array( 'key' => 'value' ) );
		$this->assertEquals( 'test', $result );
	}
}
