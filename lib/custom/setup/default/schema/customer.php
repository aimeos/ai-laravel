<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2020
 */


return array(
	'table' => array(
		'users' => function( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'users' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true, 'unsigned' => true ) );
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
			$table->addColumn( 'vdate', 'date', array( 'notnull' => false ) );
			$table->addColumn( 'status', 'smallint', array( 'default' => 1 ) );
			$table->addColumn( 'updated_at', 'datetime', [] );
			$table->addColumn( 'created_at', 'datetime', [] );
			$table->addColumn( 'editor', 'string', array( 'length' => 255, 'default' => '' ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_lvusr_id' );
			$table->addUniqueIndex( array( 'email' ), 'unq_lvusr_email' );
			$table->addIndex( array( 'langid' ), 'idx_lvusr_langid' );
			$table->addIndex( array( 'lastname', 'firstname' ), 'idx_lvusr_last_first' );
			$table->addIndex( array( 'postal', 'address1' ), 'idx_lvusr_post_addr1' );
			$table->addIndex( array( 'postal', 'city' ), 'idx_lvusr_post_city' );
			$table->addIndex( array( 'lastname' ), 'idx_lvusr_lastname' );
			$table->addIndex( array( 'address1' ), 'idx_lvusr_address1' );
			$table->addIndex( array( 'city' ), 'idx_lvusr_city' );

			return $schema;
		},

		'users_address' => function( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'users_address' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'parentid', 'integer', ['unsigned' => true] );
			$table->addColumn( 'siteid', 'string', ['length' => 255, 'default' => ''] );
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
			$table->addColumn( 'pos', 'smallint', [] );
			$table->addColumn( 'mtime', 'datetime', [] );
			$table->addColumn( 'ctime', 'datetime', [] );
			$table->addColumn( 'editor', 'string', array( 'length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_lvuad_id' );
			$table->addIndex( array( 'parentid' ), 'idx_lvuad_pid' );
			$table->addIndex( array( 'lastname', 'firstname' ), 'idx_lvuad_last_first' );
			$table->addIndex( array( 'postal', 'address1' ), 'idx_lvuad_post_addr1' );
			$table->addIndex( array( 'postal', 'city' ), 'idx_lvuad_post_city' );
			$table->addIndex( array( 'address1' ), 'idx_lvuad_address1' );
			$table->addIndex( array( 'city' ), 'idx_lvuad_city' );
			$table->addIndex( array( 'email' ), 'idx_lvuad_email' );

			$table->addForeignKeyConstraint( 'users', array( 'parentid' ), array( 'id' ),
				array( 'onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE' ), 'fk_lvuad_pid' );

			return $schema;
		},

		'users_list_type' => function( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'users_list_type' );

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

			$table->setPrimaryKey( array( 'id' ), 'pk_lvulity_id' );
			$table->addUniqueIndex( array( 'siteid', 'domain', 'code' ), 'unq_lvulity_sid_dom_code' );
			$table->addIndex( array( 'siteid', 'status', 'pos' ), 'idx_lvulity_sid_status_pos' );
			$table->addIndex( array( 'siteid', 'label' ), 'idx_lvulity_sid_label' );
			$table->addIndex( array( 'siteid', 'code' ), 'idx_lvulity_sid_code' );

			return $schema;
		},

		'users_list' => function( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'users_list' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'parentid', 'integer', ['unsigned' => true] );
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

			$table->setPrimaryKey( array( 'id' ), 'pk_lvuli_id' );
			$table->addUniqueIndex( array( 'parentid', 'siteid', 'domain', 'type', 'refid' ), 'unq_lvuli_pid_sid_dm_ty_rid' );
			$table->addIndex( array( 'siteid', 'key' ), 'idx_lvuli_sid_key' );
			$table->addIndex( array( 'parentid' ), 'fk_lvuli_pid' );

			$table->addForeignKeyConstraint( 'users', array( 'parentid' ), array( 'id' ),
				array( 'onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE' ), 'fk_lvuli_pid' );

			return $schema;
		},

		'users_property_type' => function( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'users_property_type' );

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

			$table->setPrimaryKey( array( 'id' ), 'pk_lvuprty_id' );
			$table->addUniqueIndex( array( 'siteid', 'domain', 'code' ), 'unq_lvuprty_sid_dom_code' );
			$table->addIndex( array( 'siteid', 'status', 'pos' ), 'idx_lvuprty_sid_status_pos' );
			$table->addIndex( array( 'siteid', 'label' ), 'idx_lvuprty_sid_label' );
			$table->addIndex( array( 'siteid', 'code' ), 'idx_lvuprty_sid_code' );

			return $schema;
		},

		'users_property' => function( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'users_property' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'parentid', 'integer', ['unsigned' => true] );
			$table->addColumn( 'siteid', 'string', ['length' => 255] );
			$table->addColumn( 'key', 'string', array( 'length' => 103, 'default' => '', 'customSchemaOptions' => ['charset' => 'binary'] ) );
			$table->addColumn( 'type', 'string', array( 'length' => 64, 'customSchemaOptions' => ['charset' => 'binary'] ) );
			$table->addColumn( 'langid', 'string', array( 'length' => 5, 'notnull' => false ) );
			$table->addColumn( 'value', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'mtime', 'datetime', [] );
			$table->addColumn( 'ctime', 'datetime', [] );
			$table->addColumn( 'editor', 'string', array( 'length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_lvupr_id' );
			$table->addUniqueIndex( array( 'parentid', 'siteid', 'type', 'langid', 'value' ), 'unq_lvupr_sid_ty_lid_value' );
			$table->addIndex( array( 'siteid', 'key' ), 'fk_lvupr_sid_key' );
			$table->addIndex( array( 'parentid' ), 'fk_lvupr_pid' );

			$table->addForeignKeyConstraint( 'users', array( 'parentid' ), array( 'id' ),
				array( 'onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE' ), 'fk_lvupr_pid' );

			return $schema;
		},
	),
);
