<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2022-2024
 * @package Base
 * @subpackage Mail
 */


namespace Aimeos\Base\Mail;


/**
 * Laravel implementation for creating and sending e-mails.
 *
 * @package Base
 * @subpackage Mail
 */
class Laravel implements \Aimeos\Base\Mail\Iface
{
	private \Closure $mailer;


	/**
	 * Initializes the instance of the class.
	 *
	 * @param \Illuminate\Mail\Mailer $closure Laravel mailer object
	 */
	public function __construct( \Closure $mailer )
	{
		$this->mailer = $mailer;
	}


	/**
	 * Creates a new e-mail message object.
	 *
	 * @param string $charset Default charset of the message
	 * @return \Aimeos\Base\Mail\Message\Iface E-mail message object
	 */
	public function create( string $charset = 'UTF-8' ) : \Aimeos\Base\Mail\Message\Iface
	{
		$mailer = $this->mailer;
		$message = new \Symfony\Component\Mime\Email();

		return new \Aimeos\Base\Mail\Message\Laravel( $mailer(), $message, $charset );
	}


	/**
	 * Sends the e-mail message to the mail server.
	 *
	 * @param \Aimeos\Base\Mail\Message\Iface $message E-mail message object
	 */
	public function send( \Aimeos\Base\Mail\Message\Iface $message ) : Iface
	{
		$message->send();
		return $this;
	}
}
