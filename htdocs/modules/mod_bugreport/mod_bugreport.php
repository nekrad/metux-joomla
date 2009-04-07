<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

function mod_bugreport_send($params, $data)
{
	$email     = $params->get('email');
	$subject   = $params->get('subject');
	$sender    = $params->get('sender');
	$url       = JRequest::getString('mod_bugreport_url');
	$message   = JRequest::getString('mod_bugreport_message');
	$component = JRequest::getString('option');

	mail($email, 
	     $subject, 
		"Component: $component\n".
		"URL:       $url\n".
		"\n".
		$message,
	    "From: ".$sender
	);
}

if ((JRequest::getString('mod_bugreport_message')))
{
	mod_bugreport_send($params);
	header("Location: ".JRequest::getString('mod_bugreport_kickback'));
	exit;
}
else
{
	$mod_bugreport_kickback   = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$mod_bugreport_url        = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$mod_bugreport_sendbutton = 'Send';
	$mod_bugreport_option     = JRequest::getString('option');

	require(JModuleHelper::getLayoutPath('mod_bugreport'));
}
