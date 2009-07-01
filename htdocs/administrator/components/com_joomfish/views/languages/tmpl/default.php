<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm">
<table class="adminform">
    <tr>
      <td width="30%" align="left" valign="top"><strong><?php echo JText::_('Default Language'); ?></strong></td>
      <td align="left" valign="top"><?php echo JText::_('DEFAULT_LANGUAGE_HELP'); ?></td>
    </tr>
    <tr>
      <td width="30%" align="left" valign="top"><strong><?php echo JText::_('Component Admin Interface Language'); ?></strong></td>
      <td><?php echo JText::_('LANGUAGE_HELP'); ?></td>
    <tr>
</table>
<div id="editcell">
	<table class="adminlist">
	<thead>
		<tr>
			<th width="20">
			</th>
			<th class="title">
				<?php echo $this->fetchTooltip(JText::_('TITLE_NAME' ), JText::_('NAME_HELP')); ?>
			</th>
			<th width="5%" class="title" nowrap="nowrap">
				<?php echo $this->fetchTooltip(JText::_('TITLE_ACTIVE' ), JText::_('ACTIVE_HELP')); ?>
			</th>
			<th width="5%" class="title" nowrap="nowrap">
				<?php echo $this->fetchTooltip(JText::_('TITLE_ISOCODE' ), JText::_('ISOCODE_HELP')); ?>
			</th>
			<th width="10%" class="title" nowrap="nowrap">
				<?php echo $this->fetchTooltip(JText::_('TITLE_SHORTCODE' ), JText::_('SHORTCODE_HELP')); ?>
			</th>
			<th width="10%" class="title" nowrap="nowrap">
				<?php echo $this->fetchTooltip(JText::_('TITLE_JOOMLA' ), JText::_('JOOMLACODE_HELP')); ?>
			</th>
			<th width="10%" class="title">
				<?php echo $this->fetchTooltip(JText::_('TITLE_FALLBACK' ), JText::_('FALLBACK_HELP')); ?>
			</th>
			<th width="15%" class="title">
				<?php echo $this->fetchTooltip(JText::_('TITLE_IMAGE' ), JText::_('IMAGES_DIR_HELP')); ?>
			</th>
			<th width="5%" class="title" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',  'Order', 'l.ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th class="title">
				<?php echo $this->fetchTooltip(JText::_('TITLE_CONFIG' ), JText::_('CONFIG_HELP')); ?>
			</th>
		</tr>
	</thead>
	<tfoot></tfoot>
	<tbody>
		<?php
		$k=0;
		$i=0;
		reset($this->items);
		$model = $this->getModel('languages');
		$siteLang = $model->getDefaultLanguage();		
		foreach ($this->items as $language ) { ?>
		<tr class="<?php echo 'row' . $k; ?>">
	      	<td align="center">
      			<input type="hidden" name="cid[]" value="<?php echo $language->id; ?>" />
				<?php 
				if ( $siteLang != $language->code ) {?>
      			<input type="checkbox" name="checkboxid[]" id="cb<?php echo $language->id; ?>" value="1" onclick="isChecked(this.checked);" />
	      		<?php }?>
	      	</td>
			<td><input type="text" name="name[]" value="<?php echo $language->name; ?>" size="30" maxlength="100" /></td>
			<td align="center"><input type="checkbox" name="active[]"<?php echo $language->active==1 ? ' checked' : ''; ?> value="<?php echo $language->id; ?>" /></td>
			<td><?php echo substr($language->iso, 0, strpos($language->iso, ','));?><input type="hidden" name="iso[]" value="<?php echo $language->iso; ?>" /></td>
			<td><input type="text" name="shortCode[]" value="<?php echo $language->shortcode; ?>" size="10" maxlength="10" /></td>
			<td><input type="text" name="code[]" value="<?php echo $language->code; ?>" size="13" maxlength="20" /></td>
			<td><input type="text" name="fallbackCode[]" value="<?php echo $language->fallback_code; ?>" size="10" maxlength="20" /></td>
			<td nowrap="nowrap">
	      		<input type="text" name="image[]" value="<?php echo $language->image; ?>" size="30" />
	      		<?php echo $this->languageImage($language, 'components/com_joomfish/images/', null, '/images/M_images/', $language->name); ?>
			</td>
	      <td><input type="text" name="order[]" value="<?php echo $language->ordering; ?>" size="5" maxlength="5" /></td>
	      <td align="center"><input type="hidden" name="params[]" value="<?php echo $language->params; ?>" />
	      	<a href="<?php echo JRoute::_("index.php?option=com_joomfish&amp;task=languages.translateConfig&amp;cid[]=".$language->id);?>"><?php echo JHTML::_('image.administrator', 'menu/icon-16-config.png', '/images/', null, null, JText::_("EDIT"));?></a>
		  </td>
		      <?php
		      $k = 1 - $k;
		      $i++;
		}?>
		</tr>
	</tbody>
	</table>

<input type="hidden" name="option" value="com_joomfish" />
<input type="hidden" name="task" value="languages.show" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</div>
</form>