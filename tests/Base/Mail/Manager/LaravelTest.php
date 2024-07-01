<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2024
 */


namespace Aimeos\Base\Mail\Manager;


class LaravelTest extends \PHPUnit\Framework\TestCase
{
	private $mock;
	private $stub;


	protected function setUp() : void
	{
		if( !class_exists( '\Illuminate\Mail\MailManager' ) ) {
			$this->markTestSkipped( 'Class \\Illuminate\\Mail\\MailManager not found' );
		}

		$this->mock = $this->getMockBuilder( '\Illuminate\Mail\MailManager' )
			->onlyMethods( ['get', 'getDefaultDriver'] )
			->disableOriginalConstructor()
			->getMock();

		$this->stub = $this->getMockBuilder( '\Illuminate\Mail\Mailer' )
			->disableOriginalConstructor()
			->getMock();
	}


	public function testGet()
	{
		$this->mock->expects( $this->once() )->method( 'getDefaultDriver' )->willReturn( 'smtp' );
		$this->mock->expects( $this->once() )->method( 'get' )->willReturn( $this->stub );

		$object = new \Aimeos\Base\Mail\Manager\Laravel( $this->mock );
		$this->assertInstanceOf( \Aimeos\Base\Mail\Iface::class, $object->get() );
	}
}
