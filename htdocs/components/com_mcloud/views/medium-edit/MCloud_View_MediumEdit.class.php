<?php

require_once('components/com_mcloud/source/MCloud_Render.class.php');

class MCloud_View_MediumEdit
{
    function showform($option, $row)
    {
	global $mcloud_url;

	switch ($row{'visibility'})
	{
	    case 'public':	$sel_public     = 'selected="selected"';	break;
	    case 'private':	$sel_private    = 'selected="selected"';	break;
	    case 'registered':	$sel_registered = 'selected="selected"';	break;
	    case 'group':	$sel_group      = 'selected="selected"';	break;
	    default:								break;
	}

	echo _template_fillout('media_edit_form', array
	(
	    'ACTION'			=> $mcloud_url->medium_editform_url($row{'id'}),
	    'MEDIUM:TITLE'		=> stripslashes($row{'title'}),
	    'MEDIUM:URL'		=> $mcloud_url->medium_url($row{'id'}),
	    'MEDIUM:DESCRIPTION'	=> stripslashes($row{'description'}),
	    'MEDIUM:TAGS'		=> stripslashes($row{'tags'}),
	    'MEDIUM:ID'			=> $row{'id'},
	    'MEDIUM:OWNER_USER'		=> @$row{'owner_user'},
	    'MEDIUM:PRICE'		=> @$row{'price'},
	    'THUMB:URL'			=> $row{'conversions'}{'thumb'}{'download_url'},
	    'CATEGORY_LIST'		=> MCloud_Render::render_edit_category_list($row{'category'}),
	    'SEL:PUBLIC'		=> @$sel_public,
	    'SEL:PRIVATE'		=> @$sel_private,
	    'SEL:REGISTERED'		=> @$sel_registered,
	    'SEL:GROUP'			=> @$sel_group
	    
	));
    }

    function show($option)
    {
	global $remoteclient, $my;

	$medium = $remoteclient->getMediumById($_REQUEST{'medium_id'}, $my->username);
	if ($medium{'owner_name'} != $my->username)
	    __redir_view('', 'Permission denied');
	else
	    $this->showform($option,$medium);
    }

    function store($option)
    {
	global $remoteclient, $my;

	$medium = $remoteclient->getMediumById($_REQUEST{'id'}, $my->username);

	if ($medium{'owner_name'} != $my->username)
	    __redir_view('my-media', 'Permission denied');

	$remoteclient->updateMedium(array
	(
	    id		=> $medium{'id'},
	    title	=> strip_tags(trim($_REQUEST{'title'})),
	    description	=> strip_tags(trim($_REQUEST{'description'})),
	    category	=> intval($_REQUEST{'category_id'}),
	    tags	=> strip_tags(trim($_REQUEST{'tags'})),
	    visibility	=> trim($_REQUEST{'visibility'}),
	    price	=> floatval($_REQUEST{'price'}),
	    username	=> $my->username
	));

	__redir_view('my-media', 'Ok');
    }
}
