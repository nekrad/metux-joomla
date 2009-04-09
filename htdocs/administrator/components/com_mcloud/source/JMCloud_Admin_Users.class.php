<?php

class jmcloud_admin_users
{
	function showusers($option)
	{
		global $remoteclient;
		$users = $remoteclient->queryUsers(array());
		print "
    <table width=\"100%\" class=\"adminlist\">
	<tr>
	    <th> Name </th>
	    <th align=\"right\"> Speicher-Verbrauch </th>		
	    <th align=\"right\"> Speicher-Limit </th>
	</tr>
";
		foreach($users{'records'} as $uwalk => $ucur)
		{
		    $editurl = 'index2.php?option='.$option.'&task=edituser&user_ns='.$ucur{'namespace'}.'&user_name='.$ucur{'username'};
		    print "
	<tr>
	    <td> (".$ucur{'namespace'}.") <a href=\"$editurl\">".$ucur{'username'}."</a></td>
	    <td align=\"right\"> ".$ucur{'space_consumed'}." bytes </td>
	    <td align=\"right\"> ".$ucur{'space_quota'}." bytes </td>
	</tr>
";				
		}
		print "
    </table>
";
	}

	/**
	* edit videos
	*/
	function edituser($option, $user_ns, $user_name)
	{
		global $remoteclient;

		$user = $remoteclient->User_GetByName($_REQUEST{'user_name'});
		print '
<form action="index2.php" method="post" name="adminForm">
    <input type="hidden" name="option"    value="'.$option.'">
    <input type="hidden" name="task"      value="saveuser">
    <input type="hidden" name="user_ns"   value="'.$user{'namespace'}.'">
    <input type="hidden" name="user_name" value="'.$user{'username'}.'">
    <table class="adminheading">
	<tr>
	    <th> Benutzer: <small> ('.$user{'namespace'}.') '.$user{'username'}.'</th>
	</tr>
    </table>

    <table width="100%">
	<tr>
	    <td valign="top">
		<table class="adminform">
		    <tr>
			<th colspan="2">
			    Einstellungen
			</th>
		    </tr>
		    <tr>
			<td>
			    Speicher-Limit <cite>(bytes)</cite>:
			</td>
			<td>
			    <input name="user_space_quota" value="'.$user{'space_quota'}.'">
			</td>
		    </tr>
		    <tr>
			<td>
			    <input type="submit" value="Speichern" />
			</td>
		    </tr>
		</table>
	    </td>
	    <td valign="top">
		<table class="adminform">
		    <tr>
			<th colspan="2">
			    Status
			</th>
		    </tr>
		    <tr>
			<td>
			    Speicher-Verbrauch <cite>(bytes)</cite>:
			</td>
			<td>
			    '.$user{'space_consumed'}.'
			</td>
		    </tr>
		</table>
	    </td>
	</tr>
    </table>
</form>
';
	}

	/**
	* save videos
	*/
	function saveuser($option)
	{
		global $remoteclient;

		$quota    = $_REQUEST{'user_space_quota'};
		$username = $_REQUEST{'user_name'};
		$user_ns  = $_REQUEST{'user_ns'};

		if (!$username)
		    throw new Exception("missing username");

		if (!(is_array($user = $remoteclient->User_getByName($username))))
		    throw new Exception("no such user: $username");

		$user{'space_quota'} = $quota;
		$remoteclient->User_update($user);
		
		mosRedirect("index2.php?option=$option&task=edituser&user_ns=$user_ns&user_name=$username", "Nutzerdaten gespeichert");
	}
}
