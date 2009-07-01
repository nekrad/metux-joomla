<form action="index.php" method="post" name="adminForm">
	<table class="adminlist" cellspacing="1">
		<thead>
		    <tr>
		      <th width="20" nowrap>&nbsp;</th>
		      <th class="title" width="35%" align="left"><?php echo JText::_('TITLE_NAME');?></th>
		      <th width="15%" align="left"><?php echo JText::_('TITLE_AUTHOR');?></th>
		      <th width="15%" nowrap="nowrap" align="left"><?php echo JText::_('TITLE_VERSION');?></th>
		      <th nowrap="nowrap" align="left"><?php echo JText::_('TITLE_DESCRIPTION');?></th>
		    </tr>
	    </thead>
		<tfoot>
		    <tr>
		      <td align="center" colspan="5">
				<?php echo $this->pageNav->getListFooter(); ?>
			  </td>
		    </tr>
	    </tfoot>
	    <tbody>
		    <?php
		    $elements = $this->joomfishManager->getContentElements();
		    $k=0;
		    $i=0;
		    $element_values = array_values($elements);
		    for ( $i=$this->pageNav->limitstart; $i<$this->pageNav->limitstart + $this->pageNav->limit && $i<$this->pageNav->total; $i++ ) {
		    	$element = $element_values[$i];
		    	$key = $element->referenceInformation['tablename'];
						?>
		    <tr class="<?php echo "row$k"; ?>">
		      <td width="20">
		        <?php		if ($element->checked_out && $element->checked_out != $user->id) { ?>
		        &nbsp;
		        <?php		} else { ?>
		        <input type="radio" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $key; ?>" onclick="isChecked(this.checked);" />
		        <?php		} ?>
		      </td>
		      <td>
		      	<a href="#detail" onclick="return listItemTask('cb<?php echo $i;?>','elements.detail')"><?php echo $element->Name; ?></a>
					</td>
		      <td><?php echo $element->Author ? $element->Author : '&nbsp;'; ?></td>
		      <td><?php echo $element->Version ? $element->Version : '&nbsp;'; ?></td>
		      <td><?php echo $element->Description ? $element->Description : '&nbsp;'; ?></td>
						<?php
						$k = 1 - $k;
		    }
				?>
			</tr>
		</tbody>
	</table>
	<input type="hidden" name="option" value="com_joomfish" />
	<input type="hidden" name="task" value="elements.show" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>