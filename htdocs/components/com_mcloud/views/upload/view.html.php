<?php

jimport('joomla.application.component.view');

require_once('components/com_mcloud/source/MCloud_Render.class.php');

class McloudViewUpload extends JPatTemplateView
{
	function pat_render()
	{
		global $mosConfig_live_site, $Itemid, $remoteclient, $my, $mcloud_url;

		$kickback_ok  = $mcloud_url->medium_url('___MEDIUM_ID___');
		$kickback_err = $mosConfig_live_site.'/index.php?option='.MCLOUD_COMPONENT.'&Itemid='.$Itemid.'&view=upload';
		$token        = $remoteclient->helper->Upload_Request_Key(array
		(
			'media_ns'     => $remoteclient->namespace,
			'owner_ns'     => $remoteclient->namespace,
			'owner_name'   => $my->username,
			'kickback_ok'  => $kickback_ok,
			'kickback_err' => $kickback_err
		));

		$user = $remoteclient->User_GetByName($my->username);

		if (($user{'username'}) && ($user{'space_consumed'} >= $user{'space_quota'}))
			return $this->showSubTmpl('error:quotefull');

		$this->addVars(array
		(
			'ACTION'          => $remoteclient->getUploadBotUrl(),
			'TOKEN'           => $token,
			'MEDIA_NS'        => $remoteclient->namespace,
			'OWNER_NS'        => $remoteclient->namespace,
			'OWNER_NAME'      => $my->username,
			'KICKBACK_OK'     => $kickback_ok,
			'KICKBACK_ERR'    => $kickback_err,
			'CATEGORY_SELECT' => MCloud_Render::render_category_list()
		));
	}
}
