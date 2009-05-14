<?php
// $Id: toolbar.cbe.php,v 1.2 2005/01/03 06:07:13 mambojoe Exp $
/**
* User toolbar handler
* @package Mambo Open Source
* @Copyright (C) 2000 - 2003 Miro International Pty Ltd
* @ All rights reserved
* @ Mambo Open Source is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 1.2 $
**/

// ensure this file is being included by a parent file
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ( $task ) {

	case "edit":
	TOOLBAR_usersextras::_EDIT();
	break;

	case "new":
	TOOLBAR_usersextras::_NEW();
	break;

	case "add":
	TOOLBAR_usersextras::_NEW();
	break;

	case "showconfig":
	TOOLBAR_usersextras::_EDIT_CONFIG();
	break;

	case "editTab":
	TOOLBAR_usersextras::_EDIT_TAB();
	break;

	case "newTab":
	TOOLBAR_usersextras::_NEW_TAB();
	break;

	case "showTab":
	TOOLBAR_usersextras::_DEFAULT_TAB();
	break;
	case "editField":
	TOOLBAR_usersextras::_EDIT_FIELD();
	break;

	case "newField":
	TOOLBAR_usersextras::_NEW_FIELD();
	break;

	case "showField":
	TOOLBAR_usersextras::_DEFAULT_FIELD();
	break;
	case "editList":
	TOOLBAR_usersextras::_EDIT_LIST();
	break;

	case "newList":
	TOOLBAR_usersextras::_NEW_LIST();
	break;

	case "showLists":
	TOOLBAR_usersextras::_DEFAULT_LIST();
	break;
	case "showusers":
	TOOLBAR_usersextras::_DEFAULT();
	break;
	case "tools":
	TOOLBAR_usersextras::_DEFAULT_TOOLS();
	break;
	/*
	default:
	TOOLBAR_usersextras::_DEFAULT();
	break;
	*/
	case "searchManage":
	TOOLBAR_usersextras::_DEFAULT_SEARCHMANAGER();
	break;
	case "languageFilter": //Jeffrey Randall 25-03-2005
	TOOLBAR_usersextras::_DEFAULT_LANGUAGE_FILTER();
	break;
	case "newLanguageFilter": //Jeffrey Randall 25-03-2005
	case "editLanguageFilter": //Jeffrey Randall 25-03-2005
	TOOLBAR_usersextras::_EDIT_LANGUAGE_FILTER();
	break;
	case "saveLanguageFilter": //Jeffrey Randall 25-03-2005
	TOOLBAR_usersextras::_EDIT_LANGUAGE_FILTER();
	break;

	//sv0.623
	case "adminUpAvatar":
	TOOLBAR_usersextras::_ADMIN_AVATAR();
	break;

	case "enhancedConfig":
	TOOLBAR_usersextras::_EDIT_ENHANCED_CONFIG();
	break;

	case "pluginConfig":
	TOOLBAR_usersextras::_EDIT_PLUGIN_CONFIG();
	break;

	//sv0.6232
	case "badUserNames":
	TOOLBAR_usersextras::_DEFAULT_BADUSER_NAMES();
	break;
	case "newbadUserNames":
	case "editbadUserNames":
	TOOLBAR_usersextras::_EDIT_BADUSER_NAMES();
	break;
	case "savebadUserNames":
	TOOLBAR_usersextras::_EDIT_BADUSER_NAMES();
	break;

	//sv0.702
	case "showAdMods":
	TOOLBAR_usersextras::_DEFAULT_ADMODS();
	break;
	case "newAdMods":
	case "editAdMods":
	TOOLBAR_usersextras::_EDIT_ADMODS();
	break;
	case "saveAdMods":
	TOOLBAR_usersextras::_EDIT_ADMODS();
	break;
}
?>