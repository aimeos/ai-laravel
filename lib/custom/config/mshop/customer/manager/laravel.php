<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2016
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
				"telefax", "website", "email", "longitude", "latitude", "label",
				"birthday", "status", "vdate", "password",
				"updated_at", "editor", "created_at"
			) VALUES (
				?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
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
				"longitude" = ?, "latitude" = ?, "label" = ?, "birthday" = ?,
				"status" = ?, "vdate" = ?, "password" = ?, "updated_at" = ?, "editor" = ?
			WHERE "id" = ?
		',
	),
	'search' => array(
		'ansi' => '
			SELECT lvu."id" AS "customer.id",
				lvu."label" AS "customer.label", lvu."name" AS "customer.code",
				lvu."company" AS "customer.company", lvu."vatid" AS "customer.vatid",
				lvu."salutation" AS "customer.salutation", lvu."title" AS "customer.title",
				lvu."firstname" AS "customer.firstname", lvu."lastname" AS "customer.lastname",
				lvu."address1" AS "customer.address1", lvu."address2" AS "customer.address2",
				lvu."address3" AS "customer.address3", lvu."postal" AS "customer.postal",
				lvu."city" AS "customer.city", lvu."state" AS "customer.state",
				lvu."countryid" AS "customer.countryid", lvu."langid" AS "customer.langid",
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
			GROUP BY lvu."id", lvu."label", lvu."name", lvu."company", lvu."vatid",
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
);