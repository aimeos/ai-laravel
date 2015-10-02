<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 * @package MW
 * @subpackage Logger
 */


/**
 * Log messages using the Laravel 4 logger.
 *
 * @package MW
 * @subpackage Logger
 */
class MW_Logger_Laravel4
	extends MW_Logger_Abstract
	implements MW_Logger_Interface
{
	private $logger = null;


	/**
	 * Initializes the logger object.
	 *
	 * @param \Illuminate\\Log\Writer $logger Laravel logger object
	 */
	public function __construct( \Illuminate\Log\Writer $logger )
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

			switch( $priority )
			{
				case MW_Logger_Abstract::EMERG:
					$this->logger->emergency( $message ); break;
				case MW_Logger_Abstract::ALERT:
					$this->logger->alert( $message ); break;
				case MW_Logger_Abstract::CRIT:
					$this->logger->critical( $message ); break;
				case MW_Logger_Abstract::ERR:
					$this->logger->error( $message ); break;
				case MW_Logger_Abstract::WARN:
					$this->logger->warning( $message ); break;
				case MW_Logger_Abstract::NOTICE:
					$this->logger->notice( $message ); break;
				case MW_Logger_Abstract::INFO:
					$this->logger->info( $message ); break;
				case MW_Logger_Abstract::DEBUG:
					$this->logger->debug( $message ); break;
				default:
					throw new MW_Logger_Exception( 'Invalid log level' );
			}
		}
		catch( \Exception $e )	{
			throw new \MW_Logger_Exception( $e->getMessage(), $e->getCode(), $e );
		}
	}
}