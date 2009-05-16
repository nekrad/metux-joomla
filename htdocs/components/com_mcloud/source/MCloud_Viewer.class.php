<?php

class MCloud_Viewer
{
   /**
    * Insert Video Player
    */
    function flvplayer(&$row)
    {
	global $mosConfig_live_site, $database, $mainframe, $mcloud_config;

	$mainframe->addCustomHeadTag('<script type="text/javascript" src="'.$mosConfig_live_site.'/components/com_mcloud/js/swfobject.js"></script>');

	$flv_path = $row{'conversions'}{'flash'}{'download_url'};
	$flv_x    = $row{'conversions'}{'flash'}{'attr_xsize'};
	$flv_y    = $row{'conversions'}{'flash'}{'attr_ysize'};
	@$flv_a    = $flv_x/$flv_y;

	$player_width  = $mcloud_config->flvplay_width;
	$player_height = $mcloud_config->flvplay_height;

	@$player_height = round($flv_y/$flv_x*$player_width);
	@$player_asp    = $player_width/$player_height;

	$player_url   = "http://mcloud.metux.de/flowplayer/current/FlowPlayerDark.swf?".rand();
//	$player_scale = "orig";
	$player_scale = "scale";

	return "
	    <div style=\"text-align: center\">
		<div id=\"flashcontent\"> Bitte Javascript aktivieren </div>
	<script type=\"text/javascript\">
	    var so = new SWFObject(
		'".$player_url."', 
		'video', 
		'".$player_width."', 
		'".$player_height."', 
		'8',
		'#171d25');
	    so.addVariable('width',		'".$player_width."');
	    so.addVariable('height',		'".$player_height."');
	    so.addParam('allowFullScreen',	'true');
	    so.addParam('play', 		'true');
	    so.addParam('quality', 		'high');
	    so.addParam('scale', 		'".$player_scale."');
	    so.addParam('wmode', 		'transparent');
	    so.addVariable('config', 		\"{videoFile: '".$flv_path."'".
		(($mcloud_config->flvplay_overstretch == 1) ? ",initialScale: '".$player_scale."'" : "").",loop:'false'}\");
	    so.write('flashcontent');
	</script>
	</div>
";
    }

    function audioplayer(&$row)
    {
	global $mosConfig_live_site, $database, $mainframe, $mcloud_config;

	$mainframe->addCustomHeadTag('<script type="text/javascript" src="'.$mosConfig_live_site.'/components/com_mcloud/js/swfobject.js"></script>');

	$player_url   = "http://mcloud.metux.de/flowplayer/current/FlowPlayerDark.swf?".rand();
	$flv_path = $row{'conversions'}{'flash'}{'download_url'};

	// FIXME: use mcloud-provided player swf
	return "
	    <div style=\"text-align: center\">
		<div id=\"flashcontent\"> Bitte javascript aktivieren </div>
	<script type=\"text/javascript\">
	    var so = new SWFObject(
		'".$player_url."', 
		'video', 
		'".$mcloud_config->flvplay_width."', 
		'28', 
		'8', 
		'#171d25');
	    so.addVariable('width',		'".$mcloud_config->flvplay_width."');
	    so.addVariable('height',		'0');
	    so.addParam('play', 		'true');
	    so.addParam('quality', 		'high');
	    so.addParam('wmode', 		'transparent');
	    so.addVariable('config', 		\"{videoFile: '".$flv_path."'".
		(($mcloud_config->flvplay_overstretch == 1) ? ",initialScale: 'scale'" : "").",loop:'false'}\");
	    so.write('flashcontent');
	</script>
	</div>
";
    }

    function imgviewer($row)
    {
	return '<img src="'.$row{'download_url'}.'">';
    }

   /**
    * Add to groups
    */
    function render_addtogroups(&$row, $is_admin = false)
    {
	global $mosConfig_live_site, $Itemid, $my, $remoteclient, $mcloud_config;

	$url = sefRelToAbs($_SERVER['REQUEST_URI']);
	$ajaxa2g = "onsubmit=\"ajaxFunctionA2G();return false;\"";

	$groups = $remoteclient->getGroupsForMediaAdd(array
	(
	    'username'	=> $my->username,
	    'medium_id'	=> $row{'id'},
	    'is_admin'  => $is_admin
	));

	if (count($groups)<1)
	    return '';
	    
	$output = "
	<script language='javascript' type='text/javascript'>
	    //Browser Support Code
	    function ajaxFunctionA2G()
	    {
		var box = document.add2group.groupid.options;
		var chosen_value = box[box.selectedIndex].value;
		var ajaxRequest;  // The variable that makes Ajax possible!

	        try
		{
		    // Opera 8.0+, Firefox, Safari
		    ajaxRequest = new XMLHttpRequest();
		}
		catch (e) 
		{
		    // Internet Explorer Browsers
		    try
		    {
			ajaxRequest = new ActiveXObject('Msxml2.XMLHTTP');
		    } 
		    catch (e) 
		    {
			try
		        {
			    ajaxRequest = new ActiveXObject('Microsoft.XMLHTTP');
			}
			catch (e)
			{
			    // Something went wrong
			    alert('Someting broken ;-o');
			    return false;
			}
		    }
		}
		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange = function()
		{
		    if(ajaxRequest.readyState == 4)
		    {
			document.getElementById('add2groupresponse').style.border = '1px solid #171d25';
			document.getElementById('add2groupresponse').innerHTML    = ajaxRequest.responseText;
			document.getElementById('add2groupresponse').style.margin = '3px 0 3px 0';
		    }
		}
		ajaxRequest.open('GET', '".
		    $mosConfig_live_site.
		    "/index2.php?option=com_mcloud&task=ajaxadd2group&no_html=1&videoid=".
		    $row{'id'}."&groupid="."'+ chosen_value , true);
		ajaxRequest.send(null);
	    }
	//-->
	</script>".
	_template_fillout('media_addtogroup',array(
	    'ACTION'		=> $mosConfig_live_site.'/index.php?option=com_mcloud&Itemid='.$Itemid.'&task=addv2g',
	    'URL'		=> $url,
	    'MEDIUM:ID'		=> $row{'id'},
	    'AJAXA2G'		=> $ajaxa2g,
	    'SELECT_LIST'	=> MCloud_Viewer::render_group_select('groupid', 'add2gselect', $groups)
	));

	return $output;
    }

    function render_group_select($name, $css_class, $groups)
    {
	$output = '<!-- group_select --><select name="'.$name.'" class="'.$css_class.'">';
	foreach($groups as $gw => $gc)
	    $output .= '<option value ="'.$gc{'id'}.'">('.$gc{'owner_name'}.') '.$gc{'title'}.'</option>';
	$output .= '</select>';
	return $output;
    }

    function render_media_comments($row, $form)
    {
	$rows = '';
	foreach($row{'comments'} as $cwalk => $ccur)
	{
	    $rows .= _template_fillout('media_comments_entry', array(
		'COMMENT:MTIME'		=> strftime('%d.%m.%y %H:%M',strtotime($ccur{'mtime'})),
		'COMMENT:USER_NAME'	=> $ccur{'user_name'},
		'COMMENT:CONTENT'	=> $ccur{'content'}
	    ));
	}

	return 
	    _template_fillout('media_comments', array(
		'COMMENT_ROWS'	=> $rows
	    )).
	    ($form ? 
	    _template_fillout('media_comments_form', array(
		'MEDIUM:ID'		=> $row{'id'}
	    )) : '');
    }
}
