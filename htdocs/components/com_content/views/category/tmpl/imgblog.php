<?php // no direct access
defined('_JEXEC') or die('Restricted access');
?>
<?php if ($this->params->get('show_page_title', 1)) : ?>
<div class="componentheading<?php echo $this->params->get('pageclass_sfx');?>">
	<?php echo $this->escape($this->params->get('page_title')); ?>
</div>
<?php endif; ?>
<table class="imgblog<?php echo $this->params->get('pageclass_sfx');?>" cellpadding="0" cellspacing="0">
    <tr>
	<td valign="top">
	    <table>
	<?php
for (
    $i=0; 
    (($item =& $this->getItem($i, $this->params)) && ($item->text));
    $i++
)
{
    $items[] = & $item;
    $this->item = &$item;
#    echo $this->loadTemplate('item_tr');
}

while ($this->item = &array_pop($items))
{
    echo $this->loadTemplate('item_tr');
}
	?>
	    </table>
	</td>
    </tr>
</table>
