<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2024
 * @package Base
 * @subpackage Mail
 */


namespace Aimeos\Base\Mail\Manager;


/**
 * Laravel mail manager
 *
 * @package Base
 * @subpackage Mail
 */
class Standard implements Iface
{
	private ?\Illuminate\Mail\MailManager $manager;


	/**
	 * Initializes the object
	 *
	 * @param \Illuminate\Mail\MailManager $manager Mail manager object
	 */
	public function __construct( \Illuminate\Mail\MailManager $manager )
	{
		$this->manager = $manager;
	}


	/**
	 * Returns the mailer for the given name
	 *
	 * @param string $name Key for the mailer
	 * @return \Aimeos\Base\Mail\Iface Mail object
	 * @throws \Aimeos\Base\Mail\Exception If an error occurs
	 */
	public function get( string $name ) : \Aimeos\Base\Mail\Iface
	{
		return new \Aimeos\Base\Mail\Laravel( $this->manager->mailer( $name ) );
	}
}
