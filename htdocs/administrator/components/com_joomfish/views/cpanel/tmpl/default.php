<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm">
<table class="adminform">
	<tr>
		<td width="55%" valign="top">
			<div id="cpanel">
			<?php
			$link = 'index2.php?option=com_joomfish&amp;task=translate.overview';
			$this->_quickiconButton( $link, 'icon-48-translation.png', JText::_('Translation') );

			$link = 'index2.php?option=com_joomfish&amp;task=translate.orphans';
			$this->_quickiconButton( $link, 'icon-48-orphan.png', JText::_('Orphans') );

			$link = 'index2.php?option=com_joomfish&amp;task=manage.overview';
			$this->_quickiconButton( $link, 'icon-48-manage.png', JText::_('Manage Translations') );

			$link = 'index2.php?option=com_joomfish&amp;task=statistics.overview';
			$this->_quickiconButton( $link, 'icon-48-statistics.png', JText::_('Statistics') );

			echo '<div style="clear: both;" />';

			$link = 'index2.php?option=com_joomfish&amp;task=languages.show';
			$this->_quickiconButton( $link, 'icon-48-language.png', JText::_('Language Configuration') );

			$link = 'index2.php?option=com_joomfish&amp;task=elements.show';
			$this->_quickiconButton( $link, 'icon-48-extension.png', JText::_('Content elements') );

			$link = 'index2.php?option=com_joomfish&amp;task=plugin.show';
			$this->_quickiconButton( $link, 'icon-48-plugin.png', JText::_('Manage Plugins') );

			$link = 'index2.php?option=com_joomfish&amp;task=help.show';
			$this->_quickiconButton( $link, 'icon-48-help.png', JText::_('HELP AND HOWTO') );
			?>
		</div>
		</td>
		<td width="45%" valign="top">
		<div style="width: 100%">
		<?php
			$tabs	= $this->get('publishedTabs');
			$pane		=& JPane::getInstance('sliders');
			echo $pane->startPane("content-pane");
	
			foreach ($tabs as $tab) {
				$title = JText::_($tab->title);
				echo $pane->startPanel( $title, 'jfcpanel-panel-'.$tab->name );
				$renderer = 'render' .$tab->name;
				echo $this->$renderer();
				echo $pane->endPanel();
			}
	
			echo $pane->endPane();

		 ?>
		</div>
		</td>
	</tr>
</table>

<input type="hidden" name="option" value="com_joomfish" />
<input type="hidden" name="task" value="cpanel.show" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="<?php echo JUtility::getToken(); ?>" value="1" />
</form>