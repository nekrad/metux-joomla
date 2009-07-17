<?php
/**
* Joomla/Mambo Community Builder : Plugin Handler
* @version $Id: library/cb/cb.params.php 610 2006-12-13 17:33:44Z beat $
* @package Community Builder
* @subpackage cb.params.php
* @author various, JoomlaJoe and Beat
* @copyright (C) Beat and JoomlaJoe, www.joomlapolis.com and various
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Parameters handler
* @package Joomla/Mambo Community Builder
*/
class cbParamsEditorController extends cbParamsBase {
//	/** @var object */
//	var $_params = null;
//	/** @var string The raw params string */
//	var $_raw = null;
	/** The main enclosing tag name
	 *  @var string */
	var $_maintagname = null;
	/** The attribute name of setup file
	 *  @var string */
	var $_attrname = null;
	/** The attribute value of setup file
	 *  @var string */
	var $_attrvalue = null;
	/** plugin object
	 *  @var moscomprofilerPlugin */
	var $_pluginObject = null;
	/** @var int */
	var $_tabid = null;
	/** The xml plugin root element
	 *  @var CBSimpleXMLElement */
	var $_xml = null;
	/** The xml params element
	 *  @var CBSimpleXMLElement */
	var $_xmlElem = null;
	/** The xml actions element
	 *  @var CBSimpleXMLElement */
	var $_actions = null;
	/** The xml types element
	 *  @var CBSimpleXMLElement */
	var $_types = null;
	/** Options from url REQUEST
	 *  @var unknown_type */
	var $_options = null;
	/** Extending view parser
	 *  @var cbEditRowView */
	var $_extendViewParser = null;
	/** CB plugin parameters
	 *  @var unknown_type */
	var $_pluginParams = null;

/**
* Constructor
* @param string The raw parms text
* @param CBSimpleXMLElement    The root element
* @param string The type of setup file
*/
	function cbParamsEditorController( $paramsValues, $xmlElement, $xml, &$pluginObject, $tabId=null, $maintagname='cbinstall', $attrname='type', $attrvalue='plugin'  ) {
	    // $this->_params = $this->parse( $text );
	    // $this->_raw = $text;
	    $this->cbParamsBase( $paramsValues );
	    $this->_xml				=&	$xmlElement;
	    if ( $xml ) {
	    	$this->_actions		=&	$xml->getElementByPath( 'actions' );
		    $this->_types		=&	$xml->getElementByPath( 'types' );
	    }
	    $this->_pluginObject	=&	$pluginObject;
	    $this->_tabId			=	$tabId;
	    $this->_maintagname		=	$maintagname;
	    $this->_attrname		=	$attrname;
	    $this->_attrvalue		=	$attrvalue;
	    $this->_pluginParams	=&	$this;
	}
	function setAllParams( &$object ) {
		$this->_params			=&	$object;
	}
	function setPluginParams( &$pluginParams ) {
	    $this->_pluginParams	=&	$pluginParams;
	}
	function setOptions( $options ) {
		$this->_options			=	$options;
	}
	function setExtendedViewParser( &$extendedViewParser ) {
		$this->_extendViewParser =&	$extendedViewParser;
	}
/**
* Converts the parameters received as POST array into the raw parms text
* @param mixed POST array or string
* @return string The raw parms text
* @var string The type of setup file
*/
	function getRawParams ( $params ) {
		$ret = null;
		if(is_array($params)) {
			foreach ($params as $k=>$v) {
				if (is_array($v)) {
					$v = implode("|*|", $v);
				}
				if (get_magic_quotes_gpc()) {
					$v = stripslashes( $v );
				}
				$txt[] = "$k=$v";
			}
			$ret = cbEditRowView::textareaHandling( $txt );
			if (get_magic_quotes_gpc()) {
				$ret = addslashes( $ret );
			}
		} else {
			$ret = $params;
		}
		return $ret;
	}

/**
* Converts the parameters received as POST array into the |*| format
* @param mixed POST array
*/
	function fixMultiSelects ( &$params ) {
		if ( is_array( $params ) ) {
			foreach ( $params as $k => $v ) {
				if ( is_array( $v ) ) {
					$params[$k]		=	implode( "|*|", $v );
				}
			}
		}
	}

	/**
	* @param string The name of the control, or the default text area if a setup file is not found
	* @return string HTML
	*/
	function draw( $tag_path='params', $grand_parent_path=null, $parent_tag=null, $parent_attr=null, $parent_attrvalue=null, $control_name='params', $paramstextarea=true ) {

		if ( $this->_xml ) {
			$element =& $this->_xml;
			if ( $element && $element->name() == $this->_maintagname && $element->attributes( $this->_attrname ) == $this->_attrvalue) {
				if ( $grand_parent_path != null ) {
					$element =& $element->getElementByPath( $grand_parent_path );
					if ( ! $element ) {
						return null;
					}
				}
				if ( $parent_tag != null && $parent_attr != null && $parent_attrvalue != null ) {
					if ( $element =& $element->getChildByNameAttr( $parent_tag, $parent_attr, $parent_attrvalue ) ) {
						if ($element =& $element->getElementByPath( $tag_path )) {
							$this->_xmlElem =& $element;
						}
					}
				} else {
					if ($element =& $element->getElementByPath( $tag_path )) {
						$this->_xmlElem =& $element;
					}
				}
			} elseif ( ! $tag_path ) {
				$this->_xmlElem =& $element;
			}
		}

	    if ( $this->_xmlElem ) {
	    	
	    	$controllerView = new cbDrawController( $this->_xmlElem, $this->_actions, $this->_options );
	    	$controllerView->setControl_name( $control_name );
	    	
	    	$editRowView =& new cbEditRowView( $this->_pluginParams, $this->_types, $this->_actions, $this->_pluginObject, $this->_tabid );
	    	if ( $this->_extendViewParser ) {
	    		$editRowView->setExtendedViewParser( $this->_extendViewParser );
	    	}
	    	return $editRowView->renderEditRowView( $this->_xmlElem, $this->_params, $controllerView, $this->_options );
		} else {
			if ($paramstextarea) {
				return "<textarea name=\"$control_name\" cols=\"40\" rows=\"10\" class=\"text_area\">".htmlspecialchars($this->_raw)."</textarea>";
			} else {
				return null;
			}
		}
	}
} // class cbParamsEditorController

class cbEditRowView {
	var $_i				 = 0;
	/** The xml element describing the data
	 *  @var CBSimpleXMLElement */
	var $_modelOfData;
	/** The data rows (for ordering arrows)
	 *  @var array */
	var $_modelOfDataRows;
	/** The current row number (for ordering arrows)
	 *  @var int */
	var $_modelOfDataRowsNumber;
	/** Extending view functions
	 *  @var cbEditRowView */
	var $_extendViewParser = null;
	/** Drawing controller
	 *  @var cbDrawController */
	var $_controllerView;
	/** The options from url REQUEST
	 * @var array of string */
	var $_options;
	/** The plugin parameters
	 *  @var cbParamsBase */
	var $_pluginParams;
	/** The xml <types> element
	 *  @var CBSimpleXMLElement */
	var $_types;
	/** The xml <actions> element
	 *  @var CBSimpleXMLElement */
	var $_actions;
	/** The xml <actions> element
	 *  @var CBSimpleXMLElement */
	var $_parentMOdelofView;
	/** The plugin object
	 *  @var moscomprofilerPlugin */
	var $_pluginObject = null;
	/** Id of tab
	 *  @var int */
	var $_tabid = null;
	/** internal temporary var: if render as view (true) or as param (false)
	 *  @var boolean */
	var $_view;
	/** methods of this class
	 * @var array */
	var $_methods = null;
	/** list of possible values
	 * @var array of stdClass: 'name' => object (->value, (optional ->index), ->text) */
	var $_selectValues	=	array();

	function cbEditRowView( &$pluginParams, &$types, &$actions, &$pluginObject, $tabId = null ) {
		$this->_pluginParams		=&	$pluginParams;
		$this->_types				=&	$types;
		$this->_actions				=&	$actions;
		$this->_pluginObject		=&	$pluginObject;
		$this->_tabid				=	$tabId;
	}
	
	function setParentView( &$modelView ) {
		$this->_parentMOdelofView	=&	$modelView;
	}
	function setModelOfData( &$modelOfData ) {
		$this->_modelOfData			=&	$modelOfData;
	}
	function setModelOfDataRows( &$modelOfDataRows ) {
		$this->_modelOfDataRows		=&	$modelOfDataRows;
	}
	function setModelOfDataRowsNumber( $i ) {
		$this->_modelOfDataRowsNumber = $i;
		if ( $this->_extendViewParser ) {
			$this->_extendViewParser->setModelOfDataRowsNumber( $i );
		}
	}
	/**
	 * Sets an extended view parser
	 * This method is experimental and not part of CB API.
	 *
	 * @param CBSimpleXmlElement $extendedViewParserElement  an xml element like <extendparser class="className" /> where className extends cbEditRowView
	 */
	function setExtendedViewParser( &$extendedViewParserElement ) {
		if ( $extendedViewParserElement ) {
			$class			=	$extendedViewParserElement->attributes( 'class' );
			if ( $class ) {
				$extendedViewParser			=&	new $class( $this->_pluginParams, $this->_types, $this->_actions, $this->_pluginObject, $this->_tabid, $this );
				$this->_extendViewParser	=&	$extendedViewParser;
			}
		}
	}
	function setSelectValues( &$node, &$selectValues ) {
		$this->_selectValues[$node->attributes( 'name' )]	=&	$selectValues;
	}
	function & _getSelectValues( &$node ) {
		$nodeName			=	$node->attributes( 'name' );
		if ( isset( $this->_selectValues[$nodeName] ) ) {
			return $this->_selectValues[$nodeName];
		} else {
			$arr	=	array();
			return $arr;
		}
	}
	/**
	 * Renders as ECHO HTML code of a table
	 *
	 * @param CBSimpleXmlElement  $modelView
	 * @param stdClass            $modelOfData       ( $rows )
	 * @param cbDrawController    $controllerView
	 * @param array               $options
	 * @param atring              $viewType   ( 'view', 'param', 'depends': means: <param> tag => param, <field> tag => view )
	 * @param atring              $htmlFormatting   ( 'table', 'td', 'none' )
	 * 
	 */
	function renderEditRowView( &$modelOfView, &$modelOfData, &$controllerView, $options, $viewType = 'depends', $htmlFormatting = 'table' ) {
		global $_CB_ui;

		$this->_modelOfData		=&	$modelOfData;
		$this->_controllerView	=&	$controllerView;
		$this->_options			=	$options;

		if ( $this->_extendViewParser ) {
			$html	=	$this->_extendViewParser->renderEditRowView( $modelOfView, $modelOfData, $controllerView, $options, $viewType, $htmlFormatting );
			if ( $html ) {
				return $html;
			}
		}

		$html	= array();
		if ( $htmlFormatting == 'table' ) {
			$html[]	= '<table class="adminform">';

			$label = $modelOfView->attributes( 'label' );
			if ( $label ) {
			    // add the params description to the display
			    $html[] = '<tr><th colspan="3">' . getLangDefinition( $label ) . '</th></tr>';
			}
			$description = $modelOfView->attributes( 'description' );
			if ( $description ) {
			    // add the params description to the display
			    $html[] = '<tr><td colspan="3">' . getLangDefinition( $description ) . '</td></tr>';
			}
		}
		$this->_methods = get_class_methods( get_class( $this ) );

		$this->_jsif =	array();
		$calendars	= new cbCalendars( $_CB_ui );
		$tabs		= new cbTabs( 0, $_CB_ui, $calendars );
		$html[]		= $this->renderAllParams( $modelOfView, $controllerView->control_name(), $tabs, $viewType, $htmlFormatting );
		if ( $htmlFormatting == 'table' ) {
			$html[]		= '</table>';
		}
		
		$jsCode		=	$this->_compileJsCode();
		if ( $jsCode ) {
			$html[]	=	'<script type="text/javascript"><!--//--><![CDATA[//><!--' . "\n";
//			$html[]	=	"var cbHideFields = new Array();\n";
			$html[]	=	$jsCode;
			$html[]	=	"//--><!]]></script>\n";
		}
		
		return implode( "\n", $html );
	}

	/**
	* @param string The name of the field
	* @param mixed The default value if not found
	* @return string
	*/
	function get( $key, $default=null ) {
	    if ( isset( $this->_modelOfData->$key ) ) {
	    	if (is_array( $default ) ) {
	    		return explode( '|*|', $this->_modelOfData->$key );
	    	} else {
		        return $this->_modelOfData->$key;
	    	}
		} else {
		    return $default;
		}
	}

	function _compileJsCode( ) {
		if ( count( $this->_jsif ) == 0 ) {
			return null;
		}
		$js	=	'';
		$i	=	0;
		foreach ( $this->_jsif as $ifVal ) {

			$ifName		=	$ifVal['ifname'];
			$element	=	$ifVal['element'];
			$name		=	$element->attributes( 'name' );
			$operator	=	$element->attributes( 'operator' );
			$value		=	$element->attributes( 'value' );
			$valuetype	=	$element->attributes( 'valuetype' );

			$operatorNegation	=	array( '=' => '!=', '==' => '!=', '!=' => '==', '<>' => '==', '<' => '>=', '>' => '<=', '<=' => '>', '>=' => '<', 'regexp' => 'regexp' );
			$revertedOp	=	$operatorNegation[$operator];
			//if ( in_array( $valuetype, array( 'string', 'const:string', 'text', 'const:text' ) ) ) {
			//	$value	=	"\\'" . $value . "\\'";
			//}
			if ( isset( $ifVal['show'] ) && ( count( $ifVal['show'] ) > 0 ) ) {
				$show	=	"['" . implode( "','", $ifVal['show'] ) . "']";
			} else {
				$show	=	"[]";
			}
			if ( isset( $ifVal['set'] ) && ( count( $ifVal['set'] ) > 0 ) ) {
				$set	=	"['" . implode( "','", $ifVal['set'] ) . "']";
			} else {
				$set	=	"[]";
			}
			$js	.=	"cbHideFields[" . $i . "] = new Array();\n";
			$js	.=	"cbHideFields[" . $i . "][0] = '" . $ifName		. "';\n";
			$js	.=	"cbHideFields[" . $i . "][1] = '" . $name		. "';\n";
			$js	.=	"cbHideFields[" . $i . "][2] = '" . $revertedOp	. "';\n";
			$js	.=	"cbHideFields[" . $i . "][3] = '" . $value		. "';\n";
			$js	.=	"cbHideFields[" . $i . "][4] = "  . $show		. ";\n";
			$js	.=	"cbHideFields[" . $i . "][5] = "  . $set		. ";\n";
			$i++;
		}
		return $js;
	}

	function _htmlId( $control_name, $element ) {
		return 'cbfr_' . ( $control_name ? $control_name . '_' : '' ) . $element->attributes( 'name' );
	}

	function _renderLine( $param, $result, $control_name='params', $htmlFormatting = 'table' ) {

		$id			=	$this->_htmlId( $control_name, $param );

		if ( $htmlFormatting == 'table' ) {
			$html[] = '<tr id="' . $id . '">';
			$html[] = '<td width="35%" align="right" valign="top">' . $result[0] . '</td>';
			$html[] = '<td width="60%">' . $result[1] . '</td>';
			$html[] = '<td width="5%" align="left" valign="top">' . $result[2] . "</td>";
			$html[] = '</tr>';
		} elseif ( $htmlFormatting == 'td' ) {
			$html[] = "\t\t\t<td id=\"" . $id . "\""
					. ( ( $param->attributes( 'align' ) ) ? ' style="text-align:' . htmlspecialchars( $param->attributes( 'align' ) ) . ';"' :
							( in_array( $param->attributes( 'type' ), array( 'checkmark', 'published' ) ) ? ' style="text-align:center;"' : '' ) )
					. ( ( $param->attributes( 'nowrap' ) ) || in_array( $param->attributes( 'type' ), array( 'checkmark', 'ordering' ) ) ? ' nowrap="nowrap"' : '' )
					. '>'
					. $result[1]
					. "</td>";
		} elseif ( $htmlFormatting == 'span' ) {
			if (substr( $result[0], -1 ) == ":" ) {
				$result[0]	=	substr( $result[0], 0, -1 );
			}
			if (substr( $result[0], -2 ) == "%s" ) {
				$result[0]	=	substr( $result[0], 0, -2 );
				$html[] = '<div id="' . $id . '">'
						. '<span class="cbLabelSpan">' . $result[0] . '</span>'
						. '<span class="cbFieldSpan">' . $result[1] . '</span> '
						. '</div>';
			} else {
				$html[] = '<div id="' . $id . '">'
						. '<span class="cbFieldSpan">' . $result[1] . '</span> '
						. '<span class="cbLabelSpan">' . $result[0] . '</span>'
						. '</div>';
			}
		} else {
			$html[]	= "*" . $result[1] . "*";
		}
		return implode( "\n", $html );
	}
	/**
	 * renders all parameters
	 *
	 * @param CBSimpleXMLElement $element
	 * @param string             $control_name
	 * @param cbTabs             $tabs
	 * @param atring             $viewType   ( 'view', 'param', 'depends': means: <param> tag => param, <field> tag => view )
	 * @param atring             $htmlFormatting   ( 'table', 'td', 'span', 'none' )
	 * @return string HTML
	 */
	function renderAllParams( $element, $control_name='params', $tabs=null, $viewType = 'depends', $htmlFormatting = 'table' ) {
		global $_CB_database, $mainframe;

		static $tabNavJS		=	array();
		static $tabpaneCounter	=	0;

		$html	= array();

		foreach ($element->children() as $param) {
			switch ( $param->name() ) {
				case 'param':
					$result = $this->renderParam( $param, $control_name, ( $viewType == 'view' ) );
					$html[]	= $this->_renderLine( $param, $result, $control_name, $htmlFormatting );
					break;
			
				case 'field':
					$result = $this->renderParam( $param, $control_name, ( $viewType != 'param' ) );
					
					$link	= $param->attributes( 'link' );
					$title	= htmlspecialchars( $param->attributes( 'title' ) );
					if ( $title ) {
						$title = ' title="' . $title . '"';
					} else {
						$title = '';
					}
	
					if ( $link ) {
						$linkhref = $this->_controllerView->drawUrl( $link, $param, $this->_modelOfData, isset( $this->_modelOfData->id ) ? $this->_modelOfData->id : null, true );
						$result[1]	= '<a href="' . $linkhref .'"' . $title . '>' . $result[1] . '</a>';
					} elseif ( $title ) {
						$result[1]	= '<span' . $title . '>' . $result[1] . '</span>';
					}
					$html[]	= $this->_renderLine( $param, $result, $control_name, $htmlFormatting );
					break;
			
				case 'fieldset':
					$id				=	$this->_htmlId( $control_name, $param );

					$legend			=	$param->attributes( 'label' );
					$description	=	$param->attributes( 'description' );
					$name			=	$param->attributes( 'name' );

					$fieldsethtml	=	'<fieldset' . ( $name ? ( ' class="cbfieldset_' . $name . '"' ) : '' ) . '>';
					if ( $htmlFormatting == 'table' ) {
						$html[] 		= '<tr id="' . $id . '"><td colspan="3" width="100%">' . $fieldsethtml;
					} elseif ( $htmlFormatting == 'td' ) {
						$html[]		= "\t\t\t<td id=\"" . $id . "\">" . $fieldsethtml;
					} elseif ( $htmlFormatting == 'span' ) {
						$html[]		=	'<div id="' . $id . '">' . $fieldsethtml;
					} else {
						$html[] 	=	'<fieldset id="' . $id . '"' . ( $name ? ( ' class="cbfieldset_' . $name . '"' ) : '' ) . '>';
					}
					if ( $legend ) {
					    $html[] = '<legend>' . getLangDefinition($legend) . '</legend>';
					}
					if ( $htmlFormatting == 'table' ) {
						$html[]			=	'<table class="paramlist" cellspacing="0" cellpadding="0" width="100%">';
						if ( $description ) {
						    $html[]		=	'<tr><td colspan="3" width="100%"><strong>' . getLangDefinition($description) . '</strong></td></tr>';
						}
					} elseif ( $htmlFormatting == 'td' ) {
						if ( $description ) {
							$html[] 	=	'<td colspan="3" width="100%"><strong>' . getLangDefinition($description) . '</strong></td>';
						}
					} elseif ( $htmlFormatting == 'span' ) {
						if ( $description ) {
							$html[]		=	'<span class="cbLabelSpan">' . getLangDefinition($description) . '</span> ';
						}
						$html[]			=	'<span class="cbFieldSpan">';
					} else {
						if ( $description ) {
							$html[] 		= '<strong>' . getLangDefinition($description) . '</strong>';
						}
					}
					
					$html[] = $this->renderAllParams( $param, $control_name, $tabs, $viewType, $htmlFormatting );
					
					if ( $htmlFormatting == 'table' ) {
						$html[] = "\n\t</table>";
						$html[] = '</fieldset></td></tr>';
					} elseif ( $htmlFormatting == 'td' ) {
						$html[] = '</fieldset></td>';
					} elseif ( $htmlFormatting == 'span' ) {
						$html[]	= '</span></fieldset></div>';
					} else {
						$html[] = '</fieldset>';
					}
					break;
					
				case 'fields':
				case 'status':
					$html[] = $this->renderAllParams( $param, $control_name, $tabs, $viewType, $htmlFormatting );
					break;
					
				case 'if':
					if ( $param->attributes( 'type' ) == 'showhide' ) {
						$ifName					=	$this->_htmlId( $control_name, $param ) . $param->attributes( 'operator' ) . $param->attributes( 'value' ). $param->attributes( 'valuetype' );
						// $this->_jsif[$ifName]	=	array();
						// $this->_jsif[$ifName]['show']	=	array();
						// $this->_jsif[$ifName]['set']	=	array();
						$paramChildren			=	$param->children();
						if ( $paramChildren ) {
							foreach ( $paramChildren as $subParam ) {
								if ( $subParam->name() == 'else' ) {
									if ( $subParam->attributes( 'action' ) == 'set' ) {
										$correspondingParam				=	$param->getAnyChildByNameAttr( 'param', 'name', $subParam->attributes( 'name' ) );
										if ( $correspondingParam ) {
											$this->_jsif[$ifName]['set'][]	=	$this->_htmlId( $control_name, $correspondingParam )
																			.	'=' . $this->control_name( $control_name, $subParam->attributes( 'name' ) )
																			.	'=' . $subParam->attributes( 'value' );
										} else {
											echo 'No corresponding param to the else statement for name ' . $subParam->attributes( 'name' ) . ' !';
										}
									}
								} else {
									$this->_jsif[$ifName]['show'][]		=	$this->_htmlId( $control_name, $subParam );
								}
							}
							$this->_jsif[$ifName]['element']	=	$param;
							$this->_jsif[$ifName]['ifname']		=	$this->_htmlId( $control_name, $param );
						}
					}
					$html[] = $this->renderAllParams( $param, $control_name, $tabs, $viewType, $htmlFormatting );
					break;
				case 'else':
					break;		// implemented in if above it

				case 'toolbarmenu':
					break;		// implemented in higher level

				case 'tabpane':
					$id				=	$this->_htmlId( $control_name, $param );

					$tabpaneCounter++;
					$subhtml				= array();

					$paramsTabsOfTabpane	= $param->children();
					
					$subhtml				= array();
					foreach ( $paramsTabsOfTabpane  as $paramsTab ) {
						if ( $paramsTab->name() == 'tabpanetab' ) {
							$i			= $this->_i++;
							$idtab		= $param->attributes( 'name' ) . $this->_i;
							$subhtml[]	= $tabs->startTab( $param->attributes( 'name' ), getLangDefinition( $paramsTab->attributes( 'label' ) ), $idtab );
							$subhtml[]	= '<table class="paramlist" cellspacing="0" cellpadding="0" width="100%">';
							// $results .= "\n\t\t\t<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"100%\"><tr><td>";
			
							$tabName	=	$paramsTab->attributes( 'name' );
							$tabTitle	=	$paramsTab->attributes( 'title' );
							$description =	$paramsTab->attributes( 'description' );
							if ( $tabTitle ) {
							    $subhtml[]	= '<tr><td colspan="3" width="100%"><h3' . ( $tabName ? ' class="cbTH' . $param->attributes( 'name' ) . $tabName . '"' : '' ) . '>' . getLangDefinition( $tabTitle ) . '</h3></td></tr>';
							}
							if ( $description || ! $tabTitle ) {
							    $subhtml[]	= '<tr><td colspan="3" width="100%"><strong>' . getLangDefinition($description) . '</strong></td></tr>';		// either description or a spacer.
							}
							$subhtml[]	= $this->renderAllParams( $paramsTab, $control_name, $tabs, $viewType, $htmlFormatting );
							
							$subhtml[]	=  "\n\t</table>";
							$subhtml[]	=  $tabs->endTab();
							$tabNavJS[$i]->nested		= ( $tabpaneCounter > 1 );
							$tabNavJS[$i]->name			= getLangDefinition( $paramsTab->attributes( 'label' ) );
							$tabNavJS[$i]->id			= $idtab;
							$tabNavJS[$i]->pluginclass	= $idtab;
						}
					}
					if ( $htmlFormatting == 'table' ) {
						$html[] = '<tr id="' . $id . '"><td colspan="3" width="100%">';
					} elseif ( $htmlFormatting == 'td' ) {
						$html[] = '<td id="' . $id . '">';
					}
					if ( $tabpaneCounter == 1 ) {
						$html[]		=	$tabs->_getTabNavJS( $param->attributes( 'name' ), $tabNavJS );
						$tabNavJS	=	array();
					}
					$html[] = $tabs->startPane( $param->attributes( 'name' ) );
					$html[] = implode( "\n", $subhtml );
					$html[] = $tabs->endPane();
					if ( $htmlFormatting == 'table' ) {
						$html[] = '</td></tr>';
					} elseif ( $htmlFormatting == 'td' ) {
						$html[] = '</td>';
					}
					$tabpaneCounter--;
					break;

				case 'extendparser':
					$this->setExtendedViewParser( $param );
					break;

				default:
					if ( $this->_extendViewParser ) {
						$html[] = $this->_extendViewParser->renderAllParams( $param, $control_name, $tabs, $viewType, $htmlFormatting );
					} else {
						echo 'Method to render XML view element ' . $param->name() . ' is not implemented !';
					}
					break;
			}

		}

		if (count( $element->children() ) < 1) {
			if ( $htmlFormatting == 'table' ) {
				$html[] = "<tr><td colspan=\"2\"><i>" . _UE_NO_PARAMS . "</i></td></tr>";
			} elseif ( $htmlFormatting == 'td' ) {
				$html[] = "<td><i>" . _UE_NO_PARAMS . "</i></td>";
			} else {
				$html[] = "<i>" . _UE_NO_PARAMS . "</i>";
			}
		}

		return implode( "\n", $html );
	}


	/**
	* @param  CBSimpleXMLElement $param          object A param tag node
	* @param  string             $control_name   The control name
	* @param  boolean            $view           true if view only, false if editable
	* @return array Any array of the label, the form element and the tooltip
	*/
	function renderParam( &$param, $control_name='params', $view ) {
	    $result = array();

		$name = getLangDefinition($param->attributes( 'name' ));
		$label = getLangDefinition($param->attributes( 'label' ));
		$description = getLangDefinition(htmlspecialchars($param->attributes( 'description' )));

		$value = $this->get( $name, $param->attributes( 'default' ) );
		
		if ( $param->attributes( 'translate' ) == '_UE' ) {
			$value	=	getLangDefinition( $value );
		}

		$result[0] = $label ? $label : $name;
		if ( $result[0] == '@spacer' ) {
			$result[0] = '<hr/>';
		} else if ( $result[0] ) {
			if ($name == '@spacer')	$result[0] = '<strong>'.$result[0].'</strong>';
			else $result[0] .= ':';
		}

		$result[1]	=	null;
		$type = $param->attributes( 'type' );
/* up to proof of contrary, not needed, as type="private" does it...				//TBD remove this once sure
		if ( $type == 'privateparam' ) {
			$className		= $param->attributes( 'class' );
			$methodName		= $param->attributes( 'method' );
			if ( ! $className ) {
				$className	=	$this->_parentMOdelofView->attributes( 'class' );
			}
			if ( $className && $methodName && class_exists( $className ) ) {
				global $_CB_database;
				$obj = new $className( $_CB_database );
				if ( method_exists( $obj, $methodName ) ) {
					$control_name_name	=	$this->control_name( $control_name, $name );
					$result[1]	=	$obj->$methodName( $param, $control_name, $view, $name, $control_name_name, $value, $this->_pluginParams, $type );	//TBD FIXME: pluginParams should be available by the method params() of $obj, not as function parameter
				} else {
					$result[1]	=	"Missing method " . $methodName. " in class " . $className;
				}
			} else {
				$result[1]	=	"Missing class " . $className . ", and/or method " . $methodName . " in xml";
			}
		}
*/
		if ( substr( $type, 0, 4 ) == 'xml:' ) {
			$xmlType	=	substr( $type, 4 );
			if ( $this->_types ) {
				$typeModel	=	$this->_types->getChildByNameAttr( 'type', 'name' , $xmlType );
				// find root type:
				if ( $typeModel ) {
					$root		=	$typeModel;
					for ( $i = 0; $i < 100; $i++ ) {
						if ( substr( $root->attributes( 'base' ), 0, 4 ) == 'xml:' ) {
							$subbasetype	=	$root->attributes( 'base' );
							$root	=	$this->_types->getChildByNameAttr( 'type', 'name' , substr( $subbasetype, 4 ) );
							if ( ! $root ) {
								$result[1] =	"Missing type definition of " . $subbasetype;
								break;
							}
						} else {
							// we found the root and type:
							$type	=	$root->attributes( 'base' );
							break;
						}
					}
					if ( $i >= 99 ) {
						echo 'Error: recursion loop in XML type definition of ' . $o->name() . ' ' . $o->attributes( 'name' ) . ' type: ' . $o->attributes( 'type' );
						exit;
					}
					$levelModel		=	$typeModel;
					$insertAfter	=	array();
					for ( $i = 0; $i < 100; $i++ ) {
						switch ( $type ) {
							case 'list':
							case 'multilist':
							case 'radio':
							case 'checkbox':
								if ( $view ) {
									$valueNode	=	$levelModel->getChildByNameAttr( 'option', 'value', $value );
									if ( $valueNode ) {
										$result[1]	=	$valueNode->data();
									}
								} else {
									if ( $levelModel->attributes( 'insertbase' ) != 'before' ) {
										foreach ( $levelModel->children() as $option ) {
											if ( $option->name() == 'option' ) {
												$child =& $param->addChildWithAttr( 'option', $option->data(), null, $option->attributes() );
											}
										}
									} else {
										$insertAfter[]	=	$levelModel;	
									}
								}
								break;
							default:
								if ( $view ) {
									$result[1]	=	"Unknown base type " . $type . " in XML";
								} else {
									$child =& $param->addChildWithAttr( 'option', "Unknown base type " . $type . " in XML", null, array( 'value' => '0') );
								}
								break;
						}
						if ( ( $levelModel === $typeModel ) && ( substr( $levelModel->attributes( 'type' ), 0, 4 ) == 'xml:' ) ) {
							$levelModel	=	$this->_types->getChildByNameAttr( 'type', 'name' , substr( $levelModel->attributes( 'type' ), 4 ) );
						} elseif ( substr( $levelModel->attributes( 'base' ), 0, 4 ) == 'xml:' ) {
							$levelModel	=	$this->_types->getChildByNameAttr( 'type', 'name' , substr( $levelModel->attributes( 'base' ), 4 ) );
						} else {
							break;
						}

					}
					foreach ( $insertAfter as $levelModel ) {
						foreach ($levelModel->children() as $option ) {
							if ( $option->name() == 'option' ) {
								$child =& $param->addChildWithAttr( 'option', $option->data(), null, $option->attributes() );
							}
						}
					}

				} else {
					$result[1] = "Missing type def. for param-type " .  $param->attributes( 'type' );
				}
			} else {
				$result[1] =	"No types defined in XML";
			}
		}

		if ( ! isset( $this->_methods ) ) {
			$this->_methods = get_class_methods( get_class( $this ) );
		}
		if ($result[1] ) {
			// nothing to do
		} elseif ( $this->_extendViewParser && in_array( '_form_' . $type, $this->_extendViewParser->_methods ) ) {
			$this->_view					=	$view;
			$this->_extendViewParser->_view	=	$view;
			$result[1] = call_user_func( array( &$this->_extendViewParser, '_form_' . $type ), $name, $value, $param, $control_name );
		} elseif (in_array( '_form_' . $type, $this->_methods )) {
			$this->_view					=	$view;
			$result[1] = call_user_func( array( &$this, '_form_' . $type ), $name, $value, $param, $control_name );
		} else {
		    $result[1] = _HANDLER . ' = ' . $type;
		}

		if ( $description ) {
			if (is_callable("mosToolTip")) {
				$result[2] = mosToolTip( $description, $name );
			} else {
				$result[2] = $description;		// Mambo 4.5.0 compatibility
			}
		} else {
			$result[2] = '';
		}

		if ( ( ! $view ) && ( ! $result[1] ) ) {
			$result		=	array( null, null, null );
		}
		return $result;
	}
	
	function control_name( $control_name, $name ) {
		if ( $control_name ) {
			return $control_name .'['. $name .']';
		} else {
			return $name;
		}
	}
	/**
	* @param string The name of the form element
	* @param string The value of the element
	* @param CBSimpleXMLElement  $node The xml element for the parameter
	* @param string The control name
	* @return string The html for the element
	*/
	function _form_text( $name, $value, &$node, $control_name ) {
		$size = $node->attributes( 'size' );
		return '<input type="text" name="'. $this->control_name( $control_name, $name ) . '" id="'. $this->control_name( $control_name, $name ) . '" value="'. htmlspecialchars($value) .'" class="text_area" size="'. $size .'" />';
	}
	/**
	* Calls method or function of plugin/tab
	* 
	* @param string The name of the form element
	* @param string The value of the element
	* @param CBSimpleXMLElement  $node The xml element for the parameter
	* @param string The control name
	* @return string The html for the element
	*/
	function _form_custom( $name, $value, &$node, $control_name ) {
		global $_CB_database, $_PLUGINS;
		
		$pluginId	=	$this->_pluginObject->id;
		$tabId		=	$this->_tabid;
		
		$class	=	$node->attributes( 'class' );
		$method	=	$node->attributes( 'method' );
		if(!is_null($class) && strlen(trim($class)) > 0) {
			if ($pluginId !== null) {
				$params	=	null;
				if ($tabId !== null) {
					$_CB_database->setQuery( "SELECT * FROM #__comprofiler_tabs t"
					. "\n WHERE t.enabled=1 AND t.tabid = " . (int) $tabId);
					$oTabs = $_CB_database->loadObjectList();
					if (count($oTabs)>0) $params = $oTabs[0]->params;
				}
				$args = array($name,$value,$control_name);
				$_PLUGINS->plugVarValue($pluginId, "published", "1");		// need to be able to call also unpublished plugin for parametring
				return $_PLUGINS->call($pluginId,$method,$class,$args,$params);
			} else {
				$udc = new $class();
				if(method_exists($udc,$method)) {
					return call_user_func_array(array($udc,$method),array($name,$value,$control_name));
				}
			}		
		} elseif (function_exists( $method )) {
			return call_user_func_array( $method, array($name,$value,$control_name) );
		}
		return "";
			
	}


	/**
	* @param string The name of the form element
	* @param string The value of the element
	* @param CBSimpleXMLElement  $node The xml element for the parameter
	* @param string The control name
	* @return string The html for the element
	*/
	function _form_list( $name, $value, &$node, $control_name ) {
		$size = $node->attributes( 'size' );

		$options = array();
		
		if ( $node->attributes( 'blanktext' ) ) {
			$options[] = mosHTML::makeOption( $node->attributes( 'default' ), $node->attributes( 'blanktext' ) );
		}
		foreach ($node->children() as $option) {
			if ( $option->name() == 'option' ) {
				if ( $option->attributes( 'index' ) ) {
					$val = $option->attributes( 'index' );
				} else {
					$val = $option->attributes( 'value' );
				}
				$text = getLangDefinition($option->data());
				$options[] = mosHTML::makeOption( $val, $text );
			}
		}

		return mosHTML::selectList( $options, ''. $this->control_name( $control_name, $name ) . '', 'class="inputbox" id="' . $this->control_name( $control_name, $name ) . '"', 'value', 'text', $value );
	}
	/**
	* @param string The name of the form element
	* @param string The value of the element
	* @param CBSimpleXMLElement  $node The xml element for the parameter
	* @param string The control name
	* @return string The html for the element
	*/
	function _form_radio( $name, $value, &$node, $control_name ) {
		$options = array();
		foreach ($node->children() as $option) {
			if ( $option->attributes( 'index' ) ) {
				$val = $option->attributes( 'index' );
			} else {
				$val = $option->attributes( 'value' );
			}
			$text = getLangDefinition($option->data());
			$options[] = mosHTML::makeOption( $val, $text );
		}
		return moscomprofilerHTML::radioList( $options, ''. $this->control_name( $control_name, $name ) . '', '', $key='value', $text='text', $value );			//TBD missing id :  id="' . $this->control_name( $control_name, $name ) . '"
	}
	/**
	* @param string The name of the form element
	* @param string The value of the element
	* @param CBSimpleXMLElement  $node The xml element for the parameter
	* @param string The control name
	* @return string The html for the element
	*/
	function _form_mos_section( $name, $value, &$node, $control_name ) {
		global $_CB_database;

		$query = "SELECT id AS value, title AS text"
		. "\n FROM #__sections"
		. "\n WHERE published = 1 AND scope = 'content'"
		. "\n ORDER BY title"
		;
		$_CB_database->setQuery( $query );
		$options = $_CB_database->loadObjectList();
		array_unshift( $options, mosHTML::makeOption( '0', '- Select Content Section -' ) );

		return mosHTML::selectList( $options, ''. $this->control_name( $control_name, $name ) . '', 'class="inputbox" id="' . $this->control_name( $control_name, $name ) . '"', 'value', 'text', $value );
	}
	/**
	* @param string The name of the form element
	* @param string The value of the element
	* @param CBSimpleXMLElement  $node The xml element for the parameter
	* @param string The control name
	* @return string The html for the element
	*/
	function _form_mos_category( $name, $value, &$node, $control_name ) {
		global $_CB_database;

		$query 	= "SELECT c.id AS value, CONCAT_WS( '/',s.title, c.title ) AS text"
		. "\n FROM #__categories AS c"
		. "\n LEFT JOIN #__sections AS s ON s.id=c.section"
		. "\n WHERE c.published = 1 AND s.scope='content'"
		. "\n ORDER BY c.title"
		;
		$_CB_database->setQuery( $query );
		$options = $_CB_database->loadObjectList();
		array_unshift( $options, mosHTML::makeOption( '0', '- Select Content Category -' ) );

		return mosHTML::selectList( $options, ''. $this->control_name( $control_name, $name ) . '', 'class="inputbox" id="' . $this->control_name( $control_name, $name ) . '"', 'value', 'text', $value );
	}
	/**
	* @param string The name of the form element
	* @param string The value of the element
	* @param CBSimpleXMLElement  $node The xml element for the parameter
	* @param string The control name
	* @return string The html for the element
	*/
	function _form_field( $name, $value, &$node, $control_name ) {
		global $_CB_database;

		$query 	=	"SELECT f.fieldid AS value, f.title AS text"
		. "\n FROM #__comprofiler_fields AS f"
		. "\n LEFT JOIN #__comprofiler_tabs AS t ON t.tabid = f.tabid"
		. "\n WHERE f.published = 1 AND f.name != 'NA'"
		. "\n ORDER BY t.ordering, f.ordering"
		;
		$_CB_database->setQuery( $query );
		$options				=	$_CB_database->loadObjectList();
		for ($i=0, $n=count($options); $i<$n; $i++) {
			$options[$i]->text	=	getLangDefinition( $options[$i]->text );
		}
		array_unshift( $options, mosHTML::makeOption( '0', '- Select Field -' ) );

		return mosHTML::selectList( $options, ''. $this->control_name( $control_name, $name ) . '', 'class="inputbox" id="' . $this->control_name( $control_name, $name ) . '"', 'value', 'text', $value );
	}
	/**
	* @param string The name of the form element
	* @param string The value of the element
	* @param CBSimpleXMLElement  $node The xml element for the parameter
	* @param string The control name
	* @return string The html for the element
	*/
	function _form_mos_menu( $name, $value, &$node, $control_name ) {
		global $_CB_database;

		$menuTypes = mosAdminMenus::menutypes();
	
		foreach($menuTypes as $menutype ) {
			$options[] = mosHTML::makeOption( $menutype, $menutype );
		}
		array_unshift( $options, mosHTML::makeOption( '', '- Select Menu -' ) );

		return mosHTML::selectList( $options, ''. $this->control_name( $control_name, $name ) . '', 'class="inputbox" id="' . $this->control_name( $control_name, $name ) . '"', 'value', 'text', $value );
	}
	/**
	* @param string The name of the form element
	* @param string The value of the element
	* @param CBSimpleXMLElement  $node The xml element for the parameter
	* @param string The control name
	* @return string The html for the element
	*/
	function _form_imagelist( $name, $value, &$node, $control_name ) {
		global $mainframe;

		// path to images directory
		$path = $mainframe->getCfg('absolute_path') . $node->attributes( 'directory' );
		$files = mosReadDirectory( $path, '\.png$|\.gif$|\.jpg$|\.bmp$|\.ico$' );

		$options = array();
		foreach ($files as $file) {
			$options[] = mosHTML::makeOption( $file, $file );
		}
		if ( !$node->attributes( 'hide_none' ) ) {
			array_unshift( $options, mosHTML::makeOption( '-1', '- Do not use an image -' ) );
		}
		if ( !$node->attributes( 'hide_default' ) ) {
			array_unshift( $options, mosHTML::makeOption( '', '- Use Default image -' ) );
		}

		return mosHTML::selectList( $options, ''. $this->control_name( $control_name, $name ) . '', 'class="inputbox" id="' . $this->control_name( $control_name, $name ) . '"', 'value', 'text', $value );
	}

	/**
	* @param string The name of the form element
	* @param string The value of the element
	* @param CBSimpleXMLElement  $node The xml element for the parameter
	* @param string The control name
	* @return string The html for the element
	*/
	function _form_textarea( $name, $value, &$node, $control_name ) {
 		$rows 	= $node->attributes( 'rows' );
 		$cols 	= $node->attributes( 'cols' );
 		// convert <br /> tags so they are not visible when editing
 		$value 	= str_replace( array( "\\\\", '\n', '\r' ), array( "\\", "\n", "\r" ), $value );

 		return '<textarea name="'. $this->control_name( $control_name, $name ) . '" cols="'. $cols .'" rows="'. $rows .'" class="text_area" id="' . $this->control_name( $control_name, $name ) . '">'. htmlspecialchars($value) .'</textarea>';
	}

	/**
	* @param string The name of the form element
	* @param string The value of the element
	* @param CBSimpleXMLElement  $node The xml element for the parameter
	* @param string The control name
	* @return string The html for the element
	*/
	function _form_spacer( $name, $value, &$node, $control_name ) {
		if ( $value ) {
			return '<strong id="' . $this->control_name( $control_name, $name ) . '">'.$value.'</strong>';
		} else {
			return '<hr id="' . $this->control_name( $control_name, $name ) . '" />';
		}
	}

	/**
	* @param string The name of the form element
	* @param string The value of the element
	* @param CBSimpleXMLElement  $node The xml element for the parameter
	* @param string The control name
	* @return string The html for the element
	*/
	function _form_usergroup( $name, $value, &$node, $control_name ) {
		global $acl, $my;

		$gtree = cbGetAllUsergroupsBelowMe();
	/*
		if ( ! $value ) {
			$value = $acl->get_group_id('Registered','ARO');
			// array_unshift( $gtree, mosHTML::makeOption( '0', '- Select User Group -' ) );
		}
	*/
		if ( $node->attributes( 'blanktext' ) ) {
			array_unshift( $gtree, mosHTML::makeOption( '0', $node->attributes( 'blanktext' ) ) );
		}
		$content	=	mosHTML::selectList( $gtree, $this->control_name( $control_name, $name ), 'class="inputbox" id="' . $this->control_name( $control_name, $name ) . '" size="1"', 'value', 'text', (int) $value );	//  size="10"
		return $content;
	}
	/**
	* special handling for textarea param
	*/
	function textareaHandling( &$txt ) {
		$total = count( $txt );
		for( $i=0; $i < $total; $i++ ) {
			if ( strstr( $txt[$i], "\n" ) ) {
				$txt[$i] = str_replace( array( "\\", "\n", "\r" ), array( "\\\\", '\n', '\r'  ) , $txt[$i] );
			}
		}
		$ret = implode( "\n", $txt );
		return $ret;
	}
}


/**
 * This class is EXPERIMENTAL WIP (reasearch Work In Progress)
 * It is not yet ready for use in CB API and will be developped in a probably incompatible way.
 * That's why it's licence is not yet GPL. It will be released GPL once completed, but that's not this version yet.
 * @license For CB 1.1 internal use only. Copying outside CB not permitted, as it's not yet final. Thanks.
 */
class cbDrawController {
	/** CB page navigator (and ordering)
	 *  @var cbPageNav */
	var $pageNav;
	/** @var CBSimpleXMLElement */
	var $_tableBrowserModel;
	/**  <actions> element
	 * 	@var CBSimpleXMLElement*/
	var $_actions;
	var $_options;
	var $_tableName;
	var $_search;
	var $_searchFields;
	var $_filters;
	var $_statistics;
	var $_control_name;
	
	function cbDrawController( $tableBrowserModel, $actions, $options ) {
		$this->_tableBrowserModel	=& $tableBrowserModel;
		$this->_actions				=& $actions;
		$this->_options				=  $options;
		
		$this->_tableName			= $tableBrowserModel->attributes( 'name' );			// TBD: does this really belong here ???!
	}
	function fieldName( $fieldName ) {
		// search, toggle, idcid[], order[], subtask
		$arrayBrackets = '';
		if ( substr( $fieldName, -2 ) == '[]' ) {
			$fieldName = substr( $fieldName, 0 , -2 );
			$arrayBrackets = '[]';
		}
		return $this->_tableName . '[' . $fieldName . ']' . $arrayBrackets;
	}
	function fieldId( $fieldId, $number=null, $htmlspecs=true ) {		//TBD: htmlspecialchars....
		// id 
		return 'cb' . $this->_tableName . $fieldId . $number;
	}
	function taskName( $subTask, $htmlspecs=true ) {
		// for saveorder,  publish, unpublish, orderup, orderdown
		return $this->_options['task'];
	}
	function fieldValue( $fieldName ) {
		if ( $fieldName == 'search' ) {
			return $this->_search;
		}
		return '';
	}
	function subtaskName( $htmlspecs=true ) {
		// saveorder,  publish, unpublish, orderup, orderdown
		return $this->fieldName( 'subtask' );
	}
	function subtaskValue( $subTask, $htmlspecs=true  ) {
		return $subTask;
	}
	function setSearch( &$search, $searchFields ) {
		$this->_search			=&	$search;
		$this->_searchFields	=	$searchFields;
	}
	function hasSearchFields( ) {
		return ( $this->_searchFields == true );
	}
	function quicksearchfields() {
		$result	=	'';
		if ( $this->hasSearchFields() ) {
			if ( $this->pageNav !== null ) {
				$onchangeJs = $this->pageNav->js_limitstart(0);
			} else {
				$onchangeJs = 'cbParentForm(this).submit();';
			}
			$result =	'<input type="text" name="' . $this->fieldName( 'search' ) . '" value="' . $this->fieldValue( 'search' ) . '" class="text_area" '
						. 'onchange="' . $onchangeJs . '"'
						. ' />';
		}
		return $result;
	}
	/**
	 * returns HTML code for the filters
	 *
	 * @param cbEditRowView $editRowView
	 * @param string        $htmlFormatting  ( 'table', 'td', 'none' )
	 * @return unknown
	 */
	function filters( &$editRowView, $htmlFormatting = 'none' ) {
		global $mainframe;
		$lists 						=	array();
		if ( count( $this->_filters ) > 0 ) {
			/*
			if ( $this->pageNav !== null ) {
				$onchangeJs			=	$this->pageNav->js_limitstart(0);
			} else {
				$onchangeJs			=	'cbParentForm(this).submit();';
			}
			*/
			$valueObj				=	new stdClass();
			$saveName				=	array();
			foreach ( $this->_filters as $k => $v ) {
				$valname			=	'filter_' . $v['name'];
				$valueObj->$valname	=	$v['value'];

				$filterXml			=	$v['xml'];
				$saveName[$k]		=	$filterXml->attributes( 'name' );
				@$filterXml->addAttribute( 'name', 'filter_' . $saveName[$k] );				//TBD: remove @ to silence overriding the previous attribute

				$editRowView->setSelectValues( $filterXml, $v['selectValues'] );
			}
			
			$renderedViews			=	array();
			
			foreach ( $this->_filters as $k => $v ) {
				/** <filter> tag
				 * @var  CBSimpleXmlElement $filterXml */
				$filterXml			=	$v['xml'];



				$viewName				=	$filterXml->attributes( 'view');
				
				if ( $viewName ) {
					$filterXmlParent =	$v['xmlparent'];
					$view			=	$filterXmlParent->getChildByNameAttr( 'view', 'name', $viewName );
					if ( ! $view ) {
						echo 'filter view ' . $viewName . ' not defined in filters';
					}
				} else {
					$view			=	$filterXml->getElementByPath( 'view' );
				}
				
				if ( $view ) {
					if ( ( ! $viewName ) || ! in_array( $viewName, $renderedViews ) ) {
						$lists[$k]		=	$editRowView->renderEditRowView( $view, $valueObj, $this, $this->_options, 'param', $htmlFormatting );
					}
					if ( $viewName ) {
						$renderedViews[] =	$viewName;
					}
				} else {
					$editRowView->setModelOfData( $valueObj );
					$result			=	$editRowView->renderParam( $filterXml, $this->control_name(), false );
					$lists[$k]		=	'<div class="cbFilter">'
									. '<span class="cbLabelSpan">' . $result[0] . '</span> '
									. '<span class="cbDescrSpan">' . $result[2] . '</span>'
									. '<span class="cbFieldSpan">' . $result[1] . '</span>'
									. '</div>';
				}
			}
			foreach ( $this->_filters as $k => $v ) {
				@$filterXml->addAttribute( 'name', $saveName[$k] );				//TBD: remove @ to silence overriding the previous attribute
			}
			if ( count( $lists ) > 1 ) {
				$adminimagesdir		=	$mainframe->getCfg( 'live_site' ) . '/components/com_comprofiler/images/';
				$lists[]			=	'<div class="cbFilter"><input type="image" src="' . $adminimagesdir . '/search.gif" alt="' . _UE_SEARCH . '" align="top" style="border: 0px;" /></div>';
			}
		}
		return $lists;
	}
	function setFilters( &$filters ){
		$this->_filters = $filters;
	}
	function setStatistics( &$statsArray ) {
		$this->_statistics =& $statsArray;
	}
	function & getStatistics( ) {
		return $this->_statistics;
	}
	function control_name( ) {
		return $this->_control_name;
	}
	function setControl_name( $control_name ) {
		$this->_control_name = $control_name;
	}
	function drawUrl( $cbUri, &$sourceElem, &$data, $id, $htmlspecialchars=true ) {
		if ( substr( $cbUri, 0, 4 ) == 'cbo:' ) {
			$subTaskValue	=	substr( $cbUri, 4 );
			switch ( $subTaskValue ) {
				case 'newrow':
					$id	=	0;
					// fallthrough: no break on purpose.
				case 'rowedit':				//TBD this is duplicate of below
					$baseUrl	= 'index2.php?option=' . $this->_options['option'] . '&task=' . $this->_options['task'] . '&cid=' . $this->_options['pluginid'];
					$url	= $baseUrl . '&table=' . $this->_tableBrowserModel->attributes( 'name' ) . '&action=editrow';		// below: . '&tid=' . $id;
					break;
				case 'editrows':
				case 'deleterows':
				case 'copyrows':
				case 'publish':
				case 'unpublish':
					$url	= 'javascript:cbDoListTask(this, '				// cb					//TBD: this is duplicate of pager.
					. "'" . $this->taskName( false ). "','" 				// task
					. $this->subtaskName( false ). "','" 					// subtaskName
					. $this->subtaskValue( $subTaskValue, false ) . "','" 	// subtaskValue
					. $this->fieldId( 'id', null, false ) . "'"				// fldName
					. ");";
					break;
				default:
					$url	=	"UNDEFINED_URL-" . $cbUri;
					break;
			}

		} elseif ( substr( $cbUri, 0, 10 ) == 'cb_action:' ) {

			$actionName				=	substr( $cbUri, 10 );
			$action					=&	$this->_actions->getChildByNameAttr( 'action', 'name', $actionName );
			if ( $action ) {
				$requestNames		=	explode( ' ', $action->attributes( 'request' ) );
				$requestValues		=	explode( ' ', $action->attributes( 'action' ) );
				$parametersValues	=	explode( ' ', $action->attributes( 'parameters' ) );
				
				$baseUrl			=	'index2.php?';
				$baseRequests		=	array( 'option' => 'option', 'task' => 'task', 'cid' => 'pluginid' );
				$urlParams			=	array();
				foreach ( $baseRequests as $breq => $breqOptionsValue ) {
					if ( ( ! ( in_array( $breq, $requestNames ) || in_array( $breq, $parametersValues ) ) ) && isset( $this->_options[$breqOptionsValue] ) ) {
						$urlParams[$breq]	=	$breq . '=' . $this->_options[$breqOptionsValue];
					}
				}

				$url		= $baseUrl;
				for ( $i = 0, $n = count( $requestNames ); $i < $n; $i++ ) {
					$urlParams[$requestNames[$i]]	=	$requestNames[$i] . '=' . $requestValues[$i];				// other parameters = paramvalues added below
				}
				$url		=	$baseUrl . implode( '&', $urlParams );
			} else {
				$url = "#action_not_defined:" . $actionName;
			}

		} else {

			$url = $cbUri;

		}

		// get the parameters of action/link from XML :
		$parametersNames	=	explode( ' ', $sourceElem->attributes( 'parameters' ) );
		$parametersValues	=	explode( ' ', $sourceElem->attributes( 'paramvalues' ) );

		// add currently activated filters to the parameters:
		if ( count( $this->_filters ) > 0 ) {
			foreach ( $this->_filters as $k => $v ) {
				$filterName		=	$this->fieldName( $k );
				if ( ( $v['value'] != $v['default'] ) && ( ! in_array( $filterName, $parametersNames ) ) ) {
					$parametersNames[]	=	$filterName;
					$parametersValues[]	=	"'" . $v['value'] . "'";
				}
			}
		}

		// add current search string, if any:
		$searchName		=	$this->fieldName( 'search' );
		$searchValue	=	$this->fieldValue( 'search' );
		if ( $searchValue && ( ! in_array( $searchName, $parametersNames ) ) ) {
			$parametersNames[]	=	$searchName;
			$parametersValues[]	=	"'" . $searchValue . "'";
		}

		// finally generate URL:
		for ( $i = 0, $n = count( $parametersNames ); $i < $n; $i++ ) {
			$nameOfVariable		=	$parametersValues[$i];
			if ($nameOfVariable) {
				$url	.=	'&' . $parametersNames[$i] . '=' 
						. ( ( ( substr( $nameOfVariable, 0, 1 ) == "'" ) && ( substr( $nameOfVariable, -1 ) == "'" ) ) ?
									substr( $nameOfVariable, 1, -1 ) : $data->$nameOfVariable );
			}
		}

		if ( $htmlspecialchars ) {
			$url = htmlspecialchars( $url );
		}
		return $url;
	}

	function drawPageNvigator( $positionType /* , $viewModelElement ??? */ ) {
		
	}
	function createPageNvigator( $total, $limitstart, $limit ) {
		global $_CB_joomla_adminpath;

		cbimport( 'cb.pagination' );
		$this->pageNav = new cbPageNav( $total, $limitstart, $limit, array( &$this, 'fieldName' ), $this );
		$this->pageNav->setControllerView( $this );
	}
/*		$this->pageNav =& $pageNav;
		$this->filters =& $this->filters;
		$this->search  =& $this->search;
*/
}	// class cbDrawController


?>
