<?php

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Plutos component
 *
 * @static
 * @package	Plutos
 * @subpackage	Plutos
 * @since 1.0
 */
class McloudViewAddlivestream extends JPatTemplateView
{
	function pat_render()
	{
		global $my, $remoteclient;

		$session = JFactory::getSession();

		$cats = $remoteclient->queryCategories(array());
		$catlist = "\n";
		foreach($cats as $cwalk => $ccur)
		    $catlist .= '<option value="'.$ccur{'id'}.'">'.stripslashes($ccur{'title'})."</option>\n";

		$this->addVars(array(
		    'CURRENT:USERNAME'		=> $my->username,
		    'NAMESPACE'			=> $remoteclient->namespace,
		    'CATEGORY_SELECT'		=> $catlist
		));

		if ($status_ok = $session->get('last_status_ok'))
		{
		    $this->addVars(array('OK' => $status_ok));
		    $this->showSubTmpl('ok');
#		    print "status_ok=$status_ok<br>\n";
		}
		if ($status_err = $session->get('last_status_err'))
		{
		    $this->addVars(array('ERROR' => $status_err));
		    $this->showSubTmpl('error');
#		    print "status_err=$status_err<br>\n";
		}

		if ($status_ok = JRequest::getString('status_ok'))
		{
		    $this->addVars(array('OK' => $status_ok));
		    $this->showSubTmpl('ok');
		}
		if ($status_err = JRequest::getString('status_err'))
		{
		    $this->addVars(array('ERROR' => $status_err));
		    $this->showSubTmpl('error');
		}
	}
}
