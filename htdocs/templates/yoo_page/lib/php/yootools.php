<?php
/**
 * YOOTools
 *
 * @author		yootheme.com
 * @copyright	Copyright (C) 2007 YOOtheme Ltd & Co. KG. All rights reserved.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class YOOTools {

	/* parameters */
	var $params;

	/* internal settings */
	var $internal;

	/* javascript settings */
	var $javascript;

	/* jdocument */
	var $document;

	function YOOTools() {
		global $mainframe;

		$this->document = &JFactory::getDocument();

		$filename = JPATH_ROOT . DS . 'templates' . DS . $mainframe->getTemplate() . DS . 'params.ini';
		$this->params = ($content = @ file_get_contents($filename)) ? new JParameter($content) : null;

		$this->internal = array(
			/* menu */
			"accordionMenu"       => array("mainmenu" => 2, "othermenu" => 1, "usermenu" => 1, "lifestyle" => 1)
			);
		
		$this->javascript = array(
			/* template */
			"tplurl"              => "'<VAL>'",			
			/* color */
			"color"               => "'<VAL>'",
			/* layout */
			"layout"              => "'<VAL>'",
			/* style switcher */
			"fontDefault"         => "'<VAL>'", 
			"widthDefault"        => "'<VAL>'",
			"widthThinPx"         => "<VAL>",
			"widthWidePx"         => "<VAL>",
			"widthFluidPx"        => "<VAL>"
			);
	}

	function &getInstance() {
		static $instance;

		if ($instance == null) {
			$instance = new YOOTools();
		}
		
		return $instance;
	}

	function getParam($key, $default = '', $group = '_default') {

		if (array_key_exists($key, $this->internal)) {
			return $this->internal[$key];
		}
		
		return $this->params->get($key, $default, $group);
	}

	function setParam($key, $value = '') {
		$this->internal[$key] = $value;
	}

	/* Javascript */
	
	function getJavaScript() { 
		$js = "var YtSettings = { ";
		$seperator = false;
		foreach($this->javascript as $key => $val) {
			$setting = $this->getParam($key);
			if(is_bool($setting)) {
				$setting ? $setting = "true" : $setting = "false";
			}
			if(is_float($setting)) {
				$setting = number_format($setting, 2, ".", "");
			}
			$seperator ? $js .= ", " : $seperator = true;			
			$js .= $key . ": " . str_replace("<VAL>", $setting, $val);
		}		
		$js .= " };";
		return $js;
	}

	function showJavaScript() {
		echo $this->getJavaScript();
	}

	/* Styles */

	function setStyle($condition, $key, $value)
	{
		if ($this->evalStyleCondition($condition)) {
			$this->document->params->set($key, $value);
		}
	}
	
	function evalStyleCondition($condition)
	{
		if (is_bool($condition)) return $condition;

		$parts    = explode(' ', $condition);
		$commands = array('+', '-', '&&', '||', '(', ')', '==', '!=');

		for($i = 0; $i < count($parts); $i++) {
			if (!(in_array($parts[$i], $commands) || is_numeric($parts[$i]))) {
				$name	   = strtolower($parts[$i]);
				$parts[$i] = $this->document->countModules($name);
			}
		}

		$str = 'return '.implode(' ', $parts).';';
		return eval($str);
	}
	
	/* Styleswitcher */
	
	function getCurrentStyle() {
		$styleFont  = isset($_COOKIE['ytstylefont']) ? $_COOKIE['ytstylefont'] : $this->getParam('fontDefault');
		$styleWidth = isset($_COOKIE['ytstylewidth']) ? $_COOKIE['ytstylewidth'] : $this->getParam('widthDefault');

		return $styleFont . " " . $styleWidth;
	}
	
	function getCurrentColor() {
		$color  = isset($_COOKIE['ytcolor']) ? $_COOKIE['ytcolor'] : $this->getParam('color');
		
		if(isset($_GET['yt_color'])) {
			setcookie('ytcolor', $_GET['yt_color'], time() + 3600, '/'); 
			$color = $_GET['yt_color'];
		}
		
		return $color;
	}	

	function getActiveMenuItemNumber($menu, $level) {
		$jmenu    = &JSite::getMenu();
		$active   = $jmenu->getActive();
		$menutype = isset($active) ? $active->menutype : null;
		$path     = isset($active) ? $active->tree : array();
				
		if ($menu == $menutype && array_key_exists($level, $path)) {
			$item = $jmenu->getItem($path[$level]);
			return $item->ordering;
		}
		
		return null;
	}
}

?>