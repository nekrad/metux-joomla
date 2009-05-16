<?php

class MCloud_View_GroupList
{
    function show()
    {    
	global $my, $remoteclient;

	$groups = $remoteclient->getGroupsVisibleForUser(array(
	    'username'		=> $my->username,
	    'owner_name'	=> @$_REQUEST{'owner_name'}
	));

	echo "<h1> Gruppen </h1>";

	if (count($groups) == 0) 
	    echo "<div class=\"padding\"> Keine Gruppen </div>";
	else 
	{
	    $k = 0;
	    foreach($groups as $walk => $row)
		echo $this->render_groupent($row, $k++);
	}
    }

    function render_groupent($row, $x)
    {
	global $mcloud_url;

	$k = $x%2;
	$groupurl = $mcloud_url->group_show_url($row{'id'});
	$thumb = $mcloud_url->default_thumb_url();

	$vars = array
	(
	    'THUMB:URL'		=> $thumb,
	    'K'			=> $k,
	    'GROUP:URL'		=> $groupurl,
	    'GROUP:TITLE'	=> $row{'title'},
	    'GROUP:DESCRIPTION'	=> $row{'description'},
	    'GROUP:OWNER_NAME'	=> $row{'owner_name'}
	);
	
	return 
	    _template_fill(_template_load('group_entry'), $vars);
    }
}
