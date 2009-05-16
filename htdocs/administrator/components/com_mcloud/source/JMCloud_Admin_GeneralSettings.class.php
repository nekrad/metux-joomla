<?php

class jmcloud_admin_generalsettings
{
   /**
    * show general settings
    */
    function show($option)
    {
	return;

  	if (is_writable(JMCLOUD_ADMIN_PATH.'/config.mcloud.php'))
  	    $config_file_status = "<span style=\"color:#458B00;\"> writable </span>.";
	else
  	    $config_file_status = "<span style=\"color:#ff0000;\"> not writable </span>. (".JMCLOUD_ADMIN_PATH."/config.mcloud.php)";

	?>
	<form action="index2.php" method="post" name="adminForm">
  	<?php
  	?>
  		<div style="border: solid 1px #333;margin:5px 0 5px 0;padding:5px;text-align:left;font-weight:bold;"><?php echo $config_file_status; ?></div>
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="option" value="<?echo $option?>" />
		<input type="hidden" name="task" value="generalsettings" />
		<input type="hidden" name="hidemainmenu" value="0">
		</form>
		<div style="clear:both;"></div>
	<?php
    }
	
    function save($option)
    {
	mosRedirect("index2.php?option=$option&task=generalsettings", "Save not implemented yet");
    }
}
