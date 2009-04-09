<?php
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class MCloudController extends JController
{
	function display()
	{
		// Set a default view if none exists
		if (!JRequest::getCmd('view'))
			JRequest::setVar('view', 'frontpage');
		parent::display();
	}

	function addlivestream()
	{
		global $remoteclient, $my, $mcloud_url;
		$res = $remoteclient->livestream_add(array
		(
			'owner_name'	=> $my->username,
			'title'		=> JRequest::getString('title'),
			'description'	=> JRequest::getString('description'),
			'stream_type'	=> JRequest::getString('stream_type'),
			'stream_url'	=> JRequest::getString('stream_url'),
			'tags'		=> JRequest::getString('tags'),
			'category_id'	=> JRequest::getString('category_id')
		));
		$url = $mcloud_url->medium_url($res{'medium_id'});
		$this->setRedirect($url);
	}

	function group_delete()
	{
		global $my, $remoteclient, $mcloud_url;
		$remoteclient->deleteGroup(array
		(
			'username'	=> $my->username,
			'group_id'	=> JRequest::getString('group_id')
		));
		$this->setRedirect($mcloud_url->group_list_url());
	}

	function group_create()
	{
		global $my, $remoteclient, $mcloud_url;

		$group_title       = JRequest::getString('group_title');
		$group_description = JRequest::getString('group_description');
		
		if (empty($group_title) || empty($group_description)) 
			throw new Exception("missing name/description");

		$grp = $remoteclient->createGroup(array
		(
			'title'			=> $group_title,
			'description'		=> $group_description,
			'owner_name'		=> $my->username,
			'ident'			=> JRequest::getString('group_ident'),
			'public_private'	=> JRequest::getString('public_private'),
			'allow_comments'	=> JRequest::getString('allow_comments'),
			'require_approval'	=> JRequest::getString('require_approval'),
			'auto_join'		=> JRequest::getString('add2group'),
			'visibility'		=> JRequest::getString('visibility'),
			'subscribe_policy'	=> JRequest::getString('subscribe_policy')
		));

		$this->setRedirect($mcloud_url->group_show_url($grp{'group_id'}));
	}

	function group_update()
	{
		global $mcloud_url, $remoteclient, $my, $mcloud_access;

		if (!($group_id = JRequest::getString('group_id')))
			throw new Exception("Missing group_id");

		$group = $remoteclient->getGroupById(JRequest::getString('group_id'));
		if (!is_array($group))
			throw new Exception("No group");

		if (!$mcloud_access->permit_GroupEdit($group))
			throw new Exception("Denied");

		$group{'title'}            = JRequest::getString('group_title');
		$group{'ident'}            = JRequest::getString('group_ident');
		$group{'description'}      = JRequest::getString('group_description');
		$group{'visibility'}       = JRequest::getString('visibility');
		$group{'subscribe_policy'} = JRequest::getString('subscribe_policy');
		$remoteclient->Group_Update($group);

		$this->setRedirect($mcloud_url->group_show_url($group{'id'}));
	}
	
	function medium_recommend()
	{
		global $remoteclient, $my, $mcloud_url;

		if (!($medium_id = JRequest::getString('medium_id')))
			throw new Exception("missing medium_id");
		if (!($email     = JRequest::getString('email')))
			throw new Exception("missing email");
		if (!($message   = JRequest::getString('message')));

		$lang = JFactory::getLanguage();
		$lang->load('com_mcloud');

		$subject = $lang->_('MCLOUD:MEDIUM-RECOMMEND:SUBJECT');
		$sender  = $lang->_('MCLOUD:MEDIUM-RECOMMEND:SENDER');

		$text = _template_fillout('medium-recommend/mail', array
		(
			'EMAIL'		=> $email,
			'MESSAGE'	=> $message,
			'URL'		=> $mcloud_url->medium_url_short($medium_id),
			'USERNAME'	=> $my->username
		));

		mail($email, $subject, $text, 'From: '.$sender);
		$this->setRedirect(JRequest::getString('kickback'));
	}

	function medium_comment()
	{
		global $remoteclient, $my, $mcloud_url;

		if (!($id = JRequest::getString('medium_id')))
			throw new Exception('missing medium_id');

		$remoteclient->addComment(array(
			master		=> $id,
			user_name	=> $my->username,
			username	=> $my->username,
			content		=> JRequest::getString('comment')
		));
		$this->setRedirect(JRequest::getString('kickback'));
	}
}
