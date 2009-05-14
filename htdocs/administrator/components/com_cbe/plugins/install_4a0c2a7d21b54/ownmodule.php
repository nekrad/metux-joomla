<?php
defined('_JEXEC') or die('Direct access to this location not allowed.');

class CBE_ownmodule extends CBETabHandler {
	var $params;
	function __construct($parent) {
		$this->parent = $parent;
		$this->params = $this->parent->getParams();
	}
	
	function display() {
		$mods = &JModuleHelper::getModules($this->params['ownmodule_moduleposition']);
		foreach ($mods as $mod)
			echo JModuleHelper::renderModule($mod);
	}
}
?>