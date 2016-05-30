<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */

return array(
	'insert' => array(
		'ansi' => '
			INSERT INTO "users_list_type"( "siteid", "code", "domain", "label", "status",
				"mtime", "editor", "ctime" )
			VALUES ( ?, ?, ?, ?, ?, ?, ?, ? )
		',
	),
	'update' => array(
		'ansi' => '
			UPDATE "users_list_type"
			SET "siteid"=?, "code" = ?, "domain" = ?, "label" = ?, "status" = ?, "mtime" = ?, "editor" = ?
			WHERE "id" = ?
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
);
