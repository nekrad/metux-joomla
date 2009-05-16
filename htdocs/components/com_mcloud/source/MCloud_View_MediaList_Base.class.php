<?php
#
# base class for media list/table viewers
#

require_once('components/com_mcloud/source/MCloud_Render.class.php');

class MCloud_View_MediaList_Base
{
    var $template_list_frame_filled;
    var $template_list_frame_empty;
    var $template_list_iterator_main;
    var $template_list_iterator_element;
    var $template_3col_frame_filled;
    var $template_3col_frame_empty;
    var $template_3col_iterator_main;
    var $template_3col_iterator_element;
    var $template_prefix;
#    var $featured_group_id = 3643812;

    function MCloud_View_MediaList_Base()
    {
	if (!$this->template_prefix)
	    print "missing template_prefix";

	if (!$this->template_list_iterator_main)
	     $this->template_list_iterator_main    = 'common/media-list-iterator-main';
	if (!$this->template_list_iterator_element)
	     $this->template_list_iterator_element = 'common/media-list-iterator-element';
	if (!$this->template_list_frame_filled)
	     $this->template_list_frame_filled     = $this->template_prefix.'/list-frame-filled';
	if (!$this->template_list_frame_empty)
	     $this->template_list_frame_empty      = $this->template_prefix.'/list-frame-empty';
	if (!$this->template_3col_iterator_main)
	     $this->template_3col_iterator_main    = 'common/media-3column-iterator-main';
	if (!$this->template_3col_iterator_element)
	     $this->template_3col_iterator_element = 'common/media-3column-iterator-element';
	if (!$this->template_3col_frame_filled)
	     $this->template_3col_frame_filled     = $this->template_prefix.'/3column-frame-filled';
	if (!$this->template_3col_frame_empty)
	     $this->template_3col_frame_empty      = $this->template_prefix.'/3column-frame-empty';
    }

    function _f($ml, $pre)
    {
#	foreach($ml as $walk => $cur)
#	    $ml{$walk}{'title'} .= ' ++ '.$pre;
	return $ml;
    }

    function getMediaList_Order($limit, $media_class, $order)
    {
	global $remoteclient, $my;
	return $this->_f($remoteclient->getMediaVisibleForUser(array(
	    'username'		=> $my->username,
	    'owner_name'	=> @$_REQUEST{'owner_name'},
	    'category'		=> @$_REQUEST{'category'},
	    'limit'		=> $limit,
	    'media_class'	=> $media_class,
	    'order'		=> $order
	)), 'ORDER-$order');
    }

    function getMediaList_Newest($limit, $media_class)
    {
	global $remoteclient, $my;
	return $this->_f($remoteclient->getMediaVisibleForUser(array(
	    'username'		=> $my->username,
	    'owner_name'	=> @$_REQUEST{'owner_name'},
	    'category'		=> @$_REQUEST{'category'},
	    'limit'		=> $limit,
	    'media_class'	=> $media_class,
	    'order'		=> 'newest'
	)), 'NEWEST');
    }

    function getMediaList_TopViews($limit, $media_class)
    {
	global $remoteclient, $my;
	return $this->_f($remoteclient->getMediaVisibleForUser(array(
	    'username'		=> $my->username,
	    'owner_name'	=> @$_REQUEST{'owner_name'},
	    'category'		=> @$_REQUEST{'category'},
	    'limit'		=> $limit,
	    'media_class'	=> $media_class,
	    'order'		=> 'viewcount',
	)), 'TOPVIEWS');
    }

    function getMediaList_TopRate($limit, $media_class)
    {
	global $remoteclient, $my;
	return $this->_f($remoteclient->getMediaVisibleForUser(array(
	    'username'		=> $my->username,
	    'owner_name'	=> @$_REQUEST{'owner_name'},
	    'category'		=> @$_REQUEST{'category'},
	    'limit'		=> $limit,
	    'media_class'	=> $media_class,
	    'order'		=> 'ratecount'
	)), 'TOPRATE');
    }

    function getMediaList_Featured($limit, $media_class)
    {
	global $remoteclient, $my;

	if (!$_REQUEST{'featured_group_id'})
	    syslog(LOG_WARNING, "com_mcloud: missing featured_group_id");

	return $this->_f($remoteclient->getMediaVisibleForUser(array(
	    'username'		=> $my->username,
	    'owner_name'	=> @$_REQUEST{'owner_name'},
	    'category'		=> @$_REQUEST{'category'},
	    'media_class'	=> $media_class,
	    'limit'		=> $limit,
	    'group_id'		=> $_REQUEST{'featured_group_id'},
	    'order'		=> 'random'
	)), 'FEATURED');
    }
    
    function getMediaList_TopComment($limit, $media_class)
    {
	global $remoteclient, $my;
	return $this->_f($remoteclient->getMediaVisibleForUser(array(
	    'username'		=> $my->username,
	    'owner_name'	=> @$_REQUEST{'owner_name'},
	    'category'		=> @$_REQUEST{'category'},
	    'media_class'	=> $media_class,
	    'limit'		=> $limit,
	    'order'		=> 'commentcount'
	)), 'TOPCOMMENT');
    }

    function getMediaList($type, $limit, $media_class)
    {
	global $remoteclient, $my;

	switch ($type)
	{
	    case 'newest':	
		return $this->getMediaList_Newest($limit, $media_class);	
	    break;

	    case 'top-views':	
		return $this->getMediaList_TopViews($limit, $media_class);	
	    break;

	    case 'top-views-today':
		return $this->getMediaList_Order($limit, $media_class, 'viewcount_today');
	    break;
	    
	    case 'top-views-month':
		return $this->getMediaList_Order($limit, $media_class, 'viewcount_month');
	    break;

	    case 'top-rate':	
		return $this->getMediaList_TopRate($limit, $media_class);	
	    break;

	    case 'featured':
	    case 'top-featured':
		return $this->getMediaList_Featured($limit, $media_class);
	    break;

	    case 'top-comment':	 
		return $this->getMediaList_TopComment($limit, $media_class);	
	    break;

	    default:
		throw new Exception("unhandled query view-type: $type");
	}
    }

    function render_list($rows)
    {
	global $mcloud_url, $mcloud_config;

	if (!$this->template_list_frame_filled)
	    throw new Exception("missing attr template_list_frame_filled");
	if (!$this->template_list_frame_empty)
	    throw new Exception("missing attr template_list_frame_empty");
	if (!$this->template_list_iterator_main)
	    throw new Exception("missing attr template_list_iterator_main");
	if (!$this->template_list_iterator_element)
	    throw new Exception("missing attr template_list_iterator_element");

	if (!count($rows)) 
	    return _template_fillout($this->template_list_frame_empty, array () );

	$k = 0;
	$entries = '';
	foreach($rows as $i => $row)
	{
		$thumb = $row{'conversions'}{'thumb'}{'download_url'};
		if (!$thumb)
		    $thumb = $mcloud_url->default_thumb_url();
		$url = $mcloud_url->medium_url($row{'id'});

		$entries .= _template_fillout('js-confirmdelete', array()).
		            _template_fillout($this->template_list_iterator_element, array(
				'THUMB:URL'		=> $thumb,
				'THUMB:WIDTH'		=> $mcloud_config->thumbwidth,
				'MEDIUM:TITLE'		=> $row{'title'},
				'MEDIUM:OWNER_NAME'	=> $row{'owner_name'},
				'MEDIUM:DESCRIPTION'	=> $row{'description'},
				'MEDIUM:URL'		=> $url,
				'MEDIUM:OWNERS-MEDIA'	=> $mcloud_url->users_media_url($row{'owner_name'}),
				'CATEGORY:URL'		=> $mcloud_url->category_url($row{'category_id'}),
				'CATEGORY:TITLE'	=> $row{'category_title'},
				'EDITBUTTONS'		=> MCloud_Render::render_media_editbuttons($row),
				'K'			=> $k,
			    ));
		$k = 1 - $k;
	}

	return _template_fillout(
	    $this->template_list_frame_filled,
	    array (
		'MEDIA:LIST'	=> _template_fillout(
		    $this->template_list_iterator_main,
		    array( 
			'MEDIA:LIST:ELEMENTS'	=> $entries
		     )
		)
	    )
	);
    }

    function render_3column($medialist)
    {
	if (is_array($medialist) && count($medialist))
	    return _template_fillout(
		$this->template_3col_frame_filled,
		array
		(
		    'MEDIA:LIST'	=> MCloud_Render::render_mediatable_3column(
					$medialist, 
					$this->template_3col_iterator_main,
					$this->template_3col_frame_empty,
					$this->template_3col_iterator_element)
		)
	    );
	else
	    return _template_fillout(
		$this->template_3col_frame_empty,
		array()
	    );
    }

    function getMedia()
    {
	throw new Exception("abstract");
    }

    function render($media)
    {
	switch ($_REQUEST{'medialist_layout'})
	{
	    case '3column':	return $this->render_3column($media);
	    case 'list':	return $this->render_list($media);
	    default:		return $this->render_list($media);
	}
    }

    function show($option)
    {
	throw new Exception("abstract");
    }
}
