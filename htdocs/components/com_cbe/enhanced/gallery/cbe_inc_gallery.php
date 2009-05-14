<?php
//***********************************************
// CBE-Gallery by Michael Neufing               *
// Copyright (c) 2007 Michael Neufing           *
// http://www.k-b-j.de.vu                       *
// Released under the GNU/GPL License           *
// Version 1.3 File date: 10-04-2007            *
//***********************************************

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/*
$cbe_gallery_config_path = JPATH_SITE.'/administrator/components/com_cbe/enhanced_admin/custom_configs/cbe_gallery_config.php';
$cbe_gallery_config_pathFB = JPATH_SITE.'/components/com_cbe/enhanced/gallery/cbe_gallery_config.php';

if (file_exists($cbe_gallery_config_path)) {
	include($cbe_gallery_config_path);
} else if (file_exists($cbe_gallery_config_pathFB)) {
	include($cbe_gallery_config_pathFB);
} else {
	echo "INSTALL 3rd Party CBE-Gallery FIRST!<br>\n";
	$do_die = 1;
}
*/
$cbe_gallery_installed = 1;
/****************************************************************************************/
// begin defintion of additional needed functions //

function approveGallery() {
	global $database,$_POST,$_REQUEST,$my,$ueConfig;
	global $cbe_gallery_config;
	// include (JPATH_SITE."/components/com_cbe/enhanced/gallery/config.inc.php");
	$isModerator=isModerator($my->id);
	if ($isModerator == 0) {
		mosNotAuth();
		return;
	}
	$avatars=array();
	if(isset($_POST['avatar'])) $avatars=$_POST['avatar'];
	else $avatars[] = $_REQUEST['avatars'];
	if(isset($_POST['act'])) $act=$_POST['act'];
	else $act = $_REQUEST['flag'];
	if($act=='1') {
		foreach ($avatars AS $avatar) {
			$query = "UPDATE #__cbe_gallery SET approved='1' WHERE id = '" . cbGetEscaped($avatar) . "'";
			$database->setQuery($query);
			$database->query();
		}
	} else {
		foreach ($avatars AS $avatar) {
			$query = "SELECT datei FROM #__cbe_gallery WHERE id='".$avatar."'";
			$database->setQuery($query);
			$file = $database->loadResult();
			
			$query = "SELECT uid FROM #__cbe_gallery WHERE id='".$avatar."'";
			$database->setQuery($query);
			$uid = $database->loadResult();
			
			unlink($cbe_gallery_config['dir'].$uid."/".$file);
			if(is_file($cbe_gallery_config['dir'].$uid."/thumbs/".$file)) unlink($cbe_gallery_config['dir'].$uid."/thumbs/".$file);
			$query = "DELETE FROM #__cbe_gallery WHERE id='".$avatar."'";
			$database->setQuery($query);
			$database->query();
		}

	}
	if (!isset($_REQUEST['Itemid'])) {
		if ($GLOBALS['Itemid_com']!='') {
			$Itemid_c = $GLOBALS['Itemid_com'];
		} else {
			$Itemid_c = '';
		}
	} else {
		$Itemid_c = "&amp;Itemid=".$_REQUEST['Itemid'];
	}
	mosRedirect(sefRelToAbs('index.php?option=com_cbe'.$Itemid_c.'&task=moderateGallery'),_UE_USERIMAGEMODERATED_SUCCESSFUL);
}

/************ ModerateGallery Function ************************/

function moderateGallery($option) {
	global $database,$ueConfig,$limitstart,$my;
	global $cbe_gallery_config;
	
	$isModerator=isModerator($my->id);
	if ($isModerator == 0) {
		mosNotAuth();
		return;
	}
	if (!isset($_REQUEST['Itemid'])) {
		if ($GLOBALS['Itemid_com']!='') {
			$Itemid_c = $GLOBALS['Itemid_com'];
		} else {
			$Itemid_c = '';
		}
	} else {
		$Itemid_c = "&amp;Itemid=".$_REQUEST['Itemid'];
	}

	$ue_base_url = "index.php?option=com_cbe&amp;task=moderateGallery".$Itemid_c;	// Base URL string


	$query = "SELECT count(*) FROM #__cbe_gallery WHERE approved=0";
	if(!$database->setQuery($query)) print $database->getErrorMsg();
	$total = $database->loadResult();



	if (empty($limitstart)) $limitstart = 0;
	$limit = 20;
	if ($limit > $total) {
		$limitstart = 0;
	}

	$query = "SELECT * FROM #__cbe_gallery WHERE approved=0";
	$query .= " LIMIT $limitstart, $limit";
	$database->setQuery($query);
	$row = $database->loadObjectList();

	echo "<style>\n";
	echo ".titleCell {\n";
	echo "	font-weight:bold;\n";
	echo "	width:85px;\n";
	echo "}\n";
	echo "</style>\n";
	echo "<script>\n";
	echo "function cbe_gallery_approve() {\n";
	echo "	//imageAdmin.action='index.php?option=com_cbe&amp;task=approveImage';\n";
	echo "	document.imageAdmin.act.value='1';\n";
	echo "	document.imageAdmin.submit();\n";
	echo "}\n";
	echo "\n";
	echo "function cbe_gallery_reject() {\n";
	echo "	//imageAdmin.action='index.php?option=com_cbe&amp;task=approveImage';\n";
	echo "	document.imageAdmin.act.value='0';\n";
	echo "	document.imageAdmin.submit();\n";
	echo "}\n";
	echo "\n";
	echo "</script>\n";

	echo "<!-- TAB -->\n";
	echo "<table cellspacing=\"0\" cellpadding=\"4\" border=\"0\" width=\"100%\">\n";
	echo "<tr>\n";
	echo "\t<td class=\"componentheading\" colspan=\"6\">"._UE_MODERATE_TITLE."</td>\n";
	echo "</tr>\n";
	echo "</table>\n";

	if($total<1) {
		echo _UE_NOIMAGESTOAPPROVE;
		return;
	}
	echo "<span class='contentheading'>"._UE_IMAGE_MODERATE."</span><br><br>\n";
	if(count($row) > $limit) {
		echo "<div style=\"width:100%;text-align:center;\">".cbe_writePagesLinks($limitstart, $limit, $total, $ue_base_url)."</div><hr>\n";
	}
	echo "<table width='100%' border='0' cellpadding='4' cellspacing='2'>\n";
	echo "<form action='index.php?option=com_cbe&amp;task=approveGallery".$Itemid_c."' method='post' name='imageAdmin'>\n";
	echo "<tr align='center' valign='middle'>\n";
	echo "<td colspan=\"4\">&nbsp;</td></tr>\n";
	echo "<tr align='center' valign='middle'>\n";
	for($i = 0; $i < count($row); $i++) {
		$rel_dir = str_replace(JPATH_SITE, '', $cbe_gallery_config['dir']);
		$rel_dir = preg_replace('/^\//','', $rel_dir);
		$avatar_gallery_path=$rel_dir.$row[$i]->uid.'/thumbs/';
		$avatar_gallery_path2=$rel_dir.$row[$i]->uid.'/';
		$sys_gallery_path='components/com_cbe/images/';
		$j=$i+1;
		$image=$avatar_gallery_path.$row[$i]->datei;
		echo "<td>\n";
		echo "<img style=\"cursor:hand;\" src=\"".$image."\" onclick=\"this.src='".$avatar_gallery_path2.$row[$i]->datei."'\" /><br />\n";
		echo "<label for='img".$row[$i]->id."'>".$row[$i]->titel."<input id='img".$row[$i]->id."' type=\"checkbox\" name=\"avatar[]\" value=\"".$row[$i]->id."\"></label>\n";
		echo "<br /><img style='cursor:hand;' onclick='javascript:window.location=\"".sefRelToAbs("index.php?option=com_cbe".$Itemid_c."&amp;task=approveGallery&amp;flag=1&amp;avatars=".$row[$i]->id."&amp;uid=".$row[$i]->uid)."\"' src='".$sys_gallery_path."approve.png' title='Approval Image'> <img style='cursor:hand;' src='".$sys_gallery_path."reject.png' onclick='javascript:window.location=\"".sefRelToAbs("index.php?option=com_cbe&amp;task=approveGallery&amp;flag=0&amp;avatars=".$row[$i]->id."&amp;uid=".$row[$i]->uid)."\"' title='Reject Image'> <img style='cursor:hand;' src='".$sys_gallery_path."updateprofile.gif' title='View Profile' onclick='javascript:window.location=\"".sefRelToAbs("index.php?option=com_cbe".$Itemid_c."&amp;task=userProfile&amp;user=".$row[$i]->uid)."\"'>\n";
		echo "</td>\n";
		if (function_exists('fmod')) {
			if (!fmod(($j),4)){ echo "</tr><tr align=\"center\" valign=\"middle\">\n"; }
		} else {
			if (!fmodReplace(($j),4)){ echo "</tr><tr align=\"center\" valign=\"middle\">\n"; }
		}

	}
	echo "</tr>\n";
	echo "<tr><td colspan=\"4\" align=\"center\"><input class=\"button\" onclick=\"javascript:cbe_gallery_approve();\" type=\"button\" value=\""._UE_APPROVE_IMAGES."\"><input class=\"button\" onclick=\"javascript:cbe_gallery_reject();\" type=\"button\" value=\""._UE_REJECT_IMAGES."\">\n";
	echo "</table>\n";
	echo "<input type=hidden name=\"act\" value=\"\">\n";
	echo "</form>\n";
	if(count($row) > $limit) { 
		echo "<hr><div style=\"width:100%;text-align:center;\">".cbe_writePagesLinks($limitstart, $limit, $total, $ue_base_url)."</div>\n";
	}
}

function check_gallery_mtask() {
	global $database;
	
	$query = "SELECT count(*) FROM #__cbe_gallery WHERE approved=0";
	if(!$database->setQuery($query)) print $database->getErrorMsg();
	$totalgallery = $database->loadResult();

	return $totalgallery;
}

?>