<?php
	/**
	 *	Mamblog Component for Mambo Site Server 4.5
	 *	Dynamic portal server and Content managment engine
	 *	13 Mar 2004
 	 *
	 *	Copyright (C) 2004 Olle Johansson
	 *	Distributed under the terms of the GNU General Public License
	 *	This software may be used without warrany provided and
	 *  copyright statements are left intact.
     */
function com_install() {
	global $database, $mosConfig_absolute_path;

	$errmsg = "";

	// Find component id and link from the components table.
	$sql = "SELECT id, link from #__components WHERE name='Mamblog'";
	$database->setQuery($sql);
	$row = null;
	if ( !$database->loadObject( $row ) ) {
		#return $database->stderr();
		$errmsg .= "ERROR: Couldn't read information about installed component. No menu items will be created.<br />";
	}

	// Only install menu items if we found the component information.
	if ( $row->id ) {
		// Insert a main menu item for the Mamblog.
		$menu = new mosMenu( $database );
		$menu->menutype = "mainmenu";
		$menu->name = "Mamblog";
		$menu->link = "index.php?$row->link";
		$menu->type = "components";
		$menu->published = "1";
		$menu->componentid = "$row->id";
		$menu->ordering = "9999999";
		if ( !$menu->store() || !$menu->checkin() || !$menu->updateOrder( "menutype='mainmenu'" ) ) {
			$errmsg .= "ERROR: Couldn't insert Mamblog item on main menu.<br />";
		}

		// Find menu itemid from the menu table.
		$sql = "SELECT id from #__menu WHERE link='index.php?option=com_mamblog'";
		$database->setQuery($sql);
		$menurow = null;
		if ( $database->loadObject( $menurow ) ) {
			$Itemid = $menurow->id;
		} else {
			$Itemid = 0;
		}

		// Insert a user menu item for writing new blog entries.
		$menu = new mosMenu( $database );
		$menu->menutype = "usermenu";
		$menu->name = "Write a blog entry";
		$menu->link = "index.php?$row->link&task=edit&Itemid=$Itemid";
		$menu->type = "url";
		$menu->published = "1";
		$menu->access = "1";
		$menu->utaccess = "3";
		$menu->ordering = "9999999";
		if ( !$menu->store() || !$menu->checkin() || !$menu->updateOrder( "menutype='usermenu'" ) ) {
			$errmsg .= "ERROR: An error occured when adding user menu item 'Write a blog entry'. Please check the readme on how to install this on your own.<br />";
		}

		// Insert a user menu item to link to the users' own blog entries.
		$menu = new mosMenu( $database );
		$menu->menutype = "usermenu";
		$menu->name = "Show your blog";
		$menu->link = "index.php?$row->link&task=show&action=showmyblog&Itemid=$Itemid";
		$menu->type = "url";
		$menu->published = "1";
		$menu->access = "1";
		$menu->utaccess = "3";
		$menu->ordering = "9999999";
		if ( !$menu->store() || !$menu->checkin() || !$menu->updateOrder( "menutype='usermenu'" ) ) {
			$errmsg .= "ERROR: An error occured when adding user menu item 'Show your blog'. Please check the readme on how to install this on your own.<br />";
		}
	}

	// Create a new section for the Mamblog items
	$sec = new mosSection( $database );
	$sec->title = "Mamblog";
	$sec->name = "Mamblog Section";
	$sec->scope = "content";
	$sec->image_position = "left";
	$sec->description = "A section containing all Mamblog items.";
	$sec->published = "1";
	if ( !$sec->store() || !$sec->checkin() || !$sec->updateOrder() ) {
		$errmsg .= "ERROR: Couldn't create section for Mamblog, you must create a Mamblog section under Content -> Section Manager in Joomla! administrator.<br />";
	}

	// Get the section id
	$database->setQuery( "SELECT id FROM #__sections WHERE title='Mamblog'" );
	if ( !$secid = $database->loadResult() ) {
		$errmsg .= "ERROR: Couldn't read the id of the Mamblog section. You must update the Mamblog configuration file and set the 'sectionid' value by hand.<br />";
	}

	// Insert a default category for the mamblog section.
	$cat = new mosCategory( $database );
	$cat->title = "Default Category";
	$cat->name = "Default Category";
	$cat->image = "";
	$cat->section = $secid;
	$cat->image_position = "left";
	$cat->description = "";
	$cat->published = "1";
	if ( !$cat->store() || !$cat->checkin() || !$sec->updateOrder() ) {
		$errmsg .= "ERROR: Couldn't create default category for Mamblog, you must create a Mamblog category under Content -> Category Manager in Joomla! administrator.<br />";
	}

	// Get the section id
	$database->setQuery( "SELECT id FROM #__categories WHERE section='$secid'" );
	if ( !$catid = $database->loadResult() ) {
		$errmsg .= "ERROR: Couldn't read the id of the Mamblog default category. You must update the Mamblog configuration file and set the 'catid' value by hand.<br />";
	}

	// Change the image for the Configuration submenu in the admin section.
	$sql = "UPDATE #__components SET admin_menu_img='js/ThemeOffice/config.png' WHERE admin_menu_link='option=com_mamblog&task=conf'";
	$database->setQuery($sql);
	if ( !$database->query() ) {
		$errmsg .= "Warning: Couldn't update the image for the Mamblog Configuration Admin sub-menu.<br />";
	}

	// Change the image for the Information submenu in the admin section.
	$sql = "UPDATE #__components SET admin_menu_img='js/ThemeOffice/help.png' WHERE admin_menu_link='option=com_mamblog&task=info'";
	$database->setQuery($sql);
	if ( !$database->query() ) {
		$errmsg .= "Warning: Couldn't update the image for the Mamblog Information Admin sub-menu.<br />";
	}

	// Add section id and category id to configuration file.
	$cfgfile = "$mosConfig_absolute_path/components/com_mamblog/configuration.php";
	$config = file( $cfgfile );
	$newitems = array( "<?php\n", "\$cfg_mamblog['sectionid'] = \"$secid\";\n", "\$cfg_mamblog['catid'] = \"$catid\";\n" );
	array_splice( $config, 0, 1, $newitems );
	$config = implode( "", $config );
	if ( $fp = fopen( $cfgfile, "w" ) ) {
		fwrite( $fp, $config, strlen( $config ) );
		fclose( $fp );
	} else {
		$errmsg .= "ERROR: There was a problem saving the Mamblog Configuration file. You must check the readme and find out how to add sectionid and catid values by hand before you can use Mamblog.<br />";
	}

	$retmsg = "Visit <a href=\"http://mambo.theyard.org\" target=\"blank\">Mambo at the Yard</a> for more exciting Mambo addons.";
	if ( $errmsg ) {
		print "<h1>Errors</h1>\n<p>$errmsg</p>\n";
		return "One or more errors encountered during installation. Warnings can be safely ignored, but if you receieved any ERROR messages, you must refer to the documentation on how to handle this before you can start using Mamblog.<br /><br />Mamblog 1.0 Installed. $retmsg";
	} else {
		return "Mamblog 1.0 Successfully Installed. $retmsg";
	}

/*
	# Add help information
INSERT INTO #__help
( lang, context, name, title, parent, ordering, catid, helptext )
VALUES (
'eng',
'com_mamblog',
'Mamblog',
'The Mamblog Component',
'13',
'7',
'3',
'asdf asdf af asdf'
)
*/

}
?>
