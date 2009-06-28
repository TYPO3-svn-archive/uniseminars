#
# Table structure for table 'tx_uniseminars_courses'
#
CREATE TABLE tx_uniseminars_courses (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	title tinytext NOT NULL,
	type int(11) DEFAULT '0' NOT NULL,
	department blob NOT NULL,
	coursetype int(11) DEFAULT '0' NOT NULL,
	semester int(11) DEFAULT '0' NOT NULL,
	year tinytext NOT NULL,
	lecturer tinytext NOT NULL,
	credits double(11,2) DEFAULT '0.00' NOT NULL,
	objective text NOT NULL,
	targets text NOT NULL,
	prerequisites text NOT NULL,
	reading text NOT NULL,
	datelocation tinytext NOT NULL,
	start int(11) DEFAULT '0' NOT NULL,
	grading tinytext NOT NULL,
	examdate tinytext NOT NULL,
	closed int(11) DEFAULT '0' NOT NULL,
	contact tinytext NOT NULL,
	email tinytext NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_uniseminars_department'
#
CREATE TABLE tx_uniseminars_department (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	name tinytext NOT NULL,
	description tinytext NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# Table structure for table 'tx_uniseminars_guests'
#
CREATE TABLE tx_uniseminars_guests (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,
    courseid int(11) DEFAULT '0' NOT NULL,
    firstname tinytext NOT NULL,
    lastname tinytext NOT NULL,
    email tinytext NOT NULL,
    subject tinytext NOT NULL,
    type int(11) DEFAULT '0' NOT NULL,
    semester int(11) DEFAULT '0' NOT NULL,
	year tinytext NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);