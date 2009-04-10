<?php
/**
* @version		$Id: mod_search.php 10381 2008-06-01 03:35:53Z pasamio $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );

$button		 = $params->get('button', '');
$imagebutton	 = $params->get('imagebutton', '');
$button_pos	 = $params->get('button_pos', 'left');
$button_text	 = $params->get('button_text', JText::_('SEARCH'));
$width		 = intval($params->get('width', 20));
$text		 = $params->get('text', JText::_('3MPN-SEARCH:ENTER_SEARCH_TERM'));
$set_Itemid	 = intval($params->get('set_itemid', 0));
$moduleclass_sfx = $params->get('moduleclass_sfx', '');

$label_content     = JText::_('3MPN-SEARCH:CONTENT');
$label_media       = JText::_('3MPN-SEARCH:MEDIA');
$label_states      = JText::_('3MPN-SEARCH:STATES');
$label_biographies = JText::_('3MPN-SEARCH:BIOGRAPHIES');
$label_flags       = JText::_('3MPN-SEARCH:FLAGS');

if ($imagebutton) {
    $img = modSearchHelper_3mpn::getSearchImage( $button_text );
}
require(JModuleHelper::getLayoutPath('mod_3mpn_search'));
