<?php

require_once('components/com_mcloud/source/MCloud_Render.class.php');

class MCloud_View_MediaList
{
    function getMedia()
    {
	global $remoteclient;

	switch ($_REQUEST{'order'})
	{
	    case 'newest':	$order = 'newest';	break;
	}

	return $remoteclient->getMediaVisibleForUser(array(
	    'username'	=> $my->username,
	    'category'	=> $_REQUEST{'category_id'},
	    'limit'	=> $_REQUEST{'limit'},
	    'order'	=> $order
	));
    }

    function show($option)
    {
	$medialist = $this->getMedia();
	echo $this->render($medialist);
    }
}
