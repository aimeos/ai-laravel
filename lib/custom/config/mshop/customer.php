<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2017
 */


return array(
	'manager' => array(
		'address' => array(
			'laravel' => array(
				'delete' => array(
					'ansi' => '
						DELETE FROM "users_address"
						WHERE :cond
					',
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "users_address" (
							"parentid", "company", "vatid", "salutation", "title",
							"firstname", "lastname", "address1", "address2", "address3",
							"postal", "city", "state", "countryid", "langid", "telephone",
							"email", "telefax", "website", "longitude", "latitude", "flag",
							"pos", "mtime", "editor", "siteid", "ctime"
						) VALUES (
							?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
						)
					',
				),
				'update' => array(
					'ansi' => '
						UPDATE "users_address"
						SET "parentid" = ?, "company" = ?, "vatid" = ?, "salutation" = ?,
							"title" = ?, "firstname" = ?, "lastname" = ?, "address1" = ?,
							"address2" = ?, "address3" = ?, "postal" = ?, "city" = ?,
							"state" = ?, "countryid" = ?, "langid" = ?, "telephone" = ?,
							"email" = ?, "telefax" = ?, "website" = ?, "longitude" = ?, "latitude" = ?,
							"flag" = ?, "pos" = ?, "mtime" = ?, "editor" = ?, "siteid" = ?
						WHERE "id" = ?
					',
				),
				'search' => array(
					'ansi' => '
						SELECT lvuad."id" AS "customer.address.id", lvuad."parentid" AS "customer.address.parentid",
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
							lvuad."flag" AS "customer.address.flag", lvuad."pos" AS "customer.address.position",
							lvuad."mtime" AS "customer.address.mtime", lvuad."editor" AS "customer.address.editor",
							lvuad."ctime" AS "customer.address.ctime", lvuad."siteid" AS "customer.address.siteid"
						FROM "users_address" AS lvuad
						:joins
						WHERE :cond
						GROUP BY lvuad."id", lvuad."parentid", lvuad."company", lvuad."vatid",
							lvuad."salutation", lvuad."title", lvuad."firstname", lvuad."lastname",
							lvuad."address1", lvuad."address2", lvuad."address3", lvuad."postal",
							lvuad."city", lvuad."state", lvuad."countryid", lvuad."langid",
							lvuad."telephone", lvuad."email", lvuad."telefax", lvuad."website",
							lvuad."longitude", lvuad."latitude", lvuad."flag", lvuad."pos",
							lvuad."mtime", lvuad."editor", lvuad."ctime"
						/*-orderby*/ ORDER BY :order /*orderby-*/
						LIMIT :size OFFSET :start
					',
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT DISTINCT lvuad."id"
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
							INSERT INTO "users_list_type"(
								"code", "domain", "label", "status",
								"mtime", "editor", "siteid", "ctime"
							) VALUES (
								?, ?, ?, ?, ?, ?, ?, ?
							)
						',
					),
					'update' => array(
						'ansi' => '
							UPDATE "users_list_type"
							SET "code" = ?, "domain" = ?, "label" = ?,
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
							SELECT lvulity."id" AS "customer.lists.type.id", lvulity."siteid" AS "customer.lists.type.siteid",
								lvulity."code" AS "customer.lists.type.code", lvulity."domain" AS "customer.lists.type.domain",
								lvulity."label" AS "customer.lists.type.label", lvulity."status" AS "customer.lists.type.status",
								lvulity."mtime" AS "customer.lists.type.mtime", lvulity."editor" AS "customer.lists.type.editor",
								lvulity."ctime" AS "customer.lists.type.ctime"
							FROM "users_list_type" AS lvulity
							:joins
							WHERE
								:cond
							/*-orderby*/ ORDER BY :order /*orderby-*/
							LIMIT :size OFFSET :start
						',
					),
					'count' => array(
						'ansi' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT DISTINCT lvulity."id"
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
						SELECT "key", COUNT(DISTINCT "id") AS "count"
						FROM (
							SELECT :key AS "key", lvuli."id" AS "id"
							FROM "users_list" AS lvuli
							:joins
							WHERE :cond
							/*-orderby*/ ORDER BY :order /*orderby-*/
							LIMIT :size OFFSET :start
						) AS list
						GROUP BY "key"
					',
				),
				'getposmax' => array(
					'ansi' => '
						SELECT MAX( "pos" ) AS pos
						FROM "users_list"
						WHERE "siteid" = ?
							AND "parentid" = ?
							AND "typeid" = ?
							AND "domain" = ?
					',
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "users_list"(
							"parentid", "typeid", "domain", "refid", "start", "end",
						"config", "pos", "status", "mtime", "editor", "siteid", "ctime"
						) VALUES (
							?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
						)
					',
				),
				'update' => array(
					'ansi' => '
						UPDATE "users_list"
						SET "parentid"=?, "typeid" = ?, "domain" = ?, "refid" = ?, "start" = ?, "end" = ?,
							"config" = ?, "pos" = ?, "status" = ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ? AND "id" = ?
					',
				),
				'updatepos' => array(
					'ansi' => '
						UPDATE "users_list"
							SET "pos" = ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ? AND "id" = ?
					',
				),
				'delete' => array(
					'ansi' => '
						DELETE FROM "users_list"
						WHERE :cond AND siteid = ?
					',
				),
				'move' => array(
					'ansi' => '
						UPDATE "users_list"
							SET "pos" = "pos" + ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ?
							AND "parentid" = ?
							AND "typeid" = ?
							AND "domain" = ?
							AND "pos" >= ?
					',
				),
				'search' => array(
					'ansi' => '
						SELECT lvuli."id" AS "customer.lists.id", lvuli."siteid" AS "customer.lists.siteid",
							lvuli."parentid" AS "customer.lists.parentid", lvuli."typeid" AS "customer.lists.typeid",
							lvuli."domain" AS "customer.lists.domain", lvuli."refid" AS "customer.lists.refid",
							lvuli."start" AS "customer.lists.datestart", lvuli."end" AS "customer.lists.dateend",
							lvuli."config" AS "customer.lists.config", lvuli."pos" AS "customer.lists.position",
							lvuli."status" AS "customer.lists.status", lvuli."mtime" AS "customer.lists.mtime",
							lvuli."editor" AS "customer.lists.editor", lvuli."ctime" AS "customer.lists.ctime"
						FROM "users_list" AS lvuli
						:joins
						WHERE :cond
						/*-orderby*/ ORDER BY :order /*orderby-*/
						LIMIT :size OFFSET :start
					',
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT DISTINCT lvuli."id"
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
		'laravel' => array(
			'delete' => array(
				'ansi' => '
					DELETE FROM "users"
					WHERE :cond
				',
			),
			'insert' => array(
				'ansi' => '
					INSERT INTO "users" (
						"siteid", "name", "company", "vatid", "salutation", "title",
						"firstname", "lastname", "address1", "address2", "address3",
						"postal", "city", "state", "countryid", "langid", "telephone",
						"telefax", "website", "email", "longitude", "latitude", "label",
						"birthday", "status", "vdate", "password",
						"updated_at", "editor", "created_at"
					) VALUES (
						?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
					)
				',
			),
			'update' => array(
				'ansi' => '
					UPDATE "users"
					SET "siteid" = ?, "name" = ?, "company" = ?, "vatid" = ?,
						"salutation" = ?, "title" = ?, "firstname" = ?, "lastname" = ?,
						"address1" = ?, "address2" = ?, "address3" = ?, "postal" = ?,
						"city" = ?, "state" = ?, "countryid" = ?, "langid" = ?,
						"telephone" = ?, "telefax" = ?, "website" = ?, "email" = ?,
						"longitude" = ?, "latitude" = ?, "label" = ?, "birthday" = ?,
						"status" = ?, "vdate" = ?, "password" = ?, "updated_at" = ?, "editor" = ?
					WHERE "id" = ?
				',
			),
			'search' => array(
				'ansi' => '
					SELECT lvu."id" AS "customer.id", lvu."siteid" AS "customer.siteid",
						lvu."label" AS "customer.label", lvu."name" AS "customer.code",
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
						lvu."vdate" AS "customer.dateverified", lvu."password" AS "customer.password",
						lvu."created_at" AS "customer.ctime", lvu."updated_at" AS "customer.mtime",
						lvu."editor" AS "customer.editor"
					FROM "users" AS lvu
					:joins
					WHERE :cond
					GROUP BY lvu."id", lvu."siteid", lvu."label", lvu."name", lvu."company", lvu."vatid",
						lvu."salutation", lvu."title", lvu."firstname", lvu."lastname",
						lvu."address1", lvu."address2", lvu."address3", lvu."postal",
						lvu."city", lvu."state", lvu."countryid", lvu."langid",
						lvu."telephone", lvu."telefax", lvu."email", lvu."website",
						lvu."longitude", lvu."latitude", lvu."birthday", lvu."status",
						lvu."vdate", lvu."password", lvu."created_at", lvu."updated_at",
						lvu."editor"
					/*-orderby*/ ORDER BY :order /*orderby-*/
					LIMIT :size OFFSET :start
				',
			),
			'count' => array(
				'ansi' => '
					SELECT COUNT(*) AS "count"
					FROM (
						SELECT DISTINCT lvu."id"
						FROM "users" AS lvu
						:joins
						WHERE :cond
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