<?php
/**
* @version		$Id: view.html.php 11623 2009-02-15 15:23:08Z kdevine $
* @package		Joomla
* @subpackage	Weblinks
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Users component
 *
 * @static
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.0
 */
class ExtUserPageViewUser extends JView
{
	var $menu = array
	(
	    'title'		=> array
	    (
		label		=> 'Titelseite',
		type		=> 'title'
	    ),
	    'aboutme'		=> array
	    (
		label		=> '&Uuml;ber mich',
		type		=> 'aboutme'
	    ),
	    'activities'	=> array
	    (
		label		=> 'G&auml;stebuch',
		type		=> 'guestbook'
	    ),
	    'blog'		=> array
	    (
		label		=> 'Blog',
		type		=> 'blog'
	    ),
	    'activities'	=> array
	    (
		label		=> 'Aktivit&auml;ten',
		type		=> 'activities'
	    )
	);
	var $default = 'title';

	function getUserInfo($username)
	{
	    	global $database;
		
		$userinf = array();
		$dbo = JFactory::getDBO();

		$query = "SELECT * FROM #__users WHERE username=".$database->quote($username);
		$dbo->setQuery($query);
		$user_res = $dbo->loadAssoc();

		$userinf = array
		(
		    'user.name'			=> $user_res{'username'},
		    'user.uid'   		=> $user_res{'id'},
		    'user.fullname'		=> $user_res{'name'},
		    'user.gid'			=> $user_res{'gid'},
		    'user.register_date'	=> $user_res{'registerDate'},
		    'user.email'		=> $user_res{'email'},
		    'user.lastvisit_date'	=> $user_res{'lastVisitDate'},
		    'user.type'			=> $user_res{'usertype'}
		);

		$query = "SELECT * FROM #__comprofiler WHERE user_id = ".$database->quote($user_res{'id'});
		$dbo->setQuery($query);
		$cb_res = $dbo->loadAssoc();
		foreach($cb_res as $walk => $cur93)
		    $userinf{'cb.'.$walk} = $cur93;

		return $userinf;
	}

	function _suburl($sub)
	{
		return './?option=com_extuserpage&view=user'.
			'&username='.urlencode(JRequest::getString('username')).
			'&sub='.urlencode($sub).
			'&Itemid='.urlencode(JRequest::getString('Itemid'));
	}

	function getCurSub()
	{
	        if ($sub = JRequest::getString('sub'))
			return $sub;

		return $this->default;
	}

	function getCurSubEnt()
	{
		$sub = $this->getCurSub();
		if (is_array($ent = $this->menu{$sub}))
			return $ent;
		return $this->menu{$this->default};
	}
	
	/* prepare the menu for rendering */
	function prepareMenu()
	{
		$cursub = $this->getCurSub();
		foreach ($this->menu as $walk => $cur93)
		{
			if (!$cur93{'url'})
			    $this->menu{$walk}{'url'} = $this->_suburl($walk);
			if ($cursub == $walk)
			    $this->menu{$walk}{'active'} = true;
		}
	}

	function render_type_title()
	{
		$this->assignRef('titlepage_body', $this->userinfo{'cb.cb_titlepage'});
	}

	function _request_component($component, $params)
	{
		$url = 'http://'.$_SERVER['HTTP_HOST'].'/?option='.$component.'&template=componentonly';
		foreach ($params as $walk => $cur93)
		    $url .= '&'.urlencode($walk).'='.urlencode($cur93);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_COOKIE, session_name()."=".session_id());
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		return curl_exec($curl);
	}

	function render_type_blog()
	{
		$text = $this->_request_component('com_blog', array
		(
			'blog_hide_header'	=> 1,
			'blog_username'		=> $this->userinfo{'user.name'}
		));
		$this->assignRef('blog_body', $text);
	}

	function display( $tpl = null)
	{
		global $mainframe;

		$this->username = JRequest::getString('username');
		if ((!$this->username) || ($this->username == '***SELF***'))
		{
			$usr = JFactory::getUser();
			$this->username = $usr->username;
		}
	
		$this->userinfo = $this->getUserInfo($this->username);
		$this->prepareMenu();

#		// Get the page/component configuration
#		$params = &$mainframe->getParams();
#
#		$menus	= &JSite::getMenu();
#		$menu	= $menus->getActive();
#
#		// because the application sets a default page title, we need to get it
#		// right from the menu item itself
#		if (is_object( $menu )) {
#			$menu_params = new JParameter( $menu->params );
#			if (!$menu_params->get( 'page_title')) {
#				$params->set('page_title',	JText::_( 'Registered Area' ));
#			}
#		} else {
#			$params->set('page_title',	JText::_( 'Registered Area' ));
#		}
#		$document	= &JFactory::getDocument();
#		$document->setTitle( $params->get( 'page_title' ) );
#
#		// Set pathway information
#		$this->assignRef('params',		$params);
		
		/* render the content stuff / sub-pages */
		if (!is_array($ent = $this->getCurSubEnt()))
		{
		    print "Menu error<br>\n";
		    return;
		}

		switch ($t = $ent{'type'})
		{
			case 'title':		$this->render_type_title();			break;
			case 'blog':		$this->render_type_blog();			break;
			case 'guestbook':	$this->render_type_guestbook();			break;
			case 'aboutme':		$this->render_type_aboutme();			break;
			case 'activities':	$this->render_type_activities();		break;
			default:		print "<b> unsupported sub type: $t</b>";	break;
		}

		$this->assignRef('userinfo', $this->userinfo);
		$this->assignRef('menu',     $this->menu);
		$this->assignRef('menu_ent', $ent);

		parent::display($tpl);
	}
}
