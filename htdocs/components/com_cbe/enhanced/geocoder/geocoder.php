<?php
//****************************************************
// GeoCoder DispayTab     in Profile By Phil_K       *
// Copyright (c) 2007 Philipp Kolloczek_             *
// 22-02-2007 http://www.kolloczek.com               *
// Released under the GNU/GPL License                *
// Version 1.0.0                                     *
// File date: 22-02-2007                             *
//****************************************************
//
// REMEMBER TO REPLACE xxxtab with a unique tab-name
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

if (file_exists('components/com_cbe/enhanced/geocoder/language/'.$mosConfig_lang.'.php'))
{
	include_once('components/com_cbe/enhanced/geocoder/language/'.$mosConfig_lang.'.php');
}
else
{
	include_once('components/com_cbe/enhanced/geocoder/language/english.php');
}

include_once('administrator/components/com_cbe/enhanced_admin/enhanced_config.php');


if ($GLOBALS['Itemid_com']!='') {
	$Itemid_c = $GLOBALS['Itemid_com'];
} else {
	$Itemid_c = '';
}

$func	= JRequest::getVar('geoinfo_func', 'geocodertab');
$prof	= JRequest::getVar('prof','');
$limiter = intval(JRequest::getVar('limitstart_geocodertab', 0));

switch ($func)
{

	default:
		$my = &JFactory::getUser();
		cbe_geocodertab::display_tab($Itemid_c, $option, $limiter, &$my, $user);
	break;
}

class cbe_geocodertab {
	
	var $JS_helper = '';
	
	function writePagesLinks($limitstart, $limit=20, $total=20, $ue_base_url) {
	
		$pageLink_out = "";
		$pages_in_list = 10;
	
		$displayed_pages = $pages_in_list;
		$total_pages = ceil( $total / $limit );
		$this_page = ceil( ($limitstart+1) / $limit );
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
			$pageLink_out .= "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_xxxtab=0\" title=\"" . _UE_FIRST_PAGE . "\">&lt;&lt; " . _UE_FIRST_PAGE . "</a>";
			$pageLink_out .= "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_xxxtab=$page\" title=\"" . _UE_PREV_PAGE . "\">&lt; " . _UE_PREV_PAGE . "</a>";
		}
		else
		{
			$pageLink_out .= '<span class="pagenav">&lt;&lt; '. _UE_FIRST_PAGE .'</span> ';
			$pageLink_out .= '<span class="pagenav">&lt; '. _UE_PREV_PAGE .'</span> ';
		}
	
		for ($i=$start_loop; $i <= $stop_loop; $i++)
		{
			$page = ($i - 1) * $limit;
			if ($i == $this_page)
			{
				$pageLink_out .= "\n <span class=\"pagenav\">$i</span> ";
			}
			else
			{
				$pageLink_out .= "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_xxxtab=$page\"><strong>$i</strong></a> ";
			}
		}
	
		if ($this_page < $total_pages)
		{
			$page = $this_page * $limit;
			$end_page = ($total_pages-1) * $limit;
			$pageLink_out .= "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_xxxtab=$page\" title=\"" . _UE_NEXT_PAGE . "\">" . _UE_NEXT_PAGE . " &gt;</a>";
			$pageLink_out .= "\n<a class=\"pagenav\" href=\"$ue_base_url&amp;limitstart_xxxtab=$end_page\" title=\"" . _UE_END_PAGE . "\">" . _UE_END_PAGE . " &gt;&gt;</a>";
		}
		else
		{
			$pageLink_out .= '<span class="pagenav">'. _UE_NEXT_PAGE .' &gt;</span> ';
			$pageLink_out .= '<span class="pagenav">'. _UE_END_PAGE .' &gt;&gt;</span>';
		}
		
		return $pageLink_out;
	}
	
	//Display Functions
	function display_tab ($Itemid_c, $option, $limitstart, $my, $user) {
		global $database, $mosConfig_live_site, $mosConfig_absolute_path, $ueConfig, $enhanced_Config, $mosConfig_lang;
	
		$tab_content = "";
		$page_limit = 20;
		$isModerator = isModerator($my->id);
		$ue_base_url = "index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$user->id&func=xxtab&index="._UE_XXXTAB_LABEL;	// $submitvalue Base URL string
		/////////////

		/////////////
		//$tab_content = cbe_geocodertab::writePagesLinks($limitstart, $page_limit, $total, $ue_base_url);
		echo $tab_content;
	
	}
	
} // class end

?>