<?php
/**
* @version		$Id: view.html.php 1023 2008-07-11 09:45:56Z geraint $
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
 * HTML View class for the WebLinks component
 *
 * @static
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.0
 */
class StatisticsViewStatistics extends JoomfishViewDefault
{
	function display($tpl = null)
	{
		JHTML::stylesheet( 'joomfish.css', 'administrator/components/com_joomfish/assets/css/' );

		$document =& JFactory::getDocument();
		$document->setTitle(JText::_('JOOMFISH_TITLE') . ' :: ' .JText::_('TITLE_Statistics'));
		
		// Set toolbar items for the page
		JToolBarHelper::title(JText::_( 'TITLE_Statistics' ), 'statistics' );
		JToolBarHelper::custom( 'cpanel.show', 'joomfish', 'joomfish', JText::_( 'CONTROL PANEL' ), false );
		JToolBarHelper::help( 'screen.manage', true);

		JSubMenuHelper::addEntry(JText::_('Control Panel'), 'index2.php?option=com_joomfish');
		JSubMenuHelper::addEntry(JText::_('Translation'), 'index2.php?option=com_joomfish&amp;task=translate.overview');
		JSubMenuHelper::addEntry(JText::_('Orphans'), 'index2.php?option=com_joomfish&amp;task=translate.orphans');
		JSubMenuHelper::addEntry(JText::_('Manage Translations'), 'index2.php?option=com_joomfish&amp;task=manage.overview', false);
		JSubMenuHelper::addEntry(JText::_('Statistics'), 'index2.php?option=com_joomfish&amp;task=statistics.overview', true);
		JSubMenuHelper::addEntry(JText::_('Language Configuration'), 'index2.php?option=com_joomfish&amp;task=languages.show', false);
		JSubMenuHelper::addEntry(JText::_('Content elements'), 'index2.php?option=com_joomfish&amp;task=elements.show', false);
		JSubMenuHelper::addEntry(JText::_('HELP AND HOWTO'), 'index2.php?option=com_joomfish&amp;task=help.show', false);
				
		$this->panelStates	= &$this->get('PanelStates');
		$this->contentInfo	= &$this->get('ContentInfo');
		$this->publishedTabs	= &$this->get('PublishedTabs');
		
		$this->assignRef('panelStates', $this->panelStates);
		$this->assignRef('contentInfo', $this->contentInfo);
		$this->assignRef('publishedTabs', $this->publishedTabs);
		
		JHTML::_('behavior.tooltip');
		parent::display($tpl);
	}

	/**
	 * This method renders a nice status overview table from the content element files
	 *
	 * @param unknown_type $contentelements
	 */
	function renderOriginalStatusTable($originalStatus, $message='', $langCodes=null) {
		$htmlOutput = '';

		$htmlOutput = '<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">';
		$htmlOutput .= '<tr><th>' .JText::_('Content'). '</th><th>' .JText::_('table exist'). '</th><th>' .JText::_('original total'). '</th><th>' .JText::_('Orphans'). '</th>';
		if(is_array($langCodes)) {
			foreach ($langCodes as $code) {
				$htmlOutput .= '<th>' .$code. '</th>';
			}
		}
		$htmlOutput .= '</tr>';

		$ceName = '';
		foreach ($originalStatus as $statusRow ) {
			$href = 'index2.php?option=com_joomfish&amp;task=overview&amp;act=translate&amp;catid='.$statusRow['catid'];
			$htmlOutput .= '<tr>';
			$htmlOutput .= '<td><a href="' .$href. '" target="_blank">' .$statusRow['name']. '</a></td>';
			$htmlOutput .= '<td style="text-align: center;">' .($statusRow['missing_table'] ? JText::_('missing') : JText::_('valid')). '</td>';
			$htmlOutput .= '<td style="text-align: center;">' .$statusRow['total']. '</td>';
			$htmlOutput .= '<td style="text-align: center;">' .$statusRow['orphans']. '</td>';
			if(is_array($langCodes)) {
				foreach ($langCodes as $code) {
					if( array_key_exists('langentry_' .$code, $statusRow)) {
						$persentage = intval( ($statusRow['langentry_' .$code]*100) / $statusRow['total'] );
						$htmlOutput .= '<td>' .$persentage. '%</td>';
					} else {
						$htmlOutput .= '<td>&nbsp;</td>';
					}
				}
			}
			$htmlOutput .= '</tr>';
		}

		if($message!='') {
			$span = 4 + count($langCodes);
			$htmlOutput .= '<tr><td colspan="'.$span.'" class="message">' .$message. '</td></tr>';
		}
		$htmlOutput .= '</table>';

		return $htmlOutput;
	}

	/**
	 * Status table for translation checks
	 *
	 * @param array $translationStatus
	 * @return unknown
	 */
	function renderTranslationStatusTable($translationStatus, $message='') {
		$htmlOutput = '';

		$htmlOutput .= '<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">';
		$htmlOutput .= '<tr><th>' .JText::_('Content'). '</th><th>' .JText::_('language'). '</th><th>' .JText::_('translation total'). '</th><th>' .JText::_('TITLE_PUBLISHED'). '</th><th>' .JText::_('valid'). '</th><th>' .JText::_('unvalid'). '</th></tr>';

		foreach ($translationStatus as $statusRow ) {
			$href = 'index.php?option=com_joomfish&amp;task=translate.overview&amp;catid='.$statusRow['catid'].'&amp;language_id='.$statusRow['language_id'];
			$htmlOutput .= '<tr>';
			$htmlOutput .= '<td><a href="'.$href.'">' .$statusRow['content']. '</a></td>';
			$htmlOutput .= '<td>' .$statusRow['language']. '</td>';
			$htmlOutput .= '<td style="text-align: center;">' .$statusRow['total']. '</td>';
			$htmlOutput .= '<td style="text-align: center;">' .$statusRow['published']. '</td>';
			$htmlOutput .= '<td style="text-align: center;">' .$statusRow['state_valid']. '</td>';
			$htmlOutput .= '<td style="text-align: center;">' .$statusRow['state_unvalid']. '</td>';
			$htmlOutput .= '</tr>';
		}

		if($message!='') {
			$htmlOutput .= '<tr><td colspan="7" class="message">' .$message. '</td></tr>';
		}
		$htmlOutput .= '</table>';

		return $htmlOutput;
	}
}
