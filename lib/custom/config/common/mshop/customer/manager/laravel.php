<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */

return array(
	'item' => array(
		'delete' => '
			DELETE FROM "users"
			WHERE :cond
		',
		'insert' => '
			INSERT INTO "users" (
				"name", "email", "company", "vatid", "salutation", "title",
				"firstname", "lastname", "address1", "address2", "address3",
				"postal", "city", "state", "countryid", "langid", "telephone",
				"telefax", "website", "birthday", "status",
				"vdate", "password", "updated_at", "editor", "created_at"
			) VALUES (
				?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
			)
		',
		'update' => '
			UPDATE "users"
			SET "name" = ?, "email" = ?, "company" = ?, "vatid" = ?,
				"salutation" = ?, "title" = ?, "firstname" = ?, "lastname" = ?,
				"address1" = ?, "address2" = ?, "address3" = ?, "postal" = ?,
				"city" = ?, "state" = ?, "countryid" = ?, "langid" = ?,
				"telephone" = ?, "telefax" = ?, "website" = ?,
				"birthday" = ?, "status" = ?, "vdate" = ?, "password" = ?,
				"updated_at" = ?, "editor" = ?
			WHERE "id" = ?
		',
		'search' => '
			SELECT DISTINCT lvu."id", lvu."name" as "label", lvu."email" as "code",
				lvu."company", lvu."vatid", lvu."salutation", lvu."title",
				lvu."firstname", lvu."lastname", lvu."address1",
				lvu."address2", lvu."address3", lvu."postal", lvu."city",
				lvu."state", lvu."countryid", lvu."langid",
				lvu."telephone", lvu."email", lvu."telefax", lvu."website",
				lvu."birthday", lvu."status", lvu."vdate", lvu."password",
				lvu."created_at" AS "ctime", lvu."updated_at" AS "mtime", lvu."editor"
			FROM "users" AS lvu
			:joins
			WHERE :cond
			/*-orderby*/ ORDER BY :order /*orderby-*/
			LIMIT :size OFFSET :start
		',
		'count' => '
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
);