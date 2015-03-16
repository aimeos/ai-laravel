<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014
 */

return array(
	'item' => array(
		'aggregate' => '
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
		'getposmax' => '
			SELECT MAX( "pos" ) AS pos
			FROM "users_list"
			WHERE "siteid" = ?
				AND "parentid" = ?
				AND "typeid" = ?
				AND "domain" = ?
		',
		'insert' => '
			INSERT INTO "users_list"( "parentid", "siteid", "typeid", "domain", "refid", "start", "end",
			"config", "pos", "status", "mtime", "editor", "ctime" )
			VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )
		',
		'update' => '
			UPDATE "users_list"
			SET "parentid"=?, "siteid" = ?, "typeid" = ?, "domain" = ?, "refid" = ?, "start" = ?, "end" = ?,
				"config" = ?, "pos" = ?, "status" = ?, "mtime" = ?, "editor" = ?
			WHERE "id" = ?
		',
		'updatepos' => '
			UPDATE "users_list"
				SET "pos" = ?, "mtime" = ?, "editor" = ?
			WHERE "id" = ?
		',
		'delete' => '
			DELETE FROM "users_list"
			WHERE :cond AND siteid = ?
		',
		'move' => '
			UPDATE "users_list"
				SET "pos" = "pos" + ?, "mtime" = ?, "editor" = ?
			WHERE "siteid" = ?
				AND "parentid" = ?
				AND "typeid" = ?
				AND "domain" = ?
				AND "pos" >= ?
		',
		'search' => '
			SELECT lvuli."id", lvuli."siteid", lvuli."parentid", lvuli."typeid", lvuli."domain",
				lvuli."refid", lvuli."start", lvuli."end", lvuli."config", lvuli."pos",
				lvuli."status", lvuli."mtime", lvuli."editor", lvuli."ctime"
			FROM "users_list" AS lvuli
			:joins
			WHERE :cond
			/*-orderby*/ ORDER BY :order /*orderby-*/
			LIMIT :size OFFSET :start
		',
		'count' => '
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
);
