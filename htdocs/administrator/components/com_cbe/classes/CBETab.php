<?php 
/**
 * The CBEPlugin
 * changed by www.joomla-cbe.de
 * 
 * original author:
 * @author Guillermo Vargas, http://joomla.vargas.co.cr
 * @email guille@vargas.co.cr, http://joomla.vargas.co.cr
 * @package Xmap
*/

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/** Wraps all configuration functions for CBE Tabs */
class CBETab extends CBEExtension {
	var $tabid	= '';
	var $title	= '';
	var $description	= '';
	var $width	= '';
	var $enabled	= 0;
	var $sys	= 0;
	var $enhanced_params	= '';

	var $_params    = '';
	var $tabparams	= '';
	/*
	var $id			= '';
	var $extension 	= '';
	var $published	= 0;
	var $params	= '';
	var $_params    = '';
	*/
	function CBETab(&$_db,$tablename, $colname, $colid, $type) {
		parent::__construct(&$_db,$tablename, $colname, $colid, $type);
	}


	function setParams($params,$itemid) {
		$this->_params[$itemid] = $params;
	}

	function storeEnhancedParams() {
		if (is_array($this->_params)) {
			$this->enhanced_params='';
			foreach ($this->_params as $itemid => $params) {
				if ($params) {
					$this->enhanced_params .= $params . "\n";
				}
			}
		}
		$this->_params = '';
	}
	
	function storeParams() {
		if (is_array($this->_params)) {
			$this->tabparams='';
			foreach ($this->_params as $itemid => $params) {
				if ($params) {
					$this->tabparams .= $itemid . '{' . $params . '}';
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
