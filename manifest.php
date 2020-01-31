<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2020
 */

return array(
	'name' => 'ai-laravel',
	'depends' => array(
		'aimeos-core',
	),
	'include' => array(
		'lib/custom/src',
	),
	'config' => array(
		'lib/custom/config',
	),
	'setup' => array(
		'lib/custom/setup',
	),
);
