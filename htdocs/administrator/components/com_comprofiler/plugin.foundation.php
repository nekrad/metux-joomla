<?php
/**
* Joomla/Mambo Community Builder
* @version $Id: plugin.foundation.php 610 2006-12-13 17:33:44Z beat $
* @package Community Builder
* @subpackage plugin.foundation.php
* @author JoomlaJoe and Beat
* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function getLangDefinition($text) {
	if(defined($text)) $returnText = constant($text); 
	else $returnText = $text;
	return $returnText;
}

/**
 * includes CB stuff
 * --- usage: cbimport('cb.xml.simplexml');
 *
 * @param string $path
 */
function cbimport( $lib ) {
	global $mainframe;
	static $imported = array();
	
	if ( ! isset( $imported[$lib] ) ) {
		$imported[$lib]	=	true;

		$liblow			=	strtolower( $lib );
		$pathAr			=	explode( '.', $liblow );
		array_pop( $pathAr );
		$filepath		=	implode( '/', $pathAr ) . '/' . $liblow . '.php';

		require_once( $mainframe->getCfg('absolute_path') . '/administrator/components/com_comprofiler/library/' . $filepath );
	}
}

/**
* Parameters handler
* @package Joomla/Mambo Community Builder
*/
class cbParamsBase {
	/** @var object */
	var $_params = null;
	/** @var string The raw params string */
	var $_raw = null;
/**
* Constructor
* @param string The raw parms text
* @param string Path to the xml setup file
* @param string The type of setup file
*/
	function cbParamsBase( $paramsValues ) {
	    $this->_params = $this->parse( $paramsValues );
	    $this->_raw = $paramsValues;
	}
/**
* Loads from the plugins database.
* @param string The plugin element name
* @return boolean true: could load, false: query error.
*/
	function loadFromDB( $element ) {
		global $_CB_database;
		
	    $_CB_database->setQuery("SELECT params FROM `#__comprofiler_plugin` WHERE element = '" . $_CB_database->getEscaped( $element ) . "'" );
	    $text = $_CB_database->loadResult();
	    $this->_params = $this->parse( $text );
	    $this->_raw = $text;
	    return ( $text !== null );
	}
/**
* @param string The name of the param
* @param string The value of the parameter
* @return string The set value
*/
	function set( $key, $value='' ) {
		$this->_params->$key = $value;
		return $value;
	}
/**
* Sets a default value if not alreay assigned
* @param string The name of the param
* @param string The value of the parameter
* @return string The set value
*/
	function def( $key, $value='' ) {
	    return $this->set( $key, $this->get( $key, $value ) );
	}
/**
* @param string The name of the param
* @param mixed The default value if not found
* @return string
*/
	function get( $key, $default=null ) {
	    if ( isset( $this->_params->$key ) ) {
	    	if (is_array( $default ) ) {
	    		return explode( '|*|', $this->_params->$key );
	    	} else {
		        return $this->_params->$key;
	    	}
		} else {
		    return $default;
		}
	}
/**
* Parse an .ini string, based on phpDocumentor phpDocumentor_parse_ini_file function
* @param mixed The ini string or array of lines
* @param boolean add an associative index for each section [in brackets]
* @return object
*/
	function parse( $txt, $process_sections = false, $asArray = false ) {
		if (is_string( $txt )) {
			$lines = explode( "\n", $txt );
		} else if (is_array( $txt )) {
			$lines = $txt;
		} else {
			$lines = array();
		}
		$obj = $asArray ? array() : new stdClass();

		$sec_name = '';
		$unparsed = 0;
		if (!$lines) {
			return $obj;
		}
		foreach ($lines as $line) {
			// ignore comments
			if ($line && $line[0] == ';') {
				continue;
			}
			$line = trim( $line );

			if ($line == '') {
				continue;
			}
			if ($line && $line[0] == '[' && $line[strlen($line) - 1] == ']') {
				$sec_name = substr( $line, 1, strlen($line) - 2 );
				if ($process_sections) {
					if ($asArray) {
						$obj[$sec_name] = array();
					} else {
						$obj->$sec_name = new stdClass();
					}
				}
			} else {
				if ($pos = strpos( $line, '=' )) {
					$property = trim( substr( $line, 0, $pos ) );

					if (substr($property, 0, 1) == '"' && substr($property, -1) == '"') {
						$property = stripcslashes(substr($property,1,count($property) - 2));
					}
					$value = trim( substr( $line, $pos + 1 ) );
					if ($value == 'false') {
						$value = false;
					}
					if ($value == 'true') {
						$value = true;
					}
					if (substr( $value, 0, 1 ) == '"' && substr( $value, -1 ) == '"') {
						$value = stripcslashes( substr( $value, 1, count( $value ) - 2 ) );
					}

					if ($process_sections) {
						$value = str_replace( array( '\n', '\r' ), array( "\n", "\r" ), $value );
						if ($sec_name != '') {
							if ($asArray) {
								$obj[$sec_name][$property] = $value;
							} else {
								$obj->$sec_name->$property = $value;
							}
						} else {
							if ($asArray) {
								$obj[$property] = $value;
							} else {
								$obj->$property = $value;
							}
						}
					} else {
						$value = str_replace( array( '\n', '\r' ), array( "\n", "\r" ), $value );
						if ($asArray) {
							$obj[$property] = $value;
						} else {
							$obj->$property = $value;
						}
					}
				} else {
					if ($line && trim($line[0]) == ';') {
						continue;
					}
					if ($process_sections) {
						$property = '__invalid' . $unparsed++ . '__';
						if ($process_sections) {
							if ($sec_name != '') {
								if ($asArray) {
									$obj[$sec_name][$property] = trim($line);
								} else {
									$obj->$sec_name->$property = trim($line);
								}
							} else {
								if ($asArray) {
									$obj[$property] = trim($line);
								} else {
									$obj->$property = trim($line);
								}
							}
						} else {
							if ($asArray) {
								$obj[$property] = trim($line);
							} else {
								$obj->$property = trim($line);
							}
						}
					}
				}
			}
		}
		return $obj;
	}
}

?>
