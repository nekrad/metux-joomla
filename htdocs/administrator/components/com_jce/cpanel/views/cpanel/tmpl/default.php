<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
	JToolBarHelper::title( JText::_( 'JCE Administration' ), 'cpanel.png' );
	jceToolbarHelper::help( 'cpanel' );		
?>
<table class="adminform">
    <tr>
        <td width="55%" valign="top">
		<?php foreach ($this->icons as $icon) {
			echo JModuleHelper::renderModule( $icon );
		}?>
        </td>
        <td width="45%" valign="top">
		<?php 
		echo $this->pane->startPane("content-pane");

		foreach ($this->modules as $module) {
			$title = $module->title ;
			echo $this->pane->startPanel( $title, 'cpanel-panel-'.$module->name );
			echo JModuleHelper::renderModule( $module );
			echo $this->pane->endPanel();
		}
		echo $this->pane->endPane();?>
        </td>
    </tr>
</table>