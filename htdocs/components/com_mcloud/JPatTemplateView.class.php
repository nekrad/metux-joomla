<?php

jimport('joomla.application.component.view');
jimport('pattemplate.patTemplate');

abstract class JPatTemplateView extends JView
{
    abstract function pat_render();

    function addTmplVars($vars, $ns = '', $tmpl = '')
    {
	$prefix = ($ns ? strtoupper($ns).':' : '');
	foreach($vars as $walk => $cur)
	{
	    $pr = $prefix.strtoupper($walk);
	    if (is_array($cur))
	    {
		$plain = array();
		$htmlenc = array();
		$urlenc = array();
		foreach($cur as $cwalk => $ccur)
		{
		    $plain[$cwalk]   = $ccur.'';
		    $htmlenc[$cwalk] = htmlentities($ccur.'');
		    $urlenc[$cwalk]  = urlencode($ccur);
		}
		$tvars{$pr} = $plain;
		$tvars{'HTMLENC::'.$pr} = $htmlenc;
		$tvars{'URLENC::'.$pr}  = $urlenc;
	    }
	    else
	    {	
		$tvars{$pr}             = $cur.'';
		$tvars{'HTMLENC::'.$pr} = htmlentities($cur.'');
		$tvars{'URLENC::'.$pr}  = urlencode($cur.'');
	    }
	}
	$this->pat_engine->addVars(
	    ($tmpl ? $tmpl : $this->pat_tmplname),
	    $tvars
	);
    }

    function addVarsNS($ns, $vars)
    {
	$prefix = strtoupper($ns).':';
	foreach($vars as $walk => $cur)
	{
	    $pr = $prefix.strtoupper($walk);
	    $tvars{$pr}             = $cur.'';
	    $tvars{'HTMLENC::'.$pr} = htmlentities($cur.'');
	    $tvars{'URLENC::'.$pr}  = urlencode($cur.'');
	}

	$this->pat_engine->addVars(
	    $this->pat_tmplname,
	    $tvars
	);
    }

    function addVars($vars, $ns = '')
    {
	$prefix = ($ns ? strtoupper($ns).':' : '');
	foreach($vars as $walk => $cur)
	{
	    $pr = $prefix.strtoupper($walk);
	    $tvars{$pr}             = $cur.'';
	    $tvars{'HTMLENC::'.$pr} = htmlentities($cur.'');
	    $tvars{'URLENC::'.$pr}  = urlencode($cur.'');
	}

	$this->pat_engine->addVars(
	    $this->pat_tmplname,
	    $tvars
	);
    }

    function addObjectListNS($objs, $ns = '', $subtmpl = '')
    {
	$prefix = strtoupper($ns ? $ns.':' : '');
	$tmpl   = $this->pat_tmplname.($subtmpl ? ':'.$subtmpl : '');
	$this->pat_engine->addObject($tmpl, $objs, $prefix);
	$this->pat_engine->addObject($tmpl, $objs, 'HTMLENC::'.$prefix);
	$this->pat_engine->addObject($tmpl, $objs, 'URLENC::'.$prefix);
    }

    function setError($err)
    {
	$e = JText::_($err);
	$this->pat_engine->addVars(
	    $this->pat_tmplname,
	    array
	    (
		'ERROR'			=> $e,
		'HTMLENC::ERROR'	=> htmlentities($e),
		'URLENC::ERROR'		=> urlencode($e)
	));
	$this->showSubTmpl('error', true);
	$this->showSubTmpl('view',  false);
    }

    /* loads the language elements into the template */
    function handle_language()
    {
	$this->lang = & JFactory::getLanguage();
	$this->lang->load($this->component);
	$this->addVarsNS('LANG', $this->lang->_strings);
    }

    /* overwrite this to get in your own task handling */
    // return true to proceed with view display */
    function handle_task($task)
    {
#	print "WARNING: Unhandled task \"$task\"";
    }

    function showSubTmpl($name, $visible = true)
    {
	$this->pat_engine->setAttribute(
	    $this->pat_tmplname.':'.$name, 
	    'visibility',
	    ($visible ? 'visible' : 'hidden')
	);
    }

    function getCSSFile($name)
    {
	global $mainframe;
	$c = JRequest::getString('option');
	$t = $mainframe->getTemplate();
	
	$n_tmpl = "/templates/{$t}/html/{$c}/{$name}.css";
	$n_glob = "/components/{$c}/css/{$name}.css";
	
	if (file_exists(JPATH_BASE.$n_tmpl))
	    return $n_tmpl;
	else
	    return $n_glob;
    }

    function display($tpl = null)
    {
	global $template, $mainframe, $my;

	$this->current_user = $my;

	if ($task = JRequest::getCmd('task'))
	{
	    if (!$this->handle_task($task))
		return;	
	}

	$params = & $mainframe->getParams();
	$this->assignRef('params', $params);

	$this->pat_engine = new patTemplate();
	$this->pat_engine->setBasedir(trim(`pwd`));
	$this->pat_tmplname = 'component';
	if (preg_match('~/components/([A-Za-z\_\-\0-9\.]+)~', $this->_basePath, $m))
	    $this->component = $m[1];
	if (preg_match('~/templates/([A-Za-z\_\-\0-9\.]+)/html~', $this->_path{'template'}[0], $m))
	    $this->template  = $m[1];

	$layout  = $this->getLayout();
	$fn_tmpl = 'templates'.DS.$this->template.DS.'html'.DS.$this->component.DS.$this->_name.DS.$layout.'.tmpl';
	$fn_std  = 'components'.DS.$this->component.DS.'views'.DS.$this->_name.DS.'tmpl'.DS.$layout.'.tmpl';

	if (file_exists($fn_tmpl))
	    $fn = $fn_tmpl;
	else if (file_exists($fn_std))
	    $fn = $fn_std;
	else
	    throw new Exception("Missing view template: $fn_std");

	$this->pat_engine->readTemplatesFromInput($fn);

	$this->addVarsNS('PAGE', array
	(
	    'CLASS_SUFFIX'	=> $this->params->get('page_class_sfx'),
	    'TITLE'		=> $this->params->get('page_title'),
	    'DESCRIPTION'	=> $this->params->get('description'),
	    'CSS'		=> $this->getCSSFile('main')
	));
	
	$this->addVarsNS('CURRENT', array
	(
	    'COMPONENT'		=> $this->component,
	    'VIEW'		=> $this->_name,
	    'ITEM_ID'		=> JRequest::getString('Itemdid'),
	    'URI'		=> 'http://'.$_SERVER['SERVER_NAME'].
					($_SERVER['SERVER_PORT'] ? ':'.$_SERVER['SERVER_PORT'] : '').
					$_SERVER['REQUEST_URI']
	));

	$this->showSubTmpl('page_title', $this->params->get('show_page_title', 1) ? true : false);
	$this->showSubTmpl('view', true);
	$this->showSubTmpl('error', false);

	$this->pat_render();
	$this->handle_language();
	print $this->pat_engine->getParsedTemplate($this->pat_tmplname);
    }
    
    function _render_selectlist($name, $options, $default = '')
    {
	foreach($options as $value => $text)
	    $list .= '<option value='.$value.'">'.$text.'</option>';
	return 
	    '<select name="'.$name.'">'.$list.'</select>';
    }
    
	function getParamStr($name)
	{
	        return JRequest::getString($name);
	}
    
	function getParamInt($name)
	{
		return intval(JRequest::getString($name));
	}

	function setNoCache()
	{
		// don't want to cache
    		header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");   // Date in the past
        }
}
