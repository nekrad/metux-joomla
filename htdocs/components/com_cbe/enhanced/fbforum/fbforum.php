<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

//********************************************
// MamboMe FB Forum Tab                      *
// Copyright (c) 2005 Jeffrey Randall        *
// http://mambome.com                        *
// Released under the GNU/GPL License        *
// Version 1.0                               *
// File date: 24-05-2005                     *
// Change date: 08-11-2008                   *
// Changed for: Joomla CBE 1.5               *
//********************************************

class CBE_fbforum extends CBETabHandler {
	var $params;
	function __construct($parent) {
		$this->parent = $parent;
		$this->params = $this->parent->getParams();
	}
	
	function display() {
		global $user,$option;

		if (file_exists('components/com_cbe/enhanced/fb_forum/language/'.$mosConfig_lang.'.php'))
			include_once('components/com_cbe/enhanced/fb_forum/language/'.$mosConfig_lang.'.php');
		else
			include_once('components/com_cbe/enhanced/fb_forum/language/english.php');

		include_once('administrator/components/com_cbe/enhanced_admin/enhanced_config.php');

		$prof	= JRequest::getVar('prof', '');
		$func	= JRequest::getVar('func', 'fbForumPosts');
		$fb_thread	= JRequest::getVar('fb_thread', '');
		$database = &JFactory::getDBO();
		$my = &JFactory::getUser();

		if ($GLOBALS['Itemid_com']!='')
			$Itemid_c = $GLOBALS['Itemid_com'];
		else
			$Itemid_c = '';

		$query_fireb = "SELECT count(link) FROM #__components WHERE link LIKE '%com_fireboard%'";
			$database->setQuery($query_fireb);
			$fire_res = $database->loadResult();
			if ($fire_res) {
				$fb_board_table = "fireboard";
				$forum_pre = "fb";
			}


		switch ($func) {
			case "fbForumViewSubs":
			$this->fbForumViewSubs($Itemid_c, $fb_board_table, $option, $my->id, $user->id, _UE_UPDATE);
			break;

			case "fbForumViewSettings":
			$this->fbForumViewSettings($Itemid_c, $option, $my->id, $user->id, _UE_UPDATE);
			break;

			case "fbForumSaveSettings":
			$this->fbForumSaveSettings($Itemid_c, $option, $my->id, $user->id, _UE_UPDATE);
			break;

			case "fbForumUnsubscribe":
			$this->fbForumUnsubscribe($Itemid_c, $option, $my->id,$fb_thread, _UE_UPDATE);
			break;

			case "fbForumModerator":
			$this->fbForumModerator($Itemid_c, $option, $my->id, $user->id, _UE_UPDATE);
			break;

			default:
			$this->fbForumPosts($Itemid_c, $fb_board_table, $option, $my->id, $user->id, _UE_UPDATE);
			break;
		}

	}

	function fbForumViewSettings($Itemid_c, $option, $user, $submitvalue) {
		global $user;

		$database = &JFactory::getDBO();
		$my = &JFactory::getUser();

		$FB_Forum_Settings = '<table width="100%">';

		$database->setQuery("SELECT `fbviewtype` FROM #__cbe");
		if (!$database->query())
			$FB_Forum_Settings .= 'fb-1 fb setting fields not installed';//give error code
		else {
			$query = "SELECT fbviewtype,
							fbordering,
							fbsignature
				FROM #__cbe 
				WHERE user_id=$my->id";
			$database->setQuery($query);
			$fb_settings=$database->loadObjectList();

			//FB Forum Preferences
			$FB_Forum_Settings .= "<tr><td colspan=\"2\" class=\"sectiontableheader\">"._UE_FB_FORUM_SETTINGS_HEADER."</td></tr>";

			foreach($fb_settings as $fb_setting) {
				$current_view_type = getLangEnDefinition($fb_setting->fbviewtype);
				$current_ordering = getLangEnDefinition($fb_setting->fbordering);

				//FB forum view type
				$FB_Forum_Settings .= "<tr><td><form action=\"index.php?option=com_cbe".$Itemid_c."&func=fbForumSaveSettings\" method=\"post\" name=\"fbforum\"></td></tr>\n";
				$FB_Forum_Settings .= '<tr><td>'._UE_FB_FORUM_SETTINGS_VIEW_TYPE.'</td><td><select name="fbviewtype" class="inputbox" size="1" mosReq="0" mosLabel="Preferred viewtype">';
				$FB_Forum_Settings .= "<option value=\"$fb_setting->fbviewtype\">$current_view_type</option>";
				$FB_Forum_Settings .= '<option value="_UE_FB_VIEWTYPE_FLAT">'._UE_FB_VIEWTYPE_FLAT.'</option>';
				$FB_Forum_Settings .= '<option value="_UE_FB_VIEWTYPE_THREADED">'._UE_FB_VIEWTYPE_THREADED.'</option>';
				$FB_Forum_Settings .= '</select></td></tr>';

				//FB forum prefered post order
				$FB_Forum_Settings .= '<tr><td>'._UE_FB_FORUM_SETTINGS_ORDERING.'</td><td><select name="fbordering" class="inputbox" size="1" mosReq="0" mosLabel="Preferred message ordering">';
				$FB_Forum_Settings .= "<option value=\"$fb_setting->fbordering\">$current_ordering</option>";
				$FB_Forum_Settings .= '<option value="_UE_FB_ORDERING_OLDEST">'._UE_FB_ORDERING_OLDEST.'</option>';
				$FB_Forum_Settings .= '<option value="_UE_FB_ORDERING_LATEST">'._UE_FB_ORDERING_LATEST.'</option>';
				$FB_Forum_Settings .= '</select></td></tr>';

				//FB forum signature
				$FB_Forum_Settings .= "<tr><td>"._UE_FB_FORUM_SETTINGS_SIGNATURE."</td><td><textarea class=\"inputbox\"  mosReq=\"0\"  maxlength=\"300\" rows=\"2\" cols=\"35\" mosLabel=\"Signature\" name=\"fbsignature\">$fb_setting->fbsignature</textarea></td></tr>";

				//submit buton
				$FB_Forum_Settings .= "<tr><td><input type=\"hidden\" name=\"userid\" value=\"$submitvalue\" /></td></tr>\n";
				$FB_Forum_Settings .= "<tr><td><input type=\"submit\" name=\"submit\" class=\"button\" value=\""._UE_FB_FORUM_SETTINGS_SAVE."\" onclick=\"return confirm('"._UE_FB_FORUM_SETTINGS_CHANGE."')\"></td></tr>\n";
				$FB_Forum_Settings .= "</form>\n";

				//show back link
				$FB_Forum_Settings .= "<tr><td>&nbsp;</td></tr><tr><td><a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$my->id&func=fbForumPosts&index="._UE_FB_TABTITLE."\">"._UE_FB_FORUM_SETTINGS_BACK."</a></td></tr>";

			}
		}
		$FB_Forum_Settings .= '</table>';

		echo $FB_Forum_Settings;
	}

	function fbForumSaveSettings($Itemid_c, $option, $user, $submitvalue) {
		global $my,$user,$fbviewtype,$fbordering,$fbsignature,$_POST,$_REQUEST, $mainframe;
		$my = &JFactory::getUser();
		$fbviewtype=JRequest::getVar('fbviewtype','');
		$fbordering=JRequest::getVar('fbordering','');
		$fbsignature=JRequest::getVar('fbsignature','');

		$database = &JFactory::getDBO();
		$query = "UPDATE #__cbe SET fbviewtype='".$fbviewtype."',fbordering='".$fbordering."',fbsignature='".$fbsignature."' WHERE user_id='".$submitvalue."'";
		$database->setQuery( $query );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$mainframe->redirect("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$my->id&func=fbForumViewSettings&index="._UE_FB_TABTITLE);
	}

	function fbForumModerator($Itemid_c, $option, $uid, $submitvalue) {
		global $my,$user;

		$database = &JFactory::getDBO();
		$my = &JFactory::getUser();

		$is_admin = (strtolower($my->usertype) == 'administrator' || strtolower($my->usertype) == 'super administrator' );

		//FB Moderator Assignment Listing
		$query = "SELECT #__fb_moderation.catid,
						#__fb_categories.name 
				FROM #__fb_moderation 
				LEFT JOIN #__fb_categories 
				ON #__fb_categories.id=#__fb_moderation.catid 
				WHERE #__fb_moderation.userid=$my->id";
		$database->setQuery($query);
		$modslist=$database->loadObjectList();
		$count_modslist=count($modslist);

		$FB_Forum_Moderator .= "<table width=\"100%\"><tr><td colspan=\"2\" class=\"sectiontableheader\">"._UE_FB_FORUM_MODERATOR_HEADER."</td></tr>";

		if (!$is_admin)
		{
			$mod_number=1;//start count at 1

			if($count_modslist >0)
			{
				foreach($modslist as $mods)
				{
					$FB_Forum_Moderator .= '<tr><td>'.$mod_number.': '.$mods->name.'</td></tr>';
					$mod_number++;
				}
			}
			else
			{
				$FB_Forum_Moderator .= "<tr><td>"._UE_FB_FORUM_USER_MODERATOR_NONE."</td></tr>";
			}
		}
		else
		{
			$FB_Forum_Moderator .= "<tr><td>"._UE_FB_FORUM_USER_MODERATOR_ADMIN."</td></tr>";
		}

		//show back link
		$FB_Forum_Moderator .= "<tr><td>&nbsp;</td></tr><tr><td><a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$my->id&func=fbForumPosts&index="._UE_FB_TABTITLE."\">"._UE_FB_THREAD_UNSUBSCRIBE_BACK."</a></td></tr>";

		$FB_Forum_Moderator .= '<tr><td>&nbsp;</td></tr></table>';

		echo $FB_Forum_Moderator;
	}

	function fbForumUnsubscribe($Itemid_c, $option, $user, $submitvalue) {
		global $user, $mainframe;
		$database = &JFactory::getDBO();
		$my = &JFactory::getUser();


		$database->setQuery("DELETE FROM #__fb_subscriptions
							WHERE userid=$my->id 
							AND thread=$submitvalue");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}

		$mainframe-redirect("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$my->id&func=fbForumViewSubs&index="._UE_FB_TABTITLE);
	}

	function writePagesLinksFBforum($limitstart_fb_forum, $limit, $total,$ue_base_url) {

		$pages_in_list = 10;

		$displayed_pages = $pages_in_list;
		$total_pages = ceil( $total / $limit );
		$this_page = ceil( ($limitstart_fb_forum+1) / $limit );
		$start_loop = (floor(($this_page-1)/$displayed_pages))*$displayed_pages+1;
		if ($start_loop + $displayed_pages - 1 < $total_pages) {
			$stop_loop = $start_loop + $displayed_pages - 1;
		} else {
			$stop_loop = $total_pages;
		}

		if ($this_page > 1) {
			$page = ($this_page - 2) * $limit;
			echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_fb_forum=0\" title=\"" . _UE_FIRST_PAGE . "\">&lt;&lt; " . _UE_FIRST_PAGE . "</a>";
			echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_fb_forum=$page\" title=\"" . _UE_PREV_PAGE . "\">&lt; " . _UE_PREV_PAGE . "</a>";
		} else {
			echo '<span class="pagenav">&lt;&lt; '. _UE_FIRST_PAGE .'</span> ';
			echo '<span class="pagenav">&lt; '. _UE_PREV_PAGE .'</span> ';
		}

		for ($i=$start_loop; $i <= $stop_loop; $i++) {
			$page = ($i - 1) * $limit;
			if ($i == $this_page) {
				echo "\n <span class=\"pagenav\">$i</span> ";
			} else {
				echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_fb_forum=$page\"><strong>$i</strong></a>";
			}
		}

		if ($this_page < $total_pages) {
			$page = $this_page * $limit;
			$end_page = ($total_pages-1) * $limit;
			echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_fb_forum=$page\" title=\"" . _UE_NEXT_PAGE . "\">" . _UE_NEXT_PAGE . " &gt;</a>";
			echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_fb_forum=$end_page\" title=\"" . _UE_END_PAGE . "\">" . _UE_END_PAGE . " &gt;&gt;</a>";
		} else {
			echo '<span class="pagenav">'. _UE_NEXT_PAGE .' &gt;</span> ';
			echo '<span class="pagenav">'. _UE_END_PAGE .' &gt;&gt;</span>';
		}
	}

	//Main Display Function
	function fbForumPosts($Itemid_c, $fb_board_table, $option, $uid, $submitvalue) {
		global $user,$prof,$limitstart_fb_forum,$enhanced_Config,$mosConfig_live_site,$acl;
		$database = &JFactory::getDBO();
		$my = &JFactory::getUser();

		$ue_base_url = "index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$submitvalue&func=fbForumPosts&index="._UE_FB_TABTITLE."";	// Base URL string

		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">";

		$database->setQuery("select id from #__menu where link='index.php?option=com_".$fb_board_table."'");
		$Itemid_board=$database->loadResult();

		//show user subscriptions link if user has subscriptions
		$query = "SELECT thread
				FROM #__fb_subscriptions 
				WHERE userid=$my->id";
		$database->setQuery($query);
		$subscriptions=$database->loadObjectList();
		$count_subscriptions=count($subscriptions);

		$query = "SELECT #__fb_moderation.catid,
						#__fb_categories.name 
				FROM #__fb_moderation 
				LEFT JOIN #__fb_categories 
				ON #__fb_categories.id=#__fb_moderation.catid 
				WHERE #__fb_moderation.userid=$my->id";
		$database->setQuery($query);
		$modslist=$database->loadObjectList();
		$count_modslist=count($modslist);

		// echo '<tr>';

		if($my->id == $submitvalue)
		{
			echo "<tr><td colspan=\"4\"><a href =\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$submitvalue&func=fbForumViewSettings&index="._UE_FB_TABTITLE."\">"._UE_FB_FORUM_TAB_VIEW_SETTINGS."</a></td></tr>";
		}
		if($count_subscriptions >0 && $my->id == $submitvalue)
		{
			echo "<tr><td colspan=\"4\"><a href =\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$submitvalue&func=fbForumViewSubs&index="._UE_FB_TABTITLE."\">"._UE_FB_FORUM_TAB_VIEW_SUBSCRIPTIONS."</a></td></tr>";
		}

		if($count_modslist >0 && $my->id == $submitvalue)
		{
			echo "<tr><td colspan=\"4\"><a href =\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$submitvalue&func=fbForumModerator&index="._UE_FB_TABTITLE."\">"._UE_FB_FORUM_TAB_VIEW_MODERATION."</a></td></tr>";
		}

		echo '<tr><td colspan="4"><hr/></td></tr>';
		//Count for page links

		$query = "SELECT count(subject)
				FROM #__fb_messages
				WHERE userid='".$submitvalue."'";

		if(!$database->setQuery($query))
		print $database->getErrorMsg();

		$total = $database->loadResult();


		if (empty($limitstart_fb_forum)) {
			(isset($_GET["limitstart_fb_forum"])) ? $limitstart_fb_forum  = JRequest::getVar ('limitstart_fb_forum' , '' ) : $limitstart_fb_forum = 0 ;
		} else {
			$limitstart_fb_forum = intval($limitstart_fb_forum);
		}

		$limit = $this->params['fbforum_sb_forum_posts_per_page']; //count starts at zero. 5 will show 4 entries.

		if ($limit > $total)
		{
			$limitstart_fb_forum = 0;
		}

		if ($this->params['fbforum_sb_forum_chkgid'] == '1') {
			$my_gid = userGID($my->id);
			$check_gids = getBelowGids($my_gid, 0);
			$check_gids[] = "0";
			$check_gids[] = $my_gid;
			if (is_array( $check_gids ) && count( $check_gids ) > 0) {
				$where = "(b.pub_access IN (". implode( ',', $check_gids ) . "))";
			}
		}

		$query  = "SELECT a. * , b.id as category, b.name as catname, c.hits AS 'threadhits'";
		$query .= "\n FROM #__fb_messages AS a, ";
		$query .= "\n #__fb_categories AS b, #__fb_messages AS c";
		$query .= "\n WHERE a.catid = b.id";
		$query .= "\n AND a.thread = c.id";
		$query .= "\n AND a.hold = 0 AND b.published = 1";
		$query .= "\n AND a.userid=".$submitvalue."";
		if ($this->params['fbforum_sb_forum_chkgid'] == '1') {
			$query .= "\n AND ".$where;
		}
		$query .= "\n ORDER  BY a.time DESC";
		$query .= " LIMIT $limitstart_fb_forum, $limit";
		$database->setQuery( $query );
		$items = $database->loadObjectList();
		if(count($items) >0)
		{

			$fb_forum = "<tr><td colspan=\"4\" class=\"sectiontableheader\">"._UE_FB_FORUM_TAB_HEADER."</td></tr>";
			$fb_forum .= "<tr class=\"sectiontableheader\">";
			$fb_forum .= "<td>"._UE_FB_FORUM_DATE."</td>";
			$fb_forum .= "<td>"._UE_FB_FORUM_SUBJECT."</td>";
			$fb_forum .= "<td>"._UE_FB_FORUM_CATEGORY."</td>";
			$fb_forum .= "<td>"._UE_FB_FORUM_HITS."</td>";
			$fb_forum .= "</tr>";

			$i=1;
			foreach($items AS $item)
			{
				$i= ($i==1) ? 2 : 1;

				if(!ISSET($item->created)) $item->created="";

				$formatedDate=mosFormatDate($item->created);

				$fbURL="index.php?option=com_".$fb_board_table."&amp;Itemid=".$Itemid_board."&amp;func=view&amp;catid=".$item->catid."&amp;id=".$item->id."#".$item->id;

				$fb_forum .= "<tr class=\"sectiontableentry$i\"><td>".getFieldValue("date",date("Y-n-j, H:m:s",$item->time))."</td><td><a href=\"".$fbURL."\">".$item->subject."</a></td><td>".$item->catname."</td><td>".$item->threadhits."</td></tr>\n";

			}
		}
		else
		{
			$fb_forum .= "<br />"._UE_FB_FORUM_NO_POSTS;
		}

		echo $fb_forum;

		//Write page links
		if(count($items) > $limit)
		{
			echo "<tr><td colspan=\"4\">";
			echo $this->writePagesLinksFBforum($limitstart_fb_forum, $limit, $total, $ue_base_url);
			echo "</td></tr>";
		} else {
			echo '<tr><td colspan="4">&nbsp;</td></tr><tr><td colspan="4"><hr/>';
			echo $this->writePagesLinksFBforum($limitstart_fb_forum, $limit, $total, $ue_base_url);
			echo "\n </td></tr>";
		}
		echo " \n </table>\n";
	}

	function fbForumViewSubs($Itemid_c, $fb_board_table, $option, $uid, $submitvalue) {
		global $user,$enhanced_Config,$mosConfig_live_site;
		$database = &JFactory::getDBO();
		$my = &JFactory::getUser();

		$database->setQuery("select id from #__menu where link='index.php?option=com_".$fb_board_table."'");
		$Itemid_board=$database->loadResult();

		$query = "SELECT thread
				FROM #__fb_subscriptions 
				WHERE userid=$my->id";
		$database->setQuery($query);
		$subscriptions=$database->loadObjectList();
		$count_subscriptions=count($subscriptions);

		echo '<table width="100%">';

		$FB_Forum_View_Subs = "<tr><td colspan=\"2\" class=\"sectiontableheader\">"._UE_FB_FORUM_SUBSCRIPTIONS_HEADER."</td></tr>";

		if($count_subscriptions >0)
		{
			$post_number=1;//start count at 1

			foreach ($subscriptions as $subs)
			{
				$database->setQuery("SELECT *
									FROM #__fb_messages 
									WHERE id=$subs->thread");
				$post_subject=$database->loadObjectList();

				foreach($post_subject as $subject)
				{
					$FB_Forum_View_Subs .= '<tr>';
					$FB_Forum_View_Subs .= '<td>'.$post_number.': <a href="index.php?option=com_'.$fb_board_table.'&amp;Itemid='.$Itemid_board.'&amp;func=view&amp;catid='.$subject->catid.'&amp;id='.$subject->id.'">'.$subject->subject.'</a> - ' ._UE_FB_THREAD_BY. ' ' .$subject->name;
					$FB_Forum_View_Subs .= "<td><a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$submitvalue&func=fbForumUnsubscribe&fb_thread=$subs->thread\">"._UE_FB_THREAD_UNSUBSCRIBE." </a>";
					$FB_Forum_View_Subs .= '</tr>';
					$post_number++;
				}
			}
		}

		else
		{
			$$FB_Forum_View_Subs .= '<tr><td>'._UE_FB_NO_SUBSCRIPTIONS.'</td></tr>';
		}

		//show back link
		$FB_Forum_View_Subs .= "<tr><td>&nbsp;</td></tr><tr><td><a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$my->id&func=fbForumPosts&index="._UE_FB_TABTITLE."\">"._UE_FB_THREAD_UNSUBSCRIBE_BACK."</a></td></tr>";

		echo $FB_Forum_View_Subs;
		echo '</table>';
	}
}
?>



