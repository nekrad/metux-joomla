<?php defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="post" name="adminForm">
<input type="hidden" name="lang_id" value="<?php echo $this->language->id;?>" />
<?php
foreach ($this->jf_siteconfig as $groupname=>$group) {
 	?>
<fieldset class="adminform"   >
	<legend><?php echo JText::_( $groupname ); ?></legend>
	<table class="adminlist" cellspacing="1">
		<tbody>
			<tr>
				<th class="title" align="center"><?php echo JText::_("Field");?></th>
				<th class="title" align="center"><?php echo JText::_("Original");?></th>
				<th class="title" align="center"><?php echo JText::_("Translation");?></th>				
			</tr>
		<?php
		foreach ($group as $field=>$data) {
			?>
			<tr>
				<td valign="top" class="key" style="font-weight:bold;width:150px;">
					<span class="editlinktip hasTip" title="<?php echo JText::_( $data[0] )."::".JText::_( $data[1] ); ?>">
						<?php echo JText::_(  $data[0]); ?>
					</span>
				</td>
				<td valign="top"  style="width:300px;">
				<?php echo $this->jconf->$field; ?>
				</td>
				<td>
					<?php 
					if ($data[2]=="text") { ?>
					<input class="text_area" type="text" size="80" name="trans_<?php echo $field;?>" value="<?php echo  $this->translations->get($field,""); ?>" />
					<?php } else {?>
					<textarea class="text_area" cols="60" rows="2" name="trans_<?php echo $field;?>"><?php echo $this->translations->get($field,""); ?></textarea>
					<?php }?>
					
				</td>
			</tr>
			<?php
		}
		?>
		</tbody>	
	</table>
</fieldset>
 	<?php
 } 
?>

<fieldset class="adminform"   >
	<legend><?php echo JText::_( "Joomfish Configuration"); ?></legend>
	<table class="adminlist" cellspacing="1">
		<tbody>
			<tr>
				<th class="title" align="center"><?php echo JText::_("Field");?></th>
				<th class="title" align="center"><?php echo JText::_("Original");?></th>
				<th class="title" align="center"><?php echo JText::_("Translation");?></th>				
			</tr>
			<tr>
				<td valign="top" class="key" style="font-weight:bold;width:150px;">
					<span class="editlinktip hasTip" title="<?php echo JText::_( "Placeholder" )."::".JText::_( "TRANS_DEFAULT_HELP"); ?>">
						<?php echo JText::_( "Placeholder"); ?>
					</span>
				</td>
				<td valign="top"  style="width:300px;">
				<?php echo $this->defaulttext; ?>
				</td>
				<td>
					<textarea class="text_area" cols="60" rows="2" name="trans_defaulttext"><?php echo $this->trans_defaulttext; ?></textarea>				
				</td>
			</tr>
		</tbody>	
	</table>
</fieldset>

<input type="hidden" name="option" value="com_joomfish" />
<input type="hidden" name="task" value="languages.translateConfig" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>