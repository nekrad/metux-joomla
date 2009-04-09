<?php

require_once('components/com_mcloud/source/MCloud_View_MediaList_Base.class.php');

class MCloud_View_MediaCharts extends MCloud_View_MediaList_Base
{
    var $template_prefix            = 'charts';

    function getMedia()
    {
	global $remoteclient;
	return $remoteclient->getMediaVisibleForUser(array(
	    'username'		=> $my->username, 
	    'owner_name'	=> @$_REQUEST{'owner_name'},
	    'category'		=> @$_REQUEST{'category'},
	    'search'		=> @$_REQUEST{'search'},
	    'querytype'		=> 'top-today',			// <-- charts
	    'limit'		=> $_REQUEST{'limit'},
	    'media_class'	=> $_REQUEST{'media_class'}
	));
    }

    function show($option)
    {
	echo $this->render($this->getMedia());
    }
}
