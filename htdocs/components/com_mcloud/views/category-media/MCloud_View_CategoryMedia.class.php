<?php

require_once('components/com_mcloud/source/MCloud_View_MediaList_Base.class.php');

class MCloud_View_CategoryMedia extends MCloud_View_MediaList_Base
{
    var $template_prefix = 'category-media';

    function getMedia()
    {
	global $my, $remoteclient;
	
	(($category_id = $_REQUEST{'category_id'}) ||
	 ($category_id = $_REQUEST{'cat_id'}));

	return $remoteclient->getMediaVisibleForUser(array(
	    'username'	=> $my->username,
	    'category'	=> $category_id
	));
    }

    function show($option)
    {
	global $my, $remoteclient;

	(($category_id = $_REQUEST{'category_id'}) ||
	 ($category_id = $_REQUEST{'cat_id'}));

	$categories = $remoteclient->queryCategories(array('id'=>intval($category_id)));
	$category = array_pop($categories);
	echo _template_fill(
	    $this->render($this->getMedia()),
	    array( 
		'MEDIA:OWNER_NAME' 	=> $_REQUEST{'owner_name'},
		'CATEGORY:NAME'		=> $category{'title'}
	    )
	);
    }
}
