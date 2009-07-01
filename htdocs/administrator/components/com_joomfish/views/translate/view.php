<?php
/**
* @version		$Id: mergeCopyTarget8156.tmp 1080 2008-08-15 15:24:03Z akede $
* @package		Joomla
* @subpackage	Weblinks
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

JLoader::import( 'views.default.view',JOOMFISH_ADMINPATH);

/**
 * View class for translation overview
 *
 * @static
 * @package		Joom!Fish
 * @subpackage	translation
 * @since 2.0
 */
class TranslateViewTranslate extends JoomfishViewDefault
{
	/**
	 * Control Panel display function
	 *
	 * @param template $tpl
	 */
	function display($tpl = null)
	{
		$document =& JFactory::getDocument();
		// this already includes administrator
		$livesite = JURI::base();
		$document->addStyleSheet($livesite.'components/com_joomfish/assets/css/joomfish.css');

		// browser title
		$document->setTitle(JText::_('JOOMFISH_TITLE') . ' :: ' .JText::_('TITLE_TRANSLATION'));
		
		// Set  page title
		JToolBarHelper::title( JText::_( 'TITLE_TRANSLATION' ), 'jftranslations' );

		$layout = $this->getLayout();
		if (method_exists($this,$layout)){
			$this->$layout($tpl);
		} else {
			$this->overview($tpl);
		}			

		JHTML::_('behavior.tooltip');
		parent::display($tpl);
	}
	
	
	function overview($tpl = null)
	{
		// browser title
		$document =& JFactory::getDocument();
		$document->setTitle(JText::_('JOOMFISH_TITLE') . ' :: ' .JText::_('TRANSLATE'));
		
		// set page title
		JToolBarHelper::title( JText::_( 'TRANSLATE' ), 'translation' );

		// Set toolbar items for the page
		JToolBarHelper::publish("translate.publish");
		JToolBarHelper::unpublish("translate.unpublish");
		JToolBarHelper::editList("translate.edit");
		JToolBarHelper::deleteList(JText::_("ARE YOU SURE YOU WANT TO DELETE THIS TRANSLATION"), "translate.remove");
		JToolBarHelper::custom( 'cpanel.show', 'joomfish', 'joomfish', JText::_( 'CONTROL PANEL' ), false );
		JToolBarHelper::help( 'screen.translate.overview', true);

		JSubMenuHelper::addEntry(JText::_('Control Panel'), 'index2.php?option=com_joomfish', false);
		JSubMenuHelper::addEntry(JText::_('Translation'), 'index2.php?option=com_joomfish&amp;task=translate.overview', true);
		JSubMenuHelper::addEntry(JText::_('Orphans'), 'index2.php?option=com_joomfish&amp;task=translate.orphans');
		JSubMenuHelper::addEntry(JText::_('Manage Translations'), 'index2.php?option=com_joomfish&amp;task=manage.overview', false);
		JSubMenuHelper::addEntry(JText::_('Statistics'), 'index2.php?option=com_joomfish&amp;task=statistics.overview', false);
		JSubMenuHelper::addEntry(JText::_('Language Configuration'), 'index2.php?option=com_joomfish&amp;task=languages.show', false);
		JSubMenuHelper::addEntry(JText::_('Content elements'), 'index2.php?option=com_joomfish&amp;task=elements.show', false);
		JSubMenuHelper::addEntry(JText::_('HELP AND HOWTO'), 'index2.php?option=com_joomfish&amp;task=help.show', false);
	}	
	
	function edit($tpl = null)
	{
		// browser title
		$document =& JFactory::getDocument();
		$document->setTitle(JText::_('JOOMFISH_TITLE') . ' :: ' .JText::_('Translate'));
		
		// set page title
		JToolBarHelper::title( JText::_( 'Translate' ), 'translation' );

		// Set toolbar items for the page
		if (JRequest::getVar("catid","")=="content"){
			//JToolBarHelper::preview('index.php?option=com_joomfish',true);
			$bar = & JToolBar::getInstance('toolbar');
			// Add a special preview button by hand			
			$live_site = JURI::base();			
			$bar->appendButton( 'Popup', 'preview', 'Preview', JRoute::_("index.php?option=com_joomfish&task=translate.preview&tmpl=component"), "800","550");
		}
		JToolBarHelper::save("translate.save");
		JToolBarHelper::apply("translate.apply");
		JToolBarHelper::cancel("translate.overview");
		JToolBarHelper::help( 'screen.translate.edit', true);
		
		JRequest::setVar('hidemainmenu',1);
	}	

	function orphans($tpl = null)
	{
		// browser title
		$document =& JFactory::getDocument();
		$document->setTitle(JText::_('JOOMFISH_TITLE') . ' :: ' .JText::_('CLEANUP ORPHANS'));
		
		// set page title
		JToolBarHelper::title( JText::_( 'CLEANUP ORPHANS' ), 'orphan' );

		// Set toolbar items for the page
		JToolBarHelper::deleteList(JText::_("ARE YOU SURE YOU WANT TO DELETE THIS TRANSLATION"), "translate.removeorphan");
		JToolBarHelper::custom( 'cpanel.show', 'joomfish', 'joomfish', JText::_( 'CONTROL PANEL' ), false );
		JToolBarHelper::help( 'screen.translate.orphans', true);

		JSubMenuHelper::addEntry(JText::_('Control Panel'), 'index2.php?option=com_joomfish', false);
		JSubMenuHelper::addEntry(JText::_('Translation'), 'index2.php?option=com_joomfish&amp;task=translate.overview', false);
		JSubMenuHelper::addEntry(JText::_('Orphans'), 'index2.php?option=com_joomfish&amp;task=translate.orphans', true);
		JSubMenuHelper::addEntry(JText::_('Manage Translations'), 'index2.php?option=com_joomfish&amp;task=manage.overview', false);
		JSubMenuHelper::addEntry(JText::_('Statistics'), 'index2.php?option=com_joomfish&amp;task=statistics.overview', false);
		JSubMenuHelper::addEntry(JText::_('Language Configuration'), 'index2.php?option=com_joomfish&amp;task=languages.show', false);
		JSubMenuHelper::addEntry(JText::_('Content elements'), 'index2.php?option=com_joomfish&amp;task=elements.show', false);
		JSubMenuHelper::addEntry(JText::_('HELP AND HOWTO'), 'index2.php?option=com_joomfish&amp;task=help.show', false);
	}	

	function orphandetail($tpl = null)
	{
		// browser title
		$document =& JFactory::getDocument();
		$document->setTitle(JText::_('JOOMFISH_TITLE') . ' :: ' .JText::_('CLEANUP ORPHANS'));
		
		// set page title
		JToolBarHelper::title( JText::_( 'CLEANUP ORPHANS' ), 'orphan' );

		// Set toolbar items for the page
		//JToolBarHelper::deleteList(JText::_("ARE YOU SURE YOU WANT TO DELETE THIS TRANSLATION"), "translate.removeorphan");
		JToolBarHelper::back();
		JToolBarHelper::custom( 'cpanel.show', 'joomfish', 'joomfish', JText::_( 'CONTROL PANEL' ), false );
		JToolBarHelper::help( 'screen.translate.orphans', true);

		// hide the sub menu
		// This won't work
		$submenu = & JModuleHelper::getModule("submenu");
		$submenu->content = "\n";
		
		JRequest::setVar('hidemainmenu',1);
	}	

	function preview($tpl = null)
	{
		// hide the sub menu
		$this->_hideSubmenu();
		parent::display($tpl);
		
	}
}
