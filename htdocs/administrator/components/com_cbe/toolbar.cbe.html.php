<?php
// $Id: toolbar.cbe.html.php,v 1.3 2005/04/23 21:27:09 mambojoe Exp $
/**
* User Menu Button Bar HTML
* @package Mambo Open Source
* @Copyright (C) 2000 - 2003 Miro International Pty Ltd
* @ All rights reserved
* @ Mambo Open Source is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 1.3 $
**/

class TOOLBAR_usersextras {
	/**
	* Draws the menu for a New user
	*/
	function _NEW() {
		//
		JToolBarHelper::save();
		JToolBarHelper::cancel('showusers');
		JToolBarHelper::spacer();
		//
	}
	
	function _EDIT() {
		
		JToolBarHelper::custom( 'adminUpAvatar', 'upload.png', 'upload_f2.png', 'Upload Avatar', false );
		JToolBarHelper::custom( 'adminDelAvatar', 'delete.png', 'delete_f2.png', 'Delete Avatar', false );
		JToolBarHelper::divider();
		JToolBarHelper::save();
		JToolBarHelper::cancel('showusers');
		JToolBarHelper::spacer();
		
	}

	function _NEW_TAB() {
		
		JToolBarHelper::save('saveTab');
		JToolBarHelper::cancel('showTab');
		JToolBarHelper::spacer();
		
	}
	
	function _EDIT_TAB() {
		
		JToolBarHelper::save('saveTab');
		JToolBarHelper::cancel('showTab');
		JToolBarHelper::spacer();
		
	}
	function _DEFAULT_TAB() {
		
		JToolBarHelper::custom( 'newTab', 'new.png', 'new_f2.png', 'New Tab', false );
		JToolBarHelper::editList('editTab');
		JToolBarHelper::deleteList('The tab will be deleted and cannot be undone!','removeTab');
		JToolBarHelper::spacer();
		JToolBarHelper::cancel();
		
	}
	function _NEW_FIELD() {
		
		JToolBarHelper::save('saveField');
		JToolBarHelper::cancel('showField');
		JToolBarHelper::spacer();
		
	}
	
	function _EDIT_FIELD() {
		
		JToolBarHelper::save('saveField');
		JToolBarHelper::cancel('showField');
		JToolBarHelper::spacer();
		
	}
	function _DEFAULT_FIELD() {
		
		JToolBarHelper::custom( 'newField', 'new.png', 'new_f2.png', 'New Field', false );
		JToolBarHelper::editList('editField');
		JToolBarHelper::deleteList('The Field and all user data associated to this field will be lost and cannot be undone!','removeField');
		JToolBarHelper::spacer();
		JToolBarHelper::cancel();
		
	}
	function _NEW_LIST() {
		
		JToolBarHelper::save('saveList');
		JToolBarHelper::cancel('showLists');
		JToolBarHelper::spacer();
		
	}
	
	function _EDIT_LIST() {
		
		JToolBarHelper::save('saveList');
		JToolBarHelper::cancel('showLists');
		JToolBarHelper::spacer();
		
	}
	function _DEFAULT_LIST() {
		
		JToolBarHelper::custom( 'newList', 'new.png', 'new_f2.png', 'New List', false );
		JToolBarHelper::editList('copyList', 'Copy List');
		JToolBarHelper::editList('editList');
		JToolBarHelper::deleteList('The selected List(s) will be deleted and cannot be undone!','removeList');
		JToolBarHelper::spacer();
		JToolBarHelper::cancel();
		
	}
	function _EDIT_CONFIG() {
		
		JToolBarHelper::save('saveconfig');
		JToolBarHelper::cancel();
		JToolBarHelper::spacer();
		
	}

	
	function _DEFAULT() {
		
		JToolBarHelper::custom( 'resendConfirm', 'copy.png', 'copy_f2.png', 'Resend Confirm', false );
		JToolBarHelper::divider();
		JToolBarHelper::custom( 'unblock', 'edit.png', 'edit_f2.png', 'Enable', false );
		JToolBarHelper::custom( 'block', 'edit.png', 'edit_f2.png', 'Disable', false );
		JToolBarHelper::divider();
		JToolBarHelper::custom( 'approve', 'edit.png', 'edit_f2.png', 'Approve', false );
		JToolBarHelper::custom( 'reject', 'edit.png', 'edit_f2.png', 'Reject', false );
		JToolBarHelper::divider();
		JToolBarHelper::addNew();
		JToolBarHelper::editList();
		JToolBarHelper::deleteList();
		JToolBarHelper::spacer();
		JToolBarHelper::cancel();
		
	}
	
	function _DEFAULT_TOOLS() {
		
		JToolBarHelper::cancel();
		
	}
	function _DEFAULT_SEARCHMANAGER() {
		
		JToolBarHelper::cancel();
		
	}
	
	function _EDIT_LANGUAGE_FILTER() { //Jeffrey Randall 25-03-2005
		
		JToolBarHelper::save('saveLanguageFilter');
		JToolBarHelper::cancel('cancelLanguageFilter');
		JToolBarHelper::spacer();
		
	}
	function _NEW_LANGUAGE_FILTER() { //Jeffrey Randall 25-03-2005
		
		JToolBarHelper::save('saveLanguageFilter');
		JToolBarHelper::cancel('cancelLanguageFilter');
		JToolBarHelper::spacer();
		
	}
	function _DEFAULT_LANGUAGE_FILTER() {//Jeffrey Randall 25-03-2005
		
		JToolBarHelper::publishList('publishLanguageFilter');
		JToolBarHelper::unpublishList('unpublishLanguageFilter');
		JToolBarHelper::divider();
		JToolBarHelper::addNew('newLanguageFilter');
		JToolBarHelper::editList('editLanguageFilter');
		JToolBarHelper::deleteList('','deleteLanguageFilter');
		JToolBarHelper::spacer();
		JToolBarHelper::cancel();
		
	}

	function _EDIT_ENHANCED_CONFIG() {
		
		JToolBarHelper::save('saveEnhancedConfig');
		JToolBarHelper::cancel();
		JToolBarHelper::spacer();
		
	}

	function _EDIT_PLUGIN_CONFIG() {
		
		JToolBarHelper::save('savePluginConfig');
		JToolBarHelper::cancel();
		JToolBarHelper::spacer();
		
	}

	function _ADMIN_AVATAR() {
		
		JToolBarHelper::cancel('showusers');
		JToolBarHelper::spacer();
		
	}

	function _EDIT_BADUSER_NAMES() {
		
		JToolBarHelper::save('savebadUserNames');
		JToolBarHelper::cancel('cancelbadUserNames');
		JToolBarHelper::spacer();
		
	}
	function _NEW_BADUSER_NAMES() {
		
		JToolBarHelper::save('savebadUserNames');
		JToolBarHelper::cancel('cancelbadUserNames');
		JToolBarHelper::spacer();
		
	}
	function _DEFAULT_BADUSER_NAMES() {
		
		JToolBarHelper::publishList('publishbadUserNames');
		JToolBarHelper::unpublishList('unpublishbadUserNames');
		JToolBarHelper::divider();
		JToolBarHelper::addNew('newbadUserNames');
		JToolBarHelper::editList('editbadUserNames');
		JToolBarHelper::deleteList('','deletebadUserNames');
		JToolBarHelper::spacer();
		JToolBarHelper::cancel();
		
	}

	function _EDIT_ADMODS() {
		
		JToolBarHelper::save('saveAdMods');
		JToolBarHelper::cancel('cancelAdMods');
		JToolBarHelper::spacer();
		
	}
	function _NEW_ADMODS() {
		
		JToolBarHelper::save('saveAdMods');
		JToolBarHelper::cancel('cancelAdMods');
		JToolBarHelper::spacer();
		
	}
	function _DEFAULT_ADMODS() {
		
		JToolBarHelper::publishList('publishAdMods');
		JToolBarHelper::unpublishList('unpublishAdMods');
		JToolBarHelper::divider();
		JToolBarHelper::addNew('newAdMods');
		JToolBarHelper::editList('editAdMods');
		JToolBarHelper::deleteList('','deleteAdMods');
		JToolBarHelper::spacer();
		JToolBarHelper::cancel();
		
	}
}
?>
