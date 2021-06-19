<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org], 2015-2021
 */

return [
	'name' => 'ai-laravel',
	'depends' => [
		'aimeos-core',
	],
	'include' => [
		'lib/custom/src',
	],
	'config' => [
		'lib/custom/config',
	],
	'setup' => [
		'lib/custom/setup',
	],
];
