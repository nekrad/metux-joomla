<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

/**
	 * show the Orphan translations
	 *
	 * @param array $rows
	 * @param array $catid	category id's
	 */
$rows = $this->rows;
global  $act,  $option;
$user =& JFactory::getUser();
$db =& JFactory::getDBO();

$this->_JoomlaHeader("Orphan Detail");
         ?>
  <input type="hidden" name="cid[]" value="<?php echo $rows[0]->id."|".$rows[0]->reference_id."|".$rows[0]->language_id; ?>"/>
   <input type="hidden" name="catid" value="<?php echo $catid;?>" />
   <table width="100%" border="1" cellpadding="4" cellspacing="2" class="adminForm">
	<tr align="center" valign="middle">
	      <th width="10%" align="left" valign="top"><?php echo JText::_('DBFIELDLABLE');?></th>
	      <th width="12%" align="left" valign="top"><?php echo JText::_('Original');?></th>
	      <th width="78%" align="left" valign="top"><?php echo JText::_('Translation');?></th>
        </tr>
        <?php
        $style1="style='background-color:rgb(241,243,245)'";
        $style2="style='background-color:rgb(255,228,196)'";
        $style=$style1;
        ?>
		<tr align="center" valign="middle" <?php echo $style; ?>>
	      <td align="left" valign="top"><?php echo "Debug Info";?></td>
	      <td colspan="2" align="left" valign="top"><?php echo "Original Table:<b>".$rows[0]->reference_table."</b> === Orginal Id: <b>".$rows[0]->reference_id."</b>";?></td>
        </tr>
        <?php
        foreach ($rows as $row) {
        	$style=$style==$style1?$style2:$style1;
		?>
        <tr align="center" valign="middle" <?php echo $style; ?>>
	      <td align="left" valign="top"><?php echo $row->reference_field;?></td>
	      <td align="left" valign="top"><?php echo is_null($row->original_text)?$row->original_value:$row->original_text;?></td>
	      <td align="left" valign="top"><?php echo $row->value;?></td>
	    </tr>
	    <?php
        }
	    ?>
   </table>

<?php
$this->_JoomlaFooter('translate.orphandetail', $act, $option);
