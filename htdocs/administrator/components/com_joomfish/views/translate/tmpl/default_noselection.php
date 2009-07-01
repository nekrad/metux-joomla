<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
?>
<form action="index.php" method="post" name="adminForm">
	<table>
		<tr>
			<td width="100%">
			</td>
			<td nowrap="nowrap">
				<?php echo JText::_('Languages'). ':<br/>' .$this->langlist;?>
			</td>
			<td nowrap="nowrap">
				<?php echo JText::_('Content elements'). ':<br/>' .$this->clist; ?>
			</td>
		</tr>
	</table>
  <table class="adminlist" cellspacing="1">
  <thead>
    <tr>
      <th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows); ?>);" /></th>
      <th class="title" width="20%" align="left"  nowrap="nowrap"><?php echo JText::_('TITLE');?></th>
      <th width="10%" align="left" nowrap="nowrap"><?php echo JText::_('Language');?></th>
      <th width="20%" align="left" nowrap="nowrap"><?php echo JText::_('TITLE_TRANSLATION');?></th>
      <th width="15%" align="left" nowrap="nowrap"><?php echo JText::_('TITLE_DATECHANGED');?></th>
      <th width="15%" nowrap="nowrap" align="center"><?php echo JText::_('TITLE_STATE');?></th>
      <th align="center" nowrap="nowrap"><?php echo JText::_('TITLE_PUBLISHED');?></th>
    </tr>
    </thead>
    <tfoot>
        <tr>
    	  <td align="center" colspan="7">
			<?php echo $this->pageNav->getListFooter(); ?>
		  </td>
		</tr>
    </tfoot>
    <tbody>
		<tr><td colspan="8"><p><?php echo JText::_('NOELEMENT_SELECTED');?></p></td></tr>
	</tbody>
	</table>

	<input type="hidden" name="option" value="com_joomfish" />
	<input type="hidden" name="task" value="translate.show" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>