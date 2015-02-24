<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */


class MW_Cache_Laravel5Test extends MW_Unittest_Testcase
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
		if( interface_exists( '\\Illuminate\\Contracts\\Cache\\Store' ) === false ) {
			$this->markTestSkipped( 'Class \\Illuminate\\Contracts\\Cache\\Store not found' );
		}

		$this->_mock = $this->getMock( '\\Illuminate\\Contracts\\Cache\\Store' );
		$this->_object = new MW_Cache_Laravel5( $this->_mock );
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


	public function testDelete()
	{
		$this->_mock->expects( $this->once() )->method( 'forget' )->with( $this->equalTo( 'key' ) );
		$this->_object->delete( 'key' );
	}


	public function testDeleteList()
	{
		$this->_mock->expects( $this->exactly( 2 ) )->method( 'forget' )->with( $this->equalTo( 'key' ) );
		$this->_object->deleteList( array( 'key', 'key' ) );
	}


	public function testDeleteByTags()
	{
		$this->_mock->expects( $this->once() )->method( 'flush' );
		$this->_object->deleteByTags( array( 'tag', 'tag' ) );
	}


	public function testFlush()
	{
		$this->_mock->expects( $this->once() )->method( 'flush' );
		$this->_object->flush();
	}


	public function testGet()
	{
		$this->_mock->expects( $this->once() )->method( 'get' )
			->with( $this->equalTo( 'key' ) )->will( $this->returnValue( 'value' ) );

		$this->assertEquals( 'value', $this->_object->get( 'key', 'default' ) );
	}


	public function testGetDefault()
	{
		$this->_mock->expects( $this->once() )->method( 'get' )
			->with( $this->equalTo( 'key' ) )->will( $this->returnValue( null ) );

		$this->assertEquals( 'default', $this->_object->get( 'key', 'default' ) );
	}


	public function testGetList()
	{
		$this->_mock->expects( $this->exactly( 2 ) )->method( 'get' )
			->will( $this->returnValue( 'value' ) );

		$expected = array( 'key1' => 'value', 'key2' => 'value' );
		$this->assertEquals( $expected, $this->_object->getList( array( 'key1', 'key2' ) ) );
	}


	public function testGetListByTags()
	{
		$this->assertEquals( array(), $this->_object->getListByTags( array( 'key', 'key' ) ) );
	}


	public function testSet()
	{
		$this->_mock->expects( $this->once() )->method( 'put' )
			->with( $this->equalTo( 'key' ), $this->equalTo( 'value' ), $this->greaterThan( 0 ) );

		$this->_object->set( 'key', 'value', array( 'tag' ), '2100-01-01 00:00:00' );
	}


	public function testSetForever()
	{
		$this->_mock->expects( $this->once() )->method( 'forever' )
			->with( $this->equalTo( 'key' ), $this->equalTo( 'value' ) );
	
		$this->_object->set( 'key', 'value', array( 'tag' ), null );
	}


	public function testSetList()
	{
		$this->_mock->expects( $this->once() )->method( 'put' )
			->with( $this->equalTo( 'key' ), $this->equalTo( 'value' ), $this->greaterThan( 0 ) );

		$expires = array( 'key' => '2100-01-01 00:00:00' );
		$this->_object->setList( array( 'key' => 'value' ), array( 'key' => array( 'tag' ) ), $expires );
	}
}
