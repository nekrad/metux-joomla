		CREATE TABLE IF NOT EXISTS `#__cbe_gallery` (
			`id` int(100) NOT NULL auto_increment,
			`uid` int(11) NOT NULL default '0',
			`datei` varchar(100) NOT NULL default '',
			`titel` varchar(100) NOT NULL default '',
			`datum` datetime NOT NULL default '0000-00-00 00:00:00',
			`approved` tinyint(4) NOT NULL default '0',
			PRIMARY KEY  (`id`)
		) TYPE=MyISAM;

		CREATE TABLE IF NOT EXISTS `#__cbe_extensions` (
		`id` int(11) NOT NULL auto_increment,
		`extname` varchar(250) NOT NULL,
		`exttitle` varchar(100) NOT NULL,
		`exttype` varchar(50) NOT NULL,
		`author` varchar(100) NOT NULL,
		`hp` varchar(100) NOT NULL,
		`tabid` int(11) NOT NULL,
		PRIMARY KEY  (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

		CREATE TABLE IF NOT EXISTS `#__cbe` (
		  `id` int(11) NOT NULL default '0',
		  `user_id` int(11) NOT NULL default '0',
		  `firstname` VARCHAR( 100 ),
		  `middlename` VARCHAR( 100 ) ,
		  `lastname` VARCHAR( 100 ),
		  `last_ip` VARCHAR( 100 ),
		  `zodiac` VARCHAR( 255 ),
		  `zodiac_c` VARCHAR( 255 ),
		  `hits` int(11) NOT NULL default '0',
		  `avatar` varchar(255) default NULL,
		  `avatarapproved` tinyint(4) default '1',
		  `approved` tinyint(4) NOT NULL default '1',
		  `confirmed` tinyint(4) NOT NULL default '1',
		  `lastupdatedate` datetime NOT NULL default '0000-00-00 00:00:00',
		  `banned` tinyint(4) NOT NULL default '0',
		  `banneddate` datetime default NULL,
		  `bannedby` int(11) default NULL,
		  `bannedreason` mediumtext,	
		  `acceptedterms` tinyint(1) NOT NULL default '0',
		  `last_terms_date` datetime NOT NULL default '0000-00-00 00:00:00',
		  `accepteddatasec` tinyint(1) NOT NULL default '0',
		  `last_datasec_date` datetime NOT NULL default '0000-00-00 00:00:00',
		  PRIMARY KEY  (`id`)
		) TYPE=MyISAM ;
		CREATE TABLE IF NOT EXISTS `#__cbe_field_values` (
		  `fieldvalueid` int(11) NOT NULL auto_increment,
		  `fieldid` int(11) NOT NULL default '0',
		  `fieldtitle` varchar(50) NOT NULL default '',
		  `ordering` int(11) NOT NULL default '0',
		  `sys` tinyint(4) NOT NULL default '0',
		  PRIMARY KEY  (`fieldvalueid`)
		) TYPE=MyISAM AUTO_INCREMENT=16 ;
		CREATE TABLE IF NOT EXISTS `#__cbe_fields` (
		  `fieldid` int(11) NOT NULL auto_increment,
		  `name` varchar(50) NOT NULL default '',
		  `table` varchar(50) NOT NULL default '#__cbe',
		  `title` varchar(255) NOT NULL default '',
		  `type` varchar(50) NOT NULL default '',
		  `information` mediumtext NOT NULL default '',
		  `infotag` varchar(10) NOT NULL default 'tag',
		  `maxlength` int(11) default NULL,
		  `size` int(11) default NULL,
		  `required` tinyint(4) default '0',
		  `tabid` tinyint(4) default NULL,
		  `ordering` int(11) default NULL,
		  `cols` int(11) default NULL,
		  `rows` int(11) default NULL,
		  `value` varchar(50) default NULL,
		  `default` int(11) default NULL,
		  `published` tinyint(1) NOT NULL default '1',
		  `registration` tinyint(1) NOT NULL default '0',
		  `profile` tinyint(1) NOT NULL default '1',
		  `readonly` TINYINT( 1 ) DEFAULT '0' NOT NULL,
		  `calculated` tinyint(1) NOT NULL default '0',
		  `sys` tinyint(4) NOT NULL default '0',
		  PRIMARY KEY  (`fieldid`)
		) TYPE=MyISAM AUTO_INCREMENT=54 ;
		CREATE TABLE IF NOT EXISTS `#__cbe_lists` (
		  `listid` int(11) NOT NULL auto_increment,
		  `title` varchar(255) NOT NULL default '',
		  `description` mediumtext,
		  `published` tinyint(1) NOT NULL default '0',
		  `default` tinyint(1) DEFAULT '0' NOT NULL,
		  `usergroupids` varchar(255) NULL,
		  `aclgroup` INT(9) DEFAULT '-2' NOT NULL,
		  `sortfields` varchar(255) NULL,
		  `ordering` int(11) NOT NULL default '0',
		  `filteronline` tinyint(1) unsigned NOT NULL default '0',
		  `col1title` varchar(255) default NULL,
		  `col1enabled` tinyint(1) NOT NULL default '0',
		  `col1fields` mediumtext,
		  `col2title` varchar(255) default NULL,
		  `col2enabled` tinyint(1) NOT NULL default '0',
		  `col1captions` tinyint(1) NOT NULL default '0',
		  `col2fields` mediumtext,
		  `col2captions` tinyint(1) NOT NULL default '0',
		  `col3title` varchar(255) default NULL,
		  `col3enabled` tinyint(1) NOT NULL default '0',
		  `col3fields` mediumtext,
		  `col3captions` tinyint(1) NOT NULL default '0',
		  `col4title` varchar(255) default NULL,
		  `col4enabled` tinyint(1) NOT NULL default '0',
		  `col4fields` mediumtext,
		  `col4captions` tinyint(1) NOT NULL default '0',
		  PRIMARY KEY  (`listid`)
		) TYPE=MyISAM AUTO_INCREMENT=4 ;
		CREATE TABLE IF NOT EXISTS `#__cbe_tabs` (
		  `tabid` int(11) NOT NULL auto_increment,
		  `title` varchar(50) NOT NULL default '',
		  `description` text,
		  `ordering` int(11) NOT NULL default '0',
		  `width` VARCHAR( 10 ) DEFAULT '.5' NOT NULL ,
		  `enabled` TINYINT( 1 ) DEFAULT '1' NOT NULL ,
		  `plugin` VARCHAR( 255 ) DEFAULT NULL ,
		  `sys` tinyint(4) NOT NULL default '0',
		  `tabname` VARCHAR(50) NOT NULL,
		  `tabparams` TEXT NOT NULL,
		  PRIMARY KEY  (`tabid`)
		) TYPE=MyISAM AUTO_INCREMENT=11 ;

		CREATE TABLE IF NOT EXISTS `#__cbe_templates` (
		  `id` int(11) NOT NULL auto_increment,
		  `title` varchar(50) NOT NULL default '',
		  `description` text,
		  `params` TEXT NOT NULL,
		  PRIMARY KEY  (`id`)) ;

		CREATE TABLE IF NOT EXISTS `#__cbe_userreports` (
		  `reportid` int(11) NOT NULL auto_increment,
		  `reporteduser` int(11) NOT NULL default '0',
		  `reportedbyuser` int(11) NOT NULL default '0',
		  `reportedondate` date NOT NULL default '0000-00-00',
		  `reportexplaination` text NOT NULL,
		  `reportedstatus` tinyint(4) NOT NULL default '0',
		  PRIMARY KEY  (`reportid`)
		) TYPE=MyISAM AUTO_INCREMENT=11 ;
		CREATE TABLE IF NOT EXISTS `#__cbe_buddylist` (
		`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
		`userid` int( 11 ) NOT NULL default '0',
		`buddyid` int( 11 ) NOT NULL default '0',
		`buddy` tinyint( 4 ) NOT NULL default '0',
		`status` tinyint( 4 ) NOT NULL default '0',
		PRIMARY KEY ( `id` )
		) TYPE=MYISAM AUTO_INCREMENT=19 ;
	CREATE TABLE IF NOT EXISTS `#__cbe_authorlist` (
	  `id` int(11) NOT NULL auto_increment,
	  `userid` int(11) NOT NULL default '0',
	  `authorid` int(11) NOT NULL default '0',
	  PRIMARY KEY  (`id`)
	) TYPE=MyISAM AUTO_INCREMENT=19 ;
	CREATE TABLE IF NOT EXISTS `#__cbe_testimonials` (
	  `id` int(11) NOT NULL auto_increment,
	  `userid` int(11) NOT NULL default '0',
	  `by_user` int(11) NOT NULL default '0',
	  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
	  `testimonial` mediumtext NOT NULL default '',
	  `approved` int(11) NOT NULL default '0',
	  PRIMARY KEY  (`id`)
	) TYPE=MyISAM AUTO_INCREMENT=19 ;
	CREATE TABLE IF NOT EXISTS `#__cbe_profile_comments` (
	  `id` int(11) NOT NULL auto_increment,
	  `userid` int(11) NOT NULL default '0',
	  `by_user` int(11) NOT NULL default '0',
	  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
	  `comment` text NOT NULL default '',
	  `approved` int(11) NOT NULL default '0',
	  `user_ip` varchar(30) NOT NULL default '',
	  PRIMARY KEY  (`id`)
	) TYPE=MyISAM AUTO_INCREMENT=19 ;
	CREATE TABLE IF NOT EXISTS `#__cbe_mambome_gbook` (
	  `id` int(11) NOT NULL auto_increment,
	  `userid` int(11) NOT NULL default '0',
	  `by_user` int(11) NOT NULL default '0',
	  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
	  `gbentry` text NOT NULL default '',
	  `approved` int(11) NOT NULL default '0',
	  `user_ip` varchar(30) NOT NULL default '',
	  `rating` tinyint(1) NOT NULL default '0',
	  `status` tinyint(1) NOT NULL default '0',
	  PRIMARY KEY  (`id`)
	) TYPE=MyISAM AUTO_INCREMENT=19 ;
	 CREATE TABLE IF NOT EXISTS `#__cbe_bad_words` (
	    `id` INT NOT NULL AUTO_INCREMENT,
	    `badword` varchar(30) NOT NULL,
	    `published` TINYINT(1) NOT NULL,
	    PRIMARY KEY (`id`)
	    ) TYPE=MyISAM AUTO_INCREMENT=19 ;
	CREATE TABLE IF NOT EXISTS `#__cbe_mambome_journal` (
	  `id` int(11) NOT NULL auto_increment,
	  `userid` int(11) NOT NULL default '0',
	  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
	  `journal_entry` text NOT NULL default '',
	  `published` int(11) NOT NULL default '0',
	  PRIMARY KEY  (`id`)
	) TYPE=MyISAM AUTO_INCREMENT=19 ;
		CREATE TABLE IF NOT EXISTS `#__cbe_searchmanager` (
		  `id` int(11) NOT NULL auto_increment,
		  `fieldid` int(11) NOT NULL default '0',
		  `range` tinyint(1) NOT NULL default '0',
		  `simple` tinyint(1) NOT NULL default '0',
		  `advanced` tinyint(1) NOT NULL default '0',
		  `ordering` int(11) default '0',
		  `module` tinyint(1) NOT NULL default '0',
		  PRIMARY KEY  (`id`)
		) TYPE=MyISAM AUTO_INCREMENT=21 ;
		CREATE TABLE IF NOT EXISTS `#__cbe_ratings` (
		`id` int(11) NOT NULL auto_increment,
		`profile` int(11) NOT NULL default '0',
		`rate` int(2) NOT NULL default '0',
		`ip` varchar(15) NOT NULL default '',
		`date` timestamp(14) NOT NULL,
		`visitor` varchar(20) NOT NULL default '',
		PRIMARY KEY  (`id`)
		) TYPE=MyISAM ;
	 CREATE TABLE IF NOT EXISTS `#__cbe_bad_usernames` (
	    `id` INT NOT NULL AUTO_INCREMENT,
	    `badname` varchar(30) NOT NULL,
	    `published` TINYINT(1) NOT NULL,
	    PRIMARY KEY (`id`)
	    ) TYPE=MyISAM AUTO_INCREMENT=19 ;
	 CREATE TABLE IF NOT EXISTS `#__cbe_userstime` (
	    `id` INT NOT NULL AUTO_INCREMENT,
	    `userid` INT(11) NOT NULL default '0',
	    `logcount` INT(14) NOT NULL default '0',
	    `logtime` BIGINT NOT NULL default '0',
	    `logtimesum` BIGINT NOT NULL default '0',
	    PRIMARY KEY (`id`)
	    ) TYPE=MyISAM AUTO_INCREMENT=1 ;
	 CREATE TABLE IF NOT EXISTS `#__cbe_geodata` (
	    `id` INT NOT NULL AUTO_INCREMENT,
	    `uid` INT(11) NOT NULL default '0',
	    `GeoLat` DECIMAL(20,15),
	    `GeoLng` DECIMAL(20,15),
	    `GeoAddr` TEXT,
	    `Geo_street` VARCHAR (255),
	    `Geo_postcode` VARCHAR (255),
	    `Geo_city` VARCHAR (255),
	    `Geo_state` VARCHAR (255),
	    `Geo_country` VARCHAR (255),
	    `GeoText` TEXT,
	    `GeoAccCode` TINYINT(1) NOT NULL default '0',
	    `GeoAllowShow` TINYINT(1) NOT NULL default '0',
	    PRIMARY KEY (`id`)
	    ) TYPE=MyISAM AUTO_INCREMENT=1 ;
	 CREATE TABLE IF NOT EXISTS `#__cbe_cbsearch_ses` (
	    `id` INT (11) UNSIGNED NOT NULL AUTO_INCREMENT,
	    `uid` INT (11) UNSIGNED DEFAULT '0',
	    `mod_cbe_search` VARCHAR (200) DEFAULT '0',
	    `mod_cbe_search1` VARCHAR (200) DEFAULT '0',
	    `listid` INT (11) UNSIGNED DEFAULT '0',
	    `do_cbquery` TINYINT (1) UNSIGNED DEFAULT '0',
	    `cbquery` MEDIUMTEXT,
	    `geo_distance` INT (6) UNSIGNED DEFAULT '0',
	    `geo_map` TINYINT (1) UNSIGNED DEFAULT '0',
	    `onlinenow` TINYINT (1) UNSIGNED DEFAULT '0',
	    `picture` TINYINT (1) UNSIGNED DEFAULT '0',
	    `added10` TINYINT (1) UNSIGNED DEFAULT '0',
	    `online10` TINYINT (1) UNSIGNED DEFAULT '0',
	    `q_time` BIGINT DEFAULT '0',
	    UNIQUE(`id`), PRIMARY KEY (`id`)
	    ) TYPE=MyISAM AUTO_INCREMENT=1 ;
	 CREATE TABLE IF NOT EXISTS`#__cbe_admods` (
	  `id` int(11) NOT NULL auto_increment,
	  `title` text NOT NULL,
	  `content` text NOT NULL,
	  `ordering` int(11) NOT NULL default '0',
	  `position` varchar(12) default NULL,
	  `published` tinyint(1) NOT NULL default '0',
	  `module` varchar(50) default NULL,
	  `plugin` text NOT NULL,
	  `plugin_func` text NOT NULL,
	  `showtitle` tinyint(3) unsigned NOT NULL default '1',
	  `params` text NOT NULL,
	  `iscore` tinyint(4) NOT NULL default '0',
	  PRIMARY KEY  (`id`),
	  KEY `published` (`published`)
	 ) TYPE=MyISAM;
	 CREATE TABLE IF NOT EXISTS `#__cbe_config` (
	   `varname` tinytext NOT NULL,
	   `value` tinytext NOT NULL,
	   PRIMARY KEY  (`varname`(30))
	 ) TYPE=MyISAM;
	 CREATE TABLE IF NOT EXISTS `#__cbe_config_enh` (
	   `varname` tinytext NOT NULL,
	   `value` tinytext NOT NULL,
	   PRIMARY KEY  (`varname`(40))
	 ) TYPE=MyISAM;
		INSERT IGNORE INTO `#__cbe_bad_usernames` (`id`,`badname`,`published`) VALUES
		(1,'root',1),(2,'admin',1),(3,'webmaster',1),(4,'sitemaster',1),(5,'chatmaster',1),
		(6,'postmaster',1);
		INSERT IGNORE INTO `#__cbe_fields` (`fieldid`, `name`, `table`, `title`, `type`, `maxlength`, `size`, `required`, `tabid`, `ordering`, `cols`, `rows`, `value`, `default`, `published`, `registration`, `profile`, `readonly`, `calculated`, `sys`)
		VALUES (41, 'name', '#__users', '_UE_NAME', 'predefined', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 1, 1),
		(26, 'NA', '#__cbe', '_UE_ONLINESTATUS', 'status', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 1, 1),
		(27, 'lastvisitDate', '#__cbe', '_UE_LASTONLINE', 'date', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 1, 1),
		(28, 'registerDate', '#__cbe', '_UE_MEMBERSINCE', 'date', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 1, 1),
		(29, 'avatar', '#__cbe', '_UE_IMAGE', 'image', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 1, 1),
		(42, 'username', '#__users', '_UE_UNAME', 'predefined', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 1, 1),
		(45, 'NA', '#__cbe', '_UE_FORMATNAME', 'formatname', NULL , NULL , 0, NULL , NULL , NULL , NULL , NULL , NULL , 1, 0, 1, 0, 1, 1),
		(46, 'firstname', '#__cbe', '_UE_YOUR_FNAME', 'predefined', NULL, NULL, 0, NULL , NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 1, 1),
		(47, 'middlename', '#__cbe', '_UE_YOUR_MNAME', 'predefined', NULL, NULL, 0, NULL , NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 1, 1),
		(48, 'lastname', '#__cbe', '_UE_YOUR_LNAME', 'predefined', NULL, NULL, 0, NULL , NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 1, 1),
		(49, 'lastupdatedate', '#__cbe', '_UE_LASTUPDATEDON', 'date', NULL , NULL , 0, NULL , NULL , NULL , NULL , NULL , NULL , 1, 0, 1, 0, 1, 1),
		(50, 'email', '#__users', '_UE_EMAIL', 'primaryemailaddress', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 1, 1),
		(51, 'usertype', '#__users', '_UE_CBE_UM_USERGROUP', 'predefined', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 1, 1),
		(52, 'cbe_geodistance', '#__cbe_geodata', '_UE_CBE_GEOCODER_F_DISTANCE', 'geo_calc_dist', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, 1),
		(53, 'cbe_calced_age', '#__cbe', '_UE_CBE_CALCED_AGE', 'cbe_calced_age', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, 1);
		INSERT IGNORE INTO #__cbe(id,user_id) SELECT id,id FROM #__users
