<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 * @package MW
 * @subpackage View
 */


namespace Aimeos\MW\View\Helper\Request;


use Symfony\Component\HttpFoundation\File\UploadedFile;


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
		\Aimeos\MW\View\Helper\Request\Standard::__construct( $view, null, null, null, $request->file() );

		$this->request = $request;
	}


	/**
	 * Returns the request body.
	 *
	 * @return string Request body
	 */
	public function getBody()
	{
		return $this->request->getContent();
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


	/**
	 * Creates a normalized file upload data from the given array.
	 *
	 * @param \Traversable|array $files File upload data
	 * @return array Multi-dimensional list of file objects
	 */
	protected function createUploadedFiles( $files )
	{
		$list = array();

		foreach( $files as $key => $value )
		{
			if( $value instanceof UploadedFile )
			{
				$list[$key] = new \Aimeos\MW\View\Helper\Request\File\Standard(
					$value->getRealPath(),
					$value->getClientOriginalName(),
					$value->getSize(),
					$value->getClientMimeType(),
					$value->getError()
				);
			}
			else
			{
				$list[$key] = $this->createUploadedFiles($value);
			}
		}

		return $list;
	}
}
