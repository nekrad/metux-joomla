<?php

require_once('components/com_mcloud/source/MCloud_View_MediaList_Base.class.php');

class MCloud_View_UserMedia extends MCloud_View_MediaList_Base
{
    var $template_prefix = 'user-media';

    function getMedia()
    {
	global $my, $remoteclient;
	(($ns = @$_REQUEST{'owner_ns'}) || ($ns = $remoteclient->namespace));
	return $remoteclient->getMediaVisibleForUser(array(
	    'owner_name'	=> $_REQUEST{'owner_name'},
	    'owner_ns'		=> $ns,
	    'username'		=> (is_object($my) ? $my->username : false)
#	    'groupfilter'	=> '*'
	));
    }

    function show($option)
    {
	global $my;
	if (!$my->id) 
	    __redir_view('frontpage', '');

	echo _template_fill(
	    $this->render($this->getMedia()),
	    array( 'MEDIA:OWNER_NAME' => $_REQUEST{'owner_name'} )
	);
    }
}
