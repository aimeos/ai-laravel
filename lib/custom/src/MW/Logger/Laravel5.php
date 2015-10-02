<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 * @package MW
 * @subpackage Logger
 */


/**
 * Log messages using the Laravel 5 logger.
 *
 * @package MW
 * @subpackage Logger
 */
class MW_Logger_Laravel5
	extends MW_Logger_Abstract
	implements MW_Logger_Interface
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
	 * @throws MW_Logger_Exception If an error occurs in Zend_Log
	 * @see MW_Logger_Abstract for available log level constants
	 */
	public function log( $message, $priority = \MW_Logger_Abstract::ERR, $facility = 'message' )
	{
		try
		{
			if( !is_scalar( $message ) ) {
				$message = json_encode( $message );
			}

			$this->logger->log( $message, $this->translatePriority( $priority ) );
		}
		catch( \Exception $e )	{
			throw new \MW_Logger_Exception( $e->getMessage(), $e->getCode(), $e );
		}
	}


	/**
	 * Translates the log priority to the log levels of Monolog.
	 *
	 * @param integer $priority Log level from MW_Logger_Abstract
	 * @return integer Log level from Monolog\Logger
	 * @throws MW_Logger_Exception If log level is unknown
	 */
	protected function translatePriority( $priority )
	{
		switch( $priority )
		{
			case MW_Logger_Abstract::EMERG:
				return 'emergency';
			case MW_Logger_Abstract::ALERT:
				return 'alert';
			case MW_Logger_Abstract::CRIT:
				return 'critical';
			case MW_Logger_Abstract::ERR:
				return 'error';
			case MW_Logger_Abstract::WARN:
				return 'warning';
			case MW_Logger_Abstract::NOTICE:
				return 'notice';
			case MW_Logger_Abstract::INFO:
				return 'info';
			case MW_Logger_Abstract::DEBUG:
				return 'debug';
			default:
				throw new MW_Logger_Exception( 'Invalid log level' );
		}
	}
}