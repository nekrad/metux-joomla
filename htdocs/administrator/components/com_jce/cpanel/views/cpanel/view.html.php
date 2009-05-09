<?php
/**
* @version		$Id: view.html.php 9872 2008-01-05 11:14:10Z eddieajau $
* @package		Joomla
* @subpackage	Config
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');
jimport('joomla.html.pane');
jimport('joomla.application.module.helper');

/**
 * HTML View class for the Plugins component
 *
 * @static
 * @package		Joomla
 * @subpackage	Plugins
 * @since 1.0
 */
class CpanelViewCpanel extends JView
{
	function display( $tpl = null )
	{
		$db			=& JFactory::getDBO();
		$lang 		=& JFactory::getLanguage();	
		$pane		=& JPane::getInstance('sliders');
		
		$icons		=& JModuleHelper::getModules('jce_icon');
		$modules	=& JModuleHelper::getModules('jce_cpanel');
		
		$this->assignRef('icons', 	$icons);
		$this->assignRef('pane', 	$pane);
		$this->assignRef('modules', $modules);

		parent::display($tpl);
	}
}