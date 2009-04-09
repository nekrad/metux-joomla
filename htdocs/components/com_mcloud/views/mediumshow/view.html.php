<?php

defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

require_once('components/com_mcloud/source/MCloud_Render.class.php');

class McloudViewMediumshow extends JPatTemplateView
{
	var $medium;
	var $urlrender;
	var $access;

	/* admin view: render the approved media */
	function render_approved($media)
	{
		global $mcloud_url;
		if (is_array($media))
		{
			foreach ($media as $mw => $mc)
			{
				if ($mc{'group_approved'} == 'f')
					$mustapprove{$mw} = $mc;
				else
				{
					$vars['THUMB:URL'][]          = $mc{'conversions'}{'thumb'}{'download_url'};
					$vars['THUMB:WIDTH'][]        = "100";
					$vars['MEDIUM:URL'][]         = $mcloud_url->medium_url($mc{'id'});
					$vars['MEDIUM:TITLE'][]       = $mc{'title'};
					$vars['MEDIUM:DESCRIPTION'][] = $mc{'description'};
					$vars['MEDIUM:ID'][]          = $mc{'id'};
					$vars['CATEGORY:URL'][]       = $mcloud_url->category_url($mc{'category_id'});
					$vars['CATEGORY:NAME'][]      = ($mc{'category_title'} ? $mc{'category_title'} : '--');
					$vars['MEDIUM:OWNER_NAME'][]  = $mc{'owner_name'};
					$vars['REMOVE_URL'][]         = $mcloud_url->group_medium_remove_url($mc{'id'}, $group{'id'});
				}
		        }
		}

		if (!is_array($vars))
			return $this->showSubTmpl('no-media-approved');

		$this->addTmplVars($vars, '', 'component:media-approved:entry');
		$this->showSubTmpl('media-approved');
	}

	/* admin: render the unapproved media */
	function render_unapproved($media)
	{
		global $mcloud_url;

		if (is_array($media))
		{
			foreach ($media as $mw => $mc)
			{
				if ($mc{'group_approved'} == 'f')
				{
					$vars['THUMB:URL'][]          = $mc{'conversions'}{'thumb'}{'download_url'};
					$vars['THUMB:WIDTH'][]        = "100";
					$vars['MEDIUM:URL'][]         = $mcloud_url->medium_url($mc{'id'});
					$vars['MEDIUM:TITLE'][]       = $mc{'title'};
					$vars['MEDIUM:DESCRIPTION'][] = $mc{'description'};
					$vars['MEDIUM:ID'][]          = $mc{'id'};
					$vars['CATEGORY:URL'][]       = $mcloud_url->category_url($mc{'category_id'});
					$vars['CATEGORY:NAME'][]      = ($mc{'category_title'} ? $mc{'category_title'} : '--');
					$vars['MEDIUM:OWNER_NAME'][]  = $mc{'owner_name'};
					$vars['REMOVE_URL'][]         = $mcloud_url->group_medium_remove_url($mc{'id'}, $group{'id'});
				}
			}
		}

		if (!is_array($vars))
			return $this->showSubTmpl('no-media-unapproved');

		$this->addTmplVars($vars, '', 'component:media-unapproved:entry');
		$this->showSubTmpl('media-unapproved');
	}

	function _render_common($medium)
	{
		unset($medium{'conversions'});
		unset($medium{'comments'});
		$this->addTmplVars($medium, 'MEDIUM');
	}

	function _render_player_livestream($medium)
	{
	    switch ($medium{'content_type'})
	    {
		case 'livestream/mms':
		case 'livestream/mplayer2':
			$this->addTmplVars(array('LIVESTREAM:URL' => $medium{'content_score'}));
			$this->showSubTmpl('player:livestream:mplayer2');
		break;
		default:
			$this->showSubTmpl('player:livestream:unsupported');
	    }
	}

	function _render_player($medium)
	{
	    	switch ($medium{'media_class'})
		{
			case 'video':		$v = MCloud_Viewer::flvplayer($medium);		break;
			case 'image':		$v = MCloud_Viewer::imgviewer($medium);		break;
			case 'audio':		$v = MCloud_Viewer::audioplayer($medium);	break;
			case 'livestream':	return $this->_render_player_livestream($medium); break;
	    		default:
				return $this->ShowSubTmpl('player:unsupported');
		}

		$this->showSubTmpl('player:classic');
		$this->addTmplVars(array
		(
			'VIEWER'	=> $v
		));
	}

	function _render_groupadd($medium)
	{
		if (!JRequest::getString('no_groups'))
			$grp = MCloud_Viewer::render_addtogroups($medium, $this->access->is_admin());
		$this->addTmplVars(array('GROUPS'=>$grp));
	}

	function _render_conversions($medium)
	{
		if (JRequest::getString('no_conv'))
			return;

		$data['CLASS']        = 'Original';
		$data['CONTENT-TYPE'] = $medium{'content_type'};
		$data['URL']          = $medium{'download_url'};
		$data['SIZE_KB']      = round($medium{'content_size'}/1024);

		foreach($medium{'conversions'} as $convwalk => $convcur)
    		{
			if ($convcur{'conv_class'} == 'thumb');
			else
			{
				$data['CLASS']        = $convcur{'conv_class'};
				$data['CONTENT-TYPE'] = $convcur{'content_type'};
				$data['URL']          = $convcur{'download_url'};
				$data['SIZE_KB']      = round($convcur{'content_size'}/1024);
			}
		}

		$this->addTmplVars($data, 'CONV', 'component:conversions:entry');
	}

	function _render_comments()
	{
		global $mcloud_access;

		if (JRequest::getString('no_comments'))
			return;

		if (is_array($this->medium{'comments'}) && count($this->medium{'comments'}))
		{
			foreach($this->medium{'comments'} as $cwalk => $ccur)
			{
				$vars['MTIME'][]    = strftime('%d.%m.%y %H:%M',strtotime($ccur{'mtime'}));
				$vars['USERNAME'][] = $ccur{'user_name'};
				$vars['CONTENT'][]  = $ccur{'content'};
			}
			$this->addTmplVars($vars, 'COMMENT', 'component:comments:entry');
			$this->showSubTmpl('comments');
			$this->showSubTmpl('comments:entry');
		}
	
		if ($mcloud_access->permit_MediumCommenting($this->medium))
			$this->showSubTmpl('post-comment');		
	}

	function _render_recommend()
	{
		global $mcloud_access;
		if ($mcloud_access->permit_MediumRecommend($this->medium))
			$this->showSubTmpl('recommend');
	}

	function pat_render()
	{
		global $remoteclient, $mcloud_url, $mcloud_access;

		$this->setNoCache();
		
    		$medium_id = $this->getParamInt('medium_id');
		$medium = $remoteclient->Medium_GetByIdForUser($medium_id, $this->current_user->username);
		$remoteclient->medium_log_view($medium_id, $this->current_user->username);

		$this->medium    = $medium;
		$this->urlrender = $mcloud_url;
		$this->remote    = $remoteclient;
		$this->access    = $mcloud_access;

		// FIXME: check if medium is published.
		// FIXME: check if medium is approved
		// FIXME: check if medium is public if !($this->current_user->id)

	        // if medium_ideo doesn't exist - tell user
    		if (!(is_array($medium) && ($medium{'id'})))
		{
			$this->showSubTmpl('missing');
			$this->showSubTmpl('view', false);
			return;
		}

		$this->_render_common($medium);

		if (!$medium{'allowed'})
		{
			$this->showSubTmpl('must-buy');
		}
		else
		{
			$this->showSubTmpl('player');
			$this->_render_player($medium);
			$this->_render_groupadd($medium);
			$this->_render_conversions($medium);
		}

		$this->_render_comments($medium);
		$this->_render_recommend();
	}
}
