<?php

class MCloud_View_GroupEdit
{
    function show($option)
    {
	global $Itemid, $my, $option, $remoteclient;

	$group = $remoteclient->getGroupById($_REQUEST{'group_id'});
	if (($my->username != $group{'owner_name'}) ||
	    ($remoteclient->namespace != $group{'owner_ns'}))
	{
	    print "Access denied\n";
	    return;
	}

	echo 
	    _template_fillout('js-checkaddgroupform', array()).
	    _template_fillout('group-edit', array
	    (
		'ACTION'  			=> sefRelToAbs('index.php?option='.$_REQUEST{'option'}.'&amp;Itemid='.$Itemid.'&amp;task=savegroup'),
		'VIEW'				=> 'savegroup',
		'USER:ID' 			=> $my->id,
		'HTML:GROUP:TITLE'		=> htmlentities($group{'title'}),
		'GROUP:DESCRIPTION'		=> $group{'description'},
		'GROUP:ID'			=> $group{'id'},
		'OPT:VISIBILITY:PUBLIC'		=> ($group{'visibility'}=='public'        ? 'selected="selected"' : ''),
		'OPT:VISIBILITY:REGISTERED'	=> ($group{'visibility'}=='registered'    ? 'selected="selected"' : ''),
		'OPT:VISIBILITY:PRIVATE'	=> ($group{'visibility'}=='private'       ? 'selected="selected"' : ''),
		'OPT:SUBSCRIBE:CONFIRM'		=> ($group{'subscribe_policy'}=='confirm' ? 'selected="selected"' : ''),
		'OPT:SUBSCRIBE:PUBLIC'		=> ($group{'subscribe_policy'}=='public'  ? 'selected="selected"' : ''),
		'OPT:SUBSCRIBE:PRIVATE'		=> ($group{'subscribe_policy'}=='private' ? 'selected="selected"' : '')
	    ));
    }
}
