<?php

require_once('components/com_mcloud/source/MCloud_View_MediaList_Base.class.php');

class MCloud_View_MyMedia extends MCloud_View_MediaList_Base
{
    var $template_prefix            = 'my-media';

    function getMedia()
    {
	global $my, $remoteclient;
	return $remoteclient->getMediaVisibleForUser(array
	(
	    'username'		=> $my->username,
	    'owner_name'	=> $my->username,
	    'owner_ns'		=> $remoteclient->namespace
#	    'groupfilter'	=> '*'
	));
    }

    function show($option)
    {
	global $my;
	if (!$my->id) 
	    __redir_view('frontpage', 'Not logged in');

	print $this->render($this->getMedia());
    }
}
