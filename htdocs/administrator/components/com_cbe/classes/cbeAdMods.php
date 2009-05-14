<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $mainframe, $mosConfig_sitename;
$mosConfig_sitename =  $mainframe->getCfg('sitename');

class cbeAdMods extends JTable {

	var $id=null;
	var $title=null;
	var $content=null;
	var $ordering=null;
	var $position=null;
	var $published=null;
	var $module=null;
	var $plugin=null;
	var $plugin_func=null;
	var $showtitle=null;
	var $params=null;
	var $iscore=null;
	var $_has_error = null;

	/**
    * @param database A database connector object
    */

	function __construct(&$db) {
		$this->cbeAdMods($db);
	}

	function cbeAdMods( &$db ) {
		//$this->JTable( '#__cbe_fields', 'fieldid', $db );
		parent::__construct( '#__cbe_admods', 'id', $db );
	} //end func


	function check() {
		$database = &JFactory::getDBO();
	
		$this->_has_error = 0;
		$chk_query = "SELECT id FROM #__cbe_admods WHERE module LIKE '%".cbGetEscaped($this->module)."%' OR "
				."plugin LIKE '%".cbGetEscaped($this->plugin)."%' OR plugin_func LIKE '%".cbGetEscaped($this->plugin_func)."%' LIMIT 1";
		$database->setQuery($chk_query);
		$chk_id = $database->loadResult();
		if ($this->id != $chk_id && $chk_id != NULL) {
			$this->_has_error = 1;
		}
		if ($this->id == 0) {
			$chk_ord = "SELECT max(ordering)+1 as ordering FROM #__cbe_admods";
			$database->setQuery($chk_ord);
			$this->ordering = $database->loadResult();
			if (!$database->query()) {
				$this->ordering = 0;
			}
		}
		return $this;
	}

} //end class
?>