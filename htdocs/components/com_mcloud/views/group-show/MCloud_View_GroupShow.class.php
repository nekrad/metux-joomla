<?php

require_once('components/com_mcloud/source/MCloud_Render.class.php');

class MCloud_View_GroupShow
{
    function show($option)
    {
	global $my, $remoteclient, $mcloud_url;

	$id = $_REQUEST{'group_id'};
	$group = $remoteclient->getGroupById($id);

	$is_admin=(($my->username==$group{'owner_name'})&&($remoteclient->namespace==$group{'owner_ns'}));
	
	$content = 
	    "<h1>".stripslashes($group{'title'})."</h1>".
	    "<p>".stripslashes($group{'description'})."</p>".
	    "<div>".
	    MCloud_Render::render_group_adminbutton($group, $is_admin).
	    MCloud_Render::render_group_membership($group, 0).
	    MCloud_Render::render_group_deletebutton($group, 0);
	    
	if (!count($group{'media'}))
	    $content .= 
		"<div> Keine Medien in dieser Gruppe </div>";
	else
	{
	    $othergrp = $remoteclient->getGroupsByOwner(array('username'=>$my->username));

	    $grpselect = '
    <select name="targetgroup">
	<option value="">----</option>
';

	    foreach($othergrp as $walk => $cur)
	    {
		$grpselect .= '
	<option value="'.$cur{'id'}.'"> ('.$cur{'namespace'}.') '.$cur{'title'}.'</option>';
	    }

	    $grpselect .= '
    </select>
';
	    $content .= "<div style=\"clear:both;\"></div></div>";
	    $k = 0;
	    $content_approved = '';
	    $mustapprove = '';
	    // first show the approved videos
	    foreach ($group{'media'} as $mw => $mc)
	    {
		if ($mc{'group_approved'} == 'f')
		    $mustapprove{$mw} = $mc;
		else
		{
		    $vars = array(
			'THUMB:URL'		=> $mc{'conversions'}{'thumb'}{'download_url'},
			'THUMB:WIDTH'		=> "100",
			'MEDIUM:URL'		=> $mcloud_url->medium_url($mc{'id'}),
			'MEDIUM:TITLE'		=> $mc{'title'},
			'MEDIUM:DESCRIPTION'	=> $mc{'description'},
			'MEDIUM:ID'		=> $mc{'id'},
			'CATEGORY:URL'		=> $mcloud_url->category_url($mc{'category_id'}),
			'CATEGORY:NAME'		=> ($mc{'category_title'} ? $mc{'category_title'} : '--'),
			'MEDIUM:OWNER_NAME'	=> $mc{'owner_name'},
			'REMOVE_URL'		=> $mcloud_url->group_medium_remove_url($mc{'id'}, $group{'id'}),
			'K'			=> ((++$k)%2)
		    );
		    $content_approved .= _template_fill(_template_load(
			($is_admin ? 'group-media-entry-admin' : 'group-media-entry-std')), $vars);
		}
	    }

	    $content .= _template_fill(
		_template_load(
		    ($is_admin ? 'group-medialist-approved' : 'group-medialist-visible')),
		array(
		    'MEDIA_APPROVED'	=>	$content_approved,
		    'MOVE_GROUPSELECT'	=>	$grpselect,
		    'GROUP:ID'		=>	$group{'id'},
		    'KICKBACK'		=> 	htmlentities($_SERVER['REQUEST_URI'])
		)
	    );

	    if (is_array($mustapprove) && $is_admin)
	    {
		$content .= '<h3> Noch nicht freigeschaltet </h3>';
		foreach($mustapprove as $mw => $mc)
		{
		    $thumb = $mc{'conversions'}{'thumb'}{'download_url'};
		    if (!$thumb)
			$thumb = $mcloud_url->default_thumb_url();
		    $url = $mcloud_url->medium_url($mc{'id'});

		    $content .= '
    <table border="0" cellspacing="0" cellpadding="0" class="box'.$k.'">
	<tr>
	    <td width="100" valign="top">
		<a href="'.$url.'">
		    <img src="'.$thumb.'" border="0" width="100" class="thumb'.$k.'" />
		</a>
	    </td>
	    <td width="*" valign="top">
		<div>
		    <a href="'.$mcloud_url->medium_url($mc{'id'}).'">'.$mc{'title'}.'</a>
		</div>
		    <div> Kategorie: <a href="'.$mcloud_url->category_url($row{'category_id'}).'">'.$row{'category_title'}.'
		    <ul>
			<li>
			    <a href="'.group_medium_approve_url($mc{'id'}, $group{'id'}).'"> Freischalten </a>
			</li>
			<li>
			    <a href="'.group_medium_remove_url($mc{'id'}, $group{'id'}).'"> Entfernen </a>
			</li>
		    </ul>
		<div>'.$mc{'description'}.'</div>
	    </td>
	    <td valign="top">
		<div> '.$mc{'owner_name'}.'</div>
	    </td>
	</tr>
    </table>';
		}
	    }
	    
	    if ($is_admin && allowed_group_memberlist())
	    {
		foreach($group{'users'} as $walk => $cur)
		{
		    $content_rows .= _template_fill(
			_template_load('group_user_entry_'.($cur{'approved'}=='t' ? 'approved':'unapproved')),
			array(
			    'USER:NS'	  => $cur{'user_ns'},
			    'USER:NAME'	  => $cur{'user_name'},
			    'URL:APPROVE' => __MCloud_HTML::group_user_approve_url($group{'id'},$cur{'user_ns'},$cur{'user_name'}),
			    'URL:REMOVE'  => __MCloud_HTML::group_user_remove_url ($group{'id'},$cur{'user_ns'},$cur{'user_name'})
		    ));
		}
		$content .= _template_fill(
		    _template_load('group_user_list'),
			array( 'ROWS' => $content_rows ));
	    }
	}
	
	echo $content;
    }
}
