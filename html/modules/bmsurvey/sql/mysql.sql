-- # $Id: mysql.sql,v 1.1.1.1 2005/08/10 12:14:04 yoshis Exp $
-- #
-- # Table structures for phpESP
-- # Written by James Flemer
-- # For eGrad2000.com
-- # <jflemer@alum.rpi.edu>

-- # Use this script to create and populate the phpESP tables. This
-- # should be executed _after_ the mysql_create.sql script. If you are
-- # upgrading an existing phpESP database, please read "docs/UPDATING"
-- # before doing anything else.
-- # 
-- # To execute this script via the mysql CLI, run:
-- #   mysql -u root -p phpesp < mysql_populate.sql
-- # If you used a database name other than "phpesp", use it in place
-- # of "phpesp" in the command line.
-- #
-- ...............................................................
-- ....................... USERS/GROUPS ..........................
-- ...............................................................

-- # realm (group) table
CREATE TABLE bmsurvey_realm (
	name		CHAR(25) NOT NULL,
	title		CHAR(64) NOT NULL,
	changed		int(10) unsigned NOT NULL,
	PRIMARY KEY(name)
) ENGINE=MyISAM;

-- # table of respondents (people who enter data / take forms)
CREATE TABLE bmsurvey_respondent (
	uid	mediumint(8) NOT NULL,
	password	CHAR(41) NOT NULL,
	auth		CHAR(16) NOT NULL DEFAULT 'BASIC',
	realm		CHAR(16) NOT NULL,
	fname		CHAR(16),
	lname		CHAR(24),
	email		CHAR(64),
	disabled	ENUM('Y','N') NOT NULL DEFAULT 'N',
	form_id	INT UNSIGNED NOT NULL,
	response_id	INT UNSIGNED NOT NULL,
	changed		int(10) unsigned NOT NULL,
	expiration	int(10) unsigned NOT NULL,
	PRIMARY KEY (uid, realm)
) ENGINE=MyISAM;

-- # table of designers (people who create forms / forms)
CREATE TABLE bmsurvey_designer (
	uid	mediumint(8) NOT NULL,
	password	CHAR(41) NOT NULL,
	auth		CHAR(16) NOT NULL DEFAULT 'BASIC',
	realm		CHAR(16) NOT NULL,
	fname		CHAR(16),
	lname		CHAR(24),
	email		CHAR(64),
	pdesign		ENUM('Y','N') NOT NULL DEFAULT 'Y',
	pstatus		ENUM('Y','N') NOT NULL DEFAULT 'N',
	pdata		ENUM('Y','N') NOT NULL DEFAULT 'N',
	pall		ENUM('Y','N') NOT NULL DEFAULT 'N',
	pgroup		ENUM('Y','N') NOT NULL DEFAULT 'N',
	puser		ENUM('Y','N') NOT NULL DEFAULT 'N',
	disabled	ENUM('Y','N') NOT NULL DEFAULT 'N',
	changed		int(10) unsigned NOT NULL,
	expiration	int(10) unsigned NOT NULL,
	PRIMARY KEY(uid, realm)
) ENGINE=MyISAM;

-- # create the _special_ superuser group
-- # members of this group have superuser status
INSERT INTO bmsurvey_realm ( name, title )
	VALUES ( 'superuser', 'ESP System Administrators' ),
		( 'auto', 'Self added users' );

-- # default root account
INSERT INTO bmsurvey_designer (uid, password, fname, lname, realm, pdesign, pstatus, pdata, pall, pgroup, puser, disabled)
	VALUES ('root', PASSWORD('esp'), 'ESP', 'Superuser', 'superuser', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N');


-- ...............................................................
-- ..................... FORMS ...........................
-- ...............................................................

-- # table of different forms available
CREATE TABLE bmsurvey_form (
	id			INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name		CHAR(64) NOT NULL,
	owner int(5) unsigned NOT NULL default '0',
	realm		CHAR(64) NOT NULL,
	respondents		CHAR(64) NOT NULL,
	public		ENUM('Y','N') NOT NULL DEFAULT 'Y',
	status		INT UNSIGNED NOT NULL DEFAULT '0',
	title		CHAR(255) NOT NULL,
	email		CHAR(64),
	from_option TINYINT( 3 ) UNSIGNED DEFAULT '0' NOT NULL,
	subtitle	TEXT,
	info		TEXT,
	theme		CHAR(64),
	thanks_page	CHAR(255),
	thank_head	CHAR(255),
	thank_body	TEXT,
	changed int(10) unsigned NOT NULL,
  published	 int(10) unsigned NOT NULL,
  expired	 int(10) unsigned NOT NULL,
	response_id	INT UNSIGNED NOT NULL,
	PRIMARY KEY (id),
	UNIQUE(name)
) ENGINE=MyISAM;

-- # types of questions
CREATE TABLE bmsurvey_question_type (
	id				INT UNSIGNED NOT NULL AUTO_INCREMENT,
	type			CHAR(32) NOT NULL,
	has_choices		ENUM('Y','N') NOT NULL,
	response_table	CHAR(32) NOT NULL,
	PRIMARY KEY (id)
) ENGINE=MyISAM;

-- # table of the questions for all the forms
CREATE TABLE bmsurvey_question (
	id			INT UNSIGNED NOT NULL AUTO_INCREMENT,
	form_id	INT UNSIGNED NOT NULL,
	name		CHAR(30) NOT NULL,
	type_id		INT UNSIGNED NOT NULL,
	result_id	INT UNSIGNED,
	length		INT NOT NULL DEFAULT 0,
	precise		INT NOT NULL DEFAULT 0,
	position	INT UNSIGNED NOT NULL,
	content		TEXT NOT NULL,
	required	ENUM('Y','N') NOT NULL DEFAULT 'N',
	deleted		ENUM('Y','N') NOT NULL DEFAULT 'N',
	public		ENUM('Y','N') NOT NULL DEFAULT 'Y',
	PRIMARY KEY (id)
) ENGINE=MyISAM;

-- # table of the choices (possible answers) of each question
CREATE TABLE bmsurvey_question_choice (
	id			INT UNSIGNED NOT NULL AUTO_INCREMENT,
	question_id	INT UNSIGNED NOT NULL,
	content		TEXT NOT NULL,
	value		TEXT,
	PRIMARY KEY (id)
) ENGINE=MyISAM;

-- # access control to adding data to a form / form
CREATE TABLE bmsurvey_access (
	id			INT UNSIGNED NOT NULL AUTO_INCREMENT,
	form_id	INT UNSIGNED NOT NULL,
	realm		CHAR(16),
	maxlogin	INT UNSIGNED DEFAULT '0',
        resume		ENUM('Y','N') NOT NULL DEFAULT 'N',
        navigate	ENUM('Y','N') NOT NULL DEFAULT 'N',
	PRIMARY KEY(id)
) ENGINE=MyISAM;

-- ...............................................................
-- ..................... RESPONSE DATA ...........................
-- ...............................................................

-- # this table holds info to distinguish one servey response from another
-- # (plus timestamp, and uid if known)
CREATE TABLE bmsurvey_response (
	id			INT UNSIGNED NOT NULL AUTO_INCREMENT,
	form_id	INT UNSIGNED NOT NULL,
	submitted	int(10) unsigned NOT NULL,
	complete	ENUM('Y','N') NOT NULL DEFAULT 'N',
	uid	mediumint(8),
	PRIMARY KEY (id)
) ENGINE=MyISAM;

-- # answers to boolean questions (yes/no)
CREATE TABLE bmsurvey_response_bool (
	response_id	INT UNSIGNED NOT NULL,
	question_id	INT UNSIGNED NOT NULL,
	choice_id	ENUM('Y','N') NOT NULL,
	PRIMARY KEY(response_id,question_id)
) ENGINE=MyISAM;

-- # answers to single answer questions (radio, boolean, rate) (chose one of n)
CREATE TABLE bmsurvey_response_single (
	response_id	INT UNSIGNED NOT NULL,
	question_id	INT UNSIGNED NOT NULL,
	choice_id	INT UNSIGNED NOT NULL,
	PRIMARY KEY(response_id,question_id)
) ENGINE=MyISAM;

-- # answers to questions where multiple responses are allowed
-- # (checkbox, select multiple)
CREATE TABLE bmsurvey_response_multiple (
	id			INT UNSIGNED NOT NULL AUTO_INCREMENT,
	response_id	INT UNSIGNED NOT NULL,
	question_id	INT UNSIGNED NOT NULL,
	choice_id	INT UNSIGNED NOT NULL,
	PRIMARY KEY(id)
) ENGINE=MyISAM;

-- # answers to rank questions
CREATE TABLE bmsurvey_response_rank (
	response_id	INT UNSIGNED NOT NULL,
	question_id	INT UNSIGNED NOT NULL,
	choice_id	INT UNSIGNED NOT NULL,
	rank		INT NOT NULL,
	PRIMARY KEY(response_id,question_id,choice_id)
) ENGINE=MyISAM;

-- # answers to any fill in the blank or essay question
CREATE TABLE bmsurvey_response_text (
	response_id	INT UNSIGNED NOT NULL,
	question_id INT UNSIGNED NOT NULL,
	response	TEXT,
	PRIMARY KEY (response_id,question_id)
) ENGINE=MyISAM;

-- # answers to any Other: ___ questions
CREATE TABLE bmsurvey_response_other (
	response_id	INT UNSIGNED NOT NULL,
	question_id INT UNSIGNED NOT NULL,
	choice_id	INT UNSIGNED NOT NULL,
	response	TEXT,
	PRIMARY KEY (response_id, question_id, choice_id)
) ENGINE=MyISAM;

-- # answers to any date questions
CREATE TABLE bmsurvey_response_date (
	response_id	INT UNSIGNED NOT NULL,
	question_id INT UNSIGNED NOT NULL,
	response	DATE,
	PRIMARY KEY (response_id,question_id)
) ENGINE=MyISAM;

-- # populate the types of questions
INSERT INTO bmsurvey_question_type VALUES ('1','Yes/No','N','response_bool');
INSERT INTO bmsurvey_question_type VALUES ('2','Text Box','N','response_text');
INSERT INTO bmsurvey_question_type VALUES ('3','Essay Box','N','response_text');
INSERT INTO bmsurvey_question_type VALUES ('4','Radio Buttons','Y','response_single');
INSERT INTO bmsurvey_question_type VALUES ('5','Check Boxes','Y','response_multiple');
INSERT INTO bmsurvey_question_type VALUES ('6','Dropdown Box','Y','response_single');
-- # INSERT INTO bmsurvey_question_type VALUES ('7','Rating','N','response_rank');
-- # INSERT INTO bmsurvey_question_type VALUES ('8','Rate (scale 1..5)','Y','response_rank');
INSERT INTO bmsurvey_question_type VALUES ('9','Date','N','response_date');
INSERT INTO bmsurvey_question_type VALUES ('10','Numeric','N','response_text');
-- # INSERT INTO bmsurvey_question_type VALUES ('40','Attach','N','response_text');
INSERT INTO bmsurvey_question_type VALUES ('99','Page Break','N','');
INSERT INTO bmsurvey_question_type VALUES ('100','Section Text','N','');
