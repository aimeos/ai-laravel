<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2018
 */


namespace Aimeos\MW\Cache;


class Laravel5Test extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;


	protected function setUp()
	{
		if( interface_exists( '\\Illuminate\\Contracts\\Cache\\Store' ) === false ) {
			$this->markTestSkipped( 'Class \\Illuminate\\Contracts\\Cache\\Store not found' );
		}

		$this->mock = $this->getMockBuilder( '\\Illuminate\\Contracts\\Cache\\Store' )->getMock();
		$this->object = new \Aimeos\MW\Cache\Laravel5( $this->mock );
	}


	protected function tearDown()
	{
		unset( $this->mock, $this->object );
	}


	public function testDelete()
	{
		$this->mock->expects( $this->once() )->method( 'forget' )->with( $this->equalTo( 'key' ) );
		$this->object->delete( 'key' );
	}


	public function testDeleteMultiple()
	{
		$this->mock->expects( $this->exactly( 2 ) )->method( 'forget' )->with( $this->equalTo( 'key' ) );
		$this->object->deleteMultiple( array( 'key', 'key' ) );
	}


	public function testDeleteByTags()
	{
		$this->mock->expects( $this->once() )->method( 'flush' );
		$this->object->deleteByTags( array( 'tag', 'tag' ) );
	}


	public function testClear()
	{
		$this->mock->expects( $this->once() )->method( 'flush' );
		$this->object->clear();
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


	public function testGetMultiple()
	{
		$this->mock->expects( $this->exactly( 2 ) )->method( 'get' )
			->will( $this->returnValue( 'value' ) );

		$expected = array( 'key1' => 'value', 'key2' => 'value' );
		$this->assertEquals( $expected, $this->object->getMultiple( array( 'key1', 'key2' ) ) );
	}


	public function testGetMultipleByTags()
	{
		$this->assertEquals( [], $this->object->getMultipleByTags( array( 'key', 'key' ) ) );
	}


	public function testSet()
	{
		$this->mock->expects( $this->once() )->method( 'put' )
			->with( $this->equalTo( 'key' ), $this->equalTo( 'value' ), $this->greaterThan( 0 ) );

		$this->object->set( 'key', 'value', '2100-01-01 00:00:00', array( 'tag' ) );
	}


	public function testSetForever()
	{
		$this->mock->expects( $this->once() )->method( 'forever' )
			->with( $this->equalTo( 'key' ), $this->equalTo( 'value' ) );

		$this->object->set( 'key', 'value', null, array( 'tag' ) );
	}


	public function testSetMultiple()
	{
		$this->mock->expects( $this->once() )->method( 'put' )
			->with( $this->equalTo( 'key' ), $this->equalTo( 'value' ), $this->greaterThan( 0 ) );

		$expires = array( 'key' => '2100-01-01 00:00:00' );
		$this->object->setMultiple( array( 'key' => 'value' ), $expires, array( 'key' => array( 'tag' ) ) );
	}
}
