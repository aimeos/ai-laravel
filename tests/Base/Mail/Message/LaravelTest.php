<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2022
 */


namespace Aimeos\Base\Mail\Message;


class LaravelTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;
	private $stub;


	protected function setUp() : void
	{
		if( !class_exists( 'Illuminate\Mail\Mailer' ) ) {
			$this->markTestSkipped( 'Class Illuminate\\Mail\\Mailer not found' );
		}

		$this->mock = $this->getMockBuilder( \Illuminate\Mail\Mailer::class )
			->disableOriginalConstructor()
			->getMock();

		$this->stub = $this->getMockBuilder( \Symfony\Component\Mime\Email::class )
			->getMock();

		$this->object = new \Aimeos\Base\Mail\Message\Laravel( $this->mock, $this->stub, 'UTF-8' );
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->mock, $this->stub );
	}


	public function testFrom()
	{
		$this->stub->expects( $this->once() )->method( 'from' );

		$result = $this->object->from( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testTo()
	{
		$this->stub->expects( $this->once() )->method( 'to' );

		$result = $this->object->to( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testCc()
	{
		$this->stub->expects( $this->once() )->method( 'cc' );

		$result = $this->object->cc( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testBcc()
	{
		$this->stub->expects( $this->once() )->method( 'bcc' );

		$result = $this->object->bcc( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testReplyTo()
	{
		$this->stub->expects( $this->once() )->method( 'replyTo' );

		$result = $this->object->replyTo( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testSend()
	{
		$transport = $this->getMockBuilder( '\Symfony\Component\Mailer\Transport\TransportInterface' )
			->disableOriginalConstructor()
			->getMock();

		$transport->expects( $this->once() )->method( 'send' );

		$this->mock->expects( $this->once() )->method( 'getSymfonyTransport' )
			->will( $this->returnValue( $transport ) );

		$this->assertSame( $this->object, $this->object->send() );
	}


	public function testSender()
	{
		$this->stub->expects( $this->once() )->method( 'sender' );

		$result = $this->object->sender( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testSubject()
	{
		$this->stub->expects( $this->once() )->method( 'subject' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->object->subject( 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testText()
	{
		$this->stub->expects( $this->once() )->method( 'text' )
			->with( $this->stringContains( 'test' ) );

		$this->assertSame( $this->object, $this->object->text( 'test' ) );
	}


	public function testHtml()
	{
		$this->stub->expects( $this->once() )->method( 'html' )
			->with( $this->stringContains( 'test' ) );

		$this->assertSame( $this->object, $this->object->html( 'test' ) );
	}


	public function testAttach()
	{
		$this->stub->expects( $this->once() )->method( 'attach' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->object->attach( 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testEmbed()
	{
		$this->stub->expects( $this->once() )->method( 'embed' )
			->with( $this->stringContains( 'test' ) );

		$this->assertIsString( $this->object->embed( 'test' ) );
	}
}
