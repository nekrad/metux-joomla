<?php
//****************************************************
// GroupJive Tab in Profile By Phil_K                      *
//						     *
// 27-02-2006                      		     *
// Released under the GNU/GPL License                *
// Version 1.0.1                                     *
// File date: 27-02-2006                             *
//****************************************************

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $database, $userpr, $my, $enhanced_Config;

$gj_tab_path = JPATH_SITE.'/components/com_cbe/enhanced/groupjive/';

if (file_exists($gj_tab_path.'language/'.$mosConfig_lang.'.php')) {
	include_once($gj_tab_path.'language/'.$mosConfig_lang.'.php');
} else {
	include_once($gj_tab_path.'language/english.php');
}

include_once('administrator/components/com_cbe/enhanced_admin/enhanced_config.php');

if ($GLOBALS['Itemid_com']!='') {
	$Itemid_c = $GLOBALS['Itemid_com'];
} else {
	$Itemid_c = '';
}

$func=JRequest::getVar('func', 'show_all' );

$database = &JFactory::getDBO();
$my = &JFactory::getUser();

$database->setQuery("SELECT id FROM #__menu WHERE (link LIKE '%com_groupjive%') AND (published='1' OR published='0') ORDER BY id DESC Limit 1");
$gj_itemid = $database->loadResult();
if ($gj_itemid != '') {
	$gj_itemid = "&amp;Itemid=".$gj_itemid;
}

If ($userpr=='' && $user =='') {
	$user_g = $my->id;
} else {
	$user_g = $user->id;
}

	$database->setQuery( "SELECT u.* FROM #__cbe c, #__users u WHERE c.id=u.id AND c.id='".$user_g."'");
	$users_g = $database->loadObjectList();
	$user_g = $users_g[0];

switch ($func) {
	
	case "show_all":
	echo gj_show_all( $Item_id_c, $option, $my->id, $user_g, _UE_UPDATE);
	break;

	// for testing
	case "show_oll":
	echo gj_show_all_old( $Item_id_c, $option, $my->id, $user_g, _UE_UPDATE);
	break;

	case "gj_owned":
	echo gj_write_navlinks( $Item_id_c, $option, $uid, $user_g, $submitvalue);
	echo gj_show_owned( $Item_id_c, $option, $my->id, $user_g, _UE_UPDATE);
	break;

	case "gj_memberof":
	echo gj_write_navlinks( $Item_id_c, $option, $uid, $user_g, $submitvalue);
	echo gj_show_memberof( $Item_id_c, $option, $my->id, $user_g, _UE_UPDATE);
	break;
	
	default:
	echo gj_show_all( $Item_id_c, $option, $my->id, $user_g, _UE_UPDATE);
	break;

}

function gj_write_navlinks( $Item_id_c, $option, $uid, $user_g, $submitvalue) {
	global $func;

	$gj_nav_return = "<div style=\"text-align:center;\"> ";
	$gj_nav_return .= "<a href=\"index.php?option=com_cbe".$Itemid_c."&amp;task=userProfile&amp;user=".$user_g->id."&amp;func=show_all&amp;index="._UE_GROUPJIVE_TAB_LABEL."\">";
	$gj_nav_return .= (($func=='show_all'||$func=='') ? "<b>" : "")._UE_GJ_SHOWALL.(($func=='show_all'||$func=='') ? "</b>" : "")."</a>";
	$gj_nav_return .= " - <a href=\"index.php?option=com_cbe".$Itemid_c."&amp;task=userProfile&amp;user=".$user_g->id."&amp;func=gj_owned&amp;index="._UE_GROUPJIVE_TAB_LABEL."\">";
	$gj_nav_return .= (($func=='gj_owned') ? "<b>" : "")._UE_GJ_SHOWOWNED.(($func=='gj_owned') ? "</b>" : "")."</a>";
	$gj_nav_return .= " - <a href=\"index.php?option=com_cbe".$Itemid_c."&amp;task=userProfile&amp;user=".$user_g->id."&amp;func=gj_memberof&amp;index="._UE_GROUPJIVE_TAB_LABEL."\">";
	$gj_nav_return .= (($func=='gj_memberof') ? "<b>" : "")._UE_GJ_SHOWMEMBEROF.(($func=='gj_memberof') ? "</b>" : "")."</a>";
	$gj_nav_return .= "</div> \n";
	
	return $gj_nav_return;
}

function gj_show_owned ( $Item_id_c, $option, $uid, $user_g, $submitvalue ) {
	global $gj_itemid;
	
	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();
	$gj_own_out ="";
	
	$q_own = 'SELECT a.id, a.name, a.descr, c.catname FROM #__gj_groups a '
		.'INNER JOIN #__gj_grcategory c ON a.category = c.id '
		.'WHERE user_id = '.$user_g->id.' ORDER BY id, name';
	$database->setQuery($q_own);
	$groups=$database->loadObjectList();

	if (!$database->query()) {
		$q_own = 'SELECT a.id, a.name, a.descr, c.catname FROM #__gj_groups a '
			.'INNER JOIN #__gj_grcaterory c ON a.category = c.id '
			.'WHERE user_id = '.$user_g->id.' ORDER BY id, name';
		$database->setQuery($q_own);
		$groups=$database->loadObjectList();
	}

 	$gj_own_out .= "\n<br><table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
 	if ($my->id == $user_g->id) {
 		$gj_own_out .= "\n<tr>\n<td align=left align=center class=\"sectiontableheader\" colspan=\"5\">"._UE_GJTAB_YOU." ";
		if (count($groups) < 1) {
			$gj_own_out .= _UE_GROUPJIVE_NODATA_O."</td>\n</tr>";
		} else {
 			$gj_own_out .= ((count($groups) > 1) ? _UE_GJTAB_YOWNEROF : _UE_GJTAB_YOWNEROFS)."</td>\n</tr>";
 		}
 	} else {
 		$gj_own_out .= "\n<tr>\n<td align=left align=center class=\"sectiontableheader\" colspan=\"5\">".$user_g->username." ";
 		if (count($groups) < 1) {
			$gj_own_out .= _UE_GROUPJIVE_NODATA_O."</td>\n</tr>";
		} else {
			$gj_own_out .= ((count($groups) > 1) ? _UE_GJTAB_OWNEROF : _UE_GJTAB_OWNEROFS)."</td>\n</tr>";
		}
 	}

	$mouseover = "onmouseover=\"this.T_LEFT=true;this.T_WIDTH=125;return";
	
	if (count($groups) > 0) {
		foreach($groups as $group) {
	
			$gj_info = "escape('".$group->descr."')\"";
			$gj_tip = $mouseover." ".$gj_info;
	
			$i= ($i==1) ? 2 : 1;
	 		$gj_own_out .= "\n<tr class=sectiontableentry".$i.">\n";
			$gj_own_out .= "<td>";
			$gj_own_out .= $group->catname.'</td><td style="white-space:nowrap;">-></td><td '.$gj_tip.'>'.$group->name.'</td>';
			if ($my->id != $user_g->id) {
				$gj_own_out .= '<td><a href="index.php?option=com_groupjive'.$gj_itemid.'&amp;task=sign&amp;groupid='.$group->id.'">'._UE_GJ_TAB_JOINGROUP.'</a></td><td><a href="index.php?option=com_groupjive'.$gj_itemid.'&amp;task=showgroup&amp;groupid='.$group->id.'">'._UE_GJTAB_VIEWGROUP.'</a></td></tr>';
			} else {
				$database->setQuery("SELECT COUNT(id) FROM #__gj_users WHERE status='1' AND id_group='".$group->id."'");
				$inac_user = $database->loadResult();
				$database->setQuery("SELECT COUNT(id) FROM #__gj_users WHERE status='0' AND id_group='".$group->id."'");
				$ac_user = $database->loadResult();
	
				$gj_own_out .= '<td><a href="index.php?option=com_groupjive'.$gj_itemid.'&amp;task=showgroup&amp;groupid='.$group->id.'">'.$ac_user.' '._UE_GJTAB_ACTIVE.'</a></td><td><a href="index.php?option=com_groupjive'.$gj_itemid.'&task=inactiveusers&groupid='.$group->id.'">'.$inac_user.' '._UE_GJTAB_INACTIVE.'</a></td></tr>';
			}
		}
	}

	$gj_own_out .= '</table>';

	return $gj_own_out;

}

function gj_show_memberof ( $Item_id_c, $option, $uid, $user_g, $submitvalue ) {
	global $gj_itemid;

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();
	
	$gj_member_out ="";
	
	$q_member = "SELECT a.id, a.name, a.descr, c.catname FROM #__gj_groups a "
			."INNER JOIN #__gj_users b ON a.id = b.id_group "
			."INNER JOIN #__gj_grcategory c ON a.category = c.id "
			."WHERE id_user = ".$user_g->id." AND b.status='0' "
			."ORDER BY a.id, name";
	$database->setQuery($q_member);
	$groups=$database->loadObjectList();

	if (!$database->query()) {
		$q_member = "SELECT a.id, a.name, a.descr, c.catname FROM #__gj_groups a "
			."INNER JOIN #__gj_users b ON a.id = b.id_group "
			."INNER JOIN #__gj_grcategory c ON a.category = c.id "
			."WHERE id_user = ".$user_g->id." AND b.status='0' "
			."ORDER BY a.id, name";
		$database->setQuery($q_member);
		$groups=$database->loadObjectList();
	}

 	$gj_member_out .= "\n<br><table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
 	if ($my->id == $user_g->id) {
 		$gj_member_out .= "\n<tr>\n<td align=left align=center class=\"sectiontableheader\" colspan=\"5\">"._UE_GJTAB_YOU." ";
 		if (count($groups) < 1) {
			$gj_member_out .= _UE_GROUPJIVE_NODATA_M."</td>\n</tr>";
		} else {
			$gj_member_out .= ((count($groups) > 1) ? _UE_GJTAB_YMEMBEROF : _UE_GJTAB_YMEMBEROFS)."</td>\n</tr>";
		}
 	} else {		
 		$gj_member_out .= "\n<tr>\n<td align=left align=center class=\"sectiontableheader\" colspan=\"5\">".$user_g->username." ";
 		if (count($groups) < 1) {
			$gj_member_out .= _UE_GROUPJIVE_NODATA_M."</td>\n</tr>";
		} else {
	 		$gj_member_out .= ((count($groups) > 1) ? _UE_GJTAB_MEMBEROF : _UE_GJTAB_MEMBEROFS)."</td>\n</tr>";
	 	}
 	}

	$mouseover = "onmouseover=\"this.T_LEFT=true;this.T_WIDTH=125;return";

	if (count($groups) > 0) {		
		foreach($groups as $group) {
        	
			$gj_info = "escape('".$group->descr."')\"";
			$gj_tip = $mouseover." ".$gj_info;
        	
			$i= ($i==1) ? 2 : 1;
 			$gj_member_out .= "\n<tr class=sectiontableentry".$i.">\n";
			$gj_member_out .= "<td>";
			$gj_member_out .= $group->catname.'</td><td style="white-space:nowrap;">-></td><td '.$gj_tip.'>'.$group->name.'</td>';
			if ($my->id != $user_g->id) {
				$gj_member_out .= '<td><a href="index.php?option=com_groupjive'.$gj_itemid.'&amp;task=sign&amp;groupid='.$group->id.'">'._UE_GJ_TAB_JOINGROUP.'</a></td><td><a href="index.php?option=com_groupjive'.$gj_itemid.'&amp;task=showgroup&amp;groupid='.$group->id.'">'._UE_GJTAB_VIEWGROUP.'</a></td></tr>';
			} else {
				$database->setQuery("SELECT COUNT(id) FROM #__gj_users WHERE status='0' AND id_group='".$group->id."'");
				$ac_user = $database->loadResult();
        	
				$gj_member_out .= '<td>&nbsp;</td><td><a href="index.php?option=com_groupjive'.$gj_itemid.'&amp;task=showgroup&amp;groupid='.$group->id.'">'.$ac_user.' '._UE_GJTAB_ACTIVE.'</a></td></tr>';
			}
		}
	}

	$gj_member_out .= '</table>';

	return $gj_member_out;

}

function gj_show_all ( $Item_id_c, $option, $uid, $user_g, $submitvalue ) {
	global $gj_itemid;

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	$gj_all_return = "";
	$gj_all_return .= gj_write_navlinks ( $Item_id_c, $option, $uid, $user_g,$submitvalue );
	
	$q_member = 'SELECT a.id, a.name, a.descr, c.catname, a.user_id as creator_id FROM #__gj_groups a '
			.'INNER JOIN #__gj_users b ON a.id = b.id_group '
			.'INNER JOIN #__gj_grcategory c ON a.category = c.id '
			.'WHERE id_user = '.$user_g->id.' '
			.'ORDER BY a.id, name';
	$database->setQuery($q_member);
	$groups=$database->loadObjectList();

	if (!$database->query()) {
		$q_member = 'SELECT a.id, a.name, a.descr, c.catname, a.user_id as creator_id FROM #__gj_groups a '
				.'INNER JOIN #__gj_users b ON a.id = b.id_group '
				.'INNER JOIN #__gj_grcaterory c ON a.category = c.id '
				.'WHERE id_user = '.$user_g->id.' '
				.'ORDER BY a.id, name';
		$database->setQuery($q_member);
		$groups=$database->loadObjectList();
	}
	
 	$gj_all_return .= "\n<br><table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
// 	$gj_all_return .= "\n<tr>\n<td align=left align=center class=\"sectiontableheader\" colspan=\"6\">".$user_g->username." ".((count($groups) > 1) ? _UE_GJTAB_MEMBEROF : _UE_GJTAB_MEMBEROFS)."</td>\n</tr>";
 	if ($my->id == $user_g->id) {
 		$gj_all_return .= "\n<tr>\n<td align=left align=center class=\"sectiontableheader\" colspan=\"6\">"._UE_GJTAB_YOU." ";
 		if (count($groups) < 1) {
			$gj_all_return .= _UE_GROUPJIVE_NODATA_M."</td>\n</tr>";
		} else {
			$gj_all_return .= ((count($groups) > 1) ? _UE_GJTAB_YMEMBEROF : _UE_GJTAB_YMEMBEROFS)."</td>\n</tr>";
		}
 	} else {		
 		$gj_all_return .= "\n<tr>\n<td align=left align=center class=\"sectiontableheader\" colspan=\"6\">".$user_g->username." ";
 		if (count($groups) < 1) {
			$gj_all_return .= _UE_GROUPJIVE_NODATA_M."</td>\n</tr>";
		} else {
	 		$gj_all_return .= ((count($groups) > 1) ? _UE_GJTAB_MEMBEROF : _UE_GJTAB_MEMBEROFS)."</td>\n</tr>";
	 	}
 	}

	$mouseover = "onmouseover=\"this.T_LEFT=true;this.T_WIDTH=125;return";
	$mouseover_c = "onmouseover=\"this.T_LEFT=true;this.T_WIDTH=60;return";

	if (count($groups) > 0) {		
		foreach($groups as $group) {
        	
			$database->setQuery("SELECT COUNT(id) FROM #__gj_users WHERE status='0' AND id_group='".$group->id."'");
			$ac_user = $database->loadResult();
        	
			$gj_info = "escape('".$group->descr."')\"";
			$gj_tip = $mouseover." ".$gj_info;
        	
			$i= ($i==1) ? 2 : 1;
 			$gj_all_return .= "\n<tr class=sectiontableentry".$i.">\n";
			$gj_all_return .= "<td>";
			$gj_all_return .= $group->catname.'</td><td style="white-space:nowrap;">-></td><td '.$gj_tip.'>'.$group->name.'</td>';
			
			if ($user_g->id != $group->creator_id) {
				$gj_tip_c = $mouseover_c." escape('"._UE_GJ_SHOWMEMBEROF."')\"";
				$gj_creator_tag = " <u ".$gj_tip_c.">(M)</u> ";
			} else {
				$gj_tip_c = $mouseover_c." escape('"._UE_GJ_SHOWOWNED."')\"";
				$gj_creator_tag = " <u ".$gj_tip_c.">(C)</u> ";
			}
        	
			$gj_all_return .= '<td>'.$gj_creator_tag.' </td>';
			$gj_all_return .= '<td>'.$ac_user.' '._UE_GJTAB_ACTIVE.'</td>';
			$gj_all_return .= '<td><a href="index.php?option=com_groupjive&amp;task=showgroup&amp;groupid='.$group->id.'">'._UE_GJTAB_VIEWGROUP.'</a></td></tr>';
		}
	}

	$gj_all_return .= '</table>';

	return $gj_all_return;

}


function gj_show_all_old ( $Item_id_c, $option, $uid, $user_g, $submitvalue ) {

	$gj_all_return = "";
	$gj_all_return .= gj_write_navlinks ( $Item_id_c, $option, $uid, $user_g, $submitvalue );
	$gj_all_return .= gj_show_owned ( $Item_id_c, $option, $uid, $user_g, $submitvalue );
	$gj_all_return .= "<br> \n";
	$gj_all_return .= gj_show_memberof ( $Item_id_c, $option, $uid, $user_g, $submitvalue );
	
	echo $gj_all_return;
	
}


?>
