<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

//********************************************
// LastVisitors-Tab by Philipp Kolloczek     *
// v0.9.1				 *
// Copyright (c) 2005 Philipp Kolloczek      *
// Based on the work of Fons		 *
// 02-09-2005 http://www.kolloczek.com       *
// Released under the GNU/GPL License        *
// Language File v0.9.1 File date: 02-09-2005*
// 					 *
// Read the readme !!			 *
//********************************************

// needed includes

include_once('components/com_cbe/enhanced/enhanced_functions.inc');

if (file_exists('components/com_cbe/enhanced/lastvisitors/language/'.$mosConfig_lang.'.php')) {	
	include_once('components/com_cbe/enhanced/lastvisitors/language/'.$mosConfig_lang.'.php');
} else {	
	include_once('components/com_cbe/enhanced/lastvisitors/language/english.php');
}

include_once('administrator/components/com_cbe/enhanced_admin/enhanced_config.php');

if ( !in_array( 'enhanced.class.php', get_included_files() ) ) {
	require_once( JPATH_SITE.'/components/com_cbe/enhanced/enhanced.class.php' );
}


// needed includes END

// User setable parameters

$debug_lv = '0';
$maxentry 		= $enhanced_Config['lastvisitors_maxentry'];
$countself 		= $enhanced_Config['lastvisitors_countself'];
$owneronly 		= $enhanced_Config['lastvisitors_owneronly'];
$show_time 		= $enhanced_Config['lastvisitors_showtime'];			
	// 0 => no timestamp, 1 => show timestamp, 2 => show since days
$show_online 		= $enhanced_Config['lastvisitors_showonline'];
$show_age 		= $enhanced_Config['lastvisitors_showage'];
$gender_show 		= $enhanced_Config['lastvisitors_showgender'];	
	// symbol => show pic.-symbol, tag => show name-tag, all other => show no gender
$show_visitcount	= $enhanced_Config['lastvisitors_showvisitcount'];
$show_visited_tab	= $enhanced_Config['lastvisitors_showvisitedtab'];
$show_user_field	= $enhanced_Config['lastvisitors_showuserfield'];
$lv_user_field		= $enhanced_Config['lastvisitors_userfield'];

$birthday_field_name = $enhanced_Config['lastvisitors_birthday_field'];
//die($birthday_field_name);
$gender_field_name = $enhanced_Config['lastvisitors_gender_field'];
$lastvisitor_datestr = $enhanced_Config['lastvisitors_datestring'];
$col_span = 1;

$gender_type = array($enhanced_Config['lastvisitors_female'] => $enhanced_Config['lastvisitors_femaleimage'],
		     $enhanced_Config['lastvisitors_male'] => $enhanced_Config['lastvisitors_maleimage'],
		     $enhanced_Config['lastvisitors_couple1'] => $enhanced_Config['lastvisitors_couple1image'],
		     $enhanced_Config['lastvisitors_couple2'] => $enhanced_Config['lastvisitors_couple2image'],
		     $enhanced_Config['lastvisitors_couple3'] => $enhanced_Config['lastvisitors_couple3image'],
		     $enhanced_Config['lastvisitors_neutral'] => $enhanced_Config['lastvisitors_neutralimage']);

$online_type = array("0" => $enhanced_Config['lastvisitors_offlineimage'],
		     "1" => $enhanced_Config['lastvisitors_onlineimage']);

$cbe_path = JURI::root() . "components/com_cbe/enhanced/lastvisitors/";

if ($GLOBALS['Itemid_com']!='') {
	$Itemid_c = $GLOBALS['Itemid_com'];
} else {
	$Itemid_c = '';
}


// user parameter END

$nolastuser = 0;
$lv_finalout = '';
$vis_finalout = '';
$lastvisitor = _UE_LAST_VISITORS;
$lastvisitor2 = _UE_LAST_VISITED;
$lastvisitor_owner = _UE_LAST_VISITORS_OWNER;
$lastvisitor_first = _UE_LAST_VISITORS_FIRST;

$lastvisitor_guest .= _UE_LAST_VISITORS_guest;
$lastvisitor_deleuser .= _UE_LAST_VISITORS_deleuser;

$visitor_tab_name = _UE_LAST_VISITOR_VISITOR_TAB;
$visited_tab_name = _UE_LAST_VISITOR_VISITED_TAB;

if ($show_online!='0') {
	$col_span = $col_span + 1;
}
if ($show_age!='0') {
	$col_span = $col_span + 1;
}
if ($gender_show!='not') {
	$col_span = $col_span + 1;
}
if ($show_time!='0') {
	$col_span = $col_span + 1;
}
if ($show_visitcount=='1' && $my->id==$user->id) {
	$col_span = $col_span + 1;
}
if ($show_user_field!='0') {
	$col_span = $col_span + 1;
}

$td_space = floor(100 / $col_span) ."%";

$time_now = time();

// own function

function my_diff_time($sometime) {

	$txt_t_pre	= _UE_LAST_VISITORS_txt_t_pre;
	$txt_t_post	= _UE_LAST_VISITORS_txt_t_post;
	$just_now	= _UE_LAST_VISITORS_just_now;
	$txt_minutes	= _UE_LAST_VISITORS_txt_minutes;
	$txt_min_post	= _UE_LAST_VISITORS_txt_min_post;
	$txt_hours	= _UE_LAST_VISITORS_txt_hours;
	$txt_h_post	= _UE_LAST_VISITORS_txt_h_post;
	$txt_days	= _UE_LAST_VISITORS_txt_days;
	$txt_d_post	= _UE_LAST_VISITORS_txt_d_post;
	$txt_weeks	= _UE_LAST_VISITORS_txt_weeks;
	$txt_w_post	= _UE_LAST_VISITORS_txt_w_post;
	$txt_month	= _UE_LAST_VISITORS_txt_month;
	$txt_m_post	= _UE_LAST_VISITORS_txt_m_post;
	$txt_year	= _UE_LAST_VISITORS_txt_year;

	$secs = $sometime;
	if ($secs < 60) {
		$new_time = $just_now;
	}
	$minutes = round($secs / 60);
	if ($minutes != 0) {
		if ($minutes > 1) $txt_minutes=$txt_minutes.$txt_min_post;
		$new_time = $txt_t_pre.$minutes." ".$txt_minutes.$txt_t_post.".";
	}
	$hours = round($minutes / 60);
	if ($hours != 0) {
		if ($hours > 1) $txt_hours=$txt_hours.$txt_h_post;
		$new_time = $txt_t_pre.$hours." ".$txt_hours.$txt_t_post.".";
	}
	$days = round($hours / 24);
	if ($days != 0) {
		if ($days > 1) $txt_days=$txt_days.$txt_d_post;
		$new_time = $txt_t_pre.$days." ".$txt_days.$txt_t_post.".";
	}
	$weeks = round($days / 7);
	if ($weeks != 0) {
		if ($weeks > 1) $txt_weeks=$txt_weeks.$txt_w_post;
		$new_time = $txt_t_pre.$weeks." ".$txt_weeks.$txt_t_post.".";
	}
	$month = round($weeks / 4);
	if ($month != 0) {
		if ($month > 1) $txt_month=$txt_month.$txt_m_post;
		$new_time = $txt_t_pre.$month." ".$txt_month.$txt_t_post.".";
	}
	if ($month > 12) {
		$new_time = $txt_year;
	}
	
	return $new_time;
}

function my_age($somedate,$nowtime) {
	$tmpdate = $somedate;
	$tmp_ntime = $nowtime;
	if ($tmpdate == '') {
		$tmpdate = '0000-00-00';
	}
	if ($tmpdate != '0000-00-00') {
		$date_u = strtotime($tmpdate);
		if ($date_u != -1) {
			$age_time = $tmp_ntime - $date_u;
			$a_age = (date('Y') - date('Y',$date_u)) - intval(date('md') < sprintf('%02d%02d' , date('m',$date_u), date('d',$date_u)) );
		} else {
			//$age_times = explode("-", $tmpdate);
			//$age_year = $age_times[0];
			//$a_age = date('Y') - $age_year;
			$date_ar = explode("-",$tmpdate);
			$a_age = date('Y') - $date_ar[0];
			
			if($date_ar[1] > date("m") || ($date_ar[1] == date("m") && $date_ar[2] > date("d"))) {
				$a_age--;
			}			
		}
	} else {
		$a_age = "--";
	}
	
	$age = "(".$a_age.")";
	return $age;
	// $age => String in the form of (21)
}



// Code starts here
$my = &JFactory::getUser();
$database = &JFactory::getDBO();

if (($user->id==$my->id) && ($countself == 0)) {
	// return;
} else {
	// check if user revisits
	$query_re = "SELECT visits FROM #__cbe_lastvisitor WHERE uid='".$user->id."' AND visitor='".$my->id."'";
	$database->setQuery($query_re);
	$visits_nr = $database->loadResult();
	
	if ( $visits_nr != '' || $visits_nr != NULL ) {
		$visits_nr = $visits_nr + 1;
		$query_update = "UPDATE #__cbe_lastvisitor SET visits='".$visits_nr."' WHERE uid='".$user->id."' AND visitor='".$my->id."'";
		$database->setQuery($query_update);
		if (!$database->query()) {
			echo "DB Update Error<br>";
		}
	} else {
		$query_visit = "INSERT INTO #__cbe_lastvisitor (uid, visitor, vdate, visits) VALUES ('".$user->id."','".$my->id."',NULL,'1')";
		$database->setQuery($query_visit);
		if (!$database->query()) {
			echo "DB Insert Error<br>";
		}
	}
}

$cmentry = $maxentry * 2;
$database->setQuery("SELECT count(visitor) FROM #__cbe_lastvisitor WHERE uid='".$user->id."'");
$overall_lv = $database->loadResult();

if ($overall_lv > $cmentry) {
	$query_lv = "SELECT visitor, UNIX_TIMESTAMP(vdate) as vdate, vdate as vxdate, visits FROM #__cbe_lastvisitor WHERE uid='".$user->id."' ORDER by vdate DESC LIMIT ".$maxentry;
	$database->setQuery($query_lv);
	$visitors = $database->loadObjectList();
	$database->setQuery("DELETE FROM #__cbe_lastvisitor WHERE uid='".$user->id."'");
	$database->query();
	foreach ($visitors as $visitor) {
		$database->setQuery("INSERT INTO #__cbe_lastvisitor (uid, visitor, vdate, visits) VALUES ('".$user->id."','".$visitor->visitor."','".$visitor->vxdate."','".$visitor->visits."')");
		$database->query();
	}
} else {
	// $query_lv = "SELECT a.visitor as visitor, b.username as username, UNIX_TIMESTAMP(a.vdate) as vdate, a.visits as visits FROM #__cbe_lastvisitor as a, #__users as b WHERE a.uid='".$user->id."' AND b.id=a.visitor ORDER by vdate DESC LIMIT ".$maxentry;
	$query_lv = "SELECT visitor, UNIX_TIMESTAMP(vdate) as vdate, visits FROM #__cbe_lastvisitor WHERE uid='".$user->id."' ORDER by vdate DESC LIMIT ".$maxentry;
	$database->setQuery($query_lv);
	$visitors = $database->loadObjectList();
}

$visitor_count = count($visitors);
if ($visitor_count == '0' || $visitor_count == '') {
	$nolastuser = 1;
}

$query_vis = "SELECT a.uid as user, b.username as username, UNIX_TIMESTAMP(a.vdate) as vdate, a.visits as visits FROM #__cbe_lastvisitor as a, #__users as b WHERE a.visitor='".$user->id."' AND b.id=a.uid ORDER by vdate DESC LIMIT ".$maxentry;
$database->setQuery($query_vis);
$visited = $database->loadObjectList();

	$query = "SELECT profile_color
			  FROM #__cbe 
			  WHERE user_id = '".$user->id."'";
	$database ->setQuery ($query);
	$bgcolor = $database->loadResult();

	if($enhanced_Config['profile_allow_colors']=='1')
	{
		if($bgcolor)
		{
			$bgcolor = getLangEnDefinition($bgcolor);
			$profileColor=profileColors($bgcolor);
		}
		elseif(!$bgcolor)
		{
			$color=$enhanced_Config['profile_color'];

			if($color)
			{
				$profileColor = $color;
			}
			else
			{
				$profileColor='transparent';
			}
		}

	}

	if($enhanced_Config['profile_allow_colors']=='0')
	{
		$color=$enhanced_Config['profile_color'];

		if($color)
		{
			$profileColor = $color;
		}
		else
		{
			$profileColor='transparent';
		}
	}
$lv_finalout .= '<style type="text/css">'."\n";
$lv_finalout .= ".dynamic-tab-pane-control .tab-page { \n";
$lv_finalout .= "background:".$profileColor." } \n";
$lv_finalout .= "</style> \n";

 $lv_finalout .= "\n<br><table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
 $lv_finalout .= "\n<tr>\n<td align=left align=center class=\"sectiontableheader\" colspan=\"".$col_span."\">$lastvisitor</td>\n</tr>";

if ($enhanced_Config['lastvisitors_showtitlerow']=='1') {
	$th_finalout = "\n<tr>";

	if ($show_online!='0') {
		$th_finalout .= "\n<th align=left align=center class=\"sectiontableheader\">"._UE_LASTVISITORS_ONLINE."</th>\n";
	}
	if ($gender_show!='not') {
		$th_finalout .= "\n<th align=left align=center class=\"sectiontableheader\">"._UE_LASTVISITORS_GENDER."</th>\n";
	}
	if ($show_age!='0') {
		$th_finalout .= "\n<th align=left align=center class=\"sectiontableheader\">"._UE_SHOWAGE_TITLE."</th>\n";
	}

	$q_uname = "SELECT title FROM #__cbe_fields WHERE name='username'";
	$database->setQuery($q_uname);
	$desc_uname = $database->loadResult();
	$desc_uname = getLangEnDefinition($desc_uname);
	$th_finalout .= "\n<th align=left align=center class=\"sectiontableheader\">".$desc_uname."</th>\n";

	if ($show_time!='0') {
		$th_finalout .= "\n<th align=left align=center class=\"sectiontableheader\">"._UE_LASTVISITORS_DATE."</th>\n";
	}
	if ($show_user_field!='0') {
		$query_desc = "SELECT title FROM #__cbe_fields WHERE name='".$enhanced_Config['lastvisitors_userfield']."'";
		$database->setQuery($query_desc);
		$cfield_title = $database->loadResult();
		$cfield_title = getLangEnDefinition($cfield_title);
		$th_finalout .= "\n<th align=left align=center class=\"sectiontableheader\">".$cfield_title."</th>\n";
	}
	if ($show_visitcount=='1' && $my->id==$user->id) {
		$th_finalout .= "\n<th align=left align=center class=\"sectiontableheader\">"._UE_HITS."</th>\n";
	}

	$th_finalout .= "</tr>";
	$lv_finalout .= $th_finalout;
}


if ((($my->id == $user->id) && ($owneronly == 1) && ($nolastuser == 0)) || (($owneronly == 0) && ($nolastuser == 0))) {

	foreach ($visitors as $visitor) 
	{ 

		$qdata 		= '';
		$online_data 	= '';
		$avatar_data	= '';
		$birth_data	= '';
		$gender_data	= '';

		$i= ($i==1) ? 2 : 1;
 		$lv_finalout .= "\n<tr class=sectiontableentry".$i.">\n";

//		$qdata = $visitor->username;
//		$query = "SELECT username FROM #__users WHERE id='".$visitor->visitor."' GROUP BY name LIMIT 1";
//		$database->setQuery($query);
//		$qdata = $database->loadResult();
//		
		$query_on = "SELECT username FROM #__session WHERE userid='".$visitor->visitor."' LIMIT 1";
		$database->setQuery($query_on);
		$online_data = $database->loadResult();

//		$query_avatar = "SELECT avatar from #__cbe WHERE id='".$visitor->visitor."' LIMIT 1";
//		$database->setQuery($query_avatar);
//		$avatar_data = $database->loadResult();
//
//		$query_birth = "SELECT ".$birthday_field_name." from #__cbe WHERE id='".$visitor->visitor."' LIMIT 1";
//		$database->setQuery($query_birth);
//		$birth_data = $database->loadResult();
//
//		$query_com = "SELECT ".$gender_field_name." from #__cbe WHERE id='".$visitor->visitor."' LIMIT 1";
//		$database->setQuery($query_com);
//		$gender_data = $database->loadResult();

		if ($show_age == '1') {
			$bd_field_query = ", c.".$birthday_field_name." as birthdata ";
		} else {
			$bd_field_query = "";
		}
		
		if ($gender_show != 'not') {
			$gd_field_query = ", c.".$gender_field_name." as genderdata ";
		} else {
			$gd_field_query = "";
		}

		$query_all  = "SELECT u.username as username, c.avatar as avatar".$bd_field_query.$gd_field_query." ";
		$query_all .= "FROM #__users as u, #__cbe as c WHERE u.id='".$visitor->visitor."' ";
		$query_all .= "AND u.id=c.id";
		//die("query: " . $query_all);
		$database->setQuery($query_all);
		//die(print_r($database));
		$all_data = '';
		$all_data = $database->loadObject();
		if (!$database->query()) {
			$w=0;
			$bg_query_str = $gd_field_query;
			while ($w <=2) {
				$query_all  = "SELECT u.username as username, c.avatar as avatar".$bg_query_str." ";
				$query_all .= "FROM #__users as u, #__cbe as c WHERE u.id='".$visitor->visitor."' ";
				$query_all .= "AND u.id=c.id";
				$database->setQuery($query_all);
				$all_data = '';
				$database->loadObject($all_data);
				if (!$database->query()) {
					if ($w==0) {
						$bg_query_str = $bd_field_query;
					} elseif ($w ==1 ) {
						$bg_query_str = '';
					}
					$w++;
				} else {
					break;
				}
	
			}
		}

		if ($debug_lv == '1') {
			echo "User-Query: <br>".$query_all;
			echo "<br><hr><br>";
			print_r($all_data);
			echo "<br><hr><br>";
		}

		$qdata 		= $all_data->username;
		//die("kur davor: " . print_r($all_data));
//		$online_data 	= $all_data->sesname;
		$avatar_data	= $all_data->avatar;
		$birth_data	= $all_data->birthdata;
		$gender_data	= $all_data->genderdata;

		if ($show_user_field=='1') {
			$query_custom = "SELECT ".$lv_user_field." FROM #__cbe WHERE id='".$visitor->visitor."' LIMIT 1";
			$database->setQuery($query_custom);
			$custom_data = $database->loadResult();
			$custom_data = "<td nowrap>".$custom_data."</td>";
		} else {
			$custom_data = "";
		}

		if ($visitor->visitor == '0') {
			$qdata = $lastvisitor_guest;
			$nolink = '1';
			if ($gender_show=='tag') {
				$gender_data = "--";
			} else {
				$gender_data = $enhanced_Config['lastvisitors_neutral'];
			}
			$online_data = '1';
			$birth_data = '0000-00-00';
		}

		//die(print_r($qdata) . ", " . print_r($visitor));
		if (($qdata == '') && ($visitor->visitor != '0')) {
			//die("hier bin ich...");
			$qdata = $lastvisitor_deleuser;
			if ($gender_show=='tag') {
				$gender_data = "--";
			} else {
				$gender_data = $enhanced_Config['lastvisitors_neutral'];
			}
			$online_data = '';
			$birth_data = '0000-00-00';
		}


		if ($show_age == 1) {
			$age_out = "<td width='20' align='center' nowrap>".my_age($birth_data,$time_now)."</td>";
		} else {
			$age_out = '';
		}
			
		if ($show_online == 1) {
			if ($online_data != '') {
				$online_out = "<td width='10' align='center' nowrap><img src='".$cbe_path.$online_type[1]."' alt='online'></td> ";
			} else {
				$online_out = "<td width='10' align='center' nowrap><img src='".$cbe_path.$online_type[0]."' alt='offline'></td> ";
			}
		} else {
			$online_out = '';
		}

		if ($show_time == 1) {
			$time_user = $visitor->vdate;
			$time_result = date($lastvisitor_datestr,$time_user);
			$time_out = "<td nowrap>".$time_result."</td>";
		} else if ($show_time == 2) {
			$time_user = $time_now - $visitor->vdate;
			$time_result = my_diff_time($time_user);
			$time_out = "<td nowrap>".$time_result."</td>";
		} else if ($show_time == 0) {
			$time_out = '';
		}

		if ($show_visitcount==1 && $my->id==$user->id) {
			$visitcount_out = "<td width='22' align='center' nowrap>".$visitor->visits."</td>";
		} else {
			$visitcount_out = '';
		}

 		if ($avatar_data != '') {
 			$user_av = "escape('<img src=\'images/cbe/tn".$avatar_data."\' alt=\'photo\' border=\'0\'>')\"";
 		} else {
 			$user_av = "escape('<img src=\'components/com_cbe/images/english/tnnophoto.jpg\' alt=\'no photo\' border=\'0\'>')\"";
 		}

		$mouseover = "onmouseover=\"this.T_LEFT=true;this.T_WIDTH=60;return";
		$avatar_script = $mouseover." ".$user_av;

		if ($qdata==$lastvisitor_guest || $qdata==$lastvisitor_deleuser) {
			$visitor_out = "<td nowrap>".$qdata."</td>";
		} else {
			$visitor_out = "<td nowrap><a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$visitor->visitor."\" ".$avatar_script.">".$qdata."</a></td>";
		}

		if ($gender_show == "symbol") {
			$gender_out = "<td width='22' align='center' nowrap><img src='".$cbe_path.$gender_type[$gender_data]."' alt='".$gender_data."'></td>";
		} else if ($gender_show == "tag") {
			$gender_out = "<td align='center' nowrap>".$gender_data."</td>";
		} else if (($gender_show != "symbol") || ($gender_show != "tag")) {
			$gender_out = "";
		}
		
		$lv_finalout .= $online_out.$gender_out.$age_out.$visitor_out.$time_out.$custom_data.$visitcount_out."</tr>\n";
	}

//******************************

} else if (($my->id != $user->id) && ($owneronly == 1)) {
	$lv_finalout .= "\n".$lastvisitor_owner;
}	

// Tab ausgeben auch wenn kein User bisher da war
if ($nolastuser == 1) {
	$i= ($i==1) ? 2 : 1;
	$lv_finalout .= "\n<tr class=sectiontableentry".$i.">\n";
        $lv_finalout .= "<td colspan='".$col_span."'>".$lastvisitor_first."</td></tr>";
}

 $lv_finalout .= "\n</table> <br />";

// End LV Out

// Start VIS out
if ($show_visited_tab=='1' || $my->id==$user->id) {
	 $vis_finalout .= "\n<br><table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
	 $vis_finalout .= "\n<tr>\n<td align=left align=center class=\"sectiontableheader\" colspan=\"".$col_span."\">$lastvisitor2</td>\n</tr>";

	if ($enhanced_Config['lastvisitors_showtitlerow']=='1') {
		$vis_finalout .= $th_finalout;
	}


	if (($my->id != $user->id) || ($my->id == $user->id)) {
	
		foreach ($visited as $visite) 
		{ 
	
			$i= ($i==1) ? 2 : 1;
	 		$vis_finalout .= "\n<tr class=sectiontableentry".$i.">\n";
	
			$qdata = $visite->username;
			
			$query_on = "SELECT username FROM #__session WHERE userid='".$visite->user."' LIMIT 1";
			$database->setQuery($query_on);
			$online_data = $database->loadResult();
	
//			$query_avatar = "SELECT avatar from #__cbe WHERE id='".$visite->user."' LIMIT 1";
//			$database->setQuery($query_avatar);
//			$avatar_data = $database->loadResult();
	
//			$query_birth = "SELECT ".$birthday_field_name." from #__cbe WHERE id='".$visite->user."' LIMIT 1";
//			$database->setQuery($query_birth);
//			$birth_data = $database->loadResult();
	
//			$query_com = "SELECT ".$gender_field_name." from #__cbe WHERE id='".$visite->user."' LIMIT 1";
//			$database->setQuery($query_com);
//			$gender_data = $database->loadResult();

//-->
			$query_all  = "SELECT u.username as username, c.avatar as avatar".$bd_field_query.$gd_field_query." ";
			$query_all .= "FROM #__users as u, #__cbe as c WHERE u.id='".$visite->user."' ";
			$query_all .= "AND u.id=c.id";
			$database->setQuery($query_all);
			$all_data = '';
			$all_data = $database->loadObject();
			if (!$database->query()) {
				$w=0;
				$bg_query_str = $gd_field_query;
				while ($w <=2) {
					$query_all  = "SELECT u.username as username, c.avatar as avatar".$bg_query_str." ";
					$query_all .= "FROM #__users as u, #__cbe as c WHERE u.id='".$visite->user."' ";
					$query_all .= "AND u.id=c.id";
					$database->setQuery($query_all);
					$all_data = '';
					$all_data = $database->loadObject();
					if (!$database->query()) {
						if ($w==0) {
							$bg_query_str = $bd_field_query;
						} elseif ($w ==1 ) {
							$bg_query_str = '';
						}
						$w++;
					} else {
						break;
					}
		
				}
			}
	
			if ($debug_lv == '1') {
				echo "User-Query: <br>".$query_all;
				echo "<br><hr><br>";
				print_r($all_data);
				echo "<br><hr><br>";
			}
	
	//		$qdata 		= $all_data->username;
	//		$online_data 	= $all_data->sesname;
			$avatar_data	= $all_data->avatar;
			$birth_data	= $all_data->birthdata;
			$gender_data	= $all_data->genderdata;
//<--



			if ($show_user_field=='1') {
				$query_custom = "SELECT ".$lv_user_field." FROM #__cbe WHERE id='".$visite->user."' LIMIT 1";
				$database->setQuery($query_custom);
				$custom_data = $database->loadResult();
				$custom_data = "<td nowrap>".$custom_data."</td>";
			} else {
				$custom_data = "";
			}	

			if ($visite->user == '0') {
				$qdata = $lastvisitor_guest;
				if ($gender_show=='tag') {
					$gender_data = "--";
				} else {
					$gender_data = $enhanced_Config['lastvisitors_neutral'];
				}
				$online_data = '1';
				$birth_data = '0000-00-00';
			}
	
			if (($qdata == '') && ($visite->user != '0')) {
				$qdata = $lastvisitor_deleuser;
				if ($gender_show=='tag') {
					$gender_data = "--";
				} else {
					$gender_data = $enhanced_Config['lastvisitors_neutral'];
				}
				$online_data = '';
				$birth_data = '0000-00-00';
			}
	
	
			if ($show_age == 1) {
				$age_out = "<td width='20' align='center' nowrap>".my_age($birth_data,$time_now)."</td>";
			} else {
				$age_out = '';
			}
				
			if ($show_online == 1) {
				if ($online_data != '') {
					$online_out = "<td width='10' align='center' nowrap><img src='".$cbe_path.$online_type[1]."' alt='online'></td> ";
				} else {
					$online_out = "<td width='10' align='center' nowrap><img src='".$cbe_path.$online_type[0]."' alt='offline'></td> ";
				}
			} else {
				$online_out = '';
			}
	
			if ($show_time == 1) {
				$time_user = $visite->vdate;
				$time_result = date($lastvisitor_datestr,$time_user);
				$time_out = "<td nowrap>".$time_result."</td>";
			} else if ($show_time == 2) {
				$time_user = $time_now - $visite->vdate;
				$time_result = my_diff_time($time_user);
				$time_out = "<td nowrap>".$time_result."</td>";
			} else if ($show_time == 0) {
				$time_out = '';
			}
	
			if ($show_visitcount==1 && $my->id==$user->id) {
				$visitcount_out = "<td width='22' align='center' nowrap>".$visite->visits."</td>";
			} else {
				$visitcount_out = '';
			}
	
	 		if ($avatar_data != '') {
	 			$user_av = "escape('<img src=\'images/cbe/tn".$avatar_data."\' alt=\'photo\' border=\'0\'>')\"";
	 		} else {
	 			$user_av = "escape('<img src=\'components/com_cbe/images/english/tnnophoto.jpg\' alt=\'no photo\' border=\'0\'>')\"";
	 		}
	
			$mouseover = "onmouseover=\"this.T_LEFT=true;this.T_WIDTH=60;return";
			$avatar_script = $mouseover." ".$user_av;
	
			if ($qdata==$lastvisitor_guest || $qdata==$lastvisitor_deleuser) {
				$visitor_out = "<td nowrap>".$qdata."</td>";
			} else {
				$visitor_out = "<td nowrap><a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$visite->user."\" ".$avatar_script.">".$qdata."</a></td>";
			}
	
			if ($gender_show == "symbol") {
				$gender_out = "<td width='22' align='center' nowrap><img src='".$cbe_path.$gender_type[$gender_data]."' alt='".$gender_data."'></td>";
	
			} else if ($gender_show == "tag") {
				$gender_out = "<td align='center' nowrap>".$gender_data."</td>";
			} else if (($gender_show != "symbol") || ($gender_show != "tag")) {
				$gender_out = "";
			}
			
			$vis_finalout .= $online_out.$gender_out.$age_out.$visitor_out.$time_out.$custom_data.$visitcount_out."</tr>\n";
		}
	}
	$vis_finalout .= "\n</table><br>";
}
// END VIS out


// $lv_tabs = new enhancedTabs( 0,1 );
$lv_pid1 = "LV1";
$tabs->startPane($lv_pid1);
$tabs->startTab($lv_pid1,$visitor_tab_name,$visitor_tab_name);
 echo $lv_finalout;
$tabs->endTab();

if ($show_visited_tab=='1' || $my->id==$user->id) {
	$tabs->startTab($lv_pid1,$visited_tab_name,$visited_tab_name);
	 echo $vis_finalout;
	$tabs->endTab();
}

$tabs->endPane();

?>
