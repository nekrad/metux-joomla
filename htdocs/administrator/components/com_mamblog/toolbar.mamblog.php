<?php
//Mamblog Admin//
	/**
	 *	Mamblog Component for Mambo Site Server 4
	 *	Dynamic portal server and Content managment engine
	 *	13 Mar 2004
 	 *
	 *	Copyright (C) 2004 Olle Johansson
	 *	Distributed under the terms of the GNU General Public License
	 *	This software may be used without warrany provided and
	 *  copyright statements are left intact.
	 *
	 *	Site Name: Mambo Site Server 4.5
	 *	File Name: toolbar.mamblog.php
	 *	Developer: Olle Johansson - Olle@Johansson.com
	 *	Date: 13 Mar 2004
	 * 	Version #: 1.0
	 *	Comments:
	**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ( $task ) {
	case "conf":
		TOOLBAR_mamblog::_EDIT_CONFIG();
		break;
	case "info":
	default:
		TOOLBAR_mamblog::BACKONLY_MENU();
		break;
}
?>