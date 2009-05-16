<?php

class MCloud_View_UserGroups
{
    function show($option)
    {
	global $my, $remoteclient;

	if (!$my->id) 
	    __redir_view('group-list', 'Not logged in');

	$groups = $remoteclient->getGroupsByOwner(array('username'=>$my->username));

	if (count($groups))
	{
	    $list = '';
	    $k = '';
	    foreach ($groups as $rw => $row)
		$list .= $this->render_groupent($row, $k++);
	    echo _template_fillout('yourgroups-list', array
	    (
		'GROUP_ENTRIES'	=> $list
	    ));
	}
	else
	    echo _template_fillout('yourgroups-empty', array () );
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
