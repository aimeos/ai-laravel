<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package MW
 * @subpackage View
 */


namespace Aimeos\MW\View\Helper\Response;


/**
 * View helper class for retrieving response data.
 *
 * @package MW
 * @subpackage View
 */
class Laravel5
	extends \Aimeos\MW\View\Helper\Response\Standard
	implements \Aimeos\MW\View\Helper\Response\Iface
{
	/**
	 * Initializes the response view helper.
	 *
	 * @param \\Aimeos\MW\View\Iface $view View instance with registered view helpers
	 * @param \Illuminate\Http\Response $response Laravel response object
	 */
	public function __construct( \Aimeos\MW\View\Iface $view, \Illuminate\Http\Response $response )
	{
		$factory = new \Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory();
		$psr7response = $factory->createResponse( $response );

		parent::__construct( $view, $psr7response );
	}
}
