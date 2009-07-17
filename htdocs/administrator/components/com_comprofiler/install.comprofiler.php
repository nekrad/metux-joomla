<?php
/**
* Joomla/Mambo Community Builder
* @version $Id: install.comprofiler.php 567 2006-11-19 10:05:00Z beat $
* @package Community Builder
* @subpackage install.comprofiler.php
* @author JoomlaJoe and Beat
* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );


function com_install() {
  global $database, $mainframe;

  # Show installation result to user
  ?>
 <div style="text-align:left;">
  <table width="100%" border="0">
    <tr>
      <td>
	<img src="../components/com_comprofiler/images/smcblogo.gif" />
      </td>
    </tr>
    <tr>
      <td>
    	<br />Copyright 2004 - 2007 MamboJoe/JoomlaJoe, Beat and CB team on joomlapolis.com . This component is released under the GNU/GPL version 2 License and parts under Community Builder Free License. All copyright statements must be kept. Derivate work must prominently duly acknowledge original work and include visible online links. Official site: <a href="http://www.joomlapolis.com">www.joomlapolis.com</a>
    	<br />
      </td>
    </tr>
    <tr>
      <td background="F0F0F0" colspan="2">
        <code>Installation Process:<br />
        <?php

          # Set up new icons for admin menu
          echo "Start correcting icons in administration backend.<br />";
          $database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/content.png' WHERE admin_menu_link='option=com_comprofiler&task=showLists'");
          $iconresult[0] = $database->query();
          $database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/content.png' WHERE admin_menu_link='option=com_comprofiler&task=showField'");
          $iconresult[1] = $database->query();
          $database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/content.png' WHERE admin_menu_link='option=com_comprofiler&task=showTab'");
          $iconresult[2] = $database->query();
          $database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/config.png' WHERE admin_menu_link='option=com_comprofiler&task=showconfig'");
          $iconresult[3] = $database->query();
          $database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/users.png' WHERE admin_menu_link='option=com_comprofiler&task=showusers'");
          $iconresult[4] = $database->query();
          $database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/install.png' WHERE admin_menu_link='option=com_comprofiler&task=showPlugins'");
          $iconresult[5] = $database->query();         
          foreach ($iconresult as $i=>$icresult) {
            if ($icresult) {
              echo "<font color='green'>FINISHED:</font> Image of menu entry $i has been corrected.<br />";
            } else {
              echo "<font color='red'>ERROR:</font> Image of menu entry $i could not be corrected.<br />";
            }
          }
	 $database->setQuery("SELECT COUNT(*) FROM #__components WHERE link = 'option=com_comprofiler'");
         $components = $database->loadresult();
	 IF($components > 1) {
		$database->setQuery("SELECT id FROM #__components WHERE link = 'option=com_comprofiler' ORDER BY id DESC LIMIT 1");
         	$comid = $database->loadresult();
		$database->setQuery("DELETE FROM #__components WHERE link  = 'option=com_comprofiler' AND id != $comid  ");
         	$database->query();
		//print $database->getquery();
		$database->setQuery("DELETE FROM #__components WHERE #__components.option = 'com_comprofiler' AND parent != $comid AND id != $comid ");
         	$database->query();
		//print $database->getquery();
              	echo "<font color='green'>FINISHED:</font> Administrator Menu Corrected.<br />";
	} 

	//Manage Database Upgrades
	$MCBUpgrades = array();
	
	//Beta 3 Upgrade
	$MCBUpgrades[0]['test'] = "SELECT `default` FROM #__comprofiler_lists";
	$MCBUpgrades[0]['updates'][0] = "ALTER TABLE `#__comprofiler_lists`"
					."\n ADD `default` TINYINT( 1 ) DEFAULT '0' NOT NULL,"
					."\n ADD `usergroupids` VARCHAR( 255 ),"
					."\n ADD `sortfields` VARCHAR( 255 ),"
					."\n ADD `ordering` INT( 11 ) DEFAULT '0' NOT NULL AFTER `published`";
	$MCBUpgrades[0]['updates'][1] = "UPDATE #__comprofiler_lists SET `default`=1 WHERE published =1";
	$MCBUpgrades[0]['updates'][2] = "UPDATE #__comprofiler_lists SET usergroupids = '29, 18, 19, 20, 21, 30, 23, 24, 25', sortfields = '`username` ASC'";
	$MCBUpgrades[0]['updates'][3] = "ALTER TABLE `#__comprofiler` ADD `acceptedterms` TINYINT( 1 ) DEFAULT '0' NOT NULL AFTER `bannedreason`";
	$MCBUpgrades[0]['message'] = "1.0 Beta 2 to 1.0 Beta 3";


	//Beta 4 Upgrade
	$MCBUpgrades[1]['test'] = "SELECT `firstname` FROM #__comprofiler";
	$MCBUpgrades[1]['updates'][0] = "ALTER TABLE #__comprofiler ADD `firstname` VARCHAR( 100 ) AFTER `user_id` ,"
					."\n ADD `middlename` VARCHAR( 100 ) AFTER `firstname` ,"
					."\n ADD `lastname` VARCHAR( 100 ) AFTER `middlename` ";
	$MCBUpgrades[1]['updates'][1] = "ALTER TABLE `#__comprofiler_fields` ADD `readonly` TINYINT( 1 ) DEFAULT '0' NOT NULL AFTER `profile`";
	$MCBUpgrades[1]['updates'][3] = "ALTER TABLE `#__comprofiler_tabs` ADD `width` VARCHAR( 10 ) DEFAULT '.5' NOT NULL AFTER `ordering` ,"
					."\n ADD `enabled` TINYINT( 1 ) DEFAULT '1' NOT NULL AFTER `width` ," 
					."\n ADD `plugin` VARCHAR( 255 ) DEFAULT NULL AFTER `enabled`" ;

	$MCBUpgrades[1]['message'] = "1.0 Beta 3 to 1.0 Beta 4";

	//RC 1 Upgrade
	$MCBUpgrades[2]['test'] = "SELECT `fields` FROM #__comprofiler_tabs";
	$MCBUpgrades[2]['updates'][0] = "ALTER TABLE #__comprofiler_tabs ADD `plugin_include` VARCHAR( 255 ) AFTER `plugin` ,"
					."\n ADD `fields` TINYINT( 1 ) DEFAULT '1' NOT NULL AFTER `plugin_include` ";
	$MCBUpgrades[2]['updates'][1] = "INSERT INTO `#__comprofiler_tabs` ( `title`, `description`, `ordering`, `width`, `enabled`, `plugin`, `plugin_include`, `fields`, `sys`) VALUES " 
					."\n ( '_UE_CONTACT_INFO_HEADER', '', -4, '1', 1, 'getContactTab', NULL, 1, 1),"
					."\n ( '_UE_AUTHORTAB', '', -3, '1', 0, 'getAuthorTab', NULL, 0, 1),"
					."\n ( '_UE_FORUMTAB', '', -2, '1', 0, 'getForumTab', NULL, 0, 1),"	
					."\n ( '_UE_BLOGTAB', '', -1, '1', 0, 'getBlogTab', NULL, 0, 1);";
	$MCBUpgrades[2]['updates'][2] = "ALTER TABLE `#__comprofiler_lists` ADD `filterfields` VARCHAR( 255 ) AFTER `sortfields`;";
	$MCBUpgrades[2]['message'] = "1.0 Beta 4 to 1.0 RC 1";

	//RC 2 Upgrade
	$MCBUpgrades[3]['test'] = "SELECT `description` FROM #__comprofiler_fields";
	$MCBUpgrades[3]['updates'][0] = "ALTER TABLE `#__comprofiler_fields` ADD `description` MEDIUMTEXT  NOT NULL default '' AFTER `title` ";
	$MCBUpgrades[3]['updates'][1] = "ALTER TABLE `#__comprofiler_fields` CHANGE `title` `title` VARCHAR( 255 ) NOT NULL";
	$MCBUpgrades[3]['updates'][2] = "INSERT INTO `#__comprofiler_tabs` (`title`, `description`, `ordering`, `width`, `enabled`, `plugin`, `plugin_include`, `fields`, `sys`) VALUES " 
					."\n ( '_UE_CONNECTION', '',99, '1', 0, 'getConnectionTab', NULL, 0, 1);";
	$MCBUpgrades[3]['updates'][3] = "INSERT INTO `#__comprofiler_tabs` (`title`, `description`, `ordering`, `width`, `enabled`, `plugin`, `plugin_include`, `fields`, `sys`) VALUES " 
					."\n ( '_UE_NEWSLETTER_HEADER', '_UE_NEWSLETTER_INTRODCUTION', 99, '1', 0, 'getNewslettersTab', NULL, 0, 1);";
	$MCBUpgrades[3]['updates'][4] = "UPDATE `#__comprofiler_tabs` SET sys=2, enabled=1 WHERE plugin='getContactTab' ";
	$MCBUpgrades[3]['updates'][5] = "ALTER TABLE `#__comprofiler_lists` ADD `useraccessgroupid` INT( 9 ) DEFAULT '18' NOT NULL AFTER `usergroupids` ";
	$MCBUpgrades[3]['message'] = "1.0 RC 1 to 1.0 RC 2 part 1";
	
	$MCBUpgrades[4]['test'] = "SELECT `params` FROM #__comprofiler_tabs";
	$MCBUpgrades[4]['updates'][0] = "ALTER TABLE `#__comprofiler_tabs` CHANGE `plugin` `pluginclass` VARCHAR( 255 ) DEFAULT NULL , "
					."\n CHANGE `plugin_include` `pluginid` INT( 11 ) DEFAULT NULL ";
	$MCBUpgrades[4]['updates'][1] = "ALTER TABLE `#__comprofiler_tabs` ADD `params` MEDIUMTEXT AFTER `fields` ;";
	$MCBUpgrades[4]['updates'][2] = "ALTER TABLE `#__comprofiler_fields` ADD `pluginid` INT( 11 ) , "
					."\n ADD `params` MEDIUMTEXT; ";
	$MCBUpgrades[4]['updates'][3] = "UPDATE `#__comprofiler_tabs` SET pluginid=1 WHERE pluginclass='getContactTab' ";	
	$MCBUpgrades[4]['updates'][4] = "UPDATE `#__comprofiler_tabs` SET pluginid=1 WHERE pluginclass='getConnectionTab' ";
	$MCBUpgrades[4]['updates'][5] = "UPDATE `#__comprofiler_tabs` SET pluginid=3 WHERE pluginclass='getAuthorTab' ";	
	$MCBUpgrades[4]['updates'][6] = "UPDATE `#__comprofiler_tabs` SET pluginid=4 WHERE pluginclass='getForumTab' ";	
	$MCBUpgrades[4]['updates'][7] = "UPDATE `#__comprofiler_tabs` SET pluginid=5 WHERE pluginclass='getBlogTab' ";
	$MCBUpgrades[4]['updates'][8] = "UPDATE `#__comprofiler_tabs` SET pluginid=6 WHERE pluginclass='getNewslettersTab' ";														
	$MCBUpgrades[4]['message'] = "1.0 RC 1 to 1.0 RC 2 part 2";

	$MCBUpgrades[5]['test'] = "SELECT `position` FROM #__comprofiler_tabs";
	$MCBUpgrades[5]['updates'][1] = "ALTER TABLE `#__comprofiler_tabs`"
					."\n ADD `position` VARCHAR( 255 ) DEFAULT '' NOT NULL,"
					."\n ADD `displaytype` VARCHAR( 255 ) DEFAULT '' NOT NULL AFTER `sys`";
	$MCBUpgrades[5]['updates'][2] = "UPDATE `#__comprofiler_tabs` SET position='cb_tabmain', displaytype='tab' ";	
	$MCBUpgrades[5]['updates'][3] = "INSERT INTO `#__comprofiler_tabs` (`title`, `description`, `ordering`, `width`, `enabled`, `pluginclass`, `pluginid`, `fields`, `sys`, `position`, `displaytype`) VALUES " 
					."\n ( '_UE_MENU', '', -10, '1', 1, 'getMenuTab', 14, 0, 1, 'cb_head', 'html'),"
					."\n ( '_UE_CONNECTIONPATHS', '', -9, '1', 1, 'getConnectionPathsTab', 2, 0, 1, 'cb_head', 'html'),"
					."\n ( '_UE_PROFILE_PAGE_TITLE', '', -8, '1', 1, 'getPageTitleTab', 1, 0, 1, 'cb_head', 'html'),"
					."\n ( '_UE_PORTRAIT', '', -7, '1', 1, 'getPortraitTab', 1, 0, 1, 'cb_middle', 'html'),"
					."\n ( '_UE_USER_STATUS', '', -6, '.5', 1, 'getStatusTab', 14, 0, 1, 'cb_right', 'html'),"
					."\n ( '_UE_PMSTAB', '', -5, '.5', 0, 'getmypmsproTab', 15, 0, 1, 'cb_right', 'html');";
	$MCBUpgrades[5]['updates'][5] = "UPDATE `#__comprofiler_tabs` SET pluginid=2 WHERE pluginclass='getConnectionTab' ";
	$MCBUpgrades[5]['updates'][6] = "ALTER TABLE `#__comprofiler_members` ADD `reason` MEDIUMTEXT default NULL AFTER `membersince` ";
	$MCBUpgrades[5]['updates'][7] = "UPDATE `#__comprofiler_tabs` SET `pluginclass`=NULL, `pluginid`=NULL WHERE `pluginclass` != 'getContactTab' AND `fields` = 1";
	// this is from build 10 to 11:
	// changed back sys=3 -> 1 for _UE_MENU and _UE_USER_STATUS
	// $MCBUpgrades[5]['updates'][8] = "ALTER TABLE `#__comprofiler_fields` CHANGE `default` `default` MEDIUMTEXT DEFAULT NULL";
	// this last one is only for upgrades from build 8 to 9.
	$MCBUpgrades[5]['message'] = "1.0 RC 1 to 1.0 RC 2 part 3";

	// from 1.0.1 to 1.0.2: (includes RC2 to 1.0):
	$MCBUpgrades[6]['test'] = "SELECT `cbactivation` FROM #__comprofiler";
	// from RC2 to 1.0 stable:	in fact did it always up to now, since we can alter tables indefinitely.
	// $MCBUpgrades[6]['test'] = "SELECT `thiswillneverexistasitscrapz` FROM #__comprofiler_tabs"; // ?
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler_fields` CHANGE `default` `default` MEDIUMTEXT DEFAULT NULL;";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler_fields` CHANGE `tabid` `tabid` int(11) DEFAULT NULL;";
	$MCBUpgrades[6]['updates'][] = "UPDATE `#__users` SET usertype='Registered' WHERE usertype='';";	// fix effect of previous bug in CB registration
	// $MCBUpgrades[6]['message'] = "1.0 RC 2 to 1.0 stable";
	// from 1.0.1 to 1.0.2: (includes RC2 to 1.0):
	$MCBUpgrades[6]['updates'][] = "UPDATE `#__comprofiler_fields` SET `table`='#__users' WHERE name='email';";
	$MCBUpgrades[6]['updates'][] = "UPDATE `#__comprofiler_fields` SET `table`='#__users' WHERE name='lastvisitDate';";
	$MCBUpgrades[6]['updates'][] = "UPDATE `#__comprofiler_fields` SET `table`='#__users' WHERE name='registerDate';";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE #__comprofiler ADD `registeripaddr` VARCHAR( 50 ) DEFAULT '' NOT NULL AFTER `lastupdatedate`;";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE #__comprofiler ADD `cbactivation` VARCHAR( 50 ) DEFAULT '' NOT NULL AFTER `registeripaddr`;";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE #__comprofiler ADD `message_last_sent` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `hits`;";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE #__comprofiler ADD `message_number_sent` INT( 11 ) DEFAULT 0 NOT NULL AFTER `message_last_sent`;";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler_field_values` ADD INDEX fieldid_ordering (`fieldid`, `ordering` );";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler_fields` ADD INDEX `tabid_pub_prof_order` ( `tabid` , `published` , `profile` , `ordering` );";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler_fields` ADD INDEX `readonly_published_tabid` ( `readonly` , `published` , `tabid` );";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler_fields` ADD INDEX `registration_published_order` ( `registration` , `published` , `ordering` );";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler_members` ADD INDEX `pamr` ( `pending` , `accepted` , `memberid` , `referenceid` );";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler_members` ADD INDEX `aprm` ( `accepted` , `pending` , `referenceid` , `memberid` );";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler_members` ADD INDEX `membrefid` ( `memberid` , `referenceid` );";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler_plugin` ADD INDEX `type_pub_order` ( `type` , `published` , `ordering` );";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler_tabs` ADD INDEX `enabled_position_ordering` ( `enabled` , `position` , `ordering` );";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler_lists` ADD INDEX `pub_ordering` ( `published` , `ordering` );";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler_lists` ADD INDEX `default_published` ( `default` , `published` );";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler_userreports` ADD INDEX `status_user_date` ( `reportedstatus` , `reporteduser` , `reportedondate` );";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler_userreports` ADD INDEX `reportedbyuser_ondate` ( `reportedbyuser` , `reportedondate` );";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler_views` ADD INDEX `lastview` ( `lastview` );";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler_views` ADD INDEX `profile_id_lastview` (`profile_id`,`lastview`);";
	$MCBUpgrades[6]['updates'][] = "UPDATE `#__comprofiler` SET `user_id`=`id` WHERE 1>0;";	// fix in case something corrupt for unique key
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler` ADD UNIQUE KEY user_id (`user_id`);";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler` ADD INDEX `apprconfbanid` ( `approved` , `confirmed` , `banned` , `id` );";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler` ADD INDEX `avatappr_apr_conf_ban_avatar` ( `avatarapproved` , `approved` , `confirmed` , `banned` , `avatar` );";
	$MCBUpgrades[6]['updates'][] = "ALTER TABLE `#__comprofiler` ADD INDEX `lastupdatedate` ( `lastupdatedate` );";
	$MCBUpgrades[6]['message'] = "1.0 RC 2, 1.0 and 1.0.1 to 1.0.2";

	// from 1.0.2 to 1.1:
	$MCBUpgrades[7]['test'] = "SELECT `ordering_register` FROM #__comprofiler_tabs";
	$MCBUpgrades[7]['updates'][] = "ALTER TABLE `#__comprofiler_plugin` ADD `backend_menu` VARCHAR( 255 ) NOT NULL DEFAULT '' AFTER `folder`;";
	$MCBUpgrades[7]['updates'][] = "ALTER TABLE `#__comprofiler_tabs` ADD `ordering_register` int( 11 ) NOT NULL DEFAULT 10 AFTER `ordering`;";
	$MCBUpgrades[7]['updates'][] = "ALTER TABLE `#__comprofiler_tabs` ADD `useraccessgroupid` int( 9 ) DEFAULT -2 NOT NULL AFTER `position`;";
	$MCBUpgrades[7]['updates'][] = "ALTER TABLE `#__comprofiler_tabs` ADD INDEX `orderreg_enabled_pos_order` ( `enabled` , `ordering_register` , `position` , `ordering` );";
	$MCBUpgrades[7]['updates'][] = "ALTER TABLE `#__comprofiler` ADD `unbannedby` int(11) default NULL AFTER `bannedby`;";
	$MCBUpgrades[7]['updates'][] = "ALTER TABLE `#__comprofiler` ADD `unbanneddate` datetime default NULL AFTER `banneddate`;";
	$MCBUpgrades[7]['updates'][] = "ALTER TABLE `#__comprofiler_field_values` CHANGE `fieldtitle` `fieldtitle` VARCHAR(255) NOT NULL DEFAULT '';";
	$MCBUpgrades[7]['message'] = "1.0.2 to 1.1";

	//Apply Upgrades
	foreach ($MCBUpgrades AS $MCBUpgrade) {
		$database->setQuery($MCBUpgrade['test']);
		//if it fails test then apply upgrade
		if (!$database->query()) {
			foreach($MCBUpgrade['updates'] as $MCBScript) {
				$database->setQuery($MCBScript);
				if(!$database->query()) {
					//Upgrade failed
					print("<font color=red>".$MCBUpgrade['message']." failed! SQL error:" . $database->stderr(true)."</font><br />");
					// return;
				}
			}
			//Upgrade was successful
			print "<font color=green>".$MCBUpgrade['message']." Upgrade Applied Successfully!</font><br />";			
		} 
	}

	$sql="SELECT listid FROM #__comprofiler_lists ORDER BY published desc";
	$database->setQuery($sql);
	$lists = $database->loadObjectList();
	$order=0;
	if ( $lists ) {
		foreach($lists AS $list) {
			$database->setQuery("UPDATE #__comprofiler_lists SET ordering = $order WHERE listid='".$list->listid."'");
			$database->query();
			$order++;
		}
	}
        ?>

      </td>
    </tr>
    <tr>
	<td>
	<?php
if(is_writable($mainframe->getCfg( 'absolute_path' ) . "/images/")) {
	$galleryFiles = array("airplane.gif"
			,"ball.gif"
			,"butterfly.gif"
			,"car.gif"
			,"dog.gif"
			,"duck.gif"
			,"fish.gif"
			,"frog.gif"
			,"guitar.gif"
			,"kick.gif"
			,"pinkflower.gif"
			,"redflower.gif"
			,"skater.gif"
			,"index.html"); 
	  if(!file_exists($mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/")){
	    if(mkdir($mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/")) {
	    		print "<font color=green>".$mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/ Successfully added!</font><br />";
		} else {
			print "<font color=red>".$mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/ Failed to be to be created, please do so manually!</font><br />";
		}
	  }  else {
	    print "<font color=green>".$mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/ already exists!</font><br />";
	  }
	  if(!file_exists($mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/gallery/")){
	    if(mkdir($mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/gallery/")) {
	    		print "<font color=green>".$mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/gallery/ Successfully added!</font><br />";
		} else {
			print "<font color=red>".$mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/gallery/ Failed to be to be created, please do so manually!</font><br />";
		}
	  }  else {
	    print "<font color=green>".$mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/gallery/ already exists!</font><br />";
	  }
	  if(!is_writable($mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/")){
	    if(!chmod($mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/", 0777)) {
			print "<font color=red>".$mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/ Failed to be chmod'd to 777 please do so manually!</font><br />";
		}
	  }
	  if(!is_writable($mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/gallery/")){
	    if(!chmod($mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/gallery/", 0777)) {
			print "<font color=red>".$mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/gallery/ Failed to be chmod'd to 777 please do so manually!</font><br />";
		}
	  }
	  foreach($galleryFiles AS $galleryFile) {
		IF(copy($mainframe->getCfg( 'absolute_path' ) . "/components/com_comprofiler/images/gallery/".$galleryFile,$mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/gallery/".$galleryFile)) {
			print "<font color=green>".$galleryFile." Successfully added to the gallery!</font><br />";

		} ELSE {
			print "<font color=red>".$galleryFile." Failed to be added to the gallery please do so manually!</font><br />";
		}
	  }
} else {
	print "<font color=red>".$mainframe->getCfg( 'absolute_path' ) . "/images/ is not writable!<br />  Manually do the following:<br /> 1.) create ".$mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/ directory <br /> 2.) chmod it to 777 <br /> 3.) create ".$mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/gallery/ <br /> 4.) chmod it to 777 <br />5.) copy ".$mainframe->getCfg( 'absolute_path' ) . "/components/com_comprofiler/images/gallery/ and its contents to ".$mainframe->getCfg( 'absolute_path' ) . "/images/comprofiler/gallery/  </font><br />";
}
/*
if (!file_exists($mainframe->getCfg( 'absolute_path' ) . "/includes/domit/")) {
	print "<font color='red'>".$mainframe->getCfg( 'absolute_path' ) . "/includes/domit/ does not exist! This is normal with mambo 4.5.0 and 4.6.1. Community Builder needs this library for handling plugins.<br />  You Must Manually do the following:<br /> 1.) create ".$mainframe->getCfg( 'absolute_path' ) . "/includes/domit/ directory <br /> 2.) chmod it to 777 <br /> 3.) copy corresponding content of a mambo 4.5.2 directory.</font><br /><br />\n";
}
*/
if (!(file_exists($mainframe->getCfg( 'absolute_path' ) . "/libraries/pcl/") || file_exists($mainframe->getCfg( 'absolute_path' ) . '/administrator/includes/pcl/'))) {
	print "<font color='red'>".$mainframe->getCfg( 'absolute_path' ) . "/administrator/includes/pcl/ does not exist! This is normal with mambo 4.5.0. Community Builder needs this library for handling plugins.<br />  Manually do the following:<br /> 1.) create ".$mainframe->getCfg( 'absolute_path' ) . "/administrator/includes/pcl/ directory <br /> 2.) chmod it to 777 <br /> 3.) copy corresponding content of a mambo 4.5.2 directory.</font><br /><br />\n";
}
?>
        <font color="green"><b>Installation finished. Important: Please read README.TXT and manual for further settings.</b></font></code>
      </td>
    </tr>
  </table>
 </div>
  <?php
}

?>
