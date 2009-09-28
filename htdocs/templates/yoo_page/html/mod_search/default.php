<?php
/**
 * YOOsearch
 *
 * @author		yootheme.com
 * @copyright	Copyright (C) 2007 YOOtheme Ltd. & Co. KG. All rights reserved.
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="post">
	<div id="yoo-search">
		<?php
		$button				= $params->get('button', '');
		$imagebutton		= $params->get('imagebutton', '');
		$button_pos			= $params->get('button_pos', 'left');
		$button_text		= $params->get('button_text', JText::_('Search'));
		$width				= intval($params->get('width', 20));
		$text				= $params->get('text', JText::_('search...'));
		$set_Itemid			= intval($params->get('set_itemid', 0));
		$moduleclass_sfx	= $params->get('moduleclass_sfx', '');
		?>
		
		<input name="searchword" maxlength="20" alt="<?php echo $button_text; ?>" type="text" size="<?php echo $width; ?>" value="<?php echo $text; ?>"  onblur="if(this.value=='') this.value='<?php echo $text; ?>';" onfocus="if(this.value=='<?php echo $text; ?>') this.value='';" />

		<?php if ($button) { ?>
		<button value="<?php if ( !$imagebutton ) { echo $button_text; } ?>" name="Submit" type="submit"><?php if ( !$imagebutton ) { echo $button_text; } ?></button>
		<?php } ?>
		
	</div>

	<input type="hidden" name="task"   value="search" />
	<input type="hidden" name="option" value="com_search" />
</form>