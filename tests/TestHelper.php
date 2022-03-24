<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2022
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


	public static function context( $site = 'unittest' )
	{
		if( !isset( self::$context[$site] ) ) {
			self::$context[$site] = self::createContext( $site );
		}

		return clone self::$context[$site];
	}


	public static function getAimeos()
	{
		if( !isset( self::$aimeos ) )
		{
			require_once 'Bootstrap.php';
			spl_autoload_register( 'Aimeos\\Bootstrap::autoload' );

			self::$aimeos = new \Aimeos\Bootstrap();
		}

		return self::$aimeos;
	}


	private static function createContext( $site )
	{
		$ctx = new \Aimeos\MShop\Context();
		$aimeos = self::getAimeos();


		$paths = $aimeos->getConfigPaths();
		$paths[] = __DIR__ . DIRECTORY_SEPARATOR . 'config';
		$file = __DIR__ . DIRECTORY_SEPARATOR . 'confdoc.ser';

		$conf = new \Aimeos\Base\Config\PHPArray( [], $paths );
		$conf = new \Aimeos\Base\Config\Decorator\Memory( $conf );
		$conf = new \Aimeos\Base\Config\Decorator\Documentor( $conf, $file );
		$ctx->setConfig( $conf );


		$dbm = \Aimeos\Base\DB\Factory::create( $conf, 'PDO' );
		$ctx->setDatabaseManager( $dbm );


		$logger = new \Aimeos\Base\Logger\File( $site . '.log', \Aimeos\Base\Logger\Iface::DEBUG );
		$ctx->setLogger( $logger );


		$i18n = new \Aimeos\Base\Translation\None( 'de' );
		$ctx->setI18n( array( 'de' => $i18n ) );


		$session = new \Aimeos\Base\Session\None();
		$ctx->setSession( $session );


		$localeManager = \Aimeos\MShop\Locale\Manager\Factory::create( $ctx );
		$localeItem = $localeManager->bootstrap( $site, '', '', false );
		$ctx->setLocale( $localeItem );


		return $ctx->setEditor( 'ai-laravel' );
	}
}
