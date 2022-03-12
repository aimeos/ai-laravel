<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2022
 */


namespace Aimeos\Base\View\Helper\Response;


class Laravel5Test extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;


	protected function setUp() : void
	{
		$view = new \Aimeos\Base\View\Standard();
		$this->object = new \Aimeos\Base\View\Helper\Response\Laravel5( $view );
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->mock );
	}


	public function testTransform()
	{
		$this->assertInstanceOf( '\Aimeos\Base\View\Helper\Response\Laravel5', $this->object->transform() );
	}
}
