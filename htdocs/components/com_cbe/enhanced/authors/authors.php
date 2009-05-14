<?php
//********************************************
// Favorite Authors tab By Jeffrey Randall   *
// Copyright (c) 2005 Jeffrey Randall        *
// 21-05-2005 http://mambome.com             *
// Released under the GNU/GPL License        *
// Version 1.1                               *
//********************************************

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

if (file_exists('components/com_cbe/enhanced/authors/language/'.$mosConfig_lang.'.php'))
{
	include_once('components/com_cbe/enhanced/authors/language/'.$mosConfig_lang.'.php');
}
else
{
	include_once('components/com_cbe/enhanced/authors/language/english.php');
}

include_once('components/com_cbe/enhanced/enhanced_functions.inc');
include_once('administrator/components/com_cbe/enhanced_admin/enhanced_config.php');

?>
<link href="<?php echo JURI::root();?>components/com_cbe/enhanced/enhanced_css.css" rel="stylesheet" type="text/css""/>
<?php

$task=JRequest::getVar('task', 'authors' );
$authorid=JRequest::getVar('authorid','');

// $database->setQuery("SELECT id FROM #__menu WHERE (link LIKE '%com_cbe' OR link LIKE '%com_cbe%userProfile') AND (published='1' OR published='0')");
// $Itemid = $database->loadResult();
if ($GLOBALS['Itemid_com']!='') {
	$Itemid_c = $GLOBALS['Itemid_com'];
} else {
	$Itemid_c = '';
}


$path = "index.php?option=com_cbe".$Itemid_c."&amp;task=userProfile&amp;user=";
$pm_icon = "components/com_cbe/enhanced/images/sendpm.gif";
$online_image = "components/com_cbe/enhanced/images/online.png"; //change to icon you wish to use for online status
// PMS pathes
//	$database->setQuery("SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_pms%' AND (published='1' OR published='0')");
//	$pms_ops = $database->loadResult();
//$pms_open_source_path = 'index.php?option=com_pms'.$pms_ops.'&amp;page=new&amp;id='; // MyPMS-OS II 2.1x
//
//	$database->setQuery("SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_mypms%' AND (published='1' OR published='0')");
//	$pms_mypms = $database->loadResult();
//$mypms_path = 'index.php?option=com_mypms'.$pms_mypms.'&amp;task=new&amp;to=';	 // MyPMS-Pro
//
//	$database->setQuery("SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_pms%' AND (published='1' OR published='0')");
//	$pms_os2 = $database->loadResult();
//$pms_os_2_path="index.php?option=com_pms".$pms_os2."&page=new&id=";			 // MyPMS-OS 2.5alpha	.$user->username; 
//
//	$database->setQuery("SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_pms%' AND (published='1' OR published='0')");
//	$pms_oseh = $database->loadResult();
//$pms_os_enh_path="index.php?option=com_pms".$pms_oseh."&page=new&id=";		 // MyPMS-OSenh 1.2.x	.$user->username;
//
//	$database->setQuery("SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_uddeim%' AND (published='1' OR published='0')");
//	$pms_uddeim = $database->loadResult();
//$pms_uddeim_path="index.php?option=com_uddeim".$pms_uddeim."&task=new&recip=";		 // uddeIM 0.4>		.$user->id;
//
//	$database->setQuery("SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_missus%' AND (published='1' OR published='0')");
//	$pms_missus = $database->loadResult();
//$pms_missus_path="index.php?option=com_missus".$pms_missus."&func=newmsg&user=";	 // Missus 1.0 Beta2	.$user->id;
//
//	$database->setQuery("SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_mypms%' AND (published='1' OR published='0')");
//	$pms_mypmsc = $database->loadResult();
//$pms_clexus_path = 'index.php?option=com_mypms'.$pms_mypmsc.'&amp;task=new&amp;to=';	 // Clexus 1.2.1 and higer	.$user->id;
//
//	$database->setQuery("SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_jim%' AND (published='1' OR published='0')");
//	$pms_jim = $database->loadResult();
//$pms_jim_path="index.php?option=com_jim".$pms_jim."&task=new&id=";	 // Jim 1.0.1	.$user->username;


switch ($task)
{
	case "addauthor":
	addauthor( $Itemid_c, $option, $my->id, _UE_UPDATE);
	break;

	case "subauthor":
	subauthor( $Itemid_c, $option, $my->id, _UE_UPDATE);
	break;

	case "delauthor":
	delauthor( $Itemid_c, $option, $my->id, _UE_UPDATE);
	break;

	case "deleteauthor":
	deleteauthor( $Itemid_c, $option, $my->id, _UE_UPDATE);
	break;

}

//Authors Functions
function subauthor( $Itemid_, $option, $uid, $submitvalue )
{

	global $my,$ueConfig,$acl,$_POST,$_REQUEST, $mainframe;

	$database = &JFactory::getDBO();
	if ($uid == 0)
	{
		echo JText::_(ALERTNOTAUTH);
		return;
	}

	if (isset($_POST['adminForm']))
	if (is_array($_POST["addauth"]))
	{
		{

			while(list($key, $val) = each($_POST["addauth"]))

			{
				if($val == 'add')
				$adIds[] = $key;

				$addauthor = "INSERT INTO #__cbe_authorlist (userid,authorid) VALUES ('$my->id', '$key');";
				$database->setQuery($addauthor);
				$add = $database->query();
			}
		}
	}
	$mainframe->redirect("index.php?option=com_cbe".$Itemid_."&task=userProfile&user=$my->id&func=authors&index="._UE_AUTHOR_TAB_LABEL."");
}
function addauthor( $Itemid_, $option, $uid, $submitvalue )
{
	global $my,$ueConfig,$authorid,$mainframe;

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();
	if ($uid == 0) {
		echo JText::_(ALERTNOTAUTH);
		return;
	}

	$query = "INSERT INTO #__cbe_authorlist (userid,authorid) VALUES ('$my->id', '$authorid');";

	$database->setQuery( $query );
	$database->Query();

	$mainframe->redirect("index.php?option=com_cbe".$Itemid_."&task=userProfile&user=$my->id&func=authors&index="._UE_AUTHOR_TAB_LABEL."");

}

function deleteauthor( $Itemid_, $option, $uid, $submitvalue )
{
	global $my,$ueConfig,$authorid,$acl,$mainframe;

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	if ($uid == 0) {
		echo JText::_(ALERTNOTAUTH);
		return;
	}

	$query = "DELETE FROM #__cbe_authorlist
			  WHERE userid='$my->id' 
			  AND authorid='$authorid'";

	$database->setQuery( $query );
	$database->Query();

	$mainframe->redirect("index.php?option=com_cbe".$Itemid_."&task=userProfile&user=$my->id&func=authors&index="._UE_AUTHOR_TAB_LABEL."");

}

function delauthor( $Itemid_, $option, $uid, $submitvalue )
{

	global $ueConfig,$acl,$_POST,$_REQUEST, $mainframe;

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();
	if ($uid == 0)
	{
		echo JText::_(ALERTNOTAUTH);
		return;
	}


	if (isset($_POST['adminForm']))
	if (is_array($_POST["delete"])){

		{

			while(list($key, $val) = each($_POST["delete"]))

			{
				if($val == 'del')
				$adIds[] = $key;

				$delauthor = "DELETE FROM #__cbe_authorlist
							  WHERE userid='$my->id' 
							  AND authorid='$key'";
				$database->setQuery($delauthor);
				$del = $database->query();
			}
		}
	}

	$mainframe->redirect("index.php?option=com_cbe".$Itemid_."&task=userProfile&user=$my->id&func=authors&index="._UE_AUTHOR_TAB_LABEL."");
}

//Display Favorite/Subscribed to Authors

$database = &JFactory::getDBO();
$my = &JFactory::getUser();
echo '<table width="100%">';

$FavAuthorString = "\n<!-- MamboMe Favorite Authors System Copyright (c) Jeffrey Randall 2005 -->\n";
$FavAuthorString .= "<!-- Released under the GNU/GPL License http://www.gnu.org/copyleft/gpl.html -->\n";
$FavAuthorString .= "<!-- Visit http://mambome.com for more info -->\n\n";

$FavAuthorString .= "<tr><td colspan=\"2\">\n";

$query = "SELECT authorid
		  FROM #__cbe_authorlist 
		  WHERE userid='".$user->id."' ";
$database->setQuery($query);
$result = $database->loadObjectList();
$total = count ($result);

$pmsurl ='';

if ($total <1)
{
	echo _UE_AUTHOR_TAB_NO_FAVOURITE_AUTHORS;
}

if ($total >0)
{
	$j=0;
	$author='';
	//$FavAuthorString='';

	foreach($result as $preuser)
	{
		$author[$j]=$preuser->authorid;
		$j++;
	}

	$passtoquery='(' . implode(',', $author) . ')';

	$query = "SELECT id,
					 username 
			  FROM #__users 
			  WHERE id IN ".$passtoquery." 
			  AND block!=1 
			  ORDER BY username";
	$database->setQuery($query);
	$authors = $database->loadObjectList();

	$FavAuthorString .= "<tr><td colspan=\"2\">\n";

	foreach($authors as $author)
	{
		$query_avatar = "SELECT avatar,
								avatarapproved
						 FROM #__cbe 
						 WHERE user_id='".$author->id."'";
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

			$userAvatar="<div class=\"author_pic\"><a href=".$path.$author->id."><img src=\"$user_image\" border=\"0\"><br/>\n".$author->username."</a>\n";
		}

		$FavAuthorString .= $userAvatar;
		$FavAuthorString .= "<br/>\n";

		//get private message url
		if($enhanced_Config['allow_pmauthor']==1)
		{
			if($ueConfig['pms']!=0 && $my->id == $user->id)
			{
				if ($ueConfig['pms']==1) {
					$pmsurl = "<a href=\"$pms_open_source_path$author->username\">";
					$pmsurl .="<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_AUTHOR_TAB_PRIVATE_MESSAGE."\"></a><br/>\n"; 
				} else 
				if ($ueConfig['pms']==2) {
					$pmsurl = "<a href=\"$mypms_path$author->username\">";
					$pmsurl .= "<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_AUTHOR_TAB_PRIVATE_MESSAGE."\"></a><br/>\n";
				} else 
				if ($ueConfig['pms']==3) {
					$pmsurl = "<a href=\"$pms_os_2_path$author->username\">";
					$pmsurl .= "<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_AUTHOR_TAB_PRIVATE_MESSAGE."\"></a><br/>\n";
				} else 
				if ($ueConfig['pms']==4) {
					$pmsurl = "<a href=\"$pms_os_enh_path$author->username\">";
					$pmsurl .= "<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_AUTHOR_TAB_PRIVATE_MESSAGE."\"></a><br/>\n";
				} else 
				if ($ueConfig['pms']==9) {
					$pmsurl = "<a href=\"$pms_os_enh2_path$author->id\">";
					$pmsurl .= "<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_AUTHOR_TAB_PRIVATE_MESSAGE."\"></a><br/>\n";
				} else 
				if ($ueConfig['pms']==5) {
					$pmsurl = "<a href=\"$pms_uddeim_path$author->id\">";
					$pmsurl .= "<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_AUTHOR_TAB_PRIVATE_MESSAGE."\"></a><br/>\n";
				} else
				if ($ueConfig['pms']==6) {
					$pmsurl = "<a href=\"$pms_missus_path$author->id\">";
					$pmsurl .= "<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_AUTHOR_TAB_PRIVATE_MESSAGE."\"></a><br/>\n";
				}
				if ($ueConfig['pms']==7) {
					$pmsurl = "<a href=\"$pms_clexus_path$author->id\">";
					$pmsurl .= "<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_AUTHOR_TAB_PRIVATE_MESSAGE."\"></a><br/>\n";
				}
				if ($ueConfig['pms']==8) {
					$pmsurl = "<a href=\"$pms_jim_path$author->username\">";
					$pmsurl .= "<img src=\"$pm_icon\" border=\"0\" alt=\""._UE_AUTHOR_TAB_PRIVATE_MESSAGE."\"></a><br/>\n";
				}

			}
		}

		//Get authors online status
		if($enhanced_Config['allow_onlineauthor']==1)
		{

			$query_session = "SELECT userid
							  	  	  FROM #__session 
							  	  	  WHERE userid='".$author->id."'";
			$database->setQuery( $query_session );
			$sessions = $database->loadObjectList();

			//Find authors Online
			foreach ($sessions as $session)
			{
				if($session->userid == $author->id)
				{
					$FavAuthorString .= "<img src=\"$online_image\" border=\"0\">"._UE_AUTHOR_TAB_ONLINE."<br/>";//add language
				}
			}
		}


		$FavAuthorString .= $pmsurl;

		if($my->id == $user->id)
		{
			$FavAuthorString .= "<a href=\"index.php?option=com_cbe".$Itemid_c."&amp;task=deleteauthor&amp;authorid=$author->id\">\n";
			$FavAuthorString .= _UE_AUTHOR_TAB_REMOVE."</a>\n";
		}
		$FavAuthorString .= "</div>\n";
	}
	echo $FavAuthorString;
}
echo "</table>\n";
?>