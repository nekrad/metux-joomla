<?php
/**
* Abstraction class for PHP SimpleXMLElement for PHP 4 and 5, including < 5.1.3
* @version $Id:$
* @author Beat
* @copyright (C) 2007 Beat and Lightning MultiCom SA, 1009 Pully, Switzerland
* @license Lightning Proprietary. See licence. Allowed for free use within CB and for CB plugins.
*/

// Check to ensure this file is within the rest of the framework
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

//define('CBXML_TEST_CBXML','');
//define('JXML_TEST_DOMIT', '');

define('CB_PHP_XML', class_exists( 'SimpleXMLElement' ) && ( phpversion() >= '5.1.3' ) && ! defined('CBXML_TEST_CBXML') );

global $mainframe;
$path	=	$mainframe->getCfg('absolute_path') . '/administrator/components/com_comprofiler/library/cb/xml/';

if ( CB_PHP_XML ) {
	include_once( $path . 'cb.xml.xml.php' );
} else {
	include_once( $path . 'cb.xml.domit.php' );
}

/**
 * SimpleXML Element extended for CB.
 *
 */
class CBSimpleXMLElement extends FixedSimpleXML {
	/**
	 * Get the first child element in matching all the attiributes $attributes
	 *
	 * @param   string	$name         The name tag of the element searched
	 * @param   array   $attributes   array of attribute => value which must match also
	 * @return  CBSimpleXMLElement  or false if no child matches
	 */
	function &getChildByNameAttributes( $name, $attributes = array() ) {
		$false	= false;
		foreach ($this->children() as $child) {
			if ( $child->name() == $name ) {
				$found = true;
				foreach ( $attributes as $atr => $val ) {
					if ( $child->attributes( $atr ) != $val ) {
						$found = false;
						break;
					}
				}
				if ( $found ) {
					return $child;
				}
			}
		}
		return $false;
	}
	/**
	 * Get the first child element in matching the attiribute
	 *
	 * @param   string	$name         The name tag of the element searched
	 * @param   string  $attributes   Attribute name to check
	 * @param   string  $value        Attribute value which must also match
	 * @return	CBSimpleXMLElement  or false if no child matches
	 */
	function &getChildByNameAttr( $name, $attributes, $value = null ) {
		$false	= false;
		foreach ($this->children() as $child) {
			if ( $child->name() == $name ) {
					if ( $child->attributes( $attributes ) == $value ) {
						return $child;
					}
			}
		}
		return $false;
	}
	/**
	 * Get the first child or childs' child (recursing) element in matching the attiribute
	 *
	 * @param   string	$name         The name tag of the element searched
	 * @param   string  $attributes   Attribute name to check
	 * @param   string  $value        Attribute value which must also match
	 * @return	CBSimpleXMLElement  or false if no child matches
	 */
	function &getAnyChildByNameAttr( $name, $attributes, $value = null ) {
		$false	= false;
		foreach ($this->children() as $child) {
			if ( $child->name() == $name ) {
					if ( $child->attributes( $attributes ) == $value ) {
						return $child;
					}
			}
			if ( count( $child->children() ) > 0 ) {
				$grandchild = $child->getAnyChildByNameAttr( $name, $attributes, $value );	// recurse
				if ( $grandchild ) {
					return $grandchild;
				}
			}
		}
		return $false;
	}
	/**
	 * Get an element in the document by / separated path
	 *
	 * @param	string	$path	The / separated path to the element
	 * @return	JJSimpleXMLElement
	 */
	function &getElementByPath( $path ) {
		$false				=	false;
		$parts				=	explode( '/', trim($path, '/') );

		$tmp				=&	$this;
		foreach ($parts as $node) {
			$found			=	false;
			foreach ($tmp->children() as $child) {
				if ($child->name() == $node) {
					$tmp	=&	$child;
					$found	=	true;
					break;
				}
			}
			if ( ! $found ) break;
		}
		if ( $found ) return $tmp;
		else return $false;
	}

}



?>
