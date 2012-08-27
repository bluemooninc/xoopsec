# Event Guide Module for XOOPS
# $Id: mysql.sql,v 1.9 2011-04-16 06:48:15 nobu Exp $

#
# Table structure for table `eguide`
#

CREATE TABLE eguide (
  eid int(8) unsigned NOT NULL auto_increment,
  uid int(5) NOT NULL default '0',
  title varchar(255) default NULL,
  cdate int(10) NOT NULL default '0',
  edate int(10) NOT NULL default '0',
  ldate int(10) NOT NULL default '0',
  mdate int(10) NOT NULL default '0',
  expire int(10) NOT NULL default '0',
  style tinyint(1) NOT NULL default '0',
  status tinyint(1) NOT NULL default '0',
  summary text NOT NULL,
  body    text NOT NULL,
  counter int(8) unsigned NOT NULL default '0',
  topicid int(8) unsigned NOT NULL default '1',
  uploadimage1 varchar(255) default NULL,
  uploadimage2 varchar(255) default NULL,
  uploadimage3 varchar(255) default NULL,
  PRIMARY KEY  (eid)
);

#
# Table structure for table `eguide_category`
#

CREATE TABLE eguide_category (
  catid    integer NOT NULL auto_increment,
  catname  varchar(40) NOT NULL,
  catimg   varchar(255) NOT NULL default '',
  catdesc  text,
  catpri   integer NOT NULL default '0',
  weight   integer NOT NULL default '0',
  PRIMARY KEY  (catid)
);

# --------------------------------------------------------

INSERT INTO eguide_category(catid,catname,catdesc) VALUES(1, '', 'Default category (you can edit this)'); 
# -- Default Category (Noname)

#
# Table structure for table `eguide_extent`
#

CREATE TABLE eguide_extent (
  exid    integer NOT NULL auto_increment,
  eidref  integer NOT NULL,
  exdate  integer NOT NULL,
  expersons  integer,
  reserved int(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (exid)
);

#
# Table structure for table `eguide_opt`
#

CREATE TABLE eguide_opt (
  eid int(8) NOT NULL,
  reservation tinyint(1),
  strict tinyint(1),
  autoaccept tinyint(1),
  notify  tinyint(1),
  persons int(8) unsigned NOT NULL default '0',
  reserved int(8) unsigned NOT NULL default '0',
  closetime  integer NOT NULL default '0',
  optfield text,
  optvars text,
  PRIMARY KEY  (eid)
);

#
# Table structure for table `eguide_reserv`
#

CREATE TABLE eguide_reserv (
  rvid int(8) unsigned NOT NULL auto_increment,
  eid  int(8) NOT NULL,
  exid int(8) NOT NULL,
  uid  int(8),
  rdate integer,
  email varchar(60),
  info text,
  status tinyint(1),
  confirm varchar(8),
  PRIMARY KEY  (rvid)
);
