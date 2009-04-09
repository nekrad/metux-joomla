<?php

class MCloud_Render
{
    function render_mediatable_cell($m, $tmpl)
    {
	global $mcloud_url, $mcloud_config;

	if ((!is_array($m))||(!count($m)))
	    return '<td></td>';

	$thumb = $m{'conversions'}{'thumb'}{'download_url'};
	if (!$thumb)
	    $thumb = $mcloud_url->default_thumb_url();

	return
	    _template_fillout($tmpl, array
	    (
		'MEDIUM:URL'		=> $mcloud_url->medium_url($m{'id'}),
		'MEDIUM:TITLE'		=> $m{'title'},
		'MEDIUM:DESCRIPTION'	=> $m{'description'},
		'MEDIUM:OWNER_NAME'	=> $m{'owner_name'},
		'MEDIUM:OWNERS-MEDIA'	=> $mcloud_url->users_media_url($m{'owner_name'}),
		'THUMB:WIDTH'		=> $mcloud_config->thumbwidth,
		'THUMB:URL'		=> $thumb,
		'MEDIUM:CATEGORY:URL'	=> $mcloud_url->category_url_vt($m{'category_id'}, $_REQUEST{'categories_layout'}, $_REQUEST{'medialist_layout'}),
		'MEDIUM:CATEGORY:TITLE'	=> $m{'category_title'},
		'EDITBUTTONS'		=> MCloud_Render::render_media_editbuttons($m)
	    ));
    }

    function render_mediacol($list, $maintmpl, $elemtmpl)
    {
	$elems = '';
	foreach($list as $lwalk => $lcur)
	    $elems .= MCloud_Render::render_mediacol_elem($lcur,$elemtmpl);    
	return _template_fillout($maintmpl, array
	(
	    'MEDIACOL:ELEMS'	=> $elems
	));
    }

    function render_mediacol_elem($m, $tmpl)
    {
	global $mcloud_url, $mcloud_config;

	if ((!is_array($m))||(!count($m)))
	    return '';

	$thumb = $m{'conversions'}{'thumb'}{'download_url'};
	if (!$thumb)
	    $thumb = $mcloud_url->default_thumb_url();

	return
	    _template_fillout($tmpl, array
	    (
		'MEDIUM:URL'		=> $mcloud_url->medium_url($m{'id'}),
		'MEDIUM:TITLE'		=> $m{'title'},
		'MEDIUM:DESCRIPTION'	=> $m{'description'},
		'MEDIUM:OWNER_NAME'	=> $m{'owner_name'},
		'MEDIUM:OWNERS-MEDIA'	=> $mcloud_url->users_media_url($m{'owner_name'}),
		'THUMB:WIDTH'		=> $mcloud_config->thumbwidth,
		'THUMB:URL'		=> $thumb,
		'MEDIUM:CATEGORY:URL'	=> $mcloud_url->category_url_vt($m{'category_id'}, $_REQUEST{'categories_layout'}, $_REQUEST{'medialist_layout'}),
		'MEDIUM:CATEGORY:TITLE'	=> $m{'category_title'}
	    ));
    }

    function render_mediatable_3column($medialist, $tabtemplate, $emptytemplate, $celltemplate)
    {
    	global $mcloud_url;

	$n=count($medialist);
	if ($n == 0) 
	    return _template_fillout($emptytemplate, array (
	    ));
	else 
	{
	    while (count($medialist))
	    {
		$rows .= '<tr>'.
		    MCloud_Render::render_mediatable_cell(array_shift($medialist), $celltemplate).
		    MCloud_Render::render_mediatable_cell(array_shift($medialist), $celltemplate).
		    MCloud_Render::render_mediatable_cell(array_shift($medialist), $celltemplate).
		    '</tr>';
	    }

	    return _template_fillout($tabtemplate, array (
		'MEDIA:LIST:ELEMENTS'	=> $rows
	    ));
	}
    }

    // render a 3column media table from 3 different sources
    // each source is shown verticaly in its own column
    function render_mediatable_3column_3source($medialist1, $medialist2, $medialist3, $tabtemplate, $emptytemplate, $celltemplate)
    {
    	global $mcloud_url;

	$run = true;
	while ($run)
	{
	    $ent1 = @array_shift($medialist1);
	    $ent2 = @array_shift($medialist2);
	    $ent3 = @array_shift($medialist3);
		
	    if (is_array($ent1) || is_array($ent2) || is_array($ent3))
		$rows .= 
		    '<tr>'.
			MCloud_Render::render_mediatable_cell($ent1, $celltemplate).
			MCloud_Render::render_mediatable_cell($ent2, $celltemplate).
			MCloud_Render::render_mediatable_cell($ent3, $celltemplate).
		    '</tr>';
	    else
		$run = false;
	}
	return _template_fillout($tabtemplate, array (
	    'MEDIA:LIST:ELEMENTS'	=> $rows
	));
    }

    // render a 4column media table from 4 different sources
    // each source is shown verticaly in its own column
    function render_mediatable_4column_4source($param)
    {
	$medialist1    = $param{'media0'};
	$medialist2    = $param{'media1'};
	$medialist3    = $param{'media2'};
	$medialist4    = $param{'media3'};
	$tabtemplate   = $param{'template-filled'};
	$emptytemplate = $param{'template-empty'};
	$celltemplate  = $param{'template-cell'};

    	global $mcloud_url;

	$run = true;
	while ($run)
	{
	    $ent1 = @array_shift($medialist1);
	    $ent2 = @array_shift($medialist2);
	    $ent3 = @array_shift($medialist3);
	    $ent4 = @array_shift($medialist4);
		
	    if (is_array($ent1) || is_array($ent2) || is_array($ent3))
		$rows .= 
		    '<tr>'.
			MCloud_Render::render_mediatable_cell($ent1, $celltemplate).
			MCloud_Render::render_mediatable_cell($ent2, $celltemplate).
			MCloud_Render::render_mediatable_cell($ent3, $celltemplate).
			MCloud_Render::render_mediatable_cell($ent4, $celltemplate).
		    '</tr>';
	    else
		$run = false;
	}
	return _template_fillout($tabtemplate, array (
	    'MEDIA:LIST:ELEMENTS'	=> $rows
	));
    }

    function render_media_editbuttons($row)
    {
	global $mosConfig_live_site, $Itemid, $mosConfig_absolute_path, $my, $mcloud_url;

	$vtitle = stripslashes($row{'title'});

	$img_edit= $mosConfig_live_site."/components/com_mcloud/images/icons/edit.png";
	$img_del = $mosConfig_live_site."/components/com_mcloud/images/icons/delete.png";

	// check video owner
	$owner = $row{'owner_name'};
	$vid   = $row{'id'};

	$usrvfuncs = "";

	// present edit options
	if ($my->id) 
	{
	    if ($my->username == $owner)
	    {
		$usrvfuncs = " <a href=\"".
		    $mcloud_url->medium_edit_url($vid).
		    "\" title=\""."Bearbeiten"."\">
		    <img src=\"$img_edit\" border=\"0\" alt=\""."Bearbeiten"."\" />
		    </a> 
		    <a href=\"".
		    $mcloud_url->medium_delete_url($vid).
		    "\" title=\""."Entfernen"."\" onclick=\"return confirmSubmit()\">
		    <img src=\"$img_del\" border=\"0\" alt=\""."Entfernen"."\" /></a>";
	    }
	}
	return $usrvfuncs;
    }

    function render_category_list()
    {
	global $my, $remoteclient;
	$categories = $remoteclient->queryCategories(array());
	$output = "
	<select name=\"category_id\" size=\"1\" class=\"inputbox\" style=\"width: 200px;\">
			<option value=\"none\" selected=\"selected\"> Kategorie w&auml;hlen </option>
";
	foreach($categories as $walk => $cur)
	{
	    $catname=stripslashes($cur{'title'});
	    $output .= "<option value=\"{$cur{'id'}}\">$catname</option>";
  	}
	$output .= "
	</select>
";
	return $output;
    }

    function render_edit_category_list($cat)
    {
	global $my, $remoteclient;

	$categories = $remoteclient->queryCategories(array());
	$code  = "<select name=\"category_id\" size=\"1\" class=\"inputbox\" style=\"width: 200px;\">";
	foreach($categories as $walk => $cur)
	{
	    if ($cur{'id'} == $cat)
		$select="selected=\"selected\"";
	    else
		$select="";
	    $code .= "<option value=\"".$cur{'id'}."\" ".$select.">".stripslashes($cur{'title'})."</option>";
	}
	$code .= "</select>";
	return $code;
    }

    function render_group_adminbutton(&$row, $is_admin)
    {
    	global $mosConfig_live_site, $Itemid, $option, $mcloud_config;

	if ($is_admin)
	    return _template_fillout('group-toolbar-admin', array
	    (
		'HTML:URL:GROUP:ADMIN'	=> sefRelToAbs(
		    'index.php?option='.$option.
		    '&amp;view=groupedit&amp;Itemid='.$Itemid.
		    '&amp;group_id='.$row{'id'}
		)
	    ));

	// not admin
	if ($mcloud_config->cbint == 1) 
	    $admin = "<a href=\"".sefRelToAbs(
		    "index.php?option=com_comprofiler&amp;task=userProfile&amp;Itemid=".
		    $Itemid."&amp;user=".$row{'owner_name'})."\">".$row{'user_name'}."</a>";
	else
    	    $admin = $row{'owner_name'};
	    
	return _template_fillout('group-toolbar-owner', array
	(
	    'GROUP_ADMIN'	=> $admin
	));
    }

    function render_group_deletebutton(&$row)
    {
	global $mosConfig_live_site, $my, $Itemid;
	if ($my->username != $row{'owner_name'})
	    return;

	return 
		"<div class=\"gdelete\">".
		"<form name=\"deletegroup\" action=\"".$mosConfig_live_site."/index.php?option=com_mcloud&amp;Itemid=".$Itemid."&amp;task=deletegroup\" method=\"post\">".
		"<input type=\"hidden\" name=\"userid\" value=\"".$my->id."\" />".
		"<input type=\"hidden\" name=\"groupid\" value=\"".$row{'id'}."\" />".
		"<input type=\"image\" src=\"".$mosConfig_live_site."/components/com_mcloud/images/icons/delete.png\" alt=\"Entfernen\"> Entfernen".
		"</form>".
		"</div>";
    }

    function render_group_membership($row)
    {
	global $mosConfig_live_site, $my, $Itemid;
	$url = sefRelToAbs($_SERVER['REQUEST_URI']);
	$action    = $mosConfig_live_site.'/index.php';
	$modprefix = $mosConfig_live_site.'/components/com_mcloud/';

	$vars = array
	(
	    'ITEM_ID'	=> $Itemid,
	    'USER:ID'	=> $my->id,
	    'GROUP:ID'	=> $row{'id'},
	    'URL'	=> $url,
	    'MODPREFIX'	=> $modprefix,
	    'ACTION'	=> $action
	);

	$tmpl_join  = _template_load('group_membership_join');
	$tmpl_leave = _template_load('group_membership_leave');

	$text_join  = _template_fill($tmpl_join, $vars);
	$text_leave = _template_fill($tmpl_leave, $vars);

	return $text_join.$text_leave;
    }
}
