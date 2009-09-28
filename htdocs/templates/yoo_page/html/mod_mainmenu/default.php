<?php
/**
 * YOOmenu system
 * Adds extended styling ability to Joomla 1.5 Menu module by Louis Landry <louis.landry@joomla.org>
 *
 * @version		1.0.0 (03.05.2007)
 * @author		yootheme.com
 * @copyright	Copyright (C) 2007 YOOtheme Ltd. & Co. KG. All rights reserved.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// include YOOmenu system
require_once(JModuleHelper::getLayoutPath('mod_mainmenu', 'yoomenu'));

// set YOOmenu params
$yootools  = &YOOTools::getInstance();
$accordion = $yootools->getParam('accordionMenu', array());
if (array_key_exists($params->get('menutype'), $accordion)) $params->def('accordionLevel', $accordion[$params->get('menutype')]);
$yoomenu = &YOOMenu::getInstance();
$yoomenu->setParams($params);

modMainMenuHelper::render($params, 'YOOMenuXMLCallback');
?>