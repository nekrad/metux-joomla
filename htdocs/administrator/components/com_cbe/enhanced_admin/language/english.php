<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

//********************************************
// CBE-Beta1-1/2 Tools Language File -English*
// Copyright (c) 2005 Philipp Kolloczek      *
// Released under the GNU/GPL License        *
// Version 1.0                               *
// File date: 11-06-2006                     *
//********************************************

//Tools Menu Language
DEFINE('_UE_TOOLS_MANAGER','Tools Manager');
DEFINE('_UE_TOOLS_SAMPLEDATA','Load Sample Data');
DEFINE('_UE_TOOLS_SAMPLEDATA_DESC','This will load sample data into the Mambo Community Builder component.');
DEFINE('_UE_TOOLS_SYNCUSERS','Syncronize Users');
DEFINE('_UE_TOOLS_SYNCUSERS_DESC','This will syncronize the Mambo User table with the Mambo Community Builder User Table.');
DEFINE('_UE_TOOLS_SYNCUSERS_JOOMLA_SHOW','Show lost CBE-Users');
DEFINE('_UE_TOOLS_SYNCUSERS_JOOMLA_SHOW_DESC','Shows a list of CBE-users with no correspondend in Joomla User-table.');
DEFINE('_UE_TOOLS_SYNCUSERS_JOOMLA','ReConnect Lost-Users');
DEFINE('_UE_TOOLS_SYNCUSERS_JOOMLA_DESC','Recreates lost CBE-Users into Joomla User-table for easy delation by CBE-UserManager User will be named LOST-- followed by a number.');
DEFINE('_UE_TOOLS_SYNCSEARCHTABLE','Synchronize Search Table');
DEFINE('_UE_TOOLS_SYNCSEARCHTABLE_DESC','This will synchronize the Community Builder Search Manager Table with the Community Builder Profile Fields Table.');
DEFINE('_UE_TOOLS_REASIGNFIELDS','Reasign Fields to Tab');
DEFINE('_UE_TOOLS_REASIGNFIELDS_DEC','This will reasign selfmade fields to an existing tab in case they got lost. All related fields will be asigned to the contact-info tab.');
DEFINE('_UE_TOOLS_LOADCOUNTRIES','Load Countries');
DEFINE('_UE_TOOLS_LOADCOUNTRIES_DESC','This will add a dropdown list of Countries to your CB Field Manager.');
DEFINE('_UE_TOOLS_LOADUSSTATES','Load US States');
DEFINE('_UE_TOOLS_LOADUSSTATES_DESC','This will add a dropdown list of US States to your CB Field Manager.');
DEFINE('_UE_TOOLS_LOADSIMPLEBOARD','Load Simpleboard Forum Fields');
DEFINE('_UE_TOOLS_LOADSIMPLEBOARD_DESC','This will add Simpleboard Forum setting to your database. Use this if you have deleted them, or do not have them yet.');
DEFINE('_UE_TOOLS_LOADPROFILE_COLOR','Load Profile Color Selection Fields');
DEFINE('_UE_TOOLS_LOADPROFILE_COLOR_DESC','This will add Profile Colors field to your database. Use this if you have deleted them, or do not have them yet.');
DEFINE('_UE_TOOLS_LOADGERMANSTATES','Load German Federal States');
DEFINE('_UE_TOOLS_LOADGERMANSTATES_DESC','This will load a List of the German Federal States and add the data field de_states.');
DEFINE('_UE_TOOLS_CLEANLVTAB','Clean up LastVisitors tab database Table');
DEFINE('_UE_TOOLS_CLEANLVTAB_DESC','This will clean up the database table used by LastVisitorsTab and erase all data for all users.');
DEFINE('_UE_TOOLS_CREATETOPVOTE','Create TopVoteList fields');
DEFINE('_UE_TOOLS_CREATETOPVOTE_DESC','This will set up the fields votecount and voteresult.');
DEFINE('_UE_TOOLS_CREATEZODIACS','Create Zodiac fields');
DEFINE('_UE_TOOLS_CREATEZODIACS_DESC','This will set up the fields for western and chinese Zodiac Signs.<br>
		It will create the fields, alter the table and insert values.<br>
		No values are inserted if you have added the fields to cbe_fields by hand.');
DEFINE('_UE_TOOLS_UNPUBLISHZODIACS','(Un)Publish Zodiac fields');
DEFINE('_UE_TOOLS_UNPUBLISHZODIACS_DESC','This will publish or unpublish both Zodiac Signs data fields.<br>
		If unpublished the drop-down selectors are not shown on profile edit.<br>
		This way is choosen to prevent deletion of the fields by mistake if they were<br>
		shown in normal field management.<br>');
DEFINE('_UE_TOOLS_PREPARELVTAB','Prepare new LastVisitor Tab');
DEFINE('_UE_TOOLS_PREPARELVTAB_DESC','This will prepare CBE-Beta1-1/2 for the use with the new LastVisitors Tab.<br>
		It will check for the new database table, create it if nessecary and<br>
		migrate data from the lastusers field.<br>');
DEFINE('_UE_TOOLS_DOWATERMARKALL','Print Watermark to all avatars');
DEFINE('_UE_TOOLS_DOWATERMARKALL_DESC','This will print the watermark to all avatar images located under /images/cbe/.<br>');
DEFINE('_UE_TOOLS_GEOCODER_GENXML','Generate XML file for UserMap');
DEFINE('_UE_TOOLS_GEOCODER_GENXML_DESC','Use this to generate the XML file cbe_usermap.xml.php for the CBE usermap. This file will hold the geocoordinates of the user and must be writeable by the webserver.');
DEFINE('_UE_TOOLS_CBE_GALLERY','prepare CBE-Gallery');
DEFINE('_UE_TOOLS_CBE_GALLERY_DESC','Creates database tables and tab for use with CBE-Gallery (>1.3, by ejjoman).');
DEFINE('_UE_TOOLS_CBE_GALLERY_ADM','Insert Config Module (Backend)');
DEFINE('_UE_TOOLS_CBE_GALLERY_ADM_DESC','Inserts Config-Module to CBE Control-Panel. Gives CBE-Gallery (>1.3, by ejjoman) a own Backend-Config.');
DEFINE('_UE_TOOLS_CBE_BACKUPDB','Create Backup DB');
DEFINE('_UE_TOOLS_CBE_BACKUPDB_DESC','Creates the database tables for backup of the configuration files.<br>Has only to be done once after updating to beta 1.7. (>beta1.6, by derelvis)');
DEFINE('_UE_TOOLS_CBE_BACKUP','BACKUP');
DEFINE('_UE_TOOLS_CBE_RESTORE','RESTORE');
DEFINE('_UE_TOOLS_CBE_BACKUPRESTORE_DESC','You can backup your <strong>Configuration</strong> to the database and restore it when necessary.<br>This is useful when you update the CBE or when you want to save a certain configuration because of testing. (>beta1.6, by derelvis)');
DEFINE('_UE_BACKUPRESTORE_DATE','Configuration found in database: ');
DEFINE('_UE_TOOLS_CBE_BACKUPRESTOREENH_DESC','You can backup your <strong>Enhanced Configuration</strong> to the database and restore it when necessary.<br>This is useful when you update the CBE or when you want to save a certain configuration because of testing. (>beta1.6, by derelvis)');
//DEFINE('_UE_TOOLS_','');
?>