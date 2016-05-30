<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */

return array(
	'delete' => array(
		'ansi' => '
			DELETE FROM "users"
			WHERE :cond
		',
	),
	'insert' => array(
		'ansi' => '
			INSERT INTO "users" (
				"name", "company", "vatid", "salutation", "title",
				"firstname", "lastname", "address1", "address2", "address3",
				"postal", "city", "state", "countryid", "langid", "telephone",
				"telefax", "website", "email", "label", "birthday", "status",
				"vdate", "password", "updated_at", "editor", "created_at"
			) VALUES (
				?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
			)
		',
	),
	'update' => array(
		'ansi' => '
			UPDATE "users"
			SET "name" = ?, "company" = ?, "vatid" = ?,
				"salutation" = ?, "title" = ?, "firstname" = ?, "lastname" = ?,
				"address1" = ?, "address2" = ?, "address3" = ?, "postal" = ?,
				"city" = ?, "state" = ?, "countryid" = ?, "langid" = ?,
				"telephone" = ?, "telefax" = ?, "website" = ?, "email" = ?,
				"label" = ?, "birthday" = ?, "status" = ?, "vdate" = ?,
				"password" = ?, "updated_at" = ?, "editor" = ?
			WHERE "id" = ?
		',
	),
	'search' => array(
		'ansi' => '
			SELECT DISTINCT lvu."id" AS "customer.id",
				lvu."label" AS "customer.label", lvu."name" as "customer.code",
				lvu."company" AS "customer.company", lvu."vatid" AS "customer.vatid",
				lvu."salutation" AS "customer.salutation", lvu."title" AS "customer.title",
				lvu."firstname" AS "customer.firstname", lvu."lastname" AS "customer.lastname",
				lvu."address1" AS "customer.address1", lvu."address2" AS "customer.address2",
				lvu."address3" AS "customer.address3", lvu."postal" AS "customer.postal",
				lvu."city" AS "customer.city", lvu."state" AS "customer.state",
				lvu."countryid" AS "customer.countryid", lvu."langid" AS "customer.langid",
				lvu."telephone" AS "customer.telephone", lvu."email" AS "customer.email",
				lvu."telefax" AS "customer.telefax", lvu."website" AS "customer.website",
				lvu."birthday" AS "customer.birthday", lvu."status" AS "customer.status",
				lvu."vdate" AS "customer.dateverified", lvu."password" AS "customer.password",
				lvu."created_at" AS "customer.ctime", lvu."updated_at" AS "customer.mtime",
				lvu."editor" AS "customer.editor"
			FROM "users" AS lvu
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
);