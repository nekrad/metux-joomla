<?php
/*
MOD_GET_VERSION_INFO.PHP
Package Joomla Utilities
Copyright 2008 ~ jalil ~ All rights reserved.
License GNU / GPL
Author ~ jalil ~
*/

/* 
Open Source.
*/

/* 
VERSION 1 BUILD 001 001
*/

/* 
*/

/* Changelog
*/

define( 'TEST','TEST');
if (defined( 'TEST' )) error_reporting(E_ALL); else error_reporting(0);

// no direct access
defined( '_JEXEC' ) or defined( '_VALID_MOS' ) or die( 'Restricted access' );

if (!defined( 'DS')) define( 'DS', DIRECTORY_SEPARATOR );

//************************************************************************************
// COMMON VERSION CODES
//************************************************************************************

echo '
<div style="padding:10px; background:#ffffae;color:blue;border:1px dotted blue;">
Module get version is a place holder for "get_version_info.php".<br />
The module does not do anything, other than provide access to this file.<br /> 
</div>';



//************************************************************************************
// END COMMON VERSION CODES
//************************************************************************************

