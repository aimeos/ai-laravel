<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package MW
 * @subpackage View
 */


namespace Aimeos\MW\View\Helper\Request;


/**
 * View helper class for retrieving request data.
 *
 * @package MW
 * @subpackage View
 */
class Laravel5
	extends \Aimeos\MW\View\Helper\Request\Standard
	implements \Aimeos\MW\View\Helper\Request\Iface
{
	private $request;


	/**
	 * Initializes the request view helper.
	 *
	 * @param \\Aimeos\MW\View\Iface $view View instance with registered view helpers
	 * @param \Illuminate\Http\Request $request Laravel request object
	 */
	public function __construct( \Aimeos\MW\View\Iface $view, \Illuminate\Http\Request $request )
	{
		$this->request = $request;

		$factory = new \Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory();
		$psr7request = $factory->createRequest( $request );

		parent::__construct( $view, $psr7request );
	}


	/**
	 * Returns the client IP address.
	 *
	 * @return string Client IP address
	 */
	public function getClientAddress()
	{
		return $this->request->ip();
	}


	/**
	 * Returns the current page or route name
	 *
	 * @return string|null Current page or route name
	 */
	public function getTarget()
	{
		if( ( $route = $this->request->route() ) !== null ) {
			return $route->getName();
		}
	}
}
