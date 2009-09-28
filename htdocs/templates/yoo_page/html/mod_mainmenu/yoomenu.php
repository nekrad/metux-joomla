<?php
/**
 * YOOmenu system
 * Adds extended styling ability to Joomla 1.5 Menu module by Louis Landry <louis.landry@joomla.org>
 *
 * @author		yootheme.com
 * @copyright	Copyright (C) 2007 YOOtheme Ltd. & Co. KG. All rights reserved.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

function YOOMenuXMLCallback(&$node, $args) {

	$yoomenu = &YOOMenu::getInstance();
	$params  = $yoomenu->getParams();
	$user    = &JFactory::getUser();
	$menu    = &JSite::getMenu();
	$active  = $menu->getActive();
	$path    = isset($active) ? array_reverse($active->tree) : null;

	// remove child items deeper than end level
	if (($args['end']) && ($node->attributes('level') >= $args['end'])) {
		$children = $node->children();
		foreach ($node->children() as $child) {
			if ($child->name() == 'ul') {
				$node->removeChild($child);
			}
		}
	}

	if ($node->name() == 'ul') {
		// remove inaccessable items according to user rights
		foreach ($node->children() as $child) {
			if ($child->attributes('access') > $user->get('aid', 0)) {
				$node->removeChild($child);
			}
		}
		// set first/last for li
		$children_count = count($node->children());
		$children_index = 0;
		foreach ($node->children() as $child) {
			if ($children_index == 0) $child->addAttribute('first', 1);
			if ($children_index == $children_count - 1) $child->addAttribute('last', 1);
			$children_index++;
		}
		// set ul level
		if (isset($node->_children[0])) {
			$css = 'level' . ($node->_children[0]->attributes('level') - $params->get('startLevel'));
			$node->attributes('class') ? $node->addAttribute('class', $node->attributes('class') . ' ' . $css) : $node->addAttribute('class', $css);
		}
	}

	// set item styling
	if ($node->name() == 'li') {
		$item        = $menu->getItem($node->attributes('id'));
		$item_params = new JParameter($item->params);

		$css = 'level' . ($node->attributes('level') - $params->get('startLevel')) . ' item' . $item->ordering;
		if ($node->attributes('first')) $css .= ' first';
		if ($node->attributes('last')) $css .= ' last';
		if (isset($node->ul)) $css .= ' parent';
		if (isset($path) && in_array($node->attributes('id'), $path)) $css .= ' active';
		if (isset($path) && $node->attributes('id') == $path[0]) $css .= ' current';

		// add a/span css classes
		if (isset($node->_children[0])) {
			$node->_children[0]->attributes('class') ? $node->_children[0]->addAttribute('class', $node->_children[0]->attributes('class') . ' ' . $css) : $node->_children[0]->addAttribute('class', $css);
		}

		// add accordion css class 
		if (isset($node->ul) && $item->type == 'separator' && $params->get('accordionLevel') == $node->attributes('level')) {
			$css .= ' toggler';
			$node->ul[0]->addAttribute('class', 'accordion');
		}

		// add item css classes
		$node->attributes('class') ? $node->addAttribute('class', $node->attributes('class') . ' ' . $css) : $node->addAttribute('class', $css);

		// add item background image
		if ($item_params->get('menu_image') && $item_params->get('menu_image') != -1) {
			if (isset($node->_children[0])) {
				if (isset($node->_children[0]->span[0])) {
					$node->_children[0]->span[0]->addAttribute('style', 'background-image: url(' . JURI::base() . 'images/stories/' . $item_params->get('menu_image') . ');');
				}
				if ($img = $node->_children[0]->getElementByPath('img')) {
					$node->_children[0]->removeChild($img); // remove old item image
				}
			}
		}
	}
	
	// remove inactive child items except for accordion
	if (!(isset($path) && in_array($node->attributes('id'), $path))) {
		if (isset($args['children']) && !$args['children'])	{
			$children = $node->children();
			foreach ($node->children() as $child) {
				if ($child->name() == 'ul') {
					
					// dont remove children for accordion
					if (!$child->attributes('class') == 'accordion') {
						$node->removeChild($child);
					}
				}
			}
		}
	}

	$node->removeAttribute('id');
	$node->removeAttribute('level');
	$node->removeAttribute('access');
	$node->removeAttribute('first');
	$node->removeAttribute('last');
}

class YOOMenu {

	var $params;

	function YOOMenu() {
		$this->params = null;
	}

	function &getInstance() {
		static $instance;

		if ($instance == null) {
			$instance = new YOOMenu();
		}
		
		return $instance;
	}

	function getParams() {
		return $this->params;
	}

	function setParams(&$val) {
		return $this->params = $val;
	}

}

?>