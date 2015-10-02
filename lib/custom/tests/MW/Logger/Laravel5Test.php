<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */


class MW_Logger_Laravel5Test extends MW_Unittest_Testcase
{
	private $object;


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

		$this->mock = $this->getMock( '\\Illuminate\\Contracts\\Logging\\Log' );
		$this->object = new MW_Logger_Laravel5( $this->mock );
	}


	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
	{
		unset( $this->mock, $this->object );
	}


	public function testLog()
	{
		$this->mock->expects( $this->once() )->method( 'log' )
			->with( $this->equalTo( 'msg' ), $this->equalTo( 'error' ) );
		$this->object->log( 'msg' );
	}


	public function testNonScalarLog()
	{
		$this->mock->expects( $this->once() )->method( 'log' )
			->with( $this->equalTo( '["error","error2",2]' ), $this->equalTo( 'error' ) );
		$this->object->log( array( 'error', 'error2', 2 ) );
	}


	public function testLogDebug()
	{
		$this->object->log( 'emergency', MW_Logger_Abstract::EMERG );
		$this->object->log( 'alert', MW_Logger_Abstract::ALERT );
		$this->object->log( 'critical', MW_Logger_Abstract::CRIT );
		$this->object->log( 'error', MW_Logger_Abstract::ERR );
		$this->object->log( 'warning', MW_Logger_Abstract::WARN );
		$this->object->log( 'notice', MW_Logger_Abstract::NOTICE );
		$this->object->log( 'info', MW_Logger_Abstract::INFO );
		$this->object->log( 'debug', MW_Logger_Abstract::DEBUG );
	}


	public function testBadPriority()
	{
		$this->setExpectedException( 'MW_Logger_Exception' );
		$this->object->log( 'error', -1 );
	}
}
