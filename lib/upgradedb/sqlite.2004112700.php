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

$DB->BeginTrans();
$DB->Execute("
    CREATE TABLE uiconfig (
	id integer PRIMARY KEY,
	section varchar(255) NOT NULL DEFAULT '',
	var varchar(255) NOT NULL DEFAULT '',
        value text NOT NULL DEFAULT '',
	description text NOT NULL DEFAULT '',
	disabled smallint NOT NULL DEFAULT 0,
	UNIQUE(section, var)
    )
");
$DB->Execute("UPDATE dbinfo SET keyvalue = '2004112700' WHERE keytype = 'dbversion'");
$DB->CommitTrans();

?>