<?php
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class McloudViewGrouplistmulticol extends JPatTemplateView
{
	function pat_render()
	{
		global $my, $remoteclient, $mcloud_url;

		$this->addVars(array
		(
			'CURRENT:USERNAME'	=> $my->username,
			'NAMESPACE'		=> $remoteclient->namespace,
			'PAGE_TITLE'		=> JRequest::getString('title'),
			'CAPTION_0'		=> JRequest::getString('caption_0'),
			'CAPTION_1'		=> JRequest::getString('caption_1'),
			'CAPTION_2'		=> JRequest::getString('caption_2')
		));

		$groups = $remoteclient->getGroupsVisibleForUser(array
		(
			'username'	=> $my->username,
			'owner_name'	=> @$_REQUEST{'owner_name'}
		));

		$filter0 = trim(JRequest::getString('filter_0'));
		$filter1 = trim(JRequest::getString('filter_1'));
		$filter2 = trim(JRequest::getString('filter_2'));

		foreach($groups as $walk => $gr)
		{
			if (preg_match('~'.$filter0.'~', $gr{'ident'}))
			{
				$data0['GROUP:URL'][]         = $mcloud_url->group_show_url($gr{'id'});
				$data0['GROUP:TITLE'][]       = $gr{'title'};
				$data0['GROUP:DESCRIPTION'][] = $gr{'description'};
			}
			if (preg_match('~'.$filter1.'~', $gr{'ident'}))
			{
				$data1['GROUP:URL'][]         = $mcloud_url->group_show_url($gr{'id'});
				$data1['GROUP:TITLE'][]       = $gr{'title'};
				$data1['GROUP:DESCRIPTION'][] = $gr{'description'};
			}
			if (preg_match('~'.$filter2.'~', $gr{'ident'}))
			{
				$data2['GROUP:URL'][]         = $mcloud_url->group_show_url($gr{'id'});
				$data2['GROUP:TITLE'][]       = $gr{'title'};
				$data2['GROUP:DESCRIPTION'][] = $gr{'description'};
			}
		}
		
		if (is_array($data0))
			$this->addTmplVars($data0, '', 'component:group-list:entry:0');
		else
			$this->showSubTmpl('group-list:entry:0', false);

		if (is_array($data1))
	    		$this->addTmplVars($data1, '', 'component:group-list:entry:1');
		else
			$this->showSubTmpl('group-list:entry:1', false);
		
		if (is_array($data2))
			$this->addTmplVars($data2, '', 'component:group-list:entry:2');
		else
			$this->showSubTmpl('group-list:entry:2', false);
	}
}
