<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */


class MW_Session_Laravel4Test extends MW_Unittest_Testcase
{
	private $_object;
	private $_mock;


	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	protected function setUp()
	{
		if( class_exists( '\\Illuminate\\Session\\Store' ) === false ) {
			$this->markTestSkipped( 'Class \\Illuminate\\Session\\Store not found' );
		}

		$this->_mock = $this->getMockBuilder( '\\Illuminate\\Session\\Store' )->disableOriginalConstructor()->getMock();
		$this->_object = new MW_Session_Laravel4( $this->_mock );
	}


	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
	{
		unset( $this->_object );
	}


	public function testGetDefault()
	{
		$this->_mock->expects( $this->once() )->method( 'get' )->with( $this->equalTo( 'notexist' ) );
		$this->_object->get( 'notexist' );
	}


	public function testSet()
	{
		$this->_mock->expects( $this->once() )->method( 'put' )
			->with( $this->equalTo( 'key' ), $this->equalTo( 'value' ) );
		$this->_object->set( 'key', 'value' );
	}
}
