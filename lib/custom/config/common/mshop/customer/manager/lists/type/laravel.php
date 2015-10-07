<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */

return array(
	'item' => array(
		'insert' => '
			INSERT INTO "users_list_type"( "siteid", "code", "domain", "label", "status",
				"mtime", "editor", "ctime" )
			VALUES ( ?, ?, ?, ?, ?, ?, ?, ? )
		',
		'update' => '
			UPDATE "users_list_type"
			SET "siteid"=?, "code" = ?, "domain" = ?, "label" = ?, "status" = ?, "mtime" = ?, "editor" = ?
			WHERE "id" = ?
		',
		'delete' => '
			DELETE FROM "users_list_type"
			WHERE :cond AND siteid = ?
		',
		'search' => '
			SELECT lvulity."id", lvulity."siteid", lvulity."code",
				lvulity."domain", lvulity."label", lvulity."status",
				lvulity."mtime", lvulity."editor", lvulity."ctime"
			FROM "users_list_type" AS lvulity
			:joins
			WHERE
				:cond
			/*-orderby*/ ORDER BY :order /*orderby-*/
			LIMIT :size OFFSET :start
		',
		'count' => '
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
);
