<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $mainframe, $mosConfig_sitename;
$mosConfig_sitename =  $mainframe->getCfg('sitename');

//FUNCTIONS
/**
* Page navigation support functions
*
* Input:
* $limitstart (int The record number to start dislpaying from)
* $limit (int Number of rows to display per page)
* $total (int Total number of rows)
*/

/**
* Writes the html links for pages, eg, previous 1 2 3 ... x next
*/

function cbe_writePagesLinks($limitstart, $limit, $total,$ue_base_url,$search=null) {
	GLOBAL $search_query;
	GLOBAL $pages_in_list;
	$pages_in_list = 10;                // set how many pages you want displayed in the menu
	$displayed_pages = $pages_in_list;
	$total_pages = ceil( $total / $limit );
	$this_page = ceil( ($limitstart+1) / $limit );
	$start_loop = (floor(($this_page-1)/$displayed_pages))*$displayed_pages+1;
	if ($start_loop + $displayed_pages - 1 < $total_pages) {
		$stop_loop = $start_loop + $displayed_pages - 1;
	} else {
		$stop_loop = $total_pages;
	}

	if (!empty($search)) {
		$search = "&amp;search=".$search;
	}

	if ($this_page > 1) {
		$page = ($this_page - 2) * $limit;
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart=0$search_query$search\" title=\"" . _UE_FIRST_PAGE . "\">&lt;&lt; " . _UE_FIRST_PAGE . "</a>";
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart=$page$search_query$search\" title=\"" . _UE_PREV_PAGE . "\">&lt; " . _UE_PREV_PAGE . "</a>";
	} else {
		echo '<span class="pagenav">&lt;&lt; '. _UE_FIRST_PAGE .'</span> ';
		echo '<span class="pagenav">&lt; '. _UE_PREV_PAGE .'</span> ';
	}

	for ($i=$start_loop; $i <= $stop_loop; $i++) {
		$page = ($i - 1) * $limit;
		if ($i == $this_page) {
			echo "\n <span class=\"pagenav\">$i</span> ";
		} else {
			echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart=$page$search_query$search\"><strong>$i</strong></a>";
		}
	}

	if ($this_page < $total_pages) {
		$page = $this_page * $limit;
		$end_page = ($total_pages-1) * $limit;
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart=$page$search_query$search\" title=\"" . _UE_NEXT_PAGE . "\">" . _UE_NEXT_PAGE . " &gt;</a>";
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart=$end_page$search_query$search\" title=\"" . _UE_END_PAGE . "\">" . _UE_END_PAGE . " &gt;&gt;</a>";
	} else {
		echo '<span class="pagenav">'. _UE_NEXT_PAGE .' &gt;</span> ';
		echo '<span class="pagenav">'. _UE_END_PAGE .' &gt;&gt;</span>';
	}
}

/**
* Writes the html for the pages counter, eg, Results 1-10 of x
*/


function cbe_writePagesCounter($limitstart, $limit, $total) {
	GLOBAL $usrl_base_url;
	$from_result = $limitstart+1;
	if ($limitstart + $limit < $total) {
		$to_result = $limitstart + $limit;
	} else {
		$to_result = $total;
	}
	if ($total > 0) {
		echo _UE_RESULTS . " <b>" . $from_result . " - " . $to_result . "</b> " . _UE_OF_TOTAL . " <b>" . $total . "</b>";
	} else {
		echo _UE_NO_RESULTS . ".";
	}
}

function isOdd($x){
	if($x & 1) return TRUE;
	else return FALSE;
}

function cbe_check_filesize($file,$maxSize) {

	$size = filesize($file);

	if($size <= $maxSize) {
		return true;
	}
	return false;
}

function cbe_check_image_type(&$type)
{
	switch( $type )
	{
		case 'jpeg':
		case 'pjpeg':
		case 'jpg':
		return '.jpg';
		break;
		case 'png':
		return '.png';
		break;
	}

	return false;
}

function display_avatar_gallery($avatar_gallery_path)
{
	$dir = @opendir($avatar_gallery_path);
	$avatar_images = array();
	$avatar_col_count = 0;
	while( $file = @readdir($dir) )
	{

		if( $file != '.' && $file != '..' && is_file($avatar_gallery_path . '/' . $file) && !is_link($avatar_gallery_path. '/' . $file) )
		{
			if( preg_match('/(\.gif$|\.png$|\.jpg|\.jpeg)$/is', $file) )
			{
				$avatar_images[$avatar_col_count] = $file;
				$avatar_name[$avatar_col_count] = ucfirst(str_replace("_", " ", preg_replace('/^(.*)\..*$/', '\1', $file)));
				$avatar_col_count++;
			}
		}
	}

	@closedir($dir);

	@ksort($avatar_images);
	@reset($avatar_images);

	return $avatar_images;
}

function display_watermarks($watermarks_path)
{
	$dir = @opendir($watermarks_path);
	$watermarks_images = array();
	$watermarks_col_count = 0;
	while( $file = @readdir($dir) )
	{

		if( $file != '.' && $file != '..' && is_file($watermarks_path . '/' . $file) && !is_link($watermarks_path. '/' . $file) )
		{
			if( preg_match('/(\.png$)$/is', $file) )
			{
				$watermarks_images[$watermarks_col_count] = $file;
				$watermarks_name[$watermarks_col_count] = ucfirst(str_replace("_", " ", preg_replace('/^(.*)\..*$/', '\1', $file)));
				$watermarks_col_count++;
			}
		}
	}

	@closedir($dir);

	@ksort($watermarks_images);
	@reset($watermarks_images);

	return $watermarks_images;
}

function cbe_fmodReplace($x,$y)
{ //function provided for older PHP versions which do not have an fmod function yet
	$i = floor($x/$y);
	return $x - $i*$y;
}

function cbe_getisp($ip='') {
	if ($ip=='') {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	$longisp = @gethostbyaddr($ip);
	$isp = explode('.', $longisp);
	$isp = array_reverse($isp);
	$tmp = $isp[1];
	if (preg_match("/\<(org?|com?|net)\>/i", $tmp)) {
		$myisp = $isp[2].'.'.$isp[1].'.'.$isp[0];
	} else {
		$myisp = $isp[1].'.'.$isp[0];
	}
	if (preg_match("/[0-9]{1,3}\.[0-9]{1,3}/", $myisp)) {
		$myisp = 'ISP lookup failed.';
	} 
	return $myisp;
}

function replaceVariables($emailMSG, $row, $includePWD, $ueConfig, $pwd_clear=''){
	global $mosConfig_live_site,$uDetails;

	$conf_hash = floatval($ueConfig['reg_confirmation_hash']);
	if($ueConfig['reg_confirmation']==1) $confirmLink = substr_replace(JURI::root(), '', -1, 1)."/index.php?option=com_cbe&task=confirm&confirmCode=".md5($row->id+$conf_hash);
	else $confirmLink = ' ';

//	$user_log_ip = $_SERVER['REMOTE_ADDR'];

	$emailMSG = str_replace("[USERNAME]", $row->username, $emailMSG);
	$emailMSG = str_replace("[NAME]", $row->name, $emailMSG);
	$emailMSG = str_replace("[EMAILADDRESS]", $row->email, $emailMSG);
	$emailMSG = str_replace("[PASSWORD-CLEAR]", $pwd_clear, $emailMSG);
	$emailMSG = str_replace("[SITEURL]", substr_replace(JURI::root(), '', -1, 1), $emailMSG);
	$emailMSG = str_replace("[DETAILS]", getUserDetails($row,$includePWD,$pwd_clear), $emailMSG);
	$emailMSG = str_replace("[CONFIRM]", $confirmLink, $emailMSG );
	$emailMSG = str_replace("[FULLDUMP]", getFullDump($row), $emailMSG );
	$emailMSG = str_replace("[REG-IP]", $_SERVER['REMOTE_ADDR'], $emailMSG );
	$emailMSG = str_replace("[REG-IP-DNS]", cbe_getisp(), $emailMSG );

	return $emailMSG;
}

function createEmail($row,$type,$ueConfig,$rowAdmin=null,$includePWD=0) {
	global $mosConfig_sitename;

// PK edit
	$ueConfig['reg_reject_sub']	= getLangDefinition($ueConfig['reg_reject_sub']);
	$ueConfig['reg_reject_msg']	= getLangDefinition($ueConfig['reg_reject_msg']);
	$ueConfig['reg_pend_appr_sub']	= getLangDefinition($ueConfig['reg_pend_appr_sub']);
	$ueConfig['reg_pend_appr_msg']	= getLangDefinition($ueConfig['reg_pend_appr_msg']);
	$ueConfig['reg_welcome_sub']	= getLangDefinition($ueConfig['reg_welcome_sub']);
	$ueConfig['reg_welcome_msg']	= getLangDefinition($ueConfig['reg_welcome_msg']);
	$ueConfig['reg_unregister_sub']	= getLangDefinition($ueConfig['reg_unregister_sub']);
	$ueConfig['reg_unregister_msg']	= getLangDefinition($ueConfig['reg_unregister_msg']);
// PK end

	SWITCH($type) {
		CASE 'reject':
		$subject = $mosConfig_sitename.' - '.$ueConfig['reg_reject_sub'];
		$msg =  $ueConfig['reg_reject_msg'];
		$to = $row->email;
		break;
		CASE 'pending':
		$subject = $mosConfig_sitename.' - '.$ueConfig['reg_pend_appr_sub'];
		$msg =  $ueConfig['reg_pend_appr_msg'];
		$to = $row->email;
		break;
		CASE 'welcome':
		$subject = $mosConfig_sitename.' - '.$ueConfig['reg_welcome_sub'];
		$msg =  $ueConfig['reg_welcome_msg'];
		$to = $row->email;
		break;
		CASE 'rejectUser':
		$subject = $mosConfig_sitename.' - '._UE_REG_REJECT_SUB;
		$msg =  sprintf(_UE_USERREJECT_MSG,$mosConfig_sitename,$rowAdmin);
		$to = $row->email;
		break;
		CASE 'imageApproved':
		$subject = $mosConfig_sitename.' - '._UE_IMAGEAPPROVED_SUB;
		$msg =  _UE_IMAGEAPPROVED_MSG;
		$to = $row->email;
		break;
		CASE 'imageRejected':
		$subject = $mosConfig_sitename.' - '._UE_IMAGEREJECTED_SUB;
		$msg =  _UE_IMAGEREJECTED_MSG;
		$to = $row->email;
		break;
		CASE 'unbanUser':
		$subject = $mosConfig_sitename.' - '._UE_UNBANUSER_SUB;
		$msg =  _UE_UNBANUSER_MSG;
		$to = $row->email;
		break;
		CASE 'banUser':
		$subject = $mosConfig_sitename.' - '._UE_BANUSER_SUB;
		$msg =  _UE_BANUSER_MSG;
		if ($row->block == 1) {
			$msg = _UE_CBE_BANUSER_BLOCK_MSG;
			$msg .= "\r\n --========-- \r\n ".$row->reason."\r\n --========-- \r\n\r\n";
		}
		$to = $row->email;
		break;
		CASE 'pendingAdmin':
		$subject = $mosConfig_sitename.' - '._UE_REG_ADMIN_PA_SUB;
		$msg =  _UE_REG_ADMIN_PA_MSG;
		$to = $rowAdmin->email;
		break;
		CASE 'welcomeAdmin':
		$subject = $mosConfig_sitename.' - '._UE_REG_ADMIN_SUB;
		$msg =  _UE_REG_ADMIN_MSG;
		$to = $rowAdmin->email;
		break;
		CASE 'imageAdmin':
		$subject = $mosConfig_sitename.' - '._UE_IMAGE_ADMIN_SUB;
		$msg =  _UE_IMAGE_ADMIN_MSG;
		$to = $rowAdmin->email;
		break;
		CASE 'unbanAdmin':
		$subject = $mosConfig_sitename.' - '._UE_UNBANUSERREQUEST_SUB;
		$msg =  _UE_UNBANUSERREQUEST_MSG;
		$to = $rowAdmin->email;
		break;
		CASE 'reportAdmin':
		$subject = $mosConfig_sitename.' - '._UE_USERREPORT_SUB;
		$msg =  _UE_USERREPORT_MSG;
		$to = $rowAdmin->email;
		break;
		CASE 'errorAdmin':
		$subject = $mosConfig_sitename.' - '."Registration error report";
		$msg =  $includePWD;
		$to = $rowAdmin->email;
		break;
//PK unregister
		CASE 'unregisterUser':
		$subject = $mosConfig_sitename.' - '._.$ueConfig['reg_unregister_sub'];
		$msg =  $ueConfig['reg_unregister_msg'];
		$to = $row->email;
		break;
		CASE 'unregisterAdmin':
		$subject = $mosConfig_sitename.' - '._UE_UNREGISTER_ADMIN_SUB;
		$msg =  _UE_UNREGISTER_ADMIN_MSG;
		$to = $rowAdmin->email;
		break;
//PK sendOnUpate
		CASE 'ProfileUpdateMail':
		$subject = $mosConfig_sitename.' - '._UE_USER_PROFILE_UPDATE;
		$msg =  _UE_USER_PROFILE_UPDATE_MSG;
		$to = $rowAdmin->email;
		break;
	}
	$msg=replaceVariables($msg,$row,$includePWD,$ueConfig);
	$msg.="\n\n".sprintf(_UE_EMAILFOOTER,$mosConfig_sitename,substr_replace(JURI::root(), '', -1, 1));
	if ($type != "reportAdmin") {
		eval ("\$msg = \"$msg\";");
	}
	$res = JUTility::sendMail($ueConfig['reg_email_from'], $ueConfig['reg_email_name'], $to, $subject, $msg);
	return $res;

}
function getUserDetails($row,$includePWD,$pwd_clear='') {
	$uDetails = _UE_EMAIL.' : '.$row->email.' ';
	$uDetails .= '\r\n'._UE_UNAME.' : '.$row->username.'\r\n';
	if($includePWD==1) {
		if ($pwd_clear) {
			$uDetails .= _UE_PASS.' : '.$pwd_clear.'\r\n';
		} else {
			$uDetails .= _UE_PASS.' : '.$row->password.'\r\n';
		}
	}
	return $uDetails;
}

//PK start
function getFullDump($row) {
	//global $database;
	$database = &JFactory::getDBO();
	if ($row->_tbl == '#__users') {
		$query_all = "SELECT u.username, u.name, u.email, c.* FROM #__users as u, #__cbe as c WHERE u.id=c.user_id AND u.id='".$row->id."'";
		$database->setQuery($query_all);
		$old_user = $database->loadObjectList();
		$row = $old_user[0];

//		$database->setQuery("SELECT * from #__cbe WHERE userid = '".$row->id."'");
//		$database->loadObject($new_row);
//		$row = $new_row;
	}
	
	$uDetails = '\r\nUser Data Dump: \r\n';
	if (count($row) > 0) {
		foreach ( $row as $key => $value ) {
			$uDetails .= $key." \t\t => \t ".$value." \n";
		}
	}
	return $uDetails;
}
//PK end

function dateConverter($oDate,$oFromFormat,$oToFormat) {
	if($oDate=='' || $oDate == null || !isset($oDate)) {
		return;
	} else {
		$specChar = array(".","/");
		$oDate = str_replace($specChar,"-",$oDate);
		$oFromFormat = str_replace($specChar,"-",$oFromFormat);
		$oDate=explode(" ",$oDate);
		if(!ISSET($oDate[1])) $oDate[1]="";
		$dateParts=explode("-",$oDate[0]);
		$fromParts=explode("-",$oFromFormat);

		$dateArray = array();
		$dateArray[$fromParts[0]] = $dateParts[0];
		$dateArray[$fromParts[1]] = $dateParts[1];
		$dateArray[$fromParts[2]] = $dateParts[2];

		if(strpos($oToFormat,"/")!=false) $char = "/";
		elseif(strpos($oToFormat,".")!=false) $char = ".";
		else $char = "-";

		$toParts=explode($char,$oToFormat);

		$returnDate=$oToFormat;
		foreach ($toParts as $toPart) {
			if($toPart=='Y' || $toPart=='y') {
				if(array_key_exists($toPart,$dateArray)) $returnDate=str_replace($toPart,$dateArray[$toPart],$returnDate);
				elseif($toPart=='y')$returnDate=str_replace($toPart,substr($dateArray['Y'],2,2),$returnDate);
				else $returnDate=str_replace($toPart,$dateArray['y'],$returnDate);
			}else {
				$returnDate=str_replace($toPart,substr($dateArray[$toPart],0,2),$returnDate);
			}
		}
		if (empty($oDate[1])) {
			return $returnDate;
		} elseif (!empty($oDate[1])) {
			return $returnDate." ".$oDate[1];
		}
	}

}
function getNameFormat($name,$uname,$format) {
	global $ueConfig;
	$database = &JFactory::getDBO();

	if (($format == 5 || $format == 6 || $format == 7 || $format == 8) && $ueConfig['name_style'] != 1) {
		$database->setQuery("SELECT user_id, firstname, middlename, lastname from #__cbe as c, #__users as u WHERE u.username='".$uname."' AND u.id=c.user_id");
		$u_data = "";
		$database->loadObject($u_data);
		$u_data->lastname = ($u_data->lastname!='') ? $u_data->lastname : $name;
		$u_space = ($u_data->firstname=='' && $u_data->middlename=='') ? "" : ", ";
		$name = $u_data->lastname.$u_space.$u_data->firstname.(($u_data->middlename!='') ? " ".$u_data->middlename : "");
	}

	if ($ueConfig['name_style'] == 1 && $format == 8) {
		$format = 4;
	}

	SWITCH ($format) {
		CASE 1 :
		CASE 6 :
		$returnName = $name;
		break;
		CASE 2 :
		CASE 7 :
		$returnName = $name." (".$uname.")";
		break;
		CASE 3 :
		$returnName = $uname;
		break;
		CASE 4 :
		CASE 5 :
		$returnName = $uname." (".$name.")";
		break;
		CASE 8:
		$returnName = $uname." (".$u_data->firstname.")";
		break;
		
//		CASE 5 :
//		$returnName = $uname." (".$name.")";
//		break;
//		CASE 6 :
//		$returnName = $name;
//		break;
//		CASE 7 :
//		$returnName = $name." (".$uname.")";
//		break;
	}
	return $returnName;
}
function getLangDefinition($text) {
	if(defined($text)) $returnText = constant($text);
	else $returnText = $text;
	return $returnText;
}
function getFieldValue($oType,$oValue=null,$user=null,$prefix=null, $cols=null) {
	global $ueConfig,$mosConfig_lang,$enhanced_Config;
	global $my;
	$database = &JFactory::getDBO();
	
	if ($GLOBALS['Itemid_com']!='') {
		$Itemid_c = $GLOBALS['Itemid_com'];
	} else {
		$Itemid_c = '';
	}
	
	if ($enhanced_Config['profile_txt_wordwrap'] == '1') {
		$cols = intval($cols);
	} else {
		$cols = 0;
	}
	$oReturn="";
	SWITCH ($oType){
		CASE 'checkbox':
		if($oValue!='' && $oValue!=null) {
			if($oValue==1) { $oReturn=_UE_YES;
			} elseif($oValue==0) { $oReturn=_UE_NO;
			} else { $oReturn=null; }
		}
		break;
		CASE 'select':
		CASE 'radio':
		$oReturn = getLangDefinition($oValue);
		break;
		CASE 'multiselect':
		CASE 'multicheckbox':
			$oValue_tmp = explode("|*|", $oValue);
			$oCount = count($oValue_tmp);
			for($i=0; $i < $oCount; $i++) {
				$oValue_tmp[$i] = getLangDefinition($oValue_tmp[$i]);
			}
			$oReturn = implode(";", $oValue_tmp);
			
//		$oReturn = str_replace("|*|",";",$oValue);
		break;
		CASE 'date':
		CASE 'birthdate':
		CASE 'dateselect':
		CASE 'dateselectrange':
		if($oValue!='' || $oValue!=null) {
			if ($oValue!='0000-00-00 00:00:00' && $oValue!='0000-00-00') {
				$oReturn = dateConverter($oValue,'Y-m-d',$ueConfig['date_format']);
			} else {
				$oReturn = "";
			}
		}
		break;
		CASE 'primaryemailaddress':
		IF($oValue==null) return;
		IF($ueConfig['allow_email_display']==1) {
			$oReturn=JHTML::_('email.cloak', $oValue, 0 );
		}
		ELSEIF($ueConfig['allow_email_display']==2) {
			$oReturn=JHTML::_('email.cloak', $oValue, 1 );
		}
		ELSEIF($ueConfig['allow_email_display']==3) $oReturn="<a href=\"index.php?option=com_cbe".$Itemid_c."&amp;task=emailUser&amp;uid=".$user->id."\">"._UE_SENDEMAIL."</a>";
		ELSE  $oReturn="";
		break;
		CASE 'emailaddress':
		IF($oValue==null) return;
		IF($ueConfig['allow_email']==1) {
			$oReturn=JHTML::_('email.cloak', $oValue, 1 );
		}
		ELSE {
			$oReturn=JHTML::_('email.cloak', $oValue, 0 );
		}
		break;
		CASE 'webaddress':
		IF($oValue==null) return;
		IF($ueConfig['allow_website']==1) $oReturn="<a href=\"http://".$oValue."\" target=\"_blank\">".$oValue."</a>";
		ELSE $oReturn=$oValue;
		break;
		CASE 'image':
		if(is_dir(JPATH_SITE."/components/com_cbe/images/".$mosConfig_lang)) $fileLang=$mosConfig_lang;
		else $fileLang="english";
		if($user->avatarapproved==0) $oValue="components/com_cbe/images/".$fileLang."/tnpendphoto.jpg";
		elseif(($user->avatar=='' || $user->avatar==null) && $user->avatarapproved==1) $oValue="components/com_cbe/images/".$fileLang."/tnnophoto.jpg";
		elseif(strpos($user->avatar,"gallery/")===false) $oValue="images/cbe/tn".$oValue;
		else $oValue="images/cbe/".$oValue;
		if(!is_file(JPATH_SITE."/".$oValue)) $oValue="components/com_cbe/images/".$fileLang."/tnnophoto.jpg";
		if(is_file(JPATH_SITE."/".$oValue)) {
			if($ueConfig['allow_profilelink']==1) {
				$onclick = "onclick=\"javascript:window.location='".JRoute::_("index.php?option=com_cbe".$Itemid_c."&amp;task=userProfile&amp;user=".$user->id)."'\"";
				$onclick_pop = "onclick=\"javascript:window.open('".JRoute::_("index2.php?option=com_cbe".$Itemid_pro."&amp;task=userProfile&amp;user=".$user->id."&amp;pop=1")."','cbe_win','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');\" title=\"CBE-Profile\" ";
				if ( $ueConfig['allow_profile_popup'] == '1' || $enhanced_Config['cbs_allow_profile_popup'] == '1' ) {
					// $onclick = $onclick_pop;
					$onclick = "";
				}
			}
			$oReturn="<img src=\"".$oValue. "\" ".$onclick." />";
		}
		break;
		CASE 'status':
		$database->setQuery("SELECT COUNT(*) FROM #__session WHERE userid ='".$user->id."'");
		$isonline = $database->loadResult();
		if($isonline > 0) { $oReturn = _UE_ISONLINE; } else { $oReturn = _UE_ISOFFLINE; }
		break;
		CASE 'formatname':
		$oReturn = getNameFormat($user->name,$user->username,$ueConfig['name_format']);
		break;
		CASE 'textarea':
		if ($cols > 0) {
			$oReturn = cbe_wordwrap($oValue, $cols, 1);
			$oReturn = nl2br($oReturn);
		} else {
			$oReturn = nl2br($oValue);
		}
		break;
		CASE "editorta":
		if ($cols > 0) {
			$oReturn = cbe_wordwrap($oValue, $cols, 1);
		} else {
			$oReturn = getLangDefinition($oValue);
		}
		break;
		CASE 'geo_calc_dist':
			$geo_distance = 0;
			$geo_distance_null = 0;
			$do_meter = 0;
			$geo_query = "SELECT (acos(sin(radians(u2.GeoLat)) * sin(radians(u1.GeoLat)) + cos(radians(u2.GeoLat)) * cos(radians(u1.GeoLat)) *"
					." cos(radians(u2.GeoLng) - radians(u1.GeoLng))) * 6371.11) as distance, u2.uid as has_data FROM #__cbe_geodata as u1, #__cbe_geodata as u2 WHERE "
					."u1.uid='".$my->id."' AND u2.uid='".$user->id."' AND (u1.GeoLat != 0 AND u1.GeoLng != 0 AND u2.GeoLat != 0 AND u2.GeoLng != 0) AND (u1.GeoAllowShow = '1' AND u2.GeoAllowShow = '1')";
			$database->setQuery($geo_query);
			//$geo_distance = $database->loadResult();
			$database->loadObject($geo_dist_obj_);
			$geo_distance = $geo_dist_obj_->distance;
			$geo_distance = number_format($geo_distance, 3, '.', '');
			if ($geo_distance < 1 && $geo_distance > 0) {
				$geo_distance = $geo_distance * 1000;
				$do_meter = 1;
			}
			if ($geo_distance == 0 AND !empty($geo_dist_obj_->has_data)) {
				$do_meter = 1;
				$geo_dist_null = 1;
			}

			if ($geo_distance > 0 || $geo_dist_null == 1) {
				$oReturn = $geo_distance." ".(($do_meter == 1) ? _UE_CBE_GEOCODER_F_m : _UE_CBE_GEOCODER_F_Km);
			} else {
				$oReturn = _UE_CBE_GEOCODER_F_NODATA;
			}
		break;
		CASE 'cbe_calced_age':
			include_once('components/com_cbe/enhanced/enhanced_functions.inc');
			$birthday_field = $enhanced_Config['lastvisitors_birthday_field'];
			$query = "SELECT $birthday_field FROM #__cbe WHERE id='".$user->id."'";
			$database->setQuery($query);
			$birthday = $database->loadResult();
         		
			if($birthday =="") {
				$user_age = _UE_SHOWAGE_NO;
			} else {
				$timenow = time();
				$user_age = "(".cb_user_age($birthday, $timenow).")";
			}
			$oReturn = $user_age;
		break;
		DEFAULT:
		$oReturn = getLangDefinition($oValue);
		break;
	}
	if($prefix != null && ($oReturn != null || $oReturn != '')) $oReturn = $prefix.$oReturn;
	return $oReturn;
}
function getFieldEntry($oType,$oName,$oInformation,$oInfoTag,$oValue,$oReq,$oLabel,$oID,$oSize, $oMaxLen, $oCols, $oRows,$oProfile, $rowFieldValues=null,$oFieldRange,$oFieldDefault,$oReadOnly=0) {
	global $ueConfig, $mainframe;

	$database = &JFactory::getDBO();

	if($oSize > 0) $pSize=" size='".$oSize."' ";
	else $pSize="";
	if($oMaxLen > 0) $pMax=" MAXLENGTH='".$oMaxLen."' ";
	else $pMax="";
	if($oCols > 0) $pCols=" cols='".$oCols."' ";
	else $pCols="";
	if($oRows > 0) $pRows=" rows='".$oRows."' ";
	else $pRows="";
	if($oReadOnly > 0) {
		$pReadOnly=" DISABLED disabled=\"disabled\" ";
		$oReq=0;
	} else {
		$pReadOnly="";
	}
	SWITCH ($oType){
		CASE 'text':
		 $oReturn = "<input class=\"inputbox\" $pReadOnly mosReq=".$oReq." mosLabel=\"".getLangDefinition($oLabel)."\" $pSize $pMax type=\"text\" name=\"".$oName."\" value=\"".$oValue."\" />";
		break;
		CASE 'textarea':
		 $oReturn = "<textarea class=\"inputbox\" $pReadOnly onkeyup=\"limitText(this,$oMaxLen)\"mosReq=".$oReq." $pMax mosLabel=\"".getLangDefinition($oLabel)."\" $pCols $pRows  name=\"".$oName."\">".$oValue."</textarea>";
		break;
		CASE 'editorta':
		 if ($oReadOnly == "0") {
		 	ob_start();
			//editorArea( 'editor'.$oName ,  $oValue , $oName , 500, 350, $oCols, $oRows ) ;
			$editor =& JFactory::getEditor();
			echo $editor->display( 'editor'.$oName ,  $oValue , 500, 350, $oCols, $oRows);
		 	$oReturn=ob_get_contents();
		 	ob_end_clean();
		 } else {
		 	$oReturn = $oValue;
		 }
		//echo $fieldJS;
		 if ($oReadOnly == "0") {
		 	$oReturn .= " <script> document.adminForm.".$oName.".setAttribute('mosReq',".$oReq."); document.adminForm.".$oName.".setAttribute('mosLabel','".getLangDefinition($oLabel)."'); </script>";
		 }
		break;
		CASE 'select':
		CASE 'multiselect':
		CASE 'radio':
		CASE 'multicheckbox':
		 $oReturn = $rowFieldValues;
		break;
		CASE 'checkbox':
		 $checked='';
		 if($oValue!='' && $oValue != null && $oValue==1) $checked="CHECKED";
		 $oReturn = "<input class=\"inputbox\" $pReadOnly mosReq=".$oReq." mosLabel=\"".getLangDefinition($oLabel)."\" type=\"checkbox\" $checked name=\"".$oName."\" value=\"1\" />";
		break;
		CASE 'hidden':
		 $oReturn = "<input class=\"inputbox\" $pReadOnly mosLabel=\"".getLangDefinition($oLabel)."\" type=\"hidden\" name=\"".$oName."\" value=\"".$oValue."\" />";
		break;
		CASE 'password':
		 $oReturn = "<input class=\"inputbox\" $pReadOnly mosReq=".$oReq." mosLabel=\"".getLangDefinition($oLabel)."\" type=\"password\" name=\"".$oName."\" value=\"".$oValue."\" />";
		break;
		CASE 'date':
		 $dFind=array("d","m","y","Y");
		 $dReplace=array("dd","mm","yy","y");
		 if ($oValue=='0000-00-00 00:00:00' || $oValue=='0000-00-00') $oValue="";
		 else $oValue=dateConverter($oValue,'Y-m-d',$ueConfig['date_format']);
		 $sqlFormat = "Y-m-d";
		 if ($oReadOnly == '1') {
		 	$oReturn = "<input class=\"inputbox\" readonly mosReq=".$oReq." mosLabel=\"".getLangDefinition($oLabel)."\" type=\"text\" id=\"".$oName."\" name=\"".$oName."\" value=\"".$oValue."\" />";
		 } else {
		 	$oReturn = "<input class=\"inputbox\" mosReq=".$oReq." mosLabel=\"".getLangDefinition($oLabel)."\" type=\"text\" id=\"".$oName."\" name=\"".$oName."\" value=\"".$oValue."\" onBlur=\"checkCalDate($oName);\" />";
		 }
		 if($oReadOnly!=1) $oReturn .= "<input type=\"reset\" class=\"button\" value=\"...\" onClick=\"return showCalendar2('".$oName."', '".str_replace($dFind, $dReplace, $ueConfig['date_format'])."',0,0);\" />";
		break;
		CASE 'birthdate':
		 $dFind=array("d","m","y","Y");
		 $dReplace=array("dd","mm","yy","y");
		 if ($oValue=='0000-00-00 00:00:00' || $oValue=='0000-00-00') $oValue="";
		 else $oValue=dateConverter($oValue,'Y-m-d',$ueConfig['date_format']);
		 $sqlFormat = "Y-m-d";
		 if ($oReadOnly == '1') {
		 	$oReturn = "<input class=\"inputbox\" readonly mosReq=".$oReq." mosLabel=\"".getLangDefinition($oLabel)."\" type=\"text\" id=\"".$oName."\" name=\"".$oName."\" value=\"".$oValue."\" />";
		 } else {
		 	$oValue_hid = '';
		 	if (empty($oValue) && !empty($oFieldDefault)) {
		 		$oValue = dateConverter($oFieldDefault."-01-01",'Y-m-d',$ueConfig['date_format']);
		 	} else {
		 		$oValue_hid = $oValue;
		 	}
			list($df_lowRange, $df_highRange) = explode(",", $oFieldRange);
		 	$oReturn = "<input class=\"inputbox\" mosReq=".$oReq." mosLabel=\"".getLangDefinition($oLabel)."\" type=\"text\" id=\"".$oName."\" name=\"".$oName."\" "
		 		 ."cbe_type=\"".$oType."\" lowRange=\"".$df_lowRange."\" highRange=\"".$df_highRange."\" value=\"".$oValue."\" "
		 		 ."onBlur=\"checkCalDateRange($oName);\" onChange=\"updateHiddenData($oName,".$oName."_hid);\" />";
		 	$oReturn .= "<input type=\"hidden\" id=\"".$oName."_hid\" name=\"".$oName."_hid\" value=\"".$oValue_hid."\" />";
		 }
		 if($oReadOnly!=1) $oReturn .= "<input type=\"reset\" class=\"button\" value=\"...\" onClick=\"return showCalendar2('".$oName."', '".str_replace($dFind, $dReplace, $ueConfig['date_format'])."', '".$df_lowRange."', '".$df_highRange."');\" onBlur=\"this.form.".$oName.".focus(); this.form.".$oName.".blur(); cbe_checkCalCall(".$oName.");\"/>";
		break;
		CASE 'dateselect':
		CASE 'dateselectrange':
		 $dFind=array("d","m","y","Y");
		 $dReplace=array("dd","mm","yy","y");
		 if ($oValue=='0000-00-00 00:00:00' || $oValue=='0000-00-00') $oValue="";
		 else $oValue=dateConverter($oValue,'Y-m-d','d-m-Y');
		 $df_day = 0; $df_month = 0; $df_year = 0;
		 list($df_day,$df_month,$df_year) = explode("-",$oValue);
		 $sqlFormat = "Y-m-d";
		 if ($oReadOnly == '1') {
		 	//$oReturn = "<input class=\"inputbox\" readonly mosReq=".$oReq." mosLabel=\"".getLangDefinition($oLabel)."\" type=\"text\" id=\"".$oName."\" name=\"".$oName."\" value=\"".$oValue."\" />";
		 	$oReturn  = "<select class=\"\inputbox\" DISABLED disabled=\"disabled\" mosReq=".$oReq." mosLabel=\"".getLangDefinition($oLabel)."\" type=\"select\" id=\"".$oName."_day\" name=\"".$oName."_day\" /> \n";
		 	$oReturn .= "<option>".$df_day."</option> \n";
		 	$oReturn .= "</select> \n";
		 	$oReturn .= " - ";
		 	$oReturn .= "<select class=\"\inputbox\" DISABLED disabled=\"disabled\" mosReq=".$oReq." mosLabel=\"".getLangDefinition($oLabel)."\" type=\"select\" id=\"".$oName."_mon\" name=\"".$oName."_mon\" /> \n";
		 	$oReturn .= "<option>".$df_month."</option> \n";
		 	$oReturn .= "</select> \n";
		 	$oReturn .= " - ";
		 	$oReturn .= "<select cbe_type=\"".$oType."\" cbe_name=\"".$oName."\" class=\"\inputbox\" DISABLED disabled=\"disabled\" mosReq=".$oReq." mosLabel=\"".getLangDefinition($oLabel)."\" type=\"select\" id=\"".$oName."_year\" name=\"".$oName."_year\" /> \n";
		 	$oReturn .= "<option>".$df_year."</option> \n";
		 	$oReturn .= "</select> \n";
		 	$oReturn .= "<input type=\"hidden\" id=\"".$oName."_hid\" name=\"".$oName."_hid\" value=\"".$oValue_hid."\" />";
		 } else {
		 	$oValue_hid = '';
		 	if (empty($oValue) && !empty($oFieldDefault)) {
		 		$oValue = dateConverter($oFieldDefault."-01-01",'Y-m-d','d-m-Y');
		 		list($df_day,$df_month,$df_year) = explode("-",$oValue);
		 	} else {
		 		$oValue_hid = $oValue;
		 	}
		 	$ac_year = intval(date("Y"));
		 	$df_lowRange = $ac_year - 80; $df_highRange = $ac_year + 25;
		 	if (!empty($oFieldRange) && $oType=='dateselectrange') {
		 		list($df_lowRange, $df_highRange) = explode(",", $oFieldRange);
		 		
		 	}
		 	//$oReturn = "<input class=\"inputbox\" mosReq=".$oReq." mosLabel=\"".getLangDefinition($oLabel)."\" type=\"text\" id=\"".$oName."\" name=\"".$oName."\" value=\"".$oValue."\" onBlur=\"checkCalDate($oName); checkCalDateRange($oName);\" />";
		 	$oReturn  = "<select class=\"\inputbox\" mosLabel=\"".getLangDefinition($oLabel."_day")."\" type=\"select\" id=\"".$oName."_day\" name=\"".$oName."_day\" "
		 		  ."onBlur=\"cbe_checkDateSelect('".$oName."', 1);\" /> \n";
			for ($i=1; $i < 32; $i++) {
				$_select = '';
				if ($i == $df_day) {
					$_select = ' selected=\"selected\"';
				}
				$oReturn .= "<option value=\"".$i."\"".$_select.">".$i."</option> \n";
			}
		 	$oReturn .= "</select> \n";
			$oReturn .= " - ";
			$oReturn .= "<select class=\"\inputbox\" mosLabel=\"".getLangDefinition($oLabel."_mon")."\" type=\"select\" id=\"".$oName."_mon\" name=\"".$oName."_mon\" "
				  ."onChange=\"cbe_checkDayCount('".$oName."');\"/> \n";
			for ($i=1; $i < 13; $i++) {
				$_select = '';
				if ($i == $df_month) {
					$_select = ' selected=\"selected\"';
				}
				$oReturn .= "<option value=\"".$i."\"".$_select.">".$i."</option> \n";
			}
		 	$oReturn .= "</select> \n";
			$oReturn .= " - ";
			$oReturn .= "<select cbe_type=\"".$oType."\" cbe_name=\"".$oName."\" mosReq=".$oReq." class=\"\inputbox\" mosLabel=\"".getLangDefinition($oLabel)."\" type=\"select\" id=\"".$oName."_year\" name=\"".$oName."_year\" "
				  ."onChange=\"cbe_checkDayCount('".$oName."');\"/> \n";
			// $_stop = 0; $_stop = $df_highRange - $df_lowRange + 1;
			$_stop = 0; $_stop = $df_highRange - $df_lowRange;
			for ($i=$_stop; $i > -1; $i--) {
				$_select = '';
				$ia = $df_lowRange + $i;
				if ($ia == $df_year) {
					$_select = ' selected=\"selected\"';
				}
				$oReturn .= "<option value=\"".$ia."\"".$_select.">".$ia."</option> \n";
			}
		 	$oReturn .= "</select>";
		 	$oReturn .= "<input type=\"hidden\" id=\"".$oName."_hid\" name=\"".$oName."_hid\" value=\"".$oValue_hid."\" />";
		 }
		 //if($oReadOnly!=1) $oReturn .= "<input type=\"reset\" class=\"button\" value=\"...\" onClick=\"return showCalendar2('".$oName."', '".str_replace($dFind, $dReplace, $ueConfig['date_format'])."');\" />";
		break;
		CASE 'emailaddress':
		 $oReturn = "<input class=\"inputbox\" $pReadOnly $pMax onBlur=\"isValidEmailAddress(this);\" mosReq=".$oReq." $pSize mosLabel=\"".getLangDefinition($oLabel)."\" type=\"text\" name=\"".$oName."\" id=\"".$oName."\" value=\"".$oValue."\" />";
		break;
		CASE 'webaddress':
		 $oReturn = "<input class=\"inputbox\" $pReadOnly $pMax $pSize mosReq=".$oReq." mosLabel=\"".getLangDefinition($oLabel)."\" type=\"text\" name=\"".$oName."\" id=\"".$oName."\" value=\"".$oValue."\" />";
		break;
		case 'spacer':
		 $oReturn= "";
		break;
		CASE 'numericfloat':
		 $oReturn = "<input class=\"inputbox\" $pReadOnly onBlur=\"isNummericFieldFloat(this);\" mosReq=".$oReq." mosLabel=\"".getLangDefinition($oLabel)."\" $pSize $pMax type=\"text\" name=\"".$oName."\" value=\"".$oValue."\" />";
		break;
		CASE 'numericint':
		 $oReturn = "<input class=\"inputbox\" $pReadOnly onBlur=\"isNummericFieldInt(this);\" mosReq=".$oReq." mosLabel=\"".getLangDefinition($oLabel)."\" $pSize $pMax type=\"text\" name=\"".$oName."\" value=\"".$oValue."\" />";
		break;

	}
	if($oInformation && ($oInfoTag == 'icon' || $oInfoTag == 'both')) {
//		$tip_param = "this.T_WIDTH=200;this.T_FONTCOLOR='#003399';this.T_SHADOWWIDTH=5;this.T_STICKY=true;this.T_TITLE='".$oLabel."';";
//		$oReturn .= " <img src='".$mosConfig_live_site."/components/com_cbe/images/attention.gif' width='16' height='16' alt='!' title='"._UE_FIELDINFORMATION."' onmouseover=\"".$tip_param."return escape('".$oInformation."')\" />";
		$CBEtip = getCBEtip($oLabel,$oInformation);
		$oReturn .= " <img src='".JURI::root()."components/com_cbe/images/attention.gif' width='16' height='16' alt='!' title='"._UE_FIELDINFORMATION."' ".$CBEtip." />";
	}

	if($oReq==1) $oReturn .= " <img src='".JURI::root()."components/com_cbe/images/required.gif' width='16' height='16' alt='*' title='"._UE_FIELDREQUIRED."' />";
	if($oProfile==1) $oReturn .= " <img src='".JURI::root()."components/com_cbe/images/profiles.gif' width='11' height='14' alt='+' title='"._UE_FIELDONPROFILE."' />";
	else $oReturn .= " <img src='".JURI::root()."components/com_cbe/images/noprofiles.gif' width='11' height='14' alt='-' title='"._UE_FIELDNOPROFILE."' />";
	return $oReturn;
}

function getCBEtip($tipLabel, $tipInformation) {
	global $ueConfig,$enhanced_Config,$database,$version;
	//

//	$tipInformation = str_replace(array("&","\"","'","<",">"), array("& amp;","&quot;","&#039;","& lt;","& gt;"), $tipInformation);
//	$tipInformation = str_replace(array("�","�","�","�","�","�","�"), array("&auml;","&Auml;","&ouml;","&Ouml;","&uuml;","&Uuml;","$szlig;"), $tipInformation);

	$tipInformation = htmlentities($tipInformation, ENT_QUOTES);

	if ($enhanced_Config['tooltip_wz']=='1') {
		$tipInformation = str_replace(array(" &amp; ","&lt;","&gt;"), array("& amp;","& lt;","& gt;"), $tipInformation);
		$tip_param = "this.T_WIDTH=200;this.T_FONTCOLOR='#003399';this.T_SHADOWWIDTH=5;this.T_STATIC=true;this.T_TITLE='".$tipLabel."';";
		$tip_over = "onmouseover=\"".$tip_param."return escape('".$tipInformation."')\" ";
	} else {
		//$tipInformation = str_replace(array(" &amp; ","&lt;","&gt;"), array("&amp;","&lt;","&gt;"), $tipInformation);
		$tip_over = CBEmosToolTip($tipInformation, $tipLabel);
	}

	return $tip_over;
}

function CBEmosToolTip( $tooltip, $title='', $width='200', $image='attention.gif' ) {
	if ( $width ) {
		$width = ', WIDTH, \''.$width .'\'';
	}
	if ( $title ) {
		$title = ', CAPTION, \''.$title .'\'';
	}
	if ( !$text ) {
		$image 	= substr_replace(JURI::root(), '', -1, 1) . '/components/com_cbe/images/'. $image;
		$text 	= '<img src="'. $image .'" border="0" alt="tooltip"/>';
	}
	$style = 'style="text-decoration: none;"';
	$mousover = 'return overlib(\''. $tooltip .'\''. $title .', BELOW, RIGHT'. $width .');';
	$tip = "";
	$tip .= "onmouseover=\"". $mousover ."\" onmouseout=\"return nd();\" ". $style ." ";

	return $tip;
}

function allowAccess( $accessgroupid,$recurse, $usersgroupid, &$acl, $chk_switch='0')
{
	// "agroup:".$accessgroupid." ugroupid:".$usersgroupid." recurse ".$recurse;
	if ($accessgroupid == -2 || ($accessgroupid == -1 && $usersgroupid > 0)) {
		//grant public access or access to all registered users
		return 1;
	}
	else {
		//need to do more checking based on more restrictions
		if( $usersgroupid == $accessgroupid ) {
			//direct match
			return 1;
		}
		else {
			if ($recurse=='RECURSE') {
				//check if there are children groups
				if ($chk_switch == '0') {
					// stay in maintree
					$groupchildern=array();
					$groupchildren=$acl->get_group_children( $accessgroupid, 'ARO', $recurse );
				} else {
					// look across maintree
					$groupchildren = getAboveGids($accessgroupid,0);
				}
				
				if ( is_array( $groupchildren ) && count( $groupchildren ) > 0) {
					if ( in_array($usersgroupid, $groupchildren) ) {
						//match
						return 1;
					}
				}
			}
		}
		//deny access
		return 0;
	}
}

//	check if access is allowed based on all parental groups and below own
function checkParentBelow( $accessgroupid, $recurse, $usersgroupid ) {
	$database = &JFactory::getDBO();
	
	if ($accessgroupid == -2 || ($accessgroupid == -1 && $usersgroupid > 0)) {
		return true;
	} else {
		if( $usersgroupid == $accessgroupid ) {
			return true;
		} else {
			if ($recurse=='RECURSE') {
				$groupchildren=array();
				$groupchildren=getAboveGids($accessgroupid,0);
				if ( is_array( $groupchildren ) && count( $groupchildren ) > 0) {
					if ( in_array($usersgroupid, $groupchildren) ) {
						return true;
					}
				}
			}
		}
		return false;
	}
}

/////////////////////

function getBelowGids($gid, $output=0) {
	// exluded $gid
	$database = &JFactory::getDBO();

	$query = "SELECT g1.id, g1.name FROM #__core_acl_aro_groups g1"
		."\n LEFT JOIN #__core_acl_aro_groups g2 ON g2.lft >= g1.lft"
		."\n WHERE g2.id =".$gid." ORDER BY g1.name";

	$normlist = array(-2,);
	if( $gid > 0) {
		$normlist[]=-1;
	}
	$array=array();
	$database->setQuery( $query );
	$array=$database->loadResultArray();
	$array=array_merge($array,$normlist);

	if ($output != 0) {
		$out_list = implode(',', $array);
		return $out_list;
	} else {
		return $array;
	}
}

function getAboveGids($gid, $output=0) {
	// included $gid
	$database = &JFactory::getDBO();

      	$query = "SELECT g1.id, g1.name FROM #__core_acl_aro_groups g1"
		."\n LEFT JOIN #__core_acl_aro_groups g2 ON g2.lft <= g1.lft"
		."\n WHERE g2.id =".$gid." ORDER BY g1.name";
      	$array=array();
       	$database->setQuery( $query );
	$array=$database->loadResultArray();

	if ($output != 0) {
		$out_list = implode(',', $array);
		return $out_list;
	} else {
		return $array;
	}
}

function cbReadDirectory($path) {
	$arr = array();
	//	print $path;
	if (!@is_dir( $path )) {
		return $arr;
	}
	$handle = opendir( $path );
	while ($file = readdir($handle)) {
		$dir = JPath::clean($path.DS.$file);

		if(is_dir( $dir )) {
			if (($file != ".") && ($file != "..")) {
				//print $file;
				$arr[] = trim( $file );
			}
		}
	}
	closedir($handle);
	asort($arr);
	return $arr;
}

function getForumTab($tab,$user) {
	global $acl;
	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	$return="";

	$query_simpleb = "SELECT count(link) FROM #__components WHERE link LIKE '%com_simpleboard%'";
	$database->setQuery($query_simpleb);
	$simple_res = $database->loadResult();
	if ($simple_res < '1') {
		$query_joomlab = "SELECT count(link) FROM #__components WHERE link LIKE '%com_simpleboard%'";
		$database->setQuery($query_joomlab);
		$jsimple_res = $database->loadResult();
		if ($jsimple_res >= '1') {
			$sb_board_table = "joomlaboard";
		}
	} else {
		$sb_board_table = "simpleboard";
	}

	if(file_exists('administrator/components/com_'.$sb_board_table.'/'.$sb_board_table.'_config.php')) {
		include_once ( 'administrator/components/com_'.$sb_board_table.'/'.$sb_board_table.'_config.php' );
	} else {
		$return = _UE_SBNOTINSTALLED;
		return $return;
	}
	$database->setQuery("select id from #__menu where link='index.php?option=com_".$sb_board_table."'");
	$Itemid_sb=$database->loadResult();
	if($sbConfig['showstats'] || (!$sbConfig['showranking'] && !$sbConfig['showkarma'] && !$sbConfig['postStats'])) {
		if($sbConfig['showranking']) {
			$uIsAdm="";
			$uIsMod="";
			$database->setQuery("SELECT posts,karma,moderator,gid FROM #__sb_users sb, #__users u where sb.userid=u.id AND sb.userid='$user->id'");
			$sbUserDetails=$database->loadObjectList();
			if(count($sbUserDetails)>0) $sbUserDetails=$sbUserDetails[0];
			if($sbUserDetails->posts==0) {
				return _UE_NOFORUMPOSTS;
			}
			if($sbUserDetails->gid > 0 ) {//only get the groupname from the ACL if we're sure there is one
			$agrp=strtolower( $acl->get_group_name( $sbUserDetails->gid, 'ARO' ) );
			if(strtolower($agrp)=="administrator" || strtolower($agrp)=="superadministrator"|| strtolower($agrp)=="super administrator") $uIsAdm=1;
			}
			$uIsMod=$sbUserDetails->moderator;
			$sbs=substr_replace(JURI::root(), '', -1, 1).'/components/com_'.$sb_board_table;
			$numPosts=$sbUserDetails->posts;
			$rText="";
			$rImg="";
			if ($numPosts>=0 && $numPosts<(int)$sbConfig['rank1']){$rText=$sbConfig['rank1txt']; $rImg=$sbs.'/ranks/rank1.gif';}
			if ($numPosts>=(int)$sbConfig['rank1'] && $numPosts<(int)$sbConfig['rank2']){$rText=$sbConfig['rank2txt']; $rImg=$sbs.'/ranks/rank2.gif';}
			if ($numPosts>=(int)$sbConfig['rank2'] && $numPosts<(int)$sbConfig['rank3']){$rText=$sbConfig['rank3txt']; $rImg=$sbs.'/ranks/rank3.gif';}
			if ($numPosts>=(int)$sbConfig['rank3'] && $numPosts<(int)$sbConfig['rank4']){$rText=$sbConfig['rank4txt']; $rImg=$sbs.'/ranks/rank4.gif';}
			if ($numPosts>=(int)$sbConfig['rank4'] && $numPosts<(int)$sbConfig['rank5']){$rText=$sbConfig['rank5txt']; $rImg=$sbs.'/ranks/rank5.gif';}
			if ($numPosts>=(int)$sbConfig['rank5']){$rText=$sbConfig['rank6txt']; $rImg=$sbs.'/ranks/rank6.gif';}
			if ($uIsMod){$rText=_RANK_MODERATOR; $rImg=$sbs.'/ranks/rankmod.gif';}
			if ($uIsAdm){$rText=_RANK_ADMINISTRATOR; $rImg=$sbs.'/ranks/rankadmin.gif';}
			if($sbConfig['rankimages']){$msg_userrankimg = '<br /><img src="'.$rImg.'" alt="" />';}
			$msg_userrank = $rText;
		}
		$return .= "<div class=\"sectiontableheader\" style=\"text-align:center;width:50%;\">"._UE_FORUM_STATS."</div>";
		$return .= "<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"50%\">";
		if($sbConfig['showranking']) $return .= "<tr class=\"sectiontableentry1\"><td style=\"font-weight:bold;width:50%;\">Forum Ranking</td><td>".$msg_userrank.$msg_userrankimg."</td></tr>";
		if($sbConfig['postStats']) $return .= "<tr class=\"sectiontableentry2\"><td style=\"font-weight:bold;width:50%;\">Total Posts</td><td>".$sbUserDetails->posts."</td></tr>";
		if($sbConfig['showkarma']) $return .= "<tr class=\"sectiontableentry1\"><td style=\"font-weight:bold;width:50%;\">Karma</td><td>".$sbUserDetails->karma."</td></tr>";
		$return .= "</table>";
	}
	if($my->id == $user->id && $sbConfig['allowsubscriptions']) {
		$database->setQuery("select thread from #__sb_subscriptions where userid=$my->id");
		$subslist=$database->loadObjectList();
		$csubslist=count($subslist);

		$return .= '<br /><table border=0 cellspacing=0 width="100%" align="center" class="contentpane">';
		$return .= '   <tr>';
		$return .= '      <td colspan="2" class="sectiontableheader">'._UE_USER_SUBSCRIPTIONS.'</td>';
		$return .= '   </tr>';
		if($csubslist>0) $return .= '<tr><td colspan=2><form action="index.php?option=com_'.$sb_board_table.'&amp;Itemid='.$Itemid_sb.'&amp;func=userprofile&amp;do=update" method="POST" name="postform" id="postform"><input type="hidden" name="do" value="update"><input type="checkbox" onclick="javascript:this.form.submit();" name="unsubscribeAll" value="1"><i>'._UE_USER_UNSUBSCRIBE_ALL.'</i></form></td></tr>';
		$enum=1;//reset value
		$tabclass = array("sectiontableentry1", "sectiontableentry2");//alternating row CSS classes
		$k=0; //value for alternating rows
		if($csubslist >0){
			foreach($subslist as $subs){//get all message details for each subscription
			$database->setQuery("select * from #__sb_messages where id=$subs->thread");
			$subdet=$database->loadObjectList();
			foreach($subdet as $sub){
				$k=1-$k;
				$return .= "<tr>";
				$return .= '  <td class="'.$tabclass[$k].'">'.$enum.': <a href="index.php?option=com_'.$sb_board_table.'&amp;Itemid='.$Itemid_sb.'&amp;func=view&amp;amp;catid='.$sub->catid.'&amp;id='.$sub->id.'">'.$sub->subject.'</a> - ' ._UE_GEN_BY. ' ' .$sub->name;
				$return .= '  <td class="'.$tabclass[$k].'"><a href="index.php?option=com_'.$sb_board_table.'&amp;Itemid='.$Itemid_sb.'&amp;func=userprofile&amp;do=unsubscribe&amp;thread='.$subs->thread.'">' ._UE_THREAD_UNSUBSCRIBE. '</a>';
				$return .= "</tr>";
				$enum++;
			}
			}
		}
		else{
			$return .= '<tr><td>'._UE_USER_NOSUBSCRIPTIONS.'</td></tr>';
		}

		$return .= '</table>';
	}
	$query="SELECT a. * , b.id as category, b.name as catname, c.hits AS 'threadhits'"
	. "\n FROM #__sb_messages AS a, "
	. "\n #__sb_categories AS b, #__sb_messages AS c"
	. "\n WHERE a.catid = b.id"
	. "\n AND a.thread = c.id"
	. "\n AND a.hold = 0 AND b.published = 1"
	. "\n AND a.userid=".$user->id.""
	. "\n ORDER  BY a.time DESC "
	. "\n LIMIT 10 ";

	$database->setQuery( $query );
	//print $database->getQuery();
	$items = $database->loadObjectList();
	if(count($items) >0) {
		$return .= "<br /><div style=\"width:100%;\"><span class=\"contentpane\" style=\"text-align:center;width:100%;\">"._UE_FORUM_TOP10."</span>";
		$return .= "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
		$return .= "<tr class=\"sectiontableheader\">";
		$return .= "<td>"._UE_FORUMDATE."</td>";
		$return .= "<td>"._UE_FORUMSUBJECT."</td>";
		$return .= "<td>"._UE_FORUMCATEGORY."</td>";
		$return .= "<td>"._UE_FORUMHITS."</td>";
		$return .= "</tr>";
		$i=1;
		foreach($items AS $item) {
			$i= ($i==1) ? 2 : 1;
			if(!ISSET($item->created)) $item->created="";
			$formatedDate=JHTML::_('date', $item->created);
			$sbURL="index.php?option=com_".$sb_board_table."&amp;Itemid=".$Itemid_sb."&amp;func=view&amp;catid=".$item->catid."&amp;id=".$item->id."#".$item->id;
			$return .= "<tr class=\"sectiontableentry$i\"><td>".getFieldValue("date",date("Y-n-j, H:m:s",$item->time))."</td><td><a href=\"".$sbURL."\">".$item->subject."</a></td><td>".$item->catname."</td><td>".$item->threadhits."</td></tr>\n";

		}
		$return .= "</table></div>";
	} else {
		$return .= "<br />"._UE_NOFORUMPOSTS;
	}
	return $return;
}
function getAuthorTab($tab,$user,$action,$ui) {
	global $mosConfig_hits,$mosConfig_vote;
	$database = &JFactory::getDBO();

	$return="";
	$query = "SELECT a.id, a.title, a.hits,a.created, ROUND( r.rating_sum / r.rating_count ) AS rating,r.rating_count"
	. "\n FROM #__content AS a"
	. "\n LEFT JOIN #__content_rating AS r ON r.content_id=a.id"
	. "\n WHERE a.created_by=". $user->id .""
	. "\n AND a.state=1"
	. "\n ORDER BY a.created desc"
	;
	$database->setQuery( $query );
	//print $database->getQuery();
	$items = $database->loadObjectList();
	if(!count($items)>0) {
		$return = _UE_NOARTICLES;
		return $return;
	}
	$artURL="index.php?option=com_content&amp;task=view&amp;id=";
	$return .= "<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"95%\">";
	$return .= "<tr class=\"sectiontableheader\">";
	$return .= "<td>"._UE_ARTICLEDATE."</td>";
	$return .= "<td>"._UE_ARTICLETITLE."</td>";
	if($mosConfig_hits) $return .= "<td>"._UE_ARTICLEHITS."</td>";
	if($mosConfig_vote) $return .= "<td>"._UE_ARTICLERATING."</td>";
	$return .= "</tr>";
	$i=1;
	$hits="";
	$rating="";
	foreach($items AS $item) {
		$i= ($i==1) ? 2 : 1;
		$formatedDate=JHTML::_('date', $item->created);
		$starImageOn = JHTML::_('image.site', 'rating_star.png', '/images/M_images/' );
		$starImageOff = JHTML::_('image.site','rating_star_blank.png', '/images/M_images/' );
		$img="";
		if($mosConfig_vote) {
			for ($j=0; $j < $item->rating; $j++) {
				$img .= $starImageOn;
			}
			for ($j=$item->rating; $j < 5; $j++) {
				$img .= $starImageOff;
			}

			$rating = '<td><span class="content_rating">';
			$rating .= $img . '&nbsp;/&nbsp;';
			$rating .= intval( $item->rating_count );
			$rating .= "</span></td>\n";
		}
		if($mosConfig_hits) $hits = "<td>".$item->hits."</td>";
		$return .= "<tr class=\"sectiontableentry$i\"><td>".JHTML::_('date', $item->created)."</td><td><a href=\"".$artURL.$item->id."\">".$item->title."</a></td>".$hits.$rating."</tr>\n";

	}
	$return .= "</table>";

	return $return;
}
function getBlogTab($tab,$user,$action,$ui) {
	global $mosConfig_hits,$mosConfig_vote;
	$database = &JFactory::getDBO();

	if(!file_exists('components/com_mamblog/configuration.php')){
		$return = _UE_MAMBLOGNOTINSTALLED;
	} else {
		include_once ( 'components/com_mamblog/configuration.php' );
		$return="";
		$sectid="";
		$catid="";
		if(ISSET($cfg_mamblog['sectionid'])) $sectid="\n AND a.sectionid=".$cfg_mamblog['sectionid'];
		if(ISSET($cfg_mamblog['categoryid'])) $catid="\n AND a.categoryid=".$cfg_mamblog['categoryid'];
		$query = "SELECT a.id, a.title, a.hits,a.created, ROUND( r.rating_sum / r.rating_count ) AS rating,r.rating_count"
		. "\n FROM #__content AS a"
		. "\n LEFT JOIN #__content_rating AS r ON r.content_id=a.id"
		. "\n WHERE a.created_by=". $user->id .""
		. "\n AND a.state=1"
		. $sectid
		. $catid
		. "\n ORDER BY a.created desc"
		;
		$database->setQuery( $query );
		//print $database->getQuery();
		$items = $database->loadObjectList();
		if(!count($items)>0) {
			$return = _UE_NOBLOGS;
			return $return;
		}
		$artURL="index.php?option=com_content&amp;task=view&amp;id=";
		$return .= "<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"95%\">";
		$return .= "<tr class=\"sectiontableheader\">";
		$return .= "<td>"._UE_BLOGDATE."</td>";
		$return .= "<td>"._UE_BLOGTITLE."</td>";
		if($mosConfig_hits) $return .= "<td>"._UE_BLOGHITS."</td>";
		$return .= "</tr>";
		$i=1;
		$hits="";
		$rating="";
		foreach($items AS $item) {
			$i= ($i==1) ? 2 : 1;
			$formatedDate=JHTML::_('date', $item->created);
			$starImageOn = JHTML::_('image.site', 'rating_star.png', '/images/M_images/' );
			$starImageOff = JHTML::_('image.site', 'rating_star_blank.png', '/images/M_images/' );
			$img="";

			if($mosConfig_hits) $hits = "<td>".$item->hits."</td>";
			$return .= "<tr class=\"sectiontableentry$i\"><td>".JHTML::_('date', $item->created)."</td><td><a href=\"".$artURL.$item->id."\">".$item->title."</a></td>".$hits."</tr>\n";

		}
		$return .= "</table>";

	}
	return $return;
}

Function getContactTab($tab,$user,$action,$ui) {
	global $ueConfig,$mosConfig_lang,$mainframe, $version,$my;

	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();
	//$mosConfig_live_site = 'cbe/'; //$mainframe->getCfg('site');
	if($action==1) return;
	$reqIMG = " <img src='".substr_replace(JURI::root(), '', -1, 1)."/components/com_cbe/images/required.gif' width='16' height='16' alt='*' title='"._UE_FIELDREQUIRED."' />";
	$proIMG = " <img src='".substr_replace(JURI::root(), '', -1, 1)."/components/com_cbe/images/profiles.gif' width='11' height='14' alt='+' title='"._UE_FIELDONPROFILE."' />";
	$noproIMG = " <img src='".substr_replace(JURI::root(), '', -1, 1)."/components/com_cbe/images/noprofiles.gif' width='11' height='14' alt='-' title='"._UE_FIELDNOPROFILE."' />";
	$return="";
	$return .= "<table cellpadding='5' cellspacing='0' border='0' width='100%'>\n";
	$return .= "\t\t<br /><div><b>".getLangDefinition($tab->description)."</b></div><br />\n";
	$return .= "		<tr>\n";
	$return .= "			<td class='titleCell'>"._UE_UNAME."</td>\n";
	$return .= "			<td>";
	IF(($ueConfig["usernameedit"]==1) OR (($ueConfig['adminrequiredfields']==0) && ($my->gid==25))) {
		$return .= "<input class='inputbox' type='text' size='40' name='username' value='".$user->username."' />";
	} else {
		$return .= $user->username.$reqIMG;
	}
	IF($ueConfig["name_format"]!=1) $return .= $proIMG;
	ELSE $return .= $noproIMG;
	$return .= "\n</td>\n</tr>\n";
	
// fix for readonly fields not changeable by admin
// PK start
	if($ui==2) {
		$adminReq=0;
		if($ueConfig['adminrequiredfields']=='0') {
			$adminReq=0;
		} else {
			$adminReq=1;
		}
	} else {
		$adminReq=1;
	}
// PK end	
	
	
	SWITCH($ueConfig["name_style"]) {
		case 2:
		$return .= "		<tr>\n";
		$return .= "			<td class='titleCell'>"._UE_YOUR_FNAME.":</td>\n";
		$return .= "			<td><input class='inputbox' type='text' size='40' mosReq=".$adminReq." mosLabel='"._UE_YOUR_FNAME."' name='firstname' value='".$user->firstname."' />".$reqIMG;
		IF($ueConfig["name_format"]!=3) $return .= $proIMG;
		ELSE $return .= $noproIMG;
		$return .= "		</td></tr>\n";
		$return .= "		<tr>\n";
		$return .= "			<td class='titleCell'>"._UE_YOUR_LNAME.":</td>\n";
		$return .= "			<td><input class='inputbox' type='text' size='40' mosReq=".$adminReq." mosLabel='"._UE_YOUR_LNAME."' name='lastname' value='".(($user->lastname=='') ? $user->name : $user->lastname)."' />".$reqIMG;
		IF($ueConfig["name_format"]!=3) $pfields .= $proIMG;
		ELSE $return .= $noproIMG;
		$return .= "		</td></tr>\n";
		break;
		case 3:
		$return .= "		<tr>\n";
		$return .= "			<td class='titleCell'>"._UE_YOUR_FNAME.":</td>\n";
		$return .= "			<td><input class='inputbox' type='text' size='40' mosReq=".$adminReq." mosLabel='"._UE_YOUR_FNAME."' name='firstname' value='".$user->firstname."' />".$reqIMG;
		IF($ueConfig["name_format"]!=3) $return .= $proIMG;
		ELSE $return .= $noproIMG;
		$return .= "		</td></tr>\n";
		$return .= "<tr>\n";
		$return .= "	<td class='titleCell'>"._UE_YOUR_MNAME.":</td>\n";
		$return .= "	<td><input class='inputbox' type='text' size='40' mosReq=0 mosLabel='"._UE_YOUR_MNAME."' name='middlename' value='".$user->middlename."' />\n";
		IF($ueConfig["name_format"]!=3) $return .= $proIMG;
		ELSE $return .= $noproIMG;
		$return .= "		</td></tr>\n";
		$return .= "		<tr>\n";
		$return .= "			<td class='titleCell'>"._UE_YOUR_LNAME.":</td>\n";
		$return .= "			<td><input class='inputbox' type='text' size='40' mosReq=".$adminReq." mosLabel='"._UE_YOUR_LNAME."' name='lastname' value='".(($user->lastname=='') ? $user->name : $user->lastname)."' />".$reqIMG;
		IF($ueConfig["name_format"]!=3) $return .= $proIMG;
		ELSE $return .= $noproIMG;
		$return .= "		</td></tr>\n";
		break;
		DEFAULT:
		$return .= "<tr>\n";
		$return .= "	<td class='titleCell'>"._UE_YOUR_NAME.":</td>\n";
		$return .= "	<td><input class='inputbox' type='text' size='40' name='name' mosReq=".$adminReq." mosLabel='Name'  value='".$user->name."' />".$reqIMG;
		IF($ueConfig["name_format"]!=3) $return .= $proIMG;
		ELSE $return .= $noproIMG;
		$return .= "</td></tr>\n";
		break;
	}
	$return .= "<tr>\n";
	$return .= "	<td class='titleCell'>"._UE_EMAIL."</td>\n";
	$mailchange = '';
	if ($ueConfig['allow_mailchange']==1 || $ui==2) {
		$mailchange = "";
	} else {
		$mailchange = "DISABLED";
	}
	$return .= "	<td><input class='inputbox' type='text' name='email' value='".$user->email."' size='40' mosreq='".$adminReq."' ".$mailchange." />".$reqIMG;
	IF($ueConfig["allow_email_display"]==1 || $ueConfig["allow_email_display"]==2) $return .= $proIMG;
	ELSE $return .= $noproIMG;
	$return .= "</td></tr>\n";
	$return .= "<tr>\n";
	$return .= "	<td class='titleCell'>"._UE_PASS."</td>\n";
	$return .= "	<td><input class='inputbox' type='password' size='40' name='password' value='' /> ";
	if ($ui == 2) {
		$genLen = $ueConfig['password_min'] + 4;
		$return .= "<input type=button value=\""._UE_PASS."\" onClick=\"document.adminForm.password.value = cbe_randomPassword(".$genLen."); document.adminForm.verifyPass.value = document.adminForm.password.value; alert('"._UE_PASS.": ' + document.adminForm.password.value);\" />";
	}
	$return .= "</td>\n";
	$return .= "</tr>\n";
	$return .= "<tr>\n";
	$return .= "	<td class='titleCell'>"._UE_VPASS."</td>\n";
	$return .= "	<td><input class='inputbox' type='password' size='40' name='verifyPass' /></td>\n";
	$return .= "</tr>\n";

	if ($ui==2 || $ueConfig['show_jeditor']==1) {
		$return .= _getContactUserParams($ui, $user);
	}
	
	if($ui==2) {
		$canBlockUser = $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'user properties', 'block_user' );
		$canEmailEvents = $acl->acl_check( 'workflow', 'email_events', 'users', $acl->get_group_name( $user->gid, 'ARO' ) );
		$lists = array();
		$my_group = strtolower( $acl->get_group_name( $user->gid, 'ARO' ) );
		if ($my_group == 'super administrator') {
			$lists['gid'] = "<input type=\"hidden\" mosReq=0 name=\"gid\" value=\"$my->gid\" /><strong>Super Administrator</strong>";
		} else {
			// ensure user can't add group higher than themselves
			$my_groups = $acl->get_object_groups( 'users', $my->id, 'ARO' );
			if (is_array( $my_groups ) && count( $my_groups ) > 0) {
				$ex_groups = $acl->get_group_children( $my_groups[0], 'ARO', 'RECURSE' );
			} else {
				$ex_groups = array();
			}

			$gtree = $acl->get_group_children_tree( null, 'USERS', false );

			// remove users 'above' me
			$i = 0;
			while ($i < count( $gtree )) {
				if (in_array( $gtree[$i]->value, $ex_groups )) {
					array_splice( $gtree, $i, 1 );
				} else {
					$i++;
				}
			}

			$lists['gid'] = JHTML::_('select.genericlist', $gtree, 'gid', 'size="4" mosReq=0', 'value', 'text', $user->gid );
		}

		// make the select list for yes/no fields
		$yesno[] = JHTML::_('select.option',  '0', 'No' );
		$yesno[] = JHTML::_('select.option',  '1', 'Yes' );

		// build the html select list
		$lists['block'] = yesnoSelectList( 'block', 'class="inputbox" size="1"', $user->block );
		$lists['banned'] = yesnoSelectList( 'banned', 'class="inputbox" size="1"', $user->banned );
		$lists['approved'] = yesnoSelectList( 'approved', 'class="inputbox" size="1"', $user->approved );
		$lists['confirmed'] = yesnoSelectList( 'confirmed', 'class="inputbox" size="1"', $user->confirmed );
		$lists['avatarapproved'] = yesnoSelectList( 'avatarapproved', 'class="inputbox" size="1"', $user->avatarapproved );
		// build the html select list
		$lists['sendEmail'] = yesnoSelectList( 'sendEmail', 'class="inputbox" size="1"', $user->sendEmail );

		$return .= "<tr>\n";
		$return .= "  <td valign=\"top\" class=\"titleCell\">"._UE_CBE_UM_USERGROUP.":</td>\n";
		$return .= "  <td>".$lists['gid']."</td>\n";
		$return .= "</tr>\n";

		if ($canBlockUser) {
			$return .= "<tr>\n";
			$return .= "  <td class=\"titleCell\">"._UE_CBE_UM_BLOCK_USER."</td>\n";
			$return .= "  <td>".$lists['block']."</td>\n";
			$return .= "</tr>\n";
//			$return .= "<tr>\n";
//			$return .= "  <td class=\"titleCell\">"._UE_CBE_UM_BAN_USER."</td>\n";
//			$return .= "  <td>".$lists['banned']."</td>\n";
//			$return .= "</tr>\n";
			$return .= "<tr>\n";
			$return .= "  <td class=\"titleCell\">"._UE_CBE_UM_USERDATA_APPROVED."</td>\n";
			$return .= "  <td>".$lists['approved']."</td>\n";
			$return .= "</tr>\n";
			$return .= "<tr>\n";
			$return .= "  <td class=\"titleCell\">"._UE_CBE_UM_USER_CONFIRMED."</td>\n";
			$return .= "  <td>".$lists['confirmed']."</td>\n";
			$return .= "</tr>\n";
			$return .= "<tr>\n";
			$return .= "  <td class=\"titleCell\">"._UE_CBE_UM_AVATAR_APPROVED."</td>\n";
			$return .= "  <td>".$lists['avatarapproved']."</td>\n";
			if ($user->avatar!='') {
				if (strpos($user->avatar,"gallery/") === false) {
					$av_path = JURI::root()."images/cbe/tn".$user->avatar;
					$av_path1 = JURI::root()."images/cbe/".$user->avatar;
				} else {
					$av_path = JURI::root()."images/cbe/".$user->avatar;
					$av_path1 = JURI::root()."images/cbe/".$user->avatar;
				}
				$av_img = '<img style="cursor:hand;" src="'.$av_path.'" border="1" onclick="this.src=\''.$av_path1.'\'" />';
			} else {
				if(file_exists(JPATH_SITE."/components/com_cbe/images/".$mosConfig_lang)) {
					$uimagepath=JURI::root()."components/com_cbe/images/".$mosConfig_lang."/";
				} else {
					$uimagepath=JURI::root()."components/com_cbe/images/english/";
				}
				$av_path = $uimagepath."tnnophoto.jpg";
				$av_img = '<img src="'.$av_path.'" border="1">';
			}
			$return .= "  <td>".$av_img."</td>\n";
			$return .= "</tr>\n";

		}
		if ($canEmailEvents) {
			$return .= "<tr>\n";
			$return .= "  <td class=\"titleCell\">"._UE_CBE_UM_SUBMISSION_MAIL."</td>\n";
			$return .= "  <td>".$lists['sendEmail']."</td>\n";
			$return .= "</tr>\n";
		}
		if( $user->id) {
			$return .= "<tr>\n";
			$return .= "   <td class=\"titleCell\">"._UE_CBE_UM_REGISTER_DATE."</td>\n";
			$return .= "   <td>".$user->registerDate."</td>\n";
			$return .= "</tr>\n";
			$return .= "<tr>\n";
			$return .= "   <td class=\"titleCell\">"._UE_CBE_UM_LAST_VISIT."</td>\n";
			$return .= "   <td>".$user->lastvisitDate."</td>\n";
			$return .= "</tr>\n";
		}
	}

	$return .= "</table>\n";
	return $return;
}

function _getContactUserParams($ui, $user, $name='cbeparams') {
	global $mainframe,$version;

//	if (class_exists('mosUserParameters')) {
	if (eregi('joomla',$version->PRODUCT)) {
		if(file_exists(JPATH_SITE .'/administrator/components/com_users/users.class.php')){
			require_once( JPATH_SITE .'/administrator/components/com_users/users.class.php' );		
		}
               	
		$file 	= $mainframe->getPath( 'com_xml', 'com_users' );
		//$ju_params =& new mosUserParameters( $user->params, $file, 'component' );
		$ju_params =& new JParameter( $user->params, $file, 'component' );

		//Joomla 1.0x
		if ($ju_params->_path) {
			if (!is_object( $ju_params->_xmlElem )) {
				require_once( JPATH_SITE . '/includes/domit/xml_domit_lite_include.php' );

				$xmlDoc = new DOMIT_Lite_Document();
				$xmlDoc->resolveErrors( true );
				if ($xmlDoc->loadXML( $ju_params->_path, false, true )) {
					$root =& $xmlDoc->documentElement;

					$tagName = $root->getTagName();
					$isParamsFile = ($tagName == 'mosinstall' || $tagName == 'mosparams');
					if ($isParamsFile && $root->getAttribute( 'type' ) == $ju_params->_type) {
						if ($params = &$root->getElementsByPath( 'params', 1 )) {
							$ju_params->_xmlElem =& $params;
						}
					}
				}
			}
		}
		//
		$result = "";
		
		if (is_object( $ju_params->_xmlElem )) {
			$html = array();
			$element =& $ju_params->_xmlElem;

			//$params = mosParseParams( $row->params );
			$ju_params->_methods = get_class_methods( "mosUserParameters" );
			
			foreach ($element->childNodes as $param) {
				$res = $ju_params->renderParam( $param );
				$html[] = '<tr>';
				$html[] = '   <td class="titleCell">'.$res[0].'</td>';
				$html[] = '   <td>' . $res[1] . '</td>';
				$html[] = '</tr>';
			}
			if (count( $element->childNodes ) < 1) {
				$html[] = "<tr><td colspan=\"2\">&nbsp;</td></tr>";
			}
			$result = implode( "\n", $html );
		}
		
	} else {
		$result = "";
	}
	return $result;
}

function getGeoCoderEdit ($tab,$user,$action,$ui) {
	global $ueConfig, $enhanced_Config;
	global $mosConfig_lang,$acl,$database,$mainframe, $version, $my, $Itemid_com;
	
	$return = "";
	$done = 0;
	if ($action==1) { return; }
	if ($ui != 2 && $ui != 1) {
		return;
	} else {
		if (file_exists(JPATH_SITE.'/components/com_cbe/enhanced/geocoder/geocoder.classinc.php')) {
			include(JPATH_SITE.'/components/com_cbe/enhanced/geocoder/geocoder.classinc.php');
			$return = $re_output;
		} else {
			return;
		}
	}
	return $return;
}

function unHtmlspecialchars($text) {
	if (strpos($text, "&lt;") !== false) {
		return str_replace(array("&amp;","&quot;","&#039;","&lt;","&gt;"), array("&","\"","'","<",">"), $text);
	} else {
		return $text;
	}
}

function utf8RawUrlDecode ($source) {
	$decodedStr = '';
	$pos = 0;
	$len = strlen ($source);
	while ($pos < $len) {
		$charAt = substr ($source, $pos, 1);
		if ($charAt=='%') {
			$pos++;
			$charAt = substr ($source, $pos, 1);
			if ($charAt=='u') { // we got a unicode character
			$pos++;
			$unicodeHexVal = substr ($source, $pos, 4);
			$unicode = hexdec ($unicodeHexVal);
			$entity = "&#". $unicode . ';';
			$decodedStr .= utf8_encode ($entity);
			$pos += 4;
			} else { // we have an escaped ascii character
			$hexVal = substr ($source, $pos, 2);
			$decodedStr .= chr (hexdec ($hexVal));
			$pos += 2;
			}
		} else {
			$decodedStr .= $charAt;
			$pos++;
		}
	}
	return $decodedStr;
}
function cbGetEscaped( $string ) {
	$database = &JFactory::getDBO();
	if (get_magic_quotes_gpc()==1) {
		return ( $string );
	} else {
		return ( $database->getEscaped( $string ) );
	}
}

function cbGetUnEscaped( $string ) {
	if (get_magic_quotes_gpc()==1) {
		$string = str_replace("\\","",$string);
		return ( stripslashes( $string ));
	} else {
		return ( $string );
	}
}

function cbGetEscapedObj( &$mixed, $exclude_keys='' ) {
	$database = &JFactory::getDBO();
	if (is_object( $mixed )) {
		foreach (get_object_vars( $mixed ) as $k => $v) {
			if (is_array( $v ) || is_object( $v ) || $v == NULL || substr( $k, 1, 1 ) == '_' ) {
				continue;
			}
			if (is_string( $exclude_keys ) && $k == $exclude_keys) {
				continue;
			} else if (is_array( $exclude_keys ) && in_array( $k, $exclude_keys )) {
				continue;
			}
			if (get_magic_quotes_gpc() == 1) {
				$mixed->$k = $v;
			} else {
				$mixed->$k = $database->getEscaped($v);
			}
		}
	}
}

function AuserGID($oID){
	global $database,$ueConfig;
	$database = &JFactory::getDBO();
	if($oID > 0) {
		$query = "SELECT gid FROM #__users WHERE id = '".$oID."'";
		$database->setQuery($query);
		$gid = $database->loadResult();
		return $gid;
	}
	else return 0;
}

function cbe_wordwrap($text, $limit, $linksave=0) {
	$limit = intval($limit);
	$linksave = intval($linksave);
	$bad_str = array("<", ">");
	$good_str = array(" <", "> ");
	if ($linksave==0) {
		$text = wordwrap($text, $limit, " ", 1);
	} else if ($linksave==1) {
		//$text = str_replace($bad_str, $good_str, $text);
		$text = str_replace("<", " <", $text);
		foreach(explode(" ", strip_tags($text)) as $key => $line) {
			if (strlen($line) > $limit) {
				$rept = wordwrap($line, $limit, " ", 1);
				$text = str_replace($line, $rept, $text);
			}
		}
		//$text = str_replace($good_str, $bad_str, $text);
	}
	return $text;
}
?>