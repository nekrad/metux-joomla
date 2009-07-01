<?php
/**
* @version		$Id: mergeCopyTarget8155.tmp 1080 2008-08-15 15:24:03Z akede $
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

jimport('joomla.html.pane');

JLoader::import( 'views.default.view',JOOMFISH_ADMINPATH);

/**
 * HTML View class for the WebLinks component
 *
 * @static
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.0
 */
class CPanelViewCPanel extends JoomfishViewDefault
{
	/**
	 * Control Panel display function
	 *
	 * @param template $tpl
	 */
	function display($tpl = null)
	{
		
		JHTML::stylesheet( 'joomfish.css', 'administrator/components/com_joomfish/assets/css/' );

		$document =& JFactory::getDocument();
		$document->setTitle(JText::_('JOOMFISH_TITLE') . ' :: ' .JText::_('CONTROL PANEL'));
		
		// Set toolbar items for the page
		JToolBarHelper::title( JText::_('JOOMFISH_TITLE') .' :: '. JText::_( 'JOOMFISH_HEADER' ), 'fish' );
		JToolBarHelper::preferences('com_joomfish', '580', '750');
		JToolBarHelper::help( 'screen.cpanel', true);

		JSubMenuHelper::addEntry(JText::_('Control Panel'), 'index2.php?option=com_joomfish', true);
		JSubMenuHelper::addEntry(JText::_('Translation'), 'index2.php?option=com_joomfish&amp;task=translate.overview');
		JSubMenuHelper::addEntry(JText::_('Orphans'), 'index2.php?option=com_joomfish&amp;task=translate.orphans');
		JSubMenuHelper::addEntry(JText::_('Manage Translations'), 'index2.php?option=com_joomfish&amp;task=manage.overview', false);
		JSubMenuHelper::addEntry(JText::_('Statistics'), 'index2.php?option=com_joomfish&amp;task=statistics.overview', false);
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
	  * render Information module
	  */
	 function renderInformation () {
	 	$output = '';
	 	//$panelStates = $this->get('panelStates');
		$sysInfo =  $this->panelStates['system'];
		// this already includes administrator
		$live_site = JURI::base();
		
		$output = '<div style="padding: 5px;">';
		$output .= JText::_('INFORMATION_TEXT');
		$output .= JText::_('INFORMATION_CLUB_TITLE');
		$link = JText::_('INFORMATION_CLUB_LINK');
		$output .= '<a href="'.$link.'" target="_blank"><img src="'.JURI::root().'/administrator/components/com_joomfish/assets/images/joomfishclub.png" border="0" alt="join the Joom!Fish Club" align="right" /></a>';
		$output .= JText::sprintf('INFORMATION_CLUB', $sysInfo['translations'], sprintf('%01.2f', intval($sysInfo['translations']) *0.10));
		
		$output .= JText::_('INFORMATION_SERVICE_TITLE');
		$output .= JText::_('INFORMATION_SERVICE');
		$output .= '</div>';
		//$output .= JText::sprintf ('INFORMATION_DONATE', intval($sysInfo['translations']) *0.10). '<br />';
		
		return $output;
	 }
	 
	 /**
	  * render News feed from Joom!Fish portal
	  */
	 function renderJFNews() {
	 	
	 	$output = '';

		//  get RSS parsed object
		$options = array();
		$options['rssUrl']		= 'http://www.joomfish.net/news?format=feed&type=rss';
		$options['cache_time']	= 86400;

		$rssDoc =& JFactory::getXMLparser('RSS', $options);

		if ( $rssDoc == false ) {
			$output = JText::_('Error: Feed not retrieved');
		} else {	
			// channel header and link
			$title 	= $rssDoc->get_title();
			$link	= $rssDoc->get_link();
			
			$output = '<table class="adminlist">';
			$output .= '<tr><th colspan="3"><a href="'.$link.'" target="_blank">'.JText::_($title) .'</th></tr>';
			$output .= '<tr><td colspan="3">'.JText::_('NEWS_INTRODUCTION').'</td></tr>';
			
			$items = array_slice($rssDoc->get_items(), 0, 3);
			$numItems = count($items);
            if($numItems == 0) {
            	$output .= '<tr><th>' .JText::_('No news items found'). '</th></tr>';
            } else {
            	$k = 0;
                for( $j = 0; $j < $numItems; $j++ ) {
                    $item = $items[$j];
                	$output .= '<tr><td class="row' .$k. '">';
                	$output .= '<a href="' .$item->get_link(). '" target="_blank">' .$item->get_title(). '</a>';
					if($item->get_description()) {
	                	$description = $this->limitText($item->get_description(), 50);
						$output .= '<br />' .$description;
					}
                	$output .= '</td></tr>';
                }
            }
			$k = 1 - $k;
						
			$output .= '</table>';
		}	 	
	 	return $output;
	 }
	 
	 /**
	  * render content state information
	  */
	 function renderContentState() {
	 	$joomFishManager =&  JoomFishManager::getInstance();
	 	$output = '';
		$alertContent = false;
		if( array_key_exists('unpublished', $this->contentInfo) && is_array($this->contentInfo['unpublished']) ) {
			$alertContent = true;
		}		
		ob_start();
		?>
		<table class="adminlist" border="1">
			<tr>
				<th><?php echo JText::_("UNPUBLISHED CONTENT ELEMENTS");?></th>
				<th style="text-align: center;"><?php echo JText::_("Language");?></th>
				<th style="text-align: center;"><?php echo JText::_("Publish");?></th>
			</tr>
			<?php
			$k=0;
			if( $alertContent ) {
				$curReftable = '';
				foreach ($this->contentInfo['unpublished'] as $ceInfo ) {
					$contentElement = $joomFishManager->getContentElement( $ceInfo['catid'] );

					// Trap for content elements that may have been removed
					if (is_null($contentElement)){
						$name = "<span style='font-style:italic'>".JText::sprintf("CONTENT_ELEMENT_MISSING",$ceInfo["reference_table"])."</span>";
					}
					else {
						$name = $contentElement->Name;
					}
					if ($ceInfo["reference_table"] != $curReftable){
						$curReftable = $ceInfo["reference_table"];
						$k=0;
						?>
			<tr><td colspan="3"><strong><?php echo $name;?></strong></td></tr>
						<?php
					}

					JLoader::import( 'models.ContentObject',JOOMFISH_ADMINPATH);
					$contentObject = new ContentObject( $ceInfo['language_id'], $contentElement );
					$contentObject->loadFromContentID($ceInfo['reference_id']);
					$link = 'index2.php?option=com_joomfish&amp;task=translate.edit&amp;&amp;catid=' .$ceInfo['catid']. '&cid[]=0|' .$ceInfo['reference_id'].'|'.$ceInfo['language_id'];
					$hrefEdit = "<a href='".$link."'>".$contentObject->title. "</a>";

					$link = 'index2.php?option=com_joomfish&amp;task=translate.publish&amp;catid=' .$ceInfo['catid']. '&cid[]=0|' .$ceInfo['reference_id'].'|'.$ceInfo['language_id'];
					$hrefPublish = '<a href="'.$link.'"><img src="images/publish_x.png" width="12" height="12" border="0" alt="" /></a>';
					?>
			<tr class="row<?php echo $k;?>">
				<td align="left"><?php echo $hrefEdit;?></td>
				<td style="text-align: center;"><?php echo $ceInfo['language'];?></td>
					<td style="text-align: center;"><?php echo $hrefPublish;?></td>
			</tr>
					<?php
					$k = 1 - $k;
				}
			} else {
					?>
			<tr class="row0">
				<td colspan="3"><?php echo JText::_("No unpublished translations found");?></td>
			</tr>
					<?php
			}
			?>
		</table>
		<?php
		$output .= ob_get_clean();
	 	return $output;
	 }
	 
	 /**
	  * render system state information
	  */
	 function renderSystemState() {
	 	$output = '';
		$stateGroups =  $this->panelStates;
		ob_start();
		?>
		<table class="adminlist">
			<?php
			foreach ($stateGroups as $key=>$stateRow) {
				if (!is_array($stateRow) || count($stateRow)==0){
					continue;
				}
				?>
			<tr>
				<th colspan="3"><?php echo JText::_($key. ' state');?></th>
			</tr>
				<?php
				$k=0;
				foreach ($stateRow as $row) {
					if (!isset($row->link ) ) continue;
					?>
			<tr class="row<?php echo $k;?>">
				<td><?php
					if( $row->link != '' ) {
						$row->description = '<a href="' .$row->link. '">' .$row->description. '</a>';
					}
					echo $row->description;
				?></td>
				<td colspan="2"><?php echo $row->resultText;?></td>
			</tr>
					<?php
					$k = 1 - $k;
				}
			}
			?>
			</table>
		<?php
		$output .= ob_get_clean();
	 	return $output;
	 }

	function limitText($text, $wordcount)
	{
		if(!$wordcount) {
			return $text;
		}

		$texts = explode( ' ', $text );
		$count = count( $texts );

		if ( $count > $wordcount )
		{
			$text = '';
			for( $i=0; $i < $wordcount; $i++ ) {
				$text .= ' '. $texts[$i];
			}
			$text .= '...';
		}

		return $text;
	}
		 
}