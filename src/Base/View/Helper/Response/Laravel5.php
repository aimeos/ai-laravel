<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2022
 * @package MW
 * @subpackage View
 */


namespace Aimeos\Base\View\Helper\Response;


/**
 * View helper class for retrieving response data.
 *
 * @package MW
 * @subpackage View
 */
class Laravel5
	extends \Aimeos\Base\View\Helper\Response\Standard
	implements \Aimeos\Base\View\Helper\Response\Iface
{
	/**
	 * Initializes the response view helper.
	 *
	 * @param \Aimeos\Base\View\Iface $view View instance with registered view helpers
	 */
	public function __construct( \Aimeos\Base\View\Iface $view )
	{
		$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();
		parent::__construct( $view, $psr17Factory->createResponse() );
	}
}
