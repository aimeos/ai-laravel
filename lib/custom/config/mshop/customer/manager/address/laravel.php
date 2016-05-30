<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */

return array(
	'delete' => array(
		'ansi' => '
			DELETE FROM "users_address"
			WHERE :cond
		',
	),
	'insert' => array(
		'ansi' => '
			INSERT INTO "users_address" (
				"siteid", "parentid", "company", "vatid", "salutation", "title",
				"firstname", "lastname", "address1", "address2", "address3",
				"postal", "city", "state", "countryid", "langid", "telephone",
				"email", "telefax", "website", "flag", "pos", "mtime",
				"editor", "ctime"
			) VALUES (
				?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
			)
		',
	),
	'update' => array(
		'ansi' => '
			UPDATE "users_address"
			SET "siteid" = ?, "parentid" = ?, "company" = ?, "vatid" = ?, "salutation" = ?,
				"title" = ?, "firstname" = ?, "lastname" = ?, "address1" = ?,
				"address2" = ?, "address3" = ?, "postal" = ?, "city" = ?,
				"state" = ?, "countryid" = ?, "langid" = ?, "telephone" = ?,
				"email" = ?, "telefax" = ?, "website" = ?, "flag" = ?,
				"pos" = ?, "mtime" = ?, "editor" = ?
			WHERE "id" = ?
		',
	),
	'search' => array(
		'ansi' => '
			SELECT DISTINCT lvuad."id" AS "customer.address.id", lvuad."parentid" AS "customer.address.parentid",
				lvuad."company" AS "customer.address.company", lvuad."vatid" AS "customer.address.vatid",
				lvuad."salutation" AS "customer.address.salutation", lvuad."title" AS "customer.address.title",
				lvuad."firstname" AS "customer.address.firstname", lvuad."lastname" AS "customer.address.lastname",
				lvuad."address1" AS "customer.address.address1", lvuad."address2" AS "customer.address.address2",
				lvuad."address3" AS "customer.address.address3", lvuad."postal" AS "customer.address.postal",
				lvuad."city" AS "customer.address.city", lvuad."state" AS "customer.address.state",
				lvuad."countryid" AS "customer.address.countryid", lvuad."langid" AS "customer.address.languageid",
				lvuad."telephone" AS "customer.address.telephone", lvuad."email" AS "customer.address.email",
				lvuad."telefax" AS "customer.address.telefax", lvuad."website" AS "customer.address.website",
				lvuad."flag" AS "customer.address.flag", lvuad."pos" AS "customer.address.position",
				lvuad."mtime" AS "customer.address.mtime", lvuad."editor" AS "customer.address.editor",
				lvuad."ctime" AS "customer.address.ctime"
			FROM "users_address" AS lvuad
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
);