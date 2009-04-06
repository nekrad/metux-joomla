<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
echo $this->item->event->beforeDisplayContent; 
?>
<table xclass="contentpaneopen<?php echo $this->item->params->get( 'pageclass_sfx' ); ?>">
    <tr>
	<td valign="top">
<?php if ($this->item->params->get('image')) { ?>
	    <img width="200px" src="<?php echo $this->item->params->get('image'); ?>">
<?php } ?>
	</td>
	<td valign="top" colspan="2">
          <?php echo $this->item->text; ?>
	</td>
    </tr>
</table>
<hr>
