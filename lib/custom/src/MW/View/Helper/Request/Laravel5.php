<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package MW
 * @subpackage View
 */


namespace Aimeos\MW\View\Helper\Request;

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Stream;


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

		parent::__construct( $view, $this->createRequest( $request ) );
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
	 * Transforms a Symfony request into a PSR-7 request object
	 *
	 * @param \Illuminate\Http\Request $nativeRequest Laravel request object
	 * @return \Psr\Http\Message\ServerRequestInterface PSR-7 request object
	 */
	protected function createRequest( \Illuminate\Http\Request $nativeRequest )
	{
		$files = ServerRequestFactory::normalizeFiles( $this->getFiles( $nativeRequest->files->all() ) );
		$server = ServerRequestFactory::normalizeServer( $nativeRequest->server->all() );
		$headers = $nativeRequest->headers->all();
		$cookies = $nativeRequest->cookies->all();
		$post = $nativeRequest->request->all();
		$query = $nativeRequest->query->all();
		$method = $nativeRequest->getMethod();
		$uri = $nativeRequest->getUri();

		$body = new Stream( 'php://temp', 'wb+' );
		$body->write( $nativeRequest->getContent() );

		$request = new ServerRequest( $server, $files, $uri, $method, $body, $headers, $cookies, $query, $post );

		foreach( $nativeRequest->attributes->all() as $key => $value ) {
			$request = $request->withAttribute( $key, $value );
		}

		return $request;
	}


	/**
	 * Converts Symfony uploaded files array to the PSR-7 one.
	 *
	 * @param array $files Multi-dimensional list of uploaded files from Symfony request
	 * @return array Multi-dimensional list of uploaded files as PSR-7 objects
	 */
	protected function getFiles( array $files )
	{
		$list = array();

		foreach( $files as $key => $value )
		{
			if( $value instanceof \Illuminate\Http\UploadedFile )
			{
				$list[$key] = new \Zend\Diactoros\UploadedFile(
					$file->getRealPath(),
					$file->getSize(),
					$file->getError(),
					$file->getClientOriginalName(),
					$file->getClientMimeType()
				);
			}
			else
			{
				$list[$key] = $this->getFiles( $value );
			}
		}

		return $list;
	}
}
