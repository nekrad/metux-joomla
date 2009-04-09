<?php

require_once('components/com_mcloud/mcloud.php');

class MCloud_Frontend_Controller
{
    function kickto_view($view, $msg, $extra = '')
    {
	__redir_view($view, $msg, $extra);
    }

    function kickto_view_medium_show($medium_id, $msg, $extra = '')
    {
	$this->kickto_view('mediumshow', $msg, $extra.'&medium_id='.urlencode($medium_id));
    }

    function medium_delete($option)
    {
	global $my, $remoteclient;

	$medium = $remoteclient->getMediumById(intval($_REQUEST{'medium_id'}), $my->username);
	if ($medium{'owner_name'} != $my->username)
	    __redir_view('my-media', 'Zugriff verweigert');

	$res = $remoteclient->removeMedium(array(id=>$medium{'id'}));

	__redir_view('my-media', 'Medium entfernt');
    }

    function medium_buy($option)
    {
	global $my, $remoteclient;

	$medium = $remoteclient->Medium_GetByIdForUser(
	    @$_REQUEST{'medium_id'},
	    $my->username
	);
	
	$ret = $remoteclient->Medium_Buy($_REQUEST{'medium_id'}, $my->username);

	switch ($ret)
	{
	    case 'DUPLICATE':	$msg = 'Medium bereits gekauft';	break;
	    case 'NOCASH':	$msg = 'Nicht genug Cash';		break;
	    case 'MISSING':	$msg = 'Medium nicht gefunden';		break;
	    case 'SOLD':	$msg = 'Medium gekauft';		break;
	    default:		$msg = $ret;				break;
	}
	
	$this->kickto_view_medium_show($_REQUEST{'medium_id'}, $msg);
    }

    // move media to another group
    function group_media_move($option)
    {    
	global $remoteclient, $my;

	$target = $_REQUEST{'targetgroup'};

	if (!$_REQUEST{'group_id'})
	    die("missing group_id");

	if (is_array($_REQUEST{'selected'}))
	{
	    foreach($_REQUEST{'selected'} as $swalk => $scur)
	    {
		$remoteclient->removeMediumFromGroup(array
		(
		    username	=> $my->username,
		    group_id	=> $_REQUEST{'group_id'},
		    medium_id	=> $swalk
		));    

		if ($target)
		{
		    print "Removing $swalk from group $target<br>\n";
		    $remoteclient->addMediumToGroup(array
		    (
			username	=> $my->username,
			group_id	=> $target,
			medium_id	=> $swalk
		    ));
		}	
	    }
	}

	if ($_REQUEST{'kickback'})
	    Header("Location: ".$_REQUEST{'kickback'});

	die("missing kickback");
    }

    function group_save($option)
    {
	global $my, $mosConfig_live_site, $remoteclient;

	if (empty($_REQUEST['group_name']) || empty($_REQUEST['group_description'])) 
	{
		echo "<p><img src=\"".$mosConfig_live_site."/components/com_mcloud/images/icons/exclamation.png\" />&nbsp;&nbsp; Bitte komplett ausf&uuml;llen<br /><br /></p>";
		return;
	}

	if ($_REQUEST{'group_id'})
	{
	    $group = $remoteclient->getGroupById($_REQUEST{'group_id'});
	    if (!is_array($group))
		die("No group");
	
	    if (($group{'owner_name'} != $my->username) ||
	        ($group{'owner_ns'} != $remoteclient->namespace))
		die("Denied");
	    
	    $group{'title'}            = $_REQUEST{'group_name'};
	    $group{'description'}      = $_REQUEST{'group_description'};
	    $group{'visibility'}       = $_REQUEST{'visibility'};
	    $group{'subscribe_policy'} = $_REQUEST{'subscribe_policy'};

	    $remoteclient->Group_Update($group);
	}
	else
	{
	    $grp = $remoteclient->createGroup(array
	    (
		'title'			=> $_REQUEST{'group_name'},
		'public_private'	=> $_REQUEST{'public_private'},
		'allow_comments'	=> $_REQUEST{'allow_comments'},
		'require_approval'	=> $_REQUEST{'require_approval'},
		'description'		=> $_REQUEST{'group_description'},
		'owner_name'		=> $my->username,
		'auto_join'		=> $_REQUEST{'add2group'},
		'visibility'		=> $_REQUEST{'visibility'},
		'subscribe_policy'	=> $_REQUEST{'subscribe_policy'}
	    ));
	}

	$msg = 'Ok';
	echo "<p><img src=\"".$mosConfig_live_site."/components/com_mcloud/images/icons/exclamation.png\" />&nbsp;&nbsp;".$msg."<br /><br /></p>";
	return;
    }

    function group_join($option)
    {
	global $database, $Itemid, $my, $remoteclient;
	$url = $database->getEscaped( strip_tags( trim( strtolower( $_REQUEST{'url'} ) ) ) );

	if (!$my->id) {
		$msg = 'Not logged in';
		mosRedirect( $url, $msg );
	}

	$remoteclient->groupSubscribe($my->username, $_REQUEST{'groupid'});
	$msg = 'Ok';
	mosRedirect( $url, $msg );
    }

    function group_leave($option)
    {
	global $database, $Itemid, $my, $remoteclient;
	$url = $database->getEscaped( strip_tags( trim( strtolower( $_POST{'url'} ) ) ) );

	if (!$my->id) {
		$msg = 'Not logged in';
		mosRedirect( $url, $msg );
	}

	$remoteclient->groupUnsubscribe($my->username, $_REQUEST{'groupid'});
	$msg = 'Ok';
	mosRedirect( $url, $msg );
    }

    function medium_comment_add()
    {
	global $remoteclient, $my, $mcloud_url;

	if (!$_REQUEST{'id'})
	    throw new Exception('missing id');

	$remoteclient->addComment(array(
	    master	=> $_REQUEST{'id'},
	    user_name	=> $my->username,
	    content	=> $_REQUEST{'comment'}
	));
    
	Header('Location: '.$mcloud_url->medium_url($_REQUEST{'id'}));
    }
}
