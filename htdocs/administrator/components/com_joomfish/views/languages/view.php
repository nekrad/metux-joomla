<?php
/**
* @version		$Id: mergeCopyTarget8144.tmp 1080 2008-08-15 15:24:03Z akede $
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
jimport( 'joomla.filesystem.file');
jimport( 'joomla.application.component.view');
jimport('joomla.html.pane');

/**
 * HTML View class for the WebLinks component
 *
 * @static
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.0
 */
class LanguagesViewLanguages extends JoomfishViewDefault
{
	/**
	 * Control Panel display function
	 *
	 * @param template $tpl
	 */
	function display($tpl = null)
	{
		global $mainframe;
		
		$document =& JFactory::getDocument();
		// this already includes administrator
		$livesite = JURI::base();
		$document->addStyleSheet($livesite.'components/com_joomfish/assets/css/joomfish.css');

		$document->setTitle(JText::_('JOOMFISH_TITLE') . ' :: ' .JText::_('Language Title'));
		
		// Set toolbar items for the page
		JToolBarHelper::title( JText::_( 'Language Title' ), 'language' );
		//JToolBarHelper::custom( 'languages.translateConfig', 'config', 'config', JText::_( 'Config' ),true);
		JToolBarHelper::deleteList('Are you sure you want to delete the selcted items?', 'language.remove');
		JToolBarHelper::custom( 'languages.save', 'save', 'save', JText::_( 'Save' ),false);
		JToolBarHelper::custom( 'languages.apply', 'apply', 'apply', JText::_( 'Apply' ),false);
		JToolBarHelper::cancel('languages.cancel');
		JToolBarHelper::help( 'screen.languages', true);

		JSubMenuHelper::addEntry(JText::_('Control Panel'), 'index2.php?option=com_joomfish');
		JSubMenuHelper::addEntry(JText::_('Translation'), 'index2.php?option=com_joomfish&amp;task=translate.overview');
		JSubMenuHelper::addEntry(JText::_('Orphans'), 'index2.php?option=com_joomfish&amp;task=translate.orphans');
		JSubMenuHelper::addEntry(JText::_('Manage Translations'), 'index2.php?option=com_joomfish&amp;task=manage.overview', false);
		JSubMenuHelper::addEntry(JText::_('Statistics'), 'index2.php?option=com_joomfish&amp;task=statistics.overview', false);
		JSubMenuHelper::addEntry(JText::_('Language Configuration'), 'index2.php?option=com_joomfish&amp;task=languages.show', true);
		JSubMenuHelper::addEntry(JText::_('Content elements'), 'index2.php?option=com_joomfish&amp;task=elements.show', false);
		JSubMenuHelper::addEntry(JText::_('HELP AND HOWTO'), 'index2.php?option=com_joomfish&amp;task=help.show', false);
		
		$option				= JRequest::getCmd('option', 'com_joomfish');
		$filter_state		= $mainframe->getUserStateFromRequest( $option.'filter_state',		'filter_state',		'',				'word' );
		$filter_catid		= $mainframe->getUserStateFromRequest( $option.'filter_catid',		'filter_catid',		0,				'int' );
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order',		'filter_order',		'l.ordering',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'',				'word' );
		$search				= $mainframe->getUserStateFromRequest( $option.'search',			'search',			'',				'string' );
		$search				= JString::strtolower( $search );
				
		$languages	= &$this->get('data');
		$defaultLanguage = &$this->get('defaultLanguage');
		
		$this->assignRef('items', $languages);
		$this->assignRef('defaultLanguage', $defaultLanguage);
		
		// state filter
		$lists['state']	= JHTML::_('grid.state',  $filter_state );

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		// search filter
		$lists['search']= $search;

		$this->assignRef('user',		JFactory::getUser());
		$this->assignRef('lists',		$lists);
		
		JHTML::_('behavior.tooltip');
		parent::display($tpl);
	}

	/**
	 * Method displaying the config traslation layout
	 */
	function translateConfig($tpl = null) {

		$document =& JFactory::getDocument();
		// this already includes administrator
		$livesite = JURI::base();
		$document->addStyleSheet($livesite.'components/com_joomfish/assets/css/joomfish.css');

		$document->setTitle(JText::_('JOOMFISH_TITLE') . ' :: ' .JText::_('Language Title'));
		
		// hide the sub menu
		JRequest::setVar('hidemainmenu',1);		
		
		// Set toolbar items for the page
		JToolBarHelper::title( JText::_('JOOMFISH_TITLE') .' :: '. JText::_( 'Translate Configuration' ), 'fish' );
		JToolBarHelper::save('languages.saveTranslateConfig');
		JToolBarHelper::cancel('languages.show');
		JToolBarHelper::help( 'screen.languages', true);

		parent::display($tpl);		
	}
	/**
	 * Method to determine the correct image path for language flags.
	 * The works as the standard JHTMLImage method except that it uses always the live site basic as URL
	 *
	 * @param unknown_type $language
	 * @param unknown_type $altFile
	 * @param unknown_type $altFolder
	 * @param unknown_type $alt
	 * @param unknown_type $attribs
	 * @return unknown
	 */
	function languageImage($language, $folder, $altFile=NULL, $altFolder='/images/M_images/', $alt=NULL, $attribs = null) {
		static $paths;
		global $mainframe;

		$file = '';
		if(!empty($language->image)) {
			//$file = 'flags/' . JFile::makeSafe(  $language->image);
			$file =  $language->image;
			$folder = "/images/";
		} elseif (!empty( $language->shortcode)) {
			$file = 'flags/' . $language->shortcode . '.gif';
		}

		if (!$paths) {
			$paths = array();
		}

		if (is_array( $attribs )) {
			$attribs = JArrayHelper::toString( $attribs );
		}

		$cur_template = $mainframe->getTemplate();

		if ( $altFile )
		{
			// $param allows for an alternative file to be used
			$src = $altFolder . $altFile;
		}
		else if ( $altFile == -1 )
		{
			// Comes from an image list param field with 'Do not use' selected
			return '';
		} else {
			$path = JPATH_SITE .'/templates/'. $cur_template .'/images/'. $file;
			if (!isset( $paths[$path] ))
			{
				if ( file_exists( JPATH_SITE .'/templates/'. $cur_template .'/images/'. $file ) ) {
					$paths[$path] = 'templates/'. $cur_template .'/images/'. $file;
				} else {
					// outputs only path to image
					$paths[$path] = $folder . $file;
				}
			}
			$src = $paths[$path];
		}

		if (substr($src, 0, 1 ) == "/") {
			$src = substr_replace($src, '', 0, 1);
		}

		return '<img src="'. JURI::root() . $src .'" alt="'. html_entity_decode( $alt ) .'" '.$attribs.' />';
	}
	
}
?>