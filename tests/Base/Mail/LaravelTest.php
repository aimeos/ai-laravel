<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2022-2023
 */


namespace Aimeos\Base\Mail;


class LaravelTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;


	protected function setUp() : void
	{
		if( !class_exists( 'Illuminate\\Mail\\Mailer' ) ) {
			$this->markTestSkipped( 'Class Illuminate\\Mail\\Mailer not found' );
		}

		$this->mock = $this->getMockBuilder( 'Illuminate\\Mail\\Mailer' )
			->disableOriginalConstructor()
			->getMock();

		$this->object = new \Aimeos\Base\Mail\Laravel( function() { return $this->mock; } );
	}


	public function testCreate()
	{
		$result = $this->object->create( 'ISO-8859-1' );
		$this->assertInstanceOf( '\\Aimeos\\Base\\Mail\\Message\\Iface', $result );
	}


	public function testSend()
	{
		$message = $this->getMockBuilder( \Aimeos\Base\Mail\Message\Laravel::class )
			->disableOriginalConstructor()
			->getMock();

		$message->expects( $this->once() )->method( 'send' );

		$this->object->send( $message );
	}

}
