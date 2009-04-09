<?php
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class McloudViewGroupedit extends JPatTemplateView
{
	function pat_render()
	{
		global $my, $remoteclient, $mcloud_access;

		if (!(($my->id) && allowed_groups()))
		{
			$this->showSubTmpl('denied');
			$this->showSubTmpl('view', false);
			return;
		}

		$group = $remoteclient->getGroupById($_REQUEST{'group_id'});
		if (!$mcloud_access->permit_GroupEdit($group))
		{
			$this->showSubTmpl('view', false);
			$this->showSubTmpl('denied');
			return;
		}
			
		$this->addVars(array
		(
			'GROUP:TITLE'			=> $group{'title'},
			'GROUP:DESCRIPTION'		=> $group{'description'},
			'GROUP:ID'			=> $group{'id'},
			'GROUP:IDENT'			=> $group{'ident'},
			'OPT:VISIBILITY:PUBLIC'		=> ($group{'visibility'}=='public'        ? 'selected="selected"' : ''),
			'OPT:VISIBILITY:REGISTERED'	=> ($group{'visibility'}=='registered'    ? 'selected="selected"' : ''),
			'OPT:VISIBILITY:PRIVATE'	=> ($group{'visibility'}=='private'       ? 'selected="selected"' : ''),
			'OPT:SUBSCRIBE:CONFIRM'		=> ($group{'subscribe_policy'}=='confirm' ? 'selected="selected"' : ''),
			'OPT:SUBSCRIBE:PUBLIC'		=> ($group{'subscribe_policy'}=='public'  ? 'selected="selected"' : ''),
			'OPT:SUBSCRIBE:PRIVATE'		=> ($group{'subscribe_policy'}=='private' ? 'selected="selected"' : '')
		));
	}
}
