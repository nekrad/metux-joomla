<?php
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class McloudViewGroupcreate extends JPatTemplateView
{
	function pat_render()
	{
		global $my;

		if (($my->id) && allowed_groups())
		{
			$this->showSubTmpl('view');
			$this->showSubTmpl('denied', false);
		}
		else
		{
			$this->showSubTmpl('denied');
			$this->showSubTmpl('view', false);
		}
	}
}
