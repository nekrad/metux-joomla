<?php
#
# mysql's sucha fraggin crap - it doesnt understand the simplest things
# where clauses in insert into ... select ... statements.
#
# ... mindless jerks who'll be the first against the wall when the 
# revolution comes ;-o
#

function _setting($ctx, $name, $tab, $seq, $prompt, $value, $description, $type)
{
	$ctx->dbo->setQuery("SELECT id FROM `#__jpfchat` WHERE name = '$name'");
	if (!($id = $ctx->dbo->loadResult()))
	{
	    $query = "
	    INSERT INTO `#__jpfchat` ( 
		`name` ,`tab` ,`seq` , `prompt` ,`value` , `description`,`type` )
		SELECT '$name',$tab,$seq,'$prompt','$value','$description','$type';
	    ";

	    $ctx->queryExec($query);
	}
}

function joomla_component_install($context)
{
	$context->setPkg('com_jpfchat');
	$context->addComponent(
	    'com_jpfchat', 
	    'jPFChat', 
	    '../administrator/components/com_jpfchat/images/jpfchat_menu.png');
	$context->message('Done');

	$context->queryExec("
CREATE TABLE IF NOT EXISTS `#__jpfchat` 
(
        `id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
	`name` VARCHAR( 30 ) NOT NULL ,
	`tab` int(5) NOT NULL,
	`seq` int(5) NOT NULL,
        `prompt` VARCHAR( 30 ) NOT NULL ,
	`value` VARCHAR( 100 ) NOT NULL ,
	`description` VARCHAR( 200 ) NOT NULL ,
	`type` VARCHAR( 5 ) NOT NULL ,
	PRIMARY KEY ( `id` ) 
) 
	");

	_setting($context, 'serverid',             0, 0, 'ServerID', 	0, 	'Internal Use Only',	'T');
	_setting($context, 'title',	           1, 1, 'jPFChat Title',	'jPFChat','The title displayed at the top of your jPFChat Window. Default: jPFChat','T');
	_setting($context, 'theme',                1,2,'Theme','default','Specifies the predefined display theme for the jPFChat Window. Default: default','L' );
	_setting($context, 'language',             1,3,'Language','en_US','The language file to use for the jPFChat display. Default: en-US','L');
	_setting($context, 'height',	           1,4,'Window Height','400px','The display height of the jPFChat Window. Default: 400px','T');
	_setting($context, 'channels',             1,5,'Initial Channels','Joomla!,jPFChat','A comma separated list of initial Channels (chat rooms) for the jPFChat Window to display at startup. Default: Joomla!,jPFChat','T');
	_setting($context, 'max_nick_len',         1,6,'Max Nickname Length','15','The maximum length of a jPFChat Nickname. Default: 15','T');
	_setting($context, 'frozen_nick',          1,7,'Freeze Nicknames','0','If ON, users cannot change their jPFChat Nickname using the /nick command. Default: OFF  NOTE: THere is a BUG in phpFreeChat that causes an infinite LOOP if you have this setting ON and allow unregistered Guests to chat.','B');
	_setting($context, 'max_channels',         1,8,'Max Channels','10','The maximum number of channel (chat rooms) that can be opened for each user. Default: 10','T');
	_setting($context, 'max_privmsg',          1,9,'Max Private Rooms','5','The maximum number of private message rooms that can be opened for each user. Default: 5','T');
	_setting($context, 'isadmin',              1,10,'Admin Users','admin','A comma separated list of Joomla usernames for ADMIN access to jPFChat commands','T');
	_setting($context, 'display_pfc_logo',     1,11,'Show phpFreeChat Logo?','1','Whether to display the phpFreeChat logo. Default: ON.','B');
	_setting($context, 'time_offset',          1,12,'Server Time Offset?','0','Establishes the time difference between the server clock and client clock, in SECONDS.  Default=0','T');
	_setting($context, 'name_or_uname',        2,1,'Display Joomla Username or Real Name','Username','Whether to display the users Joomla username or real name (from Joomla user record) in the Chat Screen.  Default: Username','L');
	_setting($context, 'nickmarker',           2,2,'Colorize Nicknames','1','If ON, jPFChat Nicknames will be highlighted with colors. Default: ON','B');
	_setting($context, 'date_format',          2,3,'Date Format','m/d/Y','The format to use for the display of dates.  Default: m/d/Y','L');
	_setting($context, 'time_format',          2,4,'Time Format','H:i:s','The format to use for the display of time.  Default: H:i:s','L');
	_setting($context, 'shownotice',           2,5,'Notices to Show','3','Notices to show.  Default: 3.  0-no notices,  1- show nickname changes,  2-show connects/disconnects, 3-show both','L');
	_setting($context, 'showwhosonline',       2,6,'Show Current Users','1','Whether to display the list of ONLINE USERS.  Default: ON','B');
	_setting($context, 'showsmileys',          2,7,'Show Smiley Graphics','1','Whether to display the available SMILEY graphics.  Default: ON','B');
	_setting($context, 'displaytabimage',      2,8,'Tab Images','1','Whether to display the tag image for jPFChat channels.  Default ON','B');
	_setting($context, 'displaytabclosebutton',2,9,'Tab Close Button','1','Whether to display the CLOSE button on channel tabs.  Default: ON','B');
	_setting($context, 'btn_sh_whosonline',    2,10,'Online User Button','1','Whether to display the BUTTON that toggles the list of ONLINE USERS.  Default: ON','B');
	_setting($context, 'btn_sh_smileys',       2,11,'Smiley Button','1','Whether to display the BUTTON that toggles the display of SMILEY graphics.  Default: ON','B');
	_setting($context, 'startwithsound',       2,12,'Sound Notifications','1','Whether to generate sound notifications for jPFChat messages.  Default: ON','B');
	_setting($context, 'display_ping',         2,13,'Ping Details','1','Whether to display ping details for jPFChat messages. Default ON','B');
	_setting($context, 'clock',                2,14,'Show Time','1','Display the Date/Time for each jpFChat message.  Default: ON','B');
	_setting($context, 'server_script_url',    3,1,'Server Script URL','','Needed if SEF causes internal links to be incorrect','T');
	_setting($context, 'timeout',              3,2,'Inactive User Timeout','20000','The time jPFChat waits before inactive users are logged out. Default: 20000 (milliseconds)','T');
	_setting($context, 'max_text_len',         3,3,'Max Message Length','400','The maximum length of a single message. Default: 400 (characters)','T');
	_setting($context, 'output_encoding',      3,4,'Encoding','UTF-8','Character encoding jPFChat should use. Default: UTF-8.','T');
	_setting($context, 'refresh_delay',        3,5,'Refresh Delay','2000','The initial delay between screen refreshes, dynamically altered during chats based on activity.  Default: 2000 (milliseconds)','T');
	_setting($context, 'max_msg',              3,6,'Max History','20','The maximum number of messages to be preserved in the case of jPFChat window reload. Default: 20','T');
	_setting($context, 'max_displayed_lines',  3,7,'Max Browser Lines','150','The maximum number of jPFChat lines kept in browser memory. Default: 150','T');
}
