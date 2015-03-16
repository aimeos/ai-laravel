<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */

return array(
	'item' => array(
		'delete' => '
			DELETE FROM "users_address"
			WHERE :cond
		',
		'insert' => '
			INSERT INTO "users_address" (
				"siteid", "refid", "company", "vatid", "salutation", "title",
				"firstname", "lastname", "address1", "address2", "address3",
				"postal", "city", "state", "countryid", "langid", "telephone",
				"email", "telefax", "website", "flag", "pos", "mtime",
				"editor", "ctime"
			) VALUES (
				?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
			)
		',
		'update' => '
			UPDATE "users_address"
			SET "siteid" = ?, "refid" = ?, "company" = ?, "vatid" = ?, "salutation" = ?,
				"title" = ?, "firstname" = ?, "lastname" = ?, "address1" = ?,
				"address2" = ?, "address3" = ?, "postal" = ?, "city" = ?,
				"state" = ?, "countryid" = ?, "langid" = ?, "telephone" = ?,
				"email" = ?, "telefax" = ?, "website" = ?, "flag" = ?,
				"pos" = ?, "mtime" = ?, "editor" = ?
			WHERE "id" = ?
		',
		'search' => '
			SELECT DISTINCT lvuad."id", lvuad."refid",
				lvuad."company", lvuad."vatid", lvuad."salutation", lvuad."title",
				lvuad."firstname", lvuad."lastname", lvuad."address1",
				lvuad."address2", lvuad."address3", lvuad."postal",
				lvuad."city", lvuad."state", lvuad."countryid",
				lvuad."langid", lvuad."telephone", lvuad."email",
				lvuad."telefax", lvuad."website", lvuad."flag",
				lvuad."pos", lvuad."mtime", lvuad."editor", lvuad."ctime"
			FROM "users_address" AS lvuad
			:joins
			WHERE :cond
			/*-orderby*/ ORDER BY :order /*orderby-*/
			LIMIT :size OFFSET :start
		',
		'count' => '
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
);