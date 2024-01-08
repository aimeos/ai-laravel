<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2024
 * @package Base
 * @subpackage View
 */


namespace Aimeos\Base\View\Helper\Request;


/**
 * View helper class for retrieving request data.
 *
 * @package Base
 * @subpackage View
 */
class Laravel
	extends \Aimeos\Base\View\Helper\Request\Standard
	implements \Aimeos\Base\View\Helper\Request\Iface
{
	private \Illuminate\Http\Request $request;


	/**
	 * Initializes the request view helper.
	 *
	 * @param \\Aimeos\Base\View\Iface $view View instance with registered view helpers
	 * @param \Illuminate\Http\Request $request Laravel request object
	 */
	public function __construct( \Aimeos\Base\View\Iface $view, \Illuminate\Http\Request $request )
	{
		$this->request = $request;

		parent::__construct( $view, $this->createRequest( $request ) );
	}


	/**
	 * Returns the client IP address.
	 *
	 * @return string Client IP address
	 */
	public function getClientAddress() : string
	{
		return $this->request->ip();
	}


	/**
	 * Returns the current page or route name
	 *
	 * @return string|null Current page or route name
	 */
	public function getTarget() : ?string
	{
		if( ( $route = $this->request->route() ) !== null ) {
			return $route->getName();
		}

		return null;
	}


	/**
	 * Transforms a Symfony request into a PSR-7 request object
	 *
	 * @param \Illuminate\Http\Request $nativeRequest Laravel request object
	 * @return \Psr\Http\Message\ServerRequestInterface PSR-7 request object
	 */
	protected function createRequest( \Illuminate\Http\Request $nativeRequest ) : \Psr\Http\Message\ServerRequestInterface
	{
		$files = $this->getFiles( $nativeRequest->files->all() );
		$headers = $nativeRequest->headers->all();
		$server = $nativeRequest->server->all();
		$method = $nativeRequest->getMethod();
		$uri = $nativeRequest->getUri();

		$request = new \Nyholm\Psr7\ServerRequest( $method, $uri, $headers, $nativeRequest->getContent(), '1.1', $server );
		$request = $request->withCookieParams( $nativeRequest->cookies->all() )
			->withParsedBody( $nativeRequest->request->all() )
			->withQueryParams( $nativeRequest->query->all() )
			->withUploadedFiles( $files );

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
	protected function getFiles( array $files ) : array
	{
		$list = [];
		$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

		foreach( $files as $key => $value )
		{
			if( $value instanceof \Symfony\Component\HttpFoundation\File\UploadedFile )
			{
				$list[$key] = $psr17Factory->createUploadedFile(
					$psr17Factory->createStreamFromFile( $value->getRealPath() ),
					$value->getSize(),
					$value->getError(),
					$value->getClientOriginalName(),
					$value->getClientMimeType()
				);
			}
			elseif( is_array( $value ) )
			{
				$list[$key] = $this->getFiles( $value );
			}
		}

		return $list;
	}
}
