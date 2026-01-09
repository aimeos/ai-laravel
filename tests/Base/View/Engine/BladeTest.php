<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2026
 */

namespace Aimeos\Base\View\Engine;


class BladeTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;


	protected function setUp() : void
	{
		if( !class_exists( '\Illuminate\View\Factory' ) ) {
			$this->markTestSkipped( '\Illuminate\View\Factory is not available' );
		}

		$this->mock = $this->getMockBuilder( \Illuminate\View\Factory::class )
			->onlyMethods( array( 'file' ) )
			->disableOriginalConstructor()
			->getMock();

		$this->object = new \Aimeos\Base\View\Engine\Blade( $this->mock );
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->mock );
	}


	public function testRender()
	{
		$v = new \Aimeos\Base\View\Standard( [] );

		$view = $this->getMockBuilder( \Illuminate\View\View::class )
			->onlyMethods( array( 'render' ) )
			->disableOriginalConstructor()
			->getMock();

		$view->expects( $this->once() )->method( 'render' )
			->willReturn( 'test' );

		$this->mock->expects( $this->once() )->method( 'file' )
			->willReturn( $view );

		$result = $this->object->render( $v, 'filepath', array( 'key' => 'value' ) );
		$this->assertEquals( 'test', $result );
	}
}
