<?php
//********************************************
// MamboMe My Profile Journal                *
// Copyright (c) 2005 Jeffrey Randall        *
// http://mambome.com                        *
// Released under the GNU/GPL License        *
// Version .9 beta                           *
// File date: 16-05-2005                     *
//********************************************

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $userpr;
if (file_exists('components/com_cbe/enhanced/journal/language/'.$mosConfig_lang.'.php'))
{
	include_once('components/com_cbe/enhanced/journal/language/'.$mosConfig_lang.'.php');
}
else
{
	include_once('components/com_cbe/enhanced/journal/language/english.php');
}

include_once('components/com_cbe/enhanced/enhanced_functions.inc');
include_once('administrator/components/com_cbe/enhanced_admin/enhanced_config.php');

$my = &JFactory::getUser();
$func=JRequest::getVar('func', 'journal' );
$prof=JRequest::getVar('prof','');
$userpr = JRequest::getVar('user','');

$journal_id=JRequest::getVar('journal_id','');
$journal=JRequest::getVar('journal','');

if ($GLOBALS['Itemid_com']!='') {
	$Itemid_c = $GLOBALS['Itemid_com'];
} else {
	$Itemid_c = '';
}

switch ($func)
{
	case "submitJournalEntry":
	submitJournalEntry($Itemid_c, $option, $my->id,_UE_UPDATE);
	break;

	case "deleteJournalEntry":
	deleteJournalEntry($Itemid_c, $option, $my->id,$journal_id, $prof, _UE_UPDATE);
	break;

	case "unpubJournalEntry":
	unpubJournalEntry($Itemid_c, $option, $my->id,$journal_id, $prof, _UE_UPDATE);
	break;

	case "pubJournalEntry":
	pubJournalEntry($Itemid_c, $option, $my->id,$journal_id, $prof, _UE_UPDATE);
	break;

	case "writeJournal":
	writeJournal($Itemid_c, $option, $my->id, $user->id, _UE_UPDATE);
	break;

	default:
	journal($Itemid_c, $option, $my->id, $user->id, _UE_UPDATE);
	break;
}

//Journal functions

function submitJournalEntry($Itemid_c, $option, $uid, $submitvalue)
{
	global $user,$enhanced_Config,$userpr,$journal,$acl,$_POST,$_REQUEST,$mosConfig_live_site, $mainframe;

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();
	if ($uid == 0)
	{
		echo JText::_(ALERTNOTAUTH);
		return;
	}

	(isset($_POST["journal"])) ? $journal  = JRequest::getVar ('journal' , '' ) : $journal = NULL ;
	$noHTMLText = strip_tags($journal);
	$noHTMLText = addslashes($noHTMLText);

	$time = date('H:i:s');
	$date = date('Y-m-d');


	$query = "INSERT INTO #__cbe_mambome_journal (userid,datetime,journal_entry,published) VALUES ('$my->id','$date.$time','$noHTMLText','1');";
	$database->setQuery( $query );

	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$mainframe->redirect("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$uid&func=journal&index="._UE_MY_PROFILE_JOURNAL_TAB_LABEL);
}

function deleteJournalEntry( $Itemid_c, $option, $uid, $submitvalue, $prof )
{
	global $my, $mainframe;

	$database = &JFactory::getDBO();
	if ($uid == 0)
	{
		echo JText::_(ALERTNOTAUTH);
		return;
	}
	
	$query = "DELETE FROM #__cbe_mambome_journal
			  WHERE id='".$submitvalue."'";
	$database->setQuery($query);

	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$mainframe->redirect("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$prof&func=journal&index="._UE_MY_PROFILE_JOURNAL_TAB_LABEL);

}

function unpubJournalEntry($Itemid_c, $option, $uid, $submitvalue, $prof)
{
	global $my, $mainframe;

	$database = &JFactory::getDBO();
	if ($uid == 0)
	{
		echo JText::_(ALERTNOTAUTH);
		return;
	}
	
	$query = "UPDATE #__cbe_mambome_journal
			  SET published=0 
			  WHERE id='".$submitvalue."'";
	$database->setQuery($query);

	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$mainframe->redirect("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$prof&func=journal&index="._UE_MY_PROFILE_JOURNAL_TAB_LABEL."");
}

function pubJournalEntry($Itemid_c, $option, $uid, $submitvalue, $prof)
{
	global $my, $mainframe;

	$database = &JFactory::getDBO();

	if ($uid == 0)
	{
		echo JText::_(ALERTNOTAUTH);
		return;
	}

	$query = "UPDATE #__cbe_mambome_journal
			  SET published=1 
			  WHERE id='".$submitvalue."'";
	$database->setQuery($query);

	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$mainframe->redirect("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$prof&func=journal&index="._UE_MY_PROFILE_JOURNAL_TAB_LABEL."");
}

function writePagesLinksJournal($limitstart_journal, $limit, $total,$ue_base_url) {

	$pages_in_list = 10;

	$displayed_pages = $pages_in_list;
	$total_pages = ceil( $total / $limit );
	$this_page = ceil( ($limitstart_journal+1) / $limit );
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
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_journal=0\" title=\"" . _UE_FIRST_PAGE . "\">&lt;&lt; " . _UE_FIRST_PAGE . "</a>";
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_journal=$page\" title=\"" . _UE_PREV_PAGE . "\">&lt; " . _UE_PREV_PAGE . "</a>";
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
			echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_journal=$page\"><strong>$i</strong></a>";
		}
	}

	if ($this_page < $total_pages)
	{
		$page = $this_page * $limit;
		$end_page = ($total_pages-1) * $limit;
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_journal=$page\" title=\"" . _UE_NEXT_PAGE . "\">" . _UE_NEXT_PAGE . " &gt;</a>";
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_journal=$end_page\" title=\"" . _UE_END_PAGE . "\">" . _UE_END_PAGE . " &gt;&gt;</a>";
	}
	else
	{
		echo '<span class="pagenav">'. _UE_NEXT_PAGE .' &gt;</span> ';
		echo '<span class="pagenav">'. _UE_END_PAGE .' &gt;&gt;</span>';
	}
}

function journal($Itemid_c, $option, $user, $submitvalue)
{
	global $user,$prof,$limitstart_journal,$enhanced_Config,$mosConfig_live_site;
	global $mainframe;

	$my = &JFactory::getUser();
	$database = &JFactory::getDBO();

	$ue_base_url = "index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$submitvalue&func=journal&index="._UE_MY_PROFILE_JOURNAL_TAB_LABEL."";	// Base URL string

	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">";

	$MamboMe_My_Profile_Journal = "\n<!-- MamboMe My Profile Journal Copyright (c) Jeffrey Randall 2005 -->\n";
	$MamboMe_My_Profile_Journal .= "<!-- Released under the GNU/GPL License http://www.gnu.org/copyleft/gpl.html-->\n";
	$MamboMe_My_Profile_Journal .= "<!-- Visit http://mambome.com for more info -->\n\n";

	if($my->id==$submitvalue)
	{
	?>
	<tr><td colspan="3" align="right">
	<?php
	echo "<a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$submitvalue&func=writeJournal&index="._UE_MY_PROFILE_JOURNAL_TAB_LABEL."\">"._UE_PROFILE_JOURNAL_TAB_WRITE_JOURNAL_ENTRY."\n";
	?>
	</a></td></tr><tr><td>&nbsp;</td></tr>
	<?php
	}
	//Count for page links
	if($my->id==$submitvalue)
	{
		$query = "SELECT count(journal_entry)
			  	  FROM #__cbe_mambome_journal
			  	  WHERE userid='".$submitvalue."'";

		if(!$database->setQuery($query))
		print $database->getErrorMsg();

		$total = $database->loadResult();
	}
	else
	{
		$query = "SELECT count(journal_entry)
			  	  FROM #__cbe_mambome_journal
			  	  WHERE userid='".$submitvalue."'
			  	  AND published=1";

		if(!$database->setQuery($query))
		print $database->getErrorMsg();

		$total = $database->loadResult();
	}

	if (empty($limitstart_journal)) {
		(isset($_GET["limitstart_journal"])) ? $limitstart_journal  = mosGetParam ( $_GET, 'limitstart_journal' , '' ) : $limitstart_journal = 0 ;
	} else {
		$limitstart_journal = intval($limitstart_journal);
	}

	$limit = $enhanced_Config['journal_entries_per_page']; //count starts at zero. 5 will show 4 entries.

	if ($limit > $total)
	{
		$limitstart_journal = 0;
	}

	//Display Journal Entries
	$query = "SELECT id,
					 userid,
					 journal_entry,
					 datetime,
					 published 
			  FROM #__cbe_mambome_journal 
			  WHERE userid='".$submitvalue."' 
			  ORDER BY datetime DESC";
	$query .= " LIMIT $limitstart_journal, $limit";
	$database->setQuery($query);
	$journal_entries = $database->loadObjectList();
	$count_journal_entries=count($journal_entries);

	$MamboMe_My_Profile_Journal .= "<tr><td>&nbsp;</td></tr>\n";

	if($count_journal_entries >0)
	{
		$MamboMe_My_Profile_Journal .= "<tr><th align=\"left\">"._UE_MY_PROFILE_JOURNAL_TAB_HEADER_ENTRIES."</th></tr>\n";
	}
	else
	{
		$MamboMe_My_Profile_Journal .= '<tr><td>'._UE_MY_PROFILE_JOURNAL_TAB_NO_ENTRIES.'</td></tr>';
	}

	$i = 1;

	foreach ($journal_entries as $journal_entry)
	{

		$i= ($i==1) ? 2 : 1;

		if ($enhanced_Config['journal_uselocale'] == '1') {
//			setlocale(LC_TIME, "de_DE");
			$time_format = $enhanced_Config['journal_localeformat']; // %d %B %G %T
			$tmp_Date = strftime($time_format, strtotime($journal_entry->datetime));
			$MamboMe_JournalDate = $tmp_Date;
		} else {
			$datetime="jS F Y H:i:s"; //date format
			$MamboMe_JournalDate = date($datetime, strtotime($journal_entry->datetime));
		}
		$MamboMeJournalText = $journal_entry->journal_entry;//get the journal entry text
		$JournalText = wordwrap($MamboMeJournalText,25, "\n", 1);//wrap those long words
		$JournalText = stripslashes($JournalText);//remove slashes for display

		$JournalText = language_filter($JournalText);

		if($my->id == $submitvalue)//display all entries in users journal if users own journal
		{
			$MamboMe_My_Profile_Journal .= "<tr><td class=\"sectiontableentry$i\">$MamboMe_JournalDate<br /><hr />$JournalText</td></tr>";
		}

		elseif($journal_entry->published == 1)//display only public entries to other users
		{
			$MamboMe_My_Profile_Journal .= "<tr><td class=\"sectiontableentry$i\">$MamboMe_JournalDate<br /><hr />$JournalText</td></tr>";
		}

		if($my->id == $submitvalue)//Show delete option if its users journal
		{
			$MamboMe_My_Profile_Journal .= "<tr><td class=\"sectiontableentry$i\">Options&nbsp;&nbsp;<a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$submitvalue&func=deleteJournalEntry&journal_id=$journal_entry->id\">"._UE_MY_PROFILE_JOURNAL_TAB_DELETE."</a>";

			if($journal_entry->published == 1)
			{
				$MamboMe_My_Profile_Journal .= "&nbsp;&nbsp;"._UE_MY_PROFILE_JOURNAL_TAB_STATUS.":&nbsp;Public&nbsp;&nbsp;Make<a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$submitvalue&func=unpubJournalEntry&journal_id=$journal_entry->id\">"._UE_MY_PROFILE_JOURNAL_TAB_PRIVATE."</a></td></tr>";
			}
			if($journal_entry->published == 0)
			{
				$MamboMe_My_Profile_Journal .= "&nbsp;&nbsp;"._UE_MY_PROFILE_JOURNAL_TAB_STATUS.":&nbsp;Private&nbsp;&nbsp;Make<a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$submitvalue&func=pubJournalEntry&journal_id=$journal_entry->id\">"._UE_MY_PROFILE_JOURNAL_TAB_PUBLIC."</a></td></tr>";
			}
		}

		//$i= ($i==1) ? 2 : 1;

	}
	echo $MamboMe_My_Profile_Journal;
	$colspan_j = (($isEditor) ? 4 : 3);
	if(count($journal_entries) > $limit)
	{
	 	echo "<tr><td colspan=\"".$colspan_j."\">\n";
 		writePagesLinksJournal($limitstart_journal, $limit, $total, $ue_base_url);
 		echo "</td></tr>\n";
	}
	echo '<tr><td>&nbsp;</td></tr><tr><td colspan="'.$colspan_j.'"><hr/>';
	writePagesLinksJournal($limitstart_journal, $limit, $total, $ue_base_url);
	echo "</td></tr>\n";
	echo "</table>\n";
}

function writeJournal($Itemid_c, $option, $user, $submitvalue)
{
	global $user,$prof,$enhanced_Config,$userpr,$journal,$acl,$_POST,$_REQUEST,$mosConfig_live_site;
	global $mainframe;

	$my = &JFactory::getUser();
	$database = &JFactory::getDBO();

	echo "\n<table width=\"100%\">\n";
	$MamboMe_My_Profile_Journal = "\n<!-- MamboMe My Profile Journal Copyright (c) Jeffrey Randall 2005 -->\n";
	$MamboMe_My_Profile_Journal .= "<!-- Released under the GNU/GPL License http://www.gnu.org/copyleft/gpl.html-->\n";
	$MamboMe_My_Profile_Journal .= "<!-- Visit http://mambome.com for more info -->\n\n";

	$journalWordLimit = $enhanced_Config['journal_set_word_limit'];

	//Display Journal Entry Submit Form
	if($my->id == $submitvalue)
	{
		$MamboMe_My_Profile_Journal .= "<tr><td><form action=\"index.php?option=com_cbe".$Itemid_c."&func=submitJournalEntry\" method=\"post\" name=\"journal\"></td></tr>\n";
		$MamboMe_My_Profile_Journal .= "<tr><td><textarea name=\"journal\" class=\"inputbox\" rows=\"4\" cols=\"35\" wrap=\"virtual\"  onKeyDown=\"limitText(this.form.journal,this.form.journalcountdown,$journalWordLimit);\" onKeyUp=\"limitText(this.form.journal,this.form.journalcountdown,$journalWordLimit);\"></textarea></td></tr>\n";
		$MamboMe_My_Profile_Journal .= "<tr><td><font size=\"1\">("._UE_JOURNAL_WORD_LIMIT_MAXIMUM_CHAR."&nbsp;$journalWordLimit)<br>"._UE_JOURNAL_WORD_LIMIT_YOU_HAVE."&nbsp;<input readonly type=\"text\" name=\"journalcountdown\" size=\"3\" value=\"$journalWordLimit\">&nbsp;"._UE_JOURNAL_WORD_LIMIT_CHAR_LEFT."</font></td></tr>";
		$MamboMe_My_Profile_Journal .= "<tr><td><input type=\"hidden\" name=\"userid\" value=\"$submitvalue\" /></td></tr>\n";
		$MamboMe_My_Profile_Journal .= "<tr><td><input type=\"submit\" name=\"submit\" class=button value=\"Submit\" onclick=\"return confirm('"._UE_MY_PROFILE_JOURNAL_TAB_CONFIRM."')\"></td></tr>\n";
		$MamboMe_My_Profile_Journal .= "</form>\n";
	}
	//go back link
	$MamboMe_My_Profile_Journal .= "<tr><td colspan=\"3\" align=\"right\"><a href=\"index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$submitvalue&func=journal&index="._UE_MY_PROFILE_JOURNAL_TAB_LABEL."\">"._UE_PROFILE_JOURNAL_TAB_WRITE_BACK."</a></td></tr>";	// Base URL string

	echo $MamboMe_My_Profile_Journal.'</table>';
}