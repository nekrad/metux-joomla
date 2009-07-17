<?php
/**
* Users Online Module
* $Id: mod_comprofileronline.php 434 2006-10-08 01:55:29Z beat $
* 
* @package Community Builder
* @Copyright (C) 2000 - 2003 Miro International Pty Ltd
* @ All rights reserved
* @ Mambo Open Source is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version 1.0.2
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function getNameFormatOnline($name,$uname,$format) {
	if ( $format != 3 ) {
		$name	=	str_replace( array("&amp;","&quot;","&#039;","&lt;","&gt;"), array("&","\"","'","<",">"), $name );
	}
	SWITCH ($format) {
		CASE 1 :
			$returnName = $name;
		break;
		CASE 2 :
			$returnName = $name." (".$uname.")";
		break;
		CASE 3 :
			$returnName = $uname;
		break;
		CASE 4 :
			$returnName = $uname." (".$name.")";
		break;
	}
	return $returnName;
}

global $mainframe, $ueConfig;
include_once( $mainframe->getCfg('absolute_path')."/administrator/components/com_comprofiler/ue_config.php" );

if (is_callable(array($params,"get"))) {				// Mambo 4.5.0 compatibility
	$class_sfx	= $params->get( 'moduleclass_sfx');
	$pretext 	= $params->get( 'pretext', "" );
	$posttext 	= $params->get( 'posttext', "" );
} else {
	$class_sfx = "";
	$pretext = "";
	$posttext = "";
}

$query = "SELECT DISTINCT a.username, a.userid, u.name"
."\n FROM #__session AS a, #__users AS u"
."\n WHERE (a.userid=u.id) AND (a.guest = 0) AND (NOT ( a.usertype is NULL OR a.usertype = '' ))"
."\n ORDER BY ".(($ueConfig['name_format'] > 2) ? "a.username" : "u.name")." ASC";
$database->setQuery($query);
$rows = $database->loadObjectList();
$result = "";
if (count($rows) > 0) {
	$result .= "<ul class='mod_login".$class_sfx."'>\n";	// style='list-style-type:none; margin:0px; padding:0px; font-weight:bold;'
	foreach($rows as $row) {
		$result.= "<li><a href='".sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;user=$row->userid")
				."' class='mod_login".$class_sfx."'>".htmlspecialchars(getNameFormatOnline($row->name,$row->username,$ueConfig['name_format']))."</a></li>\n";
	}
	$result .= "</ul>\n";
	if ($pretext != '') $result = $pretext."<br />\n".$result;
	$result .= $posttext;
} else {
	if ( defined( "_NONE" ) ) {
		$result .= _NONE;
	} elseif ( class_exists( "JText" ) ) {	// Joomla 1.5:
		$result .= JText::_( "NONE" );
	} elseif ( is_callable( "T_" ) ) {	// Mambo 4.6.x:
		$result .= T_( "None" );
	}
}
echo $result;
?>
