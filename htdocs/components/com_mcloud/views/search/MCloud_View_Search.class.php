<?php

require_once('components/com_mcloud/source/MCloud_View_MediaList_Base.class.php');

class MCloud_View_Search extends MCloud_View_MediaList_Base
{
    var $template_prefix = 'search';

    function getMedia()
    {
	global $remoteclient;
	return $remoteclient->getMediaVisibleForUser(array
	(
	    'username'		=> $my->username,
	    'searchterm'	=> @$_REQUEST{'searchterm'}
	));
    }

    function show($option)
    {
	echo _template_fill(
	    $this->render($this->getMedia()),
	    array(
		'SEARCHTERM'	=> htmlentities(@$_REQUEST{'searchterm'})
	));
    }
}
