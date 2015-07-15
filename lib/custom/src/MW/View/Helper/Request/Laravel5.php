<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 * @package MW
 * @subpackage View
 */


/**
 * View helper class for generating URLs using the Laravel 5 URL builder.
 *
 * @package MW
 * @subpackage View
 */
class MW_View_Helper_Request_Laravel5
	extends MW_View_Helper_Abstract
	implements MW_View_Helper_Interface
{
	private $_request;


	/**
	 * Initializes the request view helper.
	 *
	 * @param \MW_View_Interface $view View instance with registered view helpers
	 * @param \Illuminate\Http\Request $request Laravel request object
	 */
	public function __construct( \MW_View_Interface $view, \Illuminate\Http\Request $request )
	{
		parent::__construct( $view );

		$this->_request = $request;
	}


	/**
	 * Returns the request view helper.
	 *
	 * @return MW_View_Helper_Interface Request view helper
	 */
	public function transform()
	{
		return $this;
	}


	/**
	 * Returns the request body.
	 *
	 * @return string Request body
	 */
	public function getBody()
	{
		return $this->_request->getContent();
	}


	/**
	 * Returns the client IP address.
	 *
	 * @return string Client IP address
	 */
	public function getClientAddress()
	{
		return $this->_request->ip();
	}
}
