<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
//********************************************
// MamboMe SB Forum Tab                      *
// Copyright (c) 2005 Jeffrey Randall        *
// http://mambome.com                        *
// Released under the GNU/GPL License        *
// Version 1.0                               *
// File date: 24-05-2005                     *
//********************************************


if (file_exists('components/com_cbe/enhanced/sb_forum/language/'.$mosConfig_lang.'.php'))
{
	include_once('components/com_cbe/enhanced/sb_forum/language/'.$mosConfig_lang.'.php');
}
else
{
	include_once('components/com_cbe/enhanced/sb_forum/language/english.php');
}

include_once('administrator/components/com_cbe/enhanced_admin/enhanced_config.php');

$prof=mosGetParam( $_REQUEST, 'prof','');
$func=mosGetParam( $_REQUEST, 'func', 'sbForumPosts' );
$sb_thread=mosGetParam( $_REQUEST, 'sb_thread','');

if ($GLOBALS['Itemid_com']!='') {
	$Itemid_c = $GLOBALS['Itemid_com'];
} else {
	$Itemid_c = '';
}


$sbviewtype=mosGetParam( $_REQUEST, 'sbviewtype','');
$sbordering=mosGetParam( $_REQUEST, 'sbordering','');
$sbsignature=mosGetParam( $_REQUEST, 'sbsignature','');

$query_simpleb = "SELECT count(link) FROM #__components WHERE link LIKE '%com_simpleboard%'";
	$database->setQuery($query_simpleb);
	$simple_res = $database->loadResult();
	if ($simple_res < '1') {
		$query_joomlab = "SELECT count(link) FROM #__components WHERE link LIKE '%com_joomlaboard%'";
		$database->setQuery($query_joomlab);
		$jsimple_res = $database->loadResult();
		if ($jsimple_res >= '1') {
			$sb_board_table = "joomlaboard";
		}
	} else {
		$sb_board_table = "simpleboard";
	}


switch ($func)
{
	case "sbForumViewSubs":
	sbForumViewSubs($Itemid_c, $sb_board_table, $option, $my->id, $user->id, _UE_UPDATE);
	break;

	case "sbForumViewSettings":
	sbForumViewSettings($Itemid_c, $option, $my->id, $user->id, _UE_UPDATE);
	break;

	case "sbForumSaveSettings":
	sbForumSaveSettings($Itemid_c, $option, $my->id, $user->id, _UE_UPDATE);
	break;

	case "sbForumUnsubscribe":
	sbForumUnsubscribe($Itemid_c, $option, $my->id,$sb_thread, _UE_UPDATE);
	break;

	case "sbForumModerator":
	sbForumModerator($Itemid_c, $option, $my->id, $user->id, _UE_UPDATE);
	break;

	default:
	sbForumPosts($Itemid_c, $sb_board_table, $option, $my->id, $user->id, _UE_UPDATE);
	break;
}

function sbForumViewSettings($Itemid_c, $option, $user, $submitvalue)
{
	global $database,$my,$user;

	$SB_Forum_Settings = '<table width="100%">';

	$database->setQuery("SELECT `sbviewtype` FROM #__cbe");
	if (!$database->query())
	{
		$SB_Forum_Settings .= 'sb-1 sb setting fields not installed';//give error code
	}
	else
	{
		$query = "SELECT sbviewtype,
					 	 sbordering,
					 	 sbsignature
			  FROM #__cbe 
			  WHERE user_id=$my->id";
		$database->setQuery($query);
		$sb_settings=$database->loadObjectList();

		//SB Forum Preferences
		$SB_Forum_Settings .= "<tr><td colspan=\"2\" class=\"sectiontableheader\">"._UE_SB_FORUM_SETTINGS_HEADER."</td></tr>";

		foreach($sb_settings as $sb_setting)
		{
			$current_view_type = getLangEnDefinition($sb_setting->sbviewtype);
			$current_ordering = getLangEnDefinition($sb_setting->sbordering);

			//SB forum view type
			$SB_Forum_Settings .= "<tr><td><form action=\"index.php?option=com_cbe".$Itemid_c."&func=sbForumSaveSettings\" method=\"post\" name=\"sbforum\"></td></tr>\n";
			$SB_Forum_Settings .= '<tr><td>'._UE_SB_FORUM_SETTINGS_VIEW_TYPE.'</td><td><select name="sbviewtype" class="inputbox" size="1" mosReq="0" mosLabel="Preferred viewtype">';
			$SB_Forum_Settings .= "<option value=\"$sb_setting->sbviewtype\">$current_view_type</option>";
			$SB_Forum_Settings .= '<option value="_UE_SB_VIEWTYPE_FLAT">'._UE_SB_VIEWTYPE_FLAT.'</option>';
			$SB_Forum_Settings .= '<option value="_UE_SB_VIEWTYPE_THREADED">'._UE_SB_VIEWTYPE_THREADED.'</option>';
			$SB_Forum_Settings .= '</select></td></tr>';

			//SB forum prefered post order
			$SB_Forum_Settings .= '<tr><td>'._UE_SB_FORUM_SETTINGS_ORDERING.'</td><td><select name="sbordering" class="inputbox" size="1" mosReq="0" mosLabel="Preferred message ordering">';
			$SB_Forum_Settings .= "<option value=\"$sb_setting->sbordering\">$current_ordering</option>";
			$SB_Forum_Settings .= '<option value="_UE_SB_ORDERING_OLDEST">'._UE_SB_ORDERING_OLDEST.'</option>';
			$SB_Forum_Settings .= '<option value="_UE_SB_ORDERING_LATEST">'._UE_SB_ORDERING_LATEST.'</option>';
			$SB_Forum_Settings .= '</select></td></tr>';

			//SB forum signature
			$SB_Forum_Settings .= "<tr><td>"._UE_SB_FORUM_SETTINGS_SIGNATURE."</td><td><textarea class=\"inputbox\"  mosReq=\"0\"  maxlength=\"300\" rows=\"2\" cols=\"35\" mosLabel=\"Signature\" name=\"sbsignature\">$sb_setting->sbsignature</textarea></td></tr>";

			//submit buton
			$SB_Forum_Settings .= "<tr><td><input type=\"hidden\" name=\"userid\" value=\"$submitvalue\" /></td></tr>\n";
			$SB_Forum_Settings .= "<tr><td><input type=\"submit\" name=\"submit\" class=\"button\" value=\""._UE_SB_FORUM_SETTINGS_SAVE."\" onclick=\"return confirm('"._UE_SB_FORUM_SETTINGS_CHANGE."')\"></td></tr>\n";
			$SB_Forum_Settings .= "</form>\n";

			//show back link
			$SB_Forum_Settings .= "<tr><td>&nbsp;</td></tr><tr><td><a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$my->id&func=sbForumPosts&index="._UE_SB_FORUM_TAB_LABEL."\">"._UE_SB_FORUM_SETTINGS_BACK."</a></td></tr>";

		}
	}
	$SB_Forum_Settings .= '</table>';

	echo $SB_Forum_Settings;
}

function sbForumSaveSettings($Itemid_c, $option, $user, $submitvalue)
{
	global $database,$my,$user,$sbviewtype,$sbordering,$sbsignature,$_POST,$_REQUEST;

	$query = "UPDATE #__cbe SET sbviewtype='".$sbviewtype."',sbordering='".$sbordering."',sbsignature='".$sbsignature."' WHERE user_id='".$submitvalue."'";
	$database->setQuery( $query );

	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	mosRedirect ("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$my->id&func=sbForumViewSettings&index="._UE_SB_FORUM_TAB_LABEL);
}

function sbForumModerator($Itemid_c, $option, $uid, $submitvalue)
{
	global $database,$my,$user;

	$is_admin = (strtolower($my->usertype) == 'administrator' || strtolower($my->usertype) == 'super administrator' );

	//SB Moderator Assignment Listing
	$query = "SELECT #__sb_moderation.catid,
					 #__sb_categories.name 
			  FROM #__sb_moderation 
			  LEFT JOIN #__sb_categories 
			  ON #__sb_categories.id=#__sb_moderation.catid 
			  WHERE #__sb_moderation.userid=$my->id";
	$database->setQuery($query);
	$modslist=$database->loadObjectList();
	$count_modslist=count($modslist);

	$SB_Forum_Moderator .= "<table width=\"100%\"><tr><td colspan=\"2\" class=\"sectiontableheader\">"._UE_SB_FORUM_MODERATOR_HEADER."</td></tr>";

	if (!$is_admin)
	{
		$mod_number=1;//start count at 1

		if($count_modslist >0)
		{
			foreach($modslist as $mods)
			{
				$SB_Forum_Moderator .= '<tr><td>'.$mod_number.': '.$mods->name.'</td></tr>';
				$mod_number++;
			}
		}
		else
		{
			$SB_Forum_Moderator .= "<tr><td>"._UE_SB_FORUM_USER_MODERATOR_NONE."</td></tr>";
		}
	}
	else
	{
		$SB_Forum_Moderator .= "<tr><td>"._UE_SB_FORUM_USER_MODERATOR_ADMIN."</td></tr>";
	}

	//show back link
	$SB_Forum_Moderator .= "<tr><td>&nbsp;</td></tr><tr><td><a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$my->id&func=sbForumPosts&index="._UE_SB_FORUM_TAB_LABEL."\">"._UE_SB_THREAD_UNSUBSCRIBE_BACK."</a></td></tr>";

	$SB_Forum_Moderator .= '<tr><td>&nbsp;</td></tr></table>';

	echo $SB_Forum_Moderator;
}

function sbForumUnsubscribe($Itemid_c, $option, $user, $submitvalue)
{
	global $database,$my,$user;


	$database->setQuery("DELETE FROM #__sb_subscriptions
						 WHERE userid=$my->id 
						 AND thread=$submitvalue");
	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	mosRedirect ("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$my->id&func=sbForumViewSubs&index="._UE_SB_FORUM_TAB_LABEL);
}

function writePagesLinksSBforum($limitstart_sb_forum, $limit, $total,$ue_base_url) {

	$pages_in_list = 10;

	$displayed_pages = $pages_in_list;
	$total_pages = ceil( $total / $limit );
	$this_page = ceil( ($limitstart_sb_forum+1) / $limit );
	$start_loop = (floor(($this_page-1)/$displayed_pages))*$displayed_pages+1;
	if ($start_loop + $displayed_pages - 1 < $total_pages) {
		$stop_loop = $start_loop + $displayed_pages - 1;
	} else {
		$stop_loop = $total_pages;
	}

	if ($this_page > 1) {
		$page = ($this_page - 2) * $limit;
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_sb_forum=0\" title=\"" . _UE_FIRST_PAGE . "\">&lt;&lt; " . _UE_FIRST_PAGE . "</a>";
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_sb_forum=$page\" title=\"" . _UE_PREV_PAGE . "\">&lt; " . _UE_PREV_PAGE . "</a>";
	} else {
		echo '<span class="pagenav">&lt;&lt; '. _UE_FIRST_PAGE .'</span> ';
		echo '<span class="pagenav">&lt; '. _UE_PREV_PAGE .'</span> ';
	}

	for ($i=$start_loop; $i <= $stop_loop; $i++) {
		$page = ($i - 1) * $limit;
		if ($i == $this_page) {
			echo "\n <span class=\"pagenav\">$i</span> ";
		} else {
			echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_sb_forum=$page\"><strong>$i</strong></a>";
		}
	}

	if ($this_page < $total_pages) {
		$page = $this_page * $limit;
		$end_page = ($total_pages-1) * $limit;
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_sb_forum=$page\" title=\"" . _UE_NEXT_PAGE . "\">" . _UE_NEXT_PAGE . " &gt;</a>";
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_sb_forum=$end_page\" title=\"" . _UE_END_PAGE . "\">" . _UE_END_PAGE . " &gt;&gt;</a>";
	} else {
		echo '<span class="pagenav">'. _UE_NEXT_PAGE .' &gt;</span> ';
		echo '<span class="pagenav">'. _UE_END_PAGE .' &gt;&gt;</span>';
	}
}

//Main Display Function
function sbForumPosts($Itemid_c, $sb_board_table, $option, $uid, $submitvalue)
{
	global $database,$my,$user,$prof,$limitstart_sb_forum,$enhanced_Config,$mosConfig_live_site,$acl;

	$ue_base_url = "index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$submitvalue&func=sbForumPosts&index="._UE_SB_FORUM_TAB_LABEL."";	// Base URL string

	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">";

	$database->setQuery("select id from #__menu where link='index.php?option=com_".$sb_board_table."'");
	$Itemid_board=$database->loadResult();

	//show user subscriptions link if user has subscriptions
	$query = "SELECT thread
			  FROM #__sb_subscriptions 
			  WHERE userid=$my->id";
	$database->setQuery($query);
	$subscriptions=$database->loadObjectList();
	$count_subscriptions=count($subscriptions);

	$query = "SELECT #__sb_moderation.catid,
					 #__sb_categories.name 
			  FROM #__sb_moderation 
			  LEFT JOIN #__sb_categories 
			  ON #__sb_categories.id=#__sb_moderation.catid 
			  WHERE #__sb_moderation.userid=$my->id";
	$database->setQuery($query);
	$modslist=$database->loadObjectList();
	$count_modslist=count($modslist);

	// echo '<tr>';

	if($my->id == $submitvalue)
	{
		echo "<tr><td colspan=\"4\"><a href =\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$submitvalue&func=sbForumViewSettings&index="._UE_SB_FORUM_TAB_LABEL."\">"._UE_SB_FORUM_TAB_VIEW_SETTINGS."</a></td></tr>";
	}
	if($count_subscriptions >0 && $my->id == $submitvalue)
	{
		echo "<tr><td colspan=\"4\"><a href =\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$submitvalue&func=sbForumViewSubs&index="._UE_SB_FORUM_TAB_LABEL."\">"._UE_SB_FORUM_TAB_VIEW_SUBSCRIPTIONS."</a></td></tr>";
	}

	if($count_modslist >0 && $my->id == $submitvalue)
	{
		echo "<tr><td colspan=\"4\"><a href =\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$submitvalue&func=sbForumModerator&index="._UE_SB_FORUM_TAB_LABEL."\">"._UE_SB_FORUM_TAB_VIEW_MODERATION."</a></td></tr>";
	}

	echo '<tr><td colspan="4"><hr/></td></tr>';
	//Count for page links

	$query = "SELECT count(subject)
			  FROM #__sb_messages
			  WHERE userid='".$submitvalue."'";

	if(!$database->setQuery($query))
	print $database->getErrorMsg();

	$total = $database->loadResult();


	if (empty($limitstart_sb_forum)) {
		(isset($_GET["limitstart_sb_forum"])) ? $limitstart_sb_forum  = mosGetParam ( $_GET, 'limitstart_sb_forum' , '' ) : $limitstart_sb_forum = 0 ;
	} else {
		$limitstart_sb_forum = intval($limitstart_sb_forum);
	}

	$limit = $enhanced_Config['sb_forum_posts_per_page']; //count starts at zero. 5 will show 4 entries.

	if ($limit > $total)
	{
		$limitstart_sb_forum = 0;
	}

	if ($enhanced_Config['sb_forum_chkgid'] == '1') {
		$my_gid = userGID($my->id);
		$check_gids = getBelowGids($my_gid, 0);
		$check_gids[] = "0";
		$check_gids[] = $my_gid;
		if (is_array( $check_gids ) && count( $check_gids ) > 0) {
			$where = "(b.pub_access IN (". implode( ',', $check_gids ) . "))";
		}
	}

	$query  = "SELECT a. * , b.id as category, b.name as catname, c.hits AS 'threadhits'";
	$query .= "\n FROM #__sb_messages AS a, ";
	$query .= "\n #__sb_categories AS b, #__sb_messages AS c";
	$query .= "\n WHERE a.catid = b.id";
	$query .= "\n AND a.thread = c.id";
	$query .= "\n AND a.hold = 0 AND b.published = 1";
	$query .= "\n AND a.userid=".$submitvalue."";
	if ($enhanced_Config['sb_forum_chkgid'] == '1') {
		$query .= "\n AND ".$where;
	}
	$query .= "\n ORDER  BY a.time DESC";
	$query .= " LIMIT $limitstart_sb_forum, $limit";
	$database->setQuery( $query );
	$items = $database->loadObjectList();
	if(count($items) >0)
	{

		$sb_forum = "<tr><td colspan=\"4\" class=\"sectiontableheader\">"._UE_SB_FORUM_TAB_HEADER."</td></tr>";
		$sb_forum .= "<tr class=\"sectiontableheader\">";
		$sb_forum .= "<td>"._UE_SB_FORUM_DATE."</td>";
		$sb_forum .= "<td>"._UE_SB_FORUM_SUBJECT."</td>";
		$sb_forum .= "<td>"._UE_SB_FORUM_CATEGORY."</td>";
		$sb_forum .= "<td>"._UE_SB_FORUM_HITS."</td>";
		$sb_forum .= "</tr>";

		$i=1;
		foreach($items AS $item)
		{
			$i= ($i==1) ? 2 : 1;

			if(!ISSET($item->created)) $item->created="";

			$formatedDate=mosFormatDate($item->created);

			$sbURL="index.php?option=com_".$sb_board_table."&amp;Itemid=".$Itemid_board."&amp;func=view&amp;catid=".$item->catid."&amp;id=".$item->id."#".$item->id;

			$sb_forum .= "<tr class=\"sectiontableentry$i\"><td>".getFieldValue("date",date("Y-n-j, H:m:s",$item->time))."</td><td><a href=\"".$sbURL."\">".$item->subject."</a></td><td>".$item->catname."</td><td>".$item->threadhits."</td></tr>\n";

		}
	}
	else
	{
		$sb_forum .= "<br />"._UE_SB_FORUM_NO_POSTS;
	}

	echo $sb_forum;

	//Write page links
	if(count($items) > $limit)
	{
 		echo "<tr><td colspan=\"4\">";
 		echo writePagesLinksSBforum($limitstart_sb_forum, $limit, $total, $ue_base_url);
		echo "</td></tr>";
	} else {
		echo '<tr><td colspan="4">&nbsp;</td></tr><tr><td colspan="4"><hr/>';
		echo writePagesLinksSBforum($limitstart_sb_forum, $limit, $total, $ue_base_url);
		echo "\n </td></tr>";
	}
	echo " \n </table>\n";
}

function sbForumViewSubs($Itemid_c, $sb_board_table, $option, $uid, $submitvalue)
{
	global $database,$my,$user,$enhanced_Config,$mosConfig_live_site;

	$database->setQuery("select id from #__menu where link='index.php?option=com_".$sb_board_table."'");
	$Itemid_board=$database->loadResult();

	$query = "SELECT thread
			  FROM #__sb_subscriptions 
			  WHERE userid=$my->id";
	$database->setQuery($query);
	$subscriptions=$database->loadObjectList();
	$count_subscriptions=count($subscriptions);

	echo '<table width="100%">';

	$SB_Forum_View_Subs = "<tr><td colspan=\"2\" class=\"sectiontableheader\">"._UE_SB_FORUM_SUBSCRIPTIONS_HEADER."</td></tr>";

	if($count_subscriptions >0)
	{
		$post_number=1;//start count at 1

		foreach ($subscriptions as $subs)
		{
			$database->setQuery("SELECT *
								 FROM #__sb_messages 
								 WHERE id=$subs->thread");
			$post_subject=$database->loadObjectList();

			foreach($post_subject as $subject)
			{
				$SB_Forum_View_Subs .= '<tr>';
				$SB_Forum_View_Subs .= '<td>'.$post_number.': <a href="index.php?option=com_'.$sb_board_table.'&amp;Itemid='.$Itemid_board.'&amp;func=view&amp;catid='.$subject->catid.'&amp;id='.$subject->id.'">'.$subject->subject.'</a> - ' ._UE_SB_THREAD_BY. ' ' .$subject->name;
				$SB_Forum_View_Subs .= "<td><a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$submitvalue&func=sbForumUnsubscribe&sb_thread=$subs->thread\">"._UE_SB_THREAD_UNSUBSCRIBE." </a>";
				$SB_Forum_View_Subs .= '</tr>';
				$post_number++;
			}
		}
	}

	else
	{
		$$SB_Forum_View_Subs .= '<tr><td>'._UE_SB_NO_SUBSCRIPTIONS.'</td></tr>';
	}

	//show back link
	$SB_Forum_View_Subs .= "<tr><td>&nbsp;</td></tr><tr><td><a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$my->id&func=sbForumPosts&index="._UE_SB_FORUM_TAB_LABEL."\">"._UE_SB_THREAD_UNSUBSCRIBE_BACK."</a></td></tr>";

	echo $SB_Forum_View_Subs;
	echo '</table>';
}
?>