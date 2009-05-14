<?php 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

class CBETemplate extends CBEExtension {
	var $id	= '';
	var $title	= '';
	var $description	= '';

	var $_params    = '';
	var $params	= '';

	function CBETemplate(&$_db,$tablename, $colname, $colid, $type) {
		parent::__construct(&$_db,$tablename, $colname, $colid, $type);
	}

	function setParams($params,$itemid) {
		$this->_params[$itemid] = $params;
	}

	function storeParams() {
		if (is_array($this->_params)) {
			$this->params='';
			foreach ($this->_params as $itemid => $params) {
				if ($params) {
					$this->params .= $itemid . '{' . $params . '}';
				}
			}
		}
		//die(print_r($this->tabparams));
		$this->_params = '';
	}

	function store() {
		return JTable::store();
	}
}
