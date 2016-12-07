<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2016
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
	 * @param string $message Message text that should be written to the log facility
	 * @param integer $priority Priority of the message for filtering
	 * @param string $facility Facility for logging different types of messages (e.g. message, auth, user, changelog)
	 * @throws \Aimeos\MW\Logger\Exception If an error occurs in Zend_Log
	 * @see \Aimeos\MW\Logger\Base for available log level constants
	 */
	public function log( $message, $priority = \Aimeos\MW\Logger\Base::ERR, $facility = 'message' )
	{
		try
		{
			if( !is_scalar( $message ) ) {
				$message = json_encode( $message );
			}

			$this->logger->log( $message, $this->translatePriority( $priority ) );
		}
		catch( \Exception $e )	{
			throw new \Aimeos\MW\Logger\Exception( $e->getMessage(), $e->getCode(), $e );
		}
	}


	/**
	 * Translates the log priority to the log levels of Monolog.
	 *
	 * @param integer $priority Log level from \Aimeos\MW\Logger\Base
	 * @return integer Log level from Monolog\Logger
	 * @throws \Aimeos\MW\Logger\Exception If log level is unknown
	 */
	protected function translatePriority( $priority )
	{
		switch( $priority )
		{
			case \Aimeos\MW\Logger\Base::EMERG:
				return 'emergency';
			case \Aimeos\MW\Logger\Base::ALERT:
				return 'alert';
			case \Aimeos\MW\Logger\Base::CRIT:
				return 'critical';
			case \Aimeos\MW\Logger\Base::ERR:
				return 'error';
			case \Aimeos\MW\Logger\Base::WARN:
				return 'warning';
			case \Aimeos\MW\Logger\Base::NOTICE:
				return 'notice';
			case \Aimeos\MW\Logger\Base::INFO:
				return 'info';
			case \Aimeos\MW\Logger\Base::DEBUG:
				return 'debug';
			default:
				throw new \Aimeos\MW\Logger\Exception( 'Invalid log level' );
		}
	}
}