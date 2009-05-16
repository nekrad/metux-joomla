<?php

// get $task from global $_REQUEST and then switch
if (!($view = @$_REQUEST{'view'}))
    $view = @$_REQUEST{'task'};

switch ($view)
{
    case 'categories':
	require_once(MCLOUD_PREFIX.'/views/categories/MCloud_View_Categories.class.php');
	$view = new MCloud_View_Categories();
	$view->show($option);
    break;

    case 'group-create':
	require_once(MCLOUD_PREFIX.'/views/group-create/MCloud_View_GroupCreate.class.php');
	$view = new MCloud_View_GroupCreate();
	$view->show($option);
    break;

    case 'group-list':
	require_once(MCLOUD_PREFIX.'/views/group-list/MCloud_View_GroupList.class.php');
	$view = new MCloud_View_GroupList();
	$view->show();
    break;

    case 'user-media':
	require_once(MCLOUD_PREFIX.'/views/user-media/MCloud_View_UserMedia.class.php');
	$view = new MCloud_View_UserMedia();
	$view->show($option);
    break;

    case 'my-media':
	require_once(MCLOUD_PREFIX.'/views/my-media/MCloud_View_MyMedia.class.php');
	$view = new MCloud_View_MyMedia();
	$view->show($option);
    break;

    case 'user-groups':
	require_once(MCLOUD_PREFIX.'/views/user-groups/MCloud_View_UserGroups.class.php');
	$view = new MCloud_View_UserGroups();
	$view->show($option);
    break;

#    case 'upload':
#	require_once(MCLOUD_PREFIX.'/views/upload/MCloud_View_Upload.class.php');
#	$view = new MCloud_View_Upload();
#	$view->show($option);
#    break;

    case 'media-charts':
	require_once(MCLOUD_PREFIX.'/views/media-charts/MCloud_View_MediaCharts.class.php');
	$view = new MCloud_View_MediaCharts();
	$view->show($option);
    break;

    case 'media-list':
	require_once(MCLOUD_PREFIX.'/views/media-list/MCloud_View_MediaList.class.php');
	$view = new MCloud_View_MediaList();
	$view->show($option);
    break;

    case 'search':
	require_once(MCLOUD_PREFIX.'/views/search/MCloud_View_Search.class.php');
	$view = new MCloud_View_Search();
	$view->show($option);
    break;

    case 'category-media':
	require_once(MCLOUD_PREFIX.'/views/category-media/MCloud_View_CategoryMedia.class.php');
	$view = new MCloud_View_CategoryMedia();
	$view->show($option);
    break;

    case 'medium-show':
	Header('Location: '.$mcloud_url->medium_url(JRequest::getString('medium_id')));
    break;

    case 'medium-edit':
	require_once(MCLOUD_PREFIX.'/views/medium-edit/MCloud_View_MediumEdit.class.php');
	$view = new MCloud_View_MediumEdit();
	$view->show($option);
	break;

    case 'medium-store':
	require_once(MCLOUD_PREFIX.'/views/medium-edit/MCloud_View_MediumEdit.class.php');
	$view = new MCloud_View_MediumEdit();
	$view->store($option);
	break;

    case 'group-show':
	require_once(MCLOUD_PREFIX.'/views/group-show/MCloud_View_GroupShow.class.php');
	$view = new MCloud_View_GroupShow();
	$view->show($option);
    break;

    case 'savegroup':
	$mcloud_fc->group_save($option);
    break;

    case 'group_medium_delete':
	throw new Exception("a");
    break;

    case 'group-edit':
    case 'group_edit':
	require_once(MCLOUD_PREFIX.'/views/group-edit/MCloud_View_GroupEdit.class.php');
	$view = new MCloud_View_GroupEdit();
	$view->show($option);
    break;

    case 'group_medium_approve':
        require_once(MCLOUD_PREFIX.'/mcloud.html.php');
	$remoteclient->groupMediumApprove($my->username,$_REQUEST{'group_id'},$_REQUEST{'medium_id'});
	Header("Location: ".$mcloud_url->group_show_url($_REQUEST{'group_id'}));
	exit;
    break;

    case 'group_medium_remove':
        require_once(MCLOUD_PREFIX.'/mcloud.html.php');
	$remoteclient->groupMediumRemove($my->username,$_REQUEST{'group_id'},$_REQUEST{'medium_id'});
	Header("Location: ".$mcloud_url->group_show_url($_REQUEST{'group_id'}));
	exit;
    break;

    case 'group_user_approve':
        require_once(MCLOUD_PREFIX.'/mcloud.html.php');
	$x = $remoteclient->groupMemberApprove($my->username,$_REQUEST{'group_id'},$_REQUEST{'user_ns'},$_REQUEST{'user_name'});
	Header("Location: ".$mcloud_url->group_show_url($_REQUEST{'group_id'}));
	exit;
    break;

    case 'group_user_remove':
        require_once(MCLOUD_PREFIX.'/mcloud.html.php');
	$x = $remoteclient->groupMemberRemove($my->username,$_REQUEST{'group_id'},$_REQUEST{'user_ns'},$_REQUEST{'user_name'});
	print serialize($x);
	Header("Location: ".$mcloud_url->group_show_url($_REQUEST{'group_id'}));
	exit;
    break;

    case 'joingroup':
	$mcloud_fc->group_join($option);
    break;

    case 'leavegroup':
	$mcloud_fc->group_leave($option);
    break;

    case 'my-groups':
	require_once(MCLOUD_PREFIX.'/views/user-groups/MCloud_View_UserGroups.class.php');
	$view = new MCloud_View_UserGroups();
	$view->show($option);
    break;

    case 'my-memberships':
	require_once(MCLOUD_PREFIX.'/views/my-memberships/MCloud_View_MyMemberships.class.php');
	$view = new MCloud_View_MyMemberships();
	$view->show($option);
    break;

    case 'medium-delete':
	$mcloud_fc->medium_delete($option);
    break;

    case 'medium-buy':
	$mcloud_fc->medium_buy($option);
    break;

    case 'ajaxadd2group':
        MCloud_AJAX::add2group();
    break;

    case 'add_media_comment':
	$mcloud_fc->medium_comment_add();
    break;

    case 'grpmove':
	$mcloud_fc->group_media_move($option);
    break;

    case 'my-frontpage':
	require_once(MCLOUD_PREFIX.'/views/my-frontpage/MCloud_View_MyFrontpage.class.php');
	$view = new MCloud_View_MyFrontpage();
	$view->show($option);
    break;

	// these go throw the new MVC system
	case 'addlivestream':
	case 'grouplist':
	case 'groupshow':
	case 'groupcreate':
	case 'groupedit':
	case 'grouplistmulticol':
	case 'mediumshow':
	case 'upload':
		require_once(MCLOUD_PREFIX.'/mcloud-main.php');
	break;

	// if nothing else matches
	case 'frontpage':
	default:
		require_once(MCLOUD_PREFIX.'/views/frontpage/MCloud_View_Frontpage.class.php');
		$view = new MCloud_View_Frontpage();
		$view->show($option);
	break;
}
