<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2022-2025
 */


namespace Aimeos\Upscheme\Task;


class CustomerClearPropertyKeyLaravel extends TablesMigratePropertyKey
{
	protected function tables()
	{
		return [
			'db-customer' => 'users_property',
		];
	}
}
