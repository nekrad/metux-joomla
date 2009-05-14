<?php 
/**
 * The CBEExtension
 * changed by www.joomla-cbe.de
 * 
 * original author:
 * @author Guillermo Vargas, http://joomla.vargas.co.cr
 * @email guille@vargas.co.cr, http://joomla.vargas.co.cr
 * @package Xmap
*/

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/** Wraps all configuration functions for CBE Tabs */
class CBEExtension extends JTable {
	var $_cbetype		= '';
	var $_cbetablename	= '';
	var $_cbecolname		= '';

	function CBEExtension(&$_db,$tablename, $colname, $colid, $type) {
		parent::__construct($tablename, $colid, $_db );
		
		$this->_cbetype		= $type;
		$this->_cbetablename	= $tablename;
		$this->_cbecolname	= $colname;

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
		if ($this->enhanced_params) {
			preg_match_all('/(.?[0-9]+){([^}]+)}/',$this->enhanced_params,$paramsList);
			$count = count($paramsList[1]);
			for ($i=0; $i < $count; $i++) {
				$this->_params[$paramsList[1][$i]] = $this->paramsToArray($paramsList[2][$i]);
			}
		}
	}

	function &loadDefaultsParams ($asText) {
		$path = $this->parent->getPath('manifest');
                $xmlDoc = new DOMIT_Lite_Document();
                $xmlDoc->resolveErrors( true );

		$params=null;
                if ($xmlDoc->loadXML( $path, false, true )) {
                        $root =& $xmlDoc->documentElement;

                        $tagName = $root->getTagName();
                        $isParamsFile = ($tagName == 'mosinstall' || $tagName == 'install' || $tagName == 'mosparams');
                        if ($isParamsFile && $root->getAttribute( 'type' ) == $this->_cbetype) {
                                //$params = &$root->getElementsByPath( 'enhancedparams', 1 );
                                $params = &$root->getElementsByPath( 'params', 1 );

                        }
                }

		$result = ($asText)? '' : array();

                if (is_object( $params )) {
			foreach ($params->childNodes as $param) {
				$name = $param->getAttribute( 'name' );
				$label = $param->getAttribute( 'label' );

				$key = $name ? $name : $label;
				if ( $label != '@spacer' && $name != '@spacer') {
					$value = str_replace("\n",'\n',$param->getAttribute( 'default' ));
					if ($asText) {
						$result.="$key=$value\n";
					} else {
						$result[$key]=$value;
					}
				}
			}
		}
		return $result;
	}

        /** convert a menuitem's params field to an array */
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

	function setParams($params,$itemid) {
		$this->_params[$itemid] = $params;
	}

	function getEnhancedParams ($root, $asText=null) {
		$path = $root->parent->getPath('manifest');
                $xmlDoc = new DOMIT_Lite_Document();
                $xmlDoc->resolveErrors( true );

		$params=null;
                if ($xmlDoc->loadXML( $path, false, true )) {
                        $root =& $xmlDoc->documentElement;

                        $tagName = $root->getTagName();
                        $isParamsFile = ($tagName == 'mosinstall' || $tagName == 'install' || $tagName == 'mosparams');
                        if ($isParamsFile && $root->getAttribute( 'type' ) == $this->_cbetype)
                                $params = &$root->getElementsByPath( 'enhancedparams', 1 );
                }

		$result = ($asText)? '' : array();

                if (is_object( $params )) {
			foreach ($params->childNodes as $param) {
				$name = $param->getAttribute( 'name' );
				$label = $param->getAttribute( 'label' );

				$key = $name ? $name : $label;
				if ( $label != '@spacer' && $name != '@spacer') {
					$value = str_replace("\n",'\n',$param->getAttribute( 'default' ));
					if ($asText) {
						$result.="$key=$value\n";
					} else {
						$result[$key]=$value;
					}
				}
			}
		}
		return $result;
	}

	function getXmlPath () {
		return JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'enhanced'.DS.$this->tabname.DS.$this->tabname.'.xml';
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
					$this->tabparams .= $params . "\n";
				}
			}
		}
		die(print_r($this->tabparams));
		$this->_params = '';
	}

	function store() {
		return JTable::store();
	}
}
