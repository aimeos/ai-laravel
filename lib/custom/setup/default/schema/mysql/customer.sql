--
-- Customer database definition
--
-- License LGPLv3, http://opensource.org/licenses/LGPL-3.0
-- Copyright (c) Aimeos (aimeos.org), 2015
--


SET SESSION sql_mode='ANSI';



--
-- Table structure for "users" created by Laravel DBAL
--
CREATE TABLE "users" (
	"id" int(10) unsigned NOT NULL AUTO_INCREMENT,
	"label" varchar(255) NOT NULL,
	"name" varchar(255) NOT NULL,
	"email" varchar(255) NOT NULL,
	"password" varchar(60) NOT NULL,
	"remember_token" varchar(100) DEFAULT NULL,
	"created_at" timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	"updated_at" timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	"salutation" varchar(8) NOT NULL,
	"company" varchar(100) NOT NULL,
	"vatid" varchar(32) NOT NULL,
	"title" varchar(64) NOT NULL,
	"firstname" varchar(64) NOT NULL,
	"lastname" varchar(64) NOT NULL,
	"address1" varchar(255) NOT NULL,
	"address2" varchar(255) NOT NULL,
	"address3" varchar(255) NOT NULL,
	"postal" varchar(16) NOT NULL,
	"city" varchar(255) NOT NULL,
	"state" varchar(255) NOT NULL,
	"langid" varchar(5) DEFAULT NULL,
	"countryid" char(2) DEFAULT NULL,
	"telephone" varchar(32) NOT NULL,
	"telefax" varchar(255) NOT NULL,
	"website" varchar(255) NOT NULL,
	"birthday" date DEFAULT NULL,
	"status" smallint(6) NOT NULL DEFAULT '1',
	"vdate" date DEFAULT NULL,
	"editor" varchar(255) NOT NULL,
	PRIMARY KEY ("id"),
	UNIQUE KEY "users_email_unique" ("email"),
	KEY "users_langid_index" ("langid"),
	KEY "users_status_lastname_firstname_index" ("status","lastname","firstname"),
	KEY "users_status_address1_address2_index" ("status","address1","address2"),
	KEY "users_lastname_index" ("lastname"),
	KEY "users_address1_index" ("address1"),
	KEY "users_city_index" ("city"),
	KEY "users_postal_index" ("postal")
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table "users_address"
--
CREATE TABLE "users_address" (
	-- Unique address id
	"id" INTEGER NOT NULL AUTO_INCREMENT,
	-- site id, not used
	"siteid" INTEGER NULL,
	-- reference id for customer
	"refid" INTEGER UNSIGNED NOT NULL,
	-- company name
	"company" VARCHAR(100) NOT NULL,
	-- vatid
	"vatid" VARCHAR(32) NOT NULL,
	-- customer/supplier categorization
	"salutation" VARCHAR(8) NOT NULL,
	-- title of the customer/supplier
	"title" VARCHAR(64) NOT NULL,
	-- first name of customer/supplier
	"firstname" VARCHAR(64) NOT NULL,
	-- last name of customer/supplier
	"lastname" VARCHAR(64) NOT NULL,
	-- Depending on country, e.g. house name
	"address1" VARCHAR(255) NOT NULL,
	-- Depending on country, e.g. street
	"address2" VARCHAR(255) NOT NULL,
	-- Depending on country, e.g. county/suburb
	"address3" VARCHAR(255) NOT NULL,
	-- postal code of customer/supplier
	"postal" VARCHAR(16) NOT NULL,
	-- city name of customer/supplier
	"city" VARCHAR(255) NOT NULL,
	-- state name of customer/supplier
	"state" VARCHAR(255) NOT NULL,
	-- language id
	"langid" VARCHAR(5) NULL,
	-- Country id the customer/supplier is living in
	"countryid" CHAR(2) NULL,
	-- Telephone number of the customer/supplier
	"telephone" VARCHAR(32) NOT NULL,
	-- Email of the customer/supplier
	"email" VARCHAR(255) NOT NULL,
	-- Telefax of the customer/supplier
	"telefax" VARCHAR(255) NOT NULL,
	-- Website of the customer/supplier
	"website" VARCHAR(255) NOT NULL,
	-- Generic flag
	"flag" INTEGER NOT NULL,
	-- Position
	"pos" SMALLINT NOT NULL default 0,
	-- Date of last modification of this database entry
	"mtime" DATETIME NOT NULL,
	-- Date of creation of this database entry
	"ctime" DATETIME NOT NULL,
	-- Editor who modified this entry at last
	"editor" VARCHAR(255) NOT NULL,
CONSTRAINT "pk_lvuad_id"
	PRIMARY KEY ("id")
) ENGINE=InnoDB CHARACTER SET = utf8;

CREATE INDEX "idx_lvuad_refid" ON "users_address" ("refid");

CREATE INDEX "idx_lvuad_ln_fn" ON "users_address" ("lastname", "firstname");

CREATE INDEX "idx_lvuad_ad1_ad2" ON "users_address" ("address1", "address2");

CREATE INDEX "idx_lvuad_post_ci" ON "users_address" ("postal", "city");

CREATE INDEX "idx_lvuad_city" ON "users_address" ("city");


--
-- Table structure for table "users_list_type"
--

CREATE TABLE "users_list_type" (
	-- Unique id
	"id" INTEGER NOT NULL AUTO_INCREMENT,
	-- site id
	"siteid" INTEGER NULL,
	-- domain
	"domain" VARCHAR(32) NOT NULL,
	-- code
	"code" VARCHAR(32) NOT NULL COLLATE utf8_bin,
	-- Name of the list type
	"label" VARCHAR(255) NOT NULL,
	-- Status (0=disabled, 1=enabled, >1 for special)
	"status" SMALLINT NOT NULL,
	-- Date of last modification of this database entry
	"mtime" DATETIME NOT NULL,
	-- Date of creation of this database entry
	"ctime" DATETIME NOT NULL,
	-- Editor who modified this entry at last
	"editor" VARCHAR(255) NOT NULL,
CONSTRAINT "pk_lvulity_id"
	PRIMARY KEY ("id"),
CONSTRAINT "unq_lvulity_sid_dom_code"
	UNIQUE ("siteid", "domain", "code")
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX "idx_lvulity_sid_status" ON "users_list_type" ("siteid", "status");

CREATE INDEX "idx_lvulity_sid_label" ON "users_list_type" ("siteid", "label");

CREATE INDEX "idx_lvulity_sid_code" ON "users_list_type" ("siteid", "code");


--
-- Table structure for table "users_list"
--

CREATE TABLE "users_list" (
	-- Unique list id
	"id" INTEGER NOT NULL AUTO_INCREMENT,
	-- customer id (parent id)
	"parentid" INTEGER UNSIGNED NOT NULL,
	-- site id
	"siteid" INTEGER NULL,
	-- typeid
	"typeid" INTEGER NOT NULL,
	-- domain (e.g.: text, media)
	"domain" VARCHAR(32) NOT NULL,
	-- Reference of the object in given domain
	"refid" VARCHAR(32) NOT NULL,
	-- Valid from
	"start" DATETIME DEFAULT NULL,
	-- Valid until
	"end" DATETIME DEFAULT NULL,
	-- Configuration
	"config" TEXT NOT NULL,
	-- Precedence rating
	"pos" INTEGER NOT NULL,
	-- Status (0=disabled, 1=enabled, >1 for special)
	"status" SMALLINT NOT NULL,
	-- Date of last modification of this database entry
	"mtime" DATETIME NOT NULL,
	-- Date of creation of this database entry
	"ctime" DATETIME NOT NULL,
	-- Editor who modified this entry at last
	"editor" VARCHAR(255) NOT NULL,
CONSTRAINT "pk_lvuli_id"
	PRIMARY KEY ("id"),
CONSTRAINT "unq_lvuli_sid_dm_rid_tid_pid"
	UNIQUE ("siteid", "domain", "refid", "typeid", "parentid"),
CONSTRAINT "fk_lvuli_typeid"
	FOREIGN KEY ( "typeid" )
	REFERENCES "users_list_type" ("id")
	ON DELETE CASCADE
	ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX "idx_lvuli_sid_stat_start_end" ON "users_list" ("siteid", "status", "start", "end");

CREATE INDEX "idx_lvuli_pid_sid_rid_dom_tid" ON "users_list" ("parentid", "siteid", "refid", "domain", "typeid");

CREATE INDEX "idx_lvuli_pid_sid_start" ON "users_list" ("parentid", "siteid", "start");

CREATE INDEX "idx_lvuli_pid_sid_end" ON "users_list" ("parentid", "siteid", "end");

CREATE INDEX "idx_lvuli_pid_sid_pos" ON "users_list" ("parentid", "siteid", "pos");

CREATE INDEX "idx_lvuli_pid_sid_tid" ON "users_list" ("parentid", "siteid", "typeid");
