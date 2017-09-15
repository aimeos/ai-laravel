<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2017
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
	 * @param \Aimeos\MW\View\Iface $view View instance with registered view helpers
	 */
	public function __construct( \Aimeos\MW\View\Iface $view )
	{
		parent::__construct( $view, new \Zend\Diactoros\Response() );
	}
}
