<?php

class MCloud_View_MediumShow
{
    function show($option)
    {
        global $my, $mosConfig_live_site, $remoteclient;

        // don't want to cache
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");   // Date in the past
        // get medium_ideo id from POST array
        $medium_id = intval($_REQUEST{'medium_id'});

	$medium = $remoteclient->Medium_GetByIdForUser($medium_id, $my->username);
	$remoteclient->medium_log_view($medium_id, $my->username);

	// FIXME: check if medium is published.
	// FIXME: check if medium is approved
	// FIXME: check if medium is public if !($my->id)

        // if medium_ideo doesn't exist - tell user
        if (!(is_array($medium) && ($medium{'id'})))
	{
	    echo _template_fillout('medium-show/missing', array());
	    return;
	}

	if (!$medium{'allowed'})
	{
	    $v = _template_fillout('medium-show/must-buy', array(
		'MEDIUM:ID'		=> $medium{'id'},
		'MEDIUM:TITLE'		=> $medium{'title'},
		'MEDIUM:DESCRIPTION'	=> $medium{'description'},
		'MEDIUM:CLASS'		=> $medium{'media_class'},
		'MEDIUM:OWNER_NS'	=> $medium{'owner_ns'},
		'MEDIUM:OWNER_NAME'	=> $medium{'owner_name'},
		'MEDIUM:PRICE'		=> $medium{'price'}
	    ));
	    $grptext = '';
	    $convtext = '';
	}
	else
	{
	    switch ($medium{'media_class'})
	    {
		case 'video':	$v = MCloud_Viewer::flvplayer($medium);		break;
	        case 'image':	$v = MCloud_Viewer::imgviewer($medium);		break;
		case 'audio':	$v = MCloud_Viewer::audioplayer($medium);	break;
	        default:
	    	    $v = _template_fillout('medium-show/unsupported-type', array());
		    return;
	    }

	    $buffer = _template_fillout('media-conversions-entry', array
    	    (
		'CONV:CLASS'		=> 'Original',
		'CONV:CONTENT-TYPE'	=> $medium{'content_type'},
		'CONV:URL'		=> $medium{'download_url'},
		'CONV:SIZE_KB'		=> round($medium{'content_size'}/1024)
	    ));

	    foreach($medium{'conversions'} as $convwalk => $convcur)
    	    {
		if ($convcur{'conv_class'} == 'thumb');
		else
		{
		    $buffer .= _template_fillout('media-conversions-entry', array(
			'CONV:CLASS'		=> $convcur{'conv_class'},
			'CONV:CONTENT-TYPE'	=> $convcur{'content_type'},
			'CONV:URL'		=> $convcur{'download_url'},
			'CONV:SIZE_KB'		=> round($convcur{'content_size'}/1024)
		    ));
		}
	    }

	    if (!@$_REQUEST{'no_groups'})
		$grptext = MCloud_Viewer::render_addtogroups($medium);

	    if (!@$_REQUEST{'no_conv'})
		$convtext = 
		    _template_fillout(
		    'media-conversions', 
		    array( 'CONVERSIONS-LIST' => $buffer ));

	}
	
	if (!@$_REQUEST{'no_comments'})
	    $commenttext = MCloud_Viewer::render_media_comments($medium, (!(!$my->username)));

	echo _template_fillout('medium-show/main', array
	(
	    'MEDIUM:ID'			=> $medium{'inode_id'},
	    'MEDIUM:TITLE'		=> $medium{'title'},
	    'MEDIUM:DESCRIPTION'	=> $medium{'description'},
	    'MEDIUM:TAGS'		=> $medium{'tags'},
	    'VIEWER'			=> $v,
	    'GROUPS'			=> $grptext,
	    'CONVERSIONS'		=> $convtext,
	    'COMMENTS'			=> $comments
	));
    }
}
