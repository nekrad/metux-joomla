<?php
//********************************************
// Testimonials Tab By Jeffrey Randall       *
// Copyright (c) 2005 Jeffrey Randall        *
// 10-03-2005 http://mambome.com             *
// Released under the GNU/GPL License        *
// Version 1.3     File date: 16-05-2005     *
//********************************************

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $mosConfig_lang;

include_once('components/com_cbe/enhanced/enhanced.js');
include_once('components/com_cbe/enhanced/enhanced_functions.inc');

if (file_exists('components/com_cbe/enhanced/testimonials/language/'.$mosConfig_lang.'.php'))
{
	include_once('components/com_cbe/enhanced/testimonials/language/'.$mosConfig_lang.'.php');
}
else
{
	include_once('components/com_cbe/enhanced/testimonials/language/english.php');
}

include_once('administrator/components/com_cbe/enhanced_admin/enhanced_config.php');

if ($GLOBALS['Itemid_com']!='') {
	$Itemid_c = $GLOBALS['Itemid_com'];
} else {
	$Itemid_c = '';
}

$func=JRequest::getVar('func', 'testimonials' );
$prof=JRequest::getVar('prof','');

$testimonial=JRequest::getVar('testimonials','');
$testimonial_id=JRequest::getVar('testimonial_id','');


switch ($func)
{
	case "deleteTestimonial":
	deleteTestimonial($Itemid_c, $option, $my->id, $testimonial_id, $prof, _UE_UPDATE);
	break;

	case "pubTestimonial":
	pubTestimonial($Itemid_c, $option, $my->id, $testimonial_id, $prof, _UE_UPDATE);
	break;

	case "unpubTestimonial":
	unpubTestimonial($Itemid_c, $option, $my->id, $testimonial_id, $prof, _UE_UPDATE);
	break;

	case "submitTestimonial":
	submitTestimonial($Itemid_c, $option, $my->id, _UE_UPDATE);
	break;

	case "signTestimonial":
	signTestimonial($Itemid_c, $option, $my->id, $user->id, _UE_UPDATE);
	break;

	default:
	testimonials($Itemid_c, $option, $my->id, $user->id, _UE_UPDATE);
	break;
}

function deleteTestimonial($Itemid_c, $option, $uid, $testimonial_id, $prof)
{
	global $mainframe;
	$database = &JFactory::getDBO();

	if ($uid == 0)
	{
		echo JText::_(ALERTNOTAUTH);
		return;
	}
	$query = "DELETE FROM #__cbe_testimonials
			  WHERE id='".$testimonial_id."'";
	$database->setQuery($query);

	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$mainframe->redirect("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$prof."&func=testimonials&index="._UE_TESTIMONIAL_TAB_LABEL."");
}
function unpubTestimonial($Itemid_c, $option, $uid, $submitvalue,$prof)
{
	global $mainframe;
	$database = &JFactory::getDBO();

	if ($uid == 0)
	{
		echo JText::_(ALERTNOTAUTH);
		return;
	}

	$query = "UPDATE #__cbe_testimonials
			  SET approved=0 
			  WHERE id='".$submitvalue."'";
	$database->setQuery($query);

	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$mainframe->redirect("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$prof&func=testimonials&index="._UE_TESTIMONIAL_TAB_LABEL."");
}

function pubTestimonial($Itemid_c, $option, $uid, $submitvalue,$prof)
{
	global $database,$my,$user,$enhanced_Config, $mainframe;

	$database = &JFactory::getDBO();
	if ($uid == 0)
	{
		echo JText::_(ALERTNOTAUTH);
		return;
	}
	$query = "UPDATE #__cbe_testimonials
			  SET approved=1 
			  WHERE id='".$submitvalue."'";
	$database->setQuery($query);

	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if($enhanced_Config['use_pms_testimonial']==1)
	{
                $query = "SELECT by_user FROM #__cbe_testimonials WHERE id='".$submitvalue."'";
                $database->setQuery($query);
                $userid = $database->loadResult();
                //$userid= $submitvalue;
		//$userid= $user;
		$whofrom= _UE_TESTIMONIAL_PM_APP_WHOFROM;
		$subject= _UE_TESTIMONIAL_PM_APP_SUBJECT;
		$link ="<a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$my->id&func=testimonials&index="._UE_TESTIMONIAL_TAB_LABEL."\">";
		$message="".$my->username." has approved the testimonial you wrote. You can view the testimonial by clicking ".$link."here</a>";
		sendUserPM($userid,$whofrom,$subject,$message);

	}
	$mainframe->redirect("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$prof&func=testimonials&index="._UE_TESTIMONIAL_TAB_LABEL."");
}

function submitTestimonial($Itemid_c, $option, $uid, $submitvalue)
{
	global $my,$user,$enhanced_Config,$userpr,$testimonial,$acl,$_POST,$_REQUEST,$mosConfig_live_site, $mainframe;

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();
	(isset($_POST["testimonial"]) && !$testimonial) ? $testimonial  = JRequest::getVar ('testimonial' , '' ) : $testimonial = NULL ;
	$noHTMLText = strip_tags($testimonial);
	$noHTMLText = addslashes($noHTMLText);
	$time = date('H:i:s');
	$date = date('Y-m-d');

	if ($uid == 0)
	{
		echo JText::_(ALERTNOTAUTH);
		return;
	}

	$query = "INSERT INTO #__cbe_testimonials (userid,by_user,testimonial,datetime) VALUES ('$userpr','$my->id','$noHTMLText','$date.$time');";
	$database->setQuery( $query );

	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if($enhanced_Config['use_pms_testimonial']==1)
	{

		$userid="$userpr" ;
		$whofrom= _UE_TESTIMONIAL_PM_WHOFROM;
		$subject= _UE_TESTIMONIAL_PM_SUBJECT;
		$link ="<a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$userpr&func=testimonials&index="._UE_TESTIMONIAL_TAB_LABEL."\">";
		$message="".$my->username." has written a testmonial for you.<br /><br />This testimonial will not be viewable by other users until you visit the testimonial tab in your profile and click show. <br /><br />You can also choose to delete this testimonial.<br /><br />You can view the testimonial by clicking ".$link."here</a> ";
		sendUserPM($userid,$whofrom,$subject,$message);

	}
	$mainframe->redirect("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$userpr&func=testimonials&index="._UE_TESTIMONIAL_TAB_LABEL."");
}

function writePagesLinksTestimonials($limitstart_testimonials, $limit, $total,$ue_base_url)
{

	$pages_in_list = 10;

	$displayed_pages = $pages_in_list;
	$total_pages = ceil( $total / $limit );
	$this_page = ceil( ($limitstart_testimonials+1) / $limit );
	$start_loop = (floor(($this_page-1)/$displayed_pages))*$displayed_pages+1;
	if ($start_loop + $displayed_pages - 1 < $total_pages)
	{
		$stop_loop = $start_loop + $displayed_pages - 1;
	}
	else
	{
		$stop_loop = $total_pages;
	}

	if ($this_page > 1)
	{
		$page = ($this_page - 2) * $limit;
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_testimonials=0\" title=\"" . _UE_FIRST_PAGE . "\">&lt;&lt; " . _UE_FIRST_PAGE . "</a>";
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_testimonials=$page\" title=\"" . _UE_PREV_PAGE . "\">&lt; " . _UE_PREV_PAGE . "</a>";
	}
	else
	{
		echo '<span class="pagenav">&lt;&lt; '. _UE_FIRST_PAGE .'</span> ';
		echo '<span class="pagenav">&lt; '. _UE_PREV_PAGE .'</span> ';
	}

	for ($i=$start_loop; $i <= $stop_loop; $i++)
	{
		$page = ($i - 1) * $limit;
		if ($i == $this_page)
		{
			echo "\n <span class=\"pagenav\">$i</span> ";
		}
		else
		{
			echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_testimonials=$page\"><strong>$i</strong></a>";
		}
	}

	if ($this_page < $total_pages)
	{
		$page = $this_page * $limit;
		$end_page = ($total_pages-1) * $limit;
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_testimonials=$page\" title=\"" . _UE_NEXT_PAGE . "\">" . _UE_NEXT_PAGE . " &gt;</a>";
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_testimonials=$end_page\" title=\"" . _UE_END_PAGE . "\">" . _UE_END_PAGE . " &gt;&gt;</a>";
	}
	else
	{
		echo '<span class="pagenav">'. _UE_NEXT_PAGE .' &gt;</span> ';
		echo '<span class="pagenav">'. _UE_END_PAGE .' &gt;&gt;</span>';
	}
}
function testimonials($Itemid_c, $option, $my_id, $user_id, $submitvalue)
{
	global $my,$user,$prof,$limitstart_testimonials,$mosConfig_lang,$enhanced_Config,$mosConfig_live_site;

	$database = &JFactory::getDBO();
	$ue_base_url = "index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$user_id&func=testimonials&index="._UE_TESTIMONIAL_TAB_LABEL."";	// Base URL string

	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">";

	$TestimonialString = "\n<!-- MamboMe Testimonials System Copyright (c) Jeffrey Randall 2005 -->\n";
	$TestimonialString .= "<!-- Released under the GNU/GPL License http://www.gnu.org/copyleft/gpl.html-->\n";
	$TestimonialString .= "<!-- Visit http://mambome.com for more info -->\n\n";

	$query = "SELECT count(userid)
		   	  FROM #__cbe_testimonials 
		   	  WHERE by_user = '".$my_id."' 
		   	  AND userid = '".$user_id."'";
	$database ->setQuery ($query);
	$result = $database->loadResult();

//	echo " my_id ->".$my_id." ... user_id ->".$user_id." ---- Submit ->".$submitvalue." ..... Result ->".$result;

	//Display write testimonial link if not users own profile
	if($my_id != $user_id && $result=='0')
	{
	?>
	<tr><td colspan="3" align="right">
	<?php
	echo "<a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$user_id&func=signTestimonial&index="._UE_TESTIMONIAL_TAB_LABEL."\">"._UE_TESTIMONIAL_TAB_WRITE_TESTIMONIAL."\n";
	?>
	</a></td></tr><tr><td>&nbsp;</td></tr>
	<?php
	}

	$my = &JFactory::getUser();
	$is_admin = (strtolower($my->usertype) == 'editor' ||
	strtolower($my->usertype) == 'publisher' ||
	strtolower($my->usertype) == 'manager' ||
	strtolower($my->usertype) == 'administrator' ||
	strtolower($my->usertype) == 'super administrator' );

//	$datetime="jS F Y H:i:s"; //date format
	$datetime=$enhanced_Config['testimonials_timeformat'];

	$query1 = "SELECT userid
		   	   FROM #__cbe_testimonials 
		   	   WHERE userid = '".$user_id."'";
	$database ->setQuery ($query1);
	$result1 = $database->loadResult();

	$query_pub = "SELECT approved
			  	  FROM #__cbe_testimonials 
			  	  WHERE userid = '".$user_id."'";
	$database ->setQuery ($query_pub);
	$result_pub = $database->loadResult();



	if ($result > 0) //You have written a testimonial for user previously
	{
		$query = "SELECT username
			  	  FROM #__users 
			  	  WHERE id='".$user_id."'";
		$database->setQuery($query);
		$username = $database->loadResult();

		$TestimonialString .= "<tr><td colspan=\"3\">"._UE_TESTIMONIAL_TAB_PREVIOUS_A."&nbsp;$username&nbsp;"._UE_TESTIMONIAL_TAB_PREVIOUS_B."</td></tr><tr>\n<td>&nbsp;</td></tr>\n";
	}

	if($my->id==$user_id && $result1 !=0)
	{
		$TestimonialString .= "<tr><th align=\"left\">"._UE_TESTIMONIAL_TAB_HEADER_OPTION."</th><th align=\"left\">"._UE_TESTIMONIAL_TAB_HEADER_FROM."</th><th align=\"left\">"._UE_TESTIMONIAL_TAB_HEADER_TESTIMONIAL."</th></tr>";
	}

	elseif($my->id !=$user_id && $result_pub ==1)
	{
		$TestimonialString .= "<tr><th align=\"left\">"._UE_TESTIMONIAL_TAB_HEADER_FROM."</th><th align=\"left\">"._UE_TESTIMONIAL_TAB_HEADER_TESTIMONIAL."</th></tr>";
	}

	elseif($result1 == 0 && $my->id == $user_id) // you are logged in and have no testimonials
	{
		$TestimonialString.= "<tr><td>"._UE_TESTIMONIAL_TAB_MY_NONE."</td></tr>";
	}
	elseif($result1 == 0 && $my->id != $user_id) // you are logged in and user profile you are viewing has no testimonials
	{
		$TestimonialString.= "<tr><td>"._UE_TESTIMONIAL_TAB_NONE."</td></tr>";
		$TestimonialString.= "<tr><td>"._UE_TESTIMONIAL_TAB_NONE_DESC."</td></tr>";
	}


	//Count for page links
	if($my->id==$user_id)
	{
		$query = "SELECT count(testimonial)
			  	  FROM #__cbe_testimonials
			  	  WHERE userid='".$user_id."'";

		if(!$database->setQuery($query))
		print $database->getErrorMsg();

		$total = $database->loadResult();
	}
	else
	{
		$query = "SELECT count(testimonial)
			  	  FROM #__cbe_testimonials
			  	  WHERE userid='".$user_id."'
			  	  AND approved=1";

		if(!$database->setQuery($query))
		print $database->getErrorMsg();

		$total = $database->loadResult();
	}

	if (empty($limitstart_testimonials)) {
		(isset($_GET["limitstart_testimonials"])) ? $limitstart_testimonials  = mosGetParam ( $_GET, 'limitstart_testimonials' , '' ) : $limitstart_testimonials = 0 ;
	} else {
		$limitstart_testimonials = intval($limitstart_testimonials);
	}

	$limit = $enhanced_Config['testimonial_entries_per_page']; //count starts at zero. 5 will show 4 entries.

	if ($limit > $total)
	{
		$limitstart_testimonials = 0;
	}


	//Display testimonial section
	$query = "SELECT id,
				 	 userid,
				 	 testimonial,
				 	 by_user,
				 	 datetime,
				 	 approved 
		  	  FROM #__cbe_testimonials 
		  	  WHERE userid='".$user_id."' 
		  	  ORDER BY datetime DESC";
	$query .= " LIMIT $limitstart_testimonials, $limit";
	$database->setQuery($query);
	$testimonies = $database->loadObjectList();

	$i = 1;

	foreach ($testimonies as $testimonial)
	{
		$query = "SELECT id,
					 	 username 
			  	  FROM #__users 
			  	  WHERE id='".$testimonial->by_user."' ";
		$database->setQuery($query);
		$by_users = $database->loadObjectList();

		$query = "SELECT user_id,
						 avatar,
						 avatarapproved
			  	  FROM #__cbe 
			  	  WHERE user_id='".$testimonial->by_user."' ";
		$database->setQuery($query);
		$pics = $database->loadObjectList();

		foreach($pics as $pic)
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

		if ($enhanced_Config['testimonials_uselocale'] == '1') {
//			setlocale(LC_TIME, "de_DE");
			$time_format = $enhanced_Config['testimonials_localeformat']; // %d %B %G %T
			$tmp_Date = strftime($time_format, strtotime($testimonial->datetime));
			$TestimonialDate = $tmp_Date;
		} else {
			$TestimonialDate = date($datetime, strtotime($testimonial->datetime));
		}


		$MamboMeTestimonialText = $testimonial->testimonial; //get testimonial
		$TestimonialText = wordwrap($MamboMeTestimonialText,25, "\n", 1); //wrap text at certain length
		$TestimonialText = stripslashes($TestimonialText); //remove slashes

		if ($enhanced_Config['testimonials_use_language_filter']==1) //Use the language filter to get rid of those naughty words?
		{
			$TestimonialText = language_filter($TestimonialText);
		}
		foreach ($by_users as $by_user)
		{

			$i= ($i==1) ? 2 : 1;

			if($my->id == $user_id && $testimonial->approved==1)
			{
				$TestimonialString .= "<tr><td class=\"sectiontableentry$i\" width=\"20%\"><a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$user_id&func=unpubTestimonial&testimonial_id=$testimonial->id\">"._UE_TESTIMONIAL_TAB_HIDE."</a><a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$user_id&func=deleteTestimonial&amp;testimonial_id=$testimonial->id\">"._UE_TESTIMONIAL_TAB_DELETE."</a></td><td class=\"sectiontableentry$i\" width=\"15%\">$userAvatar<br /><a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$testimonial->by_user\">$by_user->username</a></td><td class=\"sectiontableentry$i\" width=\"65%\">$TestimonialDate<br/><hr/><br/> $TestimonialText</td></tr>\n";
				if ($is_admin)
				{
					$TestimonialString .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td align=\"left\" width=\"100%\"><b>"._UE_TESTIMONIAL_TAB_ADMIN."</b>&nbsp;&nbsp;&nbsp;<a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$user_id&func=deleteTestimonial&testimonial_id=$testimonial->id\">"._UE_TESTIMONIAL_TAB_DELETE."</a></td></tr>\n";
				}
			}
			elseif($my->id == $user_id && $testimonial->approved==0)
			{
				$TestimonialString .= "<tr><td class=\"sectiontableentry$i\" width=\"20%\"><a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$user_id&func=pubTestimonial&testimonial_id=$testimonial->id\">"._UE_TESTIMONIAL_TAB_SHOW." </a><a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$user_id&func=deleteTestimonial&testimonial_id=$testimonial->id\">"._UE_TESTIMONIAL_TAB_DELETE."</a></td><td class=\"sectiontableentry$i\" width=\"15%\">$userAvatar<br /><a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$testimonial->by_user\">$by_user->username</a></td><td class=\"sectiontableentry$i\" width=\"65%\">$TestimonialDate<br/><hr/><br/> $TestimonialText</td></tr>\n";
				if ($is_admin)
				{
					$TestimonialString .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td align=\"left\" width=\"100%\"><b>"._UE_TESTIMONIAL_TAB_ADMIN."</b>&nbsp;&nbsp;&nbsp;<a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$user_id&func=deleteTestimonial&testimonial_id=$testimonial->id\">"._UE_TESTIMONIAL_TAB_DELETE."</a></td></tr>\n";
				}
			}
			elseif($testimonial->approved==1)
			{
				$TestimonialString .= "<tr><td class=\"sectiontableentry$i\" width=\"30%\">$userAvatar<br /><a href=\"index.php?option=com_cbe".$Itemid_c."&amp;task=userProfile&amp;user=$testimonial->by_user\">$by_user->username</a></td><td class=\"sectiontableentry$i\" width=\"70%\">$TestimonialDate<br/><hr/><br/> $TestimonialText</td></tr>\n";
				if ($is_admin)
				{
					$TestimonialString .= "<tr><td>&nbsp;</td><td align=\"left\" width=\"100%\"><b>"._UE_TESTIMONIAL_TAB_ADMIN."</b>&nbsp;&nbsp;&nbsp;<a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$user_id&func=deleteTestimonial&testimonial_id=$testimonial->id\">"._UE_TESTIMONIAL_TAB_DELETE."</a></td></tr>\n";
				}
			}
		}
	}
	//End Display testimonial section


	echo $TestimonialString;

	if(count($total) > $limit)
	{
 	?>
<tr><td colspan="3"><?php echo writePagesLinksTestimonials($limitstart_testimonials, $limit, $total, $ue_base_url); ?></td></tr>
<?php
	}
	echo '<tr><td>&nbsp;</td></tr><tr><td colspan="3"><hr/>';
	writePagesLinksTestimonials($limitstart_testimonials, $limit, $total, $ue_base_url);
	?>
</td></tr>
</table>
<?php
}
function signTestimonial($Itemid_c, $option, $my_id, $user_id, $submitvalue)
{
	global $my,$user,$prof,$limitstart_testimonials,$enhanced_Config,$userpr,$testimonial,$acl,$_POST,$_REQUEST,$mosConfig_live_site;

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	$MamboMe_Sign_Testimonial = "\n<table>\n";
	$MamboMe_Sign_Testimonial .= "\n<!-- MamboMe Testimonials System Copyright (c) Jeffrey Randall 2005 -->\n";
	$MamboMe_Sign_Testimonial .= "<!-- Released under the GNU/GPL License http://www.gnu.org/copyleft/gpl.html-->\n";
	$MamboMe_Sign_Testimonial .= "<!-- Visit http://mambome.com for more info -->\n\n";

	$testimonialWordLimit = $enhanced_Config['testimonial_set_word_limit'];
	//Display testimonial submit form

	$query2 = "SELECT userid
		   	   FROM #__cbe_testimonials 
		   	   WHERE by_user = '".$my->id."' 
		   	   AND userid = '".$user_id."'";
	$database ->setQuery ($query2);
	$result2 = $database->loadResult();

	if ($result2 > 0) //You have written a testimonial for user previously
	{
		$query = "SELECT username
			  	  FROM #__users 
			  	  WHERE id='".$user_id."' ";
		$database->setQuery($query);
		$username = $database->loadResult();

		$MamboMe_Sign_Testimonial .= "<tr><td>"._UE_TESTIMONIAL_TAB_PREVIOUS_A."&nbsp;$username&nbsp;"._UE_TESTIMONIAL_TAB_PREVIOUS_B."</td></tr>\n";
	}

	if ($my->id == 0)
	{
		$MamboMe_Sign_Testimonial .= "<hr/>\n";
		$MamboMe_Sign_Testimonial .= "<tr><td>"._UE_TESTIMONIAL_TAB_NONE_LOGIN."&nbsp;"._UE_TESTIMONIAL_TAB_NONE_ACCOUNT." <a href=\"index.php?option=com_cbe".$Itemid_c."&amp;task=registers\">"._UE_CREATE_ACCOUNT."</a>.</td></tr>\n";
	}

	elseif ($my->id > 0 && $my->id !=$user_id && $result2 == 0) //logged in and not my profile and have not written testimonial for user
	{
		$MamboMe_Sign_Testimonial .= "<tr><td><form action=\"index.php?option=com_cbe".$Itemid_c."&func=submitTestimonial\" method=\"post\" name=\"testimonial\"></td></tr>\n";
		$MamboMe_Sign_Testimonial .= "<tr><td><textarea name=\"testimonial\" class=\"inputbox\" rows=\"4\" cols=\"35\" wrap=\"virtual\"  onKeyDown=\"limitText(this.form.testimonial,this.form.testimonialcountdown,$testimonialWordLimit);\" onKeyUp=\"limitText(this.form.testimonial,this.form.testimonialcountdown,$testimonialWordLimit);\"></textarea></td></tr>\n";
		$MamboMe_Sign_Testimonial .= "<tr><td><font size=\"1\">("._UE_TESTIMONIAL_WORD_LIMIT_MAXIMUM_CHAR."&nbsp;$testimonialWordLimit)<br>"._UE_TESTIMONIAL_WORD_LIMIT_YOU_HAVE."&nbsp;<input readonly type=\"text\" name=\"testimonialcountdown\" size=\"3\" value=\"$testimonialWordLimit\">&nbsp;"._UE_TESTIMONIAL_WORD_LIMIT_CHAR_LEFT."</font></td></tr>";
		$MamboMe_Sign_Testimonial .= "<tr><td><input type=\"hidden\" name=\"userid\" value=\"$user_id\" /></td></tr>\n";
		$MamboMe_Sign_Testimonial .= "<tr><td><input type=\"submit\" name=\"submit\" class=button value=\"Submit\" onclick=\"return confirm('"._UE_TESTIMONIAL_TAB_SUBMIT."')\"></td></tr>\n";
		$MamboMe_Sign_Testimonial .= "</form>\n";
	}

	//go back link
	$MamboMe_Sign_Testimonial .= "<tr><td>&nbsp;</td><td colspan=\"3\" align=\"right\"><a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$user_id&func=testimonials&index="._UE_TESTIMONIAL_TAB_LABEL."\">"._UE_TESTIMONIAL_TAB_SIGN_BACK."</a></td></tr>";	// Base URL string

	echo $MamboMe_Sign_Testimonial;

	echo '</table>';
}
?>