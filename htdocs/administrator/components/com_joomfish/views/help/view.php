<?php
/**
* @version		$Id: mergeCopyTarget8152.tmp 1080 2008-08-15 15:24:03Z akede $
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

jimport( 'joomla.application.component.view');
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
class HelpViewHelp extends JoomfishViewDefault
{
	/**
	 * Control Panel display function
	 *
	 * @param template $tpl
	 */
	function display($tpl = null)
	{
		$document =& JFactory::getDocument();
		$document->setTitle(JText::_('JOOMFISH_TITLE') . ' :: ' .JText::_('HELP AND HOWTO'));
		
		// Set toolbar items for the page
		JToolBarHelper::title( JText::_( 'HELP AND HOWTO' ), 'help' );
		JToolBarHelper::custom( 'cpanel.show', 'joomfish', 'joomfish', JText::_( 'CONTROL PANEL' ), false );
		
		JSubMenuHelper::addEntry(JText::_('Control Panel'), 'index2.php?option=com_joomfish');
		JSubMenuHelper::addEntry(JText::_('Translation'), 'index2.php?option=com_joomfish&amp;task=translate.overview');
		JSubMenuHelper::addEntry(JText::_('Orphans'), 'index2.php?option=com_joomfish&amp;task=translate.orphans');
		JSubMenuHelper::addEntry(JText::_('Manage Translations'), 'index2.php?option=com_joomfish&amp;task=manage.overview', false);
		JSubMenuHelper::addEntry(JText::_('Statistics'), 'index2.php?option=com_joomfish&amp;task=statistics.overview', false);
		JSubMenuHelper::addEntry(JText::_('Language Configuration'), 'index2.php?option=com_joomfish&amp;task=languages.show', false);
		JSubMenuHelper::addEntry(JText::_('Content elements'), 'index2.php?option=com_joomfish&amp;task=elements.show', false);
		JSubMenuHelper::addEntry(JText::_('HELP AND HOWTO'), 'index2.php?option=com_joomfish&amp;task=help.show', true);
		
		$layout = $this->getLayout();
		if (method_exists($this,$layout)){
			$this->$layout($tpl);
		}
		parent::display($tpl);
	}
	
	/**
	 * Method to show the information related to the project
	 * @access public
	 * @return void
	 */
	function information($tpl=null) {
		$document = JRequest::getVar('fileCode','');
		$this->assignRef('fileCode', $document);		
	}
	/**
	 * Show the side menu
	 *
	 */
	function _sideMenu() {
  	?>
		<img src="<?php echo JURI::root();?>administrator/components/com_joomfish/assets/images/joomfish_slogan.png" border="0" alt="<?php echo JText::_('Language Title');?>"  />
		<p><span class="contentheading"><?php echo JText::_('Related topics');?>:</span>
		<ul>
			<li><a href="http://www.joomfish.net" target="_blank"><?php echo JText::_('Official Project WebSite');?></a></li>
			<li><a href="http://www.joomfish.net/forum/" target="_blank"><?php echo JText::_('Official Project Forum');?></a></li>
			<li><a href="http://joomlacode.org/gf/project/joomfish/tracker/" target="_blank"><?php echo JText::_('Bug and Feature tracker');?></a></li>
		</ul>
		</p>
		<p><span class="contentheading"><?php echo JText::_('Documentation and Tutorials');?>:</span>
		<ul>
			<li><a href="http://www.joomfish.net/joomfish-documentation-overview.html" target="_blank"><?php echo JText::_('Online Documentation and Tutorials');?></a></li>
			<li><a href="index2.php?option=com_joomfish&amp;task=help.postinstall"><?php echo JText::_('Installation notes');?></a></li>
			<li><a href="index2.php?option=com_joomfish&amp;task=help.information&amp;fileCode=changelog"><?php echo JText::_('Changelog');?></a></li>
		</ul>
		</p>
		<p><span class="contentheading"><?php echo JText::_('License');?>:</span>
		<ul>
			<li><a href="index2.php?option=com_joomfish&amp;task=help.information&amp;fileCode=license">GPL based Think Network Open Source license</a></li>
		</ul>
		</p>
		<p><span class="contentheading"><?php echo JText::_('Additional Sites');?>:</span>
		<ul>
			<li><a href="http://www.joomla.org" target="_blank">Joomla!</a></li>
		</ul>
		</p>
  	<?php
	}
	
	function _creditsCopyright() {
		?>
		<p>
		<span class="smallgrey"><strong><?php echo JText::_('Credits');?>:</strong></span><br />
		<span class="smallgrey"><?php echo JText::_('JOOMFISH_COMMUNITY');?><br />
		Present development team:
		<ul>
			<li>Alex Kempkens (<?php
			$x = "@";
			$y="Alex";
			$z="JoomFish.net";
			$mail=$y.$x.$z;

			echo JHTML::_('email.cloak', $mail, 0);
			?>)</li>
			<li>Geraint Edwards (<?php
			$x = "@";
			$y="joomfish.credits";
			$z="copyn.plus.com";
			$mail=$y.$x.$z;

			echo JHTML::_('email.cloak', $mail, 0);
			?>)</li>
			<li>Ivo Apostolov (<?php
			$x = "@";
			$y="ivo";
			$z="joomfish.net";
			$mail=$y.$x.$z;

			echo JHTML::_('email.cloak', $mail, 0);
			?>)</li>
			<li>Robin Muilwijk</li>
		</ul>
		<br />

		Logo design by:
		<ul>
			<li>Tommy White (<?php
			$x = "@";
			$y="tommy";
			$z="tommywhite.com";
			$mail=$y.$x.$z;

			echo JHTML::_('email.cloak', $mail, 0);
			?>)</li>
		</ul>

		&nbsp;<br />
		Special thank's for testing, good suggestions & translations to:<br />
		Bernhard, Michael, Luc, Olivier, Robin, Rune, Victor, Akarawuth</span><br />

		&nbsp;<br />
		<span class="smallgrey"><strong>Contact:</strong></span><br />
		<span class="smallgrey"><a href="http://www.joomfish.net/forum" target="_blank">Joom!Fish Forum</a></span>
		<br />
		&nbsp;<br />
		<span class="smallgrey"><strong>Version:</strong></span><br />
		<?php
		$version = new JoomFishVersion();
		?>
		<span class="smallgrey"><?php echo $version->getVersion();?></span><br />
		&nbsp;<br />
		<span class="smallgrey"><strong>Copyright:</strong></span><br />
		<span class="smallgrey"><?php echo $version->getCopyright() ?> </span><a href="http://www.ThinkNetwork.com" target="_blank" class="smallgrey"><span class="smallgrey">Think Network, Munich</span></a><br />
		<span class="smallgrey">Revision: <?php echo $version->getRevision() ?></span><br />
		<a href="index2.php?option=com_joomfish&amp;task=help.information&amp;fileCode=license" class="smallgrey"><span class="smallgrey">Open Source License.</span></a>
		</p>
		<?php
	}
	
	/**
	 * Load a template file -- This is a special implementation that tries to find the files within the distribution help
	 * dir first. There localized versions of these files can be stored!
	 *
	 * @access	public
	 * @param string $tpl The name of the template source file ...
	 * automatically searches the template paths and compiles as needed.
	 * @return string The output of the the template script.
	 */
	function loadTemplate( $tpl = null)
	{
		global $mainframe, $option;

		// clear prior output
		$this->_output = null;

		$file = $this->_layout;
		// clean the file name
		$file = preg_replace('/[^A-Z0-9_\.-]/i', '', $file);

		// Get Help URL
		jimport('joomla.language.help');
		$filetofind = JHelp::createURL($file, true);		
		
		$this->_template = JPath::find(JPATH_ADMINISTRATOR, $filetofind);

		if ($this->_template != false)
		{
			// unset so as not to introduce into template scope
			unset($tpl);
			unset($file);

			// never allow a 'this' property
			if (isset($this->this)) {
				unset($this->this);
			}

			// start capturing output into a buffer
			ob_start();
			// include the requested template filename in the local scope
			// (this will execute the view logic).
			include $this->_template;

			// done with the requested template; get the buffer and
			// clear it.
			$this->_output = ob_get_contents();
			ob_end_clean();

			return $this->_output;
		}
		else {
			return parent::loadTemplate($tpl);
		}
	}
}