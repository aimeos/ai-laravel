<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2023
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
			$table->date( 'email_verified_at' )->null( true );
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
			$table->string( 'mobile', 32 )->default( '' );
			$table->string( 'website' )->default( '' );
			$table->float( 'longitude' )->null( true );
			$table->float( 'latitude' )->null( true );
			$table->date( 'birthday' )->null( true );
			$table->datetime( 'updated_at' );
			$table->datetime( 'created_at' );
			$table->string( 'editor' )->default( '' );

			$table->unique( ['email'], 'unq_lvu_email' );
			$table->index( ['langid', 'siteid'], 'idx_lvu_langid_sid' );
			$table->index( ['lastname', 'firstname'], 'idx_lvu_last_first' );
			$table->index( ['postal', 'address1'], 'idx_lvu_post_addr1' );
			$table->index( ['postal', 'city'], 'idx_lvu_post_city' );
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
			$table->string( 'mobile', 32 )->default( '' );
			$table->string( 'email' );
			$table->string( 'website' );
			$table->float( 'longitude' )->null( true );
			$table->float( 'latitude' )->null( true );
			$table->date( 'birthday' )->null( true );
			$table->smallint( 'pos' );
			$table->meta();

			$table->index( ['langid', 'siteid'], 'idx_lvuad_langid_sid' );
			$table->index( ['lastname', 'firstname'], 'idx_lvuad_last_first' );
			$table->index( ['postal', 'address1'], 'idx_lvuad_post_addr1' );
			$table->index( ['postal', 'city'], 'idx_lvuad_post_ci' );
			$table->index( ['city'], 'idx_lvuad_city' );
			$table->index( ['email'], 'idx_lvuad_email' );

			$table->foreign( 'parentid', 'users', 'id', 'fk_lvuad_pid' );
		},

		'users_list_type' => function( \Aimeos\Upscheme\Schema\Table $table ) {

			$table->engine = 'InnoDB';

			$table->id()->primary( 'pk_lvulity_id' );
			$table->string( 'siteid' );
			$table->string( 'domain', 32 );
			$table->code();
			$table->string( 'label' );
			$table->i18n();
			$table->int( 'pos' )->default( 0 );
			$table->smallint( 'status' );
			$table->meta();

			$table->unique( ['domain', 'code', 'siteid'], 'unq_lvulity_dom_code_sid' );
			$table->index( ['status', 'siteid', 'pos'], 'idx_lvulity_status_sid_pos' );
			$table->index( ['label', 'siteid'], 'idx_lvulity_label_sid' );
			$table->index( ['code', 'siteid'], 'idx_lvulity_code_sid' );
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
			$table->config();
			$table->int( 'pos' );
			$table->smallint( 'status' );
			$table->meta();

			$table->unique( ['parentid', 'domain', 'type', 'refid', 'siteid'], 'unq_lvuli_pid_dm_ty_rid_sid' );
			$table->index( ['key', 'siteid'], 'idx_lvuli_key_sid' );

			$table->foreign( 'parentid', 'users', 'id', 'fk_lvuli_pid' );
		},

		'users_property_type' => function( \Aimeos\Upscheme\Schema\Table $table ) {

			$table->engine = 'InnoDB';

			$table->id()->primary( 'pk_lvuprty_id' );
			$table->string( 'siteid' );
			$table->string( 'domain', 32 );
			$table->code();
			$table->string( 'label' );
			$table->i18n();
			$table->int( 'pos' )->default( 0 );
			$table->smallint( 'status' );
			$table->meta();

			$table->unique( ['domain', 'code', 'siteid'], 'unq_lvuprty_dom_code_sid' );
			$table->index( ['status', 'siteid', 'pos'], 'idx_lvuprty_status_sid_pos' );
			$table->index( ['label', 'siteid'], 'idx_lvuprty_label_sid' );
			$table->index( ['code', 'siteid'], 'idx_lvuprty_code_sid' );
		},

		'users_property' => function( \Aimeos\Upscheme\Schema\Table $table ) {

			$table->engine = 'InnoDB';

			$table->bigid()->primary( 'pk_lvupr_id' );
			$table->string( 'siteid' );
			$table->bigint( 'parentid' )->unsigned( true );
			$table->string( 'key', 255 )->default( '' );
			$table->type();
			$table->string( 'langid', 5 )->null( true );
			$table->string( 'value' );
			$table->meta();

			$table->unique( ['parentid', 'type', 'langid', 'value', 'siteid'], 'unq_lvupr_pid_ty_lid_val_sid' );
			$table->index( ['key', 'siteid'], 'idx_lvupr_key_sid' );

			$table->foreign( 'parentid', 'users', 'id', 'fk_lvupr_pid' );
		},
	),
);
