<?php

require_once('MC_ClientHelper.class.php');

class MC_RemoteClient
{
    var $helper;
    var $secret;
    var $prefix;
    var $namespace;
    var $anonymous = '*****ANONYMOUS*****';

    function MC_RemoteClient($param)
    {
	if (!$param{'prefix'})
	    throw new Exception("missing param 'prefix'");
	if (!$param{'secret'})
	    throw new Exception("missing param 'secret'");
	if (!$param{'namespace'})
	    throw new Exception("missing namespace");
	
	$this->prefix    = $param{'prefix'};
	$this->secret    = $param{'secret'};
	$this->namespace = $param{'namespace'};
	$this->helper    = new MC_ClientHelper($param{'secret'});
	$this->helper->prefix = $this->prefix;
    }

    function _mk_urlpar($param)
    {
	$par = '';
	foreach ($param as $walk => $cur)
	    if (isset($cur) && is_scalar($cur))
		$par .= ($par ? '&':'').$walk.'='.urlencode($cur);
	return $par;
    }

    // currently no-op.
    // later we'll also retrieve URLs for certain sub-services here
    function authenticate()
    {
    }

    function queryMedia($param)
    {
	$urlpar = $param;
	$urlpar{'media_ns'} = $this->namespace;
	$urlpar{'owner_ns'} = $this->namespace;
	$urlpar{'token'}    = $this->helper->Media_Query_Key($urlpar);

	$query_url = $this->prefix.'/query_media.php?'.$this->_mk_urlpar($urlpar);
	$r = implode('',file($query_url));
	$result = json_decode($r,true);
	if ($result{'status'} != 'ok')
	    throw new Exception("query failed: ".serialize($result));

	return $result{'records'};
    }

    function getMediaByOwner($username, $param = array())
    {
	if (!$username)
	    throw new Exception("missing username");

	$param{'owner_ns'}   = $this->namespace;
	$param{'owner_name'} = $username;

	return $this->queryMedia($param);
    }
    
    // FIXME: obsolete -- will go away soon
    function getMediaForFrontpage($username)
    {
	return $this->getMediaVisibleForUser(array(username=>$username));
    }

    function groupMediumApprove($username, $group_id, $medium_id)
    {
	return $this->_rpcexec(
	    "group-medium-approve", 
	    array(
		'username'	=> $username, 
		'group_id'	=> $group_id,
		'medium_id'	=> $medium_id
	    )
	);
    }

    function groupMediumRemove($username, $group_id, $medium_id)
    {
	return $this->_rpcexec(
	    "group-medium-remove",
	    array(
		'username'	=> $username,
		'group_id'	=> $group_id,
		'medium_id'	=> $medium_id
	    )
	);
    }

    function queryCategories($param)
    {
	$urlpar = $param;
	$urlpar{'namespace'} = $this->namespace;
	$urlpar{'token'}     = $this->helper->Category_Query_Key($urlpar);

	$query_url = $this->prefix.'/query_categories.php?'.$this->_mk_urlpar($urlpar);
	$r = implode('',file($query_url));
	$result = json_decode($r,true);

	if ($result{'status'} != 'ok')
	    throw new Exception("query failed: ".serialize($result));

	return $result{'records'};
    }

    function queryGroups($param)
    {
	$result = $this->_rpcexec(
	    "group-query-global",
	    $param);

	if ($result{'status'} != 'ok')
	    throw new Exception("query failed: ".serialize($result));

	return $result{'records'};
    }

    function _rpcexec($command, $param)
    {
	$result = $this->helper->rpc_call_exec(
	    $this->namespace,
	    $this->secret,
	    $command,
	    $param
	);
	if ($result{'status'} != 'ok')
	    throw new Exception("query failed: ".serialize($result));

	return $result;
    }

    function deleteGroup($param)
    {
	if (!($username = $param{'username'}))
	    throw new Exception("missing username");
	if (!($group_id = $param{'group_id'}))
	    throw new Exception("missing group_id");
	return $this->_rpcexec(
	    "group-delete", 
	    array('username'=>$username, 'group_id'=>$group_id)
	);
    }

    function getGroupsByMember($param)
    {
	if (!$param{'username'})
	    $param{'username'} = '*****ANONYMOUS*****';

	$result = $this->helper->rpc_call_exec(
	    $this->namespace,
	    $this->secret,
	    "group-query-subscribed",
	    array(
		'namespace'	=> $this->namespace,
		'username'	=> $param{'username'}
	));
	if ($result{'status'} != 'ok')
	    throw new Exception("query failed: ".serialize($result));

	return $result{'records'};
    }

    /* retrieve list of groups where the user is allowed to add some medium */
    // we currently only support those groups where adding user is owner ... 
    // additional the admin gets all groups
    // FIXME: should be entirely moved to rpc server
    function getGroupsForMediaAdd($param)
    {
	if (!$param{'is_admin'})
	    return $this->getGroupsByMember($param);

	return $this->queryGroups(array
	(
		'owner_ns'	=> $this->namespace
	));
    }

    function addMediumToGroup($param)
    {
	if (!$param{'username'})
	    $param{'username'} = '*****ANONYMOUS*****';
	if (!$param{'medium_id'})
	    throw new Exception("missing medium_id");

	$result = $this->helper->rpc_call_exec(
	    $this->namespace,
	    $this->secret,
	    "group-add-medium",
	    array(
		'namespace'	=> $this->namespace,
		'owner_ns'	=> $this->namespace,
		'username'	=> $param{'username'},
		'medium_id'	=> $param{'medium_id'},
		'group_id'	=> $param{'group_id'}
	));
	if ($result{'status'} != 'ok')
	    throw new Exception("query failed: ".serialize($result));

	return $result;
    }

    function removeMediumFromGroup($param)
    {
	if (!$param{'username'})
	    $param{'username'} = '*****ANONYMOUS*****';
	if (!$param{'medium_id'})
	    throw new Exception("missing medium_id");

	$result = $this->helper->rpc_call_exec(
	    $this->namespace,
	    $this->secret,
	    "group-remove-medium",
	    array(
		'namespace'	=> $this->namespace,
		'owner_ns'	=> $this->namespace,
		'username'	=> $param{'username'},
		'medium_id'	=> $param{'medium_id'},
		'group_id'	=> $param{'group_id'}
	));
	if ($result{'status'} != 'ok')
	    throw new Exception("query failed: ".serialize($result));

	return $result;
    }

    function removeMedium($param)
    {
	if (!$param{'id'})
	    throw new Exception("missing id");

	$urlpar = array
	(
	    'id'	=> $param{'id'},
	    'media_ns'	=> $this->namespace,
	    'user_ns'	=> $this->namespace,
	    'user_name'	=> $this->user_name
	);
	$urlpar{'token'} = $this->helper->Media_Remove_Key($urlpar);

	$query_url = $this->prefix.'/remove_medium.php?'.$this->_mk_urlpar($urlpar);
	$r = implode('',file($query_url));
	$result = json_decode($r,true);
	if ($result{'status'} != 'ok')
	    throw new Exception("query failed: ".serialize($result));

	return $result;
    }

    function updateMedium($param)
    {
	if (!$param{'id'})
	    throw new Exception("missing id");

	return $this->_rpcexec(
	    'medium-update', 
	    array(
		'media_ns'	=> $this->namespace,
		'username'	=> $param{'username'},
		'medium_id'	=> $param{'id'},
		'tags'		=> $param{'tags'},
		'title'		=> $param{'title'},
		'description'	=> $param{'description'},
		'price'		=> $param{'price'}
	));
    }

    function addComment($param)
    {
	if (!$param{'master'})
	    throw new Exception("missing master");
	if (!$param{'user_name'})
	    throw new Exception("missing user_name");
	if (!$param{'content'})
	    throw new Exception("missing content");

	$urlpar = $param;
	$urlpar{'media_ns'} = $this->namespace;
	$urlpar{'user_ns'}  = $this->namespace;
	$urlpar{'token'}    = $this->helper->Media_AddComment_Key($urlpar);

	$query_url = $this->prefix.'/add_comment.php?'.$this->_mk_urlpar($urlpar);
	$r = implode('',file($query_url));
	$result = json_decode($r,true);
	if ($result{'status'} != 'ok')
	    throw new Exception("query failed: ".serialize($result));

	return $result;
    }

    function Livestream_Add($param)
    {
	if (!$this->namespace)
	    throw new Exeception("missing this->namespace");
	if (!$param{'owner_name'})
	    throw new Exception("missing owner_name");
	if (!$param{'title'})
	    throw new Exception("missing title");
	if (!$param{'description'})
	    throw new Exception("missing description");
	if (!$param{'stream_url'})
	    throw new Exception("missing stream_url");
	if (!$param{'stream_type'})
	    throw new Exception("missing stream_type");

	$query_url = $this->helper->rpc_call_encode(
	    $this->namespace,
	    $this->secret,
	    "livestream-add",
	    array(
		'namespace'		=> $this->namespace,
		'owner_ns'		=> $this->namespace,
		'owner_name'		=> $param{'owner_name'},
		'title'			=> $param{'title'},
		'description'		=> $param{'description'},
		'stream_url'		=> $param{'stream_url'},
		'stream_type'		=> $param{'stream_type'},
		'tags'			=> $param{'tags'},
		'category_id'		=> $param{'category_id'}
	));

	$r = implode('',file($query_url));
	$result = json_decode($r,true);
	if ($result{'status'} != 'ok')
	    throw new Exception("query failed: ".serialize($result));

	return $result;
    }

    function createGroup($param)
    {
	if (!$param{'owner_name'})
	    throw new Exception("missing owner_name");
	if (!$param{'title'})
	    throw new Exception("missing title");
	if (!$param{'description'})
	    throw new Exception("missing description");

	$query_url = $this->helper->rpc_call_encode(
	    $this->namespace,
	    $this->secret,
	    "group-create",
	    array(
		'namespace'		=> $this->namespace,
		'owner_ns'		=> $this->namespace,
		'ident'			=> $param{'ident'},
		'owner_name'		=> $param{'owner_name'},
		'title'			=> $param{'title'},
		'description'		=> $param{'description'},
		'auto_join'		=> $param{'auto_join'},
		'description'		=> $param{'description'},
		'allow_comments'	=> $param{'allow_comments'},
		'require_approval'	=> $param{'require_approval'},
		'visibility'		=> $param{'visibility'},
		'subscribe_policy'	=> $param{'subscribe_policy'}
	));

	$r = implode('',file($query_url));
	$result = json_decode($r,true);
	if ($result{'status'} != 'ok')
	    throw new Exception("query failed: ".serialize($result));

	return $result;
    }

    function getMediumById($id, $username = false)
    {
	$res = $this->getMediaVisibleForUser(array('inode_id'=>$id, 'id'=>$id, 'username'=>$username));
	return $res[$id];
    }

    function getGroupById($id)
    {
	$res = $this->queryGroups(array('inode_id'=>$id, 'id'=>$id));
	return $res[$id];
    }

    function getMediaMasterURL_score($score)
    {
	return str_replace('{SCORE}', $score, MEDIACLOUD_DOWNLOAD_URL);
    }
    
    function getUploadBotUrl()
    {
	return $this->prefix.'/upload_media.php';
    }
    
    // retrieve groups which are visible to given user
    function getGroupsVisibleForUser($param)
    {
	if (!$param{'username'})
	    $param{'username'} = '*****ANONYMOUS*****';

	$result = $this->helper->rpc_call_exec(
	    $this->namespace,
	    $this->secret,
	    "group-query-for-user",
	    array(
		'namespace'	=> $this->namespace,
		'username'	=> @$param{'username'},
		'owner_name'	=> @$param{'owner_name'},
		'offset'	=> @$param{'offset'},
		'limit'		=> @$param{'limit'}
	));
	if ($result{'status'} != 'ok')
	    throw new Exception("query failed: ".serialize($result));

	return $result{'records'};
    }

    // retrieve groups which are owned by given user
    function getGroupsByOwner($param)
    {
	if (!$param{'username'})
	    throw new Exception("misssing username");

	$result = $this->helper->rpc_call_exec(
	    $this->namespace,
	    $this->secret,
	    "group-query-by-owner",
	    array(
		'namespace'	=> $this->namespace,
		'username'	=> $param{'username'}
	));
	if ($result{'status'} != 'ok')
	    throw new Exception("query failed: ".serialize($result));

	return $result{'records'};
    }

    // retrieve groups which are visible to given user
    function getMediaVisibleForUser($param)
    {
	if (!$param{'username'})
	    $param{'username'} = $this->anonymous;

	$result = $this->helper->rpc_call_exec(
	    $this->namespace,
	    $this->secret,
	    "medium-query-for-user",
	    array(
		'namespace'	=> $this->namespace,
		'username'	=> @$param{'username'},
		'category'	=> @$param{'category'},
		'owner_name'	=> @$param{'owner_name'},
		'search'	=> @$param{'search'},
		'limit'		=> @$param{'limit'},
		'offset'	=> @$param{'offset'},
		'id'		=> @$param{'id'},
		'groupfilter'	=> @$param{'groupfilter'},
		'querytype'	=> @$param{'querytype'},
		'order'		=> @$param{'order'},
		'searchterm'    => @$param{'searchterm'},
		'media_class'	=> @$param{'media_class'},
		'group_id'	=> @$param{'group_id'}
	    )
	);

	if ($result{'status'} != 'ok')
	    throw new Exception("query failed: ".serialize($result));

	return $result{'records'};
    }

    function groupSubscribe($username, $group_id)
    {
	if (!$username)
	    throw new Exception("missing username");
	if (!$group_id)
	    throw new Exception("missing group_id");
	    
	$result = $this->helper->rpc_call_exec(
	    $this->namespace,
	    $this->secret,
	    "group-subscribe",
	    array(
		'username'	=> $username,
		'group_id'	=> $group_id
	    )
	);

	if ($result{'status'} != 'ok')
	    throw new Exception("query failed: ".serialize($result));
    }

    function groupUnsubscribe($username, $group_id)
    {
	if (!$username)
	    throw new Exception("missing username");
	if (!$group_id)
	    throw new Exception("missing group_id");

	$result = $this->helper->rpc_call_exec(
	    $this->namespace,
	    $this->secret,
	    "group-unsubscribe",
	    array(
		'username'	=> $username,
		'group_id'	=> $group_id
	    )
	);
    }

    function User_GetByName($username)
    {
	if (!$username)
	    throw new Exception("missing username");

	$res = $this->_rpcexec(
	    "user-get",
	    array( 'user_name' => $username )
	);
	return $res{'records'};
    }

    function User_Add($username)
    {
	if (!$username)
	    throw new Exception("missing username");

	$res = $this->_rpcexec(
	    "user-add",
	    array( 'user_name' => $username )
	);
	return $res;
    }

    function User_Add_Bulk($userlist)
    {
	if (!is_array($userlist))
	    throw new Exception("missing userlist");
	return $this->_rpcexec(
	    "user-add-bulk",
	    array( 'userlist' => $userlist )
	);
    }

    function _group_member_action($action, $username, $group_id, $member_ns, $member_name)
    {
	if (!$username)
	    throw new Exception("missing username");
	if (!$group_id)
	    throw new Exception("missing group_id");
	if (!$member_ns)
	    throw new Exception("missing member_ns");
	if (!$member_name)
	    throw new Exception("missing member_name");

	return $this->helper->rpc_call_exec(
	    $this->namespace,
	    $this->secret,
	    $action,
	    array(
		'username'	=> $username,
		'member_ns'	=> $member_ns,
		'member_name'	=> $member_name,
		'group_id'	=> $group_id
	    )
	);    
    }

    function groupMemberApprove($username, $group_id, $member_ns, $member_name)
    {
	return $this->_group_member_action("group-member-approve", $username, $group_id, $member_ns, $member_name);
    }

    function groupMemberRemove($username, $group_id, $member_ns, $member_name)
    {
	return $this->_group_member_action("group-member-remove", $username, $group_id, $member_ns, $member_name);
    }
    
    function medium_log_view($medium_id, $username)
    {
	return $this->_rpcexec(
	    "medium-log-view", 
	    array(
		'username'	=> ($username ? $username : '*****ANONYMOUS*****'),
		'medium_id'	=> $medium_id
	    )
	);
    }
    
    function queryUsers($param)
    {
	return $this->_rpcexec(
	    "users-query",
	    $param
	);
    }
    
    function User_Update($user)
    {
	return $this->_rpcexec(
	    "user-update",
	    $user
	);
    }
    
    function Group_Update($group)
    {
	return $this->_rpcexec(
	    "group-update",
	    $group
	);
    }
    
    function Medium_GetByIdForUser($id, $username, $namespace = false)
    {
	if (!$namespace)
	    $namespace = $this->namespace;

	$ret = $this->_rpcexec(
	    'medium-get-for-user',
	    array(
		'medium_id'	=> $id,
		'username'	=> $username,
		'namespace'	=> $namespace
	    )
	);
	
	return $ret{'record'};
    }
    
    function Medium_Buy($id, $username, $namespace = false)
    {
	$ret = $this->_rpcexec(
	    'medium-buy',
	    array(
		'medium_id'	=> $id,
		'username'	=> $username,
		'namespace'	=> ($namespace ? $namespace : $this->namespace)
	    )
	);
	return $ret{'result'};
    }
}
