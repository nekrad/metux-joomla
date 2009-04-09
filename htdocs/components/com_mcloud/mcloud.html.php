<?php

class __MCloud_HTML
{
    function mk_url($task, $param)
    {
	global $Itemid;
	foreach($param as $walk => $cur)
	    $url .= '&'.$walk.'='.$cur;
	return sefRelToAbs(
	    'index.php?option='.$_REQUEST{'option'}.'&task='.$task.'&Itemid='.$Itemid.$url);
    }

    function group_user_approve_url($group_id,$user_ns,$user_name)
    {
	return __MCloud_HTML::mk_url('group_user_approve', array(
	    group_id	=> $group_id,
	    user_ns	=> $user_ns,
	    user_name	=> $user_name
	));
    }

    function group_user_remove_url($group_id,$user_ns,$user_name)
    {
	return __MCloud_HTML::mk_url('group_user_remove', array(
	    group_id	=> $group_id,
	    user_ns	=> $user_ns,
	    user_name	=> $user_name
	));
    }
}
