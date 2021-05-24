<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2021
 */


return array(
	'exclude' => ['users'],

	'table' => array(
		'users' => function( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'users' );
			$table->addOption( 'engine', 'InnoDB' );

			$table->addColumn( 'id', 'bigint', array( 'autoincrement' => true, 'unsigned' => true ) );
			$table->addColumn( 'superuser', 'smallint', array( 'default' => 0 ) );
			$table->addColumn( 'siteid', 'string', ['length' => 255, 'default' => ''] );
			$table->addColumn( 'name', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'remember_token', 'string', array( 'length' => 100, 'notnull' => false ) );
			$table->addColumn( 'salutation', 'string', array( 'length' => 8, 'default' => '' ) );
			$table->addColumn( 'company', 'string', array( 'length' => 100, 'default' => '' ) );
			$table->addColumn( 'vatid', 'string', array( 'length' => 32, 'default' => '' ) );
			$table->addColumn( 'title', 'string', array( 'length' => 64, 'default' => '' ) );
			$table->addColumn( 'firstname', 'string', array( 'length' => 64, 'default' => '' ) );
			$table->addColumn( 'lastname', 'string', array( 'length' => 64, 'default' => '' ) );
			$table->addColumn( 'address1', 'string', array( 'length' => 200, 'default' => '' ) );
			$table->addColumn( 'address2', 'string', array( 'length' => 200, 'default' => '' ) );
			$table->addColumn( 'address3', 'string', array( 'length' => 200, 'default' => '' ) );
			$table->addColumn( 'postal', 'string', array( 'length' => 16, 'default' => '' ) );
			$table->addColumn( 'city', 'string', array( 'length' => 200, 'default' => '' ) );
			$table->addColumn( 'state', 'string', array( 'length' => 200, 'default' => '' ) );
			$table->addColumn( 'langid', 'string', array( 'length' => 5, 'notnull' => false ) );
			$table->addColumn( 'countryid', 'string', array( 'length' => 2, 'notnull' => false ) );
			$table->addColumn( 'telephone', 'string', array( 'length' => 32, 'default' => '' ) );
			$table->addColumn( 'telefax', 'string', array( 'length' => 32, 'default' => '' ) );
			$table->addColumn( 'website', 'string', array( 'length' => 255, 'default' => '' ) );
			$table->addColumn( 'email', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'password', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'longitude', 'float', array( 'notnull' => false ) );
			$table->addColumn( 'latitude', 'float', array( 'notnull' => false ) );
			$table->addColumn( 'birthday', 'date', array( 'notnull' => false ) );
			$table->addColumn( 'status', 'smallint', array( 'default' => 1 ) );
			$table->addColumn( 'email_verified_at', 'date', array( 'notnull' => false ) );
			$table->addColumn( 'updated_at', 'datetime', [] );
			$table->addColumn( 'created_at', 'datetime', [] );
			$table->addColumn( 'editor', 'string', array( 'length' => 255, 'default' => '' ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_mcussr_id' );
			$table->addUniqueIndex( array( 'email' ), 'unq_mcussr_email' );
			$table->addIndex( array( 'langid' ), 'idx_mcussr_langid' );
			$table->addIndex( array( 'lastname', 'firstname' ), 'idx_mcussr_last_first' );
			$table->addIndex( array( 'postal', 'address1' ), 'idx_mcussr_post_addr1' );
			$table->addIndex( array( 'postal', 'city' ), 'idx_mcussr_post_city' );
			$table->addIndex( array( 'lastname' ), 'idx_mcussr_lastname' );
			$table->addIndex( array( 'address1' ), 'idx_mcussr_address1' );
			$table->addIndex( array( 'city' ), 'idx_mcussr_city' );

			return $schema;
		},

		'users_address' => function( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'users_address' );
			$table->addOption( 'engine', 'InnoDB' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'parentid', 'bigint', ['unsigned' => true] );
			$table->addColumn( 'siteid', 'string', ['length' => 255] );
			$table->addColumn( 'company', 'string', array( 'length' => 100 ) );
			$table->addColumn( 'vatid', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'salutation', 'string', array( 'length' => 8 ) );
			$table->addColumn( 'title', 'string', array( 'length' => 64 ) );
			$table->addColumn( 'firstname', 'string', array( 'length' => 64 ) );
			$table->addColumn( 'lastname', 'string', array( 'length' => 64 ) );
			$table->addColumn( 'address1', 'string', array( 'length' => 200 ) );
			$table->addColumn( 'address2', 'string', array( 'length' => 200 ) );
			$table->addColumn( 'address3', 'string', array( 'length' => 200 ) );
			$table->addColumn( 'postal', 'string', array( 'length' => 16 ) );
			$table->addColumn( 'city', 'string', array( 'length' => 200 ) );
			$table->addColumn( 'state', 'string', array( 'length' => 200 ) );
			$table->addColumn( 'langid', 'string', array( 'length' => 5, 'notnull' => false ) );
			$table->addColumn( 'countryid', 'string', array( 'length' => 2, 'notnull' => false ) );
			$table->addColumn( 'telephone', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'email', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'telefax', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'website', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'longitude', 'float', array( 'notnull' => false ) );
			$table->addColumn( 'latitude', 'float', array( 'notnull' => false ) );
			$table->addColumn( 'birthday', 'date', array( 'notnull' => false ) );
			$table->addColumn( 'pos', 'smallint', [] );
			$table->addColumn( 'mtime', 'datetime', [] );
			$table->addColumn( 'ctime', 'datetime', [] );
			$table->addColumn( 'editor', 'string', array( 'length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_mcusad_id' );
			$table->addIndex( array( 'parentid' ), 'idx_mcusad_pid' );
			$table->addIndex( array( 'lastname', 'firstname' ), 'idx_mcusad_last_first' );
			$table->addIndex( array( 'postal', 'address1' ), 'idx_mcusad_post_addr1' );
			$table->addIndex( array( 'postal', 'city' ), 'idx_mcusad_post_city' );
			$table->addIndex( array( 'address1' ), 'idx_mcusad_address1' );
			$table->addIndex( array( 'city' ), 'idx_mcusad_city' );
			$table->addIndex( array( 'email' ), 'idx_mcusad_email' );

			$table->addForeignKeyConstraint( 'users', array( 'parentid' ), array( 'id' ),
				array( 'onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE' ), 'fk_mcusad_pid' );

			return $schema;
		},

		'users_list_type' => function( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'users_list_type' );
			$table->addOption( 'engine', 'InnoDB' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'siteid', 'string', ['length' => 255] );
			$table->addColumn( 'domain', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'code', 'string', array( 'length' => 64, 'customSchemaOptions' => ['charset' => 'binary'] ) );
			$table->addColumn( 'label', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'pos', 'integer', ['default' => 0] );
			$table->addColumn( 'status', 'smallint', [] );
			$table->addColumn( 'mtime', 'datetime', [] );
			$table->addColumn( 'ctime', 'datetime', [] );
			$table->addColumn( 'editor', 'string', array( 'length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_mcuslity_id' );
			$table->addUniqueIndex( array( 'siteid', 'domain', 'code' ), 'unq_mcuslity_sid_dom_code' );
			$table->addIndex( array( 'siteid', 'status', 'pos' ), 'idx_mcuslity_sid_status_pos' );
			$table->addIndex( array( 'siteid', 'label' ), 'idx_mcuslity_sid_label' );
			$table->addIndex( array( 'siteid', 'code' ), 'idx_mcuslity_sid_code' );

			return $schema;
		},

		'users_list' => function( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'users_list' );
			$table->addOption( 'engine', 'InnoDB' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'parentid', 'bigint', ['unsigned' => true] );
			$table->addColumn( 'siteid', 'string', ['length' => 255] );
			$table->addColumn( 'key', 'string', array( 'length' => 134, 'default' => '', 'customSchemaOptions' => ['charset' => 'binary'] ) );
			$table->addColumn( 'type', 'string', array( 'length' => 64, 'customSchemaOptions' => ['charset' => 'binary'] ) );
			$table->addColumn( 'domain', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'refid', 'string', array( 'length' => 36, 'customSchemaOptions' => ['charset' => 'binary'] ) );
			$table->addColumn( 'start', 'datetime', array( 'notnull' => false ) );
			$table->addColumn( 'end', 'datetime', array( 'notnull' => false ) );
			$table->addColumn( 'config', 'text', array( 'length' => 0xffff ) );
			$table->addColumn( 'pos', 'integer', [] );
			$table->addColumn( 'status', 'smallint', [] );
			$table->addColumn( 'mtime', 'datetime', [] );
			$table->addColumn( 'ctime', 'datetime', [] );
			$table->addColumn( 'editor', 'string', array( 'length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_mcusli_id' );
			$table->addUniqueIndex( array( 'parentid', 'domain', 'siteid', 'type', 'refid' ), 'unq_mcusli_pid_dm_sid_ty_rid' );
			$table->addIndex( array( 'key', 'siteid' ), 'idx_mcusli_key_sid' );
			$table->addIndex( array( 'parentid' ), 'fk_mcusli_pid' );

			$table->addForeignKeyConstraint( 'users', array( 'parentid' ), array( 'id' ),
				array( 'onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE' ), 'fk_mcusli_pid' );

			return $schema;
		},

		'users_property_type' => function( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'users_property_type' );
			$table->addOption( 'engine', 'InnoDB' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'siteid', 'string', ['length' => 255] );
			$table->addColumn( 'domain', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'code', 'string', array( 'length' => 64, 'customSchemaOptions' => ['charset' => 'binary'] ) );
			$table->addColumn( 'label', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'pos', 'integer', ['default' => 0] );
			$table->addColumn( 'status', 'smallint', [] );
			$table->addColumn( 'mtime', 'datetime', [] );
			$table->addColumn( 'ctime', 'datetime', [] );
			$table->addColumn( 'editor', 'string', array( 'length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_mcusprty_id' );
			$table->addUniqueIndex( array( 'siteid', 'domain', 'code' ), 'unq_mcusprty_sid_dom_code' );
			$table->addIndex( array( 'siteid', 'status', 'pos' ), 'idx_mcusprty_sid_status_pos' );
			$table->addIndex( array( 'siteid', 'label' ), 'idx_mcusprty_sid_label' );
			$table->addIndex( array( 'siteid', 'code' ), 'idx_mcusprty_sid_code' );

			return $schema;
		},

		'users_property' => function( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'users_property' );
			$table->addOption( 'engine', 'InnoDB' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'parentid', 'bigint', ['unsigned' => true] );
			$table->addColumn( 'siteid', 'string', ['length' => 255] );
			$table->addColumn( 'key', 'string', array( 'length' => 103, 'default' => '', 'customSchemaOptions' => ['charset' => 'binary'] ) );
			$table->addColumn( 'type', 'string', array( 'length' => 64, 'customSchemaOptions' => ['charset' => 'binary'] ) );
			$table->addColumn( 'langid', 'string', array( 'length' => 5, 'notnull' => false ) );
			$table->addColumn( 'value', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'mtime', 'datetime', [] );
			$table->addColumn( 'ctime', 'datetime', [] );
			$table->addColumn( 'editor', 'string', array( 'length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_mcuspr_id' );
			$table->addUniqueIndex( array( 'parentid', 'siteid', 'type', 'langid', 'value' ), 'unq_mcuspr_sid_ty_lid_value' );
			$table->addIndex( array( 'key', 'siteid' ), 'fk_mcuspr_key_sid' );
			$table->addIndex( array( 'parentid' ), 'fk_mcuspr_pid' );

			$table->addForeignKeyConstraint( 'users', array( 'parentid' ), array( 'id' ),
				array( 'onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE' ), 'fk_mcuspr_pid' );

			return $schema;
		},
	),
);
