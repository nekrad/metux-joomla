<?php

class MCloud_View_GroupCreate
{
    function show($option)
    {
	global $my;

	if (!$my->id) 
	    __redir_view('frontpage', '');

	echo 
	    _template_fillout('js-checkaddgroupform', array()).
	    _template_fillout(
		(allowed_groups() ? 'group_add' : 'group-add-denied'), 
	    array
	    (
		'ACTION'  => sefRelToAbs('index.php?option='.$_REQUEST{'option'}.'&amp;Itemid='.$Itemid.'&amp;task=savegroup'),
		'USER:ID' => $my->id	    	    
	    ));
    }
}
