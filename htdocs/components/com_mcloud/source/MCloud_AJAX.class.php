<?php

class MCloud_AJAX
{
    // Add medium to group
    function add2group()
    {
	global $my, $remoteclient;

	if (!$my->id) 
	{
	    echo "You need to login";
	    exit;
	}

	$user_id = $my->id;
	$videoid = intval ( $_GET{'videoid'} );
	$groupid = intval ( $_GET{'groupid'} );

	if ($groupid == 0) 
	{
	    echo "No such group";
	    exit;
	}

	$res = $remoteclient->addMediumToGroup(array(
	    username	=> $my->username,
	    group_id	=> $groupid,
	    medium_id	=> $videoid
	));

	syslog(LOG_WARNING, "Add2group: ".serialize($res));
	echo "Ok";
	exit;
    }
}
