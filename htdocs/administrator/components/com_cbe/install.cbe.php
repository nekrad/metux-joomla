<?php
/*************************************************************
* Mambo Community Builder
* Author MamboJoe
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*************************************************************/
error_reporting(E_ALL);
function com_install() {
	$database = &JFactory::getDBO();
	require_once( JPATH_SITE . '/includes/domit/xml_domit_lite_include.php' );
	# Show installation result to user
  ?>
  <center>
	<script language="JavaScript">
	function cbe_ge(objID) {
		return document.getElementById(objID);
	}

	function cbe_toggle(obj) {
		var el = cbe_ge(obj);
		el.style.display = (el.style.display != 'none' ? 'none' : '' );
	}
	</script>
<div id='cbe_installation'>
	<table width=100% style="margin: 10px;" cellpadding=4 cellspacing=4>
		<tr>
		<td width=20%>
		<img src="<?php echo JURI::root() . "components/com_cbe/images/cbelogo-gruen.jpg";?>">
		</td>
		<td width=80% valign=top>
		<h2>Danke für die Benutzung des CBE 1.5 !</h2><br />
		Weitere Informationen, Forum und Updates gibt es auf <a href='http://www.joomla-cbe.de'>www.joomla-cbe.de</a>.<br />
		Möchten Sie jetzt die <a href="index.php?option=com_cbe&task=loadSampleData">Beispieldaten installieren</a> ?<br />
		Bitte <a href="javascript:cbe_toggle('cbe_installation_log')">hier klicken</a> für einen ausführlichen Installationslog.<br /><br />
		<a href="index.php?option=com_cbe">Zum CBE</a>.
		</td>
		</tr>
	</table>
</div>
<div id='cbe_installation_log' style='display:none'>
  <table width="100%" border="0">
    <tr>
      <td>
	<img src="../components/com_cbe/images/cbeblogo.gif" />
      </td>
    </tr>
    <tr>
      <td background="F0F0F0" colspan="2">
        <code>Installation Process:<br />
        <?php

	//sv0.6232
	$database->setQuery("SELECT id FROM #__components WHERE link = 'option=com_cbe' ORDER BY id DESC LIMIT 1");
	$comid = $database->loadresult();

        //Manage Database Upgrades
        $MCBUpgrades = array();

        //Beta 3 Upgrade  ---- done by xml -> without function here
        $MCBUpgrades[0]['test'] = "SELECT `default` FROM #__cbe_lists";
        $MCBUpgrades[0]['updates'][0] = "ALTER TABLE `#__cbe_lists`"
        ."\n ADD `default` TINYINT( 1 ) DEFAULT '0' NOT NULL,"
        ."\n ADD `usergroupids` VARCHAR( 255 ),"
        ."\n ADD `sortfields` VARCHAR( 255 ),"
        ."\n ADD `ordering` INT( 11 ) DEFAULT '0' NOT NULL AFTER `published`";
        $MCBUpgrades[0]['updates'][1] = "UPDATE #__cbe_lists SET `default`=1 WHERE published =1";
        $MCBUpgrades[0]['updates'][2] = "UPDATE #__cbe_lists SET usergroupids = '29, 18, 19, 20, 21, 30, 23, 24, 25', sortfields = '`username` ASC'";
        $MCBUpgrades[0]['updates'][3] = "ALTER TABLE `#__cbe` ADD `acceptedterms` TINYINT( 1 ) DEFAULT '0' NOT NULL AFTER `bannedreason`";
        $MCBUpgrades[0]['message'] = "1.0 Beta 2 to 1.0 Beta 3";


        //Beta 4 Upgrade
        $MCBUpgrades[1]['test'] = "SELECT `firstname` FROM #__cbe";
        $MCBUpgrades[1]['updates'][0] = "ALTER TABLE #__cbe ADD `firstname` VARCHAR( 100 ) AFTER `user_id` ,"
        ."\n ADD `middlename` VARCHAR( 100 ) AFTER `firstname` ,"
        ."\n ADD `lastname` VARCHAR( 100 ) AFTER `middlename` ";
        $MCBUpgrades[1]['updates'][1] = "ALTER TABLE `#__cbe_fields` ADD `readonly` TINYINT( 1 ) DEFAULT '0' NOT NULL AFTER `profile`";
        $MCBUpgrades[1]['updates'][3] = "ALTER TABLE `#__cbe_tabs` ADD `width` VARCHAR( 10 ) DEFAULT '.5' NOT NULL AFTER `ordering` ,"
        ."\n ADD `enabled` TINYINT( 1 ) DEFAULT '1' NOT NULL AFTER `width` ,"
        ."\n ADD `plugin` VARCHAR( 255 ) DEFAULT NULL AFTER `enabled`" ;

        $MCBUpgrades[1]['message'] = "1.0 Beta 3 to 1.0 Beta 4";

        //CB Enhanced 11-03-2005 to CB Enhanced 14-03-2005
        $MCBUpgrades[2]['test'] = "SELECT `buddy` FROM #__cbe_buddylist";
        $MCBUpgrades[2]['updates'][0] = "ALTER TABLE `#__cbe_buddylist`,"
        ."\n ADD `buddy` tinyint( 4 ) DEFAULT '1' NOT NULL AFTER `buddyid`,"
        ."\n ADD `status` tinyint( 4 ) DEFAULT '0' NOT NULL AFTER `buddy`";
        $MCBUpgrades[2]['updates'][1] = "ALTER TABLE #__cbe_buddylist MODIFY buddy tinyint( 4 ) DEFAULT '0' NOT NULL";
        $MCBUpgrades[2]['message'] = "CB Enhanced 11-03-2005 to CB Enhanced 14-03-2005";

        //RC 1 Upgrade
        $MCBUpgrades[3]['test'] = "SELECT `fields` FROM #__cbe_tabs";
        $MCBUpgrades[3]['updates'][0] = "ALTER TABLE #__cbe_tabs ADD `plugin_include` VARCHAR( 255 ) AFTER `plugin` ,"
        ."\n ADD `fields` TINYINT( 1 ) DEFAULT '1' NOT NULL AFTER `plugin_include` ";
        $MCBUpgrades[3]['updates'][1] = "INSERT INTO `#__cbe_tabs` (`tabid`, `title`, `description`, `ordering`, `width`, `enabled`, `plugin`, `plugin_include`, `fields`, `sys`) VALUES "
        ."\n (3, '_UE_CONTACT_INFO_HEADER', '', -4, '1', 1, 'getContactTab', NULL, 1, 1),"
        ."\n (4, '_UE_AUTHORTAB', '', -3, '1', 0, 'getAuthorTab', NULL, 0, 1),"
        ."\n (5, '_UE_FORUMTAB', '', -2, '1', 0, 'getForumTab', NULL, 0, 1),"
        ."\n (6, '_UE_BLOGTAB', '', -1, '1', 0, 'getBlogTab', NULL, 0, 1);";
        $MCBUpgrades[3]['updates'][2] = "ALTER TABLE `#__cbe_lists` ADD `filterfields` VARCHAR( 255 ) AFTER `sortfields`;";
        $MCBUpgrades[3]['message'] = "1.0 Beta 4 to 1.0 RC 1 <br />";

        //RC 1 to CB Enhanced Upgrade
        $MCBUpgrades[4]['test'] = "SELECT `enhanced_params` FROM #__cbe_tabs";
        $MCBUpgrades[4]['updates'][0] = "ALTER TABLE #__cbe_tabs ADD enhanced_params TINYTEXT DEFAULT NULL AFTER sys";
        $MCBUpgrades[4]['updates'][1] = "INSERT INTO `#__cbe_tabs` (`tabid`, `title`, `description`, `ordering`, `width`, `enabled`, `plugin`, `plugin_include`, `fields`, `sys`, `enhanced_params`) VALUES "
        ."\n ('', '_UE_BUDDY_TAB_LABEL', 		'', '-10', '1', '0', '', NULL, 0, 0, 'profile=1\n tabtype=1\n enhancedname=buddy'),"
        ."\n ('', '_UE_GUESTBOOK_TAB_LABEL', 	'', '-9', '1', '0', '', NULL, 0, 0, 'profile=1\n tabtype=1\n enhancedname=guestbook'),"
        ."\n ('', '_UE_TESTIMONIAL_TAB_LABEL','', '-8', '1', '0', '', NULL, 0, 0,'profile=1\n tabtype=1\n enhancedname=testimonials'),"
        ."\n ('', '_UE_SB_FORUM_TAB_LABEL', 		'', '-7', '1', '0', '', NULL, 0, 0,'profile=1\n tabtype=1\n enhancedname=sb_forum'),"
        ."\n ('', '_UE_ARTICLES_TAB', 	'', '-6', '1', '0', '', NULL, 0, 0,'profile=1\n tabtype=1\n enhancedname=articles'),"
        ."\n ('', '_UE_AUTHOR_TAB_LABEL', 	'', '-5', '1', '0', '', NULL, 0, 0,'profile=1\n tabtype=1\n enhancedname=authors'),"
        ."\n ('', '_UE_PROFILE_COMMENTS_TAB_LABEL', 	'', '-4', '1', '0', '', NULL, 0, 0,'profile=1\n tabtype=1\n enhancedname=comments'),"
        ."\n ('', '_UE_ZOOM_PHOTOS_TAB_LABEL', 	'', '-3', '1', '0', '', NULL, 0, 0,'profile=1\n tabtype=1\n enhancedname=zoom'),"
        ."\n ('', '_UE_SB_MAMBLOG_TAB_LABEL', 		'', '-2', '1', '0', '', NULL, 0, 0,'profile=1\n tabtype=1\n enhancedname=mamblog'),"
        ."\n ('', '_UE_MY_PROFILE_JOURNAL_TAB_LABEL', 	'', '-1', '1', '0', '', NULL, 0, 0,'profile=1\n tabtype=1\n enhancedname=journal'),"
        ."\n ('', '_UE_LAST_VISITORS_TAB_LABEL', 	'', '-1', '1', '0', '', NULL, 0, 0,'profile=1\n tabtype=1\n enhancedname=lastvisitors'),"
        ."\n ('', '_UE_ZOOM_MP3_PHOTOS_TAB_LABEL', 	'', '-1', '1', '0', '', NULL, 0, 0,'profile=1\n tabtype=1\n enhancedname=zoom_mp3'),"
        ."\n ('', '_UE_GROUPJIVE_TAB_LABEL', 	'', '-1', '1', '0', '', NULL, 0, 0,'profile=1\n tabtype=1\n enhancedname=groupjive');";
        $MCBUpgrades[4]['updates'][2] = "DELETE FROM #__cbe_tabs WHERE plugin='getAuthorTab';";
        $MCBUpgrades[4]['updates'][3] = "DELETE FROM #__cbe_tabs WHERE plugin='getForumTab';";
        $MCBUpgrades[4]['updates'][4] = "DELETE FROM #__cbe_tabs WHERE plugin='getBlogTab';";
        $MCBUpgrades[4]['message'] = " CB Enhanced and CB RC 1 upgraded to CB Enhanced beta 2 <br />";

	// Upgrades PK Pack
	$MCBUpgrades[5]['test'] = "SELECT `last_ip` FROM #__cbe";
        $MCBUpgrades[5]['updates'][0] = "ALTER TABLE #__cbe ADD last_ip VARCHAR(255) AFTER lastname";
        $MCBUpgrades[5]['message'] = " CBE Beta-1 upgraded for IP-logging <br />";

	// Zodiac Update Checks
	$MCBUpgrades[7]['test'] = "SELECT `zodiac` FROM #__cbe";
        $MCBUpgrades[7]['updates'][0] = "ALTER TABLE #__cbe ADD zodiac VARCHAR(255) AFTER last_ip";
        $MCBUpgrades[7]['message'] = " CBE Beta-1 upgraded for Zodiac. <br />";
        
	$MCBUpgrades[8]['test'] = "SELECT `zodiac_c` FROM #__cbe";
        $MCBUpgrades[8]['updates'][0] = "ALTER TABLE #__cbe ADD zodiac_c VARCHAR(255) AFTER zodiac";
        $MCBUpgrades[8]['message'] = " CBE Beta-1 upgraded for Zodiac Chinese. <br />";

	// sv0.61 update -> status to guestbook table
	$MCBUpgrades[9]['test'] = "SELECT `status` FROM #__cbe_mambome_gbook";
        $MCBUpgrades[9]['updates'][0] = "ALTER TABLE #__cbe_mambome_gbook ADD status TINYINT(1) DEFAULT '0' NOT NULL AFTER `rating`";
        $MCBUpgrades[9]['updates'][1] = "UPDATE #__cbe_mambome_gbook SET status='1' WHERE status='0'";
        $MCBUpgrades[9]['message'] = " CBE Beta-1 upgraded mambome_guestbook for Status field. <br />";

	// sv0.62 update -> ordering to searchmanager table
	$MCBUpgrades[10]['test'] = "SELECT `ordering` FROM #__cbe_searchmanager";
        $MCBUpgrades[10]['updates'][0] = "ALTER TABLE #__cbe_searchmanager ADD ordering INT(11) DEFAULT '0' AFTER `advanced`";
        $MCBUpgrades[10]['message'] = " CBE Beta-1 upgraded Search-Manager Table for Ordering field. <br />";

	// sv0.621 update -> filter-online to usersList table
	$MCBUpgrades[11]['test'] = "SELECT `filteronline` FROM #__cbe_lists";
        $MCBUpgrades[11]['updates'][0] = "ALTER TABLE #__cbe_lists ADD filteronline TINYINT(1) unsigned NOT NULL DEFAULT '0' AFTER `ordering`";
        $MCBUpgrades[11]['message'] = " CBE Beta-1 upgraded usersList Table for OnlineFilter. <br />";

	// sv0.6232 update
	$MCBUpgrades[12]['test'] = "SELECT `information` FROM #__cbe_fields";
	$MCBUpgrades[12]['updates'][0] = "ALTER TABLE `#__cbe_fields` ADD `information` MEDIUMTEXT  NOT NULL default '' AFTER `type` ";
	$MCBUpgrades[12]['updates'][1] = "ALTER TABLE `#__cbe_fields` ADD `infotag` varchar(10) NOT NULL default 'tag' AFTER `information` ";
	$MCBUpgrades[12]['updates'][2] = "ALTER TABLE `#__cbe_fields` CHANGE `title` `title` VARCHAR( 255 ) NOT NULL";
	$MCBUpgrades[12]['message'] = " CBE Beta-1 upgraded information placeholder for fields. <br />";

	$MCBUpgrades[13]['test'] = "SELECT `aclgroups` FROM #__cbe_tabs";
	$MCBUpgrades[13]['updates'][0] = "ALTER TABLE #__cbe_tabs ADD `aclgroups` varchar(255) NULL AFTER `enhanced_params`";
	$MCBUpgrades[13]['message'] = " CBE Beta-1 upgraded Tabs for ACL-Groups. <br />";
	
	// sv0.6233
	$MCBUpgrades[14]['test'] = "SELECT `aclgroup` FROM #__cbe_lists";
	$MCBUpgrades[14]['updates'][0] = "ALTER TABLE `#__cbe_lists` ADD `aclgroup` INT(9) DEFAULT '-2' NOT NULL AFTER `usergroupids` ";
	$MCBUpgrades[14]['message'] = " CBE Beta-1 upgraded usersLists for ACL-Groups. <br />";

	// sv0.6235
	$MCBUpgrades[15]['test'] = "SELECT `nested` FROM #__cbe_tabs";
	$MCBUpgrades[15]['updates'][0] = "ALTER TABLE #__cbe_tabs ADD `nested` TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL AFTER `aclgroups`";
	$MCBUpgrades[15]['message'] = " CBE Beta-1 upgraded Tabs-DB (nested). <br />";

	$MCBUpgrades[16]['test'] = "SELECT `nest_id` FROM #__cbe_tabs";
	$MCBUpgrades[16]['updates'][0] = "ALTER TABLE #__cbe_tabs ADD `nest_id` INT(11) DEFAULT '-1' NOT NULL AFTER `nested`";
	$MCBUpgrades[16]['message'] = " CBE Beta-1 upgraded Tabs-DB (nest_id). <br />";

	$MCBUpgrades[17]['test'] = "SELECT `is_nest` FROM #__cbe_tabs";
	$MCBUpgrades[17]['updates'][0] = "ALTER TABLE #__cbe_tabs ADD `is_nest` TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL AFTER `nest_id`";
	$MCBUpgrades[17]['message'] = " CBE Beta-1 upgraded Tabs-DB (is_nest). <br />";

	$MCBUpgrades[18]['test'] = "SELECT `q_me` FROM #__cbe_tabs";
	$MCBUpgrades[18]['updates'][0] = "ALTER TABLE #__cbe_tabs ADD `q_me` TEXT DEFAULT NULL AFTER `is_nest`";
	$MCBUpgrades[18]['message'] = " CBE Beta-1 upgraded Tabs-DB (q_me). <br />";

	$MCBUpgrades[19]['test'] = "SELECT `q_you` FROM #__cbe_tabs";
	$MCBUpgrades[19]['updates'][0] = "ALTER TABLE #__cbe_tabs ADD `q_you` TEXT DEFAULT NULL AFTER `q_me`";
	$MCBUpgrades[19]['message'] = " CBE Beta-1 upgraded Tabs-DB (q_you). <br />";

	$MCBUpgrades[20]['test'] = "SELECT `q_bind` FROM #__cbe_tabs";
	$MCBUpgrades[20]['updates'][0] = "ALTER TABLE #__cbe_tabs ADD `q_bind` VARCHAR(3) DEFAULT 'AND' NOT NULL AFTER `q_me`";
	$MCBUpgrades[20]['message'] = " CBE Beta-1 upgraded Tabs-DB (q_bind). <br />";

	// sv0.6236 update -> module to searchmanager table
	$MCBUpgrades[21]['test'] = "SELECT `module` FROM #__cbe_searchmanager";
	$MCBUpgrades[21]['updates'][0] = "ALTER TABLE #__cbe_searchmanager ADD module TINYINT(1) DEFAULT '0' NOT NULL AFTER `ordering`";
	$MCBUpgrades[21]['message'] = " CBE Beta-1 upgraded Search-Manager Table for module field. <br />";

	// sv0.6237 update -> changed acceptedterms and accepteddatasec
	$MCBUpgrades[22]['test'] = "SELECT `accepteddatasec` FROM #__cbe";
	$MCBUpgrades[22]['updates'][0] = "ALTER TABLE #__cbe ADD `last_terms_date` datetime NOT NULL default '0000-00-00 00:00:00' AFTER `acceptedterms`,"
	."\n ADD `accepteddatasec` datetime NOT NULL default '0000-00-00 00:00:00' AFTER `last_terms_date`,"
	."\n ADD `last_datasec_date` datetime NOT NULL default '0000-00-00 00:00:00' AFTER `accepteddatasec`";
	$MCBUpgrades[22]['message'] = " CBE Beta-1 upgraded for Datasecurity-Guideline-accept Feature. <br />";

	// sv0.701 update -> add delete_able column
	$MCBUpgrades[23]['test'] = "SELECT `delete_able` FROM #__cbe_fields";
	$MCBUpgrades[23]['updates'][0] = "ALTER TABLE `#__cbe_fields` ADD `delete_able` TINYINT UNSIGNED DEFAULT '1'";
	$MCBUpgrades[23]['updates'][1] = "UPDATE #__cbe_fields SET delete_able = 0 WHERE sys=1";
	$MCBUpgrades[23]['message'] = " CBE Beta-1 upgraded Fieldlist with 'delete_able' flag. <br />";


        //Apply Upgrades
        foreach ($MCBUpgrades AS $MCBUpgrade)
        {
        	$database->setQuery($MCBUpgrade['test']);
        	//if it fails test then apply upgrade
        	if (!$database->query()) {
        		foreach($MCBUpgrade['updates'] as $MCBScript) {
        			$database->setQuery($MCBScript);
        			if(!$database->query()) {
        				//Upgrade failed
        				print("<font color=red>".$MCBUpgrade['message']." failed! SQL error:" . $database->stderr(true)."</font><br />");
        				return;
        			}
        		}
        		//Upgrade was successful
        		print "<font color=green>".$MCBUpgrade['message']." Upgrade Applied Successfully!</font>";
        	}
        }

        //Color field
        $database->setQuery("SELECT `profile_color` FROM #__cbe");
        if (!$database->query())
        {
        	$database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE title='_UE_CONTACT_INFO_HEADER'");
        	$database->query();
        	$tabid=$database->loadResult();
        	$database->setQuery("INSERT INTO #__cbe_fields SET name='profile_color', title='_UE_PROFILE_COLOR', type='select', ordering='1', published='1', profile='0', calculated='0', sys='0', tabid=$tabid");
        	$database->query();
        	$database->setQuery("SELECT fieldid FROM #__cbe_fields WHERE name='profile_color'");
        	$database->query();
        	$fieldid=$database->loadResult();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_RED', ordering='1'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_GREEN', ordering='2'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_BLUE', ordering='3'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_PINK', ordering='4'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_ORANGE', ordering='5'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_YELLOW', ordering='6'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_BLACK', ordering='7'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_LIME', ordering='8'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_FUCHIA', ordering='9'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_NAVY', ordering='10'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_PURPLE', ordering='11'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_MAROON', ordering='12'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_TEAL', ordering='13'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_AQUA', ordering='14'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_OLIVE', ordering='15'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_SILVER', ordering='16'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_GREY', ordering='17'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_WHITE', ordering='18'");
        	$database->query();
        	$database->setQuery("ALTER TABLE #__cbe ADD profile_color varchar(255)");
        	$database->query();
        	//Upgrade was successful
        	print '<font color="green">Color field Applied Successfully!</font><br />';
        }


        //Last-Ip to cbe_fields for showing up in profile edit
        $database->setQuery("SELECT `last_ip` FROM #__cbe");
        if (!$database->query())
        {
        	$database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE title='_UE_CONTACT_INFO_HEADER'");
        	$database->query();
        	$tabid=$database->loadResult();
        	$database->setQuery("INSERT INTO #__cbe_fields SET name='last_ip', title='Last IP', type='text', published='1', profile='0', readonly='1', calculated='0', sys='1', tabid=$tabid");
        	$database->query();
        	$database->setQuery("ALTER TABLE #__cbe ADD last_ip varchar(255) AFTER `lastname`");
        	$database->query();
        	//Upgrade was successful
        	print '<font color="green">Last_IP field Applied Successfully! - code-2</font><br />';

        } else {
        	$database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE title='_UE_CONTACT_INFO_HEADER'");
        	$database->query();
        	$tabid=$database->loadResult();
        	$database->setQuery("SELECT fieldid FROM #__cbe_fields WHERE name='last_ip'");
        	$fieldid = $database->loadResult();
        	if ($fieldid != '') {
        		$database->setQuery("UPDATE #__cbe_fields SET tabid=$tabid WHERE name='last_ip'");
        	} else {
        		$database->setQuery("INSERT INTO #__cbe_fields SET name='last_ip', title='Last IP', type='text', published='1', profile='0', readonly='1', calculated='0', sys='1', tabid=$tabid");
        	}
        	$database->query();
        	//Upgrade was successful
        	print '<font color="green">Last_ip field Applied Successfully! - code-1</font><br />';

	}
		
	$database->setQuery("SELECT count(tabid) FROM #__cbe_tabs WHERE title='_UE_LAST_VISITORS_TAB_LABEL'");
	$tabid=$database->loadResult();
	if ($tabid == 0) {
		$database->setQuery("INSERT INTO `#__cbe_tabs` (`tabid`, `title`, `description`, `ordering`, `width`, `enabled`, `plugin`, `plugin_include`, `fields`, `sys`, `enhanced_params`) VALUES ('', '_UE_LAST_VISITORS_TAB_LABEL', '', '-1', '1', '0', '', NULL, 0, 0,'profile=1\n tabtype=1\n enhancedname=lastvisitors')");
		if (!$database->query()) {
			print '<font color="red">Adding of LastVisitors Tab to tab-table failed.</font><br />';
		} else {
			print '<font color="green">Added LastVisitors Tab to Tab Management</font><br />';
		}
	} else {
		print '<font color="blue">LastVisitors Tab exist in tab management.</font><br />';
	}

//	NEW LastVisitors-Tab DB creation and migration check.
	$queck_check = "SELECT uid FROM #__cbe_lastvisitor LIMIT 1";
	$database->setQuery($queck_check);
	if ( !$database->query() ) {
		$query_update  = "CREATE TABLE IF NOT EXISTS `#__cbe_lastvisitor` (";
		$query_update .= "  `uid` int(11) default '0',";
		$query_update .= "  `visitor` int(11) default '0',";
		$query_update .= "  `vdate` timestamp(14) NOT NULL,";
		$query_update .= "  `visits` INT(11) UNSIGNED default '1'";
		$query_update .= ") TYPE=MyISAM;";
		$database->setQuery($query_update);
		if (!$database->query()) {
			echo ' <font color="red">Creating lastvisitor table failed</font><br>';
		} else {
			echo ' <font color="green">Creating lastvisitor table successfull</font><br>';
		}
	} else {
		echo ' <font color="green">Lastvisitor table exists!</font><br>';
	}
	$query_all = "SELECT user_id, lastusers FROM #__cbe ORDER by user_id ASC";
	$database->setQuery($query_all);
	$all_users = $database->loadObjectList();
	if ($database->query()){
		foreach ($all_users as $all_user) {
			$db_lastusers = $all_user->lastusers;
        	
			if ($db_lastusers !='' || $db_lastusers != NULL) {
				$tmp_array_all = explode("--", $db_lastusers);
				$ID_timestamps = $tmp_array_all[1];
				$userIDs_time = explode(',', $ID_timestamps);
				// $userIDs = $tmp_array_all[0];
				
				foreach ($userIDs_time as $userID_time) {
					$user_time = explode('=', $userID_time);
					$visitor = $user_time[0];
					$vdate = $user_time[1];
					$owner_uid = $all_user->user_id;
					$query_visit = "INSERT INTO #__cbe_lastvisitor (uid, visitor, vdate, visits) VALUES ('".$owner_uid."','".$visitor."',FROM_UNIXTIME(".$vdate.")+0,'1')";
					$database->setQuery($query_visit);
					if (!$database->query()) {
//						echo "DB Update Error<br>";
//						echo "Profile -> ".$owner_uid." -- Visitor -> ".$visitor." -- Date -> ".$vdate."<br>\n";
					}
				}
			}
        	
		}
	} else {
		echo ' <font color="blue">-> no Data to migrate (lastvisitor)</font><br>';
	}
	echo ' <font color="green">-> Migration of lastvisitor successfull</font><br>';

// GroupJiveTab Insert start
	$database->setQuery("SELECT count(tabid) FROM #__cbe_tabs WHERE title='_UE_GROUPJIVE_TAB_LABEL'");
	$tabid=$database->loadResult();
	if ($tabid == 0) {
		$database->setQuery("INSERT INTO `#__cbe_tabs` (`tabid`, `title`, `description`, `ordering`, `width`, `enabled`, `plugin`, `plugin_include`, `fields`, `sys`, `enhanced_params`) VALUES ('', '_UE_GROUPJIVE_TAB_LABEL', '', '-1', '1', '0', '', NULL, 0, 0,'profile=1\n tabtype=1\n enhancedname=groupjive')");
		if (!$database->query()) {
			print '<font color="red">Adding of GroupJive Tab to tab-table failed.</font><br />';
		} else {
			print '<font color="green">Added GroupJive Tab to Tab Management</font><br />';
		}
	} else {
		print '<font color="blue">GroupJive Tab exist in tab management.</font><br />';
	}
// GroupJiveTab Insert start


        //ZODIAC (west) field Values Update
        $database->setQuery("SELECT `zodiac` FROM #__cbe");
        if (!$database->query())
        {
        	$database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE title='_UE_CONTACT_INFO_HEADER'");
        	$database->query();
        	$tabid=$database->loadResult();
        	$database->setQuery("INSERT INTO #__cbe_fields SET name='zodiac', title='_UE_SHOWZODIAC_TITLE', type='select', published='1', profile='0', readonly='1', calculated='0', sys='1', tabid=$tabid");
        	$database->query();
        	$database->setQuery("SELECT fieldid FROM #__cbe_fields WHERE name='zodiac'");
//        	$database->query();
        	$fieldid=$database->loadResult();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_ARIES', ordering='1'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_TAURUS', ordering='2'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_GEMINI', ordering='3'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_CANCER', ordering='4'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_LEO', ordering='5'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_VIRGO', ordering='6'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_LIBRA', ordering='7'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_SCORPIO', ordering='8'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_SAGITTARIUS', ordering='9'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_CAPRICORN', ordering='10'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_AQUARIUS', ordering='11'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_PISCES', ordering='12'");
        	$database->query();
        	$database->setQuery("ALTER TABLE #__cbe ADD zodiac varchar(255) AFTER 'last_ip'");
        	$database->query();
        	//Upgrade was successful
        	print '<font color="green">Zodiac(west) field Applied Successfully! - code-2</font><br />';
        } else {
        	$database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE title='_UE_CONTACT_INFO_HEADER'");
        	$database->query();
        	$tabid=$database->loadResult();
		$database->setQuery("SELECT tabid FROM #__cbe_fields WHERE name='zodiac'");
		$z_ = $database->loadResult();
		if ($z_ != '') {
			$database->setQuery("UPDATE #__cbe_fields SET tabid=$tabid WHERE name='zodiac'");
		} else {
			$database->setQuery("INSERT INTO #__cbe_fields SET name='zodiac', title='_UE_SHOWZODIAC_TITLE', type='select', published='1', profile='0', readonly='1', calculated='0', sys='1', tabid=$tabid");
		}
        	$database->query();
        	$database->setQuery("SELECT fieldid FROM #__cbe_fields WHERE name='zodiac'");
        	$database->query();
        	$fieldid=$database->loadResult();
        	$database->setQuery("SELECT count(fieldid) FROM #__cbe_field_values WHERE fieldid=$fieldid");
        	$fieldcount=$database->loadResult();
        	if ($fieldcount < '12') {
        		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_ARIES', ordering='1'");
        		$database->query();
        		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_TAURUS', ordering='2'");
        		$database->query();
        		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_GEMINI', ordering='3'");
        		$database->query();
        		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_CANCER', ordering='4'");
        		$database->query();
        		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_LEO', ordering='5'");
        		$database->query();
        		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_VIRGO', ordering='6'");
        		$database->query();
        		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_LIBRA', ordering='7'");
        		$database->query();
        		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_SCORPIO', ordering='8'");
        		$database->query();
        		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_SAGITTARIUS', ordering='9'");
        		$database->query();
        		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_CAPRICORN', ordering='10'");
        		$database->query();
        		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_AQUARIUS', ordering='11'");
        		$database->query();
        		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_PISCES', ordering='12'");
        		$database->query();
        	}
        	//Upgrade was successful
        	print '<font color="green">Zodiac(west) field Applied Successfully! - code-1</font><br />';
        }

        //ZODIAC (chinese) field Values Update
        $database->setQuery("SELECT `zodiac_c` FROM #__cbe");
        if (!$database->query())
        {
        	$database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE title='_UE_CONTACT_INFO_HEADER'");
        	$database->query();
        	$tabid=$database->loadResult();
        	$database->setQuery("INSERT INTO #__cbe_fields SET name='zodiac_c', title='_UE_SHOWZODIAC_TITLE_CHINESE', type='select', published='1', profile='0', readonly='1', calculated='0', sys='1', tabid=$tabid");
        	$database->query();
        	$database->setQuery("SELECT fieldid FROM #__cbe_fields WHERE name='zodiac_c'");
  //      	$database->query();
        	$fieldid=$database->loadResult();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_MONKEY', ordering='1'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_ROOSTER', ordering='2'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_DOG', ordering='3'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_PIG', ordering='4'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_RAT', ordering='5'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_OX', ordering='6'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_TIGER', ordering='7'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_RABBIT', ordering='8'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_DRAGON', ordering='9'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_SERPENT', ordering='10'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_HORSE', ordering='11'");
        	$database->query();
        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_GOAT', ordering='12'");
        	$database->query();
        	$database->setQuery("ALTER TABLE #__cbe ADD zodiac varchar(255) AFTER 'last_ip'");
        	$database->query();
        	//Upgrade was successful
        	print '<font color="green">Zodiac(chinese) field Applied Successfully! - code-2</font><br />';
        } else {
        	$database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE title='_UE_CONTACT_INFO_HEADER'");
        	$database->query();
        	$tabid=$database->loadResult();
		$database->setQuery("SELECT tabid FROM #__cbe_fields WHERE name='zodiac_c'");
		$z_ = $database->loadResult();
		if ($z_ != '') {
			$database->setQuery("UPDATE #__cbe_fields SET tabid=$tabid WHERE name='zodiac_c'");
		} else {
			$database->setQuery("INSERT INTO #__cbe_fields SET name='zodiac_c', title='_UE_SHOWZODIAC_TITLE_CHINESE', type='select', published='1', profile='0', readonly='1', calculated='0', sys='1', tabid=$tabid");
		}
        	$database->query();
        	$database->setQuery("SELECT fieldid FROM #__cbe_fields WHERE name='zodiac_c'");
        	$database->query();
        	$fieldid=$database->loadResult();
        	$database->setQuery("SELECT count(fieldid) FROM #__cbe_field_values WHERE fieldid=$fieldid");
        	$fieldcount=$database->loadResult();
        	if ($fieldcount < '12') {
	        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_MONKEY', ordering='1'");
	        	$database->query();
	        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_ROOSTER', ordering='2'");
	        	$database->query();
	        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_DOG', ordering='3'");
	        	$database->query();
	        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_PIG', ordering='4'");
	        	$database->query();
	        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_RAT', ordering='5'");
	        	$database->query();
	        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_OX', ordering='6'");
	        	$database->query();
	        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_TIGER', ordering='7'");
	        	$database->query();
	        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_RABBIT', ordering='8'");
	        	$database->query();
	        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_DRAGON', ordering='9'");
	        	$database->query();
	        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_SERPENT', ordering='10'");
	        	$database->query();
	        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_HORSE', ordering='11'");
	        	$database->query();
	        	$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_GOAT', ordering='12'");
	        	$database->query();
	        }
        	//Upgrade was successful
        	print '<font color="green">Zodiac(chinese) field Applied Successfully! - code-1</font><br />';
        }

	// Check right name on zodiac_C
	$database->setQuery("SELECT title FROM #__cbe_fields WHERE name='zodiac_c'");
	$zodc_title = $database->loadResult();
	if ($zodc_title != "_UE_SHOWZODIAC_TITLE_CHINESE") {
		$database->setQuery("UPDATE #__cbe_fields SET title='_UE_SHOWZODIAC_TITLE_CHINESE' WHERE name='zodiac_c'");
		$database->query();
	}


        $sql="SELECT listid FROM #__cbe_lists ORDER BY published desc";
        $database->setQuery($sql);
        $lists = $database->loadObjectList();
        $order=0;
        foreach($lists AS $list) {
        	$database->setQuery("UPDATE #__cbe_lists SET ordering = $order WHERE listid='".$list->listid."'");
        	$database->query();
        	$order++;
        }

	// Update CBE-Beta1 1/2 sv0.61 to sv0.62 list fix simple filters
        $sql="SELECT listid, filterfields FROM #__cbe_lists ORDER BY listid ASC";
        $database->setQuery($sql);
        $lists = $database->loadObjectList();
	foreach($lists AS $list) {
		$filtertype = substr($list->filterfields,0,1);
		if ($filtertype == "s") {
			$filtervalue = "s(".substr($list->filterfields,1).")";
			$database->setQuery("UPDATE #_cbe_lists SET filterfields='".$filtervalue."' WHERE listid='".$list->listid."'");
			$database->query();
		}
	}

	// Update CBE-Beta1 1/2 sv0.61 to sv0.62 search-manager
        $sql="SELECT id FROM #__cbe_searchmanager ORDER BY id ASC";
        $database->setQuery($sql);
        $entries = $database->loadObjectList();
        $order=0;
        foreach($entries AS $entry) {
        	$database->setQuery("UPDATE #__cbe_searchmanager SET ordering = $order WHERE id='".$entry->id."'");
        	$database->query();
        	$order++;
        }

	// sv0.6232 reasign fields.
	$tabid ="3"; //leave as default
	$database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE title='_UE_CONTACT_INFO_HEADER'");
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$tabid=$database->loadResult();
	$tabs = $database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE `fields`=1 ORDER BY ordering");
	$tabs = $database->loadResultArray();
	$database->setQuery("SELECT fieldid, title, tabid FROM #__cbe_fields WHERE tabid IS NOT NULL");
	$fields = $database->loadObjectList();
	$i=0;
	foreach ($fields as $field) {
		if (!in_array($field->tabid, $tabs)) {
		//	echo "Found <b>".$field->title."</b> not at an existing tab<br>";
			$database->setQuery("UPDATE #__cbe_fields SET tabid='".$tabid."' WHERE fieldid='".$field->fieldid."'");
			if (!$database->query()) {
		//		echo "<font color=red> -> Could not reasign field.</font><br>";
			} else {
		//		echo "<font color=green> -> Field reasigned to Contact-Info Tab.</font><br>";
			}
			$i++;
		}
	}
	echo "<br> ".$i." fields found for reasignment and proceeded.<br>";

	$queck_check = "SELECT id FROM #__cbe_bad_usernames LIMIT 1";
	$database->setQuery($queck_check);
	if ( !$database->query() ) {
		$query_update  = "CREATE TABLE IF NOT EXISTS `#__cbe_bad_usernames` (";
		$query_update .= "  `id` INT NOT NULL AUTO_INCREMENT,";
		$query_update .= "  `badname` varchar(30) NOT NULL,";
		$query_update .= "  `published` TINYINT(1) NOT NULL,";
		$query_update .= "  PRIMARY KEY (`id`)";
		$query_update .= ") TYPE=MyISAM AUTO_INCREMENT=19 ";
		$database->setQuery($query_update);
		if (!$database->query()) {
			echo ' <font color="red">Creating bad_usernames table failed</font><br>';
		} else {
			echo ' <font color="green">Creating bad_usernames table successfull</font><br>';
		}
	} else {
		echo ' <font color="green">Bad_Usernames table exists! No Changes needed.</font><br>';
	}
// userstime
	$queck_check = "SELECT id FROM #__cbe_userstime LIMIT 1";
	$database->setQuery($queck_check);
	if ( !$database->query() ) {
		$query_update  = "CREATE TABLE IF NOT EXISTS `#__cbe_userstime` (";
		$query_update .= "  `id` INT NOT NULL AUTO_INCREMENT,";
		$query_update .= "  `userid` INT(11) NOT NULL default '0',";
		$query_update .= "  `logcount` INT(14) NOT NULL default '0',";
		$query_update .= "  `logtime` BIGINT NOT NULL default '0',";
		$query_update .= "  `logtimesum` BIGINT NOT NULL default '0',";
		$query_update .= "  PRIMARY KEY (`id`)";
		$query_update .= ") TYPE=MyISAM AUTO_INCREMENT=1 ";
		$database->setQuery($query_update);
		if (!$database->query()) {
			echo ' <font color="red">Creating usersTime table failed</font><br>';
		} else {
			echo ' <font color="green">Creating usersTime table successfull</font><br>';
		}
	} else {
		echo ' <font color="green">usersTime table exists! No changes needed.</font><br>';
	}

// nested enhanced_params to own field.
	$database->setQuery("SELECT tabid, enhanced_params FROM #__cbe_tabs WHERE enhanced_params LIKE '%nested=1%' ORDER by tabid ASC");
	$tab_datas = $database->loadObjectList();
	if($database->query()) {
		foreach ($tab_datas as $tab_data) {
			$tab_data->enhanced_params = strtolower($tab_data->enhanced_params);
			$new_params = str_replace('nested=1', '', $tab_data->enhanced_params);
			$upd_tab = "UPDATE #__cbe_tabs SET enhanced_params ='".$new_params."', nested=1 WHERE tabid=".$tab_data->tabid;
			$database->setQuery($upd_tab);
			if (!$database->query()) {
				echo ' <font color="red">Converting Tab-'.$tab_data->tabid.'-enhanced-params failed. Step-2.</font><br>';
			}
		}
		echo ' <font color="black">Converting Tab-enhanced-params finisched.</font><br>';
	} else {
		echo ' <font color="red">Converting Tab-enhanced-params failed. Step-1.</font><br>';
	}
	$database->setQuery("SELECT tabid, enhanced_params FROM #__cbe_tabs WHERE enhanced_params LIKE '%nested=0%' ORDER by tabid ASC");
	$tab_datas = $database->loadObjectList();
	if($database->query()) {
		foreach ($tab_datas as $tab_data) {
			$tab_data->enhanced_params = strtolower($tab_data->enhanced_params);
			$new_params = str_replace('nested=0', '', $tab_data->enhanced_params);
			$upd_tab = "UPDATE #__cbe_tabs SET enhanced_params ='".$new_params."', nested=0 WHERE tabid=".$tab_data->tabid;
			$database->setQuery($upd_tab);
			if (!$database->query()) {
				// echo ' <font color="red">Converting Tab-'.$tab_data->tabid.'-enhanced-params failed. Step-2.</font><br>';
			}
		}
		// echo ' <font color="black">Converting Tab-enhanced-params finisched.</font><br>';
	} else {
		//echo ' <font color="red">Converting Tab-enhanced-params failed. Step-1.</font><br>';
	}

// add usertype to userlist selectable fields
	$database->setQuery("SELECT name FROM #__cbe_fields WHERE name='usertype' AND type='predefined' LIMIT 1");
	$utype_name = $database->loadResult();
	if ($utype_name != 'usertype') {
		$utype_query = "INSERT IGNORE INTO `#__cbe_fields` (`fieldid`, `name`, `table`, `title`, `type`, `maxlength`, `size`, `required`, `tabid`, `ordering`, `cols`, `rows`, `value`, `default`, `published`, `registration`, `profile`, `readonly`, `calculated`, `sys`)";
		$utype_query .= " VALUES ('', 'usertype', '#__users', '_UE_CBE_UM_USERGROUP', 'predefined', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 1, 1)";
		$database->setQuery($utype_query);
		if (!$database->query()) {
			echo ' <font color="red">Adding usertype to selectable fieldlist failed. Code-1.</font><br>';
		} else {
			echo ' <font color="black">Adding usertype to selectable fieldlist in userlists -> Done.</font><br>';
		}
	}

// Zoom-MP3-Tab Insert start
	$database->setQuery("SELECT count(tabid) FROM #__cbe_tabs WHERE title='_UE_ZOOM_MP3_PHOTOS_TAB_LABEL'");
	$tabid=$database->loadResult();
	if ($tabid == 0) {
		$database->setQuery("INSERT INTO `#__cbe_tabs` (`tabid`, `title`, `description`, `ordering`, `width`, `enabled`, `plugin`, `plugin_include`, `fields`, `sys`, `enhanced_params`) VALUES ('', '_UE_ZOOM_MP3_PHOTOS_TAB_LABEL', '', '-1', '1', '0', '', NULL, 0, 0,'profile=1\n tabtype=1\n enhancedname=zoom_mp3')");
		if (!$database->query()) {
			print '<font color="red">Adding of Zoom-MP3 Tab to tab-table failed.</font><br />';
		} else {
			print '<font color="green">Added Zoom-MP3 Tab to Tab Management</font><br />';
		}
	} else {
		print '<font color="blue">Zoom-MP3 Tab exist in tab management.</font><br />';
	}

// geodata Table (sv0.6237)
	$database->setQuery("SELECT count(tabid) FROM #__cbe_tabs WHERE title='_UE_CBE_GEOCODER_EDIT_LABEL'");
	$tabid=$database->loadResult();
	if ($tabid == 0) {
		$database->setQuery("INSERT INTO `#__cbe_tabs` (`tabid`, `title`, `description`, `ordering`, `width`, `enabled`, `plugin`, `plugin_include`, `fields`, `sys`, `enhanced_params`, `aclgroups`, `nested`, `nest_id`, `is_nest`, `q_me`, `q_you`, `q_bind`) VALUES('', '_UE_CBE_GEOCODER_EDIT_LABEL', 'GeoCoderEdit Tab', '30', '.5', '1', 'getGeoCoderEdit', NULL, '1', '1', '', '-2', '0', '-1', '0', '', '', 'AND')");
 		if (!$database->query()) {
			print '<font color="red">Adding of GeoCoderEdit Tab to tab-table failed.</font><br />';
		} else {
			print '<font color="green">Added GeoCoderEdit Tab to Tab Management</font><br />';
		}
	} else {
		print '<font color="blue">GeoCoderEdit Tab exist in tab management.</font><br />';
	}

	$queck_check = "SELECT id FROM #__cbe_geodata LIMIT 1";
	$database->setQuery($queck_check);
	if ( !$database->query() ) {
		$query_update  = "CREATE TABLE IF NOT EXISTS `#__cbe_geodata` (";
		$query_update .= "  `id` INT(11) NOT NULL AUTO_INCREMENT,";
		$query_update .= "  `uid` INT(11) NOT NULL default '0',";
		$query_update .= "  `GeoLat` DECIMAL(20,15),";
		$query_update .= "  `GeoLng` DECIMAL(20,15),";
		$query_update .= "  `GeoAddr` TEXT,";
		$query_update .= "  `Geo_street` VARCHAR (255),";
		$query_update .= "  `Geo_postcode` VARCHAR (255),";
		$query_update .= "  `Geo_city` VARCHAR (255),";
		$query_update .= "  `Geo_state` VARCHAR (255),";
		$query_update .= "  `Geo_country` VARCHAR (255),";
		$query_update .= "  `GeoText` TEXT,";
		$query_update .= "  `GeoAccCode` TINYINT(1) NOT NULL default '0',";
		$query_update .= "  `GeoAllowShow` TINYINT(1) NOT NULL default '0',";
		$query_update .= "  PRIMARY KEY (`id`)";
		$query_update .= ") TYPE=MyISAM AUTO_INCREMENT=1 ";
		$database->setQuery($query_update);
		if (!$database->query()) {
			echo ' <font color="red">Creating CBE GeoData table failed</font><br>';
		} else {
			echo ' <font color="green">Creating CBE GeoData table successfull</font><br>';
		}
	} else {
		echo ' <font color="green">CBE GeoData table exists! No changes needed.</font><br>';
	}

// cbsearch-Session Table (sv0.6237)
	$queck_check = "SELECT id FROM #__cbe_cbsearch_ses LIMIT 1";
	$database->setQuery($queck_check);
	if ( !$database->query() ) {
		$query_update  = "CREATE TABLE IF NOT EXISTS `#__cbe_cbsearch_ses` (";
		$query_update .= "  `id` INT (11) UNSIGNED NOT NULL AUTO_INCREMENT,";
		$query_update .= "  `uid` INT(11) NOT NULL default '0',";
		$query_update .= "  `mod_cbe_search` VARCHAR (200) DEFAULT '0',";
		$query_update .= "  `mod_cbe_search1` VARCHAR (200) DEFAULT '0',";
		$query_update .= "  `listid` INT (11) UNSIGNED DEFAULT '0',";
		$query_update .= "  `do_cbquery` TINYINT (1) UNSIGNED DEFAULT '0',";
		$query_update .= "  `cbquery` MEDIUMTEXT,";
		$query_update .= "  `geo_distance` INT (6) UNSIGNED DEFAULT '0',";
		$query_update .= "  `geo_map` TINYINT (1) UNSIGNED DEFAULT '0',";
		$query_update .= "  `onlinenow` TINYINT (1) UNSIGNED DEFAULT '0',";
		$query_update .= "  `picture` TINYINT (1) UNSIGNED DEFAULT '0',";
		$query_update .= "  `added10` TINYINT (1) UNSIGNED DEFAULT '0',";
		$query_update .= "  `online10` TINYINT (1) UNSIGNED DEFAULT '0',";
		$query_update .= "  `q_time` BIGINT DEFAULT '0',";
		$query_update .= "  UNIQUE(`id`), PRIMARY KEY (`id`)";
		$query_update .= ") TYPE=MyISAM AUTO_INCREMENT=1 ";
		$database->setQuery($query_update);
		if (!$database->query()) {
			echo ' <font color="red">Creating CBE CBsearch session table failed</font><br>';
		} else {
			echo ' <font color="green">Creating CBE CBsearch session table successfull</font><br>';
		}
	} else {
		echo ' <font color="green">CBE CBsearch session table exists! No changes needed.</font><br>';
	}

// insert MSG-Bot for CBE and PMS-OSenhanced 2.x
	$msg_bot_query = "SELECT id, username, usertype from #__users WHERE id='1' OR usertype='CBE-MSG-BOT'";
	$database->setQuery($msg_bot_query);
	$database->loadObject($msg_bot_user);
	if ( $database->query() ) {
		if (empty($msg_bot_user->id)) {
			$database->setQuery("SELECT id FROM #__users WHERE id='1' LIMIT 1");
			$bot_id_chk = $database->loadResult();
			if (empty($bot_id_chk)) {
				$database->setQuery("INSERT INTO #__users (id,name,username,usertype,block,gid) VALUES ('1','MSG-Bot','MSG-Bot','CBE-MSG-BOT','1','1')");
				if (!$database->query()) {
					echo ' <font color="red">Creating CBE-MSG-Bot failed - Code 1</font><br>';
				} else {
					echo ' <font color="green">Creating CBE-MSG-Bot successfull - Code 1</font><br>';
				}
			} else {
				$database->setQuery("INSERT INTO #__users (name,username,usertype,block,gid) VALUES ('MSG-Bot','MSG-Bot','CBE-MSG-BOT','1','1')");
				if (!$database->query()) {
					echo ' <font color="red">Creating CBE-MSG-Bot failed - Code 2</font><br>';
				} else {
					echo ' <font color="green">Creating CBE-MSG-Bot successfull - Code 2</font><br>';
				}
			}
		} else {
			echo ' <font color="green">Existing CBE-MSG-Bot found. Ok. - Code 1</font><br>';
		}
	} else {
		echo ' <font color="red">PreChecing for CBE-MSG-Bot User failed</font><br>';
	}

// sv0.7.01 update -> Distance to userlists
	$database->setQuery("SELECT type FROM #__cbe_fields WHERE type='geo_calc_dist'");
	$ck_distfield=$database->loadResult();
	if ($ck_distfield != 'geo_calc_dist') {
		$dist_query = "INSERT IGNORE INTO `#__cbe_fields` (`fieldid`, `name`, `table`, `title`, `type`, `maxlength`, `size`, `required`, `tabid`, `ordering`, `cols`, `rows`, `value`, `default`, `published`, `registration`, `profile`, `readonly`, `calculated`, `sys`)";
		$dist_query .= " VALUES('', 'cbe_geodistance', '#__cbe_geodata', '_UE_CBE_GEOCODER_F_DISTANCE', 'geo_calc_dist', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, 1)";
		$database->setQuery($dist_query);
 		if (!$database->query()) {
			print '<font color="red">Adding of Distance Field to UserLists-Mgmt failed.</font><br />';
		} else {
			print '<font color="green">Added Distance Field to Userlists-Mgmt</font><br />';
		}
	} else {
		print '<font color="blue">Distance Field exist in Userlists Management.</font><br />';
	}

// sv0.7.01 update -> Age in Userlists
	$database->setQuery("SELECT type FROM #__cbe_fields WHERE type='cbe_calced_age'");
	$ck_distfield=$database->loadResult();
	if ($ck_distfield != 'cbe_calced_age') {
		$dist_query = "INSERT IGNORE INTO `#__cbe_fields` (`fieldid`, `name`, `table`, `title`, `type`, `maxlength`, `size`, `required`, `tabid`, `ordering`, `cols`, `rows`, `value`, `default`, `published`, `registration`, `profile`, `readonly`, `calculated`, `sys`)";
		$dist_query .= " VALUES('', 'cbe_calced_age', '#__cbe', '_UE_CBE_CALCED_AGE', 'cbe_calced_age', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, 1)";
		$database->setQuery($dist_query);
 		if (!$database->query()) {
			print '<font color="red">Adding of AgeDisplay to UserLists-Mgmt failed.</font><br />';
		} else {
			print '<font color="green">Added AgeDisplay to Userlists-Mgmt</font><br />';
		}
	} else {
		print '<font color="blue">AgeDisplay exist in Userlists Management.</font><br />';
	}

// sv0.7.01 update -> FireBoard Forum Tab
	$database->setQuery("SELECT count(tabid) FROM #__cbe_tabs WHERE title='_UE_FB_TABTITLE'");
	$ck_fbtab=$database->loadResult();
	if ($ck_fbtab == 0) {

		// hinzugefügt von joomla-cbe.de, ANFANG FB
		$cols = $database->getTableFields(array('#__cbe_fields'));
		$isCB12 = isset($cols['#__cbe_fields']['tablecolumns']);

		$database->setQuery("INSERT INTO #__cbe_fields (name,".($isCB12?"tablecolumns,":"")."title,type,maxlength,cols,rows,ordering,published,profile,calculated,sys,tabid) VALUES ".
			"('fbviewtype',".($isCB12?"'fbviewtype',":"")."'_UE_FB_VIEWTYPE_TITLE','select',0,0,0,1,1,0,0,0,$tabid),".
			"('fbordering',".($isCB12?"'fbordering',":"")."'_UE_FB_ORDERING_TITLE','select',0,0,0,2,1,0,0,0,$tabid),".
			"('fbsignature',".($isCB12?"'fbsignature',":"")."'_UE_FB_SIGNATURE','textarea',300,60,5,3,1,0,0,0,$tabid)");
		$database->query();// or echo "Unable to insert comprofiler fields.";

		$database->setQuery("SELECT name,fieldid FROM #__cbe_fields WHERE name IN ('fbviewtype','fbordering')");
		$database->query();// or echo "Unable to load cbe fields.";
		$fieldid = $database->loadObjectList('name');

		$database->setQuery("INSERT INTO #__cbe_field_values (fieldid,fieldtitle,ordering) VALUES ".
			"(".$fieldid['fbviewtype']->fieldid.",'_UE_FB_VIEWTYPE_FLAT',1),".
			"(".$fieldid['fbviewtype']->fieldid.",'_UE_FB_VIEWTYPE_THREADED',2),".
			"(".$fieldid['fbordering']->fieldid.",'_UE_FB_ORDERING_OLDEST',1),".
			"(".$fieldid['fbordering']->fieldid.",'_UE_FB_ORDERING_LATEST',2)");
		$database->query();// or echo "Unable to insert cbe field values.";

		$database->setQuery("ALTER TABLE #__cbe ".
			"ADD fbviewtype varchar(255) DEFAULT '_UE_FB_VIEWTYPE_FLAT' NOT NULL, ".
				"ADD fbordering varchar(255) DEFAULT '_UE_FB_ORDERING_OLDEST' NOT NULL, ".
				"ADD fbsignature mediumtext");
		$database->query();// or echo "Unable to add signature column.";
		// hinzugefügt von joomla-cbe.de, ENDE
	} else {
		print '<font color="blue">FireBoard Tab exists already in Tab-Management.</font><br />';
	}
//end..
        ?>

      </td>
    </tr>
    <tr>
	<td>
	<?php
	if(is_writable(JPATH_SITE . "/images/")) {
		require_once(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');
		$galleryFiles = display_avatar_gallery(JPATH_SITE.DS.'components'.DS.'com_cbe'.DS.'images'.DS.'gallery');
		if(!file_exists(JPATH_SITE . "/images/cbe/")){
			if(mkdir(JPATH_SITE . "/images/cbe/")) {
				print "<font color=green>".JPATH_SITE . "/images/cbe/ Successfully added!</font><br />";
			} else {
				print "<font color=red>".JPATH_SITE . "/images/cbe/ Failed to be to be created, please do so manually!</font><br />";
			}
		}  else {
			print "<font color=green>".JPATH_SITE . "/images/cbe/ already exists!</font><br />";
		}
		if(!file_exists(JPATH_SITE . "/images/cbe/gallery/")) {
			if(mkdir(JPATH_SITE . "/images/cbe/gallery/")) {
				print "<font color=green>".JPATH_SITE . "/images/cbe/gallery/ Successfully added!</font><br />";
			} else {
				print "<font color=red>".JPATH_SITE . "/images/cbe/gallery/ Failed to be to be created, please do so manually!</font><br />";
			}
		}  else {
			print "<font color=green>".JPATH_SITE . "/images/cbe/gallery/ already exists!</font><br />";
		}
		if(!is_writable(JPATH_SITE . "/images/cbe/")){
			if(!chmod(JPATH_SITE . "/images/cbe/", 0777)) {
				print "<font color=red>".JPATH_SITE . "/images/cbe/ Failed to be chmod'd to 777 please do so manually!</font><br />";
			}
		}
		if(!is_writable(JPATH_SITE . "/images/cbe/gallery/")){
			if(!chmod(JPATH_SITE . "/images/cbe/gallery/", 0777)) {
				print "<font color=red>".JPATH_SITE . "/images/cbe/gallery/ Failed to be chmod'd to 777 please do so manually!</font><br />";
			}
		}
		foreach($galleryFiles AS $galleryFile) {
			IF(copy(JPATH_SITE . "/components/com_cbe/images/gallery/".$galleryFile,JPATH_SITE . "/images/cbe/gallery/".$galleryFile)) {
				print "<font color=green>".$galleryFile." Successfully added to the gallery!</font><br />";

			} ELSE {
				print "<font color=red>".$galleryFile." Failed to be added to the gallery please do so manually!</font><br />";
			}
		}
		//sv0.6233
		$wmark_files = array("no_watermark.png","watermark_cbe.png");
		if(!file_exists(JPATH_SITE . "/images/cbe/watermark/")){
			if(mkdir(JPATH_SITE . "/images/cbe/watermark/")) {
				print "<font color=green>".JPATH_SITE . "/images/cbe/watermark/ Successfully added!</font><br />";
			} else {
				print "<font color=red>".JPATH_SITE . "/images/cbe/watermark/ Failed to be to be created, please do so manually!</font><br />";
			}
		}  else {
			print "<font color=green>".JPATH_SITE . "/images/cbe/watermark/ already exists!</font><br />";
		}
		if(!is_writable(JPATH_SITE . "/images/cbe/watermark/")){
			if(!chmod(JPATH_SITE . "/images/cbe/watermark/", 0777)) {
				print "<font color=red>".JPATH_SITE . "/images/cbe/watermark Failed to be chmod'd to 777 please do so manually!</font><br />";
			}
		}
		foreach($wmark_files AS $wmark_file) {
			IF(copy(JPATH_SITE . "/components/com_cbe/images/watermark/".$wmark_file,JPATH_SITE . "/images/cbe/watermark/".$wmark_file)) {
				print "<font color=green>".$wmark_file." Successfully added to watermark-dir!</font><br />";

			} ELSE {
				print "<font color=red>".$wmark_file." Failed to be added to watermark-dir please do so manually!</font><br />";
			}
		}
		//
	} else {
		print "<font color=red>".JPATH_SITE . "/images/ is not writable!<br />  Manually do the following:<br /> 1.) create ".JPATH_SITE . "/images/cbe/ directory <br /> 2.) chmod it to 777 <br /> 3.) create ".JPATH_SITE . "/images/cbe/gallery/ <br /> 4.) chmod it to 777 <br />5.) copy ".JPATH_SITE . "/components/com_cbe/images/gallery/ and its contents to ".JPATH_SITE . "/images/gallery/  </font><br />";
	}

	cbe_plugins_install();

	$CBE_xml = JPATH_SITE.'/administrator/components/com_cbe/cbe.xml';
	if (file_exists($CBE_xml)) {
		
		$xmlDoc =& new DOMIT_Lite_Document();
		$xmlDoc->resolveErrors( true );
		if (!$xmlDoc->loadXML( $CBE_xml, false, true )) {
			$CBE_version = "error";
		} else {
			$element = &$xmlDoc->documentElement;
			$element = &$xmlDoc->getElementsByPath('version', 1);
			$CBE_version = $element ? $element->getText() : '';
		}
	} else {
		$CBE_version = "error reading cbe.xml";
	}

	?>
        <font color="green"><b>Installation finished.</b></font><br/>
        <font color="green"><b><?php echo $CBE_version; ?> installed.</b></font></code>
      </td>
    </tr>
  </table>
</div>
  </center>
  <?php
}

function get_cbe_packages($plugins_path) {
	$dir = @opendir($plugins_path);
	$packages = array();
	while( $file = @readdir($dir) ) {
		if( $file != '.' && $file != '..' && is_file($plugins_path . '/' . $file) && !is_link($plugins_path. '/' . $file) ) {
			$packages[] = $file;
		}
	}

	@closedir($dir);

	return $packages;
}

function cbe_plugins_install() {
	error_reporting(E_ALL);
	jimport('joomla.installer.helper');
	jimport('joomla.installer.installer');
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'CBEPluginInstaller.php');
		
	$package_dir	= JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'plugins'.DS;
	$packages	= get_cbe_packages($package_dir);
		
	foreach ($packages as $package) {
		$installerhelper = new JInstallerHelper();
		$tpackage	= $installerhelper->unpack($package_dir.$package);

		// Get an installer instance
		$installer = new JInstaller();//::getInstance();

		$cbe_ext_type = $tpackage['type'];
		$cbeInstaller = new CBEPluginInstaller($installer, $cbe_ext_type);

		/* Fix for a small bug on Joomla on PHP 4 */
		if (version_compare(PHP_VERSION, '5.0.0', '<')) {
			// We use eval to avoid PHP warnings on PHP>=5 versions
			eval("\$installer->setAdapter('".$cbe_ext_type."',&\$cbeInstaller);");
		}else {
			$installer->setAdapter($cbe_ext_type,$cbeInstaller);
		}
		$cbeInstaller->parent = &$installer;
		$install->_adapters[$cbe_ext_type] = &$cbeXinstaller;
		/* End of the fix for PHP <= 4 */

		if (!$installer->install($tpackage['dir']))
			print "<font color=red>Plugin ".basename($tpackage['packagefile'])." couldn't be installed (" . $cbeInstaller->getError() . ")</font><br />";
		else
			print "<font color=green>Plugin ".basename($tpackage['packagefile'])." installed successfully</font><br />";
				
	}
}

?>