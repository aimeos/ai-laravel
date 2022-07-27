<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2022
 */


namespace Aimeos\Upscheme\Task;


class CustomerRemoveIndexesLaravel extends Base
{
	public function after() : array
	{
		return ['Customer'];
	}


	public function up()
	{
		$this->info( 'Remove customer indexes with siteid column first', 'vv' );

		$this->db( 'db-customer' )
			->dropIndex( 'users', 'idx_lvu_lastname' )
			->dropIndex( 'users', 'idx_lvu_langid' )
			->dropIndex( 'users_address', 'idx_lvuad_langid' )
			->dropIndex( 'users_list', 'unq_lvuli_pid_dm_sid_ty_rid' )
			->dropIndex( 'users_list_type', 'unq_lvulity_sid_dom_code' )
			->dropIndex( 'users_list_type', 'idx_lvulity_sid_status_pos' )
			->dropIndex( 'users_list_type', 'idx_lvulity_sid_label' )
			->dropIndex( 'users_list_type', 'idx_lvulity_sid_code' )
			->dropIndex( 'users_property', 'fk_lvupr_key_sid' )
			->dropIndex( 'users_property', 'unq_lvupr_sid_ty_lid_value' )
			->dropIndex( 'users_property_type', 'unq_lvuprty_sid_dom_code' )
			->dropIndex( 'users_property_type', 'idx_lvuprty_sid_status_pos' )
			->dropIndex( 'users_property_type', 'idx_lvuprty_sid_label' )
			->dropIndex( 'users_property_type', 'idx_lvuprty_sid_code' )
			->dropIndex( 'users_property_type', 'fk_lvupr_key_sid' );
	}
}
