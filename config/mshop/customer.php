<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2023
 */


return array(
	'manager' => array(
		'address' => array(
			'laravel' => array(
				'clear' => array(
					'ansi' => '
						DELETE FROM "users_address"
						WHERE :cond AND "siteid" LIKE ?
					',
				),
				'delete' => array(
					'ansi' => '
						DELETE FROM "users_address"
						WHERE :cond AND ( "siteid" LIKE ? OR "siteid" = ? )
					',
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "users_address" ( :names
							"parentid", "company", "vatid", "salutation", "title",
							"firstname", "lastname", "address1", "address2", "address3",
							"postal", "city", "state", "countryid", "langid", "telephone",
							"mobile", "email", "telefax", "website", "longitude", "latitude",
							"pos", "birthday", "mtime", "editor", "siteid", "ctime"
						) VALUES ( :values
							?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
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
							"state" = ?, "countryid" = ?, "langid" = ?, "telephone" = ?, "mobile" = ?,
							"email" = ?, "telefax" = ?, "website" = ?, "longitude" = ?, "latitude" = ?,
							"pos" = ?, "birthday" = ?, "mtime" = ?, "editor" = ?
						WHERE ( "siteid" LIKE ? OR "siteid" = ? ) AND "id" = ?
					',
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							mcusad."id" AS "customer.address.id", mcusad."parentid" AS "customer.address.parentid",
							mcusad."company" AS "customer.address.company", mcusad."vatid" AS "customer.address.vatid",
							mcusad."salutation" AS "customer.address.salutation", mcusad."title" AS "customer.address.title",
							mcusad."firstname" AS "customer.address.firstname", mcusad."lastname" AS "customer.address.lastname",
							mcusad."address1" AS "customer.address.address1", mcusad."address2" AS "customer.address.address2",
							mcusad."address3" AS "customer.address.address3", mcusad."postal" AS "customer.address.postal",
							mcusad."city" AS "customer.address.city", mcusad."state" AS "customer.address.state",
							mcusad."countryid" AS "customer.address.countryid", mcusad."langid" AS "customer.address.languageid",
							mcusad."telephone" AS "customer.address.telephone", mcusad."email" AS "customer.address.email",
							mcusad."telefax" AS "customer.address.telefax", mcusad."website" AS "customer.address.website",
							mcusad."longitude" AS "customer.address.longitude", mcusad."latitude" AS "customer.address.latitude",
							mcusad."pos" AS "customer.address.position", mcusad."mtime" AS "customer.address.mtime",
							mcusad."editor" AS "customer.address.editor", mcusad."ctime" AS "customer.address.ctime",
							mcusad."siteid" AS "customer.address.siteid", mcusad."birthday" AS "customer.address.birthday",
							mcusad."mobile" AS "customer.address.mobile"
						FROM "users_address" mcusad
						:joins
						WHERE :cond
						ORDER BY :order
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					',
					'mysql' => '
						SELECT :columns
							mcusad."id" AS "customer.address.id", mcusad."parentid" AS "customer.address.parentid",
							mcusad."company" AS "customer.address.company", mcusad."vatid" AS "customer.address.vatid",
							mcusad."salutation" AS "customer.address.salutation", mcusad."title" AS "customer.address.title",
							mcusad."firstname" AS "customer.address.firstname", mcusad."lastname" AS "customer.address.lastname",
							mcusad."address1" AS "customer.address.address1", mcusad."address2" AS "customer.address.address2",
							mcusad."address3" AS "customer.address.address3", mcusad."postal" AS "customer.address.postal",
							mcusad."city" AS "customer.address.city", mcusad."state" AS "customer.address.state",
							mcusad."countryid" AS "customer.address.countryid", mcusad."langid" AS "customer.address.languageid",
							mcusad."telephone" AS "customer.address.telephone", mcusad."email" AS "customer.address.email",
							mcusad."telefax" AS "customer.address.telefax", mcusad."website" AS "customer.address.website",
							mcusad."longitude" AS "customer.address.longitude", mcusad."latitude" AS "customer.address.latitude",
							mcusad."pos" AS "customer.address.position", mcusad."mtime" AS "customer.address.mtime",
							mcusad."editor" AS "customer.address.editor", mcusad."ctime" AS "customer.address.ctime",
							mcusad."siteid" AS "customer.address.siteid", mcusad."birthday" AS "customer.address.birthday",
							mcusad."mobile" AS "customer.address.mobile"
						FROM "users_address" mcusad
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
							SELECT mcusad."id"
							FROM "users_address" mcusad
							:joins
							WHERE :cond
							OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
						) AS list
					',
					'mysql' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mcusad."id"
							FROM "users_address" mcusad
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
								"code", "domain", "label", "i18n", "pos", "status",
								"mtime","editor", "siteid", "ctime"
							) VALUES ( :values
								?, ?, ?, ?, ?, ?, ?, ?, ?, ?
							)
						',
					),
					'update' => array(
						'ansi' => '
							UPDATE "users_list_type"
							SET :names
								"code" = ?, "domain" = ?, "label" = ?, "i18n" = ?,
								"pos" = ?, "status" = ?, "mtime" = ?, "editor" = ?
							WHERE "siteid" LIKE ? AND "id" = ?
						',
					),
					'delete' => array(
						'ansi' => '
							DELETE FROM "users_list_type"
							WHERE :cond AND "siteid" LIKE ?
						',
					),
					'search' => array(
						'ansi' => '
							SELECT :columns
								mcuslity."id" AS "customer.lists.type.id", mcuslity."siteid" AS "customer.lists.type.siteid",
								mcuslity."code" AS "customer.lists.type.code", mcuslity."domain" AS "customer.lists.type.domain",
								mcuslity."label" AS "customer.lists.type.label", mcuslity."status" AS "customer.lists.type.status",
								mcuslity."mtime" AS "customer.lists.type.mtime", mcuslity."editor" AS "customer.lists.type.editor",
								mcuslity."ctime" AS "customer.lists.type.ctime", mcuslity."pos" AS "customer.lists.type.position",
								mcuslity."i18n" AS "customer.lists.type.i18n"
							FROM "users_list_type" mcuslity
							:joins
							WHERE :cond
							ORDER BY :order
							OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
						',
						'mysql' => '
							SELECT :columns
								mcuslity."id" AS "customer.lists.type.id", mcuslity."siteid" AS "customer.lists.type.siteid",
								mcuslity."code" AS "customer.lists.type.code", mcuslity."domain" AS "customer.lists.type.domain",
								mcuslity."label" AS "customer.lists.type.label", mcuslity."status" AS "customer.lists.type.status",
								mcuslity."mtime" AS "customer.lists.type.mtime", mcuslity."editor" AS "customer.lists.type.editor",
								mcuslity."ctime" AS "customer.lists.type.ctime", mcuslity."pos" AS "customer.lists.type.position",
								mcuslity."i18n" AS "customer.lists.type.i18n"
							FROM "users_list_type" mcuslity
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
								SELECT mcuslity."id"
								FROM "users_list_type" mcuslity
								:joins
								WHERE :cond
								OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
							) AS LIST
						',
						'mysql' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT mcuslity."id"
								FROM "users_list_type" mcuslity
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
						SELECT :keys, COUNT("id") AS "count"
						FROM (
							SELECT :acols, mcusli."id" AS "id"
							FROM "users_list" mcusli
							:joins
							WHERE :cond
							ORDER BY :order
							OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
						) AS list
						GROUP BY :keys
					',
					'mysql' => '
						SELECT :keys, COUNT("id") AS "count"
						FROM (
							SELECT :acols, mcusli."id" AS "id"
							FROM "users_list" mcusli
							:joins
							WHERE :cond
							ORDER BY :order
							LIMIT :size OFFSET :start
						) AS list
						GROUP BY :keys
					',
				),
				'delete' => array(
					'ansi' => '
						DELETE FROM "users_list"
						WHERE :cond AND "siteid" LIKE ?
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
						WHERE "siteid" LIKE ? AND "id" = ?
					',
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							mcusli."id" AS "customer.lists.id", mcusli."siteid" AS "customer.lists.siteid",
							mcusli."parentid" AS "customer.lists.parentid", mcusli."type" AS "customer.lists.type",
							mcusli."domain" AS "customer.lists.domain", mcusli."refid" AS "customer.lists.refid",
							mcusli."start" AS "customer.lists.datestart", mcusli."end" AS "customer.lists.dateend",
							mcusli."config" AS "customer.lists.config", mcusli."pos" AS "customer.lists.position",
							mcusli."status" AS "customer.lists.status", mcusli."mtime" AS "customer.lists.mtime",
							mcusli."editor" AS "customer.lists.editor", mcusli."ctime" AS "customer.lists.ctime"
						FROM "users_list" mcusli
						:joins
						WHERE :cond
						GROUP BY :columns
							mcusli."id", mcusli."parentid", mcusli."siteid", mcusli."type",
							mcusli."domain", mcusli."refid", mcusli."start", mcusli."end",
							mcusli."config", mcusli."pos", mcusli."status", mcusli."mtime",
							mcusli."editor", mcusli."ctime"
						ORDER BY :order
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					',
					'mysql' => '
						SELECT :columns
							mcusli."id" AS "customer.lists.id", mcusli."siteid" AS "customer.lists.siteid",
							mcusli."parentid" AS "customer.lists.parentid", mcusli."type" AS "customer.lists.type",
							mcusli."domain" AS "customer.lists.domain", mcusli."refid" AS "customer.lists.refid",
							mcusli."start" AS "customer.lists.datestart", mcusli."end" AS "customer.lists.dateend",
							mcusli."config" AS "customer.lists.config", mcusli."pos" AS "customer.lists.position",
							mcusli."status" AS "customer.lists.status", mcusli."mtime" AS "customer.lists.mtime",
							mcusli."editor" AS "customer.lists.editor", mcusli."ctime" AS "customer.lists.ctime"
						FROM "users_list" mcusli
						:joins
						WHERE :cond
						GROUP BY :columns
							mcusli."id", mcusli."parentid", mcusli."siteid", mcusli."type",
							mcusli."domain", mcusli."refid", mcusli."start", mcusli."end",
							mcusli."config", mcusli."pos", mcusli."status", mcusli."mtime",
							mcusli."editor", mcusli."ctime"
						ORDER BY :order
						LIMIT :size OFFSET :start
					',
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mcusli."id"
							FROM "users_list" mcusli
							:joins
							WHERE :cond
							OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
						) AS list
					',
					'mysql' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mcusli."id"
							FROM "users_list" mcusli
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
							WHERE :cond AND "siteid" LIKE ?
						'
					),
					'insert' => array(
						'ansi' => '
							INSERT INTO "users_property_type" ( :names
								"code", "domain", "label", "i18n", "pos", "status",
								"mtime","editor", "siteid", "ctime"
							) VALUES ( :values
								?, ?, ?, ?, ?, ?, ?, ?, ?, ?
							)
						'
					),
					'update' => array(
						'ansi' => '
							UPDATE "users_property_type"
							SET :names
								"code" = ?, "domain" = ?, "label" = ?, "i18n" = ?,
								"pos" = ?, "status" = ?, "mtime" = ?, "editor" = ?
							WHERE "siteid" LIKE ? AND "id" = ?
						'
					),
					'search' => array(
						'ansi' => '
							SELECT :columns
								mcusprty."id" AS "customer.property.type.id", mcusprty."siteid" AS "customer.property.type.siteid",
								mcusprty."code" AS "customer.property.type.code", mcusprty."domain" AS "customer.property.type.domain",
								mcusprty."label" AS "customer.property.type.label", mcusprty."status" AS "customer.property.type.status",
								mcusprty."mtime" AS "customer.property.type.mtime", mcusprty."editor" AS "customer.property.type.editor",
								mcusprty."ctime" AS "customer.property.type.ctime", mcusprty."pos" AS "customer.property.type.position",
								mcusprty."i18n" AS "customer.property.type.i18n"
							FROM "users_property_type" mcusprty
							:joins
							WHERE :cond
							ORDER BY :order
							OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
						',
						'mysql' => '
							SELECT :columns
								mcusprty."id" AS "customer.property.type.id", mcusprty."siteid" AS "customer.property.type.siteid",
								mcusprty."code" AS "customer.property.type.code", mcusprty."domain" AS "customer.property.type.domain",
								mcusprty."label" AS "customer.property.type.label", mcusprty."status" AS "customer.property.type.status",
								mcusprty."mtime" AS "customer.property.type.mtime", mcusprty."editor" AS "customer.property.type.editor",
								mcusprty."ctime" AS "customer.property.type.ctime", mcusprty."pos" AS "customer.property.type.position",
								mcusprty."i18n" AS "customer.property.type.i18n"
							FROM "users_property_type" mcusprty
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
								SELECT mcusprty."id"
								FROM "users_property_type" mcusprty
								:joins
								WHERE :cond
								OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
							) AS list
						',
						'mysql' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT mcusprty."id"
								FROM "users_property_type" mcusprty
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
						WHERE :cond AND "siteid" LIKE ?
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
						WHERE "siteid" LIKE ? AND "id" = ?
					'
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							mcuspr."id" AS "customer.property.id", mcuspr."parentid" AS "customer.property.parentid",
							mcuspr."siteid" AS "customer.property.siteid", mcuspr."type" AS "customer.property.type",
							mcuspr."langid" AS "customer.property.languageid", mcuspr."value" AS "customer.property.value",
							mcuspr."mtime" AS "customer.property.mtime", mcuspr."editor" AS "customer.property.editor",
							mcuspr."ctime" AS "customer.property.ctime"
						FROM "users_property" mcuspr
						:joins
						WHERE :cond
						ORDER BY :order
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					',
					'mysql' => '
						SELECT :columns
							mcuspr."id" AS "customer.property.id", mcuspr."parentid" AS "customer.property.parentid",
							mcuspr."siteid" AS "customer.property.siteid", mcuspr."type" AS "customer.property.type",
							mcuspr."langid" AS "customer.property.languageid", mcuspr."value" AS "customer.property.value",
							mcuspr."mtime" AS "customer.property.mtime", mcuspr."editor" AS "customer.property.editor",
							mcuspr."ctime" AS "customer.property.ctime"
						FROM "users_property" mcuspr
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
							SELECT mcuspr."id"
							FROM "users_property" mcuspr
							:joins
							WHERE :cond
							OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
						) AS list
					',
					'mysql' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mcuspr."id"
							FROM "users_property" mcuspr
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
			'aggregate' => array(
				'ansi' => '
					SELECT :keys, COUNT("val") AS "count"
					FROM (
						SELECT :acols, :val AS "val"
						FROM "users" mcus
						:joins
						WHERE :cond
						GROUP BY mcus.id, :cols, :val
						ORDER BY mcus.id DESC
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					) AS list
					GROUP BY :keys
				',
				'mysql' => '
					SELECT :keys, COUNT("val") AS "count"
					FROM (
						SELECT :acols, :val AS "val"
						FROM "users" mcus
						:joins
						WHERE :cond
						GROUP BY mcus.id, :cols, :val
						ORDER BY mcus.id DESC
						LIMIT :size OFFSET :start
					) AS list
					GROUP BY :keys
				'
			),
			'clear' => array(
				'ansi' => '
					DELETE FROM "users"
					WHERE :cond AND "siteid" LIKE ?
				',
			),
			'delete' => array(
				'ansi' => '
					DELETE FROM "users"
					WHERE :cond AND ( "siteid" LIKE ? OR "siteid" = ? )
				',
			),
			'insert' => array(
				'ansi' => '
					INSERT INTO "users" ( :names
						"name", "email", "company", "vatid", "salutation", "title",
						"firstname", "lastname", "address1", "address2", "address3",
						"postal", "city", "state", "countryid", "langid", "telephone",
						"telefax", "mobile", "website", "longitude", "latitude",
						"birthday", "status", "email_verified_at", "password",
						"updated_at", "editor", "siteid", "created_at"
					) VALUES ( :values
						?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
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
						"telephone" = ?, "telefax" = ?, "mobile" = ?, "website" = ?,
						"longitude" = ?, "latitude" = ?, "birthday" = ?,
						"status" = ?, "email_verified_at" = ?, "password" = ?, "updated_at" = ?, "editor" = ?
					WHERE ( "siteid" LIKE ? OR "siteid" = ? ) AND "id" = ?
				',
			),
			'search' => array(
				'ansi' => '
					SELECT :columns
						mcus."id" AS "customer.id", mcus."siteid" AS "customer.siteid",
						mcus."name" AS "customer.label", mcus."email" AS "customer.code",
						mcus."company" AS "customer.company", mcus."vatid" AS "customer.vatid",
						mcus."salutation" AS "customer.salutation", mcus."title" AS "customer.title",
						mcus."firstname" AS "customer.firstname", mcus."lastname" AS "customer.lastname",
						mcus."address1" AS "customer.address1", mcus."address2" AS "customer.address2",
						mcus."address3" AS "customer.address3", mcus."postal" AS "customer.postal",
						mcus."city" AS "customer.city", mcus."state" AS "customer.state",
						mcus."countryid" AS "customer.countryid", mcus."langid" AS "customer.languageid",
						mcus."telephone" AS "customer.telephone",mcus."telefax" AS "customer.telefax",
						mcus."email" AS "customer.email", mcus."website" AS "customer.website",
						mcus."longitude" AS "customer.longitude", mcus."latitude" AS "customer.latitude",
						mcus."birthday" AS "customer.birthday", mcus."status" AS "customer.status",
						mcus."email_verified_at" AS "customer.dateverified", mcus."password" AS "customer.password",
						mcus."created_at" AS "customer.ctime", mcus."updated_at" AS "customer.mtime",
						mcus."editor" AS "customer.editor", mcus."mobile" AS "customer.mobile",
						mcus."superuser" AS ".super"
					FROM "users" mcus
					:joins
					WHERE :cond
					GROUP BY :columns :group
						mcus."id", mcus."siteid", mcus."name", mcus."email", mcus."company", mcus."vatid",
						mcus."salutation", mcus."title", mcus."firstname", mcus."lastname", mcus."address1",
						mcus."address2", mcus."address3", mcus."postal", mcus."city", mcus."state", mcus."countryid",
						mcus."langid", mcus."telephone",mcus."telefax", mcus."email", mcus."website",
						mcus."longitude", mcus."latitude", mcus."birthday", mcus."status", mcus."email_verified_at", mcus."password",
						mcus."created_at", mcus."updated_at", mcus."editor", mcus."mobile", mcus."superuser"
					ORDER BY :order
					OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
				',
				'mysql' => '
					SELECT :columns
						mcus."id" AS "customer.id", mcus."siteid" AS "customer.siteid",
						mcus."name" AS "customer.label", mcus."email" AS "customer.code",
						mcus."company" AS "customer.company", mcus."vatid" AS "customer.vatid",
						mcus."salutation" AS "customer.salutation", mcus."title" AS "customer.title",
						mcus."firstname" AS "customer.firstname", mcus."lastname" AS "customer.lastname",
						mcus."address1" AS "customer.address1", mcus."address2" AS "customer.address2",
						mcus."address3" AS "customer.address3", mcus."postal" AS "customer.postal",
						mcus."city" AS "customer.city", mcus."state" AS "customer.state",
						mcus."countryid" AS "customer.countryid", mcus."langid" AS "customer.languageid",
						mcus."telephone" AS "customer.telephone",mcus."telefax" AS "customer.telefax",
						mcus."email" AS "customer.email", mcus."website" AS "customer.website",
						mcus."longitude" AS "customer.longitude", mcus."latitude" AS "customer.latitude",
						mcus."birthday" AS "customer.birthday", mcus."status" AS "customer.status",
						mcus."email_verified_at" AS "customer.dateverified", mcus."password" AS "customer.password",
						mcus."created_at" AS "customer.ctime", mcus."updated_at" AS "customer.mtime",
						mcus."editor" AS "customer.editor", mcus."mobile" AS "customer.mobile",
						mcus."superuser" AS ".super"
					FROM "users" mcus
					:joins
					WHERE :cond
					GROUP BY :group mcus."id"
					ORDER BY :order
					LIMIT :size OFFSET :start
				',
			),
			'count' => array(
				'ansi' => '
					SELECT COUNT(*) AS "count"
					FROM (
						SELECT mcus."id"
						FROM "users" mcus
						:joins
						WHERE :cond
						GROUP BY mcus."id"
						OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
					) AS list
				',
				'mysql' => '
					SELECT COUNT(*) AS "count"
					FROM (
						SELECT mcus."id"
						FROM "users" mcus
						:joins
						WHERE :cond
						GROUP BY mcus."id"
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
