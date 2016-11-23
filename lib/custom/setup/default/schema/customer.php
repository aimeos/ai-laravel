<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016
 */


return array(
	'table' => array(
		'users' => function ( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'users' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'label', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'name', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'remember_token', 'string', array( 'length' => 100, 'notnull' => false ) );
			$table->addColumn( 'salutation', 'string', array( 'length' => 8 ) );
			$table->addColumn( 'company', 'string', array( 'length' => 100 ) );
			$table->addColumn( 'vatid', 'string', array( 'length' => 32 ) );
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
			$table->addColumn( 'countryid', 'string', array( 'length' => 2, 'notnull' => false, 'fixed' => true ) );
			$table->addColumn( 'telephone', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'telefax', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'website', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'email', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'password', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'birthday', 'date', array( 'notnull' => false ) );
			$table->addColumn( 'vdate', 'date', array( 'notnull' => false ) );
			$table->addColumn( 'status', 'smallint', array() );
			$table->addColumn( 'updated_at', 'datetime', array() );
			$table->addColumn( 'created_at', 'datetime', array() );
			$table->addColumn( 'editor', 'string', array('length' => 255 ) );

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

		'users_address' => function ( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'users_address' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'siteid', 'integer', array() );
			$table->addColumn( 'parentid', 'integer', array() );
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
			$table->addColumn( 'countryid', 'string', array( 'length' => 2, 'notnull' => false, 'fixed' => true ) );
			$table->addColumn( 'telephone', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'email', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'telefax', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'website', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'flag', 'integer', array() );
			$table->addColumn( 'pos', 'smallint', array() );
			$table->addColumn( 'mtime', 'datetime', array() );
			$table->addColumn( 'ctime', 'datetime', array() );
			$table->addColumn( 'editor', 'string', array('length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_lvuad_id' );
			$table->addIndex( array( 'parentid' ), 'idx_lvuad_pid' );
			$table->addIndex( array( 'lastname', 'firstname' ), 'idx_lvuad_last_first' );
			$table->addIndex( array( 'postal', 'address1' ), 'idx_lvuad_post_addr1' );
			$table->addIndex( array( 'postal', 'city' ), 'idx_lvuad_post_city' );
			$table->addIndex( array( 'address1' ), 'idx_lvusr_address1' );
			$table->addIndex( array( 'city' ), 'idx_lvuad_city' );
			$table->addIndex( array( 'email' ), 'idx_lvuad_email' );

			return $schema;
		},

		'users_list_type' => function ( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'users_list_type' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'siteid', 'integer', array() );
			$table->addColumn( 'domain', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'code', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'label', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'status', 'smallint', array() );
			$table->addColumn( 'mtime', 'datetime', array() );
			$table->addColumn( 'ctime', 'datetime', array() );
			$table->addColumn( 'editor', 'string', array( 'length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_lvulity_id' );
			$table->addUniqueIndex( array( 'siteid', 'domain', 'code' ), 'unq_lvulity_sid_dom_code' );
			$table->addIndex( array( 'siteid', 'status' ), 'idx_lvulity_sid_status' );
			$table->addIndex( array( 'siteid', 'label' ), 'idx_lvulity_sid_label' );
			$table->addIndex( array( 'siteid', 'code' ), 'idx_lvulity_sid_code' );

			return $schema;
		},

		'users_list' => function ( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'users_list' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'parentid', 'integer', array() );
			$table->addColumn( 'siteid', 'integer', array() );
			$table->addColumn( 'typeid', 'integer', array() );
			$table->addColumn( 'domain', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'refid', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'start', 'datetime', array( 'notnull' => false ) );
			$table->addColumn( 'end', 'datetime', array( 'notnull' => false ) );
			$table->addColumn( 'config', 'text', array( 'length' => 0xffff ) );
			$table->addColumn( 'pos', 'integer', array() );
			$table->addColumn( 'status', 'smallint', array() );
			$table->addColumn( 'mtime', 'datetime', array() );
			$table->addColumn( 'ctime', 'datetime', array() );
			$table->addColumn( 'editor', 'string', array( 'length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_lvuli_id' );
			$table->addUniqueIndex( array( 'siteid', 'domain', 'refid', 'typeid', 'parentid' ), 'unq_lvuli_sid_dm_rid_tid_pid' );
			$table->addIndex( array( 'siteid', 'status', 'start', 'end' ), 'idx_lvuli_sid_stat_start_end' );
			$table->addIndex( array( 'parentid', 'siteid', 'refid', 'domain', 'typeid' ), 'idx_lvuli_pid_sid_rid_dom_tid' );
			$table->addIndex( array( 'parentid', 'siteid', 'start' ), 'idx_lvuli_pid_sid_start' );
			$table->addIndex( array( 'parentid', 'siteid', 'end' ), 'idx_lvuli_pid_sid_end' );
			$table->addIndex( array( 'parentid', 'siteid', 'pos' ), 'idx_lvuli_pid_sid_pos' );

			$table->addForeignKeyConstraint( 'users_list_type', array( 'typeid' ), array( 'id' ),
				array( 'onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE' ), 'fk_lvuli_typeid' );

			return $schema;
		},
	),
);
