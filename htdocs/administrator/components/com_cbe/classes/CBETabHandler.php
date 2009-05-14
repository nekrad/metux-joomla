<?php 

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

class CBETabHandler extends JTable {
	var $tabid	= '';
	var $enabled	= 0;
	var $tabparams	= '';
	var $_params    = '';

	function __construct($modname, &$db=null) {
		$db = (!empty($db))?$db:JFactory::getDBO();

		$sql = "SELECT tabid FROM #__cbe_tabs WHERE tabname = '$modname'";
		$db->setQuery($sql);
		$id = $db->loadResult();

		if (!$id)
			return false;
		parent::__construct( '#__cbe_tabs', 'tabid', $db );
		$this->load($id);
	}

	function &getParams($Itemid='-1',$asTXT=0) {
		if (!is_array($this->_params)) {
			$this->parseParams();
		}
		if (!empty($this->_params[$Itemid])) {
			$params = $this->_params[$Itemid];
		} else {
			$params = $this->_params[-1];
		}
		if ($asTXT) {
			return $params['__TXT__'];
		}
		return $params;
	}

	function parseParams() {
		$this->_params =array('-1'=>array());
		if ($this->tabparams) {
			preg_match_all('/(.?[0-9]+){([^}]+)}/',$this->tabparams,$paramsList);
			//print_r($paramsList);
			//echo $this->tabparams;
			$count = count($paramsList[1]);
			for ($i=0; $i < $count; $i++) {
				$this->_params[$paramsList[1][$i]] = $this->paramsToArray($paramsList[2][$i]);
			}
		}
		//die(print_r($this->_params));
	}

	function paramsToArray( &$menuparams ) {
		$tmp = explode("\n", $menuparams);
		$res = array(); 
		foreach($tmp AS $a) {
			@list($key, $val) = explode('=', $a, 2);
			$res[$key] = str_replace('\n',"\n",$val);
		}
		$res['__TXT__'] = $menuparams;
		return $res;
        }

	function setParams($params,$itemid=-1) {
		$this->_params[$itemid] = $params;
	}

	function store() {
		if (is_array($this->_params)) {
			$this->tabparams='';
			foreach ($this->_params as $itemid => $params) {
				if ($params) {
					$this->tabparams .= $itemid . '{' . $params . '}';
				}
			}
		}
		return JTable::store();
	}

}
?>