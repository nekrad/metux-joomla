<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $mosConfig_lang, $user;
include_once('components/com_cbe/enhanced/enhanced_functions.inc');

$langpath = JPATH_SITE.DS.'components'.DS.'com_cbe'.DS.'enhanced'.DS.'buddy'.DS.'language'.DS;
(file_exists($langpath.$mosConfig_lang.'.php'))? include_once($langpath.$mosConfig_lang.'.php'):include_once($langpath.'english.php');

?>
<link href="<?php echo JURI::root();?>components/com_cbe/enhanced/enhanced_css.css" rel="stylesheet" type="text/css"/>
<?php
class CBE_buddy extends CBETabHandler {
	var $params;
	function __construct($parent) {
		$this->parent = $parent;
		$this->params = $this->parent->getParams();
	}

	function display() {
		// display wird immer zuerst aufgerufen
		global $uid, $mainframe, $user;
		$func		= JRequest::getVar('func', 'buddy');
		$buddyid	= JRequest::getVar('buddyid', '');
		$my = &JFactory::getUser();

		$Itemid_c= ($GLOBALS['Itemid_com']!='')? $GLOBALS['Itemid_com']:'';
		$Item_id = $Itemid_c;

		if ($my->id == 0) {
			echo JText::_(ALERTNOTAUTH);
			return;
		}

		$mlink = '';
		$pop_win = '';
		$pop_enh = '';
		$pop_link= '';
		$mlink = JRequest::getVar('mlb', 0 );
		$pop_win = JRequest::getVar('pop', 0 );
		if ($pop_win == 1) {
			$pop_enh = '2';
			$pop_link = '&pop=1';
		}

		$sendmsg = 0;
		switch ($func) {
			case "addbuddy":
				$this->addbuddy( $Item_id, $option, $my->id, _UE_UPDATE);

				$userid="$buddyid" ;
				$link = "<a href=\"".JURI::root()."index.php?option=com_cbe".$Itemid_c."&func=request&index="._UE_BUDDY_TAB_LABEL."\">";
				$subject=_UE_BUDDY_PM_ADDED_SUBJECT;
				$message=$my->username." "._UE_BUDDY_PM_ADDED." ".$link._UE_BUDDY_PM_ADDED1."</a>";
				$sendmsg = 1;
				break; // added by Naughty Leo - March 12 2005

			case "cancelbuddy":
				$this->cancelbuddy( $Item_id, $option, $my->id, _UE_UPDATE);
				$userid="$buddyid" ;
				$subject = _UE_BUDDY_PM_CANCELED_SUBJECT;
				$message = $my->username." "._UE_BUDDY_PM_CANCELED;
				$sendmsg = 1;

				break; // added by Naughty Leo - March 12 2005

			case "deletebuddy":
				$this->deletebuddy( $Item_id, $option, $my->id, _UE_UPDATE);
				$userid="$buddyid" ;
				$subject=_UE_BUDDY_PM_DELETED_SUBJECT;
				$message= $my->username." "._UE_BUDDY_PM_DELETED;
				$sendmsg = 1;

				break; // added by Naughty Leo - March 12 2005

			case "acceptbuddy":
				$this->acceptbuddy( $Item_id, $option, $my->id, _UE_UPDATE);
				$userid="$buddyid" ;
				$subject=_UE_BUDDY_PM_ACCEPTED_SUBJECT;
				$message=$my->username." "._UE_BUDDY_PM_ACCEPTED;
				$sendmsg = 1;

				break; // added by Naughty Leo - March 12 2005

			case "rejectbuddy":
				$this->rejectbuddy( $Item_id, $option, $my->id, _UE_UPDATE);
				$userid="$buddyid" ;
				$subject=_UE_BUDDY_PM_REJECTED_SUBJECT;
				$message=$my->username." "._UE_BUDDY_PM_REJECTED;
				$sendmsg = 1;

				break; // added by Naughty Leo - March 12 2005

			default:
				if ($func != 'invite' && $func != 'request')
					$func = 'buddy';
				break;
		}

		$this->buddy_default($func, $Itemid_c);

		if ($sendmsg) {
			$whofrom = ($this->params["buddy_buddylist_sender"] == 0)? "Buddylist Bot":$my->username;
			// am ende noch eine nachricht abschicken
			sendUserPM($userid,$whofrom,$subject,$message);
			if ($mlink == 1) {
				$mainframe->redirect('index'.$pop_enh.'.php?option=com_cbe'.$Itemid_c.$pop_link.'&task=userProfile&user='.$buddyid.'&func=buddy&index='._UE_BUDDY_TAB_LABEL.'');
			} else {
				$mainframe->redirect('index'.$pop_enh.'.php?option=com_cbe'.$Itemid_c.$pop_link.'&task=userProfile&user='.$my->id.'&func=buddy&index='._UE_BUDDY_TAB_LABEL.'');
			}
		}
	}

	//buddy system functions
	function addbuddy ( $Item_id, $option, $uid, $submitvalue ) {
		global $ueConfig,$acl,$_POST,$_REQUEST, $mainframe;

		$database = &JFactory::getDBO();
		$my = &JFactory::getUser();
		$Itemid_c = $Item_id;
		
		$buddyid = JRequest::getVar('buddyid', 0);

		$query_check1 = "SELECT buddyid FROM #__cbe_buddylist WHERE buddyid='$buddyid' AND userid='$my->id'";
		$database->setQuery($query_check1);
		$b_check1 = $database->loadResult();
		
		$query_check2 = "SELECT userid FROM #__cbe_buddylist WHERE userid='$buddyid' AND buddyid='$my->id'";
		$database->setQuery($query_check2);
		$b_check2 = $database->loadResult();

		if (($b_check1 != '') || ($b_check2 != ''))
			$mainframe->redirect('index.php?option=com_cbe'.$Itemid_c.'&task=userProfile&user='.$buddyid.'&func=buddy&index='._UE_BUDDY_TAB_LABEL.'');
		
		$query = "INSERT INTO #__cbe_buddylist (userid,buddyid,status) VALUES ('$my->id', '$buddyid', 1)";
		$database->setQuery( $query );
		$database->query();

		// für die verbindungen, status auf 2, um verwechselungen zu vermeiden
		$query = "INSERT INTO #__cbe_buddylist (userid,buddyid,status) VALUES ('$buddyid', '$my->id', 2)";
		$database->setQuery( $query );
		$database->query();
	}

	function deletebuddy ( $Item_id, $option, $uid, $submitvalue ){
		global $ueConfig,$mainframe;

		$database = &JFactory::getDBO();
		$my = &JFactory::getUser();

		$buddyid = JRequest::getVar('buddyid', 0);

		//first case
		$query = "DELETE FROM #__cbe_buddylist WHERE userid='$buddyid' AND buddyid='$my->id' AND status=0 AND buddy=1";
		$database->setQuery( $query );
		$database->Query();

		//second case
		$query = "DELETE FROM #__cbe_buddylist WHERE userid='$my->id' AND buddyid='$buddyid' AND status=0 AND buddy=1";
		$database->setQuery( $query );
		$database->Query();
	}

	function cancelbuddy ( $Item_id, $option, $uid, $submitvalue ) {
		global $ueConfig,$buddyid,$acl, $mainframe;

		$Itemid_c = $Item_id;
 		$buddyid = JRequest::getVar('buddyid', 0);

		$database = &JFactory::getDBO();
		$my = &JFactory::getUser();

		$query = "DELETE FROM #__cbe_buddylist WHERE userid='$my->id' AND buddyid='$buddyid' AND status=1 AND buddy=0";
		$database->setQuery( $query );
		$database->Query();

		// für die verbindungen
		$query = "DELETE FROM #__cbe_buddylist WHERE buddyid='$my->id' AND userid='$buddyid' AND status=2 AND buddy=0";
		$database->setQuery( $query );
		$database->Query();
	}

	function acceptbuddy ( $Item_id, $option, $uid, $submitvalue ) {
		$database = &JFactory::getDBO();
		$my = &JFactory::getUser();
		$buddyid = JRequest::getVar('buddyid', 0);
		
		$query = "UPDATE #__cbe_buddylist SET status=0, buddy=1 WHERE userid='$buddyid' AND buddyid='$my->id' AND buddy=0 AND status=1";
		$database->setQuery( $query );
		$database->Query();

		// für die verbindungen
		$query = "UPDATE #__cbe_buddylist SET status=0, buddy=1 WHERE buddyid='$buddyid' AND userid='$my->id' AND buddy=0 AND status=2";
		$database->setQuery( $query );
		$database->Query();

	}


	function rejectbuddy ( $Item_id, $option, $uid, $submitvalue ) {
		global $ueConfig,$buddyid,$acl,$_POST,$_REQUEST;

		$database = &JFactory::getDBO();
		$my = &JFactory::getUser();
		$buddyid = JRequest::getVar('buddyid', 0);
			
		$query = "DELETE FROM #__cbe_buddylist WHERE userid='$buddyid' AND buddyid='$my->id' AND status=1 AND buddy=0";
		$database->setQuery( $query );
		$database->Query();

		// wegen der verbindungen
		$query = "DELETE FROM #__cbe_buddylist WHERE buddyid='$buddyid' AND userid='$my->id' AND status=2 AND buddy=0";
		$database->setQuery( $query );
		$database->Query();

	}

	function getPMS() {
		global $ueConfig;
		$pm_icon = "components/com_cbe/enhanced/images/sendpm.gif";

		$pmsarray = array(
			"",
			"<a href=\"$pms_open_source_path$bud->username\">
				<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_BUDDY_TAB_PRIVATE_MESSAGE."\"></a><br/>\n",
			"<a href=\"$mypms_path$bud->username\">
				<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_BUDDY_TAB_PRIVATE_MESSAGE."\"></a><br/>\n",
			"<a href=\"$pms_os_2_path$bud->username\">
				<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_BUDDY_TAB_PRIVATE_MESSAGE."\"></a><br/>\n",
			"<a href=\"$pms_os_enh_path$bud->username\">
				<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_BUDDY_TAB_PRIVATE_MESSAGE."\"></a><br/>\n",
			"<a href=\"$pms_uddeim_path$bud->id\">
				<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_BUDDY_TAB_PRIVATE_MESSAGE."\"></a><br/>\n",
			"<a href=\"$pms_missus_path$bud->id\">
				<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_BUDDY_TAB_PRIVATE_MESSAGE."\"></a><br/>\n",
			"<a href=\"$pms_clexus_path$bud->id\">
				<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_AUTHOR_TAB_PRIVATE_MESSAGE."\"></a><br/>\n",
			"<a href=\"$pms_jim_path$bud->username\">
				<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_BUDDY_TAB_PRIVATE_MESSAGE."\"></a><br/>\n",
			"<a href=\"$pms_os_enh2_path$bud->id\">
				<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_BUDDY_TAB_PRIVATE_MESSAGE."\"></a><br/>\n"
		);
		$ind = $ueConfig['pms'];
		$ret = (in_array($ind, array_keys($pmsarray)))?$pmsarray[$ind]:false;
		return $ret;
	}

	function writePagesLinksBuddy($limitstart_buddies, $limit, $total,$ue_base_url) {

		$pages_in_list = 10;

		$displayed_pages = $pages_in_list;
		$total_pages = ceil( $total / $limit );
		$this_page = ceil( ($limitstart_buddies+1) / $limit );
		$start_loop = (floor(($this_page-1)/$displayed_pages))*$displayed_pages+1;
		if ($start_loop + $displayed_pages - 1 < $total_pages) {
			$stop_loop = $start_loop + $displayed_pages - 1;
		} else {
			$stop_loop = $total_pages;
		}

		if ($this_page > 1) {
			$page = ($this_page - 2) * $limit;
			echo "\n<a class=\"pagenav\" href=\"$ue_base_url&limitstart_buddies=0\" title=\"" . _UE_FIRST_PAGE . "\">&lt;&lt; " . _UE_FIRST_PAGE . "</a>";
			echo "\n<a class=\"pagenav\" href=\"$ue_base_url&limitstart_buddies=$page\" title=\"" . _UE_PREV_PAGE . "\">&lt; " . _UE_PREV_PAGE . "</a>";
		} else {
			echo '<span class="pagenav">&lt;&lt; '. _UE_FIRST_PAGE .'</span> ';
			echo '<span class="pagenav">&lt; '. _UE_PREV_PAGE .'</span> ';
		}

		for ($i=$start_loop; $i <= $stop_loop; $i++) {
			$page = ($i - 1) * $limit;
			if ($i == $this_page) {
				echo "\n <span class=\"pagenav\">$i</span> ";
			} else {
				echo "\n<a class=\"pagenav\" href=\"$ue_base_url&limitstart_buddies=$page\"><strong>$i</strong></a>";
			}
		}

		if ($this_page < $total_pages) {
			$page = $this_page * $limit;
			$end_page = ($total_pages-1) * $limit;
			echo "\n<a class=\"pagenav\" href=\"$ue_base_url&limitstart_buddies=$page\" title=\"" . _UE_NEXT_PAGE . "\">" . _UE_NEXT_PAGE . " &gt;</a>";
			echo "\n<a class=\"pagenav\" href=\"$ue_base_url&limitstart_buddies=$end_page\" title=\"" . _UE_END_PAGE . "\">" . _UE_END_PAGE . " &gt;&gt;</a>";
		}
		else
		{
			echo '<span class="pagenav">'. _UE_NEXT_PAGE .' &gt;</span> ';
			echo '<span class="pagenav">'. _UE_END_PAGE .' &gt;&gt;</span>';
		}
	// ende von writepageslinkabuddy
	}


	function buddy_default($func, $Itemid_c) {
		global $limitstart_buddies, $ueConfig, $user, $mosConfig_lang;

		$online_image	= "components/com_cbe/enhanced/images/online.png"; //change to icon you wish to use for online status
		$offline_image	= "components/com_cbe/enhanced/images/offline.png"; //change to icon you wish to use for offline status
		$gogb_image	= "components/com_cbe/enhanced/images/goguestb.gif";
		$path		= "index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=";
		$pm_icon	= "components/com_cbe/enhanced/images/sendpm.gif";

		$database = &JFactory::getDBO();
		$my = &JFactory::getUser();
		$ue_base_url = "index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$user->id&func=buddy&index="._UE_BUDDY_TAB_LABEL;	// $submitvalue Base URL string

	// do some needed querys on buddy
		$query1 = "SELECT buddyid
				FROM #__cbe_buddylist 
				WHERE userid='".$user->id."' 
				AND buddy=1";
		$database->setQuery($query1);
		$result = $database->loadObjectList();

		/*
		$query2 = "SELECT userid AS buddyid
				FROM #__cbe_buddylist 
				WHERE buddyid='".$user->id."' 
				AND buddy=1";
		$database->setQuery($query2);
		$result2 = $database->loadObjectList();
		
		$result = array_merge($result1, $result2);
		*/
		$total = count ($result);
		$total_bud = $total;
		
		if ($total_bud != 0) {
			$total_bud = "(".$total_bud.")";
		} else {
			$total_bud = "";
		}


		//buddy header
		echo "<table><tr><td><a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$user->id&func=buddy&index="._UE_BUDDY_TAB_LABEL."\">"._UE_BUDDY_TAB_BUDDIES.$total_bud."</a>";

		if ($my->id==$user->id) {

			$query_inv = "SELECT buddyid FROM #__cbe_buddylist WHERE userid='".$my->id."' AND status = 1";
			$database->setQuery($query_inv);
			$result_inv = $database->loadObjectList();
			$total_inv = count ($result_inv);
			if ($total_inv != 0) {
				$total_inv = "(".$total_inv.")";
			} else {
				$total_inv = "";
			}
			
			$query_req = "SELECT userid FROM #__cbe_buddylist WHERE buddyid='".$my->id."' AND status = 1";
			$database->setQuery($query_req);
			$result_req = $database->loadObjectList();
			$total_req = count ($result_req);
			if ($total_req != 0) {
				$total_req = "(".$total_req.")";
			} else {
				$total_req = "";
			}

			echo " - <a href=\"index.php?option=com_cbe".$Itemid_c."&func=invite&index="._UE_BUDDY_TAB_LABEL."\">"._UE_BUDDY_TAB_PENDING_INVITES.$total_inv."</a>";
			echo " - <a href=\"index.php?option=com_cbe".$Itemid_c."&func=request&index="._UE_BUDDY_TAB_LABEL."\">"._UE_BUDDY_TAB_PENDING_REQUESTS.$total_req."</a>";
		}
		echo '</td></tr></table>';

		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">";

		// ab hier die ganzen funktionen
		$bstring='';
		if($func=='buddy')
		{
			if ($total < 1)
				echo '<tr><td>'._UE_BUDDY_TAB_NO_BUDDIES.'</td></tr>';

		// PK edit start
			if (empty($limitstart_buddies))
				(isset($_GET["limitstart_buddies"])) ? $limitstart_buddies  = JRequest::getVar('limitstart_buddies' , '' ) : $limitstart_buddies = 0 ;
			else
				$limitstart_buddies = intval($limitstart_buddies);

			$buddy_page_limit = $this->params['buddy_buddies_per_page']; 	//count starts at zero. 5 will show 4 entries.

			if ($buddy_page_limit > $total)
				$limitstart_buddies = 0;

			if ($total > 0) {
				$buddy='';
				$bstring='';

				foreach($result as $preuser)
					$buddy[]=$preuser->buddyid;

				$passtoquery='(' . implode(',', $buddy) . ')';
				$query = "SELECT id,username FROM #__users WHERE id IN ".$passtoquery." AND block!=1 ORDER BY username ";
				$query .= " LIMIT $limitstart_buddies, $buddy_page_limit";
				$database->setQuery($query);
				$buds = $database->loadObjectList();

				$bstring .= "<tr><td colspan=\"2\">\n";

				//get buddies avatar thumbnail
				foreach($buds as $bud)
				{
					$query_avatar = "SELECT avatar, avatarapproved FROM #__cbe WHERE user_id='".$bud->id."'";
					$database->setQuery( $query_avatar );
					$pics = $database->loadObjectList();

					foreach ($pics as $pic)
					{
						$user_image=$pic->avatar;

						if(file_exists("components/com_cbe/images/".$mosConfig_lang))
							$user_image_path="components/com_cbe/images/".$mosConfig_lang."/";
						else
							$user_image_path="components/com_cbe/images/english/";

						if($pic->avatarapproved==0)
							$user_image=$user_image_path."tnpendphoto.jpg";
						elseif($pic->avatar=='' || $pic->avatar==null)
							$user_image=$user_image_path."tnnophoto.jpg";
						elseif(ereg('gallery',$pic->avatar))
							$user_image="images/cbe/".$user_image;
						else
							$user_image="images/cbe/tn".$user_image;

						$userAvatar="<img src=\"$user_image\" border=\"0\">";
					}

					if($this->params['buddy_allow_pmbuddy']==1) {
						if($ueConfig['pms']!=0 && $my->id == $user->id)	
							$pmsurl = $this->getPMS();
					}

					if($ueConfig['allow_profilelink']==1)
						$bstring .= "<div class=\"bud_pic\" align=\"center\"><a href=".$path.$bud->id.">$userAvatar<br/>\n".$bud->username."</a>\n";
					else
						$bstring .= "<div class=\"bud_pic\" align=\"center\">$userAvatar<br/>\n".$bud->username."\n";
					$bstring .= "<br/>\n";

					//Get buddies online status
					if($this->params['buddy_allow_onlinebuddy']==1) {

						$query_session = "SELECT userid FROM #__session WHERE userid='".$bud->id."' LIMIT 1";
						$database->setQuery( $query_session );
						$sessions = $database->loadObjectList();

						//Find Buddies Online
						$buddy_online = 0;
						foreach ($sessions as $session)
						{
							if($session->userid == $bud->id)
							{
								$bstring .= "<img src=\"$online_image\" border=\"0\">"._UE_BUDDY_TAB_ONLINE."<br/>";//add language
								$buddy_online = 1;
							}
						} 
						if ($buddy_online == 0) {
							$bstring .= "<img src=\"$offline_image\" border=\"0\">"._UE_BUDDY_TAB_OFFLINE."<br/>";//add language
						}
					}

					if($this->params['buddy_allow_guestbookbuddy']==1) {
						$gb_link = "index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$bud->id."&index="._UE_GUESTBOOK_TAB_LABEL;
						$gb_link = "<a href='".JRoute::_($gb_link)."'><img src='".$gogb_image."' border='0'></a><br>\n";
					}

					if($my->id == $user->id)
					{
						$bstring .= $pmsurl;
						$bstring .= $gb_link;
						$bstring .= "<a href=\"index.php?option=com_cbe".$Itemid_c."&func=deletebuddy&buddyid=$bud->id&index="._UE_BUDDY_TAB_LABEL."\" onClick=\"return confirm('"._UE_POPUP_DELETE_BUDDY."');\">\n";
						$bstring .= _UE_BUDDY_TAB_DELETE."</a>\n";
					}
					$bstring .= "</div>\n";
				}//end foreach
			}
			echo $bstring;
		// PK edit start
			if(count($buds) > $buddy_page_limit) {
				echo "<tr><td>";
				echo $this->writePagesLinksBuddy($limitstart_buddies, $buddy_page_limit, $total, $ue_base_url);
				echo "</td></tr>";
			} else {
				echo '<tr><td>&nbsp;</td></tr><tr><td><hr/>';
				$this->writePagesLinksBuddy($limitstart_buddies, $buddy_page_limit, $total, $ue_base_url);
			}

		// PK edit end
		}

		//buddy invite
		if ($func=='invite' && $my->id == $user->id) {
			$query = "SELECT buddyid FROM #__cbe_buddylist WHERE userid='".$user->id. "' AND status = 1";
			$database->setQuery($query);
			$result = $database->loadObjectList();
			$total = count ($result);

			if ($total < 1)
				$bstring = '<tr><td>'._UE_BUDDY_TAB_NO_PENDING_INVITES.'</td></tr>';

			if ($total > 0) {
				$buddy='';
				$bstring='';

				foreach($result as $preuser)
					$buddy[]=$preuser->buddyid;

				$passtoquery='(' . implode(',', $buddy) . ')';
				$query = "SELECT id, username FROM #__users WHERE id IN ".$passtoquery." AND block!=1 ORDER BY username";
				$database->setQuery($query);
				$buds = $database->loadObjectList();

				$bstring .= "<tr><td colspan=\"2\">\n";

				foreach($buds as $bud) {
					$query_avatar = "SELECT avatar, avatarapproved FROM #__cbe WHERE user_id='".$bud->id."'";
					$database->setQuery( $query_avatar );
					$pics = $database->loadObjectList();

					foreach ($pics as $pic)
					{
						$user_image=$pic->avatar;

						if(file_exists("components/com_cbe/images/".$mosConfig_lang))
							$user_image_path="components/com_cbe/images/".$mosConfig_lang."/";
						else
							$user_image_path="components/com_cbe/images/english/";

						if($pic->avatarapproved==0)
							$user_image=$user_image_path."tnpendphoto.jpg";
						elseif($pic->avatar=='' || $pic->avatar==null)
							$user_image=$user_image_path."tnnophoto.jpg";
						elseif(ereg('gallery',$pic->avatar))
							$user_image="images/cbe/".$user_image;
						else
							$user_image="images/cbe/tn".$user_image;

						$userAvatar="<img src=\"$user_image\" border=\"0\">";
					}

					if($this->params['buddy_allow_pmbuddy']==1)
					{
						if($ueConfig['pms']!=0 && $my->id == $user->id)
							$pmsurl = $this->getPMS();
					}

					if($ueConfig['allow_profilelink']==1) {
						$bstring .= "<div class=\"bud_pic\" align=\"center\"><a href=".$path.$bud->id.">$userAvatar<br/>\n".$bud->username."</a>\n";
					} else {
						$bstring .= "<div class=\"bud_pic\" align=\"center\">$userAvatar<br/>\n".$bud->username."\n";
					}
					$bstring .= "<br/>\n";

					//Get buddies online status
					if($this->params['buddy_allow_onlinebuddy']==1)
					{

						$query_session = "SELECT userid
										FROM #__session 
										WHERE userid='".$bud->id."' LIMIT 1";
						$database->setQuery( $query_session );
						$sessions = $database->loadObjectList();

						//Find Buddies Online
						$buddy_online = 0;
						foreach ($sessions as $session)
						{
							if($session->userid == $bud->id)
							{
								$bstring .= "<img src=\"$online_image\" border=\"0\">"._UE_BUDDY_TAB_ONLINE."<br/>";//add language
								$buddy_online = 1;
							}
						} 
						if ($buddy_online == 0) {
							$bstring .= "<img src=\"$offline_image\" border=\"0\">"._UE_BUDDY_TAB_OFFLINE."<br/>";//add language
						}
					}

					if($this->params['buddy_allow_guestbookbuddy']==1) {
						$gb_link = "index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$bud->id."&index="._UE_GUESTBOOK_TAB_LABEL;
						$gb_link = "<a href='".JRoute::_($gb_link)."'><img src='".$gogb_image."' border='0'></a><br>\n";
					}

					if($my->id == $user->id)
					{
						$bstring .= $pmsurl;
						$bstring .= $gb_link;
						$bstring .= "<a href=\"index.php?option=com_cbe".$Itemid_c."&func=cancelbuddy&buddyid=$bud->id&index="._UE_BUDDY_TAB_LABEL."\" onClick=\"return confirm('"._UE_POPUP_CANCEL_BUDDY."');\">\n";
						$bstring .= "<img src='components/com_cbe/images/reject.png' width=14 height=14></a>\n";
						//$bstring .= _UE_BUDDY_TAB_CANCEL."</a>\n";
					}
					$bstring .= "</div>\n";
				}//end foreach
			}
			echo $bstring;
		}

		//buddy request
		if($func=='request' && $my->id == $user->id)
		{
			$query = "SELECT userid
					AS buddyid 
					FROM #__cbe_buddylist 
					WHERE buddyid='".$user->id."' 
					AND status = 1";
			$database->setQuery($query);
			$result = $database->loadObjectList();
			$total = count ($result);

			if ($total < 1)
			{
				$bstring = '<tr><td>'._UE_BUDDY_TAB_NO_PENDING_REQUESTS.'</td></tr>';
			}
			if ($total > 0)
			{

				$j=0;
				$buddy='';
				$bstring='';

				foreach($result as $preuser)
				{
					$buddy[$j]=$preuser->buddyid;
					$j++;
				}

				$passtoquery='(' . implode(',', $buddy) . ')';
				$query = "SELECT id,
								username 
						FROM #__users 
						WHERE id 
						IN ".$passtoquery." 
						AND block!=1 
						ORDER BY username";
				$database->setQuery($query);
				$buds = $database->loadObjectList();

				$bstring .= "<tr><td colspan=\"2\">\n";

				foreach($buds as $bud)
				{
					$query_avatar = "SELECT avatar,
											avatarapproved
									FROM #__cbe 
									WHERE user_id='".$bud->id."'";
					$database->setQuery( $query_avatar );
					$pics = $database->loadObjectList();

					foreach ($pics as $pic)
					{
						$user_image=$pic->avatar;

						if(file_exists("components/com_cbe/images/".$mosConfig_lang))
							$user_image_path="components/com_cbe/images/".$mosConfig_lang."/";
						else
							$user_image_path="components/com_cbe/images/english/";

						if($pic->avatarapproved==0)
							$user_image=$user_image_path."tnpendphoto.jpg";
						elseif($pic->avatar=='' || $pic->avatar==null)
							$user_image=$user_image_path."tnnophoto.jpg";
						elseif(ereg('gallery',$pic->avatar))
							$user_image="images/cbe/".$user_image;
						else
							$user_image="images/cbe/tn".$user_image;

						$userAvatar="<img src=\"$user_image\" border=\"0\">";
					}

					$query_session = "SELECT userid
									FROM #__session 
									WHERE userid='".$bud->id."' LIMIT 1";
					$database->setQuery( $query_session );
					$session = $database->loadResult();

					if($this->params['buddy_allow_pmbuddy']==1)
					{
						if($ueConfig['pms']!=0 && $my->id == $user->id)
							$pmsurl = $this->getPMS();
					}

					if($ueConfig['allow_profilelink']==1) {
						$bstring .= "<div class=\"bud_pic\" align=\"center\"><a href=".$path.$bud->id.">$userAvatar<br/>\n".$bud->username."</a>\n";
					} else {
						$bstring .= "<div class=\"bud_pic\" align=\"center\">$userAvatar<br/>\n".$bud->username."\n";
					}
					$bstring .= "<br/>\n";

					//Get buddies online status
					if($this->params['buddy_allow_onlinebuddy']==1)
					{

						$query_session = "SELECT userid
										FROM #__session 
										WHERE userid='".$bud->id."' LIMIT 1";
						$database->setQuery( $query_session );
						$sessions = $database->loadObjectList();

						//Find Buddies Online
						$buddy_online = 0;
						foreach ($sessions as $session)
						{
							if($session->userid == $bud->id)
							{
								$bstring .= "<img src=\"$online_image\" border=\"0\">"._UE_BUDDY_TAB_ONLINE."<br/>";//add language
								$buddy_online = 1;
							}
						} 
						if ($buddy_online == 0) {
							$bstring .= "<img src=\"$offline_image\" border=\"0\">"._UE_BUDDY_TAB_OFFLINE."<br/>";//add language
						}
					}

					if($this->params['buddy_allow_guestbookbuddy']==1) {
						$gb_link = "index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$bud->id."&index="._UE_GUESTBOOK_TAB_LABEL;
						$gb_link = "<a href='".JRoute::_($gb_link)."'><img src='".$gogb_image."' border='0'></a><br>\n";
					}

					if($my->id == $user->id)
					{
						$bstring .= $pmsurl;
						$bstring .= $gb_link;
						$bstring .= "<a href=\"index.php?option=com_cbe".$Itemid_c."&func=acceptbuddy&buddyid=$bud->id&index="._UE_BUDDY_TAB_LABEL."\" onClick=\"return confirm('"._UE_POPUP_ACCEPT_BUDDY."');\">\n";
						$bstring .= _UE_BUDDY_TAB_ACCEPT.'</a>';
						$bstring .= "<a href=\"index.php?option=com_cbe".$Itemid_c."&func=rejectbuddy&buddyid=$bud->id&index="._UE_BUDDY_TAB_LABEL."\" onClick=\"return confirm('"._UE_POPUP_REJECT_BUDDY."');\">\n";
						$bstring .= _UE_BUDDY_TAB_REJECT.'</a>';
					}
					$bstring .= "</div>\n";
				}//end foreach
			}
			echo $bstring;
		}
		//footer
		echo "</table>";
	// ende von buddy_default()
	}
// ende von CBE_buddy
}
?>