<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2020
 */


return array(
	'manager' => array(
		'address' => array(
			'laravel' => array(
				'delete' => array(
					'ansi' => '
						DELETE FROM "users_address"
						WHERE :cond AND ( "siteid" = ? OR "siteid" = \'\' )
					',
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "users_address" ( :names
							"parentid", "company", "vatid", "salutation", "title",
							"firstname", "lastname", "address1", "address2", "address3",
							"postal", "city", "state", "countryid", "langid", "telephone",
							"email", "telefax", "website", "longitude", "latitude",
							"pos", "birthday", "mtime", "editor", "siteid", "ctime"
						) VALUES ( :values
							?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
						)
					',
				),
				'update' => array(
					'ansi' => '
						UPDATE "users_address"
						SET :names
							"parentid" = ?, "company" = ?, "vatid" = ?, "salutation" = ?,
							"title" = ?, "firstname" = ?, "lastname" = ?, "address1" = ?,
							"address2" = ?, "address3" = ?, "postal" = ?, "city" = ?,
							"state" = ?, "countryid" = ?, "langid" = ?, "telephone" = ?,
							"email" = ?, "telefax" = ?, "website" = ?, "longitude" = ?, "latitude" = ?,
							"pos" = ?, "birthday" = ?, "mtime" = ?, "editor" = ?
						WHERE ( "siteid" = ? OR "siteid" = \'\' ) AND "id" = ?
					',
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							lvuad."id" AS "customer.address.id", lvuad."parentid" AS "customer.address.parentid",
							lvuad."company" AS "customer.address.company", lvuad."vatid" AS "customer.address.vatid",
							lvuad."salutation" AS "customer.address.salutation", lvuad."title" AS "customer.address.title",
							lvuad."firstname" AS "customer.address.firstname", lvuad."lastname" AS "customer.address.lastname",
							lvuad."address1" AS "customer.address.address1", lvuad."address2" AS "customer.address.address2",
							lvuad."address3" AS "customer.address.address3", lvuad."postal" AS "customer.address.postal",
							lvuad."city" AS "customer.address.city", lvuad."state" AS "customer.address.state",
							lvuad."countryid" AS "customer.address.countryid", lvuad."langid" AS "customer.address.languageid",
							lvuad."telephone" AS "customer.address.telephone", lvuad."email" AS "customer.address.email",
							lvuad."telefax" AS "customer.address.telefax", lvuad."website" AS "customer.address.website",
							lvuad."longitude" AS "customer.address.longitude", lvuad."latitude" AS "customer.address.latitude",
							lvuad."pos" AS "customer.address.position", lvuad."mtime" AS "customer.address.mtime",
							lvuad."editor" AS "customer.address.editor", lvuad."ctime" AS "customer.address.ctime",
							lvuad."siteid" AS "customer.address.siteid", lvuad."birthday" AS "customer.address.birthday"
						FROM "users_address" AS lvuad
						:joins
						WHERE :cond
						ORDER BY :order
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					',
					'mysql' => '
						SELECT :columns
							lvuad."id" AS "customer.address.id", lvuad."parentid" AS "customer.address.parentid",
							lvuad."company" AS "customer.address.company", lvuad."vatid" AS "customer.address.vatid",
							lvuad."salutation" AS "customer.address.salutation", lvuad."title" AS "customer.address.title",
							lvuad."firstname" AS "customer.address.firstname", lvuad."lastname" AS "customer.address.lastname",
							lvuad."address1" AS "customer.address.address1", lvuad."address2" AS "customer.address.address2",
							lvuad."address3" AS "customer.address.address3", lvuad."postal" AS "customer.address.postal",
							lvuad."city" AS "customer.address.city", lvuad."state" AS "customer.address.state",
							lvuad."countryid" AS "customer.address.countryid", lvuad."langid" AS "customer.address.languageid",
							lvuad."telephone" AS "customer.address.telephone", lvuad."email" AS "customer.address.email",
							lvuad."telefax" AS "customer.address.telefax", lvuad."website" AS "customer.address.website",
							lvuad."longitude" AS "customer.address.longitude", lvuad."latitude" AS "customer.address.latitude",
							lvuad."pos" AS "customer.address.position", lvuad."mtime" AS "customer.address.mtime",
							lvuad."editor" AS "customer.address.editor", lvuad."ctime" AS "customer.address.ctime",
							lvuad."siteid" AS "customer.address.siteid", lvuad."birthday" AS "customer.address.birthday"
						FROM "users_address" AS lvuad
						:joins
						WHERE :cond
						ORDER BY :order
						LIMIT :size OFFSET :start
					',
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT lvuad."id"
							FROM "users_address" AS lvuad
							:joins
							WHERE :cond
							OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
						) AS list
					',
					'mysql' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT lvuad."id"
							FROM "users_address" AS lvuad
							:joins
							WHERE :cond
							LIMIT 10000 OFFSET 0
						) AS list
					',
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT users_address.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
		),
		'lists' => array(
			'type' => array(
				'laravel' => array(
					'insert' => array(
						'ansi' => '
							INSERT INTO "users_list_type" ( :names
								"code", "domain", "label", "pos", "status",
								"mtime", "editor", "siteid", "ctime"
							) VALUES ( :values
								?, ?, ?, ?, ?, ?, ?, ?, ?
							)
						',
					),
					'update' => array(
						'ansi' => '
							UPDATE "users_list_type"
							SET :names
								"code" = ?, "domain" = ?, "label" = ?, "pos" = ?,
								"status" = ?, "mtime" = ?, "editor" = ?
							WHERE "siteid" = ? AND "id" = ?
						',
					),
					'delete' => array(
						'ansi' => '
							DELETE FROM "users_list_type"
							WHERE :cond AND siteid = ?
						',
					),
					'search' => array(
						'ansi' => '
							SELECT :columns
								lvulity."id" AS "customer.lists.type.id", lvulity."siteid" AS "customer.lists.type.siteid",
								lvulity."code" AS "customer.lists.type.code", lvulity."domain" AS "customer.lists.type.domain",
								lvulity."label" AS "customer.lists.type.label", lvulity."status" AS "customer.lists.type.status",
								lvulity."mtime" AS "customer.lists.type.mtime", lvulity."editor" AS "customer.lists.type.editor",
								lvulity."ctime" AS "customer.lists.type.ctime", lvulity."pos" AS "customer.lists.type.position"
							FROM "users_list_type" AS lvulity
							:joins
							WHERE :cond
							ORDER BY :order
							OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
						',
						'mysql' => '
							SELECT :columns
								lvulity."id" AS "customer.lists.type.id", lvulity."siteid" AS "customer.lists.type.siteid",
								lvulity."code" AS "customer.lists.type.code", lvulity."domain" AS "customer.lists.type.domain",
								lvulity."label" AS "customer.lists.type.label", lvulity."status" AS "customer.lists.type.status",
								lvulity."mtime" AS "customer.lists.type.mtime", lvulity."editor" AS "customer.lists.type.editor",
								lvulity."ctime" AS "customer.lists.type.ctime", lvulity."pos" AS "customer.lists.type.position"
							FROM "users_list_type" AS lvulity
							:joins
							WHERE :cond
							ORDER BY :order
							LIMIT :size OFFSET :start
						',
					),
					'count' => array(
						'ansi' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT lvulity."id"
								FROM "users_list_type" AS lvulity
								:joins
								WHERE :cond
								OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
							) AS LIST
						',
						'mysql' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT lvulity."id"
								FROM "users_list_type" AS lvulity
								:joins
								WHERE :cond
								LIMIT 10000 OFFSET 0
							) AS LIST
						',
					),
					'newid' => array(
						'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
						'mysql' => 'SELECT LAST_INSERT_ID()',
						'oracle' => 'SELECT users_list_type.CURRVAL FROM DUAL',
						'pgsql' => 'SELECT lastval()',
						'sqlite' => 'SELECT last_insert_rowid()',
						'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
						'sqlanywhere' => 'SELECT @@IDENTITY',
					),
				),
			),
			'laravel' => array(
				'aggregate' => array(
					'ansi' => '
						SELECT "key", COUNT("id") AS "count"
						FROM (
							SELECT :key AS "key", lvuli."id" AS "id"
							FROM "users_list" AS lvuli
							:joins
							WHERE :cond
							ORDER BY :order
							OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
						) AS list
						GROUP BY "key"
					',
					'mysql' => '
						SELECT "key", COUNT("id") AS "count"
						FROM (
							SELECT :key AS "key", lvuli."id" AS "id"
							FROM "users_list" AS lvuli
							:joins
							WHERE :cond
							ORDER BY :order
							LIMIT :size OFFSET :start
						) AS list
						GROUP BY "key"
					',
				),
				'delete' => array(
					'ansi' => '
						DELETE FROM "users_list"
						WHERE :cond AND siteid = ?
					',
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "users_list" ( :names
							"parentid", "key", "type", "domain", "refid", "start", "end",
						"config", "pos", "status", "mtime", "editor", "siteid", "ctime"
						) VALUES ( :values
							?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
						)
					',
				),
				'update' => array(
					'ansi' => '
						UPDATE "users_list"
						SET :names
							"parentid"=?, "key" = ?, "type" = ?, "domain" = ?, "refid" = ?, "start" = ?,
							"end" = ?, "config" = ?, "pos" = ?, "status" = ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ? AND "id" = ?
					',
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							lvuli."id" AS "customer.lists.id", lvuli."siteid" AS "customer.lists.siteid",
							lvuli."parentid" AS "customer.lists.parentid", lvuli."type" AS "customer.lists.type",
							lvuli."domain" AS "customer.lists.domain", lvuli."refid" AS "customer.lists.refid",
							lvuli."start" AS "customer.lists.datestart", lvuli."end" AS "customer.lists.dateend",
							lvuli."config" AS "customer.lists.config", lvuli."pos" AS "customer.lists.position",
							lvuli."status" AS "customer.lists.status", lvuli."mtime" AS "customer.lists.mtime",
							lvuli."editor" AS "customer.lists.editor", lvuli."ctime" AS "customer.lists.ctime"
						FROM "users_list" AS lvuli
						:joins
						WHERE :cond
						GROUP BY :columns
							lvuli."id", lvuli."parentid", lvuli."siteid", lvuli."type",
							lvuli."domain", lvuli."refid", lvuli."start", lvuli."end",
							lvuli."config", lvuli."pos", lvuli."status", lvuli."mtime",
							lvuli."editor", lvuli."ctime"
						ORDER BY :order
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					',
					'mysql' => '
						SELECT :columns
							lvuli."id" AS "customer.lists.id", lvuli."siteid" AS "customer.lists.siteid",
							lvuli."parentid" AS "customer.lists.parentid", lvuli."type" AS "customer.lists.type",
							lvuli."domain" AS "customer.lists.domain", lvuli."refid" AS "customer.lists.refid",
							lvuli."start" AS "customer.lists.datestart", lvuli."end" AS "customer.lists.dateend",
							lvuli."config" AS "customer.lists.config", lvuli."pos" AS "customer.lists.position",
							lvuli."status" AS "customer.lists.status", lvuli."mtime" AS "customer.lists.mtime",
							lvuli."editor" AS "customer.lists.editor", lvuli."ctime" AS "customer.lists.ctime"
						FROM "users_list" AS lvuli
						:joins
						WHERE :cond
						GROUP BY :columns
							lvuli."id", lvuli."parentid", lvuli."siteid", lvuli."type",
							lvuli."domain", lvuli."refid", lvuli."start", lvuli."end",
							lvuli."config", lvuli."pos", lvuli."status", lvuli."mtime",
							lvuli."editor", lvuli."ctime"
						ORDER BY :order
						LIMIT :size OFFSET :start
					',
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT lvuli."id"
							FROM "users_list" AS lvuli
							:joins
							WHERE :cond
							OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
						) AS list
					',
					'mysql' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT lvuli."id"
							FROM "users_list" AS lvuli
							:joins
							WHERE :cond
							LIMIT 10000 OFFSET 0
						) AS list
					',
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT users_list.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
		),
		'property' => array(
			'type' => array(
				'laravel' => array(
					'delete' => array(
						'ansi' => '
							DELETE FROM "users_property_type"
							WHERE :cond AND siteid = ?
						'
					),
					'insert' => array(
						'ansi' => '
							INSERT INTO "users_property_type" ( :names
								"code", "domain", "label", "pos", "status",
								"mtime", "editor", "siteid", "ctime"
							) VALUES ( :values
								?, ?, ?, ?, ?, ?, ?, ?, ?
							)
						'
					),
					'update' => array(
						'ansi' => '
							UPDATE "users_property_type"
							SET :names
								"code" = ?, "domain" = ?, "label" = ?, "pos" = ?,
								"status" = ?, "mtime" = ?, "editor" = ?
							WHERE "siteid" = ? AND "id" = ?
						'
					),
					'search' => array(
						'ansi' => '
							SELECT :columns
								lvuprty."id" AS "customer.property.type.id", lvuprty."siteid" AS "customer.property.type.siteid",
								lvuprty."code" AS "customer.property.type.code", lvuprty."domain" AS "customer.property.type.domain",
								lvuprty."label" AS "customer.property.type.label", lvuprty."status" AS "customer.property.type.status",
								lvuprty."mtime" AS "customer.property.type.mtime", lvuprty."editor" AS "customer.property.type.editor",
								lvuprty."ctime" AS "customer.property.type.ctime", lvuprty."pos" AS "customer.property.type.position"
							FROM "users_property_type" lvuprty
							:joins
							WHERE :cond
							ORDER BY :order
							OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
						',
						'mysql' => '
							SELECT :columns
								lvuprty."id" AS "customer.property.type.id", lvuprty."siteid" AS "customer.property.type.siteid",
								lvuprty."code" AS "customer.property.type.code", lvuprty."domain" AS "customer.property.type.domain",
								lvuprty."label" AS "customer.property.type.label", lvuprty."status" AS "customer.property.type.status",
								lvuprty."mtime" AS "customer.property.type.mtime", lvuprty."editor" AS "customer.property.type.editor",
								lvuprty."ctime" AS "customer.property.type.ctime", lvuprty."pos" AS "customer.property.type.position"
							FROM "users_property_type" lvuprty
							:joins
							WHERE :cond
							ORDER BY :order
							LIMIT :size OFFSET :start
						'
					),
					'count' => array(
						'ansi' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT lvuprty."id"
								FROM "users_property_type" lvuprty
								:joins
								WHERE :cond
								OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
							) AS list
						',
						'mysql' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT lvuprty."id"
								FROM "users_property_type" lvuprty
								:joins
								WHERE :cond
								LIMIT 10000 OFFSET 0
							) AS list
						'
					),
					'newid' => array(
						'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
						'mysql' => 'SELECT LAST_INSERT_ID()',
						'oracle' => 'SELECT users_property_type_seq.CURRVAL FROM DUAL',
						'pgsql' => 'SELECT lastval()',
						'sqlite' => 'SELECT last_insert_rowid()',
						'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
						'sqlanywhere' => 'SELECT @@IDENTITY',
					),
				),
			),
			'laravel' => array(
				'delete' => array(
					'ansi' => '
						DELETE FROM "users_property"
						WHERE :cond AND siteid = ?
					'
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "users_property" ( :names
							"parentid", "key", "type", "langid", "value",
							"mtime", "editor", "siteid", "ctime"
						) VALUES ( :values
							?, ?, ?, ?, ?, ?, ?, ?, ?
						)
					'
				),
				'update' => array(
					'ansi' => '
						UPDATE "users_property"
						SET :names
							"parentid" = ?, "key" = ?, "type" = ?, "langid" = ?,
							"value" = ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ? AND "id" = ?
					'
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							lvupr."id" AS "customer.property.id", lvupr."parentid" AS "customer.property.parentid",
							lvupr."siteid" AS "customer.property.siteid", lvupr."type" AS "customer.property.type",
							lvupr."langid" AS "customer.property.languageid", lvupr."value" AS "customer.property.value",
							lvupr."mtime" AS "customer.property.mtime", lvupr."editor" AS "customer.property.editor",
							lvupr."ctime" AS "customer.property.ctime"
						FROM "users_property" AS lvupr
						:joins
						WHERE :cond
						ORDER BY :order
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					',
					'mysql' => '
						SELECT :columns
							lvupr."id" AS "customer.property.id", lvupr."parentid" AS "customer.property.parentid",
							lvupr."siteid" AS "customer.property.siteid", lvupr."type" AS "customer.property.type",
							lvupr."langid" AS "customer.property.languageid", lvupr."value" AS "customer.property.value",
							lvupr."mtime" AS "customer.property.mtime", lvupr."editor" AS "customer.property.editor",
							lvupr."ctime" AS "customer.property.ctime"
						FROM "users_property" AS lvupr
						:joins
						WHERE :cond
						ORDER BY :order
						LIMIT :size OFFSET :start
					'
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT lvupr."id"
							FROM "users_property" AS lvupr
							:joins
							WHERE :cond
							OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
						) AS list
					',
					'mysql' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT lvupr."id"
							FROM "users_property" AS lvupr
							:joins
							WHERE :cond
							LIMIT 10000 OFFSET 0
						) AS list
					'
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT users_property_seq.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
		),
		'laravel' => array(
			'delete' => array(
				'ansi' => '
					DELETE FROM "users"
					WHERE :cond AND ( "siteid" = ? OR "siteid" = \'\' )
				',
			),
			'insert' => array(
				'ansi' => '
					INSERT INTO "users" ( :names
						"name", "email", "company", "vatid", "salutation", "title",
						"firstname", "lastname", "address1", "address2", "address3",
						"postal", "city", "state", "countryid", "langid", "telephone",
						"telefax", "website", "longitude", "latitude",
						"birthday", "status", "email_verified_at", "password",
						"updated_at", "editor", "siteid", "created_at"
					) VALUES ( :values
						?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
					)
				',
			),
			'update' => array(
				'ansi' => '
					UPDATE "users"
					SET :names
						"name" = ?, "email" = ?, "company" = ?, "vatid" = ?,
						"salutation" = ?, "title" = ?, "firstname" = ?, "lastname" = ?,
						"address1" = ?, "address2" = ?, "address3" = ?, "postal" = ?,
						"city" = ?, "state" = ?, "countryid" = ?, "langid" = ?,
						"telephone" = ?, "telefax" = ?, "website" = ?,
						"longitude" = ?, "latitude" = ?, "birthday" = ?,
						"status" = ?, "email_verified_at" = ?, "password" = ?, "updated_at" = ?, "editor" = ?
					WHERE ( "siteid" = ? OR "siteid" = \'\' ) AND "id" = ?
				',
			),
			'search' => array(
				'ansi' => '
					SELECT :columns
						lvu."id" AS "customer.id", lvu."siteid" AS "customer.siteid",
						lvu."name" AS "customer.label", lvu."email" AS "customer.code",
						lvu."company" AS "customer.company", lvu."vatid" AS "customer.vatid",
						lvu."salutation" AS "customer.salutation", lvu."title" AS "customer.title",
						lvu."firstname" AS "customer.firstname", lvu."lastname" AS "customer.lastname",
						lvu."address1" AS "customer.address1", lvu."address2" AS "customer.address2",
						lvu."address3" AS "customer.address3", lvu."postal" AS "customer.postal",
						lvu."city" AS "customer.city", lvu."state" AS "customer.state",
						lvu."countryid" AS "customer.countryid", lvu."langid" AS "customer.languageid",
						lvu."telephone" AS "customer.telephone",lvu."telefax" AS "customer.telefax",
						lvu."email" AS "customer.email", lvu."website" AS "customer.website",
						lvu."longitude" AS "customer.longitude", lvu."latitude" AS "customer.latitude",
						lvu."birthday" AS "customer.birthday", lvu."status" AS "customer.status",
						lvu."email_verified_at" AS "customer.dateverified", lvu."password" AS "customer.password",
						lvu."created_at" AS "customer.ctime", lvu."updated_at" AS "customer.mtime",
						lvu."editor" AS "customer.editor"
					FROM "users" AS lvu
					:joins
					WHERE :cond
					GROUP BY :columns :group
						lvu."id", lvu."siteid", lvu."name", lvu."email", lvu."company", lvu."vatid",
						lvu."salutation", lvu."title", lvu."firstname", lvu."lastname", lvu."address1",
						lvu."address2", lvu."address3", lvu."postal", lvu."city", lvu."state", lvu."countryid",
						lvu."langid", lvu."telephone",lvu."telefax", lvu."email", lvu."website",
						lvu."longitude", lvu."latitude", lvu."birthday", lvu."status", lvu."email_verified_at", lvu."password",
						lvu."created_at", lvu."updated_at", lvu."editor"
					ORDER BY :order
					OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
				',
				'mysql' => '
					SELECT :columns
						lvu."id" AS "customer.id", lvu."siteid" AS "customer.siteid",
						lvu."name" AS "customer.label", lvu."email" AS "customer.code",
						lvu."company" AS "customer.company", lvu."vatid" AS "customer.vatid",
						lvu."salutation" AS "customer.salutation", lvu."title" AS "customer.title",
						lvu."firstname" AS "customer.firstname", lvu."lastname" AS "customer.lastname",
						lvu."address1" AS "customer.address1", lvu."address2" AS "customer.address2",
						lvu."address3" AS "customer.address3", lvu."postal" AS "customer.postal",
						lvu."city" AS "customer.city", lvu."state" AS "customer.state",
						lvu."countryid" AS "customer.countryid", lvu."langid" AS "customer.languageid",
						lvu."telephone" AS "customer.telephone",lvu."telefax" AS "customer.telefax",
						lvu."email" AS "customer.email", lvu."website" AS "customer.website",
						lvu."longitude" AS "customer.longitude", lvu."latitude" AS "customer.latitude",
						lvu."birthday" AS "customer.birthday", lvu."status" AS "customer.status",
						lvu."email_verified_at" AS "customer.dateverified", lvu."password" AS "customer.password",
						lvu."created_at" AS "customer.ctime", lvu."updated_at" AS "customer.mtime",
						lvu."editor" AS "customer.editor"
					FROM "users" AS lvu
					:joins
					WHERE :cond
					GROUP BY :group lvu."id"
					ORDER BY :order
					LIMIT :size OFFSET :start
				',
			),
			'count' => array(
				'ansi' => '
					SELECT COUNT(*) AS "count"
					FROM (
						SELECT lvu."id"
						FROM "users" AS lvu
						:joins
						WHERE :cond
						GROUP BY lvu."id"
						OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
					) AS list
				',
				'mysql' => '
					SELECT COUNT(*) AS "count"
					FROM (
						SELECT lvu."id"
						FROM "users" AS lvu
						:joins
						WHERE :cond
						GROUP BY lvu."id"
						LIMIT 10000 OFFSET 0
					) AS list
				',
			),
			'newid' => array(
				'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
				'mysql' => 'SELECT LAST_INSERT_ID()',
				'oracle' => 'SELECT users.CURRVAL FROM DUAL',
				'pgsql' => 'SELECT lastval()',
				'sqlite' => 'SELECT last_insert_rowid()',
				'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
				'sqlanywhere' => 'SELECT @@IDENTITY',
			),
		),
	),
);
