<?php

function joomla_component_install($context)
{
	$context->setPkg('com_yaml');
	$context->addComponent(
	    'com_jyaml',
	    'jYAML', 
	    'components/com_jyaml/images/jyaml-16.png');

	/**
	 * Delete database link like Core-Extension to hide Component in Menu-Manager
	**/
#	$query = "UPDATE #__components SET link='' WHERE link='option=com_jyaml' LIMIT 1";
#	$context->queryExec($query);

	$context->registerPlugin('jyaml', 'system', 'System - JYAML Plugin');

	/**
	 * Check activate_parent Parameter id enabled. If not set to 1 or add param activate_parent=1
	**/ 
	$query = "SELECT id, params FROM #__modules WHERE module='mod_mainmenu'";
	$menus = $context->queryObjectList($query);
	foreach($menus as $key=>$menu) 
	{
		if( strpos($menu->params, "activate_parent") ) 
		{
			if ( strpos($menu->params, "activate_parent=0") )
			    $menus[$key]->params = str_replace("activate_parent=0", "activate_parent=1", $menu->params);
			else
			    $menus[$key]->params .= "\nactivate_parent=1";
		}
	}

	/**
	 * Check mod_mainmenu in nav_main exists 
	**/
	$query = "SELECT * FROM #__modules WHERE module='mod_mainmenu' AND position='nav_main'";
	if (!($result = $context->queryRecord($query)))
	{
	    // Insert mod_mainmenu with nav_main
	    $params = "menutype=mainmenu\nmenu_style=list\nstartLevel=0\nendLevel=1\nshowAllChildren=0\nshow_whitespace=0\ncache=1\nmoduleclass_sfx=_menu\nmaxdepth=1\nactivate_parent=1";
	    $query = "INSERT INTO #__modules " .
		"(id, title, content, ordering, position, checked_out, checked_out_time, published, module, numnews, access, showtitle, params, iscore, client_id, control) " .
		"VALUES (null, 'Main Menu (level0) - JYAML', '', '0', 'nav_main', '0', '', '1', 'mod_mainmenu', '0', '0', '0', '".$params."', '0', '0', '')"
           ;
	    $context->queryExec($query);

	    // Show on all pages
	    $query = "INSERT INTO #__modules_menu (moduleid, menuid) ".
		"VALUES ('".$context->dbo->insertid()."', '0')";
	    $context->queryExec( $query );
	}

	/**
	 * Check mod_mainmenu in topnav exists 
	**/
	$query = "SELECT * FROM #__modules WHERE module='mod_mainmenu' AND position='topnav'";
	if (!($result = $context->queryRecord($query)))
	{
		// Insert mod_mainmenu with nav_main
	        $params = "menutype=topmenu\nmenu_style=list\nstartLevel=0\nendLevel=1\nshowAllChildren=0\nshow_whitespace=0\ncache=1\nmoduleclass_sfx=_menu\nmaxdepth=1\nactivate_parent=1";
	        $query = "INSERT INTO #__modules " .
	           "(id, title, content, ordering, position, checked_out, checked_out_time, published, module, numnews, access, showtitle, params, iscore, client_id, control) " .
	           "VALUES (null, 'Top Menu (level0) - JYAML', '', '0', 'topnav', '0', '', '1', 'mod_mainmenu', '0', '0', '0', '".$params."', '0', '0', '')"
	           ;
		$context->queryExec($query);

	        // Show on all pages
	        $query = "INSERT INTO #__modules_menu (moduleid, menuid) VALUES ('".$context->dbo->insertid()."', '0')";
		$context->queryExec($query);
	}

	$context->message('Done');
}
