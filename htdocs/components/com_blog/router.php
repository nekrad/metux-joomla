<?php
/**
* @version		$Id: router.php 10752 2008-08-23 01:53:31Z eddieajau $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

function blogBuildRoute(&$query)
{
	$segments = array();

	if(isset($query['view']))
	{
		if(empty($query['Itemid'])) {
			$segments[] = $query['view'];
		} else {
			$menu = &JSite::getMenu();
			$menuItem = &$menu->getItem( $query['Itemid'] );
			if(!isset($menuItem->query['view']) || $menuItem->query['view'] != $query['view']) {
				$segments[] = $query['view'];
			}
		}
		unset($query['view']);
	}
	if(isset($query['name'])) {

		if(!empty($query['Itemid'])) {
			$segments[] = $query['name'];
			unset($query['name']);
		}
	};
	
	if(isset($query['task'])) {

		if(!empty($query['Itemid'])) {
			$segments[] = $query['task'];
			unset($query['task']);
		}
	};

 	
 	return $segments;
}

function blogParseRoute($segments)
{
	$vars = array();

	//Get the active menu item
	$menu =& JSite::getMenu();
	$item =& $menu->getActive();
	
	$count = count($segments);
	
	if(!empty($count)) {
		$vars['view'] = $segments[0];
	}
	if($count > 1) {
	
		$vars['task']    = $segments[$count - 1];
	}
	
 	return $vars;
}

?>