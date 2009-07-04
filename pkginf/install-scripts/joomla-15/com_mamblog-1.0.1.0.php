<?php

jimport('joomla.database.table.category');
jimport('joomla.database.table.section');

require_once(JPATH_BASE.'/libraries/joomla/database/table/section.php');
require_once(JPATH_BASE.'/libraries/joomla/database/table/category.php');

function joomla_component_install($context)
{
	$context->setPkg('MamBlog');
	$context->setComponent('com_mamblog');
	$context->message('Installing mamblog db stuff');
	$context->addComponent('com_mamblog', 'Mamblog', '');

	$cfg_filename = $context->getFrontendComponentPathname("configuration.php");

	$sec = new JTableSection($context->dbo);
	$sec->title = "Mamblog";
	$sec->name = "Mamblog Section";
	$sec->scope = "content";
	$sec->image_position = "left";
	$sec->description = "A section containing all Mamblog items.";
	$sec->published = "1";
	if ( !$sec->store() || !$sec->checkin() ) {
		die("ERROR: Couldn't create section for Mamblog, you must create a Mamblog section under Content -> Section Manager in Joomla! administrator.<br />");
	}

	$context->message("Created section: ".$sec->id);
	$secid = $sec->id;

	// Insert a default category for the mamblog section.
	$cat = new JTableCategory( $context->dbo );
	$cat->title = "Default Category";
	$cat->name = "Default Category";
	$cat->image = "";
	$cat->section = $secid;
	$cat->image_position = "left";
	$cat->description = "";
	$cat->published = "1";
	if ( !$cat->store() || !$cat->checkin() ) {
		$errmsg .= "ERROR: Couldn't create default category for Mamblog, you must create a Mamblog category under Content -> Category Manager in Joomla! administrator.<br />";
	}

	$context->message("Created category: ".$cat->id);
	$catid = $cat->id;

	// Change the image for the Configuration submenu in the admin section.
#	$sql = "UPDATE #__components SET admin_menu_img='js/ThemeOffice/config.png' WHERE admin_menu_link='option=com_mamblog&task=conf'";
#	$database->setQuery($sql);
#	if ( !$database->query() ) {
#		$errmsg .= "Warning: Couldn't update the image for the Mamblog Configuration Admin sub-menu.<br />";
#	}

	// Change the image for the Information submenu in the admin section.
#	$sql = "UPDATE #__components SET admin_menu_img='js/ThemeOffice/help.png' WHERE admin_menu_link='option=com_mamblog&task=info'";
#	$database->setQuery($sql);
#	if ( !$database->query() ) {
#		$errmsg .= "Warning: Couldn't update the image for the Mamblog Information Admin sub-menu.<br />";
#	}

	// Add section id and category id to configuration file.
	$context->message('Storing configfile');
	$config = file( $cfg_filename );
	foreach($config as $walk => $ccur)
	    if (preg_match('~cfg_mamblog\[\'(sectionid|catid)\'\]~', $ccur))
		unset($config[$walk]);

	$newitems = array( "<?php\n", "\$cfg_mamblog['sectionid'] = \"$secid\";\n", "\$cfg_mamblog['catid'] = \"$catid\";\n" );
	array_splice( $config, 0, 1, $newitems );
	$config = implode( "", $config );
	if ( $fp = fopen( $cfg_filename, "w" ) ) {
		fwrite( $fp, $config, strlen( $config ) );
		fclose( $fp );
	} else {
		$errmsg .= "ERROR: There was a problem saving the Mamblog Configuration file. You must check the readme and find out how to add sectionid and catid values by hand before you can use Mamblog.<br />";
	}

	$context->message('Done');
}
