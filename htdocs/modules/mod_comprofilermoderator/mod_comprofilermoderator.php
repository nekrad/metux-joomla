<?php
/**
* CB Moderator Module
* $Id: mod_comprofilermoderator.php 554 2006-11-18 02:47:54Z beat $
* 
* @package Community Builder 1.1
* @subpackage CB Moderator Module
* @Copyright (C) MamboJoe and Beat at www.joomlapolis.com
* @ All rights reserved
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $ueConfig, $Itemid, $my;

if ( ! ( $my->id > 0 ) ) {
	// mosNotAuth();
	return;
}

if (is_callable(array($params,"get"))) {				// Mambo 4.5.0 compatibility
	$class_sfx	= $params->get( 'moduleclass_sfx', "");
	$pretext 	= $params->get( 'pretext', "" );
	$posttext 	= $params->get( 'posttext', "" );
} else {
	$class_sfx = "";
	$pretext = "";
	$posttext = "";
}

$UEAdminPath=$mainframe->getCfg( 'absolute_path' ).'/administrator/components/com_comprofiler';
$UElanguagePath=$mainframe->getCfg( 'absolute_path' ).'/components/com_comprofiler/plugin/language';
if (file_exists($UElanguagePath.'/'.$mosConfig_lang.'/'.$mosConfig_lang.'.php')) {
	include_once($UElanguagePath.'/'.$mosConfig_lang.'/'.$mosConfig_lang.'.php');
} else {
	include_once($UElanguagePath.'/default_language/default_language.php');
}
include_once($UEAdminPath."/ue_config.php");

// copied from comprofiler.class.php:

		function cbmodUserGID($oID){
		  	global $database;
			if($oID > 0) {
			$query = "SELECT gid FROM #__users WHERE id = '".$oID."'";
			$database->setQuery($query);
			$gid = $database->loadResult();
			return $gid;
			}
			else return 0;
		}
		
		function cbmodCheckJversion() {
			global $_VERSION;
			if ($_VERSION->PRODUCT == "Mambo") {
				$version = 0;
			} elseif ($_VERSION->PRODUCT == "Joomla!") {
				if (strncasecmp($_VERSION->RELEASE, "1.0", 3)) {
					$version = 1;
				} else {
					$version = 0;
				}
			}
			return $version;
		}
	
		function cbmodGetParentGIDS($gid) {
			global $database;
 			if (cbmodCheckJversion() == 0) {
              	$query="SELECT g1.group_id, g1.name"
				."\n FROM #__core_acl_aro_groups g1"
				."\n LEFT JOIN #__core_acl_aro_groups g2 ON g2.lft <= g1.lft"
				."\n WHERE g2.group_id =".$gid
				."\n ORDER BY g1.name";
 			} else {
              	$query="SELECT g1.id AS group_id, g1.name"
				."\n FROM #__core_acl_aro_groups g1"
				."\n LEFT JOIN #__core_acl_aro_groups g2 ON g2.lft <= g1.lft"
				."\n WHERE g2.id =".$gid
				."\n ORDER BY g1.name";
 			}
               	$database->setQuery( $query );
				$array=$database->loadResultArray();
				if ($array===null) $array=array();
				return $array;
	}

function cbmodIsModerator($oID){
  	global $ueConfig;
	if(in_array(cbmodUserGID($oID), cbmodGetParentGIDS($ueConfig['imageApproverGid']))) {
		return true;
	} else {
		return false;
	}
}

function cbmod_getItemid() {
	global $database;

	$database->setQuery("SELECT id FROM #__menu WHERE link = 'index.php?option=com_comprofiler' AND published=1");
	$cbItemid = $database->loadResult();
	if (is_numeric($cbItemid)) {
		$andItemid = "&amp;Itemid=".$cbItemid;
	} else {
		$andItemid = "";
	}
	return $andItemid;
}

$results = null;
$andItemid = null;

	$query = "SELECT banned FROM #__comprofiler WHERE id = " . $my->id;
	if(!$database->setQuery($query)) print $database->getErrorMsg();
	$myBanStatus = $database->loadResult();

	if ($andItemid === null) $andItemid = cbmod_getItemid();

	if($myBanStatus > 0) $results .= "<div><a href='".sefRelToAbs("index.php?option=com_comprofiler".$andItemid)."' class='mod_login".$class_sfx."'>" . ( ( $myBanStatus == 1 ) ? _UE_PLEAE_CHECK_PROFILE : _UE_BANSTATUS_UNBAN_REQUEST_PENDING ) . "</a></div>";

if (cbmodIsModerator($my->id)) {
	$query = "SELECT count(*) FROM #__comprofiler  WHERE avatarapproved=0 AND approved=1 AND confirmed=1 AND banned=0";
	if(!$database->setQuery($query)) print $database->getErrorMsg();
	$totalimages = $database->loadResult();

	$query = "SELECT count(*) FROM #__comprofiler_userreports  WHERE reportedstatus=0 ";
	if(!$database->setQuery($query)) print $database->getErrorMsg();
	$totaluserreports = $database->loadResult();

	$query = "SELECT count(*) FROM #__comprofiler WHERE banned=2 AND approved=1 AND confirmed=1";
	if(!$database->setQuery($query)) print $database->getErrorMsg();
	$totalunban = $database->loadResult();

	$query = "SELECT count(*) FROM #__comprofiler WHERE approved=0 AND confirmed=1 ";
	if(!$database->setQuery($query)) print $database->getErrorMsg();
	$totaluserpendapproval = $database->loadResult();

	if($totalunban > 0 || $totaluserreports > 0 || $totalimages > 0 || ($totaluserpendapproval > 0 && $ueConfig['allowModUserApproval'])) {
		
		if($totalunban > 0) $results .= "<div><a href='".sefRelToAbs("index.php?option=com_comprofiler&amp;task=moderateBans".$andItemid)."' class='mod_login".$class_sfx."'>".$totalunban." "._UE_UNBANREQUIREACTION."</a></div>";
		if($totaluserreports > 0) $results .= "<div><a href='".sefRelToAbs("index.php?option=com_comprofiler&amp;task=moderateReports".$andItemid)."' class='mod_login".$class_sfx."'>".$totaluserreports." "._UE_USERREPORTSREQUIREACTION."</a></div>";
		if($totalimages > 0) $results .= "<div><a href='".sefRelToAbs("index.php?option=com_comprofiler&amp;task=moderateImages".$andItemid)."' class='mod_login".$class_sfx."'>".$totalimages." "._UE_IMAGESREQUIREACTION."</a></div>";
		if($totaluserpendapproval > 0 && $ueConfig['allowModUserApproval']) $results .= "<div><a href='".sefRelToAbs("index.php?option=com_comprofiler&amp;task=pendingApprovalUser".$andItemid)."' class='mod_login".$class_sfx."'>".$totaluserpendapproval." "._UE_USERPENDAPPRACTION."</a></div>";
	}
}
if($ueConfig['allowConnections']) {
	
	if ($andItemid === null) $andItemid = cbmod_getItemid();
	$query = "SELECT count(*) FROM #__comprofiler_members WHERE pending=1 AND memberid=". $my->id;
	if(!$database->setQuery($query)) print $database->getErrorMsg();
	$totalpendingconnections = $database->loadResult();
	if($totalpendingconnections > 0) {
		$results .= "<div><a href='".sefRelToAbs("index.php?option=com_comprofiler&amp;task=manageConnections".$andItemid)."' class='mod_login".$class_sfx."'>".$totalpendingconnections." "._UE_CONNECTIONREQUIREACTION."</a></div>";
	}	
}

if($results==null) {
	echo _UE_NOACTIONREQUIRED;
} else {
	if($pretext != "") echo "<div>".$pretext."</div>";
	echo $results;
	if($posttext != "") echo "<div>".$posttext."</div>";
}
?>
