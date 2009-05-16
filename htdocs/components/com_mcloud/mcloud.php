<?php
(defined('_VALID_MOS') or defined('_JEXEC')) or die( 'Direct Access to this location is not allowed.' );

// declare global variables
global $mosConfig_live_site, $limitstart, $mainframe, $Itemid;

// define a (safe filepath) named constant
define( 'MCLOUD_PREFIX', dirname(__FILE__) );

require_once(MCLOUD_PREFIX.'/../../administrator/components/com_mcloud/config.mcloud.php');
require_once(MCLOUD_PREFIX.'/../../administrator/components/com_mcloud/mcloud.php');
require_once(MCLOUD_PREFIX.'/source/MCloud_URL.class.php');
require_once(MCLOUD_PREFIX.'/source/MCloud_Viewer.class.php');
require_once(MCLOUD_PREFIX.'/source/MCloud_AJAX.class.php');
require_once(MCLOUD_PREFIX.'/source/MCloud_Access.class.php');
require_once(MCLOUD_PREFIX.'/helpers.php');
require_once(MCLOUD_PREFIX.'/source/MCloud_Frontend_Controller.class.php');
require_once(MCLOUD_PREFIX.'/mcloud.html.php');

global $mcloud_url, $mcloud_fc, $mcloud_config, $mcloud_access;

$mcloud_url    = new MCloud_URL();
$mcloud_fc     = new MCloud_Frontend_Controller();
$mcloud_config = new mcloud_client_config();
$mcloud_access = new MCloud_Access($remoteclient, $my);

require_once( $mainframe->getPath( 'front_html' ) );

// get $limitstart from global $_REQUEST for page navigation
$limitstart = @intval($_REQUEST{'limitstart'});

/* --- catch out new tasks and send them to the mvc front controller --- */
switch($_REQUEST{'task'})
{
	case 'group_delete':
	case 'group_create':
	case 'group_update':
	case 'medium_recommend':
	case 'medium_comment':
	case 'upload':
		require_once(MCLOUD_PREFIX.'/mcloud-main.php');
	break;
	default:
		require_once(MCLOUD_PREFIX.'/old-controller.php');		
}

function allowed_groups()
{
    global $my;
#    if (($my) && ($my->usertype == "Super Administrator"))
	return true;
#    else
#	return false;
}

function allowed_upload()
{
    return true;
}

function allowed_group_memberlist()
{
    return false;
}




































































































print "<font color=\"white\">metux mediacloud -- copyright (C) 2008 metux IT services - <a style=\"color: white\" href=\"http://www.metux.de/\">www.metux.de</a></font>";
