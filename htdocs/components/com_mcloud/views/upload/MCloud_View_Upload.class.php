<?php

require_once('components/com_mcloud/mcloud.php');
require_once('components/com_mcloud/source/MCloud_Render.class.php');

class MCloud_View_Upload
{
   /**
    * Upload page
    */
    function render($option)
    {
	global $mosConfig_live_site, $Itemid, $remoteclient, $my, $mcloud_url;

	$kickback_ok  = $mcloud_url->medium_url('___MEDIUM_ID___');
	$kickback_err = $mosConfig_live_site.'/index.php?option='.MCLOUD_COMPONENT.'&Itemid='.$Itemid.'&view=upload';
	$token        = $remoteclient->helper->Upload_Request_Key(array
	(
	    'media_ns'		=> $remoteclient->namespace,
	    'owner_ns'		=> $remoteclient->namespace,
	    'owner_name'	=> $my->username,
	    'kickback_ok'	=> $kickback_ok,
	    'kickback_err'	=> $kickback_err
	));

	$user = $remoteclient->User_GetByName($my->username);

	if (($user{'username'}) && ($user{'space_consumed'} >= $user{'space_quota'}))
	    $ret = _template_fillout('upload/quotefull', array ());
	else
	    $ret = 
		_template_fill(
		    _template_load('upload/form'),
		    array(
			'action'        	=> $remoteclient->getUploadBotUrl(),
			'token'			=> $token,
			'media_ns'		=> $remoteclient->namespace,
			'owner_ns'		=> $remoteclient->namespace,
			'owner_name'		=> $my->username,
			'kickback_ok'		=> $kickback_ok,
			'kickback_err'		=> $kickback_err,
			'category_select'	=> MCloud_Render::render_category_list()
		    )
		);

	return $ret;
    }
    
    function show($option)
    {
	echo $this->render($option);
    }
}
