<?php
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

require_once('components/com_mcloud/source/MCloud_Render.class.php');

class McloudViewGroupshow extends JPatTemplateView
{
	/* render the list for plain users */
	function render_plain($media)
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
				    $vars['THUMB:URL'][]           = $mcloud_url->medium_thumb_url($mc);
				    $vars['THUMB:WIDTH'][]         = "100";
				    $vars['MEDIUM:URL'][]          = $mcloud_url->medium_url($mc{'id'});
				    $vars['MEDIUM:TITLE'][]        = $mc{'title'};
				    $vars['MEDIUM:DESCRIPTION'][]  = $mc{'description'};
				    $vars['MEDIUM:ID'][]           = $mc{'id'};
				    $vars['CATEGORY:URL'][]        = $mcloud_url->category_url($mc{'category_id'});
				    $vars['CATEGORY:NAME'][]       = ($mc{'category_title'} ? $mc{'category_title'} : '--');
				    $vars['MEDIUM:OWNER_NAME'][]   = $mc{'owner_name'};
				    $vars['REMOVE_URL'][]          = $mcloud_url->group_medium_remove_url($mc{'id'}, $this->group{'id'});
				    $vars['MEDIUM:OWNERS-MEDIA'][] = $mcloud_url->users_media_url($mc{'owner_name'});
		    		}
			}
			$this->addTmplVars($vars, '', 'component:media-visible:entry');
			$this->showSubTmpl('media-visible');
		}
		else
			$this->showSubTmpl('no-media-visible', false);
	}

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
					$vars['THUMB:URL'][]          = $mcloud_url->medium_thumb_url($mc);
					$vars['THUMB:WIDTH'][]        = "100";
					$vars['MEDIUM:URL'][]         = $mcloud_url->medium_url($mc{'id'});
					$vars['MEDIUM:TITLE'][]       = $mc{'title'};
					$vars['MEDIUM:DESCRIPTION'][] = $mc{'description'};
					$vars['MEDIUM:ID'][]          = $mc{'id'};
					$vars['CATEGORY:URL'][]       = $mcloud_url->category_url($mc{'category_id'});
					$vars['CATEGORY:NAME'][]      = ($mc{'category_title'} ? $mc{'category_title'} : '--');
					$vars['MEDIUM:OWNER_NAME'][]  = $mc{'owner_name'};
					$vars['REMOVE_URL'][]         = $mcloud_url->group_medium_remove_url($mc{'id'}, $this->group{'id'});
					$vars['MEDIUM:OWNERS-MEDIA'][] = $mcloud_url->users_media_url($mc{'owner_name'});
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
					$vars['THUMB:URL'][]           = $mcloud_url->medium_thumb_url($mc);
					$vars['THUMB:WIDTH'][]         = "100";
					$vars['MEDIUM:URL'][]          = $mcloud_url->medium_url($mc{'id'});
					$vars['MEDIUM:TITLE'][]        = $mc{'title'};
					$vars['MEDIUM:DESCRIPTION'][]  = $mc{'description'};
					$vars['MEDIUM:ID'][]           = $mc{'id'};
					$vars['CATEGORY:URL'][]        = $mcloud_url->category_url($mc{'category_id'});
					$vars['CATEGORY:NAME'][]       = ($mc{'category_title'} ? $mc{'category_title'} : '--');
					$vars['MEDIUM:OWNER_NAME'][]   = $mc{'owner_name'};
					$vars['MEDIUM:URL:REMOVE'][]   = $mcloud_url->group_medium_remove_url($mc{'id'}, $this->group{'id'});
					$vars['MEDIUM:URL:APPROVE'][]  = $mcloud_url->group_medium_approve_url($mc{'id'}, $this->group{'id'});
					$vars['MEDIUM:OWNERS-MEDIA'][] = $mcloud_url->users_media_url($mc{'owner_name'});
				}
			}
		}

		if (!is_array($vars))
			return $this->showSubTmpl('no-media-unapproved');

		$this->addTmplVars($vars, '', 'component:media-unapproved:entry');
		$this->showSubTmpl('media-unapproved');
	}

	function pat_render()
	{
		global $my, $remoteclient, $mcloud_url, $mcloud_access;

		$this->addVars(array(
		    'CURRENT:USERNAME'		=> $my->username,
		    'NAMESPACE'			=> $remoteclient->namespace
		));

		$id = $this->getParamStr('group_id');
		$this->group = $remoteclient->getGroupById($id);
		if ($mcloud_access->permit_GroupEdit($this->group))
		{
			/* render the group select list for moving media */
			$othergrp = $remoteclient->getGroupsByOwner(array('username'=>$my->username));
			$grps = array( '' => '----' );
			foreach($othergrp as $walk => $cur)
			    $grps[$cur{'id'}] = '('.$cur{'namespace'}.') '.$cur{'title'};
			$grpselect = $this->_render_selectlist('targetgroup', $grps);

			$this->render_approved($this->group{'media'});
			$this->render_unapproved($this->group{'media'});

			$this->showSubTmpl('admin');
			$this->addTmplVars(array
			(
				'GROUP:TITLE'		=> stripslashes($this->group{'title'}),
				'GROUP:DESCRIPTION'	=> stripslashes($this->group{'description'}),
				'URL:GROUP:EDIT'	=> $mcloud_url->group_edit_url($this->group{'id'}),
				'URL:GROUP:DELETE'	=> $mcloud_url->group_delete_url($this->group{'id'}),
				'MEMBERSHIP'		=> MCloud_Render::render_group_membership($this->group, 0),
				'DELETEBUTTON'		=> MCloud_Render::render_group_deletebutton($this->group, 0)
			));
		}
		else
		{
			$this->addTmplVars(array
			(
				'GROUP:TITLE'		=> stripslashes($this->group{'title'}),
				'GROUP:DESCRIPTION'	=> stripslashes($this->group{'description'})
			));
			$this->render_plain($this->group{'media'});
		}
	}
}
