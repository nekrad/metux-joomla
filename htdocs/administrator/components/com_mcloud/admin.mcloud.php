<?php

(defined('_VALID_MOS') or defined('_JEXEC')) or die( 'Direct Access to this location is not allowed.' );

define( 'JMCLOUD_ADMIN_PATH', dirname(__FILE__) );

require_once(JMCLOUD_ADMIN_PATH.'/mcloud.php');
require_once(JMCLOUD_ADMIN_PATH.'/../../includes/pageNavigation.php');
require_once(JMCLOUD_ADMIN_PATH.'/config.mcloud.php');
require_once(JMCLOUD_ADMIN_PATH.'/source/JMCloud_Admin_GeneralSettings.class.php');
require_once(JMCLOUD_ADMIN_PATH.'/source/JMCloud_Admin_ServerSettings.class.php');
require_once(JMCLOUD_ADMIN_PATH.'/source/JMCloud_Admin_Users.class.php');
require_once(JMCLOUD_ADMIN_PATH.'/source/JMCloud_Admin_Homepage.class.php');

switch($_REQUEST{'task'})
{
    case 'users':
	jmcloud_admin_users::showusers($option);
    break;

    case 'edituser':
	jmcloud_admin_users::edituser($option, $_REQUEST{'user_ns'}, $_REQUEST{'user_name'});
    break;

    case 'saveuser':
	jmcloud_admin_users::saveuser($option);
    break;
	
    case 'serversettings':
	jmcloud_admin_serversettings::show($option);
    break;

    case 'saveserver':
	jmcloud_admin_serversettings::save($option);
    break;

    case 'generalsettings':
	jmcloud_admin_generalsettings::show($option);
    break;

    case 'savegeneral':
	jmcloud_admin_generalsettings::save($option);
    break;

    default:
	JMCloud_Admin_Homepage::show($option);
	break;
}
