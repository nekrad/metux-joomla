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
	 *	File Name: toolbar.mamblog.html.php
	 *	Developer: Olle Johansson - Olle@Johansson.com
	 *	Date: 13 Mar 2004
	 * 	Version #: 1.0
	 *	Comments:
	**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class TOOLBAR_mamblog {

	function _EDIT_CONFIG() {
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::save( 'saveconf' );
		mosMenuBar::back();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	function BACKONLY_MENU() {
		mosMenuBar::startTable();
		mosMenuBar::back();
		mosMenuBar::endTable();
	}

}
?>