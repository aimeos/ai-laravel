<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */


class MW_Logger_Laravel5Test extends MW_Unittest_Testcase
{
	private $_object;


	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	protected function setUp()
	{
		if( interface_exists( '\\Illuminate\\Contracts\\Logging\\Log' ) === false ) {
			$this->markTestSkipped( 'Class \\Illuminate\\Contracts\\Logging\\Log not found' );
		}

		$this->_mock = $this->getMock( '\\Illuminate\\Contracts\\Logging\\Log' );
		$this->_object = new MW_Logger_Laravel5( $this->_mock );
	}


	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
	{
		unset( $this->_mock, $this->_object );
	}


	public function testLog()
	{
		$this->_mock->expects( $this->once() )->method( 'log' )
			->with( $this->equalTo( 'msg' ), $this->equalTo( 'error' ) );
		$this->_object->log( 'msg' );
	}


	public function testNonScalarLog()
	{
		$this->_mock->expects( $this->once() )->method( 'log' )
			->with( $this->equalTo( '["error","error2",2]' ), $this->equalTo( 'error' ) );
		$this->_object->log( array( 'error', 'error2', 2 ) );
	}


	public function testLogDebug()
	{
		$this->_object->log( 'emergency', MW_Logger_Abstract::EMERG );
		$this->_object->log( 'alert', MW_Logger_Abstract::ALERT );
		$this->_object->log( 'critical', MW_Logger_Abstract::CRIT );
		$this->_object->log( 'error', MW_Logger_Abstract::ERR );
		$this->_object->log( 'warning', MW_Logger_Abstract::WARN );
		$this->_object->log( 'notice', MW_Logger_Abstract::NOTICE );
		$this->_object->log( 'info', MW_Logger_Abstract::INFO );
		$this->_object->log( 'debug', MW_Logger_Abstract::DEBUG );
	}


	public function testBadPriority()
	{
		$this->setExpectedException( 'MW_Logger_Exception' );
		$this->_object->log( 'error', -1 );
	}
}
