<?php

jimport( 'joomla.application.module.helper' );

require_once('components/com_mcloud/source/MCloud_Render.class.php');
require_once('components/com_mcloud/source/MCloud_View_MediaList_Base.class.php');

class MCloud_View_Frontpage extends MCloud_View_MediaList_Base
{
    var $template_prefix = 'frontpage';
    var $default_width   = 300;
    var $default_height  = 225;
    var $medialist = array
    (
	1 => array(
	    'title'	=> 'Television Europe TV',
	    'medium_id'	=> 3726934
	),
	2 => array(
	    'title'	=> 'ATV News',
	    'medium_id'	=> 3291266
	),
	3 => array(
	    'title'	=> 'Viaggio in Liguria',
	    'medium_id'	=> 3726874
	),
	4 => array(
	    'title'	=> 'Da Ai Television',
	    'medium_id'	=> 3726910
	),
	5 => array(
	    'title'	=> 'Lifestyle Plus TV',
	    'medium_id'	=> 1972306
	),
	6 => array(
	    'title'	=> 'Lifestyle Plus TV',
	    'medium_id'	=> 1972306
	)
    );

    function render_player_box_video($medium_url, $medium, $player_width, $player_height)
    {
	return _template_fillout('frontpage/player-widget',array(
	    'PLAYER:WIDTH'	=> $player_width,
	    'PLAYER:HEIGHT'	=> $player_height,
	    'MEDIUM:URL'	=> $medium_url
	));    
    }

    function render_player_box_livestream_mplayer2($medium, $player_width, $player_height)
    {
	return _template_fillout('frontpage/player/livestream-mplayer2', array(
	    'PLAYER:WIDTH'	=> $player_width,
	    'PLAYER:HEIGHT'	=> $player_height,
	    'LIVESTREAM:URL'	=> $medium{'content_score'}
	));
    }

    function render_player_box_live($medium_url, $medium, $player_width, $player_height)
    {
	switch($medium{'content_type'})
	{
	    case 'livestream/mms':
	    case 'livestream/mplayer2':
		return $this->render_player_box_livestream_mplayer2($medium, $player_width, $player_height);
	    case 'livestream/flv':
		return $this->render_player_box_livestream_flv($medium, $player_width, $player_height);
	    default:
		'<strong> unsupported content-type: '.$medium{'content_type'}.'</strong>';
	}
    }

    function render_player_box($medium_url, $medium, $player_width, $player_height)
    {
	switch($medium{'media_class'})
	{
	    case 'livestream':
		    return $this->render_player_box_live($medium_url, $medium, $player_width, $player_height);
	    case 'video':
	    default:
		    return $this->render_player_box_video($medium_url, $medium, $player_width, $player_height);
	}
    }

    function _mlink($id)
    {
	return '/?frontpage_play_id='.$id;
    }

    function render_player($medium_url, $medium, $player_width, $player_height, $medialist)
    {
	return
	    _template_fillout('frontpage/player-frame', array(
		'PLAYER:WIDGET'		=> $this->render_player_box($medium_url, $medium, $player_width, $player_height),
		'MEDIUM:1:TITLE'	=> $medialist[1]{'title'},
		'MEDIUM:1:URL'		=> $this->_mlink(1),
		'MEDIUM:2:TITLE'	=> $medialist[2]{'title'},
		'MEDIUM:2:URL'		=> $this->_mlink(2),
		'MEDIUM:3:TITLE'	=> $medialist[3]{'title'},
		'MEDIUM:3:URL'		=> $this->_mlink(3),
		'MEDIUM:4:TITLE'	=> $medialist[4]{'title'},
		'MEDIUM:4:URL'		=> $this->_mlink(4),
		'MEDIUM:5:TITLE'	=> $medialist[5]{'title'},
		'MEDIUM:5:URL'		=> $this->_mlink(5),
		'MEDIUM:6:TITLE'	=> $medialist[6]{'title'},
		'MEDIUM:6:URL'		=> $this->_mlink(6)
	    ));
    }

    function render_topmedia()
    {
	(($limit = @$_REQUEST{'limit'}) || ($limit = 5));

	return MCloud_Render::render_mediatable_3column_3source(
	    $this->getMediaList('top-views',    $limit, @$_REQUEST{'media_class'}),
	    $this->getMediaList('top-featured', $limit, @$_REQUEST{'media_class'}),
	    $this->getMediaList('newest',       $limit, @$_REQUEST{'media_class'}),
	    'frontpage-3column',
	    'frontpage-empty',
	    'common/media-3column-iterator-element'
	);
    }

    function getparam($n)
    {
	if (!$this->params)
	{
	    $menuitemid = JRequest::getInt( 'Itemid' );
	    if ($menuitemid)
	    {
		$menu = JSite::getMenu();
		$this->params = $menu->getParams( $menuitemid );
	    }
	}
	if ($v = $this->params->get($n))
	    return $v;
	return $_REQUEST{$n};
    }

    function render_teaser()
    {
	$modpos = $this->getparam('teaser_moduleposition');
	if (!is_array($modules = JModuleHelper::getModules($modpos)))
	    return "";

	$text = "";
	foreach ($modules as $mwalk => $mcur)
	    $text .= JModuleHelper::renderModule($mcur);

	return $text;
    }

    function fetch_medium($id)
    {
	global $remoteclient, $my;

	if ($id == '*')
	{
            $res = $remoteclient->getMediaVisibleForUser(array(
		'username'      => $my->username,
		'order'         => 'random',
		'media_class'   => 'video',
		'limit'         => 42
	    ));
	    return array_pop($res);
	}
	else
	{
	    return $remoteclient->getMediumById($id, $my->username);
	}
    }

    function show($option)
    {
	global $remoteclient, $my;

	$this->medialist[1]{'title'}     = JRequest::getString('medium_1_title');
	$this->medialist[1]{'medium_id'} = JRequest::getString('medium_1_id');
	$this->medialist[2]{'title'}     = JRequest::getString('medium_2_title');
	$this->medialist[2]{'medium_id'} = JRequest::getString('medium_2_id');
	$this->medialist[3]{'title'}     = JRequest::getString('medium_3_title');
	$this->medialist[3]{'medium_id'} = JRequest::getString('medium_3_id');
	$this->medialist[4]{'title'}     = JRequest::getString('medium_4_title');
	$this->medialist[4]{'medium_id'} = JRequest::getString('medium_4_id');
	$this->medialist[5]{'title'}     = JRequest::getString('medium_5_title');
	$this->medialist[5]{'medium_id'} = JRequest::getString('medium_5_id');

	(($id = $_REQUEST{'frontpage_play_id'}) ||
	 ($id = 1));

	if ($medium_id = $this->medialist[$id]{'medium_id'})
	{
	    $medium = $this->fetch_medium($medium_id);
	    $medium_url = $medium{'conversions'}{'flash'}{'download_url'};
	}
	else
	{
	    $medium_url = $this->medialist[$id]{'url'};
	    $medium = array(
		'title'	=> $this->medialist[$id]{'title'},
		'conversions'	=> array(
		    'flash'	=> array(
			'download_url'		=> $this->medialist[$id]{'url'}
		    )
		)
	    );
	}

	$height = ((@$_REQUEST{'player_widget_width'})  ? $_REQUEST{'player_widget_width'}  : $this->default_width);
	$width  = ((@$_REQUEST{'player_widget_height'}) ? $_REQUEST{'player_widget_height'} : $this->default_height);

	echo _template_fillout('frontpage/main', array
	(
	    'FRONTPAGE:PLAYERBOX'	=>
		$this->render_player(
		    $medium_url,
		    $medium,
		    $height,
		    $width,
		    $this->medialist
		),
	    'FRONTPAGE:TOPMEDIA'		=> $this->render_topmedia(),
	    'FRONTPAGE:PLAYER-MENU:HEIGHT'	=> $_REQUEST{'player_menu_height'},
	    'FRONTPAGE:PLAYER-MENU:WIDTH'	=> $_REQUEST{'player_menu_width'},
	    'FRONTPAGE:PLAYER-FRAME:WIDTH'	=> $_REQUEST{'player_menu_width'} + $width,
	    'FRONTPAGE:TEASER'			=> $this->render_teaser()
	));
    }
}
