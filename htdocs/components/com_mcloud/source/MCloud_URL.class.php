<?php

class MCloud_URL
{
	function component_name()
	{
		return 'com_mcloud';
	}

	function seftask($task, $params = array())
	{
		global $Itemid;
		$rawurl = 'index.php?option='.MCloud_URL::component_name().'&task='.$task.'&Itemid='.$Itemid;
    
		foreach ($params as $pwalk => $pcur)
			$rawurl .= '&'.$pwalk.'='.urlencode($pcur);

		return sefRelToAbs($rawurl);
	}

	function sefview($view, $params = array())
	{
		global $Itemid;
		$rawurl = 'index.php?option='.MCloud_URL::component_name().'&view='.$view.'&Itemid='.$Itemid;

		foreach ($params as $pwalk => $pcur)
			$rawurl .= '&'.$pwalk.'='.urlencode($pcur);

		return sefRelToAbs($rawurl);
	}

	function medium_url($id)
	{
		return MCloud_URL::sefview('mediumshow', array(
			'medium_id'		=> $id,
			'categories_layout'	=> JRequest::getString('categories_layout'),
			'medialist_layout'	=> JRequest::getString('medialist_layout')
		));
	}

	function medium_url_short($id)
	{
		return 'http://'.$_SERVER['SERVER_NAME'].'/?option='.MCloud_URL::component_name().'&view=mediumshow&medium_id='.$id;
	}

	function users_media_url($username)
	{
		return MCloud_URL::sefview('user-media', array(
			'owner_name'		=> $username,
			'categories_layout'	=> $_REQUEST{'categories_layout'},
			'medialist_layout'	=> $_REQUEST{'medialist_layout'}
		));
	}

	function medium_edit_url($id)
	{
		return MCloud_URL::sefview('medium-edit', array('medium_id'=>$id));
	}

	function medium_delete_url($id)
	{
		return MCloud_URL::sefview('medium-delete', array('medium_id'=>$id));
	}

	function medium_editform_url($id)
	{
		return MCloud_URL::sefview('medium-store', array('medium_id'=>$id));
	}

	function category_url($id)
        {
		return MCloud_URL::sefview('category-media', array('cat_id'=>$id));
	}

	function category_url_vt($id,$categories_layout,$medialist_layout)
	{
		return MCloud_URL::sefview('category-media', array(
			'cat_id'		=> $id,
			'categories_layout'	=> $categories_layout,
			'medialist_layout'	=> $medialist_layout
		));
	}

	function group_medium_approve_url($id,$groupid)
	{
		return MCloud_URL::seftask('group_medium_approve', array('medium_id'=>$id, 'group_id'=>$groupid));
	}

	function group_medium_remove_url($id,$groupid)
	{
		return MCloud_URL::seftask('group_medium_remove', array('medium_id'=>$id, 'group_id'=>$groupid));
	}

	function group_show_url($id)
	{
		return MCloud_URL::sefview('groupshow', array('group_id'=>$id));
	}

	function upload_url()
	{
		return MCloud_URL::sefview('upload', array());
	}

        function default_thumb_url()
	{
		return './components/'.MCLOUD_COMPONENT.'/images/default_thumb.jpg';
	}

	function group_delete_url($group_id)
	{
		return MCloud_URL::sefview('', array ( 'task' => 'group_delete', 'group_id' => $group_id ));
	}

	function group_edit_url($group_id)
	{
		return MCloud_URL::sefview('groupedit', array ( 'group_id' => $group_id ));
	}

	function group_list_url()
	{
		return MCloud_URL::sefview('grouplist', array ());
	}

	function medium_thumb_url($medium)
	{
		if ($i = $medium{'conversions'}{'thumb'}{'download_url'})
			return $i;

		switch($medium{'media_class'})
		{
			case 'livestream':
				return '/components/com_mcloud/images/play.jpg';
		}
	}
}
