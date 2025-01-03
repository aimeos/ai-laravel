<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2025
 */


return array(
	'manager' => array(
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
					SELECT :columns, mcus."superuser" AS ".super"
					FROM "users" mcus
					:joins
					WHERE :cond
					GROUP BY :group, mcus."superuser"
					ORDER BY :order
					OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
				',
				'mysql' => '
					SELECT :columns, mcus."superuser" AS ".super"
					FROM "users" mcus
					:joins
					WHERE :cond
					GROUP BY :group
					ORDER BY :order
					LIMIT :size OFFSET :start
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
