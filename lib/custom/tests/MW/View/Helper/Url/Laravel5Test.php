<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2017
 */


namespace Aimeos\MW\View\Helper\Url;


class Laravel5Test extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;


	protected function setUp()
	{
		if( !interface_exists( '\\Illuminate\\Contracts\\Routing\\UrlGenerator' ) ) {
			$this->markTestSkipped( '\\Illuminate\\Contracts\\Routing\\UrlGenerator is not available' );
		}

		$view = new \Aimeos\MW\View\Standard();
		$this->mock = $this->getMockBuilder( '\\Illuminate\\Contracts\\Routing\\UrlGenerator' )->getMock();
		$this->object = new \Aimeos\MW\View\Helper\Url\Laravel5( $view, $this->mock, [] );
	}


	protected function tearDown()
	{
		unset( $this->object, $this->mock );
	}


	public function testTransform()
	{
		$this->mock->expects( $this->once() )->method( 'route' )
			->with( $this->equalTo( 'route'), $this->equalTo( array( 'key' => 'value' ) ), $this->equalTo( false ) );

		$this->object->transform( 'route', 'catalog', 'lists', array( 'key' => 'value' ) );
	}


	public function testTransformAbsolute()
	{
		$this->mock->expects( $this->once() )->method( 'route' )
			->with( $this->equalTo( 'route'), $this->equalTo( [] ), $this->equalTo( true ) );

		$options = array( 'absoluteUri' => true );
		$this->object->transform( 'route', 'catalog', 'lists', [], [], $options );
	}
}
