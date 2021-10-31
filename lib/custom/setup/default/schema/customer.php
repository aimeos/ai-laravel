<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2021
 */


return array(
	'table' => array(
		'users' => function( \Aimeos\Upscheme\Schema\Table $table ) {

			$table->engine = 'InnoDB';

			$table->bigid()->primary( 'pk_lvu_id' )->unsigned( true );
			$table->string( 'siteid' )->default( '' );
			$table->string( 'email' );
			$table->string( 'name' );
			$table->string( 'password' );
			$table->string( 'remember_token', 100 )->null( true );
			$table->date( 'email_verified_at' )->null( true );;
			$table->smallint( 'superuser' )->default( 0 );
			$table->smallint( 'status' )->default( 1 );
			$table->string( 'company', 100 )->default( '' );
			$table->string( 'vatid', 32 )->default( '' );
			$table->string( 'salutation', 8 )->default( '' );
			$table->string( 'title', 64 )->default( '' );
			$table->string( 'firstname', 64 )->default( '' );
			$table->string( 'lastname', 64 )->default( '' );
			$table->string( 'address1', 200 )->default( '' );
			$table->string( 'address2', 200 )->default( '' );
			$table->string( 'address3', 200 )->default( '' );
			$table->string( 'postal', 16 )->default( '' );
			$table->string( 'city', 200 )->default( '' );
			$table->string( 'state', 200 )->default( '' );
			$table->string( 'langid', 5 )->null( true );
			$table->string( 'countryid', 2 )->null( true );
			$table->string( 'telephone', 32 )->default( '' );
			$table->string( 'telefax', 32 )->default( '' );
			$table->string( 'website' )->default( '' );
			$table->float( 'longitude' )->null( true );
			$table->float( 'latitude' )->null( true );
			$table->date( 'birthday' )->null( true );
			$table->datetime( 'updated_at' );
			$table->datetime( 'created_at' );
			$table->string( 'editor' )->default( '' );

			$table->unique( ['email'], 'unq_lvu_email' );
			$table->index( ['langid'], 'idx_lvu_langid' );
			$table->index( ['lastname', 'firstname'], 'idx_lvu_last_first' );
			$table->index( ['postal', 'address1'], 'idx_lvu_post_addr1' );
			$table->index( ['postal', 'city'], 'idx_lvu_post_city' );
			$table->index( ['lastname'], 'idx_lvu_lastname' );
			$table->index( ['address1'], 'idx_lvu_address1' );
			$table->index( ['city'], 'idx_lvu_city' );
		},

		'users_address' => function( \Aimeos\Upscheme\Schema\Table $table ) {

			$table->engine = 'InnoDB';

			$table->id()->primary( 'pk_lvuad_id' );
			$table->string( 'siteid' );
			$table->bigint( 'parentid' )->unsigned( true );
			$table->string( 'company', 100 );
			$table->string( 'vatid', 32 );
			$table->string( 'salutation', 8 );
			$table->string( 'title', 64 );
			$table->string( 'firstname', 64 );
			$table->string( 'lastname', 64 );
			$table->string( 'address1', 200 );
			$table->string( 'address2', 200 );
			$table->string( 'address3', 200 );
			$table->string( 'postal', 16 );
			$table->string( 'city', 200 );
			$table->string( 'state', 200 );
			$table->string( 'langid', 5 )->null( true );
			$table->string( 'countryid', 2 )->null( true );
			$table->string( 'telephone', 32 );
			$table->string( 'telefax', 32 );
			$table->string( 'email' );
			$table->string( 'website' );
			$table->float( 'longitude' )->null( true );
			$table->float( 'latitude' )->null( true );
			$table->date( 'birthday' )->null( true );
			$table->smallint( 'pos' );
			$table->meta();

			$table->index( ['parentid'], 'fk_lvuad_pid' );
			$table->index( ['langid'], 'idx_lvuad_langid' );
			$table->index( ['siteid', 'lastname', 'firstname'], 'idx_lvuad_sid_last_first' );
			$table->index( ['siteid', 'postal', 'address1'], 'idx_lvuad_sid_post_addr1' );
			$table->index( ['siteid', 'postal', 'city'], 'idx_lvuad_sid_post_ci' );
			$table->index( ['siteid', 'city'], 'idx_lvuad_sid_city' );
			$table->index( ['siteid', 'email'], 'idx_lvuad_sid_email' );

			$table->foreign( 'parentid', 'users', 'id', 'fk_lvuad_pid' );
		},

		'users_list_type' => function( \Aimeos\Upscheme\Schema\Table $table ) {

			$table->engine = 'InnoDB';

			$table->id()->primary( 'pk_lvulity_id' );
			$table->string( 'siteid' );
			$table->string( 'domain', 32 );
			$table->code();
			$table->string( 'label' );
			$table->int( 'pos' )->default( 0 );
			$table->smallint( 'status' );
			$table->meta();

			$table->unique( ['siteid', 'domain', 'code'], 'unq_lvulity_sid_dom_code' );
			$table->index( ['siteid', 'status', 'pos'], 'idx_lvulity_sid_status_pos' );
			$table->index( ['siteid', 'label'], 'idx_lvulity_sid_label' );
			$table->index( ['siteid', 'code'], 'idx_lvulity_sid_code' );
		},

		'users_list' => function( \Aimeos\Upscheme\Schema\Table $table ) {

			$table->engine = 'InnoDB';

			$table->id()->primary( 'pk_lvuli_id' );
			$table->string( 'siteid' );
			$table->bigint( 'parentid' )->unsigned( true );
			$table->string( 'key', 134 )->default( '' );
			$table->type( 'type' );
			$table->string( 'domain', 32 );
			$table->refid();
			$table->startend();
			$table->text( 'config' );
			$table->int( 'pos' );
			$table->smallint( 'status' );
			$table->meta();

			$table->unique( ['parentid', 'domain', 'siteid', 'type', 'refid'], 'unq_lvuli_pid_dm_sid_ty_rid' );
			$table->index( ['key', 'siteid'], 'idx_lvuli_key_sid' );
			$table->index( ['parentid'], 'fk_lvuli_pid' );

			$table->foreign( 'parentid', 'users', 'id', 'fk_lvuli_pid' );
		},

		'users_property_type' => function( \Aimeos\Upscheme\Schema\Table $table ) {

			$table->engine = 'InnoDB';

			$table->id()->primary( 'pk_lvuprty_id' );
			$table->string( 'siteid' );
			$table->string( 'domain', 32 );
			$table->code();
			$table->string( 'label' );
			$table->int( 'pos' )->default( 0 );
			$table->smallint( 'status' );
			$table->meta();

			$table->unique( ['siteid', 'domain', 'code'], 'unq_lvuprty_sid_dom_code' );
			$table->index( ['siteid', 'status', 'pos'], 'idx_lvuprty_sid_status_pos' );
			$table->index( ['siteid', 'label'], 'idx_lvuprty_sid_label' );
			$table->index( ['siteid', 'code'], 'idx_lvuprty_sid_code' );
		},

		'users_property' => function( \Aimeos\Upscheme\Schema\Table $table ) {

			$table->engine = 'InnoDB';

			$table->bigid()->primary( 'pk_lvupr_id' );
			$table->string( 'siteid' );
			$table->bigint( 'parentid' )->unsigned( true );
			$table->string( 'key', 103 )->default( '' );
			$table->type();
			$table->string( 'langid', 5 )->null( true );
			$table->string( 'value' );
			$table->meta();

			$table->unique( ['parentid', 'siteid', 'type', 'langid', 'value'], 'unq_lvupr_sid_ty_lid_value' );
			$table->index( ['key', 'siteid'], 'fk_lvupr_key_sid' );
			$table->index( ['parentid'], 'fk_lvupr_pid' );

			$table->foreign( 'parentid', 'users', 'id', 'fk_lvupr_pid' );
		},
	),
);
