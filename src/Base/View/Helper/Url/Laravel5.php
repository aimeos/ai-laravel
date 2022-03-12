<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2022
 * @package MW
 * @subpackage View
 */


namespace Aimeos\Base\View\Helper\Url;


/**
 * View helper class for generating URLs using the Laravel 5 URL builder.
 *
 * @package MW
 * @subpackage View
 */
class Laravel5
	extends \Aimeos\Base\View\Helper\Url\Base
	implements \Aimeos\Base\View\Helper\Url\Iface
{
	private $builder;
	private $fixed;


	/**
	 * Initializes the URL view helper.
	 *
	 * @param \\Aimeos\Base\View\Iface $view View instance with registered view helpers
	 * @param \Illuminate\Contracts\Routing\UrlGenerator $builder Laravel URL builder object
	 * @param array Associative list of fixed parameters that should be available for all routes
	 */
	public function __construct( \Aimeos\Base\View\Iface $view, \Illuminate\Contracts\Routing\UrlGenerator $builder, array $fixed )
	{
		parent::__construct( $view );

		$this->builder = $builder;
		$this->fixed = $fixed;
	}


	/**
	 * Returns the URL assembled from the given arguments.
	 *
	 * @param string|null $target Route or page which should be the target of the link (if any)
	 * @param string|null $controller Name of the controller which should be part of the link (if any)
	 * @param string|null $action Name of the action which should be part of the link (if any)
	 * @param array $params Associative list of parameters that should be part of the URL
	 * @param array $trailing Trailing URL parts that are not relevant to identify the resource (for pretty URLs)
	 * @param array $config Additional configuration parameter per URL
	 * @return string Complete URL that can be used in the template
	 */
	public function transform( string $target = null, string $controller = null, string $action = null,
		array $params = [], array $trailing = [], array $config = [] ) : string
	{
		$values = $this->getValues( $config );
		$params = $this->sanitize( $params ) + $this->fixed;
		$fragment = ( !empty( $trailing ) ? '#' . implode( '/', $trailing ) : '' );

		return $this->builder->route( $target, $params, $values['absoluteUri'] ) . $fragment;
	}


	/**
	 * Returns the sanitized configuration values.
	 *
	 * @param array $config Associative list of key/value pairs
	 * @return array Associative list of sanitized key/value pairs
	 */
	protected function getValues( array $config ) : array
	{
		$values = array(
			'absoluteUri' => false,
		);

		if( isset( $config['absoluteUri'] ) ) {
			$values['absoluteUri'] = (bool) $config['absoluteUri'];
		}

		return $values;
	}
}
