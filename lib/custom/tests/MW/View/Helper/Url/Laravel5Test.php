<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */


class MW_View_Helper_Url_Laravel5Test extends MW_Unittest_Testcase
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
		if( !interface_exists( '\\Illuminate\\Contracts\\Routing\\UrlGenerator' ) ) {
			$this->markTestSkipped( '\\Illuminate\\Contracts\\Routing\\UrlGenerator is not available' );
		}

		$view = new \MW_View_Default();
		$this->mock = $this->getMock( '\\Illuminate\\Contracts\\Routing\\UrlGenerator' );
		$this->object = new MW_View_Helper_Url_Laravel5( $view, $this->mock, array() );
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
		$this->mock->expects( $this->once() )->method( 'route' )
			->with( $this->equalTo( 'route'), $this->equalTo( array( 'key' => 'value' ) ), $this->equalTo( false ) );

		$this->object->transform( 'route', 'catalog', 'list', array( 'key' => 'value' ) );
	}


	public function testTransformAbsolute()
	{
		$this->mock->expects( $this->once() )->method( 'route' )
			->with( $this->equalTo( 'route'), $this->equalTo( array() ), $this->equalTo( true ) );

		$options = array( 'absoluteUri' => true );
		$this->object->transform( 'route', 'catalog', 'list', array(), array(), $options );
	}
}
