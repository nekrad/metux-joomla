<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
/* Joomla CBE Guestbook
/* uses Mootools
*/

global $mosConfig_lang, $userpr;
include_once('components/com_cbe/enhanced/enhanced.js');
include_once('components/com_cbe/enhanced/enhanced_functions.inc');

if (file_exists('components/com_cbe/enhanced/guestbook/language/'.$mosConfig_lang.'.php'))
	include_once('components/com_cbe/enhanced/guestbook/language/'.$mosConfig_lang.'.php');
else
	include_once('components/com_cbe/enhanced/guestbook/language/english.php');

include_once('administrator/components/com_cbe/ue_config.php');
include_once('administrator/components/com_cbe/enhanced_admin/enhanced_config.php');

$prof		= JRequest::getVar('prof','');
$func		= JRequest::getVar('func', 'guestbook' );
$userpr		= JRequest::getVar('user', '');
$gbEntry	= JRequest::getVar('gbentry','');
$gbEntry_id	= JRequest::getVar('gbentry_id','');
$gbrate		= JRequest::getVar('gbrate','');
$Item_id	= JRequest::getVar('Itemid','');

switch ($func) {

	/* Update sv0.61 -> guestbook alerter combatible */
	case "updateGBEntryStatus":
	updateGBEntryStatus($Item_id);
	break;

	case "submitGBEntry":
	submitGBEntry($Item_id, $option, $my->id, _UE_UPDATE);
	break;

	case "deleteGBEntry":
	deleteGBEntry($Item_id, $option, $my->id, $gbEntry_id, $prof, _UE_UPDATE);
	break;

	case "pubGBEntry":
	pubGBEntry($Item_id, $option, $my->id,$gbEntry_id, $prof, _UE_UPDATE);
	break;

	case "unpubGBEntry":
	unpubGBEntry($Item_id, $option, $my->id,$gbEntry_id, $prof, _UE_UPDATE);
	break;

	case "signGuestbook":
	sign_guestbook($Item_id, $option, $my->id, $user->id, _UE_UPDATE);
	break;

	default:
	guestbook($Item_id, $option, $my->id, $user->id, _UE_UPDATE);
	break;

}

// new sv0.61 function, thanks to MrJeff
function updateGBEntryStatus($Item_id) {
	global $mainframe, $userpr;

	$my = &JFactory::getUser();
	$database = &JFactory::getDBO();
	
	$query = "UPDATE #__cbe_mambome_gbook SET status=1 WHERE userid='".$my->id."'";
	$database->setQuery($query);
	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$mainframe->redirect("index.php?option=com_cbe&Itemid=".$Item_id."&task=userProfile&user=$userpr&func=guestbook&index="._UE_GUESTBOOK_TAB_LABEL."");
}

//Guestbook functions
function submitGBEntry($Item_id, $option, $uid, $submitvalue) {
	global $user,$enhanced_Config,$userpr,$gbentry,$gbrate,$acl,$mosConfig_live_site, $mainframe;
	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	(isset($_POST["gbentry"])) ? $gbentry  = JRequest::getVar('gbentry' , '' ) : $gbentry = NULL ;
	(isset($_POST["gbrate"])) ? $gbrate  = JRequest::getVar('gbrate' , '' ) : $gbrate = NULL ;
	$noHTMLText = strip_tags($gbentry);
	$noHTMLText = str_replace('<','-',$noHTMLText);
        $noHTMLText = str_replace('>','-',$noHTMLText);
	$noHTMLText = addslashes($noHTMLText);
	$user_ip =  getenv('REMOTE_ADDR');
	$time = date('H:i:s');
	$date = date('Y-m-d');

	if ($uid == 0 && $enhanced_Config['guestbook_allow_anon']=='0')
	{
		echo JText::_(ALERTNOTAUTH);
		return;
	}

	if($enhanced_Config['guestbook_auto_publish']==0 || ($enhanced_Config['guestbook_allow_anon']=='1' && $uid==0))
	{
		$query = "INSERT INTO #__cbe_mambome_gbook (userid,by_user,gbentry,datetime,user_ip,rating) VALUES ('$userpr','$my->id','$noHTMLText','$date.$time','$user_ip','$gbrate');";
		$database->setQuery( $query );

		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	}
	elseif($enhanced_Config['guestbook_auto_publish']==1 && $uid!=0)
	{
		$query = "INSERT INTO #__cbe_mambome_gbook (userid,by_user,gbentry,datetime,approved,user_ip,rating) VALUES ('$userpr','$my->id','$noHTMLText','$date.$time','1','$user_ip','$gbrate');";
		$database->setQuery( $query );

		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	}

	if($enhanced_Config['guestbook_use_pms_notify']==1)
	{
		$userid= $userpr;
		$whofrom= _UE_GUESTBOOK_TAB_PM_FROM;
		$subject= _UE_GUESTBOOK_TAB_PM_SUBJECT;
		$message= $my->username." ". _UE_GUESTBOOK_TAB_PM_MESSAGE;
		sendUserPM($userid,$whofrom,$subject,$message);
	}
	$mainframe->redirect("index.php?option=com_cbe&Itemid=".$Item_id."&task=userProfile&user=$userpr&func=Guestbook&index="._UE_GUESTBOOK_TAB_LABEL."");
	// eigentlich JRoute::_() davor
}

function deleteGBEntry($Item_id, $option, $uid, $submitvalue, $prof)
{
	global $mainframe;

	$database = &JFactory::getDBO();
	if ($uid == 0)
	{
		echo JText::_(ALERTNOTAUTH);
		return;
	}
	$query = "DELETE FROM #__cbe_mambome_gbook
			  WHERE id='".$submitvalue."'";
	$database->setQuery($query);

	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$mainframe->redirect("index.php?option=com_cbe&Itemid=".$Item_id."&task=userProfile&user=$prof&func=Guestbook&index="._UE_GUESTBOOK_TAB_LABEL."");
}

function pubGBEntry($Item_id, $option, $uid, $submitvalue, $prof)
{
	global $mainframe;

	$database = &JFactory::getDBO();
	if ($uid == 0)
	{
		echo JText::_(ALERTNOTAUTH);
		return;
	}
	$query = "UPDATE #__cbe_mambome_gbook
			  SET approved=1 
			  WHERE id='".$submitvalue."'";
	$database->setQuery($query);

	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$mainframe->redirect("index.php?option=com_cbe&Itemid=".$Item_id."&task=userProfile&user=$prof&func=Guestbook&index="._UE_GUESTBOOK_TAB_LABEL."");
}
function unpubGBEntry($Item_id, $option, $uid, $submitvalue, $prof)
{
	global $mainframe;

	$database = &JFactory::getDBO();
	if ($uid == 0)
	{
		echo JText::_(ALERTNOTAUTH);
		return;
	}

	$query = "UPDATE #__cbe_mambome_gbook
			  SET approved=0 
			  WHERE id='".$submitvalue."'";
	$database->setQuery($query);

	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$mainframe->redirect("index.php?option=com_cbe&Itemid=".$Item_id."&task=userProfile&user=$prof&func=Guestbook&index="._UE_GUESTBOOK_TAB_LABEL."");
}

function writePagesLinksGuestbook($limitstart_guestbook, $limit, $total,$ue_base_url)
{

	$pages_in_list = 10;
	$displayed_pages = $pages_in_list;
	$total_pages = ceil( $total / $limit );
	$this_page = ceil( ($limitstart_guestbook+1) / $limit );
	$start_loop = (floor(($this_page-1)/$displayed_pages))*$displayed_pages+1;
	if ($start_loop + $displayed_pages - 1 < $total_pages) {
		$stop_loop = $start_loop + $displayed_pages - 1;
	} else {
		$stop_loop = $total_pages;
	}

	if ($this_page > 1) {
		$page = ($this_page - 2) * $limit;
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_guestbook=0\" title=\"" . _UE_FIRST_PAGE . "\">&lt;&lt; " . _UE_FIRST_PAGE . "</a>";
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_guestbook=$page\" title=\"" . _UE_PREV_PAGE . "\">&lt; " . _UE_PREV_PAGE . "</a>";
	} else {
		echo '<span class="pagenav">&lt;&lt; '. _UE_FIRST_PAGE .'</span> ';
		echo '<span class="pagenav">&lt; '. _UE_PREV_PAGE .'</span> ';
	}

	for ($i=$start_loop; $i <= $stop_loop; $i++) {
		$page = ($i - 1) * $limit;
		if ($i == $this_page) {
			echo "\n <span class=\"pagenav\">$i</span> ";
		} else {
			echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_guestbook=$page\"><strong>$i</strong></a>";
		}
	}

	if ($this_page < $total_pages) {
		$page = $this_page * $limit;
		$end_page = ($total_pages-1) * $limit;
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_guestbook=$page\" title=\"" . _UE_NEXT_PAGE . "\">" . _UE_NEXT_PAGE . " &gt;</a>";
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_guestbook=$end_page\" title=\"" . _UE_END_PAGE . "\">" . _UE_END_PAGE . " &gt;&gt;</a>";
	} else {
		echo '<span class="pagenav">'. _UE_NEXT_PAGE .' &gt;</span> ';
		echo '<span class="pagenav">'. _UE_END_PAGE .' &gt;&gt;</span>';
	}
}

function guestbook($Item_id, $option, $user, $submitvalue) {
	global $user,$prof,$limitstart_guestbook,$mosConfig_lang,$enhanced_Config,$ueConfig,$mosConfig_live_site,$cbe_GuestBook,$isEditor;

	
	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();
	$ue_base_url = "index.php?option=com_cbe&Itemid=".$Item_id."&task=userProfile&user=$submitvalue&func=guestbook&index="._UE_GUESTBOOK_TAB_LABEL."";	// Base URL string
	$pm_icon = "components/com_cbe/enhanced/images/sendpm.gif";

	include('components/com_cbe/enhanced/pms_includes.php');

	//Sign Guestbook link
	$signlink = "";
	if (($enhanced_Config['guestbook_allow_sign_own'] == '1' && $my->id == $submitvalue) || ($my->id != $submitvalue)) {
		//$signlink = "<a href='index.php?option=com_cbe&Itemid=".$Item_id."&task=userProfile&user=$submitvalue&func=signGuestbook&ajaxdirekt=1&tabname=guestbook'>"._UE_GUESTBOOK_TAB_SIGN_GUESTBOOK."</a>";
		$signlink = "<a href=\"index.php?option=com_cbe&Itemid=".$Item_id."&task=userProfile&user=$submitvalue&func=signGuestbook&index="._UE_GUESTBOOK_TAB_LABEL."\">"._UE_GUESTBOOK_TAB_SIGN_GUESTBOOK."\n" . "</a>";

	}
	//What type of user are we?
	$is_editor = (strtolower($my->usertype) == 'editor' ||
	strtolower($my->usertype) == 'publisher' ||
	strtolower($my->usertype) == 'manager' ||
	strtolower($my->usertype) == 'administrator' ||
	strtolower($my->usertype) == 'super administrator' );

//	$datetime="jS F Y H:i:s"; //date time format refer to php.net for settings
	$datetime=$enhanced_Config['guestbook_timeformat'];
	
	$query1 = "SELECT userid
			   FROM #__cbe_mambome_gbook 
			   WHERE userid = '".$submitvalue."'";
	$database ->setQuery ($query1);
	$result1 = $database->loadResult();

	$query_pub = "SELECT approved
				  FROM #__cbe_mambome_gbook 
				  WHERE userid = '".$submitvalue."'";
	$database ->setQuery ($query_pub);
	$result_pub = $database->loadResult();

	//table header section
	if($my->id==$submitvalue && $result1 !=0)
		$cbe_GuestBook .= "<tr><th align=\"left\">"._UE_GUESTBOOK_TAB_HEADER_FROM."</th><th align=\"left\">"._UE_GUESTBOOK_TAB_HEADER_ENTRIES."</th></tr>\n";
	elseif($my->id !=$submitvalue && $result_pub ==1)
		$cbe_GuestBook .= "<tr><th align=\"left\">"._UE_GUESTBOOK_TAB_HEADER_FROM."</th><th align=\"left\">"._UE_GUESTBOOK_TAB_HEADER_ENTRIES."</th></tr>\n";
	elseif($result1 == 0 && $my->id == $submitvalue)
		$cbe_GuestBook .= "<tr><td>"._UE_GUESTBOOK_TAB_MY_NONE."</td></tr>\n";
	elseif($result1 == 0 && $my->id != $submitvalue)
		$cbe_GuestBook .= "<tr><td>"._UE_GUESTBOOK_TAB_NONE."</td></tr>\n";
	//end table header section

	//Count for page links
	if($my->id == $submitvalue) {
		$query = "SELECT count(gbentry) FROM #__cbe_mambome_gbook WHERE userid='".$submitvalue."'";
		if(!$database->setQuery($query))
			print $database->getErrorMsg();

		$total = $database->loadResult();
	} else {
		$query = "SELECT count(gbentry) FROM #__cbe_mambome_gbook WHERE userid='".$submitvalue."' AND approved=1";
		if(!$database->setQuery($query))
			print $database->getErrorMsg();
		$total = $database->loadResult();
	}

	if (empty($limitstart_guestbook))
		(isset($_GET["limitstart_guestbook"])) ? $limitstart_guestbook  = JRequest::getVar('limitstart_guestbook' , '' ) : $limitstart_guestbook = 0 ;
	else
		$limitstart_guestbook = intval($limitstart_guestbook);

	$limit = $enhanced_Config['guestbook_entries_per_page']; //count starts at zero. 5 will show 4 entries.

	if ($limit > $total)
		$limitstart_guestbook = 0;

	//Display gb entry section
	$query = "SELECT id, userid, gbentry, by_user, datetime, approved, user_ip, rating FROM #__cbe_mambome_gbook WHERE userid='".$submitvalue."' ORDER BY datetime DESC";
	$query .= " LIMIT $limitstart_guestbook, $limit";
	$database->setQuery($query);
	$entries = $database->loadObjectList();

	$i = 1;

	foreach($entries as $entry) {

		//text formatting
		if ($enhanced_Config['guestbook_uselocale'] == '1') {
			$time_format = $enhanced_Config['guestbook_localeformat']; // %d %B %G %T
			$tmp_Date = strftime($time_format, strtotime($entry->datetime));
			$MamboMe_EntryDate = $tmp_Date;
		} else {
			$MamboMe_EntryDate = date($datetime, strtotime($entry->datetime));
		}
		$MamboMeEntryText = $entry->gbentry;
		$gbEntryText = stripslashes($MamboMeEntryText); //remove slashes for viewing

		if ($enhanced_Config['guestbook_use_language_filter']==1) //Use the language filter to get rid of those naughty words?
			$gbEntryText = language_filter($gbEntryText);

		//MamboMe BBC Code
		if ($enhanced_Config['guestbook_use_bbc_code']==1) //Use bbc code?
			$gbEntryText = bbcConvert($gbEntryText);

		//MamboMe Emoticons
		if ($enhanced_Config['guestbook_use_emoticons']==1) //if use emoticons convert to icons
			$gbEntryText = emoticonConvert($gbEntryText);

		if ($enhanced_Config['guestbook_usewordwrap'] == '1') {
			$gb_wrap_limit = intval($enhanced_Config['guestbook_usewordwrap_limit']);
			if ($gb_wrap_limit == 0)
				$gb_wrap_limit = 25;
			$gbEntryText = cbe_wordwrap($gbEntryText, $gb_wrap_limit, 1); //wrap long entries of text at specified length
		}
		$gbEntryText = nl2br($gbEntryText); //changes new lines (\n) to breaklines (<br />)
		$gbEntryText .= "<br>&nbsp;";
		
		//directory where you keep your rating images without trailing slash
		$Rating_Image_Directory ='components/com_cbe/enhanced/guestbook/rating_images';

		if ($enhanced_Config['use_guestbook_rating']=='1') {
			if ($entry->rating == 0)
				$ratingStar = "<img title=\"Not Rated\" src=\"$Rating_Image_Directory/not_rated.gif\" alt=\"not rated\" border=\"0\" /><br />";
			else
				$ratingStar = "<img title=\"" . $entry->rating . " Stars\" src=\"$Rating_Image_Directory/" . $entry->rating . "stars.gif\" border=\"0\" /><br />";
		} else
			$ratingStar = "";

		//get username
		if ($entry->by_user != 0) {
			$query = "SELECT id, username FROM #__users WHERE id='".$entry->by_user."' ";
			$database->setQuery($query);
			$by_users = $database->loadObjectList();
		} else {
			$by_user = array("id" => "0", "username" => "Anon");
			$by_users = array();
			$by_users[] = $by_user;
		}

		foreach ($by_users as $by_user) {
			if ($enhanced_Config['guestbook_show_avatar']==1) {
				//get users avatar
				$query = "SELECT avatar,
							  	 avatarapproved
						  FROM #__cbe
						  WHERE user_id='".$entry->by_user."' ";
				$database->setQuery($query);
				$pics = $database->loadObjectList();

				foreach ($pics as $pic) {
					$user_image=$pic->avatar;

					if(file_exists("components/com_cbe/images/".$mosConfig_lang))
						$user_imagepath="components/com_cbe/images/".$mosConfig_lang."/";
					else
						$user_imagepath="components/com_cbe/images/english/";

					if($pic->avatarapproved==0)
						$user_image=$user_imagepath."tnpendphoto.jpg";
					elseif($pic->avatar=='' || $pic->avatar==null)
						$user_image=$user_imagepath."tnnophoto.jpg";
					elseif(ereg('gallery',$pic->avatar))
						$user_image="images/cbe/".$user_image;
					else
						$user_image="images/cbe/tn".$user_image;
					$userAvatar="<img src=\"$user_image\">";
				}
			}

			$pmsurl = "";
			if($enhanced_Config['allow_gbdirectmail']=='1' && $by_user->id!=0)
			{
				
				if($ueConfig['pms']!=0 && $my->id == $submitvalue)	
				{
					if ($ueConfig['pms']==1) {
						$pmsurl = "<br><a href=\"$pms_open_source_path$by_user->username\">";
						$pmsurl .="<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_BUDDY_TAB_PRIVATE_MESSAGE."\"></a><br/>\n"; 
					} else 
					if ($ueConfig['pms']==2) {
						$pmsurl = "<br><a href=\"$mypms_path$by_user->username\">";
						$pmsurl .= "<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_BUDDY_TAB_PRIVATE_MESSAGE."\"></a><br/>\n";
					} else 
					if ($ueConfig['pms']==3) {
						$pmsurl = "<br><a href=\"$pms_os_2_path$by_user->username\">";
						$pmsurl .= "<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_BUDDY_TAB_PRIVATE_MESSAGE."\"></a><br/>\n";
					} else 
					if ($ueConfig['pms']==4) {
						$pmsurl = "<br><a href=\"$pms_os_enh_path$by_user->username\">";
						$pmsurl .= "<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_BUDDY_TAB_PRIVATE_MESSAGE."\"></a><br/>\n";
					} else 
					if ($ueConfig['pms']==9) {
						$pmsurl = "<br><a href=\"$pms_os_enh2_path$by_user->id\">";
						$pmsurl .= "<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_BUDDY_TAB_PRIVATE_MESSAGE."\"></a><br/>\n";
					} else 
					if ($ueConfig['pms']==5) {
						$pmsurl = "<br><a href=\"$pms_uddeim_path$by_user->id\">";
						$pmsurl .= "<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_BUDDY_TAB_PRIVATE_MESSAGE."\"></a><br/>\n";
					} else 
					if ($ueConfig['pms']==6) {
						$pmsurl = "<br><a href=\"$pms_missus_path$by_user->id\">";
						$pmsurl .= "<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_BUDDY_TAB_PRIVATE_MESSAGE."\"></a><br/>\n";
					} else
					if ($ueConfig['pms']==7) {
						$pmsurl = "<br><a href=\"$pms_clexus_path$by_user->id\">";
						$pmsurl .= "<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_BUDDY_TAB_PRIVATE_MESSAGE."\"></a><br/>\n";
					}
					if ($ueConfig['pms']==8) {
						$pmsurl = "<a href=\"$pms_jim_path$by_user->username\">";
						$pmsurl .= "<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_BUDDY_TAB_PRIVATE_MESSAGE."\"></a><br/>\n";
					}
	
				} 
			}

			$i=($i==1) ? 2 : 1;//alternate the entries row color

			if($my->id == $submitvalue && $entry->approved==1)//This is user's own profile and user is logged in and entry is approved
			{
				$cbe_GuestBook .= "<tr><td class=\"sectiontableentry$i\" width=\"15%\">$userAvatar<br /><a href=\"index.php?option=com_cbe&Itemid=".$Item_id."&task=userProfile&user=$entry->by_user\">$by_user->username</a>".$pmsurl."</td><td class=\"sectiontableentry$i\" width=\"65%\" colspan=\"2\">$MamboMe_EntryDate<br/><hr/>$ratingStar<br/>$gbEntryText</td></tr>\n";
				$cbe_GuestBook .= "<tr><td class=\"sectiontableentry$i\">&nbsp;</td>\n";
				if ($enhanced_Config['allow_gbdirectanswer']=='1' && $by_user->id!=0) {
					$cbe_GuestBook .= "<td class=\"sectiontableentry$i\" width=\"50%\"><a href=\"index.php?option=com_cbe&Itemid=".$Item_id."&task=userProfile&user=".$entry->by_user."&func=signGuestbook&index="._UE_GUESTBOOK_TAB_LABEL."\">"._UE_GUESTBOOK_TAB_ANSWER."</a></td>\n";
				} else {
					$cbe_GuestBook .= "<td class=\"sectiontableentry$i\" width=\"50%\">&nbsp;</td>\n";
				}
				$cbe_GuestBook .= "<td class=\"sectiontableentry$i\" width=\"50%\"><a href=\"index.php?option=com_cbe&Itemid=".$Item_id."&prof=$submitvalue&func=unpubGBEntry&gbentry_id=$entry->id\">"._UE_GUESTBOOK_TAB_UNPUBLISH."</a><a href=\"index.php?option=com_cbe&Itemid=".$Item_id."&prof=$submitvalue&func=deleteGBEntry&amp;gbentry_id=$entry->id\">"._UE_GUESTBOOK_TAB_DELETE."</a></td></tr>\n";

				if ($is_editor)//if user is admin, display admin options
				{
					$cbe_GuestBook .= "<tr><td>&nbsp;</td><td align=\"left\" width=\"100%\"><b>"._UE_GUESTBOOK_TAB_ADMIN."</b>&nbsp;&nbsp;&nbsp;<a href=\"index.php?option=com_cbe&Itemid=".$Item_id."&prof=$user->id&func=deleteGBEntry&gbentry_id=$entry->id\">"._UE_GUESTBOOK_TAB_DELETE."</a>&nbsp;&nbsp;&nbsp;<b>"._UE_GUESTBOOK_TAB_ADMIN_IP."</b>&nbsp;$entry->user_ip</td></tr>\n";
				}
			}
			elseif($my->id == $submitvalue && $entry->approved==0)//This is user's own profile and user is logged in and entry is not approved
			{
				$cbe_GuestBook .= "<tr><td class=\"sectiontableentry$i\" width=\"15%\">$userAvatar<br /><a href=\"index.php?option=com_cbe&Itemid=".$Item_id."&task=userProfile&user=$entry->by_user\">$by_user->username</a>".$pmsurl."</td><td class=\"sectiontableentry$i\" width=\"65%\" colspan=\"2\">$MamboMe_EntryDate<br/><hr/>$ratingStar<br/>$gbEntryText</td></tr>\n";
				$cbe_GuestBook .= "<tr><td class=\"sectiontableentry$i\">&nbsp;</td>\n";
				if ($enhanced_Config['allow_gbdirectanswer']=='1' && $by_user->id!=0) {
					$cbe_GuestBook .= "<td class=\"sectiontableentry$i\" width=\"50%\"><a href=\"index.php?option=com_cbe&Itemid=".$Item_id."&task=userProfile&user=".$entry->by_user."&func=signGuestbook&index="._UE_GUESTBOOK_TAB_LABEL."\">"._UE_GUESTBOOK_TAB_ANSWER."</a></td>\n";
				} else {
					$cbe_GuestBook .= "<td class=\"sectiontableentry$i\" width=\"50%\">&nbsp;</td>\n";
				}
				$cbe_GuestBook .= "<td class=\"sectiontableentry$i\" width=\"50%\"><a href=\"index.php?option=com_cbe&Itemid=".$Item_id."&prof=$submitvalue&func=pubGBEntry&gbentry_id=$entry->id\">"._UE_GUESTBOOK_TAB_PUBLISH."</a><a href=\"index.php?option=com_cbe&Itemid=".$Item_id."&prof=$submitvalue&func=deleteGBEntry&amp;gbentry_id=$entry->id\">"._UE_GUESTBOOK_TAB_DELETE."</a></td></tr>\n";
//				$cbe_GuestBook .= "<tr><td class=\"sectiontableentry$i\">&nbsp;</td><td class=\"sectiontableentry$i\" width=\"20%\"><a href=\"index.php?option=com_cbe".$Item_id."&prof=$submitvalue&func=pubGBEntry&gbentry_id=$entry->id\">"._UE_GUESTBOOK_TAB_PUBLISH." </a><a href=\"index.php?option=com_cbe".$Item_id."&prof=$submitvalue&func=deleteGBEntry&gbentry_id=$entry->id\">"._UE_GUESTBOOK_TAB_DELETE."</a></td></tr>\n";

				if ($is_editor)//if user is admin, display admin options
				{
					$cbe_GuestBook .= "<tr><td>&nbsp;</td><td align=\"left\" width=\"100%\"><b>"._UE_GUESTBOOK_TAB_ADMIN."</b>&nbsp;&nbsp;&nbsp;<a href=\"index.php?option=com_cbe&Itemid=".$Item_id."&prof=$submitvalue&func=deleteGBEntry&gbentry_id=$entry->id\">"._UE_GUESTBOOK_TAB_DELETE."</a>&nbsp;&nbsp;&nbsp;<b>"._UE_GUESTBOOK_TAB_ADMIN_IP."</b>&nbsp;$entry->user_ip</td></tr>\n";
				}
			}
			elseif($entry->approved==1)
			{
				$cbe_GuestBook .= "<tr><td class=\"sectiontableentry$i\" width=\"30%\">$userAvatar<br /><a href=\"index.php?option=com_cbe&Itemid=".$Item_id."&task=userProfile&user=$entry->by_user\">$by_user->username</a>".$pmsurl."</td><td class=\"sectiontableentry$i\" width=\"70%\">$MamboMe_EntryDate<br/><hr/>$ratingStar<br/>$gbEntryText</td></tr>\n";

				if ($is_editor)//if user is admin, display admin options
				{
					$cbe_GuestBook .= "<tr><td>&nbsp;</td><td align=\"left\" width=\"100%\"><b>"._UE_GUESTBOOK_TAB_ADMIN."</b>&nbsp;&nbsp;&nbsp;<a href=\"index.php?option=com_cbe&Itemid=".$Item_id."&prof=$submitvalue&func=deleteGBEntry&gbentry_id=$entry->id\">"._UE_GUESTBOOK_TAB_DELETE."</a>&nbsp;&nbsp;&nbsp;<b>"._UE_GUESTBOOK_TAB_ADMIN_IP."</b>&nbsp;$entry->user_ip</td></tr>\n";
				}
			}
		}
	}

	// und jetzt der output
	echo <<<EOT
	<div id="cbe_guestbook">
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr><td colspan="3" align="right">$signlink</td></tr>
		<tr><td>&nbsp;</td></tr>
EOT;
	echo $cbe_GuestBook;
	//End Display gb entries section
	$colspan_gb = (($isEditor) ? 4 : 3);
	if(count($entries) > $limit)
	{
 	echo "<tr><td colspan=\"".$colspan_gb."\">\n";
 	writePagesLinksGuestbook($limitstart_guestbook, $limit, $total, $ue_base_url);
 	echo "</td></tr>\n";

	}
	echo '<tr><td>&nbsp;</td></tr><tr><td colspan="'.$colspan_gb.'"><hr/>';
	writePagesLinksGuestbook($limitstart_guestbook, $limit, $total, $ue_base_url);
	echo "</td></tr>\n";

	//Sign Guestbook link
	if (($enhanced_Config['guestbook_allow_sign_own'] == '1' && $my->id == $submitvalue) || ($my->id != $submitvalue)) {
		echo "<tr><td colspan=\"3\" align=\"right\"><a href=\"index.php?option=com_cbe&Itemid=".$Item_id."&task=userProfile&user=$submitvalue&func=signGuestbook&index="._UE_GUESTBOOK_TAB_LABEL."\">"._UE_GUESTBOOK_TAB_SIGN_GUESTBOOK."</a></td></tr><tr><td>&nbsp;</td></tr>";
	}
	echo '</table></div>';
}

function sign_guestbook($Item_id, $option, $user, $submitvalue)
{
	global $user,$prof,$enhanced_Config,$userpr,$gbentry,$gbrate,$acl,$_POST,$_REQUEST,$mosConfig_live_site;
	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$gbWordLimit = $enhanced_Config['guestbook_set_word_limit']; //get the character limit from ue_config.php
	$submitvalue =(!empty($userpr))?$userpr:$submitvalue;

	echo "<table width='100%'>"; //<!-- $user, $submitvalue -->

	$cbe_GuestBook = "\n<!-- MamboMe Profile GuestBook System Copyright (c) Jeffrey Randall 2005 -->\n";
	$cbe_GuestBook .= "<!-- Released under the GNU/GPL License http://www.gnu.org/copyleft/gpl.html-->\n";
	$cbe_GuestBook .= "<!-- Visit http://mambome.com for more info -->\n\n";


	if ($my->id == 0 && $enhanced_Config['guestbook_allow_anon']=='0')//not logged in, can not sign guestbook
	{
		//$MamboMe_Sign_GuestBook .= "<table width=\"100%\">\n";
		$MamboMe_Sign_GuestBook .= "<hr/>\n";
		$MamboMe_Sign_GuestBook .= "<tr><td>"._UE_GUESTBOOK_TAB_NOT_LOGIN."&nbsp;"._UE_GUESTBOOK_TAB_NO_ACCOUNT." <a href=\"index.php?option=com_cbe&Itemid=".$Item_id."&task=registers\">"._UE_CREATE_ACCOUNT."</a>.</td></tr>\n";
	}

	//Display guestbook Submit Form
	elseif ($my->id || ($enhanced_Config['guestbook_allow_anon']=='1' && $my->id==0))//logged in
	{
		$MamboMe_Sign_GuestBook = "<table width=\"100%\" cellspacing=\"0\" cellpadding\"0\">\n";

		//get username
		$query = "SELECT username
				  FROM #__users 
				  WHERE id='".$submitvalue."'";
		$database->setQuery($query);
		$username = $database->loadResult();

		$MamboMe_Sign_GuestBook .= '<tr><th>'._UE_GUESTBOOK_TAB_SIGN_HEADER.'&nbsp;'.$username._UE_GUESTBOOK_TAB_SIGN_HEADER_PLURAL.'&nbsp;'._UE_GUESTBOOK_TAB_SIGN_GUESTBOOK_HEADER."</th></tr>";

		if ($enhanced_Config['guestbook_use_bbc_code']==1) //Use bbc code? basic for now - more to come later!
		{
			$MamboMe_Sign_GuestBook .= "<br />\n";
			$MamboMe_Sign_GuestBook .= "<tr><td>"._UE_GUESTBOOK_TAB_BBC_CODE_LEGEND."</td></tr>\n";
			$MamboMe_Sign_GuestBook .= "<tr><td>"._UE_GUESTBOOK_TAB_BBC_CODE_BOLD." [b]"._UE_GUESTBOOK_TAB_BBC_CODE_TEXT."[/b]&nbsp;&nbsp;"._UE_GUESTBOOK_TAB_BBC_CODE_ITALICS." [i]"._UE_GUESTBOOK_TAB_BBC_CODE_TEXT."[/i]&nbsp;&nbsp;"._UE_GUESTBOOK_TAB_BBC_CODE_UNDERLINE." [u]"._UE_GUESTBOOK_TAB_BBC_CODE_TEXT."[/u]<br />";
			$MamboMe_Sign_GuestBook .= _UE_GUESTBOOK_TAB_BBC_CODE_IMAGE." [img]"._UE_GUESTBOOK_TAB_BBC_CODE_URL."[/img]</td></tr>\n";
			$MamboMe_Sign_GuestBook .= "<br />\n";
		}

		if ($enhanced_Config['guestbook_use_emoticons']==1) //if use emoticons, show emoticon table
		{
			$MamboMe_Sign_GuestBook .= "<tr><td><form method=\"post\" name=\"gbentry\" action=\"index.php?option=com_cbe&Itemid=".$Item_id."&task=userProfile&user=".$submitvalue."&func=submitGBEntry\"></td></tr>\n";
			$MamboMe_Sign_GuestBook .= "<tr><td><textarea name=\"gbentry\" class=\"inputbox\" rows=\"4\" cols=\"35\" wrap=\"virtual\" onselect=\"storeCaret(this);\" onclick=\"storeCaret(this);\" onkeyup=\"storeCaret(this);\" onKeyDown=\"limitText(this.form.gbentry,this.form.countdown,$gbWordLimit);\" onKeyUp=\"limitText(this.form.gbentry,this.form.countdown,$gbWordLimit);\"></textarea></td></tr>\n";
			$MamboMe_Sign_GuestBook .= "<tr><td><font size=\"1\">("._UE_WORD_LIMIT_MAXIMUM_CHAR."&nbsp;$gbWordLimit)<br>"._UE_WORD_LIMIT_YOU_HAVE."&nbsp;<input readonly type=\"text\" name=\"countdown\" size=\"3\" value=\"$gbWordLimit\">&nbsp;"._UE_WORD_LIMIT_CHAR_LEFT."</font></td></tr>";
			$MamboMe_Sign_GuestBook .= "</table>\n";
			$MamboMe_Sign_GuestBook .= ShowEmoticonsTable(1);
			$MamboMe_Sign_GuestBook .= "<table width=\"100%\" cellspacing=\"0\" cellpadding\"0\">\n";
		}
		else
		{
			$MamboMe_Sign_GuestBook .= "<tr><td><form action=\"index.php?option=com_cbe&Itemid=".$Item_id."&task=userProfile&user=".$submitvalue."&func=submitGBEntry\" method=\"post\" name=\"gbentry\"></td></tr>\n";
			$MamboMe_Sign_GuestBook .= "<tr><td><textarea name=\"gbentry\" class=\"inputbox\" rows=\"4\" cols=\"35\" wrap=\"virtual\"  onKeyDown=\"limitText(this.form.gbentry,this.form.countdown,$gbWordLimit);\" onKeyUp=\"limitText(this.form.gbentry,this.form.countdown,$gbWordLimit);\"></textarea></td></tr>\n";
			$MamboMe_Sign_GuestBook .= "<tr><td><font size=\"1\">("._UE_WORD_LIMIT_MAXIMUM_CHAR."&nbsp;$gbWordLimit)<br>"._UE_WORD_LIMIT_YOU_HAVE."&nbsp;<input readonly type=\"text\" name=\"countdown\" size=\"3\" value=\"$gbWordLimit\">&nbsp;"._UE_WORD_LIMIT_CHAR_LEFT."</font></td></tr>";
			//$MamboMe_Sign_GuestBook .= "</table>\n";
		}

		//guestbook rating section 2 the drop down list
		if ($enhanced_Config['use_guestbook_rating']==1)
		{
			$MamboMe_Sign_GuestBook .= "<tr><td>"._UE_GUESTBOOK_TAB_RATING."&nbsp;<select name=\"gbrate\" style=\"width:100px;\" class=\"inputbox\" size=\"1\">";
			$MamboMe_Sign_GuestBook .= "<option value=\"5\" selected>"._UE_GUESTBOOK_TAB_RATING_5."</option>";
			$MamboMe_Sign_GuestBook .= "<option value=\"0\">"._UE_GUESTBOOK_TAB_RATING_0."</option>";
			$MamboMe_Sign_GuestBook .= "<option value=\"1\">"._UE_GUESTBOOK_TAB_RATING_1."</option>";
			$MamboMe_Sign_GuestBook .= "<option value=\"2\">"._UE_GUESTBOOK_TAB_RATING_2."</option>";
			$MamboMe_Sign_GuestBook .= "<option value=\"3\">"._UE_GUESTBOOK_TAB_RATING_3."</option>";
			$MamboMe_Sign_GuestBook .= "<option value=\"4\">"._UE_GUESTBOOK_TAB_RATING_4."</option>";
			$MamboMe_Sign_GuestBook .= "<option value=\"5\">"._UE_GUESTBOOK_TAB_RATING_5."</option>";
			$MamboMe_Sign_GuestBook .= "</select>&nbsp;"._UE_GUESTBOOK_TAB_RATING_LEGEND."</td></tr>";
		}


		$MamboMe_Sign_GuestBook .= "<tr><td><input type=\"hidden\" name=\"userid\" value=\"$submitvalue\" /></td></tr>\n";
		$MamboMe_Sign_GuestBook .= "<tr><td><input type=\"submit\" name=\"submit\" class=button value=\""._UE_GUESTBOOK_TAB_SIGN_SUBMIT."\" onclick=\"return confirm('"._UE_GUESTBOOK_TAB_SUBMIT."')\"></td></tr>\n";
		$MamboMe_Sign_GuestBook .= "</form>\n";

	}

	//go back link
	$MamboMe_Sign_GuestBook .= "<tr><td colspan=\"3\" align=\"right\"><a href=\"index.php?option=com_cbe&Itemid=".$Item_id."&task=userProfile&user=$submitvalue&tabname=guestbook&func=Guestbook&index="._UE_GUESTBOOK_TAB_LABEL."\">"._UE_GUESTBOOK_TAB_SIGN_BACK."</a></td></tr>";	// Base URL string

	echo $MamboMe_Sign_GuestBook;

	echo '</table>';
}
?>