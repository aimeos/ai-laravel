<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org)2023-2026
 */


namespace Aimeos\Upscheme\Task;


class CustomerRenameGroupLaravel extends CustomerRenameGroup
{
	public function before() : array
	{
		return ['Customer', 'Group'];
	}


	public function up()
	{
		$this->info( 'Migrate Laravel "customer/group" domain to "group"', 'vv' );

		$this->update( 'users_list' );
	}
}
