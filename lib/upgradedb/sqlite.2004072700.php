<?php

/*
 * LMS version 1.6-cvs
 *
 *  (C) Copyright 2001-2006 LMS Developers
 *
 *  Please, see the doc/AUTHORS for more information about authors!
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License Version 2 as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 *  USA.
 *
 *  $Id$
 */

/* included 2004071400, 2004072100, 2004072700 upgrades */

$DB->Execute("BEGIN");
$DB->Execute("CREATE TEMP TABLE users_t AS SELECT * FROM users");
$DB->Execute("DROP TABLE users");
$DB->Execute("CREATE TABLE users (
	id integer PRIMARY KEY,
	lastname varchar(255)	DEFAULT '' NOT NULL,
	name varchar(255)	DEFAULT '' NOT NULL,
	status smallint 	DEFAULT 0 NOT NULL,
	email varchar(255) 	DEFAULT '' NOT NULL,
	phone1 varchar(255) 	DEFAULT '' NOT NULL,
	phone2 varchar(255) 	DEFAULT '' NOT NULL,
	phone3 varchar(255) 	DEFAULT '' NOT NULL,
	gguin integer 		DEFAULT 0 NOT NULL,
	address varchar(255) 	DEFAULT '' NOT NULL,
	zip varchar(6) 		DEFAULT '' NOT NULL,
	city varchar(32) 	DEFAULT '' NOT NULL,
	nip varchar(16) 	DEFAULT '' NOT NULL,
	pesel varchar(11) 	DEFAULT '' NOT NULL,
	info text		DEFAULT '' NOT NULL,
	serviceaddr text	DEFAULT '' NOT NULL,
	creationdate integer 	DEFAULT 0 NOT NULL,
	moddate integer 	DEFAULT 0 NOT NULL,
	creatorid integer 	DEFAULT 0 NOT NULL,
	modid integer 		DEFAULT 0 NOT NULL,
	deleted smallint 	DEFAULT 0 NOT NULL,
	message text		DEFAULT '' NOT NULL
)");
$DB->Execute("INSERT INTO users (id, lastname, name, status, email, phone1, phone2, phone3, gguin, address, zip, city, nip, pesel, info, creationdate, moddate, creatorid, modid, deleted, message) SELECT id, lastname, name, status, email, phone1, phone2, phone3, gguin, address, zip, city, nip, pesel, info, creationdate, moddate, creatorid, modid, deleted, message FROM users_t");
$DB->Execute("DROP TABLE users_t");

$DB->Execute("CREATE TEMP TABLE stats_t AS SELECT * FROM stats");
$DB->Execute("DROP TABLE stats");
$DB->Execute("CREATE TABLE stats (
	nodeid integer 		DEFAULT 0 NOT NULL,
	dt integer 		DEFAULT 0 NOT NULL,
	upload bigint 		DEFAULT 0,
	download bigint 	DEFAULT 0,
	PRIMARY KEY (nodeid, dt)
)");
$DB->Execute("INSERT INTO stats(nodeid, dt, upload, download) SELECT nodeid, dt, upload, download FROM stats_t");
$DB->Execute("DROP TABLE stats_t");

$DB->Execute("CREATE TEMP TABLE rttickets_t AS SELECT * FROM rttickets");
$DB->Execute("DROP TABLE rttickets");
$DB->Execute("CREATE TABLE rttickets (
  id integer 		PRIMARY KEY,  
  queueid integer 	DEFAULT 0 NOT NULL,
  requestor varchar(255) DEFAULT '' NOT NULL,
  subject varchar(255) 	DEFAULT '' NOT NULL,
  state smallint 	DEFAULT 0 NOT NULL,
  owner integer 	DEFAULT 0 NOT NULL,
  userid integer	DEFAULT 0 NOT NULL,
  createtime integer 	DEFAULT 0 NOT NULL,
  resolvetime integer 	DEFAULT 0 NOT NULL
)");
$DB->Execute("INSERT INTO rttickets(id, queueid, requestor, subject, state, owner, userid, createtime) SELECT id, queueid, requestor, subject, state, owner, userid, createtime FROM rttickets_t");
$DB->Execute("DROP TABLE rttickets_t");

$DB->Execute("UPDATE dbinfo SET keyvalue = '2004072700' WHERE keytype = 'dbversion'");
$DB->Execute("COMMIT");

?>