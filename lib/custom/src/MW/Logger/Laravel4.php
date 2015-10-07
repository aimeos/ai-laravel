<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 * @package MW
 * @subpackage Logger
 */


namespace Aimeos\MW\Logger;


/**
 * Log messages using the Laravel 4 logger.
 *
 * @package MW
 * @subpackage Logger
 */
class Laravel4
	extends \Aimeos\MW\Logger\Base
	implements \Aimeos\MW\Logger\Iface
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

			switch( $priority )
			{
				case \Aimeos\MW\Logger\Base::EMERG:
					$this->logger->emergency( $message ); break;
				case \Aimeos\MW\Logger\Base::ALERT:
					$this->logger->alert( $message ); break;
				case \Aimeos\MW\Logger\Base::CRIT:
					$this->logger->critical( $message ); break;
				case \Aimeos\MW\Logger\Base::ERR:
					$this->logger->error( $message ); break;
				case \Aimeos\MW\Logger\Base::WARN:
					$this->logger->warning( $message ); break;
				case \Aimeos\MW\Logger\Base::NOTICE:
					$this->logger->notice( $message ); break;
				case \Aimeos\MW\Logger\Base::INFO:
					$this->logger->info( $message ); break;
				case \Aimeos\MW\Logger\Base::DEBUG:
					$this->logger->debug( $message ); break;
				default:
					throw new \Aimeos\MW\Logger\Exception( 'Invalid log level' );
			}
		}
		catch( \Exception $e )	{
			throw new \Aimeos\MW\Logger\Exception( $e->getMessage(), $e->getCode(), $e );
		}
	}
}