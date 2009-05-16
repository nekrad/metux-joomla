<?php
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
//************************************************************************************
if (!DEFINED('Joomla')) DEFINE('Joomla',$evolution.'.'.$generation.'.'.$breed);

?>
