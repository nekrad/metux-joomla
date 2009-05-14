<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
//********************************************
// Articles tab By Jeffrey Randall           *
// Copyright (c) 2005 Jeffrey Randall        *
// 20-05-2005 http://mambome.com             *
// Released under the GNU/GPL License        *
// Version 1.0                               *
//********************************************

//to do -add write article function

include_once('administrator/components/com_cbe/enhanced_admin/enhanced_config.php');
include_once('components/com_cbe/enhanced/enhanced_functions.inc');

$prof=JRequest::getVar('prof','');
$func=JRequest::getVar('func', 'articles' );
$my = &JFactory::getUser();
switch ($func)
{
	default:
	articles($option, $my->id, $user->id, _UE_UPDATE);
	break;
}



function writePagesLinksArticles($limitstart_articles, $limit, $total,$ue_base_url) {

	$pages_in_list = 10;

	$displayed_pages = $pages_in_list;
	$total_pages = ceil( $total / $limit );
	$this_page = ceil( ($limitstart_articles+1) / $limit );
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
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_articles=0\" title=\"" . _UE_FIRST_PAGE . "\">&lt;&lt; " . _UE_FIRST_PAGE . "</a>";
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_articles=$page\" title=\"" . _UE_PREV_PAGE . "\">&lt; " . _UE_PREV_PAGE . "</a>";
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
			echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_articles=$page\"><strong>$i</strong></a>";
		}
	}

	if ($this_page < $total_pages)
	{
		$page = $this_page * $limit;
		$end_page = ($total_pages-1) * $limit;
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_articles=$page\" title=\"" . _UE_NEXT_PAGE . "\">" . _UE_NEXT_PAGE . " &gt;</a>";
		echo "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_articles=$end_page\" title=\"" . _UE_END_PAGE . "\">" . _UE_END_PAGE . " &gt;&gt;</a>";
	}
	else
	{
		echo '<span class="pagenav">'. _UE_NEXT_PAGE .' &gt;</span> ';
		echo '<span class="pagenav">'. _UE_END_PAGE .' &gt;&gt;</span>';
	}
}

function articles($option, $user, $submitvalue)
{
	global $my,$user,$prof,$limitstart_articles,$enhanced_Config,$mosConfig_live_site,$mosConfig_hits,$mosConfig_vote;

	$database = &JFactory::getDBO();
//	$database->setQuery("SELECT id FROM #__menu WHERE (link LIKE '%com_cbe' OR link LIKE '%com_cbe%userProfile') AND (published='1' OR published='0')");
//	$Itemid = $database->loadResult();
	if ($GLOBALS['Itemid_com']!='') {
		$Itemid_c = $GLOBALS['Itemid_com'];
	} else {
		$Itemid_c = '';
	}

	$ue_base_url = "index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$submitvalue&func=articles&index="._UE_ARTICLES_TAB;	// Base URL string

	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">";

	//Count for page links

	$query = "SELECT count(created_by)
			  FROM #__content
			  WHERE created_by='".$submitvalue."'
	 		  AND state=1";
	if(!$database->setQuery($query))
	print $database->getErrorMsg();

	$total = $database->loadResult();

	if($total <1)
	{
		$no_articles = _UE_NOARTICLES;
		echo $no_articles;
	}

	if (empty($limitstart_articles)) {
		(isset($_GET["limitstart_articles"])) ? $limitstart_articles  = JRequest::getVar ('limitstart_articles' , '' ) : $limitstart_articles = 0 ;
	} else {
		$limitstart_articles = intval($limitstart_articles);
	}

	$limit = $enhanced_Config['articles_per_page']; //count starts at zero. 5 will show 4 entries.

	if ($limit > $total)
	{
		$limitstart_articles = 0;
	}

	$query = "SELECT a.id, a.title, a.hits,a.created, ROUND( r.rating_sum / r.rating_count ) AS rating,r.rating_count"
	. "\n FROM #__content AS a"
	. "\n LEFT JOIN #__content_rating AS r ON r.content_id=a.id"
	. "\n WHERE a.created_by=".$submitvalue.""
	. "\n AND a.state=1"
	. "\n AND ((publish_up <= NOW() AND NOW() <= publish_down) OR (publish_up <= NOW() AND publish_down = '0000-00-00 00:00:00'))"
	. "\n ORDER BY a.created DESC";
	$query .= " LIMIT $limitstart_articles, $limit";
	$database->setQuery( $query );
	$articles = $database->loadObjectList();

	$database->setQuery("select id from #__menu where link LIKE '%com_content%' AND published='1' AND access='0' ORDER BY id ASC LIMIT 1");
	$content_Itemid = $database->loadResult();
	if ($content_Itemid!='' || $content_Itemid!=NULL) {
		$content_Itemid = '&amp;Itemid='.$content_Itemid;
	} else {
		$content_Itemid = '';
	}

	$articleURL="index.php?option=com_content".$content_Itemid."&amp;task=view&amp;id=";

	$display_articles = "<tr class=\"sectiontableheader\">";
	$display_articles .= "<td>"._UE_ARTICLEDATE."</td>";
	$display_articles .= "<td>"._UE_ARTICLETITLE."</td>";

	if($mosConfig_hits)
	{
		$display_articles .= "<td>"._UE_ARTICLEHITS."</td>";
	}

	if($mosConfig_vote)
	{
		$display_articles .= "<td>"._UE_ARTICLERATING."</td>";
	}

	$display_articles .= "</tr>";

	$i=1;
	$hits="";
	$rating="";

	foreach($articles AS $article)
	{
		$i= ($i==1) ? 2 : 1;
		$formatedDate=JHTML::_('date', $article->created);

		$starImageOn = JHTML::_('image.site', 'rating_star.png', '/images/M_images/' );
		$starImageOff = JHTML::_('image.site', 'rating_star_blank.png', '/images/M_images/' );
		$img="";

		if($mosConfig_vote)
		{
			for ($j=0; $j < $article->rating; $j++)
			{
				$img .= $starImageOn;
			}
			for ($j=$article->rating; $j < 5; $j++)
			{
				$img .= $starImageOff;
			}

			$rating = '<td><span class="content_rating">';
			$rating .= $img . '&nbsp;/&nbsp;';
			$rating .= intval( $article->rating_count );
			$rating .= "</span></td>\n";
		}
		if($mosConfig_hits)
		{
			$hits = "<td>". $article->hits."</td>";
		}
		$display_articles .= "<tr class=\"sectiontableentry$i\"><td>".JHTML::_('date', $article->created)."</td><td><a href=\"".$articleURL.$article->id."\">".$article->title."</a></td>".$hits.$rating."</tr>\n";

	}

	if($total >0)
	{
		echo $display_articles;
	}

	//Write page links
	if(count($articles) > $limit) {
 		echo "<tr><td colspan=\"3\">";
 		echo writePagesLinksArticles($limitstart_articles, $limit, $total, $ue_base_url);
 		echo "</td></tr>\n";
	} else {
		echo "<tr><td colspan=\"3\">&nbsp;</td></tr><tr><td colspan=\"3\"><hr />";
		echo writePagesLinksArticles($limitstart_articles, $limit, $total, $ue_base_url);
		echo "</td></tr>\n";
	}
	echo "</table>\n";
}
?>