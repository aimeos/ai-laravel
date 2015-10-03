<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */


class MW_Cache_Laravel5Test extends PHPUnit_Framework_TestCase
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
		if( interface_exists( '\\Illuminate\\Contracts\\Cache\\Store' ) === false ) {
			$this->markTestSkipped( 'Class \\Illuminate\\Contracts\\Cache\\Store not found' );
		}

		$this->mock = $this->getMock( '\\Illuminate\\Contracts\\Cache\\Store' );
		$this->object = new MW_Cache_Laravel5( $this->mock );
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


	public function testDelete()
	{
		$this->mock->expects( $this->once() )->method( 'forget' )->with( $this->equalTo( 'key' ) );
		$this->object->delete( 'key' );
	}


	public function testDeleteList()
	{
		$this->mock->expects( $this->exactly( 2 ) )->method( 'forget' )->with( $this->equalTo( 'key' ) );
		$this->object->deleteList( array( 'key', 'key' ) );
	}


	public function testDeleteByTags()
	{
		$this->mock->expects( $this->once() )->method( 'flush' );
		$this->object->deleteByTags( array( 'tag', 'tag' ) );
	}


	public function testFlush()
	{
		$this->mock->expects( $this->once() )->method( 'flush' );
		$this->object->flush();
	}


	public function testGet()
	{
		$this->mock->expects( $this->once() )->method( 'get' )
			->with( $this->equalTo( 'key' ) )->will( $this->returnValue( 'value' ) );

		$this->assertEquals( 'value', $this->object->get( 'key', 'default' ) );
	}


	public function testGetDefault()
	{
		$this->mock->expects( $this->once() )->method( 'get' )
			->with( $this->equalTo( 'key' ) )->will( $this->returnValue( null ) );

		$this->assertEquals( 'default', $this->object->get( 'key', 'default' ) );
	}


	public function testGetList()
	{
		$this->mock->expects( $this->exactly( 2 ) )->method( 'get' )
			->will( $this->returnValue( 'value' ) );

		$expected = array( 'key1' => 'value', 'key2' => 'value' );
		$this->assertEquals( $expected, $this->object->getList( array( 'key1', 'key2' ) ) );
	}


	public function testGetListByTags()
	{
		$this->assertEquals( array(), $this->object->getListByTags( array( 'key', 'key' ) ) );
	}


	public function testSet()
	{
		$this->mock->expects( $this->once() )->method( 'put' )
			->with( $this->equalTo( 'key' ), $this->equalTo( 'value' ), $this->greaterThan( 0 ) );

		$this->object->set( 'key', 'value', array( 'tag' ), '2100-01-01 00:00:00' );
	}


	public function testSetForever()
	{
		$this->mock->expects( $this->once() )->method( 'forever' )
			->with( $this->equalTo( 'key' ), $this->equalTo( 'value' ) );
	
		$this->object->set( 'key', 'value', array( 'tag' ), null );
	}


	public function testSetList()
	{
		$this->mock->expects( $this->once() )->method( 'put' )
			->with( $this->equalTo( 'key' ), $this->equalTo( 'value' ), $this->greaterThan( 0 ) );

		$expires = array( 'key' => '2100-01-01 00:00:00' );
		$this->object->setList( array( 'key' => 'value' ), array( 'key' => array( 'tag' ) ), $expires );
	}
}
