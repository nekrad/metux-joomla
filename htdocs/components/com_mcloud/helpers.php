<?php

define('MCLOUD_COMPONENT','com_mcloud');

function __redir_intern($task, $msg, $misc = '')
{
    global $mosConfig_live_site, $Itemid;
    $url = $mosConfig_live_site.'/index.php?option='.MCLOUD_COMPONENT.'&task='.$task.'&Itemid='.$Itemid.'&'.$misc;
    mosRedirect($url, $msg);
}

function __redir_view($v, $msg, $misc = '')
{
    global $mosConfig_live_site, $Itemid;
    $url = $mosConfig_live_site.'/index.php?option='.$_REQUEST{'option'}.'&view='.$v.'&Itemid='.$Itemid.'&'.$misc;
    mosRedirect($url, $msg);
}

function _template_fill($template, $vars, $prefix = '')
{
    global $mosConfig_live_site;

    foreach($vars as $walk => $cur)
	$template = str_replace('{'.$prefix.strtoupper($walk).'}', $cur, $template);
    $template=str_replace('{SESSION:NAME}', session_name(), 
	      str_replace('{SESSION:ID}',   session_id(), 
	      str_replace('{CURRENT:OPTION}', $_REQUEST{'option'},
	      str_replace('{CURRENT:ITEM_ID}', $_REQUEST{'Itemid'}, 
	      str_replace('{CURRENT:COMPONENT_PATH}', $mosConfig_live_site.'/components/'.$_REQUEST{'option'},
	        $template)))));
    return $template;
}

function _mcloud_getlang()
{
    global $_mcloud_lang_initialized;    
    $lang = JFactory::getLanguage();

    if (!$_mcloud_lang_initialized)
    {
	$lang->load('com_mcloud');
	$_mcloud_lang_initialized = 1;
    }

    return $lang->_strings;
}

function _template_load($name)
{
    if (!($lang = @$_REQUEST{'lang'}))
	$lang = '_default_';

    $x = implode('',@file('components/'.MCLOUD_COMPONENT.'/templates/'.$lang.'/'.$name.'.html'));
    if (!$x)
	throw new Exception("could not load template: $name");

    $strings = _mcloud_getlang();
    foreach ($strings as $swalk => $scur)
	$x = str_replace('{LANG:'.$swalk.'}', $scur, $x);

    return $x;
}

function _template_fillout($name, $vars)
{
    return _template_fill(_template_load($name), $vars);
}
