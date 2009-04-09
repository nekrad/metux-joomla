<?php
defined('_JEXEC') or die('Restricted access');

ini_set('include_path', ini_get('include_path').':libraries/plutos');

$juser    = & JFactory::getUser();
$jlang    = & JFactory::getLanguage();
$jlang->load(JRequest::getString('option'));

// Require the com_content helper library
require_once (JPATH_COMPONENT.DS.'JPatTemplateView.class.php');
require_once (JPATH_COMPONENT.DS.'controller.php');

JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');

// Create the controller
$controller = new MCloudController( );

// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
