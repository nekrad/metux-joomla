<?php
	/**
	 *	Mamblog User Blog Component for Joomla!
	 *	30 Oct 2005
 	 *
	 *	Copyright (C) 2004-2005 Olle Johansson
	 *	Distributed under the terms of the GNU General Public License
	 *	This software may be used without warrany provided and
	 *  copyright statements are left intact.
     */
function com_uninstall() {
	global $database;

	$errmsg = "";

	// Remove the menu items for the component.
	$database->setQuery( "DELETE FROM #__menu WHERE link LIKE 'index.php?option=com_mamblog%'" );
	if ( !$database->query() ) {
		$errmsg .= "ERROR: Couldn't delete Mamblog menu item.<br />";
	}
	// Read the id of the section used by the component.
	$database->setQuery( "SELECT id FROM #__sections WHERE title='Mamblog'" );
	if ( $id = $database->loadResult() ) {
		// Delete the categories connected to the section.
		$database->setQuery( "DELETE FROM #__categories WHERE section='$id'" );
		if ( !$database->query() ) {
			$errmsg .= "ERROR: Couldn't delete Mamblog category.<br />";
		}
		// Delete the content section used by the component.
		$database->setQuery( "DELETE FROM #__sections WHERE id='$id'" );
		if ( !$database->query() ) {
			$errmsg .= "Couldn't delete Mamblog content section, make sure you delete it by hand.<br />";
		}
		// Find all Mamblog items in frontpage table
		$database->setQuery( "SELECT id FROM #__content_frontpage LEFT JOIN #__content ON content_id = id WHERE sectionid='$id'" );
		$contentids = $database->loadResultArray();
		if ( count( $contentids ) ) {
			$database->setQuery( "DELETE FROM #__content_frontpage WHERE content_id IN (" . implode( ",", $contentids ) . ")" );
			$database->query();
		}
		// Delete the content items connected to the Mamblog section.
		$database->setQuery( "DELETE FROM #__content WHERE sectionid='$id'" );
		if ( !$database->query() ) {
			$errmsg .= "ERROR: Couldn't delete Mamblog content items, make sure you delete them by hand.<br />";
		}
	} else {
		$errmsg .= "ERROR: Couldn't find Mamblog section, make sure you delete it.<br />";
	}

	$retmsg = "Visit <a href=\"http://mambo.theyard.org\" target=\"blank\">Mambo at the Yard</a> for more exciting Mambo addons.";
	if ( $errmsg ) {
		print "<h1>Errors encountered</h1\n><p>$errmsg</p>\n";
		return "Mamblog Uninstalled.<br />$retmsg";
	} else {
		return "Mamblog Successfully Uninstalled<br />$retmsg";
	}
}
?>
