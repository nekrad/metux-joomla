<?php

defined('_JEXEC') or die('Restricted access');


function pagination_list_footer($list)
{
	$lang =& JFactory::getLanguage();
	$html = "<div class=\"list-footer\">\n";

	if ($lang->isRTL())
	{
		$html .= "\n<div class=\"counter\">".$list['pagescounter']."</div>";
		$html .= $list['pageslinks'];
		$html .= "\n<div class=\"limit\">".JText::_('Display Num').$list['limitfield']."</div>";
	}
	else
	{
		$html .= "\n<div class=\"limit\">".JText::_('Display Num').$list['limitfield']."</div>";
		$html .= $list['pageslinks'];
		$html .= "\n<div class=\"counter\">".$list['pagescounter']."</div>";
	}

	$html .= "\n<input type=\"hidden\" name=\"limitstart\" value=\"".$list['limitstart']."\" />";
	$html .= "\n</div>";

	return $html;
}

function pagination_list_render($list)
{
	
	$lang =& JFactory::getLanguage();
	$html = "<ul class=\"jth-pagination\">";
	$html .= '<li id="page-left">&laquo;</li>';
	
	if($lang->isRTL())
	{
		$html .= $list['start']['data'];
		$html .= $list['previous']['data'];

		$list['pages'] = array_reverse( $list['pages'] );

		foreach( $list['pages'] as $page ) {
			if($page['data']['active']) {
				
			}

			$html .= $page['data'];

			if($page['data']['active']) {
				
			}
		}

		$html .= $list['next']['data'];
		$html .= $list['end']['data'];
		
	}
	else
	{
		$html .= $list['start']['data'];
		$html .= $list['previous']['data'];

		foreach( $list['pages'] as $page )
		{
			if($page['data']['active']) {
				
			}

			$html .= $page['data'];

			if($page['data']['active']) {
				
			}
		}

		$html .= $list['next']['data'];
		$html .= $list['end']['data'];


	}
	$html .= '<li id="page-right">&raquo;</li>';
	$html .= "</ul>";
	return $html;
}

function pagination_item_active(&$item) {
	return "<li>&nbsp;<strong><a href=\"".$item->link."\" title=\"".$item->text."\">".$item->text."</a></strong>&nbsp;</li>";
}

function pagination_item_inactive(&$item) {
	return "<li>&nbsp;<span>".$item->text."</span>&nbsp;</li>";
}
?>
