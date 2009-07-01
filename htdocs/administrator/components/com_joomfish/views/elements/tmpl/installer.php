<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

/**
 * shows the element installer dialog
 */
global $option;
?>
<form enctype="multipart/form-data" action="index2.php" method="post" name="filename" class="adminForm">
<table class="adminheading">
<tr>
	<th class="install"><?php echo JText::_('Install');?> <?php echo JText::_('Content Elements');?></th>
</tr>
</table>
<table class="adminform">
<tr>
	<th><?php echo JText::_('Upload XML file');?></th>
</tr>
<tr>
	<td align="left"><?php echo JText::_('File name');?>:
	<input class="text_area" name="userfile" type="file" size="70"/>
	<input class="button" type="submit" value="<?php echo JText::_('Upload file and install');?>" />
	</td>
</tr>
</table>

<input type="hidden" name="task" value="elements.uploadfile"/>
<input type="hidden" name="option" value="com_joomfish"/>
</form>
<p>&nbsp;</p>
<?php if( $this->cElements != null ) { ?>
<form action="index2.php" method="post" name="adminForm">
	<table class="adminheading">
	<tr>
		<th class="install"><?php echo JText::_('Content Elements');?></th>
	</tr>
	</table>

	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
    <tr>
      <th width="20" nowrap>&nbsp;</th>
      <th class="title" width="35%" align="left"><?php echo JText::_('TITLE_NAME');?></th>
      <th width="15%" align="left"><?php echo JText::_('TITLE_AUTHOR');?></th>
      <th width="15%" nowrap="nowrap" align="left"><?php echo JText::_('TITLE_VERSION');?></th>
      <th nowrap="nowrap" align="left"><?php echo JText::_('TITLE_DESCRIPTION');?></th>
    </tr>
	<?php
	$k=0;
	$i=0;
	foreach (array_values($this->cElements) as $element ) {
		$key = $element->referenceInformation['tablename'];
				?>
    <tr class="<?php echo "row$k"; ?>">
      <td width="20">
        <?php		if ($element->checked_out && $element->checked_out != $user->id) { ?>
        &nbsp;
        <?php		} else { ?>
		<input type="radio" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $key; ?>" onclick="isChecked(this.checked);">
        <?php		} ?>
      </td>
      <td><?php echo $element->Name; ?></td>
      <td><?php echo $element->Author ? $element->Author : '&nbsp;'; ?></td>
      <td><?php echo $element->Version ? $element->Version : '&nbsp;'; ?></td>
      <td><?php echo $element->Description ? $element->Description : '&nbsp;'; ?></td>
     </tr>
		<?php
		$k = 1 - $k;
		$i++;
	}
} else {
	?>
	<tr><td class="small">
	There are no custom elements installed
	</td></tr>
	<?php
}
?>
</table>
<input type="hidden" name="task" value="elements.uploadfile"/>
<input type="hidden" name="option" value="com_joomfish"/>
<input type="hidden" name="boxchecked" value="0" />
</form>