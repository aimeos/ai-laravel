<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2022
 */


namespace Aimeos\Upscheme\Task;


class CustomerMigratePropertyKeyLaravel extends TablesMigratePropertyKey
{
	protected function tables()
	{
		return [
			'db-customer' => 'users_property',
		];
	}
}
