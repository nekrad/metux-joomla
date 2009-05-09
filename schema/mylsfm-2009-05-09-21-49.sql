-- MySQL dump 10.11
--
-- Host: localhost    Database: mylsfm
-- ------------------------------------------------------
-- Server version	5.0.51a-24-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `mylsfm_banner`
--

DROP TABLE IF EXISTS `mylsfm_banner`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_banner` (
  `bid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `type` varchar(30) NOT NULL default 'banner',
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `imptotal` int(11) NOT NULL default '0',
  `impmade` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `imageurl` varchar(100) NOT NULL default '',
  `clickurl` varchar(200) NOT NULL default '',
  `date` datetime default NULL,
  `showBanner` tinyint(1) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(50) default NULL,
  `custombannercode` text,
  `catid` int(10) unsigned NOT NULL default '0',
  `description` text NOT NULL,
  `sticky` tinyint(1) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `tags` text NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY  (`bid`),
  KEY `viewbanner` (`showBanner`),
  KEY `idx_banner_catid` (`catid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_banner`
--

LOCK TABLES `mylsfm_banner` WRITE;
/*!40000 ALTER TABLE `mylsfm_banner` DISABLE KEYS */;
INSERT INTO `mylsfm_banner` VALUES (1,1,'banner','OSM 1','osm-1',0,43,0,'osmbanner1.png','http://www.opensourcematters.org','2004-07-07 15:31:29',1,0,'0000-00-00 00:00:00','','',13,'',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','',''),(2,1,'banner','OSM 2','osm-2',0,49,0,'osmbanner2.png','http://www.opensourcematters.org','2004-07-07 15:31:29',1,0,'0000-00-00 00:00:00','','',13,'',0,2,'0000-00-00 00:00:00','0000-00-00 00:00:00','',''),(3,1,'','Joomla!','joomla',0,26,0,'','http://www.joomla.org','2006-05-29 14:21:28',1,0,'0000-00-00 00:00:00','','<a href=\"{CLICKURL}\" target=\"_blank\">{NAME}</a>\r\n<br/>\r\nJoomla!, das bekannteste und meistgenutzte Open-Source-CMS-Projekt der Welt.',14,'',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','',''),(4,1,'','JoomlaCode','joomlacode',0,26,0,'','http://joomlacode.org','2006-05-29 14:19:26',1,0,'0000-00-00 00:00:00','','<a href=\"{CLICKURL}\" target=\"_blank\">{NAME}</a>\r\n<br/>\r\nJoomlaCode - Entwicklung und Verbreitung einfach gemacht.',14,'',0,2,'0000-00-00 00:00:00','0000-00-00 00:00:00','',''),(5,1,'','Joomla!-Erweitungen','joomla-erweitungen',0,21,0,'','http://extensions.joomla.org','2006-05-29 14:23:21',1,0,'0000-00-00 00:00:00','','<a href=\"{CLICKURL}\" target=\"_blank\">{NAME}</a>\r\n<br/>\r\nJoomla!-Komponenten, Module, Plugins und Übersetzungen zentral.',14,'',0,3,'0000-00-00 00:00:00','0000-00-00 00:00:00','',''),(6,1,'','Joomla!-Shop','joomla-shop',0,21,1,'','http://shop.joomla.org','2006-05-29 14:23:21',1,0,'0000-00-00 00:00:00','','<a href=\"{CLICKURL}\" target=\"_blank\">{NAME}</a>\r\n<br/>\r\nFür alle Ihre Joomla!-Artikel.',14,'',0,4,'0000-00-00 00:00:00','0000-00-00 00:00:00','',''),(7,1,'','Joomla! Promo-Artikel','joomla-promo-artikel',0,9,1,'shop-ad.jpg','http://shop.joomla.org','2007-09-19 17:26:24',1,0,'0000-00-00 00:00:00','','',33,'',0,3,'0000-00-00 00:00:00','0000-00-00 00:00:00','',''),(8,1,'','Joomla!-Bücher','joomla-buecher',0,11,0,'shop-ad-books.jpg','http://shop.joomla.org/amazoncom-bookstores.html','2007-09-19 17:28:01',1,0,'0000-00-00 00:00:00','','',33,'',0,4,'0000-00-00 00:00:00','0000-00-00 00:00:00','','');
/*!40000 ALTER TABLE `mylsfm_banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_bannerclient`
--

DROP TABLE IF EXISTS `mylsfm_bannerclient`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_bannerclient` (
  `cid` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `contact` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `extrainfo` text NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time default NULL,
  `editor` varchar(50) default NULL,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_bannerclient`
--

LOCK TABLES `mylsfm_bannerclient` WRITE;
/*!40000 ALTER TABLE `mylsfm_bannerclient` DISABLE KEYS */;
INSERT INTO `mylsfm_bannerclient` VALUES (1,'Open Source Matters','Administrator','admin@opensourcematters.org','',0,'00:00:00',NULL);
/*!40000 ALTER TABLE `mylsfm_bannerclient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_bannertrack`
--

DROP TABLE IF EXISTS `mylsfm_bannertrack`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_bannertrack` (
  `track_date` date NOT NULL,
  `track_type` int(10) unsigned NOT NULL,
  `banner_id` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_bannertrack`
--

LOCK TABLES `mylsfm_bannertrack` WRITE;
/*!40000 ALTER TABLE `mylsfm_bannertrack` DISABLE KEYS */;
/*!40000 ALTER TABLE `mylsfm_bannertrack` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_categories`
--

DROP TABLE IF EXISTS `mylsfm_categories`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_categories` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `image` varchar(255) NOT NULL default '',
  `section` varchar(50) NOT NULL default '',
  `image_position` varchar(30) NOT NULL default '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(50) default NULL,
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `cat_idx` (`section`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_categories`
--

LOCK TABLES `mylsfm_categories` WRITE;
/*!40000 ALTER TABLE `mylsfm_categories` DISABLE KEYS */;
INSERT INTO `mylsfm_categories` VALUES (2,0,'Links rund um Joomla!','','links-rund-um-joomla','clock.jpg','com_weblinks','left','Eine Auswahl an Weblinks, die mit dem Joomla!-Projekt zu tun haben.',1,0,'0000-00-00 00:00:00',NULL,1,0,0,''),(4,0,'Joomla!','','joomla','','com_newsfeeds','left','',1,0,'0000-00-00 00:00:00',NULL,2,0,0,''),(5,0,'Freie und Open Source-Software','','freie-und-open-source-software','','com_newsfeeds','left','Lesen Sie das Neueste über Freie und Open Source Software von einigen der führenden Verfechtern.',1,0,'0000-00-00 00:00:00',NULL,3,0,0,''),(6,0,'Related Projects','','related-projects','','com_newsfeeds','left','Joomla basiert auf andere Freie und Open Source Projekte und arbeitet mit vielen zusammen. Wir haben einige ausgewählt, damit Sie auf dem Laufenden bleiben.',1,0,'0000-00-00 00:00:00',NULL,4,0,0,''),(12,0,'Kontakte','','kontakte','','com_contact_details','left','Details zu den Kontakten dieser Webseite',1,0,'0000-00-00 00:00:00',NULL,0,0,0,''),(13,0,'Joomla','','joomla','','com_banner','left','',1,0,'0000-00-00 00:00:00',NULL,0,0,0,''),(14,0,'Text-Werbung','','text-werbung','','com_banner','left','',1,0,'0000-00-00 00:00:00',NULL,0,0,0,''),(15,0,'Merkmale','','merkmale','','com_content','left','',0,0,'0000-00-00 00:00:00',NULL,6,0,0,''),(17,0,'Benefits','','benefits','','com_content','left','',0,0,'0000-00-00 00:00:00',NULL,4,0,0,''),(18,0,'Plattformen','','plattformen','','com_content','left','',0,0,'0000-00-00 00:00:00',NULL,3,0,0,''),(19,0,'Andere Quellen','','andere-quellen','','com_weblinks','left','',1,0,'0000-00-00 00:00:00',NULL,2,0,0,''),(31,0,'MyLSFM Infos','','mylsfm-infos','','3','left','Allgemeine Fragen zum Joomla! CMS',1,0,'0000-00-00 00:00:00',NULL,1,0,0,''),(33,0,'Joomla! Promo','','joomla-promo','','com_banner','left','',1,0,'0000-00-00 00:00:00',NULL,1,0,0,'');
/*!40000 ALTER TABLE `mylsfm_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_components`
--

DROP TABLE IF EXISTS `mylsfm_components`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_components` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `menuid` int(11) unsigned NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `admin_menu_link` varchar(255) NOT NULL default '',
  `admin_menu_alt` varchar(255) NOT NULL default '',
  `option` varchar(50) NOT NULL default '',
  `ordering` int(11) NOT NULL default '0',
  `admin_menu_img` varchar(255) NOT NULL default '',
  `iscore` tinyint(4) NOT NULL default '0',
  `params` text NOT NULL,
  `enabled` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `parent_option` (`parent`,`option`(32))
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_components`
--

LOCK TABLES `mylsfm_components` WRITE;
/*!40000 ALTER TABLE `mylsfm_components` DISABLE KEYS */;
INSERT INTO `mylsfm_components` VALUES (1,'Banner','',0,0,'','Banner-Verwaltung','com_banners',0,'js/ThemeOffice/component.png',0,'track_impressions=0\ntrack_clicks=0\ntag_prefix=\n\n',1),(2,'Banner','',0,1,'option=com_banners','Aktive Banner','com_banners',1,'js/ThemeOffice/edit.png',0,'',1),(3,'Kunden','',0,1,'option=com_banners&c=client','Kunden','com_banners',2,'js/ThemeOffice/categories.png',0,'',1),(4,'Weblinks','option=com_weblinks',0,0,'','Weblinks','com_weblinks',0,'js/ThemeOffice/component.png',0,'show_comp_description=1\ncomp_description=\nshow_link_hits=1\nshow_link_description=1\nshow_other_cats=1\nshow_headings=1\nshow_page_title=1\nlink_target=0\nlink_icons=\n\n',1),(5,'Links','',0,4,'option=com_weblinks','Existierende Weblinks anzeigen','com_weblinks',1,'js/ThemeOffice/edit.png',0,'',1),(6,'Kategorien','',0,4,'option=com_categories&section=com_weblinks','Weblink-Kategorien','',2,'js/ThemeOffice/categories.png',0,'',1),(7,'Kontakte','option=com_contact',0,0,'','Kontaktdetails bearbeiten','com_contact',0,'js/ThemeOffice/component.png',1,'contact_icons=0\nicon_address=\nicon_email=\nicon_telephone=\nicon_fax=\nicon_misc=\nshow_headings=1\nshow_position=1\nshow_email=0\nshow_telephone=1\nshow_mobile=1\nshow_fax=1\nbannedEmail=\nbannedSubject=\nbannedText=\nsession=1\ncustomReply=0\n\n',1),(8,'Kontakte','',0,7,'option=com_contact','Kontaktdetails bearbeiten','com_contact',0,'js/ThemeOffice/edit.png',1,'',1),(9,'Kategorien','',0,7,'option=com_categories&section=com_contact_details','Kontaktkategorien','',2,'js/ThemeOffice/categories.png',1,'contact_icons=0\nicon_address=\nicon_email=\nicon_telephone=\nicon_fax=\nicon_misc=\nshow_headings=1\nshow_position=1\nshow_email=0\nshow_telephone=1\nshow_mobile=1\nshow_fax=1\nbannedEmail=\nbannedSubject=\nbannedText=\nsession=1\ncustomReply=0\n\n',1),(10,'Umfragen','option=com_poll',0,0,'option=com_poll','Umfragen','com_poll',0,'js/ThemeOffice/component.png',0,'',1),(11,'Newsfeeds','option=com_newsfeeds',0,0,'','Newsfeeds','com_newsfeeds',0,'js/ThemeOffice/component.png',0,'',1),(12,'Feeds','',0,11,'option=com_newsfeeds','Feeds','com_newsfeeds',1,'js/ThemeOffice/edit.png',0,'show_headings=1\nshow_name=1\nshow_articles=1\nshow_link=1\nshow_cat_description=1\nshow_cat_items=1\nshow_feed_image=1\nshow_feed_description=1\nshow_item_description=1\nfeed_word_count=0\n\n',1),(13,'Kategorien','',0,11,'option=com_categories&section=com_newsfeeds','Kategorien','',2,'js/ThemeOffice/categories.png',0,'',1),(14,'Benutzer','option=com_user',0,0,'','','com_user',0,'',1,'',1),(15,'Suche','option=com_search',0,0,'option=com_search','Statistiken der Suchanfragen','com_search',0,'js/ThemeOffice/component.png',1,'enabled=0\n\n',1),(16,'Kategorien','',0,1,'option=com_categories&section=com_banner','Kategorien','',3,'',1,'',1),(17,'Wrapper','option=com_wrapper',0,0,'','Wrapper','com_wrapper',0,'',1,'',1),(18,'Mail an','',0,0,'','','com_mailto',0,'',1,'',1),(19,'Medien','',0,0,'option=com_media','Medien','com_media',0,'',1,'upload_extensions=bmp,csv,doc,epg,gif,ico,jpg,odg,odp,ods,odt,pdf,png,ppt,swf,txt,xcf,xls,BMP,CSV,DOC,EPG,GIF,ICO,JPG,ODG,ODP,ODS,ODT,PDF,PNG,PPT,SWF,TXT,XCF,XLS\nupload_maxsize=10000000\nfile_path=images\nimage_path=images/stories\nrestrict_uploads=1\ncheck_mime=1\nimage_extensions=bmp,gif,jpg,png\nignore_extensions=\nupload_mime=image/jpeg,image/gif,image/png,image/bmp,application/x-shockwave-flash,application/msword,application/excel,application/pdf,application/powerpoint,text/plain,application/x-zip\nupload_mime_illegal=text/html\nenable_flash=0\n\n',1),(20,'Beiträge','option=com_content',0,0,'','','com_content',0,'',1,'show_noauth=1\nshow_title=1\nlink_titles=1\nshow_intro=0\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=0\nshow_create_date=0\nshow_modify_date=0\nshow_item_navigation=0\nshow_readmore=0\nshow_vote=0\nshow_icons=0\nshow_pdf_icon=0\nshow_print_icon=0\nshow_email_icon=0\nshow_hits=0\nfeed_summary=0\nfilter_tags=\nfilter_attritbutes=\n\n',1),(21,'Konfiguration','',0,0,'','Konfiguration','com_config',0,'',1,'',1),(22,'Installation','',0,0,'','Installer','com_installer',0,'',1,'',1),(23,'Sprachen','',0,0,'','Sprachen','com_languages',0,'',1,'administrator=de-DE\nsite=de-DE',1),(24,'Massenmail','',0,0,'','Massenmail','com_massmail',0,'',1,'mailSubjectPrefix=\nmailBodySuffix=\n\n',1),(25,'Menüeditor','',0,0,'','Menüeditor','com_menus',0,'',1,'',1),(27,'Nachrichten','',0,0,'','Nachrichten','com_messages',0,'',1,'',1),(28,'Module','',0,0,'','Module','com_modules',0,'',1,'',1),(29,'Plugins','',0,0,'','Plugins','com_plugins',0,'',1,'',1),(30,'Templates','',0,0,'','Templates','com_templates',0,'',1,'',1),(31,'Benutzer','',0,0,'','Benutzer','com_users',0,'',1,'allowUserRegistration=1\nnew_usertype=Registered\nuseractivation=1\nfrontend_userparams=1\n\n',1),(32,'Cache','',0,0,'','Cache','com_cache',0,'',1,'',1),(33,'Kontrollzentrum','',0,0,'','Kontrollzentrum','com_cpanel',0,'',1,'',1),(34,'JCE Administration','option=com_jce',0,0,'option=com_jce','JCE Administration','com_jce',0,'js/ThemeOffice/component.png',0,'',1),(35,'Control Panel','',0,34,'option=com_jce','Control Panel','com_jce',0,'templates/khepri/images/menu/icon-16-cpanel.png',0,'',1),(36,'Configuration','',0,34,'option=com_jce&type=config','Configuration','com_jce',1,'templates/khepri/images/menu/icon-16-config.png',0,'',1),(37,'Groups','',0,34,'option=com_jce&type=group','Groups','com_jce',2,'templates/khepri/images/menu/icon-16-user.png',0,'',1),(38,'Plugins','',0,34,'option=com_jce&type=plugin','Plugins','com_jce',3,'templates/khepri/images/menu/icon-16-plugin.png',0,'',1),(39,'Install','',0,34,'option=com_jce&type=install','Install','com_jce',4,'templates/khepri/images/menu/icon-16-install.png',0,'',1);
/*!40000 ALTER TABLE `mylsfm_components` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_contact_details`
--

DROP TABLE IF EXISTS `mylsfm_contact_details`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_contact_details` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `con_position` varchar(255) default NULL,
  `address` text,
  `suburb` varchar(100) default NULL,
  `state` varchar(100) default NULL,
  `country` varchar(100) default NULL,
  `postcode` varchar(100) default NULL,
  `telephone` varchar(255) default NULL,
  `fax` varchar(255) default NULL,
  `misc` mediumtext,
  `image` varchar(255) default NULL,
  `imagepos` varchar(20) default NULL,
  `email_to` varchar(255) default NULL,
  `default_con` tinyint(1) unsigned NOT NULL default '0',
  `published` tinyint(1) unsigned NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL default '0',
  `catid` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `mobile` varchar(255) NOT NULL default '',
  `webpage` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_contact_details`
--

LOCK TABLES `mylsfm_contact_details` WRITE;
/*!40000 ALTER TABLE `mylsfm_contact_details` DISABLE KEYS */;
INSERT INTO `mylsfm_contact_details` VALUES (1,'Name','name','Position','Straße','Stadt/Bezirk','Bundesland/Kanton','Staat','PLZ','Telefon','Fax','Weitere Infos','powered_by.png','top','email@email.com',1,1,0,'0000-00-00 00:00:00',1,'show_name=1\r\nshow_position=1\r\nshow_email=0\r\nshow_street_address=1\r\nshow_suburb=1\r\nshow_state=1\r\nshow_postcode=1\r\nshow_country=1\r\nshow_telephone=1\r\nshow_mobile=1\r\nshow_fax=1\r\nshow_webpage=1\r\nshow_misc=1\r\nshow_image=1\r\nallow_vcard=0\r\ncontact_icons=0\r\nicon_address=\r\nicon_email=\r\nicon_telephone=\r\nicon_fax=\r\nicon_misc=\r\nshow_email_form=1\r\nemail_description=1\r\nshow_email_copy=1\r\nbanned_email=\r\nbanned_subject=\r\nbanned_text=',0,12,0,'','');
/*!40000 ALTER TABLE `mylsfm_contact_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_content`
--

DROP TABLE IF EXISTS `mylsfm_content`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_content` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `title_alias` varchar(255) NOT NULL default '',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL default '0',
  `sectionid` int(11) unsigned NOT NULL default '0',
  `mask` int(11) unsigned NOT NULL default '0',
  `catid` int(11) unsigned NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) unsigned NOT NULL default '0',
  `created_by_alias` varchar(255) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) unsigned NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` text NOT NULL,
  `version` int(11) unsigned NOT NULL default '1',
  `parentid` int(11) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0',
  `metadata` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_section` (`sectionid`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_content`
--

LOCK TABLES `mylsfm_content` WRITE;
/*!40000 ALTER TABLE `mylsfm_content` DISABLE KEYS */;
INSERT INTO `mylsfm_content` VALUES (36,'MyLSFM Records - Newcomer - Startseite','startseite','','<br /><center>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td>\r\n<table background=\"http://www.mylsfm.de/images/stories/webtechnik/webground/newsblock1.png\" width=\"200\" style=\"height: 340px;\">\r\n<tbody>\r\n<tr height=\"33\">\r\n<td></td>\r\n<td></td>\r\n<td></td>\r\n<td></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n<td valign=\"top\"><img width=\"85\" src=\"images/stories/testfoto.jpg\" alt=\"testfoto.jpg\" height=\"64\" title=\"testfoto.jpg\" /></td>\r\n<td width=\"105\" valign=\"top\"><span class=\"newsblock\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=7:halt-dich-an-den-code&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Test Band Live</a></span><br /><span style=\"font-family: verdana,geneva;\">Testand wird hier mal aufgelistet</span></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n<td valign=\"top\"><img width=\"85\" src=\"images/stories/testfoto1.jpg\" alt=\"testfoto.jpg\" height=\"64\" title=\"testfoto.jpg\" /></td>\r\n<td width=\"105\" valign=\"top\"><span class=\"newsblock\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=7:halt-dich-an-den-code&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Test Band Live</a></span><br /><span style=\"font-family: verdana,geneva;\">Testand wird hier mal aufgelistet</span></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n<td valign=\"top\"><img width=\"85\" src=\"images/stories/testfoto2.jpg\" alt=\"testfoto.jpg\" height=\"64\" title=\"testfoto.jpg\" /></td>\r\n<td width=\"105\" valign=\"top\"><span class=\"newsblock\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=7:halt-dich-an-den-code&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Test Band Live</a></span><br /><span style=\"font-family: verdana,geneva;\">Testand wird hier mal aufgelistet</span></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n<td valign=\"top\"><img width=\"85\" src=\"images/stories/testfoto3.jpg\" alt=\"testfoto.jpg\" height=\"64\" title=\"testfoto.jpg\" /></td>\r\n<td width=\"105\" valign=\"top\"><span class=\"newsblock\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=7:halt-dich-an-den-code&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Test Band Live</a></span><br /><span style=\"font-family: verdana,geneva;\">Testand wird hier mal aufgelistet</span></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n<td>\r\n<table background=\"http://www.mylsfm.de/images/stories/webtechnik/webground/newsblock2.png\" width=\"200\" style=\"height: 340px;\">\r\n<tbody>\r\n<tr height=\"33\">\r\n<td></td>\r\n<td></td>\r\n<td></td>\r\n<td></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n<td valign=\"top\"><img width=\"85\" src=\"images/stories/testfoto4.jpg\" alt=\"testfoto.jpg\" height=\"64\" title=\"testfoto.jpg\" /></td>\r\n<td width=\"105\" valign=\"top\"><span class=\"newsblock\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=7:halt-dich-an-den-code&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Test Band Live</a></span><br /><span style=\"font-family: verdana,geneva;\">Testand wird hier mal aufgelistet</span></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n<td valign=\"top\"><img width=\"85\" src=\"images/stories/testfoto5.jpg\" alt=\"testfoto.jpg\" height=\"64\" title=\"testfoto.jpg\" /></td>\r\n<td width=\"105\" valign=\"top\"><span class=\"newsblock\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=7:halt-dich-an-den-code&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Test Band Live</a></span><br /><span style=\"font-family: verdana,geneva;\">Testand wird hier mal aufgelistet</span></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n<td valign=\"top\"><img width=\"85\" src=\"images/stories/testfoto6.jpg\" alt=\"testfoto.jpg\" height=\"64\" title=\"testfoto.jpg\" /></td>\r\n<td width=\"105\" valign=\"top\"><span class=\"newsblock\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=7:halt-dich-an-den-code&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Test Band Live</a></span><br /><span style=\"font-family: verdana,geneva;\">Testand wird hier mal aufgelistet</span></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n<td valign=\"top\"><img width=\"85\" src=\"images/stories/testfoto7.jpg\" alt=\"testfoto.jpg\" height=\"64\" title=\"testfoto.jpg\" /></td>\r\n<td width=\"105\" valign=\"top\"><span class=\"newsblock\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=7:halt-dich-an-den-code&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Test Band Live</a></span><br /><span style=\"font-family: verdana,geneva;\">Testand wird hier mal aufgelistet</span></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n<td>\r\n<table background=\"http://www.mylsfm.de/images/stories/webtechnik/webground/newsblock3.png\" width=\"200\" style=\"height: 340px;\">\r\n<tbody>\r\n<tr height=\"33\">\r\n<td></td>\r\n<td></td>\r\n<td></td>\r\n<td></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n<td valign=\"top\"><img width=\"85\" src=\"images/stories/testfoto8.jpg\" alt=\"testfoto.jpg\" height=\"64\" title=\"testfoto.jpg\" /></td>\r\n<td width=\"105\" valign=\"top\"><span class=\"newsblock\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=7:halt-dich-an-den-code&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Test Band Live</a></span><br /><span style=\"font-family: verdana,geneva;\">Testand wird hier mal aufgelistet</span></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n<td valign=\"top\"><img width=\"85\" src=\"images/stories/testfoto9.jpg\" alt=\"testfoto.jpg\" height=\"64\" title=\"testfoto.jpg\" /></td>\r\n<td width=\"105\" valign=\"top\"><span class=\"newsblock\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=7:halt-dich-an-den-code&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Test Band Live</a></span><br /><span style=\"font-family: verdana,geneva;\">Testand wird hier mal aufgelistet</span></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n<td valign=\"top\"><img width=\"85\" src=\"images/stories/testfoto10.jpg\" alt=\"testfoto.jpg\" height=\"64\" title=\"testfoto.jpg\" /></td>\r\n<td width=\"105\" valign=\"top\"><span class=\"newsblock\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=7:halt-dich-an-den-code&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Test Band Live</a></span><br /><span style=\"font-family: verdana,geneva;\">Testand wird hier mal aufgelistet</span></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n<td valign=\"top\"><img width=\"85\" src=\"images/stories/testfoto11.jpg\" alt=\"testfoto.jpg\" height=\"64\" title=\"testfoto.jpg\" /></td>\r\n<td width=\"105\" valign=\"top\"><span class=\"newsblock\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=7:halt-dich-an-den-code&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Test Band Live</a></span><br /><span style=\"font-family: verdana,geneva;\">Testand wird hier mal aufgelistet</span></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</center><br /><center>\r\n<table background=\"http://www.mylsfm.de/images/stories/webtechnik/webground/topground.png\" width=\"612\" style=\"height: 320px;\">\r\n<tbody>\r\n<tr height=\"30\">\r\n<td></td>\r\n</tr>\r\n<tr>\r\n<td><center>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td><a href=\"index.php/component/content/article/35-infos/125-niclas-holtrup-stellt-hoertalk-vor.html\"><img width=\"125\" src=\"images/stories/testanne.jpg\" alt=\"testanne.jpg\" height=\"80\" style=\"border: 0px solid;\" title=\"testanne.jpg\" /></a></td>\r\n<td width=\"15\"></td>\r\n<td><a href=\"index.php/component/content/article/35-infos/125-niclas-holtrup-stellt-hoertalk-vor.html\"><img width=\"125\" src=\"images/stories/testanne.jpg\" alt=\"testanne.jpg\" height=\"80\" style=\"border: 0px solid;\" title=\"testanne.jpg\" /></a></td>\r\n<td width=\"15\"></td>\r\n<td><a href=\"index.php/component/content/article/35-infos/125-niclas-holtrup-stellt-hoertalk-vor.html\"><img width=\"125\" src=\"images/stories/testanne.jpg\" alt=\"testanne.jpg\" height=\"80\" style=\"border: 0px solid;\" title=\"testanne.jpg\" /></a></td>\r\n<td width=\"15\"></td>\r\n<td><a href=\"index.php/component/content/article/35-infos/125-niclas-holtrup-stellt-hoertalk-vor.html\"><img width=\"125\" src=\"images/stories/testanne.jpg\" alt=\"testanne.jpg\" height=\"80\" style=\"border: 0px solid;\" title=\"testanne.jpg\" /></a></td>\r\n</tr>\r\n<tr>\r\n<td><center><span class=\"massilink\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=45:joomla-community-portal&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Die Top Band</a></span></center></td>\r\n<td></td>\r\n<td><center><span class=\"massilink\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=45:joomla-community-portal&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Die Top Band</a></span></center></td>\r\n<td></td>\r\n<td><center><span class=\"massilink\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=45:joomla-community-portal&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Die Top Band</a></span></center></td>\r\n<td></td>\r\n<td><center><span class=\"massilink\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=45:joomla-community-portal&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Die Top Band</a></span></center></td>\r\n</tr>\r\n<tr>\r\n<td><center><span style=\"font-size: 7pt; color: #ffffff; font-family: verdana,geneva;\"><strong>Rock / Pop</strong></span></center></td>\r\n<td></td>\r\n<td><center><span style=\"font-size: 7pt; color: #ffffff; font-family: verdana,geneva;\"><strong>Rock / Pop</strong></span></center></td>\r\n<td></td>\r\n<td><center><span style=\"font-size: 7pt; color: #ffffff; font-family: verdana,geneva;\"><strong>Rock / Pop</strong></span></center></td>\r\n<td></td>\r\n<td><center><span style=\"font-size: 7pt; color: #ffffff; font-family: verdana,geneva;\"><strong>Rock / Pop</strong></span></center></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<br /><br />\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td><a href=\"index.php/component/content/article/35-infos/125-niclas-holtrup-stellt-hoertalk-vor.html\"><img width=\"125\" src=\"images/stories/testanne.jpg\" alt=\"testanne.jpg\" height=\"80\" style=\"border: 0px solid;\" title=\"testanne.jpg\" /></a></td>\r\n<td width=\"15\"></td>\r\n<td><a href=\"index.php/component/content/article/35-infos/125-niclas-holtrup-stellt-hoertalk-vor.html\"><img width=\"125\" src=\"images/stories/testanne.jpg\" alt=\"testanne.jpg\" height=\"80\" style=\"border: 0px solid;\" title=\"testanne.jpg\" /></a></td>\r\n<td width=\"15\"></td>\r\n<td><a href=\"index.php/component/content/article/35-infos/125-niclas-holtrup-stellt-hoertalk-vor.html\"><img width=\"125\" src=\"images/stories/testanne.jpg\" alt=\"testanne.jpg\" height=\"80\" style=\"border: 0px solid;\" title=\"testanne.jpg\" /></a></td>\r\n<td width=\"15\"></td>\r\n<td><a href=\"index.php/component/content/article/35-infos/125-niclas-holtrup-stellt-hoertalk-vor.html\"><img width=\"125\" src=\"images/stories/testanne.jpg\" alt=\"testanne.jpg\" height=\"80\" style=\"border: 0px solid;\" title=\"testanne.jpg\" /></a></td>\r\n</tr>\r\n<tr>\r\n<td><center><span class=\"massilink\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=45:joomla-community-portal&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Die Top Band</a></span></center></td>\r\n<td></td>\r\n<td><center><span class=\"massilink\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=45:joomla-community-portal&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Die Top Band</a></span></center></td>\r\n<td></td>\r\n<td><center><span class=\"massilink\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=45:joomla-community-portal&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Die Top Band</a></span></center></td>\r\n<td></td>\r\n<td><center><span class=\"massilink\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=45:joomla-community-portal&amp;catid=1:aktuelle-nachrichten&amp;Itemid=50\">Die Top Band</a></span></center></td>\r\n</tr>\r\n<tr>\r\n<td><center><span style=\"font-size: 7pt; color: #ffffff; font-family: verdana,geneva;\"><strong>Rock / Pop</strong></span></center></td>\r\n<td></td>\r\n<td><center><span style=\"font-size: 7pt; color: #ffffff; font-family: verdana,geneva;\"><strong>Rock / Pop</strong></span></center></td>\r\n<td></td>\r\n<td><center><span style=\"font-size: 7pt; color: #ffffff; font-family: verdana,geneva;\"><strong>Rock / Pop</strong></span></center></td>\r\n<td></td>\r\n<td><center><span style=\"font-size: 7pt; color: #ffffff; font-family: verdana,geneva;\"><strong>Rock / Pop</strong></span></center></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</center><br /></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</center><br /><center>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td>\r\n<table background=\"http://www.mylsfm.de/images/stories/webtechnik/webground/amazonground.png\" width=\"300\" style=\"height: 260px;\">\r\n<tbody>\r\n<tr>\r\n<td><center>\r\n<object height=\"250\" classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0\" width=\"250\">\r\n<param value=\"Player_70c58ca9-050c-41e1-960d-d7a3afef92de\" name=\"id\" />\r\n<param value=\"high\" name=\"quality\" />\r\n<param value=\"#FFFFFF\" name=\"bgcolor\" />\r\n<param value=\"always\" name=\"allowscriptaccess\" />\r\n<param value=\"http://ws.amazon.de/widgets/q?ServiceVersion=20070822&amp;MarketPlace=DE&amp;ID=V20070822%2FDE%2Fshootingstar-21%2F8014%2F70c58ca9-050c-41e1-960d-d7a3afef92de&amp;Operation=GetDisplayTemplate\" name=\"src\" /><embed id=\"Player_70c58ca9-050c-41e1-960d-d7a3afef92de\" src=\"http://ws.amazon.de/widgets/q?ServiceVersion=20070822&amp;MarketPlace=DE&amp;ID=V20070822%2FDE%2Fshootingstar-21%2F8014%2F70c58ca9-050c-41e1-960d-d7a3afef92de&amp;Operation=GetDisplayTemplate\" quality=\"high\" bgcolor=\"#FFFFFF\" allowscriptaccess=\"always\" height=\"250\" width=\"250\" type=\"application/x-shockwave-flash\"></embed>\r\n</object>\r\n</center></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n<td></td>\r\n<td>\r\n<table background=\"http://www.mylsfm.de/images/stories/webtechnik/webground/newsground2.png\" width=\"300\" style=\"height: 260px;\">\r\n<tbody>\r\n<tr>\r\n<td><br />\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td><a target=\"_blank\" href=\"http://www.amazon.de/gp/product/B001UNPQOQ?ie=UTF8&amp;tag=cdlexikon-21&amp;linkCode=as2&amp;camp=1638&amp;creative=6742&amp;creativeASIN=B001UNPQOQ\"><img width=\"100\" src=\"images/stories/webpicture/webmusic/ronan.jpg\" alt=\"Ronan Keating - Songs For My Mother\" height=\"75\" style=\"float: left; margin: 0px; border: 0px solid;\" title=\"Ronan Keating - Songs For My Mother\" /></a></td>\r\n<td valign=\"top\"><span class=\"massilink\"><a target=\"_blank\" href=\"http://www.amazon.de/gp/product/B001UNPQOQ?ie=UTF8&amp;tag=cdlexikon-21&amp;linkCode=as2&amp;camp=1638&amp;creative=6742&amp;creativeASIN=B001UNPQOQ\">Mit \"Songs for my Mother\" kehrt Ronan Keating zurück<br /></a></span>Lange haben wir von ihm nix gehört - jetzt kehrt er mit einem neuen Album zurück...<a target=\"_blank\" href=\"http://www.amazon.de/gp/product/B001UNPQOQ?ie=UTF8&amp;tag=cdlexikon-21&amp;linkCode=as2&amp;camp=1638&amp;creative=6742&amp;creativeASIN=B001UNPQOQ\">weiter<span></span></a></td>\r\n</tr>\r\n<tr height=\"30\">\r\n<td></td>\r\n<td></td>\r\n</tr>\r\n<tr>\r\n<td><a target=\"_blank\" href=\"http://www.eventim.de/cgi-bin/lafee-ring-frei-tour-2009-tickets-oberhausen.html?id=EVE_NO_SESSION&amp;fun=evdetail&amp;doc=evdetailb&amp;key=251582$553032\"><img width=\"100\" src=\"images/stories/webpicture/webmusic/lafee.jpg\" alt=\"LaFee live in Oberhausen\" height=\"75\" style=\"float: left; margin: 0px; border: 0px solid;\" title=\"LaFee live in Oberhausen\" /></a></td>\r\n<td valign=\"top\"><span class=\"massilink\"><a target=\"_blank\" href=\"http://www.eventim.de/cgi-bin/lafee-ring-frei-tour-2009-tickets-oberhausen.html?id=EVE_NO_SESSION&amp;fun=evdetail&amp;doc=evdetailb&amp;key=251582$553032\">LaFee live in Oberhausen - Jetzt noch Tickets sichern<br /></a></span>Deutschlands jüngste Künstlerin ist live in Oberhausen - jetzt könnt ihr noch Tickerts sichern...<a target=\"_blank\" href=\"http://www.eventim.de/cgi-bin/lafee-ring-frei-tour-2009-tickets-oberhausen.html?id=EVE_NO_SESSION&amp;fun=evdetail&amp;doc=evdetailb&amp;key=251582$553032\">weiter<span></span></a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</center><br /><center>\r\n<table background=\"http://www.livestylefm.de/images/stories/webtechnik/webgrund/newground3.jpg\" width=\"612\" style=\"height: 250px;\">\r\n<tbody>\r\n<tr>\r\n<td></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</center><br /><center>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td>\r\n<table background=\"http://www.livestylefm.de/images/stories/webtechnik/webgrund/newground41.jpg\" width=\"200\" style=\"height: 250px;\">\r\n<tbody>\r\n<tr height=\"20\">\r\n<td></td>\r\n</tr>\r\n<tr>\r\n<td><a target=\"_blank\" href=\"http://www.amazon.de/gp/product/B001RPAZ02?ie=UTF8&amp;tag=shootingstar-21&amp;linkCode=as2&amp;camp=1638&amp;creative=19454&amp;creativeASIN=B001RPAZ02\"><img width=\"192\" src=\"images/stories/webpicture/webmusic/pinkneu.jpg\" alt=\"Punk - Please Don\'t Leave Me\" height=\"100\" style=\"border: 0px solid;\" title=\"Punk - Please Don\'t Leave Me\" /></a></td>\r\n</tr>\r\n<tr>\r\n<td><a target=\"_blank\" href=\"http://www.amazon.de/gp/product/B001RPAZ02?ie=UTF8&amp;tag=shootingstar-21&amp;linkCode=as2&amp;camp=1638&amp;creative=19454&amp;creativeASIN=B001RPAZ02\">Live Style FM Musik Tipp:<br />Pink - Please don´t leave me</a></td>\r\n</tr>\r\n<tr>\r\n<td>Schon mit \"So What\" und \"Sober\" hatte sie einen mege Erfolg und jetzt zieht ihre neue Single direkt nach....<br /><br /><a target=\"_blank\" href=\"http://www.amazon.de/gp/product/B001RPAZ02?ie=UTF8&amp;tag=shootingstar-21&amp;linkCode=as2&amp;camp=1638&amp;creative=19454&amp;creativeASIN=B001RPAZ02\">&gt;&gt; Single jetzt downlaoden</a></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n<td>\r\n<table background=\"http://www.livestylefm.de/images/stories/webtechnik/webgrund/newground42.jpg\" width=\"200\" style=\"height: 250px;\">\r\n<tbody>\r\n<tr height=\"20\">\r\n<td></td>\r\n</tr>\r\n<tr>\r\n<td><a href=\"index.php/movies/40-movie/127-x-men-origins-wolverine-.html\"><img width=\"192\" src=\"images/stories/webpicture/webmovie/xmen.jpg\" alt=\"X-Men Origins: Wolverine\" height=\"100\" style=\"border: 0px solid;\" title=\"X-Men Origins: Wolverine\" /></a></td>\r\n</tr>\r\n<tr>\r\n<td><a href=\"index.php/movies/40-movie/127-x-men-origins-wolverine-.html\">Der neue X-Men Film lockt wieder Fans in die Kinos - sei auch dabei</a></td>\r\n</tr>\r\n<tr>\r\n<td>Es geht in die nächste Runde. X-Men Origins: Wolverine ist das neuste Abenteuer mit Hugh Jackmann....<br /><br /><a href=\"index.php/movies/40-movie/127-x-men-origins-wolverine-.html\">&gt;&gt; Mehr Informationen</a><span></span></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n<td>\r\n<table background=\"http://www.livestylefm.de/images/stories/webtechnik/webgrund/newground43.jpg\" width=\"200\" style=\"height: 250px;\">\r\n<tbody>\r\n<tr height=\"20\">\r\n<td></td>\r\n</tr>\r\n<tr>\r\n<td><a href=\"index.php/component/content/article/34-konzert/105-jean-luke-musiker-mit-leidenschaft.html\"><img width=\"192\" src=\"images/stories/webpicture/webmusic/jeanluke2.jpg\" alt=\"Jean Luke on Tour\" height=\"100\" style=\"border: 0px solid;\" title=\"Jean Luke on Tour\" /></a></td>\r\n</tr>\r\n<tr>\r\n<td><a href=\"index.php/component/content/article/34-konzert/105-jean-luke-musiker-mit-leidenschaft.html\">MyLSFM Newcomer: Jean Luke ist auf Tour - seit dabei</a></td>\r\n</tr>\r\n<tr>\r\n<td>Wer die Musik von Jean Luke nochmal erleben will, der kann jetzt noch dabei sein. Bremen und Hamburg begrüsst....<br /><br /><a href=\"index.php/component/content/article/34-konzert/105-jean-luke-musiker-mit-leidenschaft.html\">&gt;&gt; Mehr Informationen</a><span></span></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</center>','',1,3,0,31,'2006-10-10 23:16:20',62,'','2009-05-05 21:05:40',62,0,'0000-00-00 00:00:00','2006-10-10 04:00:00','0000-00-00 00:00:00','','','show_title=0\nlink_titles=\nshow_intro=\nshow_section=\nlink_section=\nshow_category=\nlink_category=\nshow_vote=\nshow_author=0\nshow_create_date=0\nshow_modify_date=0\nshow_pdf_icon=0\nshow_print_icon=0\nshow_email_icon=0\nlanguage=\nkeyref=\nreadmore=',65,0,1,'','',0,4,'robots=\nauthor=');
/*!40000 ALTER TABLE `mylsfm_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_content_frontpage`
--

DROP TABLE IF EXISTS `mylsfm_content_frontpage`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_content_frontpage` (
  `content_id` int(11) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_content_frontpage`
--

LOCK TABLES `mylsfm_content_frontpage` WRITE;
/*!40000 ALTER TABLE `mylsfm_content_frontpage` DISABLE KEYS */;
INSERT INTO `mylsfm_content_frontpage` VALUES (36,1);
/*!40000 ALTER TABLE `mylsfm_content_frontpage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_content_rating`
--

DROP TABLE IF EXISTS `mylsfm_content_rating`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_content_rating` (
  `content_id` int(11) NOT NULL default '0',
  `rating_sum` int(11) unsigned NOT NULL default '0',
  `rating_count` int(11) unsigned NOT NULL default '0',
  `lastip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_content_rating`
--

LOCK TABLES `mylsfm_content_rating` WRITE;
/*!40000 ALTER TABLE `mylsfm_content_rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `mylsfm_content_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_core_acl_aro`
--

DROP TABLE IF EXISTS `mylsfm_core_acl_aro`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_core_acl_aro` (
  `id` int(11) NOT NULL auto_increment,
  `section_value` varchar(240) NOT NULL default '0',
  `value` varchar(240) NOT NULL default '',
  `order_value` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `mylsfm_section_value_value_aro` (`section_value`(100),`value`(100)),
  KEY `mylsfm_gacl_hidden_aro` (`hidden`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_core_acl_aro`
--

LOCK TABLES `mylsfm_core_acl_aro` WRITE;
/*!40000 ALTER TABLE `mylsfm_core_acl_aro` DISABLE KEYS */;
INSERT INTO `mylsfm_core_acl_aro` VALUES (10,'users','62',0,'Mellimaus',0),(11,'users','63',0,'nekrad',0);
/*!40000 ALTER TABLE `mylsfm_core_acl_aro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_core_acl_aro_groups`
--

DROP TABLE IF EXISTS `mylsfm_core_acl_aro_groups`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_core_acl_aro_groups` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `lft` int(11) NOT NULL default '0',
  `rgt` int(11) NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `mylsfm_gacl_parent_id_aro_groups` (`parent_id`),
  KEY `mylsfm_gacl_lft_rgt_aro_groups` (`lft`,`rgt`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_core_acl_aro_groups`
--

LOCK TABLES `mylsfm_core_acl_aro_groups` WRITE;
/*!40000 ALTER TABLE `mylsfm_core_acl_aro_groups` DISABLE KEYS */;
INSERT INTO `mylsfm_core_acl_aro_groups` VALUES (17,0,'ROOT',1,22,'ROOT'),(28,17,'USERS',2,21,'USERS'),(29,28,'Public Frontend',3,12,'Public Frontend'),(18,29,'Registered',4,11,'Registered'),(19,18,'Author',5,10,'Author'),(20,19,'Editor',6,9,'Editor'),(21,20,'Publisher',7,8,'Publisher'),(30,28,'Public Backend',13,20,'Public Backend'),(23,30,'Manager',14,19,'Manager'),(24,23,'Administrator',15,18,'Administrator'),(25,24,'Super Administrator',16,17,'Super Administrator');
/*!40000 ALTER TABLE `mylsfm_core_acl_aro_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_core_acl_aro_map`
--

DROP TABLE IF EXISTS `mylsfm_core_acl_aro_map`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_core_acl_aro_map` (
  `acl_id` int(11) NOT NULL default '0',
  `section_value` varchar(230) NOT NULL default '0',
  `value` varchar(100) NOT NULL,
  PRIMARY KEY  (`acl_id`,`section_value`,`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_core_acl_aro_map`
--

LOCK TABLES `mylsfm_core_acl_aro_map` WRITE;
/*!40000 ALTER TABLE `mylsfm_core_acl_aro_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `mylsfm_core_acl_aro_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_core_acl_aro_sections`
--

DROP TABLE IF EXISTS `mylsfm_core_acl_aro_sections`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_core_acl_aro_sections` (
  `id` int(11) NOT NULL auto_increment,
  `value` varchar(230) NOT NULL default '',
  `order_value` int(11) NOT NULL default '0',
  `name` varchar(230) NOT NULL default '',
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `mylsfm_gacl_value_aro_sections` (`value`),
  KEY `mylsfm_gacl_hidden_aro_sections` (`hidden`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_core_acl_aro_sections`
--

LOCK TABLES `mylsfm_core_acl_aro_sections` WRITE;
/*!40000 ALTER TABLE `mylsfm_core_acl_aro_sections` DISABLE KEYS */;
INSERT INTO `mylsfm_core_acl_aro_sections` VALUES (10,'users',1,'Users',0);
/*!40000 ALTER TABLE `mylsfm_core_acl_aro_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_core_acl_groups_aro_map`
--

DROP TABLE IF EXISTS `mylsfm_core_acl_groups_aro_map`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_core_acl_groups_aro_map` (
  `group_id` int(11) NOT NULL default '0',
  `section_value` varchar(240) NOT NULL default '',
  `aro_id` int(11) NOT NULL default '0',
  UNIQUE KEY `group_id_aro_id_groups_aro_map` (`group_id`,`section_value`,`aro_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_core_acl_groups_aro_map`
--

LOCK TABLES `mylsfm_core_acl_groups_aro_map` WRITE;
/*!40000 ALTER TABLE `mylsfm_core_acl_groups_aro_map` DISABLE KEYS */;
INSERT INTO `mylsfm_core_acl_groups_aro_map` VALUES (25,'',10),(25,'',11);
/*!40000 ALTER TABLE `mylsfm_core_acl_groups_aro_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_core_log_items`
--

DROP TABLE IF EXISTS `mylsfm_core_log_items`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_core_log_items` (
  `time_stamp` date NOT NULL default '0000-00-00',
  `item_table` varchar(50) NOT NULL default '',
  `item_id` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_core_log_items`
--

LOCK TABLES `mylsfm_core_log_items` WRITE;
/*!40000 ALTER TABLE `mylsfm_core_log_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `mylsfm_core_log_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_core_log_searches`
--

DROP TABLE IF EXISTS `mylsfm_core_log_searches`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_core_log_searches` (
  `search_term` varchar(128) NOT NULL default '',
  `hits` int(11) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_core_log_searches`
--

LOCK TABLES `mylsfm_core_log_searches` WRITE;
/*!40000 ALTER TABLE `mylsfm_core_log_searches` DISABLE KEYS */;
/*!40000 ALTER TABLE `mylsfm_core_log_searches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_groups`
--

DROP TABLE IF EXISTS `mylsfm_groups`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_groups` (
  `id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_groups`
--

LOCK TABLES `mylsfm_groups` WRITE;
/*!40000 ALTER TABLE `mylsfm_groups` DISABLE KEYS */;
INSERT INTO `mylsfm_groups` VALUES (0,'Public'),(1,'Registered'),(2,'Special');
/*!40000 ALTER TABLE `mylsfm_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_jce_extensions`
--

DROP TABLE IF EXISTS `mylsfm_jce_extensions`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_jce_extensions` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `extension` varchar(255) NOT NULL,
  `folder` varchar(255) NOT NULL,
  `published` tinyint(3) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_jce_extensions`
--

LOCK TABLES `mylsfm_jce_extensions` WRITE;
/*!40000 ALTER TABLE `mylsfm_jce_extensions` DISABLE KEYS */;
INSERT INTO `mylsfm_jce_extensions` VALUES (1,15,'Joomla Links for Advanced Link','joomlalinks','links',1);
/*!40000 ALTER TABLE `mylsfm_jce_extensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_jce_groups`
--

DROP TABLE IF EXISTS `mylsfm_jce_groups`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_jce_groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `users` text NOT NULL,
  `types` varchar(255) NOT NULL,
  `rows` text NOT NULL,
  `plugins` varchar(255) NOT NULL,
  `published` tinyint(3) NOT NULL,
  `ordering` int(11) NOT NULL,
  `checked_out` tinyint(3) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_jce_groups`
--

LOCK TABLES `mylsfm_jce_groups` WRITE;
/*!40000 ALTER TABLE `mylsfm_jce_groups` DISABLE KEYS */;
INSERT INTO `mylsfm_jce_groups` VALUES (1,'Default','Default group for all users with edit access','','19,20,21,23,24,25','28,32,33,27,19,20,21,30,31,36,37,29,43,44,45,46,49,26;2,34,39,40,42,38,5,9,15,23,48,47,56,41;22,18,25,24,7,10,11,12;4,8,6,17,13,3,54,14,16,35','52,55,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,28,54',1,1,0,'0000-00-00 00:00:00','editor_dir=images/stories\neditor_max_size=1024\neditor_toggle=1\neditor_theme_advanced_toolbar_location=top\neditor_skin=default\neditor_skin_variant=default\neditor_inlinepopups_skin=clearlooks2\neditor_allow_script=1\neditor_allow_php=1\npaste_create_paragraphs=1\npaste_create_linebreaks=1\npaste_use_dialog=0\npaste_auto_cleanup_on_paste=0\npaste_strip_class_attributes=all\npaste_remove_spans=0\npaste_remove_styles=0\nimgmanager_dir=\nimgmanager_max_size=\nimgmanager_hspace=5\nimgmanager_vspace=5\nimgmanager_border=0\nimgmanager_border_width=1\nimgmanager_border_style=solid\nimgmanager_border_color=#000000\nimgmanager_align=left\nimgmanager_upload=1\nimgmanager_folder_new=1\nimgmanager_folder_delete=1\nimgmanager_folder_rename=1\nimgmanager_file_delete=1\nimgmanager_file_rename=1\nimgmanager_file_move=1\nadvlink_target=_self\nadvlink_article=1\nadvlink_section=1\nadvlink_category=1\nadvlink_static=1\nadvlink_contact=1\nspellchecker_engine=googlespell\nspellchecker_languages=English=en\nspellchecker_pspell_mode=PSPELL_FAST\nspellchecker_pspell_spelling=\nspellchecker_pspell_jargon=\nspellchecker_pspell_encoding=\nspellchecker_pspellshell_aspell=/usr/bin/aspell\nspellchecker_pspellshell_tmp=/tmp\nbrowser_dir=\nbrowser_max_size=\nbrowser_upload=1\nbrowser_folder_new=1\nbrowser_folder_delete=1\nbrowser_folder_rename=1\nbrowser_file_delete=1\nbrowser_file_rename=1\nbrowser_file_move=1\nmedia_use_script=0\nmedia_codebase_flash=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0\nmedia_codebase_shockwave=http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#version=8,5,1,0\nmedia_codebase_mplayer=http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701\nmedia_codebase_quicktime=http://www.apple.com/qtactivex/qtplugin.cab#version=6,0,2,0\nmedia_codebase_realplayer=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0\nmedia_codebase_divx=http://go.divx.com/plugin/DivXBrowserPlugin.cab\n\n');
/*!40000 ALTER TABLE `mylsfm_jce_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_jce_plugins`
--

DROP TABLE IF EXISTS `mylsfm_jce_plugins`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_jce_plugins` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `name` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL default 'plugin',
  `icon` varchar(255) NOT NULL default '',
  `layout` varchar(255) NOT NULL,
  `row` int(11) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `published` tinyint(3) NOT NULL default '0',
  `editable` tinyint(3) NOT NULL default '0',
  `elements` varchar(255) NOT NULL default '',
  `iscore` tinyint(3) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `params` text NOT NULL,
  `variables` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `plugin` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_jce_plugins`
--

LOCK TABLES `mylsfm_jce_plugins` WRITE;
/*!40000 ALTER TABLE `mylsfm_jce_plugins` DISABLE KEYS */;
INSERT INTO `mylsfm_jce_plugins` VALUES (1,'Context Menu','contextmenu','plugin','','',0,14,1,0,'',1,0,'0000-00-00 00:00:00','',''),(2,'Directionality','directionality','plugin','ltr,rtl','directionality',3,21,1,0,'',1,0,'0000-00-00 00:00:00','',''),(3,'Emotions','emotions','plugin','emotions','emotions',3,19,1,0,'',1,0,'0000-00-00 00:00:00','',''),(4,'Fullscreen','fullscreen','plugin','fullscreen','fullscreen',3,22,1,0,'',1,0,'0000-00-00 00:00:00','',''),(5,'Paste','paste','plugin','pasteword,pastetext','paste',2,10,1,1,'',1,0,'0000-00-00 00:00:00','',''),(6,'Preview','preview','plugin','preview','preview',3,24,1,0,'',1,0,'0000-00-00 00:00:00','',''),(7,'Tables','table','plugin','tablecontrols','buttons',3,6,1,0,'',1,0,'0000-00-00 00:00:00','',''),(8,'Print','print','plugin','print','print',3,20,1,0,'',1,0,'0000-00-00 00:00:00','',''),(9,'Search Replace','searchreplace','plugin','search,replace','searchreplace',2,13,1,0,'',1,0,'0000-00-00 00:00:00','',''),(10,'Styles','style','plugin','styles','styles',4,11,1,0,'',1,0,'0000-00-00 00:00:00','',''),(11,'Non-Breaking','nonbreaking','plugin','nonbreaking','nonbreaking',4,16,1,0,'',1,0,'0000-00-00 00:00:00','',''),(12,'Visual Characters','visualchars','plugin','visualchars','visualchars',4,15,1,0,'',1,0,'0000-00-00 00:00:00','',''),(13,'XHTML Xtras','xhtmlxtras','plugin','cite,abbr,acronym,del,ins,attribs','xhtmlxtras',4,12,1,0,'',1,0,'0000-00-00 00:00:00','',''),(14,'Image Manager','imgmanager','plugin','imgmanager','imgmanager',4,25,1,1,'',1,0,'0000-00-00 00:00:00','',''),(15,'Advanced Link','advlink','plugin','advlink','advlink',4,26,1,1,'',1,0,'0000-00-00 00:00:00','',''),(16,'Spell Checker','spellchecker','plugin','spellchecker','spellchecker',4,17,1,1,'',1,0,'0000-00-00 00:00:00','',''),(17,'Layers','layer','plugin','insertlayer,moveforward,movebackward,absolute','layer',4,5,1,0,'',1,0,'0000-00-00 00:00:00','',''),(18,'Font ForeColour','forecolor','command','forecolor','forecolor',2,17,1,0,'',1,0,'0000-00-00 00:00:00','',''),(19,'Bold','bold','command','bold','bold',1,2,1,0,'',1,0,'0000-00-00 00:00:00','',''),(20,'Italic','italic','command','italic','italic',1,3,1,0,'',1,0,'0000-00-00 00:00:00','',''),(21,'Underline','underline','command','underline','underline',1,4,1,0,'',1,0,'0000-00-00 00:00:00','',''),(22,'Font BackColour','backcolor','command','backcolor','backcolor',2,18,1,0,'',1,0,'0000-00-00 00:00:00','',''),(23,'Unlink','unlink','command','unlink','unlink',2,11,1,0,'',1,0,'0000-00-00 00:00:00','',''),(24,'Font Select','fontselect','command','fontselect','fontselect',1,12,1,0,'',1,0,'0000-00-00 00:00:00','',''),(25,'Font Size Select','fontsizeselect','command','fontsizeselect','fontsizeselect',1,13,1,0,'',1,0,'0000-00-00 00:00:00','',''),(26,'Style Select','styleselect','command','styleselect','styleselect',1,10,1,0,'',1,0,'0000-00-00 00:00:00','',''),(27,'New Document','newdocument','command','newdocument','newdocument',1,1,1,0,'',1,0,'0000-00-00 00:00:00','',''),(28,'Help','help','plugin','help','help',1,1,1,0,'',1,0,'0000-00-00 00:00:00','',''),(29,'StrikeThrough','strikethrough','command','strikethrough','strikethrough',1,5,1,0,'',1,0,'0000-00-00 00:00:00','',''),(30,'Indent','indent','command','indent','indent',2,7,1,0,'',1,0,'0000-00-00 00:00:00','',''),(31,'Outdent','outdent','command','outdent','outdent',2,6,1,0,'',1,0,'0000-00-00 00:00:00','',''),(32,'Undo','undo','command','undo','undo',2,8,1,0,'',1,0,'0000-00-00 00:00:00','',''),(33,'Redo','redo','command','redo','redo',2,9,1,0,'',1,0,'0000-00-00 00:00:00','',''),(34,'Horizontal Rule','hr','command','hr','hr',3,2,1,0,'',1,0,'0000-00-00 00:00:00','',''),(35,'HTML','html','command','code','code',2,16,1,0,'',1,0,'0000-00-00 00:00:00','',''),(36,'Numbered List','numlist','command','numlist','numlist',2,5,1,0,'',1,0,'0000-00-00 00:00:00','',''),(37,'Bullet List','bullist','command','bullist','bullist',2,4,1,0,'',1,0,'0000-00-00 00:00:00','',''),(38,'Clipboard Actions','clipboard','command','cut,copy,paste','clipboard',2,1,1,0,'',1,0,'0000-00-00 00:00:00','',''),(39,'Subscript','sub','command','sub','sub',3,5,1,0,'',1,0,'0000-00-00 00:00:00','',''),(40,'Superscript','sup','command','sup','sup',3,6,1,0,'',1,0,'0000-00-00 00:00:00','',''),(41,'Visual Aid','visualaid','command','visualaid','visualaid',3,4,1,0,'',1,0,'0000-00-00 00:00:00','',''),(42,'Character Map','charmap','command','charmap','charmap',3,7,1,0,'',1,0,'0000-00-00 00:00:00','',''),(43,'Justify Full','full','command','justifyfull','justifyfull',1,8,1,0,'',1,0,'0000-00-00 00:00:00','',''),(44,'Justify Center','center','command','justifycenter','justifycenter',1,7,1,0,'',1,0,'0000-00-00 00:00:00','',''),(45,'Justify Left','left','command','justifyleft','justifyleft',1,6,1,0,'',1,0,'0000-00-00 00:00:00','',''),(46,'Justify Right','right','command','justifyright','justifyright',1,9,1,0,'',1,0,'0000-00-00 00:00:00','',''),(47,'Remove Format','removeformat','command','removeformat','removeformat',3,3,1,0,'',1,0,'0000-00-00 00:00:00','',''),(48,'Anchor','anchor','command','anchor','anchor',2,12,1,0,'',1,0,'0000-00-00 00:00:00','',''),(49,'Format Select','formatselect','command','formatselect','formatselect',1,11,1,0,'',1,0,'0000-00-00 00:00:00','',''),(50,'Image','image','command','image','image',2,13,1,0,'',1,0,'0000-00-00 00:00:00','',''),(51,'Link','link','command','link','link',2,10,1,0,'',1,0,'0000-00-00 00:00:00','',''),(52,'Browser','browser','plugin','','',0,23,1,1,'',1,0,'0000-00-00 00:00:00','',''),(53,'Inline Popups','inlinepopups','plugin','','',0,7,1,0,'',1,0,'0000-00-00 00:00:00','',''),(54,'Read More','readmore','plugin','readmore','readmore',4,18,1,0,'',1,0,'0000-00-00 00:00:00','',''),(55,'Media','media','plugin','','',0,3,1,1,'',1,0,'0000-00-00 00:00:00','\r\n\r\n',''),(56,'Code Cleanup','cleanup','command','cleanup','cleanup',2,14,1,0,'',1,0,'0000-00-00 00:00:00','',''),(57,'Safari Browser Support','safari','plugin','','',0,8,1,0,'',1,0,'0000-00-00 00:00:00','',''),(58,'TinyMCE 2.x Compatability','compat2x','plugin','','',0,9,1,0,'',1,0,'0000-00-00 00:00:00','',''),(59,'Advanced Code Editor','advcode','plugin','advcode','advcode',4,2,1,0,'',1,0,'0000-00-00 00:00:00','','');
/*!40000 ALTER TABLE `mylsfm_jce_plugins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_menu`
--

DROP TABLE IF EXISTS `mylsfm_menu`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_menu` (
  `id` int(11) NOT NULL auto_increment,
  `menutype` varchar(75) default NULL,
  `name` varchar(255) default NULL,
  `alias` varchar(255) NOT NULL default '',
  `link` text,
  `type` varchar(50) NOT NULL default '',
  `published` tinyint(1) NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `componentid` int(11) unsigned NOT NULL default '0',
  `sublevel` int(11) default '0',
  `ordering` int(11) default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `pollid` int(11) NOT NULL default '0',
  `browserNav` tinyint(4) default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `utaccess` tinyint(3) unsigned NOT NULL default '0',
  `params` text NOT NULL,
  `lft` int(11) unsigned NOT NULL default '0',
  `rgt` int(11) unsigned NOT NULL default '0',
  `home` int(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `componentid` (`componentid`,`menutype`,`published`,`access`),
  KEY `menutype` (`menutype`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_menu`
--

LOCK TABLES `mylsfm_menu` WRITE;
/*!40000 ALTER TABLE `mylsfm_menu` DISABLE KEYS */;
INSERT INTO `mylsfm_menu` VALUES (1,'mainmenu','Startseite','home','index.php?option=com_content&view=frontpage','component',1,0,20,0,1,0,'0000-00-00 00:00:00',0,0,0,3,'num_leading_articles=1\nnum_intro_articles=4\nnum_columns=2\nnum_links=4\norderby_pri=\norderby_sec=front\nmulti_column_order=1\nshow_pagination=2\nshow_pagination_results=1\nshow_feed_link=1\nshow_noauth=0\nshow_title=1\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1\nfeed_summary=\npage_title=Willkommen auf der Startseite\nshow_page_title=0\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n',0,0,1),(2,'mainmenu','Joomla!-Lizenz','joomla-lizenz','index.php?option=com_content&view=article&id=5','component',1,0,20,0,3,0,'0000-00-00 00:00:00',0,0,0,0,'pageclass_sfx=\nmenu_image=-1\nsecure=0\nshow_noauth=0\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1\n\n',0,0,0),(41,'mainmenu','FAQ','faq','index.php?option=com_content&view=section&id=3','component',1,0,20,0,5,0,'0000-00-00 00:00:00',0,0,0,0,'show_page_title=1\nshow_description=0\nshow_description_image=0\nshow_categories=1\nshow_empty_categories=0\nshow_cat_num_articles=1\nshow_category_description=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\norderby=\nshow_noauth=0\nshow_title=1\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1',0,0,0),(11,'othermenu','Joomla!-Home','joomla-home','http://www.joomla.org','url',1,0,0,0,1,0,'0000-00-00 00:00:00',0,0,0,3,'menu_image=-1\n\n',0,0,0),(12,'othermenu','Joomla!-Foren','joomla-forums','http://forum.joomla.org','url',1,0,0,0,2,0,'0000-00-00 00:00:00',0,0,0,3,'menu_image=-1\n\n',0,0,0),(13,'othermenu','Joomla!-Hilfe','joomla-help','http://help.joomla.org','url',1,0,0,0,3,0,'0000-00-00 00:00:00',0,0,0,3,'menu_image=-1\n\n',0,0,0),(14,'othermenu','Joomla! Community','joomla-community','http://community.joomla.org','url',1,0,0,0,4,0,'0000-00-00 00:00:00',0,0,0,3,'menu_image=-1\n\n',0,0,0),(15,'othermenu','Joomla! Magazin','joomla-community-magazin','http://community.joomla.org/magazine.html','url',1,0,0,0,5,0,'0000-00-00 00:00:00',0,0,0,3,'menu_image=-1\n\n',0,0,0),(16,'othermenu','OSM Home','osm-home','http://www.opensourcematters.org','url',1,0,0,0,4,0,'0000-00-00 00:00:00',0,0,0,4,'menu_image=-1\n\n',0,0,0),(17,'othermenu','Administrator','administrator','administrator/','url',1,0,0,0,5,0,'0000-00-00 00:00:00',0,0,0,3,'menu_image=-1\n\n',0,0,0),(18,'topmenu','News','news','index.php?option=com_newsfeeds&view=newsfeed&id=1&feedid=1','component',1,0,11,0,3,0,'0000-00-00 00:00:00',0,0,0,3,'show_page_title=1\npage_title=News\npageclass_sfx=\nmenu_image=-1\nsecure=0\nshow_headings=1\nshow_name=1\nshow_articles=1\nshow_link=1\nshow_other_cats=1\nshow_cat_description=1\nshow_cat_items=1\nshow_feed_image=1\nshow_feed_description=1\nshow_item_description=1\nfeed_word_count=0\n\n',0,0,0),(20,'usermenu','Ihre Details','ihre-details','index.php?option=com_user&view=user&task=edit','component',1,0,14,0,1,0,'0000-00-00 00:00:00',0,0,1,3,'',0,0,0),(24,'usermenu','Abmelden','abmelden','index.php?option=com_user&view=login','component',1,0,14,0,4,0,'0000-00-00 00:00:00',0,0,1,3,'',0,0,0),(38,'keyconcepts','Inhaltlayouts','inhaltlayouts','index.php?option=com_content&view=article&id=24','component',1,0,20,0,2,0,'0000-00-00 00:00:00',0,0,0,0,'pageclass_sfx=\nmenu_image=-1\nsecure=0\nshow_noauth=0\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1\n\n',0,0,0),(27,'mainmenu','Joomla! im Überblick','joomla-overview','index.php?option=com_content&view=article&id=19','component',1,0,20,0,2,0,'0000-00-00 00:00:00',0,0,0,0,'pageclass_sfx=\nmenu_image=-1\nsecure=0\nshow_noauth=0\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1\n\n',0,0,0),(28,'topmenu','Über Joomla!','about-joomla','index.php?option=com_content&view=article&id=25','component',1,0,20,0,1,0,'0000-00-00 00:00:00',0,0,0,0,'pageclass_sfx=\nmenu_image=-1\nsecure=0\nshow_noauth=0\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1\n\n',0,0,0),(29,'topmenu','Merkmale','merkmale','index.php?option=com_content&view=article&id=22','component',1,0,20,0,2,0,'0000-00-00 00:00:00',0,0,0,0,'pageclass_sfx=\nmenu_image=-1\nsecure=0\nshow_noauth=0\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1\n\n',0,0,0),(30,'topmenu','Die Community','die-community','index.php?option=com_content&view=article&id=27','component',1,0,20,0,4,0,'0000-00-00 00:00:00',0,0,0,0,'pageclass_sfx=\nmenu_image=-1\nsecure=0\nshow_noauth=0\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1\n\n',0,0,0),(34,'mainmenu','Was ist neu in 1.5?','was-ist-neu-in-1-5','index.php?option=com_content&view=article&id=22','component',1,27,20,1,1,0,'0000-00-00 00:00:00',0,0,0,0,'pageclass_sfx=\nmenu_image=-1\nsecure=0\nshow_noauth=0\nshow_title=1\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1\n\n',0,0,0),(40,'keyconcepts','Erweiterungen','erweiterungen','index.php?option=com_content&view=article&id=26','component',1,0,20,0,1,0,'0000-00-00 00:00:00',0,0,0,0,'pageclass_sfx=\nmenu_image=-1\nsecure=0\nshow_noauth=0\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1\n\n',0,0,0),(37,'mainmenu','Mehr über Joomla!','mehr-ueber-joomla','index.php?option=com_content&view=section&id=4','component',1,0,20,0,4,0,'0000-00-00 00:00:00',0,0,0,0,'show_page_title=1\nshow_description=0\nshow_description_image=0\nshow_categories=1\nshow_empty_categories=0\nshow_cat_num_articles=1\nshow_category_description=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\norderby=\nshow_noauth=0\nshow_title=1\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1',0,0,0),(43,'keyconcepts','Beispielseiten','beispielseiten','index.php?option=com_content&view=article&id=43','component',1,0,20,0,3,0,'0000-00-00 00:00:00',0,0,0,0,'pageclass_sfx=\nmenu_image=-1\nsecure=0\nshow_noauth=0\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1\n\n',0,0,0),(44,'ExamplePages','Bereich als Blog','bereich-als-blog','index.php?option=com_content&view=section&layout=blog&id=3','component',1,0,20,0,1,0,'0000-00-00 00:00:00',0,0,0,0,'show_page_title=1\npage_title=Beispiel eines Bereichs-Blog-Layout (FAQ-Bereich)\nshow_description=0\nshow_description_image=0\nnum_leading_articles=1\nnum_intro_articles=4\nnum_columns=2\nnum_links=4\nshow_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\norderby_pri=\norderby_sec=\nshow_pagination=2\nshow_pagination_results=1\nshow_noauth=0\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1\n\n',0,0,0),(45,'ExamplePages','Bereich als Tabelle','bereich-als-tabelle','index.php?option=com_content&view=section&id=3','component',1,0,20,0,2,0,'0000-00-00 00:00:00',0,0,0,0,'show_page_title=1\npage_title=Beispiel eines Bereichs-Layout (Joomla!-Standard) (FAQ-Bereich)\nshow_description=0\nshow_description_image=0\nshow_categories=1\nshow_empty_categories=0\nshow_cat_num_articles=1\nshow_category_description=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\norderby=\nshow_noauth=0\nshow_title=1\nnlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1\n\n',0,0,0),(46,'ExamplePages','Kategorie als Blog','kategorie-als-blog','index.php?option=com_content&view=category&layout=blog&id=31','component',1,0,20,0,3,0,'0000-00-00 00:00:00',0,0,0,0,'show_page_title=1\npage_title=Beispiel eines Kategorie-Blog-Layouts (FAQ/Allgemein-Kategorie)\nshow_description=0\nshow_description_image=0\nnum_leading_articles=1\nnum_intro_articles=4\nnum_columns=2\nnum_links=4\nshow_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\norderby_pri=\norderby_sec=\nshow_pagination=2\nshow_pagination_results=1\nshow_noauth=0\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1\n\n',0,0,0),(47,'ExamplePages','Kategorie als Tabelle','kategorie-als-tabelle','index.php?option=com_content&view=category&id=32','component',1,0,20,0,4,0,'0000-00-00 00:00:00',0,0,0,0,'show_page_title=1\npage_title=Beispiel eines Kategorie-Listen-Layouts (Joomla!-Standard) (FAQ/Sprachen-Kategorie)\nshow_headings=1\nshow_date=0\ndate_format=\nfilter=1\nfilter_type=title\npageclass_sfx=\nmenu_image=-1\nsecure=0\norderby_sec=\nshow_pagination=1\nshow_pagination_limit=1\nshow_noauth=0\nshow_title=1\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1\n\n',0,0,0),(48,'mainmenu','Weblinks','weblinks','index.php?option=com_weblinks&view=categories','component',1,0,4,0,7,0,'0000-00-00 00:00:00',0,0,0,0,'page_title=Weblinks\nimage=-1\nimage_align=right\npageclass_sfx=\nmenu_image=-1\nsecure=0\nshow_comp_description=1\ncomp_description=\nshow_link_hits=1\nshow_link_description=1\nshow_other_cats=1\nshow_headings=1\nshow_page_title=1\nlink_target=0\nlink_icons=\n\n',0,0,0),(49,'mainmenu','Newsfeeds','newsfeeds','index.php?option=com_newsfeeds&view=categories','component',1,0,11,0,8,0,'0000-00-00 00:00:00',0,0,0,0,'show_page_title=1\npage_title=Newsfeeds\nshow_comp_description=1\ncomp_description=\nimage=-1\nimage_align=right\npageclass_sfx=\nmenu_image=-1\nsecure=0\nshow_headings=1\nshow_name=1\nshow_articles=1\nshow_link=1\nshow_other_cats=1\nshow_cat_description=1\nshow_cat_items=1\nshow_feed_image=1\nshow_feed_description=1\nshow_item_description=1\nfeed_word_count=0\n\n',0,0,0),(50,'mainmenu','Neuigkeiten','neuigkeiten','index.php?option=com_content&view=category&layout=blog&id=1','component',1,0,20,0,6,0,'0000-00-00 00:00:00',0,0,0,0,'show_page_title=1\npage_title=The News\nshow_description=0\nshow_description_image=0\nnum_leading_articles=1\nnum_intro_articles=4\nnum_columns=2\nnum_links=4\nshow_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\norderby_pri=\norderby_sec=\nshow_pagination=2\nshow_pagination_results=1\nshow_noauth=0\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1\n\n',0,0,0),(51,'usermenu','Beitrag einreichen','beitrag-einreichen','index.php?option=com_content&view=article&layout=form','component',1,0,20,0,2,0,'0000-00-00 00:00:00',0,0,2,0,'',0,0,0),(52,'usermenu','Weblink einreichen','weblink-einreichen','index.php?option=com_weblinks&view=weblink&layout=form','component',1,0,4,0,3,0,'0000-00-00 00:00:00',0,0,2,0,'',0,0,0);
/*!40000 ALTER TABLE `mylsfm_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_menu_types`
--

DROP TABLE IF EXISTS `mylsfm_menu_types`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_menu_types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `menutype` varchar(75) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `menutype` (`menutype`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_menu_types`
--

LOCK TABLES `mylsfm_menu_types` WRITE;
/*!40000 ALTER TABLE `mylsfm_menu_types` DISABLE KEYS */;
INSERT INTO `mylsfm_menu_types` VALUES (1,'mainmenu','Hauptmenü','Das Hauptmenü dieser Website'),(2,'usermenu','Benutzermenü','Ein Menü für angemeldete Benutzer'),(3,'topmenu','Menü oben','Menü oben'),(4,'othermenu','Weiteres Menü','Zusätzliche Links'),(5,'ExamplePages','Beispielseiten','Beispielseiten'),(6,'keyconcepts','Schlüsselkonzepte','Beschreibung einiger kritischer Informationen für neue Benutzer.');
/*!40000 ALTER TABLE `mylsfm_menu_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_messages`
--

DROP TABLE IF EXISTS `mylsfm_messages`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_messages` (
  `message_id` int(10) unsigned NOT NULL auto_increment,
  `user_id_from` int(10) unsigned NOT NULL default '0',
  `user_id_to` int(10) unsigned NOT NULL default '0',
  `folder_id` int(10) unsigned NOT NULL default '0',
  `date_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `state` int(11) NOT NULL default '0',
  `priority` int(1) unsigned NOT NULL default '0',
  `subject` text NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY  (`message_id`),
  KEY `useridto_state` (`user_id_to`,`state`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_messages`
--

LOCK TABLES `mylsfm_messages` WRITE;
/*!40000 ALTER TABLE `mylsfm_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `mylsfm_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_messages_cfg`
--

DROP TABLE IF EXISTS `mylsfm_messages_cfg`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_messages_cfg` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `cfg_name` varchar(100) NOT NULL default '',
  `cfg_value` varchar(255) NOT NULL default '',
  UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_messages_cfg`
--

LOCK TABLES `mylsfm_messages_cfg` WRITE;
/*!40000 ALTER TABLE `mylsfm_messages_cfg` DISABLE KEYS */;
/*!40000 ALTER TABLE `mylsfm_messages_cfg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_migration_backlinks`
--

DROP TABLE IF EXISTS `mylsfm_migration_backlinks`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_migration_backlinks` (
  `itemid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `url` text NOT NULL,
  `sefurl` text NOT NULL,
  `newurl` text NOT NULL,
  PRIMARY KEY  (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_migration_backlinks`
--

LOCK TABLES `mylsfm_migration_backlinks` WRITE;
/*!40000 ALTER TABLE `mylsfm_migration_backlinks` DISABLE KEYS */;
/*!40000 ALTER TABLE `mylsfm_migration_backlinks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_modules`
--

DROP TABLE IF EXISTS `mylsfm_modules`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_modules` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  `position` varchar(50) default NULL,
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `module` varchar(50) default NULL,
  `numnews` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `showtitle` tinyint(3) unsigned NOT NULL default '1',
  `params` text NOT NULL,
  `iscore` tinyint(4) NOT NULL default '0',
  `client_id` tinyint(4) NOT NULL default '0',
  `control` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_modules`
--

LOCK TABLES `mylsfm_modules` WRITE;
/*!40000 ALTER TABLE `mylsfm_modules` DISABLE KEYS */;
INSERT INTO `mylsfm_modules` VALUES (1,'Hauptmenü','',1,'left',0,'0000-00-00 00:00:00',1,'mod_mainmenu',0,0,1,'menutype=mainmenu\nmoduleclass_sfx=_menu\n',1,0,''),(2,'Anmeldung','',1,'login',0,'0000-00-00 00:00:00',1,'mod_login',0,0,1,'',1,1,''),(3,'Beliebt','',4,'cpanel',0,'0000-00-00 00:00:00',1,'mod_popular',0,2,1,'',0,1,''),(4,'Neue Beiträge','',5,'cpanel',0,'0000-00-00 00:00:00',1,'mod_latest',0,2,1,'ordering=c_dsc\nuser_id=0\ncache=0\n\n',0,1,''),(5,'Statistiken','',6,'cpanel',0,'0000-00-00 00:00:00',1,'mod_stats',0,2,1,'',0,1,''),(6,'Ungelesene Nachrichten','',1,'header',0,'0000-00-00 00:00:00',1,'mod_unread',0,2,1,'',1,1,''),(7,'Benutzer online','',2,'header',0,'0000-00-00 00:00:00',1,'mod_online',0,2,1,'',1,1,''),(8,'Toolbar','',1,'toolbar',0,'0000-00-00 00:00:00',1,'mod_toolbar',0,2,1,'',1,1,''),(9,'Quick-Icons','',1,'icon',0,'0000-00-00 00:00:00',1,'mod_quickicon',0,2,1,'',1,1,''),(10,'Angemeldete Benutzer','',3,'cpanel',0,'0000-00-00 00:00:00',1,'mod_logged',0,2,1,'',0,1,''),(11,'Fußzeile','',0,'footer',0,'0000-00-00 00:00:00',1,'mod_footer',0,0,1,'',1,1,''),(12,'Admin-Menü','',1,'menu',0,'0000-00-00 00:00:00',1,'mod_menu',0,2,1,'',0,1,''),(13,'Admin-Untermenü','',1,'submenu',0,'0000-00-00 00:00:00',1,'mod_submenu',0,2,1,'',0,1,''),(14,'Benutzerstatus','',1,'status',0,'0000-00-00 00:00:00',1,'mod_status',0,2,1,'',0,1,''),(15,'Titel','',1,'title',0,'0000-00-00 00:00:00',1,'mod_title',0,2,1,'',0,1,''),(43,'Update nötig?','',2,'cpanel',0,'0000-00-00 00:00:00',1,'mod_jgerman',0,2,1,'auto_check=auto_check_no\ncheck_core=check_core_show\nnotice=notice_show\nimagesize=middle\n\n',0,1,''),(16,'Umfragen','',1,'right',0,'0000-00-00 00:00:00',0,'mod_poll',0,0,1,'id=14\ncache=1',0,0,''),(17,'Benutzermenü','',4,'left',0,'0000-00-00 00:00:00',1,'mod_mainmenu',0,1,1,'menutype=usermenu\nmoduleclass_sfx=_menu\ncache=1',1,0,''),(18,'Anmeldung','',8,'left',0,'0000-00-00 00:00:00',1,'mod_login',0,0,1,'greeting=1\nname=0',1,0,''),(19,'Neueste Nachrichten','',0,'user2',0,'0000-00-00 00:00:00',1,'mod_latestnews',0,0,1,'count=5\nordering=c_dsc\nuser_id=0\nshow_front=1\nsecid=\ncatid=\nmoduleclass_sfx=\ncache=1\ncache_time=900\n\n',1,0,''),(20,'Statistiken','',6,'left',0,'0000-00-00 00:00:00',0,'mod_stats',0,0,1,'serverinfo=1\nsiteinfo=1\ncounter=1\nincrease=0\nmoduleclass_sfx=',0,0,''),(21,'Wer ist online','',1,'right',0,'0000-00-00 00:00:00',0,'mod_whosonline',0,0,1,'online=1\nusers=1\nmoduleclass_sfx=',0,0,''),(22,'Meist gelesen','',6,'user2',0,'0000-00-00 00:00:00',1,'mod_mostread',0,0,1,'cache=1',0,0,''),(23,'Archiv','',9,'left',0,'0000-00-00 00:00:00',0,'mod_archive',0,0,1,'cache=1',1,0,''),(24,'Bereiche','',10,'left',0,'0000-00-00 00:00:00',0,'mod_sections',0,0,1,'cache=1',1,0,''),(25,'Schlagzeilen','',1,'top',0,'0000-00-00 00:00:00',1,'mod_newsflash',0,0,1,'catid=3\r\nstyle=random\r\nitems=\r\nmoduleclass_sfx=',0,0,''),(26,'Verwandte Beiträge','',11,'left',0,'0000-00-00 00:00:00',0,'mod_related_items',0,0,1,'',0,0,''),(27,'Suche','',1,'user4',0,'0000-00-00 00:00:00',1,'mod_search',0,0,0,'cache=1',0,0,''),(28,'Zufallsbild','',9,'right',0,'0000-00-00 00:00:00',0,'mod_random_image',0,0,1,'',0,0,''),(29,'Menü oben','',1,'user3',0,'0000-00-00 00:00:00',1,'mod_mainmenu',0,0,0,'cache=1\nmenutype=topmenu\nmenu_style=list_flat\nmenu_images=n\nmenu_images_align=left\nexpand_menu=n\nclass_sfx=-nav\nmoduleclass_sfx=\nindent_image1=0\nindent_image2=0\nindent_image3=0\nindent_image4=0\nindent_image5=0\nindent_image6=0',1,0,''),(30,'Banner','',1,'footer',0,'0000-00-00 00:00:00',1,'mod_banners',0,0,0,'target=1\ncount=1\ncid=1\ncatid=33\ntag_search=0\nordering=random\nheader_text=\nfooter_text=\nmoduleclass_sfx=\ncache=1\ncache_time=900\n\n',1,0,''),(31,'Quellen','',2,'left',0,'0000-00-00 00:00:00',1,'mod_mainmenu',0,0,1,'menutype=othermenu\nmenu_style=list\ncache=1\nmenu_images=0\nmenu_images_align=0\nexpand_menu=0\nclass_sfx=\nmoduleclass_sfx=\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nmoduleclass_sfx=_menu\n',0,0,''),(32,'Wrapper','',12,'left',0,'0000-00-00 00:00:00',0,'mod_wrapper',0,0,1,'',0,0,''),(33,'Fußzeile','',2,'footer',0,'0000-00-00 00:00:00',1,'mod_footer',0,0,0,'cache=1\n\n',1,0,''),(34,'Feed-Anzeige','',13,'left',0,'0000-00-00 00:00:00',0,'mod_feed',0,0,1,'',1,0,''),(35,'Navigationspfad (Breadcrumb)','',1,'breadcrumb',0,'0000-00-00 00:00:00',1,'mod_breadcrumbs',0,0,1,'moduleclass_sfx=\ncache=0\nshowHome=1\nhomeText=Start\nshowComponent=1\nseparator=\n\n',1,0,''),(36,'Syndication','',3,'syndicate',0,'0000-00-00 00:00:00',1,'mod_syndicate',0,0,0,'',1,0,''),(38,'Werbung','',3,'right',0,'0000-00-00 00:00:00',0,'mod_banners',0,0,1,'count=4\r\nrandomise=0\r\ncid=0\r\ncatid=14\r\nheader_text=Empfohlene Links:\r\nfooter_text=<a href=\"http://www.joomla.org\">Inserate von Joomla!</a>\r\nmoduleclass_sfx=_text\r\ncache=0\r\n\r\n',0,0,''),(39,'Beispielseiten','',5,'left',0,'0000-00-00 00:00:00',1,'mod_mainmenu',0,0,1,'cache=1\nclass_sfx=\nmoduleclass_sfx=_menu\nmenutype=ExamplePages\nmenu_style=list_flat\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nfull_active_id=0\nmenu_images=0\nmenu_images_align=0\nexpand_menu=0\nactivate_parent=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=\nwindow_open=\n\n',0,0,''),(40,'Schlüsselkonzepte','',3,'left',0,'0000-00-00 00:00:00',1,'mod_mainmenu',0,0,1,'cache=1\nclass_sfx=\nmoduleclass_sfx=_menu\nmenutype=keyconcepts\nmenu_style=list\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nfull_active_id=0\nmenu_images=0\nmenu_images_align=0\nexpand_menu=0\nactivate_parent=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=\nwindow_open=\n\n',0,0,''),(41,'Willkommen bei Joomla!','<div style=\"padding: 5px\"><p>Gratulation, dass Sie Joomla! als Ihr Content-Management-System gewählt haben. Wir hoffen, dass es Ihnen mit unserem Programm gelingt eine erfolgreiche Website zu erstellen und der Gemeinschaft vielleicht zu einem späteren Punkt etwas zurückgeben können.</p><p>Um Ihren Anfang mit Joomla! so einfach wie möglich zu gestalten, möchten wir Ihnen einige Punkte aufzeigen, wie z.B. allgemeinen Fragen, Hilfen und Sicherheit Ihres Server.</p><p>Sie sollten mit dem &quot;<a href=\"http://docs.joomla.org/beginners\" target=\"_blank\">Absolute Beginners Guide to Joomla!</a>&quot; anfangen und dann, um die Sicherheit Ihres Servers zu gewährleisten, die &quot;<a href=\"http://forum.joomla.org/viewtopic.php?t=81058\" target=\"_blank\">Security Checklist</a>&quot; lesen.</p><p>Für Ihre häufig gestellten Fragen sollten Sie zuerst ins <a href=\"http://forum.joomla.org\" target=\"_blank\">Forum</a> schauen und die <a href=\"http://docs.joomla.org/Category:FAQ\" target=\"_blank\">FAQ</a> im Wiki lesen. Im Forum finden Sie eine Antwort auf fast alle Ihre Fragen. Auch wenn diese bisher nur einmal von anderen beantwortet wurden, so ist das Forum ein großes Nachschlagewerk für Anfänger und Profis. Bitte benutzen Sie die Suchfunktion des Forums bevor Sie Ihre Frage stellen, es könnte nämlich sein, dass diese schon einmal gestellt wurde. <img alt=\"Lächeln\" border=\"0\" src=\"../plugins/editors/tinymce/jscripts/tiny_mce/plugins/emotions/images/smiley-smile.gif\" title=\"Lächeln\" /></p><p>Die Sicherheit ist ein großes Anliegen für uns, deshalb würden wir es begrüßen, wenn Sie das &quot;<a href=\"http://forum.joomla.org/viewforum.php?f=8\" target=\"_blank\">Announcement-Forum</a>&quot; abonnieren würden, damit Sie immer aktuelle Informationen über neue Joomla!-Versionen bekommen. Sie sollten aber auch regelmäßig das &quot;<a href=\"http://forum.joomla.org/viewforum.php?f=432\" target=\"_blank\">Security-Forum</a>&quot; besuchen.</p><p>Wir hoffen, dass Sie viel Spaß und Erfolg mit Joomla! haben und Sie bald unter den Hunderten bzw. Tausenden an Joomla!-Benutzern sind, die Anfängern helfen können.</p><p>Ihr Joomla!-Team</p><p>P.S.: Um diese Anzeige zu entfernen, löschen Sie einfach das &quot;Willkommen bei Joomla!&quot;-Modul unter &quot;Erweiterungen&quot;-&gt;&quot;Module&quot; -&gt;&quot;Administrator&quot;.</p></div>',1,'cpanel',0,'0000-00-00 00:00:00',1,'mod_custom',0,2,1,'moduleclass_sfx=\n\n',1,1,''),(42,'Joomla! Security Newsfeed','',6,'cpanel',62,'2008-10-25 20:15:17',1,'mod_feed',0,0,1,'cache=1\ncache_time=15\nmoduleclass_sfx=\nrssurl=http://feeds.joomla.org/JoomlaSecurityNews\nrssrtl=0\nrsstitle=1\nrssdesc=0\nrssimage=1\nrssitems=1\nrssitemdesc=1\nword_count=0\n\n',0,1,''),(44,'JCE Latest News','',1,'jce_cpanel',0,'0000-00-00 00:00:00',1,'mod_feed',0,0,1,'cache=1\r\n	cache_time=15\r\n	moduleclass_sfx=\r\n	rssurl=http://www.joomlacontenteditor.net/index.php?option=com_rss&feed=RSS2.0&type=com_frontpage&Itemid=1\r\n	rssrtl=0\r\n	rsstitle=0\r\n	rssdesc=0\r\n	rssimage=0\r\n	rssitems=3\r\n	rssitemdesc=1\r\n	word_count=100',0,1,''),(45,'JCE Control Panel Icons','',1,'jce_icon',0,'0000-00-00 00:00:00',1,'mod_jcequickicon',0,0,0,'',0,1,''),(46,'Test','<center>\r\n<table border=\"0\">\r\n<tbody>\r\n<tr height=\"12\">\r\n<td></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</center><center>\r\n<table background=\"http://www.mylsfm.de/images/stories/webtechnik/webground/welcomeground.png\" width=\"300\" style=\"height: 258px;\">\r\n<tbody>\r\n<tr>\r\n<td><br /><br /><br /><br /><br />\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td width=\"13\"></td>\r\n<td><span style=\"font-family: verdana,geneva;\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=36:startseite&amp;catid=31:mylsfm-infos&amp;Itemid=46\">Dann registrier Dich jetzt!</a> Hier findest Du Deinen Sound, Deinen Style, Deine Freunde, Deine Chance und Infos über die Musikszene.</span></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n<td>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td width=\"45\"></td>\r\n<td><img width=\"150\" src=\"images/stories/webtechnik/webimages/meldebutton.jpg\" alt=\"Jetzt kostenlos anmelden\" height=\"25\" style=\"float: center; margin: 5px;\" title=\"Jetzt kostenlos anmelden\" /></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n<td><span style=\"font-family: verdana,geneva;\"><a href=\"index.php?option=com_content&amp;view=article&amp;id=36:startseite&amp;catid=31:mylsfm-infos&amp;Itemid=46\">Mehr Infos zum Service gibt es hier...</a></span></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n<td></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n<td></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n<td><strong><span style=\"font-family: verdana,geneva;\">Höre 24 Stunden Musik der Newcomer!!</span></strong></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n<td></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n<td><center>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td><img width=\"40\" src=\"images/stories/webtechnik/webimages/winamp.jpg\" alt=\"winamp.jpg\" height=\"40\" style=\"float: center; margin: 5px;\" title=\"winamp.jpg\" /></td>\r\n<td></td>\r\n<td><img width=\"40\" src=\"images/stories/webtechnik/webimages/winamp.jpg\" alt=\"winamp.jpg\" height=\"40\" style=\"float: center; margin: 5px;\" title=\"winamp.jpg\" /></td>\r\n<td></td>\r\n<td><img width=\"40\" src=\"images/stories/webtechnik/webimages/winamp.jpg\" alt=\"winamp.jpg\" height=\"40\" style=\"float: center; margin: 5px;\" title=\"winamp.jpg\" /></td>\r\n<td></td>\r\n<td><img width=\"40\" src=\"images/stories/webtechnik/webimages/winamp.jpg\" alt=\"winamp.jpg\" height=\"40\" style=\"float: center; margin: 5px;\" title=\"winamp.jpg\" /></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</center></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</center><br /><center>\r\n<table background=\"http://www.livestylefm.de/images/stories/webtechnik/webgrund/newground2.jpg\" width=\"300\" style=\"height: 250px;\">\r\n<tbody>\r\n<tr>\r\n<td><br />\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td><a target=\"_blank\" href=\"http://www.amazon.de/gp/product/B001UNPQOQ?ie=UTF8&amp;tag=cdlexikon-21&amp;linkCode=as2&amp;camp=1638&amp;creative=6742&amp;creativeASIN=B001UNPQOQ\"><img width=\"100\" src=\"images/stories/webpicture/webmusic/ronan.jpg\" alt=\"Ronan Keating - Songs For My Mother\" height=\"75\" style=\"float: left; margin: 0px; border: 0px solid;\" title=\"Ronan Keating - Songs For My Mother\" /></a></td>\r\n<td valign=\"top\"><span class=\"massilink\"><a target=\"_blank\" href=\"http://www.amazon.de/gp/product/B001UNPQOQ?ie=UTF8&amp;tag=cdlexikon-21&amp;linkCode=as2&amp;camp=1638&amp;creative=6742&amp;creativeASIN=B001UNPQOQ\">Mit \"Songs for my Mother\" kehrt Ronan Keating zurück<br /></a></span><span style=\"font-family: arial,helvetica,sans-serif;\">Lange haben wir von ihm nix gehört - jetzt kehrt er mit einem neuen Album zurück...<a target=\"_blank\" href=\"http://www.amazon.de/gp/product/B001UNPQOQ?ie=UTF8&amp;tag=cdlexikon-21&amp;linkCode=as2&amp;camp=1638&amp;creative=6742&amp;creativeASIN=B001UNPQOQ\">weiter<span></span></a></span></td>\r\n</tr>\r\n<tr height=\"30\">\r\n<td></td>\r\n<td></td>\r\n</tr>\r\n<tr>\r\n<td><a target=\"_blank\" href=\"http://www.eventim.de/cgi-bin/lafee-ring-frei-tour-2009-tickets-oberhausen.html?id=EVE_NO_SESSION&amp;fun=evdetail&amp;doc=evdetailb&amp;key=251582$553032\"><img width=\"100\" src=\"images/stories/webpicture/webmusic/lafee.jpg\" alt=\"LaFee live in Oberhausen\" height=\"75\" style=\"float: left; margin: 0px; border: 0px solid;\" title=\"LaFee live in Oberhausen\" /></a></td>\r\n<td valign=\"top\"><span class=\"massilink\"><a target=\"_blank\" href=\"http://www.eventim.de/cgi-bin/lafee-ring-frei-tour-2009-tickets-oberhausen.html?id=EVE_NO_SESSION&amp;fun=evdetail&amp;doc=evdetailb&amp;key=251582$553032\">LaFee live in Oberhausen - Jetzt noch Tickets sichern<br /></a></span><span style=\"font-family: arial,helvetica,sans-serif;\">Deutschlands jüngste Künstlerin ist live in Oberhausen - jetzt könnt ihr noch Tickerts sichern...<a target=\"_blank\" href=\"http://www.eventim.de/cgi-bin/lafee-ring-frei-tour-2009-tickets-oberhausen.html?id=EVE_NO_SESSION&amp;fun=evdetail&amp;doc=evdetailb&amp;key=251582$553032\">weiter<span></span></a></span></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</center><br /><center>\r\n<script type=\"text/javascript\">//<![CDATA[\r\n   var m3_u = (location.protocol==\'https:\'?\'https://www.livestylefm.de/werbung/www/delivery/ajs.php\':\'http://www.livestylefm.de/werbung/www/delivery/ajs.php\');\r\n   var m3_r = Math.floor(Math.random()*99999999999);\r\n   if (!document.MAX_used) document.MAX_used = \',\';\r\n   document.write (\"<scr\"+\"ipt type=\'text/javascript\' src=\'\"+m3_u);\r\n   document.write (\"?campaignid=3\");\r\n   document.write (\'&cb=\' + m3_r);\r\n   if (document.MAX_used != \',\') document.write (\"&exclude=\" + document.MAX_used);\r\n   document.write (document.charset ? \'&charset=\'+document.charset : (document.characterSet ? \'&charset=\'+document.characterSet : \'\'));\r\n   document.write (\"&loc=\" + escape(window.location));\r\n   if (document.referrer) document.write (\"&referer=\" + escape(document.referrer));\r\n   if (document.context) document.write (\"&context=\" + escape(document.context));\r\n   if (document.mmm_fo) document.write (\"&mmm_fo=1\");\r\n   document.write (\"\'><\\/scr\"+\"ipt>\");</script>\r\n</center>',0,'right',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,0,'moduleclass_sfx=\n\n',0,0,''),(47,'Top News','<center>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td>\r\n<table background=\"http://www.livestylefm.de/images/stories/webtechnik/webgrund/newground41.jpg\" width=\"200\" style=\"height: 250px;\">\r\n<tbody>\r\n<tr height=\"20\">\r\n<td></td>\r\n</tr>\r\n<tr>\r\n<td><a target=\"_blank\" href=\"http://www.amazon.de/gp/product/B001RPAZ02?ie=UTF8&amp;tag=shootingstar-21&amp;linkCode=as2&amp;camp=1638&amp;creative=19454&amp;creativeASIN=B001RPAZ02\"><img width=\"192\" src=\"images/stories/webpicture/webmusic/pinkneu.jpg\" alt=\"Punk - Please Don\'t Leave Me\" height=\"100\" style=\"border: 0px solid;\" title=\"Punk - Please Don\'t Leave Me\" /></a></td>\r\n</tr>\r\n<tr>\r\n<td><a target=\"_blank\" href=\"http://www.amazon.de/gp/product/B001RPAZ02?ie=UTF8&amp;tag=shootingstar-21&amp;linkCode=as2&amp;camp=1638&amp;creative=19454&amp;creativeASIN=B001RPAZ02\">Live Style FM Musik Tipp:<br />Pink - Please don´t leave me</a></td>\r\n</tr>\r\n<tr>\r\n<td>Schon mit \"So What\" und \"Sober\" hatte sie einen mege Erfolg und jetzt zieht ihre neue Single direkt nach....<br /><br /><a target=\"_blank\" href=\"http://www.amazon.de/gp/product/B001RPAZ02?ie=UTF8&amp;tag=shootingstar-21&amp;linkCode=as2&amp;camp=1638&amp;creative=19454&amp;creativeASIN=B001RPAZ02\">&gt;&gt; Single jetzt downlaoden</a></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n<td width=\"3\"></td>\r\n<td>\r\n<table background=\"http://www.livestylefm.de/images/stories/webtechnik/webgrund/newground42.jpg\" width=\"200\" style=\"height: 250px;\">\r\n<tbody>\r\n<tr height=\"20\">\r\n<td></td>\r\n</tr>\r\n<tr>\r\n<td><a href=\"index.php/movies/40-movie/127-x-men-origins-wolverine-.html\"><img width=\"192\" src=\"images/stories/webpicture/webmovie/xmen.jpg\" alt=\"X-Men Origins: Wolverine\" height=\"100\" style=\"border: 0px solid;\" title=\"X-Men Origins: Wolverine\" /></a></td>\r\n</tr>\r\n<tr>\r\n<td><a href=\"index.php/movies/40-movie/127-x-men-origins-wolverine-.html\">Der neue X-Men Film lockt wieder Fans in die Kinos - sei auch dabei</a></td>\r\n</tr>\r\n<tr>\r\n<td>Es geht in die nächste Runde. X-Men Origins: Wolverine ist das neuste Abenteuer mit Hugh Jackmann....<br /><br /><a href=\"index.php/movies/40-movie/127-x-men-origins-wolverine-.html\">&gt;&gt; Mehr Informationen</a><span></span></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n<td width=\"3\"></td>\r\n<td>\r\n<table background=\"http://www.livestylefm.de/images/stories/webtechnik/webgrund/newground43.jpg\" width=\"200\" style=\"height: 250px;\">\r\n<tbody>\r\n<tr height=\"20\">\r\n<td></td>\r\n</tr>\r\n<tr>\r\n<td><a href=\"index.php/component/content/article/34-konzert/105-jean-luke-musiker-mit-leidenschaft.html\"><img width=\"192\" src=\"images/stories/webpicture/webmusic/jeanluke2.jpg\" alt=\"Jean Luke on Tour\" height=\"100\" style=\"border: 0px solid;\" title=\"Jean Luke on Tour\" /></a></td>\r\n</tr>\r\n<tr>\r\n<td><a href=\"index.php/component/content/article/34-konzert/105-jean-luke-musiker-mit-leidenschaft.html\">MyLSFM Newcomer: Jean Luke ist auf Tour - seit dabei</a></td>\r\n</tr>\r\n<tr>\r\n<td>Wer die Musik von Jean Luke nochmal erleben will, der kann jetzt noch dabei sein. Bremen und Hamburg begrüsst....<br /><br /><a href=\"index.php/component/content/article/34-konzert/105-jean-luke-musiker-mit-leidenschaft.html\">&gt;&gt; Mehr Informationen</a><span></span></td>\r\n</tr>\r\n<tr>\r\n<td></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</center>',0,'user1',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,0,'moduleclass_sfx=\n\n',0,0,'');
/*!40000 ALTER TABLE `mylsfm_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_modules_menu`
--

DROP TABLE IF EXISTS `mylsfm_modules_menu`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_modules_menu` (
  `moduleid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`moduleid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_modules_menu`
--

LOCK TABLES `mylsfm_modules_menu` WRITE;
/*!40000 ALTER TABLE `mylsfm_modules_menu` DISABLE KEYS */;
INSERT INTO `mylsfm_modules_menu` VALUES (1,0),(16,1),(17,0),(18,1),(19,1),(19,2),(19,27),(21,1),(22,1),(22,2),(22,4),(22,27),(22,36),(25,0),(27,0),(29,0),(30,0),(31,1),(32,0),(33,0),(34,0),(35,0),(36,0),(38,1),(39,43),(39,44),(39,45),(39,46),(39,47),(40,0),(46,0),(47,0);
/*!40000 ALTER TABLE `mylsfm_modules_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_newsfeeds`
--

DROP TABLE IF EXISTS `mylsfm_newsfeeds`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_newsfeeds` (
  `catid` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `alias` varchar(255) NOT NULL default '',
  `link` text NOT NULL,
  `filename` varchar(200) default NULL,
  `published` tinyint(1) NOT NULL default '0',
  `numarticles` int(11) unsigned NOT NULL default '1',
  `cache_time` int(11) unsigned NOT NULL default '3600',
  `checked_out` tinyint(3) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `rtl` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `published` (`published`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_newsfeeds`
--

LOCK TABLES `mylsfm_newsfeeds` WRITE;
/*!40000 ALTER TABLE `mylsfm_newsfeeds` DISABLE KEYS */;
INSERT INTO `mylsfm_newsfeeds` VALUES (4,1,'Joomla! Ankündigungen','joomla-ankuendigungen','http://feeds.joomla.org/JoomlaAnnouncements','',1,5,3600,0,'0000-00-00 00:00:00',1,0),(4,2,'Joomla! Core-Team Blog','joomla-core-team-blog','http://feeds.joomla.org/JoomlaCommunityCoreTeamBlog','',1,5,3600,0,'0000-00-00 00:00:00',2,0),(4,3,'Joomla! Community-Magazin','joomla-community-magazin','http://feeds.joomla.org/JoomlaMagazine','',1,20,3600,0,'0000-00-00 00:00:00',3,0),(4,4,'Joomla! Developer-News','joomla-developer-news','http://feeds.joomla.org/JoomlaDeveloper','',1,5,3600,0,'0000-00-00 00:00:00',4,0),(4,5,'Joomla! Sicherheits-News','joomla-sicherheits-news','http://feeds.joomla.org/JoomlaSecurityNews','',1,5,3600,0,'0000-00-00 00:00:00',5,0),(5,6,'Free Software Foundation Blogs','free-software-foundation-blogs','http://www.fsf.org/blogs/RSS',NULL,1,5,3600,0,'0000-00-00 00:00:00',4,0),(5,7,'Free Software Foundation','free-software-foundation','http://www.fsf.org/news/RSS',NULL,1,5,3600,0,'0000-00-00 00:00:00',3,0),(5,8,'Software Freedom Law Center Blog','software-freedom-law-center-blog','http://www.softwarefreedom.org/feeds/blog/',NULL,1,5,3600,0,'0000-00-00 00:00:00',2,0),(5,9,'Software Freedom Law Center News','software-freedom-law-center','http://www.softwarefreedom.org/feeds/news/',NULL,1,5,3600,0,'0000-00-00 00:00:00',1,0),(5,10,'Open Source Initiative Blog','open-source-initiative-blog','http://www.opensource.org/blog/feed',NULL,1,5,3600,0,'0000-00-00 00:00:00',5,0),(6,11,'PHP-News und Ankündigungen','php-news-und-ankuendigungen','http://www.php.net/feed.atom',NULL,1,5,3600,0,'0000-00-00 00:00:00',1,0),(6,12,'Planet MySQL','planet-mysql','http://www.planetmysql.org/rss20.xml',NULL,1,5,3600,0,'0000-00-00 00:00:00',2,0),(6,13,'Linux Foundation Ankündigungen','linux-foundation-ankuendigungen','http://www.linuxfoundation.org/press/rss20.xml',NULL,1,5,3600,0,'0000-00-00 00:00:00',3,0),(6,14,'Mootools Blog','mootools-blog','http://feeds.feedburner.com/mootools-blog',NULL,1,5,3600,0,'0000-00-00 00:00:00',4,0),(4,15,'J!German News','jgerman-news','http://www.jgerman.de/feed/rss.html','',1,5,3600,0,'0000-00-00 00:00:00',6,0);
/*!40000 ALTER TABLE `mylsfm_newsfeeds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_plugins`
--

DROP TABLE IF EXISTS `mylsfm_plugins`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_plugins` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `element` varchar(100) NOT NULL default '',
  `folder` varchar(100) NOT NULL default '',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `published` tinyint(3) NOT NULL default '0',
  `iscore` tinyint(3) NOT NULL default '0',
  `client_id` tinyint(3) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_folder` (`published`,`client_id`,`access`,`folder`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_plugins`
--

LOCK TABLES `mylsfm_plugins` WRITE;
/*!40000 ALTER TABLE `mylsfm_plugins` DISABLE KEYS */;
INSERT INTO `mylsfm_plugins` VALUES (1,'Authentifikation - Joomla','joomla','authentication',0,1,1,1,0,0,'0000-00-00 00:00:00',''),(2,'Authentifikation - LDAP','ldap','authentication',0,2,0,1,0,0,'0000-00-00 00:00:00','host=\nport=389\nuse_ldapV3=0\nnegotiate_tls=0\nno_referrals=0\nauth_method=bind\nbase_dn=\nsearch_string=\nusers_dn=\nusername=\npassword=\nldap_fullname=fullName\nldap_email=mail\nldap_uid=uid\n\n'),(3,'Authentifikation - GMail','gmail','authentication',0,4,0,0,0,0,'0000-00-00 00:00:00',''),(4,'Authentifikation - OpenID','openid','authentication',0,3,0,0,0,0,'0000-00-00 00:00:00',''),(5,'Benutzer - Joomla!','joomla','user',0,0,1,0,0,0,'0000-00-00 00:00:00','autoregister=1\n\n'),(6,'Suche - Inhalte','content','search',0,1,1,1,0,0,'0000-00-00 00:00:00','search_limit=50\nsearch_content=1\nsearch_uncategorised=1\nsearch_archived=1\n\n'),(7,'Suche - Kontakte','contacts','search',0,3,1,1,0,0,'0000-00-00 00:00:00','search_limit=50\n\n'),(8,'Suche - Kategorien','categories','search',0,4,1,0,0,0,'0000-00-00 00:00:00','search_limit=50\n\n'),(9,'Suche - Bereiche','sections','search',0,5,1,0,0,0,'0000-00-00 00:00:00','search_limit=50\n\n'),(10,'Suche - Newsfeeds','newsfeeds','search',0,6,1,0,0,0,'0000-00-00 00:00:00','search_limit=50\n\n'),(11,'Suche - Weblinks','weblinks','search',0,2,1,1,0,0,'0000-00-00 00:00:00','search_limit=50\n\n'),(12,'Inhalt - Seitenumbruch','pagebreak','content',0,10000,1,1,0,0,'0000-00-00 00:00:00','enabled=1\ntitle=1\nmultipage_toc=1\nshowall=1\n\n'),(13,'Inhalt - Bewertung','vote','content',0,4,1,1,0,0,'0000-00-00 00:00:00',''),(14,'Inhalt - E-Mail-Verschleierung','emailcloak','content',0,5,1,0,0,0,'0000-00-00 00:00:00','mode=1\n\n'),(15,'Inhalt - Code-Hervorhebung (GeSHi)','geshi','content',0,5,0,0,0,0,'0000-00-00 00:00:00',''),(16,'Inhalt - Modul laden','loadmodule','content',0,6,1,0,0,0,'0000-00-00 00:00:00','enabled=1\nstyle=0\n\n'),(17,'Inhalt - Seitennavigation','pagenavigation','content',0,2,1,1,0,0,'0000-00-00 00:00:00','position=1\n\n'),(18,'Editor - Kein Editor','none','editors',0,0,1,1,0,0,'0000-00-00 00:00:00',''),(19,'Editor - TinyMCE 2.0','tinymce','editors',0,0,1,1,0,0,'0000-00-00 00:00:00','theme=advanced\ncleanup=1\ncleanup_startup=0\nautosave=0\ncompressed=0\nrelative_urls=1\ntext_direction=ltr\nlang_mode=0\nlang_code=de\ninvalid_elements=applet\ncontent_css=1\ncontent_css_custom=\nnewlines=0\ntoolbar=top\nhr=1\nsmilies=1\ntable=1\nstyle=1\nlayer=1\nxhtmlxtras=0\ntemplate=0\ndirectionality=1\nfullscreen=1\nhtml_height=550\nhtml_width=750\npreview=1\ninsertdate=1\nformat_date=%Y-%m-%d\ninserttime=1\nformat_time=%H:%M:%S\n\n'),(20,'Editor - XStandard Lite 2.0','xstandard','editors',0,0,0,1,0,0,'0000-00-00 00:00:00',''),(21,'Editorbutton - Bild','image','editors-xtd',0,0,1,0,0,0,'0000-00-00 00:00:00',''),(22,'Editorbutton - Seitenumbruch','pagebreak','editors-xtd',0,0,1,0,0,0,'0000-00-00 00:00:00',''),(23,'Editorbutton - Weiterlesen','readmore','editors-xtd',0,0,1,0,0,0,'0000-00-00 00:00:00',''),(24,'XML-RPC - Joomla','joomla','xmlrpc',0,7,0,1,0,0,'0000-00-00 00:00:00',''),(25,'XML-RPC - Blogger-API','blogger','xmlrpc',0,7,0,1,0,0,'0000-00-00 00:00:00','catid=1\nsectionid=0\n\n'),(27,'System - SEF','sef','system',0,1,1,0,0,0,'0000-00-00 00:00:00',''),(28,'System - Debug','debug','system',0,2,1,0,0,0,'0000-00-00 00:00:00','queries=1\nmemory=1\nlangauge=1\n\n'),(29,'System - Legacy','legacy','system',0,3,0,1,0,0,'0000-00-00 00:00:00','route=0\n\n'),(30,'System - Cache','cache','system',0,4,0,1,0,0,'0000-00-00 00:00:00','browsercache=0\ncachetime=15\n\n'),(31,'System - Protokoll','log','system',0,5,0,1,0,0,'0000-00-00 00:00:00',''),(32,'System - Remember Me','remember','system',0,6,1,1,0,0,'0000-00-00 00:00:00',''),(33,'System - Backlink','backlink','system',0,7,0,1,0,0,'0000-00-00 00:00:00',''),(34,'Editor - JCE 1.5.0','jce','editors',0,0,1,0,0,0,'0000-00-00 00:00:00','editor_state=mceEditor\neditor_toggle_text=[show/hide]\neditor_toggle=1\neditor_theme_advanced_toolbar_location=top\neditor_layout_rows=5\neditor_skin=default\neditor_skin_variant=default\neditor_inlinepopups_skin=clearlooks2\n');
/*!40000 ALTER TABLE `mylsfm_plugins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_poll_data`
--

DROP TABLE IF EXISTS `mylsfm_poll_data`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_poll_data` (
  `id` int(11) NOT NULL auto_increment,
  `pollid` int(11) NOT NULL default '0',
  `text` text NOT NULL,
  `hits` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pollid` (`pollid`,`text`(1))
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_poll_data`
--

LOCK TABLES `mylsfm_poll_data` WRITE;
/*!40000 ALTER TABLE `mylsfm_poll_data` DISABLE KEYS */;
INSERT INTO `mylsfm_poll_data` VALUES (1,14,'Community-Seiten',2),(2,14,'Öffentliche Firmenseiten',3),(3,14,'eCommerce',1),(4,14,'Blogs',0),(5,14,'Intranets',0),(6,14,'Foto- und Medienseiten',2),(7,14,'Alles oben genannte!',3),(8,14,'',0),(9,14,'',0),(10,14,'',0),(11,14,'',0),(12,14,'',0);
/*!40000 ALTER TABLE `mylsfm_poll_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_poll_date`
--

DROP TABLE IF EXISTS `mylsfm_poll_date`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_poll_date` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `vote_id` int(11) NOT NULL default '0',
  `poll_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `poll_id` (`poll_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_poll_date`
--

LOCK TABLES `mylsfm_poll_date` WRITE;
/*!40000 ALTER TABLE `mylsfm_poll_date` DISABLE KEYS */;
INSERT INTO `mylsfm_poll_date` VALUES (1,'2007-10-09 13:01:58',1,14),(2,'2007-10-10 15:19:43',7,14),(3,'2007-10-11 11:08:16',7,14),(4,'2007-10-11 15:02:26',2,14),(5,'2007-10-11 15:43:03',7,14),(6,'2007-10-11 15:43:38',7,14),(7,'2007-10-12 00:51:13',2,14),(8,'2008-05-10 19:12:29',3,14),(9,'2008-05-14 14:18:00',6,14),(10,'2008-06-10 15:20:29',6,14),(11,'2008-07-03 12:37:53',2,14);
/*!40000 ALTER TABLE `mylsfm_poll_date` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_poll_menu`
--

DROP TABLE IF EXISTS `mylsfm_poll_menu`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_poll_menu` (
  `pollid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pollid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_poll_menu`
--

LOCK TABLES `mylsfm_poll_menu` WRITE;
/*!40000 ALTER TABLE `mylsfm_poll_menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `mylsfm_poll_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_polls`
--

DROP TABLE IF EXISTS `mylsfm_polls`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_polls` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `voters` int(9) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `access` int(11) NOT NULL default '0',
  `lag` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_polls`
--

LOCK TABLES `mylsfm_polls` WRITE;
/*!40000 ALTER TABLE `mylsfm_polls` DISABLE KEYS */;
INSERT INTO `mylsfm_polls` VALUES (14,'Wozu nutzen Sie Joomla!?','wozu-nutzen-sie-joomla',11,0,'0000-00-00 00:00:00',1,0,86400);
/*!40000 ALTER TABLE `mylsfm_polls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_sections`
--

DROP TABLE IF EXISTS `mylsfm_sections`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_sections` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `image` text NOT NULL,
  `scope` varchar(50) NOT NULL default '',
  `image_position` varchar(30) NOT NULL default '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_scope` (`scope`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_sections`
--

LOCK TABLES `mylsfm_sections` WRITE;
/*!40000 ALTER TABLE `mylsfm_sections` DISABLE KEYS */;
INSERT INTO `mylsfm_sections` VALUES (3,'Alle Infos','','infos','','content','left','Wählen Sie eines der unten angeführten FAQ-Themen, dann eine FAQ. Sollten Sie eine Frage haben welche hier nicht beantwortet ist, kontaktieren Sie uns bitte.',1,0,'0000-00-00 00:00:00',0,0,24,'');
/*!40000 ALTER TABLE `mylsfm_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_session`
--

DROP TABLE IF EXISTS `mylsfm_session`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_session` (
  `username` varchar(150) default '',
  `time` varchar(14) default '',
  `session_id` varchar(200) NOT NULL default '0',
  `guest` tinyint(4) default '1',
  `userid` int(11) default '0',
  `usertype` varchar(50) default '',
  `gid` tinyint(3) unsigned NOT NULL default '0',
  `client_id` tinyint(3) unsigned NOT NULL default '0',
  `data` longtext,
  PRIMARY KEY  (`session_id`(64)),
  KEY `whosonline` (`guest`,`usertype`),
  KEY `userid` (`userid`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_session`
--

LOCK TABLES `mylsfm_session` WRITE;
/*!40000 ALTER TABLE `mylsfm_session` DISABLE KEYS */;
INSERT INTO `mylsfm_session` VALUES ('','1241898142','91e7cc59bb081f2afa977055005982d8',1,0,'',0,0,'__default|a:7:{s:15:\"session.counter\";i:1;s:19:\"session.timer.start\";i:1241898142;s:18:\"session.timer.last\";i:1241898142;s:17:\"session.timer.now\";i:1241898142;s:22:\"session.client.browser\";s:89:\"Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10\";s:8:\"registry\";O:9:\"JRegistry\":3:{s:17:\"_defaultNameSpace\";s:7:\"session\";s:9:\"_registry\";a:1:{s:7:\"session\";a:1:{s:4:\"data\";O:8:\"stdClass\":0:{}}}s:7:\"_errors\";a:0:{}}s:4:\"user\";O:5:\"JUser\":19:{s:2:\"id\";i:0;s:4:\"name\";N;s:8:\"username\";N;s:5:\"email\";N;s:8:\"password\";N;s:14:\"password_clear\";s:0:\"\";s:8:\"usertype\";N;s:5:\"block\";N;s:9:\"sendEmail\";i:0;s:3:\"gid\";i:0;s:12:\"registerDate\";N;s:13:\"lastvisitDate\";N;s:10:\"activation\";N;s:6:\"params\";N;s:3:\"aid\";i:0;s:5:\"guest\";i:1;s:7:\"_params\";O:10:\"JParameter\":7:{s:4:\"_raw\";s:0:\"\";s:4:\"_xml\";N;s:9:\"_elements\";a:0:{}s:12:\"_elementPath\";a:1:{i:0;s:74:\"/var/www/vhosts/mylsfm.de/httpdocs/libraries/joomla/html/parameter/element\";}s:17:\"_defaultNameSpace\";s:8:\"_default\";s:9:\"_registry\";a:1:{s:8:\"_default\";a:1:{s:4:\"data\";O:8:\"stdClass\":0:{}}}s:7:\"_errors\";a:0:{}}s:9:\"_errorMsg\";N;s:7:\"_errors\";a:0:{}}}'),('','1241895560','dacaf20e1640e899849db70df00f3666',1,0,'',0,0,'__default|a:7:{s:15:\"session.counter\";i:1;s:19:\"session.timer.start\";i:1241895560;s:18:\"session.timer.last\";i:1241895560;s:17:\"session.timer.now\";i:1241895560;s:22:\"session.client.browser\";s:72:\"Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)\";s:8:\"registry\";O:9:\"JRegistry\":3:{s:17:\"_defaultNameSpace\";s:7:\"session\";s:9:\"_registry\";a:1:{s:7:\"session\";a:1:{s:4:\"data\";O:8:\"stdClass\":0:{}}}s:7:\"_errors\";a:0:{}}s:4:\"user\";O:5:\"JUser\":19:{s:2:\"id\";i:0;s:4:\"name\";N;s:8:\"username\";N;s:5:\"email\";N;s:8:\"password\";N;s:14:\"password_clear\";s:0:\"\";s:8:\"usertype\";N;s:5:\"block\";N;s:9:\"sendEmail\";i:0;s:3:\"gid\";i:0;s:12:\"registerDate\";N;s:13:\"lastvisitDate\";N;s:10:\"activation\";N;s:6:\"params\";N;s:3:\"aid\";i:0;s:5:\"guest\";i:1;s:7:\"_params\";O:10:\"JParameter\":7:{s:4:\"_raw\";s:0:\"\";s:4:\"_xml\";N;s:9:\"_elements\";a:0:{}s:12:\"_elementPath\";a:1:{i:0;s:74:\"/var/www/vhosts/mylsfm.de/httpdocs/libraries/joomla/html/parameter/element\";}s:17:\"_defaultNameSpace\";s:8:\"_default\";s:9:\"_registry\";a:1:{s:8:\"_default\";a:1:{s:4:\"data\";O:8:\"stdClass\":0:{}}}s:7:\"_errors\";a:0:{}}s:9:\"_errorMsg\";N;s:7:\"_errors\";a:0:{}}}'),('','1241896217','1b0eb3b74a6dfa2a4e408c6e7cb4c6d6',1,0,'',0,0,'__default|a:7:{s:15:\"session.counter\";i:1;s:19:\"session.timer.start\";i:1241896217;s:18:\"session.timer.last\";i:1241896217;s:17:\"session.timer.now\";i:1241896217;s:22:\"session.client.browser\";s:53:\"Baiduspider+(+http://www.baidu.com/search/spider.htm)\";s:8:\"registry\";O:9:\"JRegistry\":3:{s:17:\"_defaultNameSpace\";s:7:\"session\";s:9:\"_registry\";a:1:{s:7:\"session\";a:1:{s:4:\"data\";O:8:\"stdClass\":0:{}}}s:7:\"_errors\";a:0:{}}s:4:\"user\";O:5:\"JUser\":19:{s:2:\"id\";i:0;s:4:\"name\";N;s:8:\"username\";N;s:5:\"email\";N;s:8:\"password\";N;s:14:\"password_clear\";s:0:\"\";s:8:\"usertype\";N;s:5:\"block\";N;s:9:\"sendEmail\";i:0;s:3:\"gid\";i:0;s:12:\"registerDate\";N;s:13:\"lastvisitDate\";N;s:10:\"activation\";N;s:6:\"params\";N;s:3:\"aid\";i:0;s:5:\"guest\";i:1;s:7:\"_params\";O:10:\"JParameter\":7:{s:4:\"_raw\";s:0:\"\";s:4:\"_xml\";N;s:9:\"_elements\";a:0:{}s:12:\"_elementPath\";a:1:{i:0;s:74:\"/var/www/vhosts/mylsfm.de/httpdocs/libraries/joomla/html/parameter/element\";}s:17:\"_defaultNameSpace\";s:8:\"_default\";s:9:\"_registry\";a:1:{s:8:\"_default\";a:1:{s:4:\"data\";O:8:\"stdClass\":0:{}}}s:7:\"_errors\";a:0:{}}s:9:\"_errorMsg\";N;s:7:\"_errors\";a:0:{}}}'),('','1241898498','82e0ac6013f94b733fd462f01462fb65',1,0,'',0,0,'__default|a:7:{s:15:\"session.counter\";i:5;s:19:\"session.timer.start\";i:1241898186;s:18:\"session.timer.last\";i:1241898291;s:17:\"session.timer.now\";i:1241898498;s:22:\"session.client.browser\";s:84:\"Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.19) Gecko/20090113 SeaMonkey/1.1.14\";s:8:\"registry\";O:9:\"JRegistry\":3:{s:17:\"_defaultNameSpace\";s:7:\"session\";s:9:\"_registry\";a:1:{s:7:\"session\";a:1:{s:4:\"data\";O:8:\"stdClass\":0:{}}}s:7:\"_errors\";a:0:{}}s:4:\"user\";O:5:\"JUser\":19:{s:2:\"id\";i:0;s:4:\"name\";N;s:8:\"username\";N;s:5:\"email\";N;s:8:\"password\";N;s:14:\"password_clear\";s:0:\"\";s:8:\"usertype\";N;s:5:\"block\";N;s:9:\"sendEmail\";i:0;s:3:\"gid\";i:0;s:12:\"registerDate\";N;s:13:\"lastvisitDate\";N;s:10:\"activation\";N;s:6:\"params\";N;s:3:\"aid\";i:0;s:5:\"guest\";i:1;s:7:\"_params\";O:10:\"JParameter\":7:{s:4:\"_raw\";s:0:\"\";s:4:\"_xml\";N;s:9:\"_elements\";a:0:{}s:12:\"_elementPath\";a:1:{i:0;s:74:\"/var/www/vhosts/mylsfm.de/httpdocs/libraries/joomla/html/parameter/element\";}s:17:\"_defaultNameSpace\";s:8:\"_default\";s:9:\"_registry\";a:1:{s:8:\"_default\";a:1:{s:4:\"data\";O:8:\"stdClass\":0:{}}}s:7:\"_errors\";a:0:{}}s:9:\"_errorMsg\";N;s:7:\"_errors\";a:0:{}}}');
/*!40000 ALTER TABLE `mylsfm_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_stats_agents`
--

DROP TABLE IF EXISTS `mylsfm_stats_agents`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_stats_agents` (
  `agent` varchar(255) NOT NULL default '',
  `type` tinyint(1) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_stats_agents`
--

LOCK TABLES `mylsfm_stats_agents` WRITE;
/*!40000 ALTER TABLE `mylsfm_stats_agents` DISABLE KEYS */;
/*!40000 ALTER TABLE `mylsfm_stats_agents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_templates_menu`
--

DROP TABLE IF EXISTS `mylsfm_templates_menu`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_templates_menu` (
  `template` varchar(255) NOT NULL default '',
  `menuid` int(11) NOT NULL default '0',
  `client_id` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`menuid`,`client_id`,`template`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_templates_menu`
--

LOCK TABLES `mylsfm_templates_menu` WRITE;
/*!40000 ALTER TABLE `mylsfm_templates_menu` DISABLE KEYS */;
INSERT INTO `mylsfm_templates_menu` VALUES ('mylsfm',0,0),('khepri',0,1);
/*!40000 ALTER TABLE `mylsfm_templates_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_users`
--

DROP TABLE IF EXISTS `mylsfm_users`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `username` varchar(150) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `usertype` varchar(25) NOT NULL default '',
  `block` tinyint(4) NOT NULL default '0',
  `sendEmail` tinyint(4) default '0',
  `gid` tinyint(3) unsigned NOT NULL default '1',
  `registerDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`),
  KEY `gid_block` (`gid`,`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_users`
--

LOCK TABLES `mylsfm_users` WRITE;
/*!40000 ALTER TABLE `mylsfm_users` DISABLE KEYS */;
INSERT INTO `mylsfm_users` VALUES (62,'Mellimaus','Mellipupsi','newcomer@mylsfm.de','138d4dfb2fc41c0ce23031b83fa5f2e4:l6rlkRmJEKiYl11Bs38W8thKwLgvG1lN','Super Administrator',0,1,25,'2009-04-28 17:32:10','2009-05-08 20:45:25','','admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),(63,'nekrad','nekrad','weigelt@metux.de','d9cd6d5cb7bae1a2c5c42de5c92727ed:kKRvCNNUNELaR9njnas7RF2BMK5Mi9i9','Super Administrator',0,0,25,'2009-05-06 20:41:06','0000-00-00 00:00:00','','admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n');
/*!40000 ALTER TABLE `mylsfm_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mylsfm_weblinks`
--

DROP TABLE IF EXISTS `mylsfm_weblinks`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mylsfm_weblinks` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `url` varchar(250) NOT NULL default '',
  `description` text NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `archived` tinyint(1) NOT NULL default '0',
  `approved` tinyint(1) NOT NULL default '1',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `catid` (`catid`,`published`,`archived`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mylsfm_weblinks`
--

LOCK TABLES `mylsfm_weblinks` WRITE;
/*!40000 ALTER TABLE `mylsfm_weblinks` DISABLE KEYS */;
INSERT INTO `mylsfm_weblinks` VALUES (1,2,0,'Joomla!','joomla','http://www.joomla.org','Das Zuhause von Joomla!','2005-02-14 15:19:02',3,1,0,'0000-00-00 00:00:00',1,0,1,'target=0'),(2,2,0,'php.net','php','http://www.php.net','Die Sprache, mit der Joomla! entwickelt wird','2004-07-07 11:33:24',6,1,0,'0000-00-00 00:00:00',3,0,1,''),(3,2,0,'MySQL','mysql','http://www.mysql.com','Die Datenbank, die Joomla! nutzt','2004-07-07 10:18:31',1,1,0,'0000-00-00 00:00:00',5,0,1,''),(4,2,0,'OpenSourceMatters','opensourcematters','http://www.opensourcematters.org','Das Zuhause von OSM','2005-02-14 15:19:02',11,1,0,'0000-00-00 00:00:00',2,0,1,'target=0'),(5,2,0,'Joomla!-Foren','joomla-foren','http://forum.joomla.org','Joomla! Foren','2005-02-14 15:19:02',4,1,0,'0000-00-00 00:00:00',4,0,1,'target=0'),(6,2,0,'Ohloh über Joomla!','ohloh-ueber-joomla','http://www.ohloh.net/projects/20','Sachliche Berichte von Ohloo über die Aktivitäten der Joomla-Entwicklung. Joomla! hat einige ernsthaft anerkannte Star-Programmierer.','2007-07-19 09:28:31',1,1,0,'0000-00-00 00:00:00',6,0,1,'target=0\n\n');
/*!40000 ALTER TABLE `mylsfm_weblinks` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-05-09 19:50:04
