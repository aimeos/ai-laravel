<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2017
 */


class TestHelper
{
	private static $aimeos;
	private static $context = [];


	public static function bootstrap()
	{
		$aimeos = self::getAimeos();

		$includepaths = $aimeos->getIncludePaths();
		$includepaths[] = get_include_path();
		set_include_path( implode( PATH_SEPARATOR, $includepaths ) );
	}


	public static function getContext( $site = 'unittest' )
	{
		if( !isset( self::$context[$site] ) ) {
			self::$context[$site] = self::createContext( $site );
		}

		return clone self::$context[$site];
	}


	private static function getAimeos()
	{
		if( !isset( self::$aimeos ) )
		{
			require_once 'Bootstrap.php';
			spl_autoload_register( 'Aimeos\\Bootstrap::autoload' );

			$extdir = dirname( dirname( dirname( __DIR__ ) ) );
			self::$aimeos = new \Aimeos\Bootstrap( array( $extdir ), false );
		}

		return self::$aimeos;
	}


	private static function createContext( $site )
	{
		$ctx = new \Aimeos\MShop\Context\Item\Standard();
		$aimeos = self::getAimeos();


		$paths = $aimeos->getConfigPaths( 'mysql' );
		$paths[] = __DIR__ . DIRECTORY_SEPARATOR . 'config';

		$conf = new \Aimeos\MW\Config\PHPArray( [], $paths );
		$ctx->setConfig( $conf );


		$dbm = new \Aimeos\MW\DB\Manager\PDO( $conf );
		$ctx->setDatabaseManager( $dbm );


		$logger = new \Aimeos\MW\Logger\File( $site . '.log', \Aimeos\MW\Logger\Base::DEBUG );
		$ctx->setLogger( $logger );


		$i18n = new \Aimeos\MW\Translation\None( 'de' );
		$ctx->setI18n( array( 'de' => $i18n ) );


		$session = new \Aimeos\MW\Session\None();
		$ctx->setSession( $session );


		$localeManager = \Aimeos\MShop\Locale\Manager\Factory::createManager( $ctx );
		$localeItem = $localeManager->bootstrap( $site, '', '', false );

		$ctx->setLocale( $localeItem );

		$ctx->setEditor( 'ai-laravel:unittest' );

		return $ctx;
	}
}
