<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */


class MW_Logger_Laravel4Test extends MW_Unittest_Testcase
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
		if( class_exists( '\\Illuminate\\Log\\Writer' ) === false ) {
			$this->markTestSkipped( 'Class \\Illuminate\\Log\\Writer not found' );
		}

		$this->mock = $this->getMockBuilder( '\\Illuminate\\Log\\Writer' )->disableOriginalConstructor()->getMock();
		$this->object = new MW_Logger_Laravel4( $this->mock );
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
		$this->object->log( 'msg' );
	}


	public function testNonScalarLog()
	{
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
