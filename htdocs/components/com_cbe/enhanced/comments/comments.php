<?php
//********************************************
// MamboMe Profile Comment System Tab        *
// Copyright (c) 2005 Jeffrey Randall        *
// http://mambome.com                        *
// Released under the GNU/GPL License        *
// Version 1.0                               *
// File date: 20-05-2005                     *
//********************************************

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

include_once('components/com_cbe/enhanced/enhanced.js');

include_once('components/com_cbe/enhanced/enhanced_functions.inc');

if (file_exists('components/com_cbe/enhanced/comments/language/'.$mosConfig_lang.'.php'))
{
	include_once('components/com_cbe/enhanced/comments/language/'.$mosConfig_lang.'.php');
}
else
{
	include_once('components/com_cbe/enhanced/comments/language/english.php');
}

include_once('administrator/components/com_cbe/enhanced_admin/enhanced_config.php');



$func=JRequest::getVar('func', 'comments' );
$prof=JRequest::getVar('prof','');
$comment=JRequest::getVar('comment','');
$comment_id=JRequest::getVar('comment_id','');
$my = &JFactory::getUser();

if ($GLOBALS['Itemid_com']!='') {
	$Itemid_c = $GLOBALS['Itemid_com'];
} else {
	$Itemid_c = '';
}


switch ($func)
{
	case "submitComment":
	submitComment($Itemid_c, $option, $my->id, _UE_UPDATE);
	break;

	case "pubComment":
	pubComment($Itemid_c, $option, $my->id,$comment_id, $prof, _UE_UPDATE);
	break;

	case "unpubComment":
	unpubComment($Itemid_c, $option, $my->id,$comment_id, $prof, _UE_UPDATE);
	break;

	case "deleteComment":
	deleteComment($Itemid_c, $option, $my->id,$comment_id, $prof, _UE_UPDATE);
	break;

	case "writeComment":
	writeComment($Itemid_c, $option, $my->id, $user->id, _UE_UPDATE);
	break;

	default:
	comments($Itemid_c, $option, $my->id, $user->id, _UE_UPDATE);
	break;
}

//Comment functions
function submitComment($Itemid_c, $option, $uid, $submitvalue)
{
	global $user,$enhanced_Config,$userpr,$comment,$acl,$_POST,$_REQUEST,$mosConfig_live_site, $mainframe;
	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	(isset($_POST["comment"])) ? $comment  = JRequest::getVar ('comment' , '' ) : $comment = NULL ;
	
	$noHTMLText = strip_tags($comment);
	$noHTMLText = str_replace('<','-',$noHTMLText);
        $noHTMLText = str_replace('>','-',$noHTMLText);
	$noHTMLText = addslashes($noHTMLText);
	$user_ip =  getenv('REMOTE_ADDR');
	$time = date('H:i:s');
	$date = date('Y-m-d');

	if ($uid == 0)
	{
		echo JText::_(ALERTNOTAUTH);
		return;
	}

	if($enhanced_Config['comment_auto_publish']==0)
	{
		$query = "INSERT INTO #__cbe_profile_comments (userid,by_user,comment,datetime,user_ip) VALUES ('$userpr','$my->id','$noHTMLText','$date.$time','$user_ip');";
		$database->setQuery( $query );

		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	}
	elseif($enhanced_Config['comment_auto_publish']==1)
	{
		$query = "INSERT INTO #__cbe_profile_comments (userid,by_user,comment,datetime,approved,user_ip) VALUES ('$userpr','$my->id','$noHTMLText','$date.$time','1','$user_ip');";
		$database->setQuery( $query );

		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	}
	$mainframe->redirect("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$userpr&func=comments&index="._UE_PROFILE_COMMENTS_TAB_LABEL."");
}

function deleteComment ($Itemid_c, $option, $uid, $submitvalue, $prof)
{
	global $mainframe;
	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	if ($uid == 0)
	{
		echo JText::_(ALERTNOTAUTH);
		return;
	}
	$query = "DELETE FROM #__cbe_profile_comments
			  WHERE id='".$submitvalue."'";
	$database->setQuery($query);

	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$mainframe->redirect("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$prof&func=comments&index="._UE_PROFILE_COMMENTS_TAB_LABEL."");
}

function pubComment($Itemid_c, $option, $uid, $submitvalue, $prof)
{
	global $mainframe;

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	if ($uid == 0)
	{
		echo JText::_(ALERTNOTAUTH);
		return;
	}
	$query = "UPDATE #__cbe_profile_comments
			  SET approved=1 
			  WHERE id='".$submitvalue."'";
	$database->setQuery($query);

	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$mainframe->redirect("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$prof."&func=comments&index="._UE_PROFILE_COMMENTS_TAB_LABEL."");
}

function unpubComment($Itemid_c, $option, $uid, $submitvalue, $prof)
{
	global $mainframe;
	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	if ($uid == 0)
	{
		echo JText::_(ALERTNOTAUTH);
		return;
	}

	$query = "UPDATE #__cbe_profile_comments
			  SET approved=0 
			  WHERE id='".$submitvalue."'";
	$database->setQuery($query);

	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$mainframe->redirect("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$prof."&func=comments&index="._UE_PROFILE_COMMENTS_TAB_LABEL."");
}

function writePagesLinksComment($limitstart_comment, $limit, $total,$ue_base_url)
{

	$pages_in_list = 10;
	$displayed_pages = $pages_in_list;
	$total_pages = ceil( $total / $limit );
	$this_page = ceil( ($limitstart_comment+1) / $limit );
	$start_loop = (floor(($this_page-1)/$displayed_pages))*$displayed_pages+1;
	if ($start_loop + $displayed_pages - 1 < $total_pages) {
		$stop_loop = $start_loop + $displayed_pages - 1;
	} else {
		$stop_loop = $total_pages;
	}

	if ($this_page > 1) {
		$page = ($this_page - 2) * $limit;
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_comment=0\" title=\"" . _UE_FIRST_PAGE . "\">&lt;&lt; " . _UE_FIRST_PAGE . "</a>";
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_comment=$page\" title=\"" . _UE_PREV_PAGE . "\">&lt; " . _UE_PREV_PAGE . "</a>";
	} else {
		echo '<span class="pagenav">&lt;&lt; '. _UE_FIRST_PAGE .'</span> ';
		echo '<span class="pagenav">&lt; '. _UE_PREV_PAGE .'</span> ';
	}

	for ($i=$start_loop; $i <= $stop_loop; $i++) {
		$page = ($i - 1) * $limit;
		if ($i == $this_page) {
			echo "\n <span class=\"pagenav\">$i</span> ";
		} else {
			echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_comment=$page\"><strong>$i</strong></a>";
		}
	}

	if ($this_page < $total_pages) {
		$page = $this_page * $limit;
		$end_page = ($total_pages-1) * $limit;
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_comment=$page\" title=\"" . _UE_NEXT_PAGE . "\">" . _UE_NEXT_PAGE . " &gt;</a>";
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_comment=$end_page\" title=\"" . _UE_END_PAGE . "\">" . _UE_END_PAGE . " &gt;&gt;</a>";
	} else {
		echo '<span class="pagenav">'. _UE_NEXT_PAGE .' &gt;</span> ';
		echo '<span class="pagenav">'. _UE_END_PAGE .' &gt;&gt;</span>';
	}
}
function comments($Itemid_c, $option, $user, $submitvalue)
{
	global $user,$prof,$limitstart_comment,$mosConfig_lang,$enhanced_Config,$mosConfig_live_site;
	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	$ue_base_url = "index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$submitvalue&func=comments&index="._UE_PROFILE_COMMENTS_TAB_LABEL."";	// Base URL string

	//Begin Display Comment

	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">";

	$MamboMe_Comment = "\n<!-- MamboMe Profile Comment System Copyright (c) Jeffrey Randall 2005 -->\n";
	$MamboMe_Comment .= "<!-- Released under the GNU/GPL License http://www.gnu.org/copyleft/gpl.html-->\n";
	$MamboMe_Comment .= "<!-- Visit http://mambome.com for more info -->\n\n";

	//Write Comment link
	?>
	<tr><td colspan="3" align="right">
	<?php
	if ($enhanced_Config['comment_allow_sign_own'] == '1') {
		echo "<a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$submitvalue&func=writeComment&index="._UE_PROFILE_COMMENTS_TAB_LABEL."\">"._UE_PROFILE_COMMENTS_TAB_WRITE_COMMENT."\n";
	}
	?>
	</a></td></tr><tr><td>&nbsp;</td></tr>
	<?php

	$is_editor = (strtolower($my->usertype) == 'editor' ||
	strtolower($my->usertype) == 'publisher' ||
	strtolower($my->usertype) == 'manager' ||
	strtolower($my->usertype) == 'administrator' ||
	strtolower($my->usertype) == 'super administrator' );

	//$datetime="jS F Y H:i:s"; //date format
	$datetime=$enhanced_Config['comment_timeformat'];

	$query1 = "SELECT userid
			   FROM #__cbe_profile_comments 
			   WHERE userid = '".$submitvalue."'";
	$database ->setQuery ($query1);
	$result1 = $database->loadResult();

	$query_pub = "SELECT approved
				  FROM #__cbe_profile_comments 
				  WHERE userid = '".$submitvalue."'";
	$database ->setQuery ($query_pub);
	$result_pub = $database->loadResult();

	if($my->id==$submitvalue && $result1 !=0)
	{
		$MamboMe_Comment .= "<tr><th align=\"left\">"._UE_PROFILE_COMMENTS_TAB_HEADER_OPTION."</th><th align=\"left\">"._UE_PROFILE_COMMENTS_TAB_HEADER_FROM."</th><th align=\"left\">"._UE_PROFILE_COMMENTS_TAB_HEADER_COMMENT."</th></tr>\n";
	}

	elseif($my->id !=$submitvalue && $result_pub ==1)
	{
		$MamboMe_Comment .= "<tr><th align=\"left\">"._UE_PROFILE_COMMENTS_TAB_HEADER_FROM."</th><th align=\"left\">"._UE_PROFILE_COMMENTS_TAB_HEADER_COMMENT."</th></tr>\n";
	}

	elseif($result1 == 0 && $my->id == $submitvalue) // you are logged in and have no comments
	{
		$MamboMe_Comment.= "<tr><td>"._UE_PROFILE_COMMENTS_TAB_MY_NONE."</td></tr>\n";
	}
	elseif($result1 == 0 && $my->id != $submitvalue) // you are logged in and the user profile you are viewing has no comments
	{
		$MamboMe_Comment.= "<tr><td>"._UE_PROFILE_COMMENTS_TAB_NONE."</td></tr>\n";
	}

	//Count for page links
	if($my->id==$submitvalue)
	{
		$query = "SELECT count(comment)
			  	  FROM #__cbe_profile_comments
			  	  WHERE userid='".$submitvalue."'";

		if(!$database->setQuery($query))
		print $database->getErrorMsg();

		$total = $database->loadResult();
	}
	else
	{
		$query = "SELECT count(comment)
			  	  FROM #__cbe_profile_comments
			  	  WHERE userid='".$submitvalue."'
			  	  AND approved=1";

		if(!$database->setQuery($query))
		print $database->getErrorMsg();

		$total = $database->loadResult();
	}

	if (empty($limitstart_comment)) {
		(isset($_GET["limitstart_comment"])) ? $limitstart_comment  = mosGetParam ( $_GET, 'limitstart_comment' , '' ) : $limitstart_comment = 0 ;
	} else {
		$limitstart_comment = intval($limitstart_comment);
	}

	$limit = $enhanced_Config['comment_entries_per_page']; //count starts at zero. 5 will show 4 entries.

	if ($limit > $total)
	{
		$limitstart_comment = 0;
	}

	//Display comment section
	$query = "SELECT id,
					 userid,
					 comment,
					 by_user,
					 datetime,
					 approved,
					 user_ip 
			  FROM #__cbe_profile_comments 
			  WHERE userid='".$submitvalue."' 
			  ORDER BY datetime DESC";
	$query .= " LIMIT $limitstart_comment, $limit";
	$database->setQuery($query);
	$comments = $database->loadObjectList();

	$i = 1;

	foreach ($comments as $comment)
	{
		$query = "SELECT id,
						 username 
				  FROM #__users 
				  WHERE id='".$comment->by_user."' ";
		$database->setQuery($query);
		$by_users = $database->loadObjectList();

		//$MamboMe_CommentDate = date($datetime, strtotime($comment->datetime));
		if ($enhanced_Config['comment_uselocale'] == '1') {
//			setlocale(LC_TIME, "de_DE");
			$time_format = $enhanced_Config['comment_localeformat']; // %d %B %G %T
			$tmp_Date = strftime($time_format, strtotime($comment->datetime));
			$MamboMe_CommentDate = $tmp_Date;
		} else {
			$MamboMe_CommentDate = date($datetime, strtotime($comment->datetime));
		}


		$MamboMeCommentText = $comment->comment;//get the comment
		$CommentText = wordwrap($MamboMeCommentText,25, "\n", 1);//wrap words
		$CommentText = stripslashes($CommentText);//remove slashes

		if ($enhanced_Config['comment_use_language_filter']==1) //Use the language filter to get rid of those naughty words?
		{
			$CommentText = language_filter($CommentText);
		}

		//MamboMe BBC Code
		if ($enhanced_Config['comment_use_bbc_code']==1) //Use bbc code?
		{
			$CommentText = bbcConvert($CommentText);
		}

		//MamboMe Emoticons
		if ($enhanced_Config['comment_use_emoticons']==1) //if use emoticons convert to icons
		{
			$CommentText = emoticonConvert($CommentText);
		}

		foreach ($by_users as $by_user)
		{
			if ($enhanced_Config['comment_show_avatar']==1) //Show commenters avatar?
			{

				$query_avatar = "SELECT avatar,
							  	 		avatarapproved
								 FROM #__cbe 
								 WHERE user_id='".$comment->by_user."'";
				$database->setQuery( $query_avatar );
				$pics = $database->loadObjectList();

				foreach ($pics as $pic)
				{
					$user_image=$pic->avatar;

					if(file_exists("components/com_cbe/images/".$mosConfig_lang))
					{
						$user_image_path="components/com_cbe/images/".$mosConfig_lang."/";
					}
					else
					{
						$user_image_path="components/com_cbe/images/english/";
					}

					if($pic->avatarapproved==0)
					{
						$user_image=$user_image_path."tnpendphoto.jpg";
					}

					elseif($pic->avatar=='' || $pic->avatar==null)
					{
						$user_image=$user_image_path."tnnophoto.jpg";
					}

					elseif(ereg('gallery',$pic->avatar))
					{

						$user_image="images/cbe/".$user_image;
					}
					else
					{
						$user_image="images/cbe/tn".$user_image;
					}

					$userAvatar="<img src=\"$user_image\">";
				}
			}

			$i=($i==1) ? 2 : 1;

			if($my->id == $submitvalue && $comment->approved==1)
			{

				$MamboMe_Comment .= "<tr><td class=\"sectiontableentry$i\" width=\"20%\"><a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$submitvalue&func=unpubComment&amp;comment_id=$comment->id\">"._UE_PROFILE_COMMENTS_TAB_HIDE."</a><a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$submitvalue&func=deleteComment&amp;comment_id=$comment->id\">"._UE_PROFILE_COMMENTS_TAB_DELETE."</a></td><td class=\"sectiontableentry$i\" width=\"15%\">$userAvatar<br/><a href=\"index.php?option=com_cbe".$Itemid_c."&amp;task=userProfile&user=$comment->by_user\">$by_user->username</a></td><td class=\"sectiontableentry$i\" width=\"65%\">$MamboMe_CommentDate<br/><hr/><br/> $CommentText</td></tr>\n";
				if ($is_editor)
				{
					$MamboMe_Comment .= "<tr>\n<td>&nbsp;</td><td>&nbsp;</td><td align=\"left\" width=\"100%\"><b>"._UE_PROFILE_COMMENTS_TAB_ADMIN."</b>&nbsp;&nbsp;&nbsp;<a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$submitvalue&func=deleteComment&comment_id=$comment->id\">"._UE_PROFILE_COMMENTS_TAB_DELETE."</a>&nbsp;&nbsp;&nbsp;<b>"._UE_PROFILE_COMMENTS_TAB_ADMIN_IP."</b>&nbsp;$comment->user_ip</td></tr>\n";
				}
			}
			elseif($my->id == $submitvalue && $comment->approved==0)
			{
				$MamboMe_Comment .= "<tr><td class=\"sectiontableentry$i\" width=\"20%\"><a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$submitvalue&func=pubComment&comment_id=$comment->id\">"._UE_PROFILE_COMMENTS_TAB_SHOW." </a><a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$submitvalue&func=deleteComment&comment_id=$comment->id\">"._UE_PROFILE_COMMENTS_TAB_DELETE."</a></td><td class=\"sectiontableentry$i\" width=\"15%\">$userAvatar<br/><a href=\"index.php?option=com_cbe".$Itemid_c."&amp;task=userProfile&user=$comment->by_user\">$by_user->username</a></td><td class=\"sectiontableentry$i\" width=\"65%\">$MamboMe_CommentDate<br/><hr/><br/> $CommentText</td></tr>\n";
				if ($is_editor)
				{
					$MamboMe_Comment .= "<tr><td>&nbsp;</td><td>&nbsp;</td>\n<td align=\"left\" width=\"100%\"><b>"._UE_PROFILE_COMMENTS_TAB_ADMIN."</b>&nbsp;&nbsp;&nbsp;<a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$submitvalue&func=deleteComment&comment_id=$comment->id\">"._UE_PROFILE_COMMENTS_TAB_DELETE."</a>&nbsp;&nbsp;&nbsp;<b>"._UE_PROFILE_COMMENTS_TAB_ADMIN_IP."</b>&nbsp;$comment->user_ip</td></tr>\n";
				}
			}
			elseif($comment->approved==1)
			{
				$MamboMe_Comment .= "<tr><td class=\"sectiontableentry$i\" width=\"30%\">$userAvatar<br/><a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$comment->by_user\">$by_user->username</a></td><td class=\"sectiontableentry$i\" width=\"70%\">$MamboMe_CommentDate<br/><hr/><br/> $CommentText</td></tr>\n";
				if ($is_editor)
				{
					$MamboMe_Comment .= "<tr><td>&nbsp;</td><td align=\"left\" width=\"100%\"><b>"._UE_PROFILE_COMMENTS_TAB_ADMIN."</b>&nbsp;&nbsp;&nbsp;<a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$submitvalue&func=deleteComment&comment_id=$comment->id\">"._UE_PROFILE_COMMENTS_TAB_DELETE."</a>&nbsp;&nbsp;&nbsp;<b>"._UE_PROFILE_COMMENTS_TAB_ADMIN_IP."</b>&nbsp;$comment->user_ip</td></tr>\n";
				}
			}
		}
	}
	echo $MamboMe_Comment;

	//End Display Comments section
	$colspan_c = (($isEditor) ? 4 : 3);
	if(count($total) > $limit)
	{
		$cm_pagenav = '<tr><td colspan="'.$colspan_c.'">';
		echo $cm_pagenav."\n";
		writePagesLinksComment($limitstart_comment, $limit, $total, $ue_base_url);
		echo "</td></tr>\n";
	}
	$cm_pagenav = '<tr><tdcolspan="'.$colspan_c.'">&nbsp;</td></tr><tr><td colspan="'.$colspan_c.'"><hr/>'."\n";
	echo $cm_pagenav;
	writePagesLinksComment($limitstart_comment, $limit, $total, $ue_base_url);
	echo "</td></tr>\n";
	echo '<tr><td colspan="3" align="right">'."\n";

	if ($enhanced_Config['comment_allow_sign_own'] == '1') {
		echo "<a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$submitvalue&func=writeComment&index="._UE_PROFILE_COMMENTS_TAB_LABEL."\">"._UE_PROFILE_COMMENTS_TAB_WRITE_COMMENT."\n";
	}
	echo "</a></td></tr><tr><td>&nbsp;</td></tr> \n";
	echo "</table>\n";
}

function writeComment($Itemid_c, $option, $user, $submitvalue)
{
	global $user,$prof,$enhanced_Config,$userpr,$acl,$_POST,$_REQUEST,$mosConfig_live_site;

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	$cmtWordLimit = $enhanced_Config['comment_set_word_limit'];

	//Display Comment Submit Form
	echo '<table width="100%">';

	if ($my->id == 0)//not logged in
	{
		$MamboMe_Comment .= "<hr/>\n";
		$MamboMe_Comment .= "<tr><td>"._UE_PROFILE_COMMENTS_TAB_NOT_LOGIN."&nbsp;"._UE_PROFILE_COMMENTS_TAB_NO_ACCOUNT." <a href=\"index.php?option=com_cbe".$Itemid_c."&amp;task=registers\">"._UE_CREATE_ACCOUNT."</a>.</td></tr>\n";
	}

	elseif ($my->id)//logged in
	{

		if ($enhanced_Config['comment_use_bbc_code']==1) //Use bbc code?
		{
			$MamboMe_Comment = "<br/>\n";
			$MamboMe_Comment .= "<tr><td>"._UE_PROFILE_COMMENTS_TAB_BBC_CODE_LEGEND."</td></tr>\n";
			$MamboMe_Comment .= "<tr><td>"._UE_PROFILE_COMMENTS_TAB_BBC_CODE_BOLD."&nbsp;&nbsp;[b]"._UE_PROFILE_COMMENTS_TAB_BBC_CODE_TEXT."[/b]&nbsp;"._UE_PROFILE_COMMENTS_TAB_BBC_CODE_ITALICS."&nbsp;&nbsp;[i]"._UE_PROFILE_COMMENTS_TAB_BBC_CODE_TEXT."[/i]&nbsp;"._UE_PROFILE_COMMENTS_TAB_BBC_CODE_UNDERLINE."&nbsp;&nbsp;[u]"._UE_PROFILE_COMMENTS_TAB_BBC_CODE_TEXT."[/u]</td></tr>\n";
			$MamboMe_Comment .= "<br/>\n";
		}

		if ($enhanced_Config['comment_use_emoticons']==1) //if use emoticons, show emoticon table
		{

			$MamboMe_Comment .= "<tr><td><form method=\"post\" name=\"post\" action=\"index.php?option=com_cbe".$Itemid_c."&func=submitComment\"return document.MM_returnValue\"></td></tr>\n";
			$MamboMe_Comment .= "<tr><td><textarea name=\"comment\" class=\"inputbox\" rows=\"4\" cols=\"35\" wrap=\"virtual\" onselect=\"storeCaret(this);\" onclick=\"storeCaret(this);\" onkeyup=\"storeCaret(this);\" onKeyDown=\"limitText(this.form.comment,this.form.cmtcountdown,$cmtWordLimit);\" onKeyUp=\"limitText(this.form.comment,this.form.cmtcountdown,$cmtWordLimit);\"></textarea></td></tr>\n";
			$MamboMe_Comment .= "<tr><td><font size=\"1\">("._UE_WORD_LIMIT_MAXIMUM_CHAR."&nbsp;$cmtWordLimit)<br>"._UE_WORD_LIMIT_YOU_HAVE."&nbsp;<input readonly type=\"text\" name=\"cmtcountdown\" size=\"3\" value=\"$cmtWordLimit\">&nbsp;"._UE_WORD_LIMIT_CHAR_LEFT."</font></td></tr>";
			$MamboMe_Comment .= "</table>\n";
			$MamboMe_Comment .= ShowEmoticonsTable(2);
			$MamboMe_Comment .= "<table width=\"100%\" cellspacing=\"0\" cellpadding\"0\">\n";
		}
		else
		{
			$MamboMe_Comment = "<tr><td><form action=\"index.php?option=com_cbe".$Itemid_c."&func=submitComment\" method=\"post\" name=\"comment\"></td></tr>\n";
			$MamboMe_Comment .= "<tr><td><textarea name=\"comment\" class=\"inputbox\" rows=\"4\" cols=\"35\" wrap=\"virtual\" onKeyDown=\"limitText(this.form.comment,this.form.cmtcountdown,$cmtWordLimit);\" onKeyUp=\"limitText(this.form.comment,this.form.cmtcountdown,$cmtWordLimit);\"></textarea></td></tr>\n";
			$MamboMe_Comment .= "<tr><td><font size=\"1\">("._UE_COMMENT_WORD_LIMIT_MAXIMUM_CHAR."&nbsp;$cmtWordLimit)<br>"._UE_COMMENT_WORD_LIMIT_YOU_HAVE."&nbsp;<input readonly type=\"text\" name=\"cmtcountdown\" size=\"3\" value=\"$cmtWordLimit\">&nbsp;"._UE_COMMENT_WORD_LIMIT_CHAR_LEFT."</font></td></tr>";
			//$MamboMe_Comment .= "</table>\n";
		}

		$MamboMe_Comment .= "<tr><td><input type=\"hidden\" name=\"userid\" value=\"$submitvalue\" /></td></tr>\n";
		$MamboMe_Comment .= "<tr><td><input type=\"submit\" name=\"submit\" class=\"button\" value=\"Submit\" onclick=\"return confirm('"._UE_PROFILE_COMMENTS_TAB_SUBMIT."')\"></td></tr>\n";
		$MamboMe_Comment .= "</form>\n";
	}

	//go back link
	$MamboMe_Comment .= "<tr><td colspan=\"3\" align=\"right\"><a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$submitvalue&func=comments&index="._UE_PROFILE_COMMENTS_TAB_LABEL."\">"._UE_PROFILE_COMMENTS_TAB_WRITE_BACK."</a></td></tr>";	// Base URL string

	echo $MamboMe_Comment.'</table>';
}
?>