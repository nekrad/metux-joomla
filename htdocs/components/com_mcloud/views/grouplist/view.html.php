<?php
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class McloudViewGrouplist extends JPatTemplateView
{
	function pat_render()
	{
		global $my, $remoteclient, $mcloud_url;

		$this->addVars(array(
		    'CURRENT:USERNAME'		=> $my->username,
		    'NAMESPACE'			=> $remoteclient->namespace
		));

		$groups = $remoteclient->getGroupsVisibleForUser(array(
		    'username'		=> $my->username,
		    'owner_name'	=> @$_REQUEST{'owner_name'}
		));


		if (count($groups))
		{
			$k = 0;
			foreach($groups as $walk => $row)
			{
				$k = ($k ? 0 : 1);
				$vars{'THUMB:URL'}[]	     = $mcloud_url->default_thumb_url();
				$vars{'K'}[]                 = $k;
				$vars{'GROUP:URL'}[]         = $mcloud_url->group_show_url($row{'id'});
				$vars{'GROUP:TITLE'}[]       = $row{'title'};
				$vars{'GROUP:DESCRIPTION'}[] = $row{'description'};
				$vars{'GROUP:OWNER_NAME'}[]  = $row{'owner_name'};
			}
			$this->showSubTmpl('group-list');
			$this->showSubTmpl('no-groups', false);
			$this->addTmplVars($vars, '', 'group-entry');
		}
		else
		{
			$this->showSubTmpl('no-groups');
			$this->showSubTmpl('group-list', false);
		}
	}
}
