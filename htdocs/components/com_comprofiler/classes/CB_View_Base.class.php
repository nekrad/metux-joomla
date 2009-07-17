<?php

class CB_View_Base
{
    var $view_name;
    var $tmpl_engine;

    function show($option=false)
    {
	global $tmpl_engine;
	$tmpl_engine->readTemplatesFromFile('views/'.$this->view_name.'/view.tmpl');
	$this->prepare_render();
	echo $tmpl_engine->getParsedTemplate('view:'.$this->view_name);
    }
}
