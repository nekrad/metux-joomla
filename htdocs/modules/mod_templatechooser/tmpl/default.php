<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<div class="templatechooser">
<?php
$onchange = "";
if ($show_preview) {
	$onchange = "showimage()";


?>

<img src="<?php echo "templates/$cur_template/template_thumbnail.png";?>" name="preview" border="1" width="<?php echo $preview_width;?>" height="<?php echo $preview_height;?>" alt="<?php echo $cur_template; ?>" />
<script language='JavaScript1.2' type='text/javascript'>
<!--
	function showimage() {
		//if (!document.images) return;
		document.images.preview.src = 'templates/' + getSelectedValue( 'templateform', 'mod_change_template' ) + '/template_thumbnail.png';
	}
	function getSelectedValue( frmName, srcListName ) {
		var form = eval( 'document.' + frmName );
		var srcList = eval( 'form.' + srcListName );

		i = srcList.selectedIndex;
		if (i != null && i > -1) {
			return srcList.options[i].value;
		} else {
			return null;
		}
	}
-->
</script>
<?php
}
?>
<form  name="templateform" method="post" action="">
	<input type="hidden" name="templatechooser_kickback" value="<?php echo htmlentities($_SERVER['REQUEST_URI']);?>">
	<?php 
        $selectattr = " class=\"button\" onchange=\"$onchange\""; 
	echo JHTML::_('select.genericlist', $darray, 'mod_change_template', $selectattr,'value', 'text', $cur_template );
	?>
	<input class="button" type="submit" value="<?php echo JText::_('Select');?>" />
</form>
</div>