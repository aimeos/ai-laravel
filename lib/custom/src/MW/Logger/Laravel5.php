<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MW
 * @subpackage Logger
 */


namespace Aimeos\MW\Logger;


/**
 * Log messages using the Laravel 5 logger.
 *
 * @package MW
 * @subpackage Logger
 */
class Laravel5
	extends \Aimeos\MW\Logger\Base
	implements \Aimeos\MW\Logger\Iface
{
	private $logger = null;


	/**
	 * Initializes the logger object.
	 *
	 * @param \Illuminate\Contracts\Logging\Log $logger Laravel logger object
	 */
	public function __construct( \Illuminate\Contracts\Logging\Log $logger )
	{
		$this->logger = $logger;
	}


	/**
	 * Writes a message to the configured log facility.
	 *
	 * @param string|array|object $message Message text that should be written to the log facility
	 * @param int $prio Priority of the message for filtering
	 * @param string $facility Facility for logging different types of messages (e.g. message, auth, user, changelog)
	 * @return \Aimeos\MW\Logger\Iface Logger object for method chaining
	 * @throws \Aimeos\MW\Logger\Exception If an error occurs in Zend_Log
	 * @see \Aimeos\MW\Logger\Base for available log level constants
	 */
	public function log( $message, int $priority = Base::ERR, string $facility = 'message' ) : Iface
	{
		if( !is_scalar( $message ) ) {
			$message = json_encode( $message );
		}

		try {
			$this->logger->log( $message, $this->getLogLevel( $priority ) );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), $e->getCode(), $e );
		}
	}
}
