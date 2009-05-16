<?php

class MCloud_View_Categories
{
    function show($option)
    {
	switch ($_REQUEST{'categories_layout'})
	{
	    case '2column':	echo MCloud_View_Categories::__render_2column($option);	break;
	    case 'list':
	    default:		echo MCloud_View_Categories::show_list($option);	break;
	}
    }

    function show_list($option)
    {
	global $my, $remoteclient, $mcloud_url, $mcloud_config;

	$rows = $remoteclient->queryCategories(array());

	$n = 0;
	$listrows = '';
	foreach($rows as $walk => $cur)
	{
	    $listrows .= _template_fillout('category-list-entry', array
	    (
		'THUMB:WIDTH'		=> $mcloud_config->thumbwidth,
		'THUMB:URL'		=> $mcloud_url->default_thumb_url(),
		'CATEGORY:URL'		=> $mcloud_url->category_url($cur{'id'}),
		'CATEGORY:TITLE'	=> stripslashes($cur{'title'}),
		'CATEGORY:DESCRIPTION'	=> $cur{'description'},
		'K'			=> ($n++)%2
	    ));
	}
	
	return _template_fillout('category-list', array
	(
	    'CATEGORY-LIST-ENTRIES'	=> $listrows
	));
    }

    function __col($cat,$tmpl)
    {
	global $mcloud_url, $mcloud_config;
	if (!(is_array($cat)&&count($cat)))
	    return '';
	return _template_fillout($tmpl, array
	(
	    'THUMB:WIDTH'		=> $mcloud_config->thumbwidth,
	    'THUMB:URL'			=> $mcloud_url->default_thumb_url(),
	    'CATEGORY:URL'		=> $mcloud_url->category_url_vt(
		$cat{'id'}, $_REQUEST{'categories_layout'}, $_REQUEST{'medialist_layout'}),
	    'CATEGORY:TITLE'		=> stripslashes($cat{'title'}),
	    'CATEGORY:DESCRIPTION'	=> $cat{'description'},
	));
    }

    function __render_2column($option)
    {
	global $my, $remoteclient, $mcloud_url, $mcloud_config;
	$rows = $remoteclient->queryCategories(array());

	while(count($rows))
	    $content .= 
		'<tr>'.
		MCloud_View_Categories::__col(array_pop($rows),'categories-2column-cell').
		MCloud_View_Categories::__col(array_pop($rows),'categories-2column-cell').
		'</tr>';

	$output = _template_fillout('categories-2column', array
	(
	    'CATEGORY-LIST-ENTRIES'	=> $content
	));
	
	return $output;
    }
}
