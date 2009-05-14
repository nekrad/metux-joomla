<?php
//********************************************
// MamboMe Enhanced Display                  *
// Copyright (c) 2005 Jeffrey Randall        *
// http://mambome.com                        *
// Released under the GNU/GPL License        *
// Version 1.0                               *
// File date: 16-05-2005                     *
//********************************************

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

if (file_exists('components/com_cbe/enhanced/language/'.$mosConfig_lang.'.php'))
{
	include_once('components/com_cbe/enhanced/language/'.$mosConfig_lang.'.php');
}
else
{
	include_once('components/com_cbe/enhanced/language/english.php');
}

//include buddy language
if (file_exists('components/com_cbe/enhanced/buddy/language/'.$mosConfig_lang.'.php'))
{
	include_once('components/com_cbe/enhanced/buddy/language/'.$mosConfig_lang.'.php');
}
else
{
	include_once('components/com_cbe/enhanced/buddy/language/english.php');
}

include_once('administrator/components/com_cbe/enhanced_admin/enhanced_config.php');
include_once('components/com_cbe/enhanced/enhanced_functions.inc');

if ($GLOBALS['Itemid_com']!='') {
	$Itemid_c = $GLOBALS['Itemid_com'];
} else {
	$Itemid_c = '';
}
// add/delete buddy link
if($enhanced_Config['show_add_del_bud_link']==1)
{
	if($my->id &&  $my->id!=$user->id)
	{
	?>
<tr>
	<td  class=sectiontableentry<?php echo $i; ?> width="35%" style="font-weight:bold;"><?php echo _UE_BUDDYLIST; ?></td>
	<td  class=sectiontableentry<?php echo $i; ?> >
	
<?php
/*
// $query = "SELECT id
//		  FROM #__cbe_buddylist 
//		  WHERE userid='".$my->id."' 
//		  AND buddyid='".$user->id."' 
//		  AND buddy=1 UNION ALL SELECT id 
//		  FROM #__cbe_buddylist 
//		  WHERE userid='".$user->id."' 
//		  AND buddyid='".$my->id."' 
//		  AND buddy=1 ";
*/

$query = "SELECT id
		  FROM #__cbe_buddylist 
		  WHERE (userid='".$my->id."' 
		  AND buddyid='".$user->id."' 
		  AND buddy=1) OR  
		  (userid='".$user->id."' 
		  AND buddyid='".$my->id."'
		  AND buddy=1) "; 
$database->setQuery($query);
$result = $database->loadObjectList();
$delete = count($result);

$query = "SELECT id
		  FROM #__cbe_buddylist 
		  WHERE userid='".$my->id."' 
		  AND buddyid='".$user->id."' 
		  AND status=1";
$database->setQuery($query);
$result = $database->loadObjectList();
$cancel = count($result);

$query = "SELECT id
		  FROM #__cbe_buddylist 
		  WHERE userid='".$user->id."' 
		  AND buddyid='".$my->id."' 
		  AND status=1";
$database->setQuery($query);
$result = $database->loadObjectList();
$acceptreject = count($result);

if($delete)
{
	?>
<a href="<?php echo JRoute::_("index.php?option=com_cbe".$Itemid_c."&amp;func=deletebuddy&amp;mlb=1&amp;buddyid=".$user->id); ?>" onClick= "return confirm('<?php echo _UE_POPUP_DELETE_BUDDY; ?>');"><?php echo _UE_BUDDYLIST_DELETE; ?></a></td></tr> 
<?php 
}
else if($cancel)
{
	?> 
	<a href="<?php echo JRoute::_("index.php?option=com_cbe".$Itemid_c."&amp;func=cancelbuddy&amp;mlb=1&amp;buddyid=".$user->id); ?>" onClick= "return confirm('<?php echo _UE_POPUP_CANCEL_BUDDY; ?>');"><?php echo _UE_BUDDYLIST_CANCEL; ?></a></td></tr> 
	<?php 
}
else if($acceptreject)
{
	?> 
	<a href="<?php echo JRoute::_("index.php?option=com_cbe".$Itemid_c."&amp;func=acceptbuddy&amp;mlb=1&amp;buddyid=".$user->id); ?>" onClick= "return confirm('<?php echo _UE_POPUP_ACCEPT_BUDDY; ?>');" ><?php echo _UE_BUDDYLIST_ACCEPT; ?></a>
	<a href="<?php echo JRoute::_("index.php?option=com_cbe".$Itemid_c."&amp;func=rejectbuddy&amp;mlb=1&amp;buddyid=".$user->id); ?>" onClick= "return confirm('<?php echo _UE_POPUP_REJECT_BUDDY; ?>');" ><?php echo _UE_BUDDYLIST_REJECT; ?></a></td></tr> 
	<?php 
}
else
{
	?> 
<a href="<?php echo JRoute::_("index.php?option=com_cbe".$Itemid_c."&amp;func=addbuddy&amp;mlb=1&amp;buddyid=".$user->id); ?>" onClick= "return confirm('<?php echo _UE_POPUP_ADD_BUDDY; ?>');"><?php echo _UE_BUDDYLIST_ADD; ?></a></td></tr> 
<?php
}
$i= ($i==1) ? 2 : 1;
	}
}

//Zoom Photos Number
if($enhanced_Config['show_photos_number']=='1')
{
	$query = "SELECT count(uid) FROM #__zoomfiles WHERE imgfilename NOT LIKE '%.mp3' AND published='1' AND uid='".$user->id."'";
	$database->setQuery($query);
	$total = $database->loadResult();
?>
<tr>
	<td class="sectiontableentry<?php echo $i; ?>" width="35%" style="font-weight:bold;">
	<?php echo _UE_PHOTOSNUMBER; ?></td>
	<td class="sectiontableentry<?php echo $i; ?>" ><?php echo $total; ?></td>
</tr>
<?php $i= ($i==1) ? 2 : 1; 
}

// Zoom MP3 Counter Display
if($enhanced_Config['show_mp3_number']=='1')
{
	$query = "SELECT count(uid) FROM #__zoomfiles WHERE imgfilename LIKE '%.mp3' AND published='1' AND uid='".$user->id."'";
	$database->setQuery($query);
	$total = $database->loadResult();
?>
<tr>
	<td class="sectiontableentry<?php echo $i; ?>" width="35%" style="font-weight:bold;">
	<?php echo _UE_MP3SNUMBER; ?></td>
	<td class="sectiontableentry<?php echo $i; ?>" ><?php echo $total; ?></td>
</tr>
<?php $i= ($i==1) ? 2 : 1; 
}

//Forum Rank
if($enhanced_Config['show_forum_ranking']==1 || $enhanced_Config['show_forum_post_number']==1 || $enhanced_Config['show_forum_karma']==1)
{
	$do_ff_query = 1;
	if ($enhanced_Config['sb_use_fb'] != '1') {
		$query_simpleb = "SELECT count(link) FROM #__components WHERE link LIKE '%com_simpleboard%'";
		$database->setQuery($query_simpleb);
		$simple_res = $database->loadResult();
		if ($simple_res < '1') {
			$query_joomlab = "SELECT count(link) FROM #__components WHERE link LIKE '%com_joomlaboard%'";
			$database->setQuery($query_joomlab);
			$jsimple_res = $database->loadResult();
			if ($jsimple_res >= '1') {
				$sb_board_table = "joomlaboard";
				$forum_pre = "sb";
			} else {
				$do_ff_query = 0;
			}
		} else {
			$sb_board_table = "simpleboard";
			$forum_pre = "sb";
		}
	} else {
		$query_fireboard = "SELECT count(link) FROM #__components WHERE link LIKE '%com_fireboard%'";
		$database->setQuery($query_fireboard);
		$fire_res = $database->loadResult();
		if ($fire_res < '1') {
			$do_ff_query = 0;
		} else {
			$sb_board_table = "fireboard";
			$forum_pre = "fb";
		}
	}
	
	if ($do_ff_query == 1) {
		if (file_exists( 'administrator/components/com_'.$sb_board_table.'/'.$sb_board_table.'_config.php')) {
			include_once ( 'administrator/components/com_'.$sb_board_table.'/'.$sb_board_table.'_config.php' );
		}
		if ($enhanced_Config['sb_use_fb'] == '1') {
			$sbConfig = $fbConfig;
		}
	}
}

if ($enhanced_Config['show_forum_ranking']==1 && $do_ff_query == 1) {
	if($sbConfig['showranking'])
	{
		$database->setQuery("SELECT posts FROM #__".$forum_pre."_users where userid='$user->id'");
		$numPosts=$database->loadResult();
		$numPosts=(int)$numPosts;
		$rText="";
		$rImg="";

		//What type of user are we?
		$database->setQuery("SELECT gid FROM #__users WHERE id='$user->id'");
		$ugid=$database->loadResult();
		$uIsMod=0;
		$uIsAdm=0;

		$database->setQuery("SELECT moderator FROM #__".$forum_pre."_users WHERE userid='$user->id'");
		$mod_quest = $database->loadResult();
		if ($mod_quest != 0) {
			$uIsMod=1;
		}
		
		if($ugid==24 || $ugid==25)
		{
			$uIsAdm=1;
		}
		
		$sbs=$mosConfig_live_site.'/components/com_'.$sb_board_table;

		if ($numPosts>=0 && $numPosts<(int)$sbConfig['rank1'])
		{
			$rText=$sbConfig['rank1txt'];
			$rImg=$sbs.'/ranks/rank1.gif';
		}
		if ($numPosts>=(int)$sbConfig['rank1'] && $numPosts<(int)$sbConfig['rank2'])
		{
			$rText=$sbConfig['rank2txt'];
			$rImg=$sbs.'/ranks/rank2.gif';
		}
		if ($numPosts>=(int)$sbConfig['rank2'] && $numPosts<(int)$sbConfig['rank3'])
		{
			$rText=$sbConfig['rank3txt'];
			$rImg=$sbs.'/ranks/rank3.gif';
		}
		if ($numPosts>=(int)$sbConfig['rank3'] && $numPosts<(int)$sbConfig['rank4'])
		{
			$rText=$sbConfig['rank4txt'];
			$rImg=$sbs.'/ranks/rank4.gif';
		}
		if ($numPosts>=(int)$sbConfig['rank4'] && $numPosts<(int)$sbConfig['rank5'])
		{
			$rText=$sbConfig['rank5txt']; $rImg=$sbs.'/ranks/rank5.gif';
		}
		if ($numPosts>=(int)$sbConfig['rank5'])
		{
			$rText=$sbConfig['rank6txt'];
			$rImg=$sbs.'/ranks/rank6.gif';
		}
		if ( $uIsMod ) {
			$rText=_RANK_MODERATOR;
			$rImg=$sbs.'/ranks/rankmod.gif';
		}
		if($uIsAdm)
		{
			$rText=_RANK_ADMINISTRATOR;
			$rImg=$sbs.'/ranks/rankadmin.gif';
		}
		if($sbConfig['rankimages'])
		{
			$msg_userrankimg = '<img src="'.$rImg.'" alt="" />';
		}
		$msg_userrank = $rText;
?>
<tr>
	<td class="sectiontableentry<?php echo $i; ?> width="35%" style="font-weight:bold;">
<?php echo "Forum Rank"; ?></td>
	<td class="sectiontableentry<?php echo $i; ?>">
<?php echo $msg_userrank; ?></td>
</tr>
<?php $i= ($i==1) ? 2 : 1; 
	}
}

//Forum Posts Number
if($enhanced_Config['show_forum_post_number']==1 && $do_ff_query == 1)
{
	$query = "SELECT count(userid) FROM #__".$forum_pre."_messages WHERE userid='".$user->id."'";
	$database->setQuery($query);
	$total = $database->loadResult();
?>
<tr>
	<td class="sectiontableentry<?php echo $i; ?>"width="35%" style="font-weight:bold;">
<?php echo "Forum Posts"; ?>
</td>
	<td class="sectiontableentry<?php echo $i; ?>">
<?php echo $total; ?>
</td></tr>
<?php $i= ($i==1) ? 2 : 1; 
}
?>

<?php 
//SB Forum Karma
if ($enhanced_Config['show_forum_karma']==1 && $do_ff_query == 1)
{
	$query = "SELECT karma
			  FROM #__".$forum_pre."_users 
			  WHERE userid='".$user->id."'";
	$database->setQuery($query);
	$karma = $database->loadResult();

	if($karma =="")
	{
		$karma = _UE_FORUM_NO_KARMA;
	}
?>
<tr>
	<td class="sectiontableentry<?php echo $i; ?>"width="35%" style="font-weight:bold;">
<?php echo _UE_FORUM_KARMA; ?></td>
	<td class="sectiontableentry<?php echo $i; ?>">
<?php echo $karma; ?></td>
</tr>
<?php $i= ($i==1) ? 2 : 1; 
}
?>

<?php 
// calculate Age and print out
if ($enhanced_Config['showage']==1)
{
	$birthday_field = $enhanced_Config['lastvisitors_birthday_field'];
	$query = "SELECT $birthday_field FROM #__cbe WHERE id='".$user->id."'";
	$database->setQuery($query);
	$birthday = $database->loadResult();

	if($birthday =="")
	{
		$user_age = _UE_SHOWAGE_NO;
	} else {
		$timenow = time();
		$user_age = cb_user_age($birthday, $timenow);
	}
?>
<tr>
	<td class="sectiontableentry<?php echo $i; ?>"width="35%" style="font-weight:bold;">
<?php echo _UE_SHOWAGE_TITLE; ?></td>
	<td class="sectiontableentry<?php echo $i; ?>">
<?php echo $user_age; ?></td>
</tr>
<?php $i= ($i==1) ? 2 : 1; 
}
?>

<?php 
// show Zodiac
if ($enhanced_Config['show_zodiacs'] == '1' || $enhanced_Config['show_zodiacs_ch'] == '1')
{

	$query = "SELECT zodiac, zodiac_c FROM #__cbe WHERE id='".$user->id."'";
	$database->setQuery($query);
	$zodiacs = $database->loadAssocList();
	$zodiacs = $zodiacs[0];

	if(($zodiacs['zodiac']=='') && ($zodiacs['zodiac_c']=='')) {
		$user_zodiac = _UE_ZODIAC_NO;
		$user_zodiac_chinese = _UE_ZODIAC_NO;
	} else {
		if (defined($zodiacs[zodiac])) {
			$user_zodiac = constant($zodiacs['zodiac']);
		} else {
			$user_zodiac = $zodiacs['zodiac'];
			if ($user_zodiac == '') {
				$user_zodiac = _UE_ZODIAC_NO;
			}
		}
		if (defined($zodiacs['zodiac_c'])) {
			$user_zodiac_chinese = constant($zodiacs['zodiac_c']);
		} else {
			$user_zodiac_chinese = $zodiacs['zodiac_c'];
			if ($user_zodiac_chinese == '') {
				$user_zodiac_chinese = _UE_ZODIAC_NO;
			}
		}
	}
if ($enhanced_Config['show_zodiacs'] == '1') {
?>
<tr>
	<td class="sectiontableentry<?php echo $i; ?>"width="35%" style="font-weight:bold;">
<?php echo _UE_SHOWZODIAC_TITLE; ?></td>
	<td class="sectiontableentry<?php echo $i; ?>">
<?php echo $user_zodiac; ?></td>
</tr>
<?php $i= ($i==1) ? 2 : 1; 
}
if ($enhanced_Config['show_zodiacs_ch'] == '1') {
?>

<tr>
	<td class="sectiontableentry<?php echo $i; ?>"width="35%" style="font-weight:bold;">
<?php echo _UE_SHOWZODIAC_TITLE_CHINESE; ?></td>
	<td class="sectiontableentry<?php echo $i; ?>">
<?php echo $user_zodiac_chinese; ?></td>
</tr>
<?php $i= ($i==1) ? 2 : 1; 
} // end chinese zodiac
}
// zodiac end

if ($enhanced_Config['show_core_usertype'] == '1') {               
?>

<tr>
        <td class="sectiontableentry<?php echo $i; ?>"width="35%" style="font-weight:bold;">
<?php echo _UE_CB_CORE_USERTYPE; ?></td>
        <td class="sectiontableentry<?php echo $i; ?>">
<?php
$acl =& JFactory::getACL();

$user->usertype = $acl->get_group_name($user->gid, 'ARO');
echo $user->usertype; ?></td>
</tr>
<?php $i= ($i==1) ? 2 : 1;
}
// end core_usertype

// GroupJive inline display
if ($enhanced_Config['groupjive_integration'] == '1') {
	if ($enhanced_Config['link_gj_owned_groups'] == '1') {
		if (file_exists('components/com_cbe/enhanced/groupjive/language/'.$mosConfig_lang.'.php')) {
			include_once('components/com_cbe/enhanced/groupjive/language/'.$mosConfig_lang.'.php');
		} else {
			include_once('components/com_cbe/enhanced/groupjive/language/english.php');
		}
	}
		
	$database->setQuery("SELECT id FROM #__menu WHERE (link LIKE '%com_groupjive%') AND (published='1' OR published='0') AND access='0' ORDER BY id DESC Limit 1");
	$gj_itemid = $database->loadResult();
	if ($gj_itemid != '') {
		$gj_itemid = "&amp;Itemid=".$gj_itemid;
	}
	$gj_group_link = "index.php?option=com_groupjive&amp;task=showgroup".$gj_itemid."&groupid=";
	$gj_group_link_s = "index.php?option=com_groupjive".$gj_itemid;
	$gj_tab_link = "index.php?option=com_cbe".$GLOBALS['Itemid_com']."&amp;task=userProfile&user=".$user->id."&amp;func=gj_owned&amp;index="._UE_GROUPJIVE_TAB_LABEL;

	$database->setQuery("SELECT id, name, descr, type, creator FROM #__gj_groups WHERE user_id='".$user->id."' AND active='1' ORDER BY id ASC");
	$user_gj_owned_groups = $database->loadObjectList();
	$user_gj_count = count($user_gj_owned_groups);
	$user_gj_gon = $user_gj_count - 1;
?>

<tr>
        <td class="sectiontableentry<?php echo $i; ?>"width="35%" style="font-weight:bold;">
<?php echo _UE_GROUPJIVE_OWNER; ?></td>
        <td class="sectiontableentry<?php echo $i; ?>">
<?php
	if ($enhanced_Config['show_gj_owned_groups'] == '1') {
		if ($user_gj_count != 0) {
			echo "<ul>\n";
			echo "<li><a href=\"".JRoute::_($gj_group_link.$user_gj_owned_groups[0]->id)."\">".$user_gj_owned_groups[0]->name."</a>\n";
			if ($enhanced_Config['link_gj_owned_groups'] == '1') {
				if ($user_gj_count > 1) {
					echo "<li><a href=\"".JRoute::_($gj_tab_link)."\">+".$user_gj_gon." ".(($user_gj_gon > 1) ? _UE_GROUPJIVE_GS : _UE_GROUPJIVE_G)."</a>\n";
				}
			}
			echo "</ul>\n";
		} else {
			echo "-- \n";
		}
	} else {
		if ($user_gj_count != 0) {
			echo "<a href=\"".JRoute::_($gj_group_link_s)."\">".$user_gj_count." ".(($user_gj_count > 1) ? _UE_GROUPJIVE_GS : _UE_GROUPJIVE_G)."</a>\n";
		} else {
			echo "-- \n";
		}
	}

?>
</td>
</tr>
<?php 
		$i= ($i==1) ? 2 : 1;
}
// end com_groupjive 

?>