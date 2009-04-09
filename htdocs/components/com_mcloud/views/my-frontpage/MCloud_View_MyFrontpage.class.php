<?php

require_once('components/com_mcloud/source/MCloud_View_MediaList_Base.class.php');

class MCloud_View_MyFrontpage extends MCloud_View_MediaList_Base
{
    var $template_prefix = 'my-frontpage';

    function render()
    {
	(($limit   = $_REQUEST{'limit'})   || ($limit   = 6));
	(($column0 = $_REQUEST{'column0'}) || ($column0 = 'newest'));
	(($column1 = $_REQUEST{'column1'}) || ($column1 = 'top-views'));
	(($column2 = $_REQUEST{'column2'}) || ($column2 = 'top-rate'));
	(($column3 = $_REQUEST{'column3'}) || ($column3 = 'top-comment'));

	return MCloud_Render::render_mediatable_4column_4source(array
	(
	    'media0' 		=> $this->getMediaList($column0, $limit, $_REQUEST{'media_class'}),
	    'media1' 		=> $this->getMediaList($column1, $limit, $_REQUEST{'media_class'}),
	    'media2' 		=> $this->getMediaList($column2, $limit, $_REQUEST{'media_class'}),
	    'media3' 		=> $this->getMediaList($column3, $limit, $_REQUEST{'media_class'}),
	    'template-filled'	=> 'my-frontpage/4column-frame-filled',
	    'template-empty'	=> 'frontpage-empty',
	    'template-cell'	=> 'common/media-4column-iterator-element'
	));
    }

    function show($option)
    {
	echo $this->render();
    }
}
