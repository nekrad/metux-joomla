<?php

class jmcloud_admin_serversettings
{
   /**
    * show server settings
    */
    function show($option)
    {
	global $config_file_status;

	?>
	<form action="index2.php" method="post" name="adminForm">
  	    <div style="border: solid 1px #333;margin:5px 0 5px 0;padding:5px;text-align:left;font-weight:bold;"><?php echo $config_file_status; ?></div>
  	    <div>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" class="adminform">
		    <tr>
			<th colspan="3" align="left"><h3> MediaCloud Server </h3></th>
		    </tr>
		    <tr>
			<td align="left" valign="top" width="20%" style="font-weight: bold">
			    Prefix
			</td>
			<td align="left" valign="top" width="20%">
			    <input type="text" readonly="1" name="server_prefix" value="<?php echo MEDIACLOUD_SRV_PREFIX ?>" size="60">
			</td>
		    </tr>
		    <tr>
			<td align="left" valign="top" width="20%" style="font-weight: bold">
			    Namespace
			</td>
			<td align="left" valign="top" width="20%">
			    <input type="text" readonly="1" name="server_namespace" value="<?php echo MEDIACLOUD_SRV_NAMESPACE ?>" size="60">
			</td>
			<td align="left" valign="top" width="60%"> </td>
		    </tr>
		    <tr>
			<td align="left" valign="top" width="20%" style="font-weight: bold">
			    Password
			</td>
			<td>
			    <input type="text" readonly="1" name="server_secret" value="<?php echo MEDIACLOUD_SRV_SECRET ?>" size="60">
			</td>
		    </tr>
		</table>
	    </div>
	    <input type="hidden" name="boxchecked" value="0" />
	    <input type="hidden" name="option" value="<?php echo $option ?>" />
	    <input type="hidden" name="task" value="serversettings" />
	    <input type="hidden" name="hidemainmenu" value="0">
	</form>
	<?php
    }
    
    function save($option)
    {
	print "Serversettings save not implemented yet";
    }
}
