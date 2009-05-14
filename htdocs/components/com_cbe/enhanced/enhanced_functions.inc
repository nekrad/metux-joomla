<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
//********************************************
// MamboMe Enhanced Functions                *
// Copyright (c) 2005 Jeffrey Randall        *
// 02-05-2005 http://mambome.com             *
// Released under the GNU/GPL License        *
// Version 1.2  File date: 27-05-2005        *
//********************************************

function profileColors($bgcolor)
{
	if($bgcolor==getLangEnDefinition(_UE_PROFILE_COLOR_BLUE))
	$profileColor='#0000FF';//blue

	elseif($bgcolor==getLangEnDefinition(_UE_PROFILE_COLOR_GREEN))
	$profileColor='#008000';//Green

	elseif($bgcolor==getLangEnDefinition(_UE_PROFILE_COLOR_PINK))
	$profileColor='#E3007B';//Pink

	elseif($bgcolor==getLangEnDefinition(_UE_PROFILE_COLOR_RED))
	$profileColor='#FF0000';//Red

	elseif($bgcolor==getLangEnDefinition(_UE_PROFILE_COLOR_ORANGE))
	$profileColor='#EF9C00';//Orange

	elseif($bgcolor==getLangEnDefinition(_UE_PROFILE_COLOR_YELLOW))
	$profileColor='#FFFF00';//Yellow

	elseif($bgcolor==getLangEnDefinition(_UE_PROFILE_COLOR_BLACK))
	$profileColor='#000000';//Black

	elseif($bgcolor==getLangEnDefinition(_UE_PROFILE_COLOR_LIME))
	$profileColor='#00FF00';//Lime

	elseif($bgcolor==getLangEnDefinition(_UE_PROFILE_COLOR_FUCHIA))
	$profileColor='#FF00FF';//Fuchia

	elseif($bgcolor==getLangEnDefinition(_UE_PROFILE_COLOR_NAVY))
	$profileColor='#000080';//Navy

	elseif($bgcolor==getLangEnDefinition(_UE_PROFILE_COLOR_PURPLE))
	$profileColor='#800080';//Purple

	elseif($bgcolor==getLangEnDefinition(_UE_PROFILE_COLOR_MAROON))
	$profileColor='#800000';//Maroon

	elseif($bgcolor==getLangEnDefinition(_UE_PROFILE_COLOR_TEAL))
	$profileColor='#008080';//Teal

	elseif($bgcolor==getLangEnDefinition(_UE_PROFILE_COLOR_AQUA))
	$profileColor='#00FFFF';//Aqua

	elseif($bgcolor==getLangEnDefinition(_UE_PROFILE_COLOR_OLIVE))
	$profileColor='#808000';//Olive

	elseif($bgcolor==getLangEnDefinition(_UE_PROFILE_COLOR_SILVER))
	$profileColor='#C0C0C0';//Silver

	elseif($bgcolor==getLangEnDefinition(_UE_PROFILE_COLOR_GREY))
	$profileColor='#808080';//Grey

	elseif($bgcolor==getLangEnDefinition(_UE_PROFILE_COLOR_WHITE))
	$profileColor='#FFFFFF';//White

	return $profileColor;
}

function ShowEmoticonsTable($fn_type)
{
	$Smile_Directory ='components/com_cbe/enhanced/images/smiles';

	if ($fn_type == 1)
	{
		$java_script_function = "gb";
	}
	elseif ($fn_type == 2)
	{
		$java_script_function = "emoticon";
	}
	elseif ($fn_type == 3)
	{
		$java_script_function = "messenger";
	}
	elseif ($fn_type == 4)
	{
		$java_script_function = "messenger_reply";
	}

	$showEmoticon = "<table \"cellspacing=\"0\" cellpadding\"0\">\n";
	$showEmoticon .= "<tr><td width=\"5\"><a href=\"javascript:$java_script_function(':D')\"><img title=\"Very Happy\" src=\"$Smile_Directory/biggrin.gif\" alt=\"Very Happy\" border=\"0\" /></a></td>\n";
	$showEmoticon .= "<td width=\"5\"><a href=\"javascript:$java_script_function(':)')\"><img title=\"Smile\" src=\"$Smile_Directory/smile.gif\" alt=\"Smile\" border=\"0\" /></a></td>\n";
	$showEmoticon .= "<td width=\"5\"><a href=\"javascript:$java_script_function(':shock:')\"><img title=\"Shock\" src=\"$Smile_Directory/eek.gif\" alt=\"Shock\" border=\"0\" /></a></td>\n";
	$showEmoticon .= "<td width=\"5\"><a href=\"javascript:$java_script_function(':cry:')\"><img title=\"Cry\" src=\"$Smile_Directory/cry.gif\" alt=\"Cry\" border=\"0\" /></a></td>\n";
	$showEmoticon .= "<td width=\"5\"><a href=\"javascript:$java_script_function(':x')\"><img title=\"Mad\" src=\"$Smile_Directory/mad.gif\" alt=\"Mad\" border=\"0\" /></a></td>\n";
	$showEmoticon .= "<td width=\"5\"><a href=\"javascript:$java_script_function(':lol:')\"><img title=\"lol\" src=\"$Smile_Directory/lol.gif\" alt=\"lol\" border=\"0\" /></a></td>\n";
	$showEmoticon .= "<td width=\"5\"><a href=\"javascript:$java_script_function('8)')\"><img title=\"Cool\" src=\"$Smile_Directory/cool.gif\" alt=\"Cool\" border=\"0\" /></a></td>\n";
	$showEmoticon .= "<td width=\"5\"><a href=\"javascript:$java_script_function(':roll:')\"><img title=\"Roll Eyes\" src=\"$Smile_Directory/rolleyes.gif\" alt=\"Rolling Eyes\" border=\"0\" /></a></td>\n";
	$showEmoticon .= "<td width=\"5\"><a href=\"javascript:$java_script_function(':wink:')\"><img title=\"Wink\" src=\"$Smile_Directory/wink.gif\" alt=\"Wink\" border=\"0\" /></a></td>\n";
	$showEmoticon .= "<td width=\"5\"><a href=\"javascript:$java_script_function(':!:')\"><img title=\"Exclamation\" src=\"$Smile_Directory/exclaim.gif\" alt=\"Exclamation\" border=\"0\" /></a></td>\n";
	$showEmoticon .= "<td width=\"5\"><a href=\"javascript:$java_script_function(':?:')\"><img title=\"Question\" src=\"$Smile_Directory/question.gif\" alt=\"Question\" border=\"0\" /></a></td>\n";
	$showEmoticon .= "<td width=\"5\"><a href=\"javascript:$java_script_function(':idea:')\"><img title=\"Idea\" src=\"$Smile_Directory/idea.gif\" alt=\"Idea\" border=\"0\" /></a></td>\n";
	$showEmoticon .= "<td width=\"5\"><a href=\"javascript:$java_script_function(':(')\"><img title=\"Sad\" src=\"$Smile_Directory/sad.gif\" alt=\"Sad\" border=\"0\" /></a></td></tr>\n";
	$showEmoticon .= "</table>\n";

	return $showEmoticon;
}

function emoticonConvert($emoticon)
{
	$Smile_Directory ='components/com_cbe/enhanced/images/smiles';

	$emoticon = str_replace(":D", "<img title=\"Very Happy\" src=\"$Smile_Directory/biggrin.gif\" alt=\"Very Happy\" border=\"0\" />","$emoticon");
	$emoticon = str_replace(":)", "<img title=\"Smile\" src=\"$Smile_Directory/smile.gif\" alt=\"Smile\" border=\"0\" />","$emoticon");
	$emoticon = str_replace(":shock:", "<img title=\"Shock\" src=\"$Smile_Directory/eek.gif\" alt=\"Shock\" border=\"0\" />","$emoticon");
	$emoticon = str_replace(":cry:", "<img title=\"Cry\" src=\"$Smile_Directory/cry.gif\" alt=\"Cry\" border=\"0\" />","$emoticon");
	$emoticon = str_replace(":x", "<img title=\"Mad\" src=\"$Smile_Directory/mad.gif\" alt=\"Mad\" border=\"0\" />","$emoticon");
	$emoticon = str_replace(":lol:", "<img title=\"lol\" src=\"$Smile_Directory/lol.gif\" alt=\"lol\" border=\"0\" />","$emoticon");
	$emoticon = str_replace("8)", "<img title=\"Cool\" src=\"$Smile_Directory/cool.gif\" alt=\"Cool\" border=\"0\" />","$emoticon");
	$emoticon = str_replace(":roll:", "<img title=\"Roll Eyes\" src=\"$Smile_Directory/rolleyes.gif\" alt=\"Rolling Eyes\" border=\"0\" />","$emoticon");
	$emoticon = str_replace(":(", "<img title=\"Sad\" src=\"$Smile_Directory/sad.gif\" alt=\"Sad\" border=\"0\" />","$emoticon");
	$emoticon = str_replace(":wink:", "<img title=\"Wink\" src=\"$Smile_Directory/wink.gif\" alt=\"Wink\" border=\"0\" />","$emoticon");
	$emoticon = str_replace(":!:", "<img title=\"Exclamation\" src=\"$Smile_Directory/exclaim.gif\" alt=\"Exclaim\" border=\"0\" />","$emoticon");
	$emoticon = str_replace(":?:", "<img title=\"Question\" src=\"$Smile_Directory/question.gif\" alt=\"Question\" border=\"0\" />","$emoticon");
	$emoticon = str_replace(":idea:", "<img title=\"Idea\" src=\"$Smile_Directory/idea.gif\" alt=\"Idea\" border=\"0\" />","$emoticon");

	return $emoticon;
}

function bbcConvert($bbc)
{

	$bbc = str_replace("[b]", "<b>", "$bbc");
	$bbc = str_replace("[/b]", "</b>", "$bbc");
	$bbc = str_replace("[i]", "<i>", "$bbc");
	$bbc = str_replace("[/i]", "</i>", "$bbc");
	$bbc = str_replace("[u]", "<u>", "$bbc");
	$bbc = str_replace("[/u]", "</u>", "$bbc");
	$bbc = str_replace("[img]", "<img src=\"", "$bbc");
	$bbc = str_replace("[/img]", "\" />", "$bbc");

	return $bbc;
}

//sendPM function will check whether integrated with PMS or PMS PRO
function sendUserPM($userid,$whofrom,$subject,$message)
{
	global $ueConfig,$my,$enhanced_Config;

	$database = &JFactory::getDBO();
	if ($ueConfig=='') {
                include(JPATH_SITE."/administrator/components/com_cbe/ue_config.php");
        }

	$time = date('H:i:s');
	$date = date('Y-m-d');
	//username
	$database->setQuery( "SELECT username FROM #__users WHERE id='".$userid."'");
	$username = $database->loadResult();
	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()." - u.1'); window.history.go(-1); </script>\n";
		exit();
	}
	if ( $ueConfig['pms'] != '0' ) {
		
		if($ueConfig['pms']=='1') {
			// MyPMS-OS 2.1x
			$inspms = "INSERT INTO #__pms (id,groupname,username,whofrom,date,time,readstate,subject,message) VALUES ('','','$username','$whofrom','$date','$time','','$subject','$message')";
		} else if($ueConfig['pms']=='2') {
			// MyPMS-PRO
			$inspms = "INSERT INTO #__mypms (id,username,whofrom,time,readstate,subject,message) VALUES ('','$username','$whofrom','$date $time','','$subject','$message')";
		} else if($ueConfig['pms']=='3') {
			// MyPMS-OS 2.5 alpha or higher
			$date_time = $date." ".$time;
			$inspms = "INSERT INTO #__pms (id,username,whofrom,date,readstate,subject,message) VALUES ('','$username','$whofrom','$date_time','','$subject','$message')";
		} else if($ueConfig['pms']=='4') {
			// MyPMS-OSenhanced 1.2.x or higher
			$inspms = "INSERT INTO #__pms (id,username,whofrom,date,time,readstate,subject,message,inbox,sent_items) VALUES ('','$username','$whofrom','$date','$time','','$subject','$message','1','')";
		} else if($ueConfig['pms']=='9') {
			// MyPMS-OSenhanced 2.x or higher
			$query_uid = "SELECT id FROM #__users WHERE username='$whofrom'";
			$database->setQuery($query_uid);
			$uid_result=$database->loadResult();
			if ($uid_result == '') {
				$query_msgbot_id = "SELECT id from #__users WHERE usertype='CBE-MSG-BOT' ORDER by id ASC LIMIT 1";
				$database->setQuery($query_msgbot_id);
				$savefromid=$database->loadResult();
				if (!$savefromid || $savefromid =='0') {
					$query_msgbot_id = "SELECT id from #__users WHERE usertype='Super Administrator' ORDER by id ASC LIMIT 1";
					$database->setQuery($query_msgbot_id);
					$savefromid=$database->loadResult();
					if (!$savefromid || $savefromid =='0') {
						$savefromid=62; // replace XX with admin user ID
					}
				}
			} else {
				$savefromid = $uid_result;
			}
			$uid_sender = $savefromid;

			$message = str_replace( '<a href="', '[url=', $message);
			$message = str_replace( '">', ']', $message);
			$message = str_replace( '</a>', '[/url]', $message);

			$inspms = "INSERT INTO #__pms (recip_id,sender_id,date,time,readstate,subject,message) VALUES ('$userid','$uid_sender','$date','$time','0','$subject','$message')";
		} else if($ueConfig['pms']=='5') {
			// uddeIM 0.4 or higher
			$savedate=time();
			$message = str_replace( '<a href="', '[url=', $message);
			$message = str_replace( '">', ']', $message);
			$message = str_replace( '</a>', '[/url]', $message);
			$savemessage=$subject.":\n\n".$message;
				$query_uid = "SELECT id FROM #__users WHERE username='$whofrom'";
				$database->setQuery($query_uid);
				$uid_result=$database->loadResult();
			if ($uid_result == '') {
				$query_super_id = "SELECT id from #__users WHERE usertype='Super Administrator' ORDER by id ASC LIMIT 1";
				$database->setQuery($query_super_id);
				$savefromid=$database->loadResult();
				if (!$savefromid || $savefromid =='0') {
					$savefromid=62; // replace XX with admin user ID
				}
				$inspms="INSERT INTO #__uddeim (fromid, toid, message, datum, disablereply, systemmessage) VALUES (".$savefromid.", ".$userid.", '".$savemessage."', ".$savedate.", '1', 'System')";
			} else {
				$savefromid=$uid_result;
				$inspms="INSERT INTO #__uddeim (fromid, toid, message, datum) VALUES (".$savefromid.", ".$userid.", '".$savemessage."', ".$savedate.")";
			}
		} else if ($ueConfig['pms']=='6') {
			// Missus 1.0 beta2
			$query_missus = "INSERT INTO #__missus (sendername,sendermail,datesended,subject,message,broadcast) VALUES ('$whofrom', '', '".date("Y-m-d H:i:s")."', '$subject', '$message', '0')"; 
			$database->setQuery( $query_missus );
			if (!$database->query()) { 
				echo "<script> alert('".$database->getErrorMsg()." - mi.1'); window.history.go(-1); </script>\n"; 
			}
			$missus_msgid = $database->insertid();
			$query_missus_recip = "INSERT INTO #__missus_receipt (id,receptorid) VALUES ('".$missus_msgid."', '".$userid."')";
			$database->setQuery( $query_missus_recip );
			if (!$database->query()) { 
				echo "<script> alert('".$database->getErrorMsg()." - mi.2'); window.history.go(-1); </script>\n"; 
			}
			$inspms = "SELECT username FROM #__users WHERE id='".$userid."'";
		} else if ($ueConfig['pms']=='7') {
			// Clexus 1.2.1 and higher
			
			if ($enhanced_Config['buddylist_sender'] != '0') {
				$query_uid = "SELECT id FROM #__users WHERE username='$whofrom'";
				$database->setQuery($query_uid);
				$uid_result=$database->loadResult();
				$whofrom = $uid_result;
			} else {
				$query_super_id = "SELECT id from #__users WHERE usertype='Super Administrator' ORDER by id ASC LIMIT 1";
				$database->setQuery($query_super_id);
				$savefromid=$database->loadResult();
				if (!$savefromid || $savefromid =='0') {
					$savefromid=62; // replace XX with admin user ID
				}
				$whofrom = $savefromid;
			}
			$s_ip = $_SERVER['REMOTE_ADDR'];
			$database->setquery("SELECT MAX(sent_id)+1 FROM #__mypms");
			$sent_id = $database->loadResult();
			
			$query_clexus = "INSERT INTO #__mypms (id,userid,whofrom,time,readstate,subject,message,owner,sent_id,ip) "
					."VALUES ('','$userid','$whofrom','$date $time','0','$subject','$message','$whofrom','$sent_id','$s_ip')";
			$database->setQuery( $query_clexus );
			if (!$database->query()) { 
				echo "<script> alert('".$database->getErrorMsg()." - mi.1'); window.history.go(-1); </script>\n"; 
			}
			
			$query_clex_s = "INSERT INTO #__mypms_sent (id,userid,whofrom,time,readstate,subject,message,owner) "
					."VALUES ('','$userid','$whofrom','$date $time','0','$subject','$message','$whofrom')";
			$database->setQuery( $query_clex_s );
			if (!$database->query()) { 
				echo "<script> alert('".$database->getErrorMsg()." - mi.1'); window.history.go(-1); </script>\n"; 
			}
			$inspms = "SELECT username FROM #__users WHERE id='".$userid."'";
		} else if ($ueConfig['pms']=='8') {
			// Jim 1.0.1 or higher / username
			
			$to = $username;
			$sub = $subject;
			$msg = $message;
			$inspms = "INSERT INTO #__jim (username,whofrom,date,readstate,subject,message) VALUES('"
			     .$to."','".$from."',NOW(),0,'".$sub."','".$msg."');";
		}

		$database->setQuery($inspms);
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()." -- ma.2'); window.history.go(-1); </script>\n";
			exit();
		}
	}

}

function language_filter($string)
{
	$database = &JFactory::getDBO();
	$query = "SELECT badword
			  FROM #__cbe_bad_words 
			  WHERE published=1";
	$database->setQuery($query);
	$obscenities = $database->loadObjectList();

	foreach($obscenities as $curse_word)
	{
		if(stristr(trim($string),$curse_word->badword))
		{
			$length=strlen($curse_word->badword);
			$stars = '';
			for($i=1;$i<=$length;$i++)
			{
				$stars .= "*";
			}
			$string=eregi_replace($curse_word->badword,$stars,trim($string));
			$stars="";
		}
	}
	return $string;
}

function unRegister($option, $uid, $submitvalue)
{
	global $ueConfig;

	if ($ueConfig['user_unregister_allow']==1)
	{
	?>

  <p><?php echo _UE_USER_UNREGISTER_DESCRIPTION; ?></p><br/>

<table>
  <form action="index.php?option=com_cbe&task=deleteUser" method="post" name="unregister">	
  <tr>
    <td width="50%" align="left"><b><?php echo _UE_USER_UNREGISTER_PASSWORD; ?></b></td>
    <td><input type="text" name="password_a"></td>
  </tr>
  <tr>
    <td width="50%" align="left"><b><?php echo _UE_USER_UNREGISTER_PASSWORD_VERIFY; ?></b></td>
    <td><input type="text" name="password_b"></td>
  </tr>
  <tr>
    <td colspan="2" align="left">
     <?php echo "<input type=\"hidden\" name=\"userid\" value=\"$uid\" />";
     echo "<input type=\"submit\" value='"._UE_USER_UNREGISTER_UNREGISTER."' onclick=\"return confirm('"._UE_USER_UNREGISTER_CONFIRM."')\">";
      ?>
    </td>
  </tr>
  </form>
</table>
<?php
	}
}

//delete user comming soon! need to add security question.
function deleteUser($option, $uid, $submitvalue)
{
	global $my,$mainframe,$ueConfig,$_POST,$_REQUEST,$mosConfig_absolute_path;

	$database = &JFactory::getDBO();
	$acl = &JFactory::getACL();
	
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

	if ($ueConfig['user_unregister_allow']==1)
	{
		if ($uid == 0 || $uid != $_POST['userid'])
		{
			echo JText::_(ALERTNOTAUTH);
			return;
		}

		$password_a = JRequest::getVar('password_a','');
		$password_b = JRequest::getVar('password_b','');

		if($password_a !=$password_b)
		{
			echo _UE_USER_UNREGISTER_PASSWORDS_NO_MATCH.'<br/>';
			echo _UE_USER_UNREGISTER_REDIRECT;
		     ?>
<script language="javascript">
setTimeout("location='index.php?option=com_cbe&task=unRegister'",3000);
</script>
      <?php
		}
		else
		{

			$query = "SELECT *
		  		  	  FROM #__users 
		  		  	  WHERE (id = $uid)";
			$database->setQuery($query);
			$data = null;
			$data= $database->loadObject();
			$password = $data->password;

			if (md5($password_a) != $password)
			{
				echo _UE_USER_UNREGISTER_PASSWORD_INCORRECT.'<br/>';
				echo _UE_USER_UNREGISTER_REDIRECT;
					     ?>
<script language="javascript">
setTimeout("location='index.php?option=com_cbe&task=unRegister'",3000);
</script>
      <?php
			}
			else
			{
				// obj = new mosUser($database);
				$obj = new JTableUser( $database );
				//$obj2 = new moscbe( $database );
				$obj2 = $obj;
				$obj2->load($uid);

				$id = $uid;
				// check for a super admin ... can't delete them
				$groups = $acl->get_object_groups( 'users', $id, 'ARO' );
				$this_group = strtolower( $acl->get_group_name( $groups[0], 'ARO' ) );
				if ($this_group == 'super administrator') {
					$message .= _UE_USER_UNREGISTER_SUPERADMIN;
				} else {
					// delete Avatar
					if(eregi("gallery/",$obj2->avatar)==false && is_file(JPATH_SITE."/images/cbe/".$obj2->avatar)) {
						unlink(JPATH_SITE."/images/cbe/".$obj2->avatar);
						if(is_file(JPATH_SITE."/images/cbe/tn".$obj2->avatar)) unlink(JPATH_SITE."/images/cbe/tn".$obj2->avatar);
					}

					$query_all = "SELECT u.username, u.name, u.email, c.* FROM #__users as u, #__cbe as c WHERE u.id=c.user_id AND u.id='".$uid."'";
					$database->setQuery($query_all);
					$old_user = $database->loadObjectList();
					$old_user = $old_user[0];

					$obj->delete( $id );
					$obj2->delete( $id );
					$message .= $obj->getError();
					$message .= $obj2->getError();
					$database->setQuery("DELETE FROM #__cbe_buddylist WHERE buddyid='$id' OR userid='$id'");
					if (!$database->query()) {
//						$msg .= "Buddylist entries could not be deleted, maybe there are no.<br>\n";
					}
					$database->setQuery("DELETE FROM #__cbe_mambobe_gbook WHERE by_user='$id' OR userid='$id'");
					if (!$database->query()) {
//						$msg .= "Guestbook entries could not be deleted, maybe there are no.<br>\n";
					}
					$database->setQuery("DELETE FROM #__cbe_mambobe_journal WHERE userid='$id'");
					if (!$database->query()) {
//						$msg .= "Journal entries could not be deleted, maybe there are no.<br>\n";
					}
					$database->setQuery("DELETE FROM #__cbe_profile_comments WHERE by_user='$id' OR userid='$id'");
					if (!$database->query()) {
//						$msg .= "Comment entries could not be deleted, maybe there are no.<br>\n";
					}
					$database->setQuery("DELETE FROM #__cbe_ratings WHERE profile='$id'");
					if (!$database->query()) {
//						$msg .= "Rating entry could not be deleted, maybe there are no.<br>\n";
					}
					$database->setQuery("DELETE FROM #__cbe_testimonials WHERE by_user='$id' OR userid='$id'");
					if (!$database->query()) {
//						$msg .= "Testimonials entries could not be deleted, maybe there are no.<br>\n";
					}
					$database->setQuery("DELETE FROM #__cbe_userreports WHERE reporteduser='$id' OR reportedbyuser='$id'");
					if (!$database->query()) {
//						$msg .= "UserReport entries could not be deleted, maybe there are no.<br>\n";
					}
					$database->setQuery("DELETE FROM #__cbe_lastvisitor WHERE uid='$id' OR visitor='$id'");
					if (!$database->query()) {
//						$msg .= "LastVisitor entries could not be deleted, maybe there are no.<br>\n";
					}
					$database->setQuery("DELETE FROM #__cbe_userstime WHERE userid='$id'");
					if (!$database->query()) {
//						$msg .= "TopMostUser data could not be deleted, maybe there are no.<br>\n";
					}
					$database->setQuery("DELETE FROM #__cbe_geodata WHERE uid='$id'");
					if (!$database->query()) {
//						$msg .= "GeoCoder data could not be deleted, maybe there are no.<br>\n";
					}

// old query				}

					//Delete sb forum user
					$query = "SELECT userid
				  		  	  FROM #__sb_users 
				  		  	  WHERE (userid = $uid)";
					$database->setQuery($query);
					if($database->query())
					{
						$query = "DELETE FROM #__sb_users
	      				  	  	  WHERE (userid = $uid)";	
						$database->setQuery($query);
						$database->query();
	
					}
					//Delete any SB forum subscriptions user has
					$query = "SELECT userid
				  		  	  FROM #__sb_subscriptions 
				  		  	  WHERE (userid = $uid)";
					$database->setQuery($query);
					if($database->query())
					{
						$sb_subscriptions = $database->loadObjectList();
						if (count($sb_subscriptions) > 0)
						{
							foreach ($sb_subscriptions as $sb_subscription)
							{
								$query = "DELETE FROM #__sb_subscriptions
	      				  	  	  		  WHERE (userid = $uid)";	
								$database->setQuery($query);
								$database->query();
							}
						}
					}
					//remove users moderation from sb forum
					$query = "SELECT userid
				  		  	  FROM #__sb_moderation 
				  		  	  WHERE (userid = $uid)";
					$database->setQuery($query);
					if($database->query())
					{
						$sb_moderators = $database->loadObjectList();
						if (count($sb_moderators) > 0)
						{
							foreach ($sb_moderators as $sb_moderator)
							{
								$query = "DELETE FROM #__sb_moderation
	      				  	  	  		  WHERE (userid = $uid)";	
								$database->setQuery($query);
								$database->query();
							}
						}
					}
					//Delete user authorlist
					$query = "SELECT *
				  		  	  FROM #__cbe_authorlist
				  		  	  WHERE (userid = $uid)";
					$database->setQuery($query);
					$authors = $database->loadObjectList();
					if (count($authors) > 0)
					{
						foreach ($authors as $author)
						{
							$query = "DELETE FROM #__cbe_authorlist
								  	  WHERE userid=$uid";
							$database->setQuery($query);
							$database->query();
						}
					}

					$mainframe->logout();
					$message = _UE_USER_UNREGISTER_UNREGISTERED;
//Mail to User and Admin

					if ($ueConfig['unregister_send_email']=='1') {
						createEmail($old_user,'unregisterUser',$ueConfig);
						$emailType='unregisterAdmin';
					}
					
					if ($ueConfig['unregister_moderatorEmail']=='1') {
						$emailType='unregisterAdmin';
						$database->setQuery( "SELECT name, email, u.id as uid FROM #__users u, #__cbe c "
						."\n WHERE u.id=c.id AND u.gid >='".$ueConfig['imageApproverGid']."' AND u.block=0 AND u.sendEmail='1' AND c.confirmed=1 AND c.approved=1" );
						$rowAdmins = $database->loadObjectList();
						foreach ($rowAdmins AS $rowAdmin) {
							$isModerator=isModerator($rowAdmin->uid);
							if ($isModerator==1) {
								createEmail($old_user,$emailType,$ueConfig,$rowAdmin);
							}
						}
					}
					
// Mail end
				}
			}
		}
		echo $message;
	}
}

function date_iso2unix($dstr) {
	$i = preg_split("/[^0-9]/", $dstr);
	return mktime($i[3], $i[4], $i[5], $i[1], $i[2], $i[0]);
}

function cb_user_age($somedate,$nowtime) {
	$tmpdate = $somedate;
	$tmp_ntime = $nowtime;
	$date_u = strtotime($tmpdate);

	if ($tmpdate != '0000-00-00') {
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
	
	//$age = "(".$a_age.")";
	$age = " ".$a_age." ";
	return $age;
	// $age => String in the form of (21)
}
?>