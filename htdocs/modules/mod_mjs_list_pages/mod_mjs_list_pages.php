<?php
/*
MOD_VIEWMJSPAGES.PHP
Package myJSpace
Copyright 2008 D'Abronzo Vincenzo/ ~ jalil ~ All rights reserved.
Lcense GNU / GPL
Author D'Abronzo Vincenzo
*/

/* 
MyJSpace is free software. This version may have been modified pursuant
to the GNU General Public License, and as distributed it includes or
is derivative of works licensed under the GNU General Public License or
other free or open source software licenses.
*/

/* 
VERSION 13 BUILD 009
*/

// top level error control
error_reporting(E_ALL);
error_reporting(0);

if (!defined( '_MJSEXEC' )) define( '_MJSEXEC', 1 );
if (!defined( 'DS')) define( 'DS', DIRECTORY_SEPARATOR );

//----------------------------------------------------
// Get Joomla Version
//----------------------------------------------------

$f=('get_version_info.php');
$c='components'.DS.'com_myjspace'.DS.$f; 	// component version file
$m='modules'.DS.dirname(__FILE__).DS.dirname(__FILE__).$f; 	// module version file

if (file_exists($c)) 

	{ include_once($c); } 	

else if (file_exists($m)) 

	{ include_once($m); } 	

else	
{ 

	/*==================================================================================
	* GET VERSION INFO :: Build 010
	* Jalil Latiff :: April 2008 , Kuala Lumpur, Malaysia.
	* =================================================================================*/
	defined( '_JEXEC' ) or defined( '_VALID_MOS' ) or die( 'Restricted access' );
	
	if ( defined( 'Joomla' ) OR defined( '_J1' ) OR defined( '_J5' ) ) return;
	
	//.................................................................................
	if (function_exists('jimport')) 
	{ jimport('joomla.version'); $instance =new JVersion(); }
	else
	{
	if (class_exists('joomlaVersion')) { $instance = new joomlaVersion(); } 
		else 
		{
		 // echo ' Joomla Version not discovered' ; // assume J5 legacy mode
		if (!defined('_J1')) DEFINE('_J1',2); 
		if (!defined('_J5')) DEFINE('_J5',0);  
		if (!DEFINED('Joomla')) DEFINE('Joomla',' Virtual Joomla 1.5 Legacy Mode ');
		return;
		 }
	}
	$L_version=$instance->getLongVersion(); $S_version=$instance->getShortVersion();
	$version=trim($S_version); 
	$family=explode('.',$S_version);
	$evolution=$family[0]; 
	$generation=$family[1]; 
	$breed=$family[2];
	/*--------------------------------------------------------------------------------
	* END GET VERSION INFO
	*--------------------------------------------------------------------------------*/
	
	if ($evolution<>1)
	{
	Die('Application Written for Joomla Version 1.X Only');
	}
	
	/****************************************
	* Legacy Mode for 1.5
	*****************************************/
	if ( defined( '_JEXEC' ) AND defined( '_VALID_MOS' ) )
	{	
	if (!defined('_J1')) DEFINE('_J1',2); 
	if (!defined('_J5')) DEFINE('_J5',0);  
	if (!DEFINED('Joomla')) DEFINE('Joomla',$evolution.'.'.$generation.'.'.$breed.' Legacy Mode');
	}
	else
	{
		/*.............................
		* Joomla 1.0
		*..............................*/
		if ( defined( '_VALID_MOS' ) AND ($generation<5) )
		{
		if (!defined('_J1')) DEFINE('_J1',1); 
		if (!defined('_J5')) DEFINE('_J5',0);  
		}
	
		/*.............................
		* Joomla 1.5
		*..............................*/
		if (defined( '_JEXEC' ) AND ($generation>=5) )
		{
		if (!defined('_J1')) DEFINE('_J1',0); 
		if (!defined('_J5')) DEFINE('_J5',1);  
		}
	}
	//*******************************************************************************************
	if (!DEFINED('Joomla')) DEFINE('Joomla',$evolution.'.'.$generation.'.'.$breed);
	//*******************************************************************************************
}


//************************************************************************************
// Joomla Version CODES
//************************************************************************************
// Get object database
if (constant('_J1'))
{
//.........................................................
global $database;
$db = $database;
}

if (constant('_J5'))
{
//.........................................................
// Get object database
$db =& JFactory::getDBO();
//.........................................................
}

//************************************************************************************
// COMMON VERSION MJS CODES
//************************************************************************************

// Show module

require_once( dirname(__FILE__).DS.'mod_mjs_list_pages.class.php' );
require_once( dirname(__FILE__).DS.'mod_mjs_list_pages.html.php' );

$mjsmod 	= 	new mod_mjs_list_pages();
$_html		=	new HTML_mod_mjs_list_pages();

$mjsmod->setDatabase($db);
$mjsmod->setParams($params);
$mjsmod->getPostsSetVars($_POST); // sets user preferences

$mjsmod->setHTML($_html);

$mjsmod->show();

//************************************************************************************
// END COMMON VERSION MJS CODES
//************************************************************************************

