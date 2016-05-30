<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014
 */

return array(
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
			INSERT INTO "users_list"( "parentid", "siteid", "typeid", "domain", "refid", "start", "end",
			"config", "pos", "status", "mtime", "editor", "ctime" )
			VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )
		',
	),
	'update' => array(
		'ansi' => '
			UPDATE "users_list"
			SET "parentid"=?, "siteid" = ?, "typeid" = ?, "domain" = ?, "refid" = ?, "start" = ?, "end" = ?,
				"config" = ?, "pos" = ?, "status" = ?, "mtime" = ?, "editor" = ?
			WHERE "id" = ?
		',
	),
	'updatepos' => array(
		'ansi' => '
			UPDATE "users_list"
				SET "pos" = ?, "mtime" = ?, "editor" = ?
			WHERE "id" = ?
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
);
