<?php

namespace Aimeos\MW\Filesystem;


class LaravelTest extends \PHPUnit_Framework_TestCase
{
	private $mock;
	private $object;


	protected function setUp()
	{
		if( !interface_exists( '\\Illuminate\\Contracts\\Filesystem\\Filesystem' ) ) {
			$this->markTestSkipped( 'Install Laravel framework first' );
		}

		$this->mock = $this->getMockBuilder( '\\Illuminate\\Contracts\\Filesystem\\Filesystem' )
			->disableOriginalConstructor()
			->getMock();

		$this->object = new \Aimeos\MW\Filesystem\Laravel( $this->mock, sys_get_temp_dir() );
	}


	protected function tearDown()
	{
		unset( $this->object );
	}


	public function testIsdir()
	{
		$this->mock->expects( $this->once() )->method( 'directories' )
			->will( $this->returnValue( array( 't', 'test', 'es' ) ) );

		$this->assertTrue( $this->object->isdir( 'test' ) );
	}


	public function testIsdirFalse()
	{
		$this->mock->expects( $this->once() )->method( 'directories' )
			->will( $this->returnValue( array( 't', 'es' ) ) );

		$this->assertFalse( $this->object->isdir( 'test' ) );
	}


	public function testMkdir()
	{
		$this->mock->expects( $this->once() )->method( 'makeDirectory' );

		$this->object->mkdir( 'test' );
	}


	public function testRmdir()
	{
		$this->mock->expects( $this->once() )->method( 'deleteDirectory' );

		$this->object->rmdir( 'test' );
	}


	public function testScan()
	{
		$list = array( 't', 'es', 'st' );

		$this->mock->expects( $this->once() )->method( 'directories' )
			->will( $this->returnValue( array( 't', 'es' ) ) );

		$this->mock->expects( $this->once() )->method( 'files' )
			->will( $this->returnValue( array( 'st' ) ) );

		$result = $this->object->scan();

		$this->assertInternalType( 'array', $result );

		foreach( $result as $entry ) {
			$this->assertTrue( in_array( $entry, $list ) );
		}
	}


	public function testSize()
	{
		$this->mock->expects( $this->once() )->method( 'size' )
			->will( $this->returnValue( 4 ) );

		$result = $this->object->size( 'test' );

		$this->assertEquals( 4, $result );
	}


	public function testTime()
	{
		$this->mock->expects( $this->once() )->method( 'lastModified' )
			->will( $this->returnValue( 1 ) );

		$result = $this->object->time( 'test' );

		$this->assertGreaterThan( 0, $result );
	}


	public function testRm()
	{
		$this->mock->expects( $this->once() )->method( 'delete' );

		$this->object->rm( 'test' );
	}


	public function testHas()
	{
		$this->mock->expects( $this->once() )->method( 'exists' )
			->will( $this->returnValue( true ) );

		$result = $this->object->has( 'test' );

		$this->assertTrue( $result );
	}


	public function testHasFalse()
	{
		$this->mock->expects( $this->once() )->method( 'exists' )
			->will( $this->returnValue( false ) );

		$result = $this->object->has( 'test' );

		$this->assertFalse( $result );
	}


	public function testRead()
	{
		$this->mock->expects( $this->once() )->method( 'get' )
			->will( $this->returnValue( 'test' ) );

		$result = $this->object->read( 'file' );

		$this->assertEquals( 'test', $result );
	}


	public function testReadException()
	{
		$this->mock->expects( $this->once() )->method( 'get' )
			->will( $this->throwException( new \Exception() ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->read( 'readinvalid' );
	}


	public function testReadf()
	{
		$this->mock->expects( $this->once() )->method( 'get' )
			->will( $this->returnValue( 'test' ) );

		$result = $this->object->readf( 'file' );

		$this->assertEquals( 'test', file_get_contents( $result ) );
		unlink( $result );
	}


	public function testReads()
	{
		$this->mock->expects( $this->once() )->method( 'get' )
			->will( $this->returnValue( 'test' ) );

		$handle = $this->object->reads( 'file' );

		$this->assertInternalType( 'resource', $handle );
		$this->assertEquals( 'test', fgets( $handle ) );

		fclose( $handle );
	}


	public function testReadsException()
	{
		$this->mock->expects( $this->once() )->method( 'get' )
			->will( $this->throwException( new \Exception() ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->reads( 'readinvalid' );
	}


	public function testWrite()
	{
		$this->mock->expects( $this->once() )->method( 'put' );

		$this->object->write( 'file', 'test' );
	}


	public function testWriteException()
	{
		$this->mock->expects( $this->once() )->method( 'put' )
			->will( $this->throwException( new \Exception() ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->write( '', 'test' );
	}


	public function testWritef()
	{
		$file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'file99';
		file_put_contents( $file, 'test' );

		$this->mock->expects( $this->once() )->method( 'put' );

		$this->object->writef( 'file', $file );

		unlink( $file );
	}


	public function testWritefException()
	{
		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->writef( '', 'invalid' );
	}


	public function testWrites()
	{
		$this->mock->expects( $this->once() )->method( 'put' );

		$handle = fopen( __FILE__, 'r' );

		$this->object->writes( 'file', $handle );

		fclose( $handle );
	}


	public function testWritesException()
	{
		$this->mock->expects( $this->once() )->method( 'put' )
			->will( $this->throwException( new \Exception() ) );

		$handle = fopen( __FILE__, 'r' );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->writes( 'file', $handle );
	}


	public function testWritesException2()
	{
		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->writes( 'file', null );
	}


	public function testMove()
	{
		$this->mock->expects( $this->once() )->method( 'move' );

		$this->object->move( 'file1', 'file2' );
	}


	public function testCopy()
	{
		$this->mock->expects( $this->once() )->method( 'copy' );

		$this->object->copy( 'file1', 'file2' );
	}
}
