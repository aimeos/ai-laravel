<?php

namespace Aimeos\MW\Session;


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
		if( interface_exists( '\\Illuminate\\Session\\SessionInterface' ) === false ) {
			$this->markTestSkipped( 'Class \\Illuminate\\Session\\SessionInterface not found' );
		}

		$this->mock = $this->getMock( '\\Illuminate\\Session\\SessionInterface' );
		$this->object = new \Aimeos\MW\Session\Laravel5( $this->mock );
	}


	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
	{
		unset( $this->object );
	}


	public function testGetDefault()
	{
		$this->mock->expects( $this->once() )->method( 'get' )->with( $this->equalTo( 'notexist' ) );
		$this->object->get( 'notexist' );
	}


	public function testSet()
	{
		$this->mock->expects( $this->once() )->method( 'set' )
			->with( $this->equalTo( 'key' ), $this->equalTo( 'value' ) );
		$this->object->set( 'key', 'value' );
	}
}
