<?php

# (defined('_VALID_MOS') or defined('_JEXEC')) or die( 'Direct Access to this location is not allowed.' );

ini_set('include_path', ini_get('include_path').':../');

require_once('mcloud-client.conf.php');

ini_set('include_path', ini_get('include_path').':'.MEDIACLOUD_CLASSES);

require_once('MC_ClientHelper.class.php');
require_once('MC_RemoteClient.class.php');

global $remoteclient;

$remoteclient = new MC_RemoteClient(array(
    'namespace'	=> MEDIACLOUD_SRV_NAMESPACE,
    'prefix'	=> MEDIACLOUD_SRV_PREFIX,
    'secret'	=> MEDIACLOUD_SRV_SECRET
));
