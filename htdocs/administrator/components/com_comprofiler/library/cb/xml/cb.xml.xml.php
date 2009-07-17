<?php
/**
* Fixing bugs and missing functions of PHP SimpleXMLElement in PHP < 5.1.3
* @version $Id:$
* @author Beat
* @copyright (C) 2007 Beat and Lightning MultiCom SA, 1009 Pully, Switzerland
* @license Lightning Proprietary. See licence. Allowed for free use within CB and for CB plugins.
*/

// Check to ensure this file is within the rest of the framework
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * Class to fix the bugs and shortcuts of PHP SimpleXMLElement
 *
 * @author Beat
 * @copyright Beat 2007
 * @licence allowed for free use within CB and for CB plugins
 */
class FixedSimpleXML extends SimpleXMLElement  {
	/**
	 * Get the name of the element.
	 * Warning: don't use getName() as it's broken up to php 5.2.3 included.
	 *
	 * @return string
	 */
	function name() {
		if ( phpversion() > '5.2.3' ) {
			return $this->getName();
		} else {
			return $this->aaa->getName();		// workaround php bug number 41867, fixed in 5.2.4
		}
	}

	/**
	 * Get the an attribute or all attributes of the element
	 *
	 * @param string $attribute 	The name of the attribute if only one attribute is fetched
	 * @return mixed If an attribute is given will return the attribute if it exist.
	 * 				 If no attribute is given will return the complete attributes array
	 */
	function attributes($attribute = null)
	{
		if( isset( $attribute ) ) {
			return (string) $this[$attribute];
		}
		$array	=	array();
		foreach ( parent::attributes() as $k => $v ) {
			$array[$k]	=	(string) $v;
		}
		return count( $array ) ? $array : null;
	}

	/**
	 * Get the data of the element
	 *
	 * @access public
	 * @return string
	 */
	function data() {
		return (string) $this;
	}

	/**
	 * Adds a direct child to the element
	 *
	 * @param string $name
	 * @param string $value
	 * @param string $nameSpace
	 * @param array  $attrs
	 * @param int 	 $level
	 * @return FixedSimpleXML the child				//BB added !
	 */
	function &addChildWithAttr($name, $value, $nameSpace = null, $attrs = array(), $level = null) {
		$child	=&	parent::addChild( $name, $value, $nameSpace );
		foreach ( $attrs as $k => $v ) {
			$child->addAttribute( $k, $v );
		}
		return $child;
	}

	function removeChild(&$child) {
		$name = $child->name();
		foreach ( $this->children() as $eachChild ) {
			if ( $eachChild == $child ) {
				unset( $eachChild );
			}
		}
		unset( $child );
	}
}

?>
