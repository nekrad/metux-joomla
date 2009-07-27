<?php
/**
 * This file is part of Joomla Estate Agency - Joomla! extension for real estate agency
 * 
 * @version     O.7 2009-01-22
 * @package		Jea.site
 * @copyright	Copyright (C) 2008 PHILIP Sylvain. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla Estate Agency is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses.
 * 
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'jea.class.php';
require_once('mcloud-client.conf.php');
require_once('MC_RemoteClient.class.php');

global $mcloud_remoteclient;
$mcloud_remoteclient = new MC_RemoteClient(array
(
    'namespace' => MEDIACLOUD_SRV_NAMESPACE,
    'prefix'    => MEDIACLOUD_SRV_PREFIX,
    'secret'    => MEDIACLOUD_SRV_SECRET
));                                                                                                       

//add ACL
$acl = & JFactory::getACL();
$acl->addACL( 'com_jea', 'edit', 'users', 'jea agent', 'property', 'own' );
$acl->addACL( 'com_jea', 'edit', 'users', 'manager', 'property', 'all' );
$acl->addACL( 'com_jea', 'edit', 'users', 'administrator', 'property', 'all' );
$acl->addACL( 'com_jea', 'edit', 'users', 'super administrator', 'property', 'all' );

ComJea::run('properties');
