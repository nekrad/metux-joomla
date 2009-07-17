<?php
/**
* Precise emulation of PHP SimpleXMLElement in PHP < 5.1.3
* @version $Id:$
* @author Beat
* @copyright (C) 2007 Beat and Lightning MultiCom SA, 1009 Pully, Switzerland
* @license Lightning Proprietary. See licence. Allowed for free use within CB and for CB plugins.
*/

// Check to ensure this file is within the rest of the framework
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

if( defined('JXML_TEST_DOMIT') || ! function_exists( 'xml_parser_create' ) ) {
	global $mainframe;
	$domitPath = $mainframe->getCfg('absolute_path') . '/includes/domit/xml_domit_lite_include.php';
	if ( file_exists( $domitPath ) ) {
		require_once( $domitPath );
	} else {
		die("<font color='red'>". $mainframe->getCfg( 'absolute_path' ) . "/includes/domit/ does not exist! This is normal with mambo 4.5.0 and 4.6.1 and php 4 without xml parser library binded. Community Builder needs this library for handling plugins.<br />  You Must Manually do the following:<br /> 1.) create " . $mainframe->getCfg( 'absolute_path' ) . "/includes/domit/ directory <br /> 2.) chmod it to 777 <br /> 3.) copy corresponding content of a mambo 4.5.2 directory.</font><br /><br />\n");
	}
}

/**
 * Class to emulate precisely PHP SimpleXMLElement in PHP < 5.1.3
 *
 * @author Beat
 * @copyright Beat 2007
 * @licence allowed for free use within CB and for CB plugins
 */
class FixedSimpleXML {
	/** Attributes of this element
	* @var array of string */
	var $_attributes = array();

	/** The name of the element
	* @var string */
	var $_name = '';

	/** The data the element contains
	* @var string */
	var $_data = '';

	/** Array of references to the objects of all direct children of this XML object
	* @var array of FixedSimpleXML */
	var $_children = array();
	
	/**
	 * Constructor, creates tree and parses XML
	 * All parameters are equivalent to PHP 5 SimpleXML, except last 2
	 *
	 * @param  string          $data
	 * @param  int             $options
	 * @param  boolean         $data_is_url
	 * @param  string          $ns
	 * @param  boolean         $is_prefix
	 * @param  string          $name         used internally to creat tree:  name
	 * @param  array           $attrs        used internally to create tree: attributes
	 * @return FixedSimpleXML
	 */
	function FixedSimpleXML( $data, $options = null, $data_is_url = false, $ns = null, $is_prefix = false, $name = null, $attrs = array() )
	{
		if ( $data ) {
			$this->_xmlHelper		=&	new SimpleXML_Helper( $this,  $data, $options, $data_is_url, $ns, $is_prefix );
		} else {
			//Make the keys of the attr array lower case, and store the value
			$this->_attributes		=	$attrs;				// array_change_key_case($attrs, CASE_LOWER);
			$this->_name			=	$name;
		}
	}

	/**
	 * Get the name of the element
	 *
	 * @return string
	 */
	function name() {
		return $this->_name;
	}

	/**
	 * Get the an attribute of the element
	 *
	 * @param string $attribute 	The name of the attribute
	 * @return mixed If an attribute is given will return the attribute if it exist.
	 * 				 If no attribute is given will return the complete attributes array
	 */
	function attributes( $attribute = null ) {
		if( ! isset( $attribute ) ) {
			return $this->_attributes;
		}
		return isset($this->_attributes[$attribute]) ? $this->_attributes[$attribute] : null;
	}

	/**
	 * Get the data of the element
	 *
	 * @return string
	 */
	function data( ) {
		return $this->_data;
	}

	/**
	 * Set the data of the element
	 * WARNING: Not PHP SimpleXML compatible
	 *
	 * @param	string $data
	 * @return string
	 */
	function setData( $data ) {
		$this->_data	=	$data;
	}
	/**
	 * Get the children of the element
	 *
	 * @return array FixedSimpleXML
	 * 
	 */
	function children( ) {
		return $this->_children;
	}

	 /**
	 * Adds an attribute to the element, override if it already exists
	 *
	 * @param string $name
	 * @param array  $attrs
	 */
	function addAttribute( $name, $value ) {
		$this->_attributes[$name]	=	$value;
	}

	/**
	 * Adds a direct child to the element
	 *
	 * @param string $name
	 * @param string $value
	 * @param string $nameSpace
	 * @param array  $attrs
	 * @return FixedSimpleXML the child
	 */
	function &addChildWithAttr( $name, $value, $nameSpace = null, $attrs = array() ) {
		//If there is no array already set for the tag name being added,
		//create an empty array for it
		if( ! isset( $this->$name ) ) {
			$this->$name	=	array();
		}

		//Create the child object itself
		$classname			=	get_class( $this );
		$child				=&	new $classname( null, null, false, null, false, $name, $attrs );
		$child->_data		=	$value;

		//Add the reference of it to the end of an array member named for the elements name
		$this->{$name}[]	=&	$child;

		//Add the reference to the children array member
		$this->_children[]	=&	$child;

		return $child;
	}
	/**
	 * Remove a specific child from the tree
	 *
	 * @param FixedSimpleXML $child  the child
	 */
	function removeChild( &$child ) {
		$name = $child->name();
		for ( $i = 0, $n = count( $this->_children ); $i < $n; $i++ ) {
			if ( $this->_children[$i] == $child ) {
				unset( $this->_children[$i] );
			}
		}
		for ( $i = 0, $n = count( $this->{$name} ); $i < $n; $i++ ) {
			if ( $this->{$name}[$i] == $child ) {
				unset( $this->{$name}[$i] );
			}
		}
		$this->_children	=	array_values( $this->_children );
		$this->{$name}		=	array_values($this->{$name});
		unset( $child );
	}
	/**
	 * Adds a direct child to the element prepended as first child
	 * WARNING: Not PHP SimpleXML compatible
	 *
	 * @param string $name
	 * @param array  $attrs
	 * @return FixedSimpleXML  the child
	 */
	function & prependChild( $name, $attrs ) {
		//If there is no array already set for the tag name being added, create an empty array for it
		if(!isset($this->$name))
			$this->$name = array();

		//Create the child object itself
		$classname = get_class( $this );
		$child = new $classname( null, null, false, null, false, $name, $attrs );

		//Add the reference of it to the end of an array member named for the elements name
		array_unshift( $this->$name, $child );

		//Add the reference to the children array member
		array_unshift( $this->_children, $child );

		return $child;
	}
	/**
	 * Return a well-formed XML string based on SimpleXML element
	 *
	 * @param  string  $filename  filename to write to if not returning xml
	 * @param  int     $_level    no public access: level for indentation
	 * @return string             if no $filename, otherwise null
	 */
	function asXML( $filename = null, $_level = 0 ) {
		$out = "\n".str_repeat("\t", $_level).'<'.$this->_name;

		//For each attribute, add attr="value"
		foreach($this->_attributes as $attr => $value)
			$out .= ' '.$attr.'="'.htmlspecialchars($value).'"';

		//If there are no children and it contains no data, end it off with a />
		if(empty($this->_children) && empty($this->_data))
			$out .= " />";

		else
		{
			//If there are children
			if(!empty($this->_children))
			{
				//Close off the start tag
				$out .= '>';

				//For each child, call the asXML function (this will ensure that all children are added recursively)
				foreach($this->_children as $child)
					$out .= $child->asXML( null, $_level + 1 );

				//Add the newline and indentation to go along with the close tag
				$out .= "\n".str_repeat("\t", $_level);
			}

			//If there is data, close off the start tag and add the data
			elseif(!empty($this->_data))
				$out .= '>'. htmlspecialchars($this->_data);

			//Add the end tag
			$out .= '</'.$this->_name.'>';
		}

		if ( ( $_level != 0 ) || ( $filename === null ) ) {
			return $out;
		} else {
			file_put_contents( $filename, $out );
			return null;
		}
	}
}


/**
 * Helper Class to load SimpleXMLElement in PHP < 5.1.3
 *
 * @author Beat
 * @copyright Beat 2007
 * @licence allowed for free use within CB and for CB plugins
 */
class SimpleXML_Helper
{
	/** Document element
	* @var FixedSimpleXML $document */
	var $document = null;
	/** The XML parser
	 * @var resource */
	var $_parser = null;
	/** parsing helper
	* @var array of array */
	var $_stack = array();

	/**
	 * Constructor.
	 */
	function SimpleXML_Helper( &$firstElement, $data, $options = null, $data_is_url = false, $ns = null, $is_prefix = false ) {
		if( defined('JXML_TEST_DOMIT') || ! function_exists( 'xml_parser_create' ) ) {

			global $mainframe;

			$domitPath = $mainframe->getCfg('absolute_path') . '/includes/domit/xml_domit_lite_include.php';
			if ( file_exists( $domitPath ) ) {
				require_once( $domitPath );
			} else {
				die("<font color='red'>". $mainframe->getCfg( 'absolute_path' ) . "/includes/domit/ does not exist! This is normal with mambo 4.5.0 and 4.6.1. Community Builder needs this library for handling plugins.<br />  You Must Manually do the following:<br /> 1.) create " . $mainframe->getCfg( 'absolute_path' ) . "/includes/domit/ directory <br /> 2.) chmod it to 777 <br /> 3.) copy corresponding content of a mambo 4.5.2 directory.</font><br /><br />\n");
			}
			
			$this->_parser = null;

		} else {
			
			//Create the parser resource and make sure both versions of PHP autodetect the format
			$this->_parser = xml_parser_create('');
	
			// check parser resource
			xml_set_object($this->_parser, $this);
			xml_parser_set_option($this->_parser, XML_OPTION_CASE_FOLDING, 0);
	
			//Set the handlers
			xml_set_element_handler($this->_parser, '_startElement', '_endElement');
			xml_set_character_data_handler($this->_parser, '_characterData');
		}

		// set the first element
		$this->document[0]	=&	$firstElement;
/*
$mem0 = memory_get_usage();
echo "Memory: " . $mem0 ."\n";

$time = microtime(true);
*/
		// load the XML data and generate tree
		if ( $data_is_url ) {
			if ( ! $this->loadFile( $data ) ) {
				echo "XML file " . $data . " load error.";
				exit();
			}
		} else {
			if ( ! $this->loadString( $data ) ) {
				echo "XML string load error.";
				exit();
			}
		}
/*
$time2 = microtime(true) - $time;
echo "Time function calls: " . $time2 ."\n";

$mem1 = memory_get_usage();
echo "Memory used additional: " . ($mem1 - $mem0) ."\n";
$mem0 = $mem1;
*/
	}

	 /**
	 * Interprets a string of XML into an object
	 *
	 * This function will take the well-formed xml string data and return an object of class
	 * FixedSimpleXML with properties containing the data held within the xml document.
	 * If any errors occur, it returns FALSE.
	 *
	 * @param string  Well-formed xml string data
	 * @return boolean
	 */
	function loadString( $string ) {
		$this->_parse( $string );
		return true;
	}

	 /**
	 * Interprets an XML file into an object
	 *
	 * @param string  Path to xml file containing a well-formed XML document
	 * @return boolean True if successful, false if file empty
	 */
	function loadFile( $path ) {
		if ( file_exists( $path ) ) {
			//Get the XML document loaded into a variable
			$xml = trim( file_get_contents($path) );
			if ($xml == '') {
				return false;
			} else {
				$this->_parse($xml);
				return true;
			}
		} else {
			return false;
		}
	}
	/**
	 * Returns all attributes of the DOMIT element in an array
	 *
	 * @param DOMIT_Lite_Element $element
	 * @return array of string
	 */
	function _domitGetAttributes( &$element ) {
		$attributesArray = array();
		
		//get a reference to the attributes list / named node map (don't forget the ampersand!)
		$attrList =& $element->attributes;

		if ( $attrList !== null && is_array( $attrList ) && ( count( $attrList ) > 0 ) ) {
			//determine the number of members in the attribute list
			$numAttributes = count( $attrList );
	
			//iterate through the list
			foreach ($attrList as $k => $currAttr ) {
				$attributesArray[$k] = $currAttr;
			}
		}
		return $attributesArray;
	}
	/**
	 * Recursively parses XML using DOMIT
	 *
	 * @param unknown_type $element
	 */
	function _domitParse( &$element ) {
		if ( $element->nodeName != '#text' ) {
			$this->_startElement( null, $element->nodeName, $this->_domitGetAttributes( $element ) );
			if ( $element->hasChildNodes() ) {
				$myChildNodes = $element->childNodes;
				//get the total number of childNodes for the document element
				$numChildren = $element->childCount;
				//iterate through the collection
				for ($i = 0; $i < $numChildren; $i++) {
					//get a reference to the i childNode
					$currentNode = $myChildNodes[$i];
					// recurse
					$this->_domitParse( $currentNode );
				}
			}
			$this->_endElement( null, $element->nodeName );
		} else {
			$this->_characterData( null, $element->nodeValue );
		}
	}

	/**
	 * Start parsing an XML document
	 *
	 * Parses an XML document. The handlers for the configured events are called as many times as necessary.
	 *
	 * @param  string $data to parse
	 */
	function _parse($data = '') {
		if ( $this->_parser === null ) {

			$xml					=&	new DOMIT_Lite_Document();
			$success				=	$xml->parseXML( $data );

			if ($success) {
				//gets a reference to the root element of the cd collection
				$myDocumentElement	=&	$xml->documentElement;

				$this->_domitParse( $myDocumentElement );
				$this->document		=	$this->document[0];
			}

		} else {

			if ( xml_parse( $this->_parser, $data ) ) {
				$this->document		=	$this->document[0];
			} else {
				//Error handling
				$this->_handleError( xml_get_error_code( $this->_parser ),
									 xml_get_current_line_number( $this->_parser ),
									 xml_get_current_column_number( $this->_parser ) );
			}
			xml_parser_free($this->_parser);
		}
	}

	/**
	 * Handles an XML parsing error
	 *
	 * @param int $code XML Error Code
	 * @param int $line Line on which the error happened
	 * @param int $col Column on which the error happened
	 */
	function _handleError($code, $line, $col) {
		echo 'XML Parsing Error at '.$line.':'.$col.'. Error '.$code.': '.xml_error_string($code);
	}
	/**
	 * Gets the current direct parent
	 *
	 * @return string object
	 */
	function & _getStackElement() {
		$return =& $this;
		foreach($this->_stack as $stack) {
			$return =& $return->{$stack[0]}[$stack[1]];
			// equivalent to:
			//list( $n, $k ) = $stack;
			//$return	=	$return->{$n}[$k];
		}
		return $return;
	}

	/**
	 * Handler function for the start of a tag
	 *
	 * @param resource $parser
	 * @param string $name
	 * @param array $attrs
	 */
	function _startElement( $parser, $name, $attrs = array() ) {
		//Check to see if tag is root-level
		if (count($this->_stack) == 0) {
			// start out the stack with the document tag
			$this->_stack = array( array ( 'document', 0 ) );
			$this->document[0]->_name		=	$name;
			$this->document[0]->_attributes	=	$attrs;
		} else {
			//If it isn't root level, use the stack to find the parent
			 //Get the name which points to the current direct parent, relative to $this
			$parent			=&	$this->_getStackElement();

			//Add the child
			$parent->addChildWithAttr( $name, null, null, $attrs );

			//Update the stack
			$this->_stack[]	=	array( $name, ( count( $parent->$name ) - 1 ) );
		}
	}

	/**
	 * Handler function for the end of a tag
	 *
	 * @param resource $parser
	 * @param string $name
	 */
	function _endElement( $parser, $name ) {
		//Update stack by removing the end value from it as the parent
		array_pop($this->_stack);
	}

	/**
	 * Handler function for the character data within a tag
	 *
	 * @param resource $parser
	 * @param string $data
	 */
	function _characterData( $parser, $data ) {
		//Get the reference to the current parent object
		$tag =& $this->_getStackElement();

		//Assign data to it
		$tag->_data .= $data;
	}
}

?>
