<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="resultContent"><?php echo $this->get('htmlResult');?></div>
<script language="javascript" type="text/javascript">
resultDiv = document.getElementById("resultContent");
window.parent.updateResultDiv( resultDiv, 'div' );
<?php
if( $this->get('reload') != '' ) {
	echo "document.location.href='" .$this->get('reload'). "'";
}
?>
</script>