<?php

class TestHelper
{
	private static $aimeos;
	private static $context = array();


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
			require_once 'Aimeos.php';
			spl_autoload_register( 'Aimeos::autoload' );

			$extdir = dirname( dirname( dirname( __DIR__ ) ) );
			self::$aimeos = new Aimeos( array( $extdir ), false );
		}

		return self::$aimeos;
	}


	private static function createContext( $site )
	{
		$ctx = new MShop_Context_Item_Default();
		$aimeos = self::getAimeos();


		$paths = $aimeos->getConfigPaths( 'mysql' );
		$paths[] = __DIR__ . DIRECTORY_SEPARATOR . 'config';

		$conf = new MW_Config_Array( array(), $paths );
		$ctx->setConfig( $conf );


		$dbm = new MW_DB_Manager_PDO( $conf );
		$ctx->setDatabaseManager( $dbm );


		$logger = new MW_Logger_File( $site . '.log', MW_Logger_Abstract::DEBUG );
		$ctx->setLogger( $logger );


		$i18n = new MW_Translation_None( 'de' );
		$ctx->setI18n( array( 'de' => $i18n ) );


		$session = new MW_Session_None();
		$ctx->setSession( $session );


		$localeManager = MShop_Locale_Manager_Factory::createManager( $ctx );
		$localeItem = $localeManager->bootstrap( $site, '', '', false );

		$ctx->setLocale( $localeItem );

		$ctx->setEditor( 'ai-laravel:unittest' );

		return $ctx;
	}
}
