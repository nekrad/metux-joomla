<?php
/**
* @version $Id: cb.pagination.php 344 2006-11-21 23:25:39Z beat $
* @package Community Builder
* @subpackage cb.pagination.php
* @author Beat and various
* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

/**
* Page navigation support class
*/
class cbPageNav {
	/** The record number to start dislpaying from 
	 *  @var int */
	var $limitstart 	= null;
	/** Number of rows to display per page
	 * @var int */
	var $limit 			= null;
	/** Total number of rows
	 * @var int */
	var $total 			= null;
	/** returns input name for form
	 * @var function method($name) */
	var $_fieldNameFnct	= null;
	/** CB Draw Controller for ordering feature
	 * @var cbDrawController */
	var $_controllerView;
	/** Number of rows displayed on the page
	 * @var int */
	var $_n 			= null;
	/** Current index of row during display for ordering icons feature
	 * @var int */
	var $_i 			= null;


	function cbPageNav( $total, $limitstart, $limit, $fieldNamingMethod=null ) {
		$this->total 		= (int) $total;
		$this->limitstart 	= (int) max( $limitstart, 0 );
		$this->limit 		= (int) max( $limit, 1 );
		if ($this->limit > $this->total) {
			$this->limitstart = 0;
		}
		if (($this->limit-1)*$this->limitstart > $this->total) {
			$this->limitstart -= $this->limitstart % $this->limit;
		}
		if ( $fieldNamingMethod ) {
			$this->_fieldNameFnct = $fieldNamingMethod;
		} else {
			$this->_fieldNameFnct = array( &$this, '_defaultFieldNameFnct' );
		}
	}
	function _defaultFieldNameFnct( $name ) {
		return $name;
	}
	function _fieldName( $name ) {
		return call_user_func( $this->_fieldNameFnct, $name );
	}
	/**
	 * transforms a well-formed nested array : a[b[c[x]]] -> a['b']['c']['x'] (x optional)
	 *
	 * @param string $str
	 * @return string
	 */
	function _unnestArray( $str ) {
		if ( substr( $str, -1, 1 ) == ']' ) {
			$res = strtok( $str, '[]' );
			while ( ( ( $token = strtok( '[]' ) ) !== false ) ) {
				$res .= "['" . $token . "']";
			}
			if ( strpos( $str, '[]' ) !== false ) {
				$res .= '[]';
			}
		} else {
			$res = $str;
		}
		return $res;
	}
	function js_limitstart( $value ) {
		return "cbParentForm(this)." . "elements['".$this->_fieldName('limitstart') . "'].value=" . (int) $value . ";"
			 . "cbParentForm(this).submit();return false;";
	}
	
	/**
	* @return string The html for the limit # input box
	*/
	function getLimitBox () {
		$limits = array();
		foreach ( array(1,2,3,5,10,15,20,30,50,100) as $i ) {
			$limits[] = mosHTML::makeOption( "$i" );
		}

		// build the html select list
		$html = mosHTML::selectList( $limits, $this->_fieldName( 'limit' ), 'class="inputbox" size="1" onchange="' . $this->js_limitstart(0) . '"',
									'value', 'text', $this->limit );
		$html .= "\n<input type=\"hidden\" name=\"" . $this->_fieldName( 'limitstart' ) . "\" value=\"$this->limitstart\" />";
		return $html;
	}
	/**
	* Writes the html limit # input box
	*/
	function writeLimitBox () {
		echo mosPageNav::getLimitBox();
	}
	function writePagesCounter() {
		echo $this->getPagesCounter();
	}
	/**
	* @return string The html for the pages counter, eg, Results 1-10 of x
	*/
	function getPagesCounter() {
		$html = '';
		$from_result = $this->limitstart+1;
		if ($this->limitstart + $this->limit < $this->total) {
			$to_result = $this->limitstart + $this->limit;
		} else {
			$to_result = $this->total;
		}
		if ($this->total > 0) {
			$html .= "\n" . _UE_RESULTS . " <strong>" . $from_result . " - " . $to_result . "</strong> " . _UE_OF_TOTAL . " <strong>" . $this->total . "</strong>";

		} else {
			$html .= "\n" . _UE_NO_RESULTS . ".";
		}
		return $html;
	}
	/**
	* Writes the html for the pages counter, eg, Results 1-10 of x
	*/
	function writePagesLinks() {
		echo $this->getPagesLinks();
	}
	/**
	* @return string The html links for pages, eg, previous, next, 1 2 3 ... x
	*/
	function getPagesLinks() {
		$limitstart = max( (int) $this->limitstart, 0 );
		$limit		= max( (int) $this->limit, 1 );
		$total		= (int) $this->total;
		$html 				= '';
		$displayed_pages 	= 10;		// set how many pages you want displayed in the menu (not including first&last, and ev. ... repl by single page number.
		$total_pages = ceil( $total / $limit );
		$this_page = ceil( ($limitstart+1) / $limit );
//		$start_loop 		= (floor(($this_page-1)/$displayed_pages))*$displayed_pages+1;
		$start_loop = $this_page-floor($displayed_pages/2);
		if ($start_loop < 1) {
			$start_loop = 1;
		}
		if ($start_loop == 3) {
			$start_loop = 2;
		}
		if ( $start_loop + $displayed_pages - 1 < $total_pages - 2 ) {
			$stop_loop = $start_loop + $displayed_pages - 1;
		} else {
			$stop_loop = $total_pages;
		}

		if ($this_page > 1) {
			$page = ($this_page - 2) * $this->limit;
			$html .= "\n<a href=\"#beg\" class=\"pagenav\" title=\"" . _UE_FIRST_PAGE . "\" onclick=\"" . $this->js_limitstart(0) . "\">&lt;&lt;&nbsp;" . _UE_FIRST_PAGE . "</a>";
			$html .= "\n<a href=\"#prev\" class=\"pagenav\" title=\"" . _UE_PREV_PAGE . "\" onclick=\"" . $this->js_limitstart( $page ) . "\">&lt;&nbsp;" . _UE_PREV_PAGE . "</a>";
			if ($start_loop > 1) {
				$html .= "\n<a href=\"#beg\" class=\"pagenav\" title=\"" . _UE_FIRST_PAGE . "\" onclick=\"" . $this->js_limitstart(0) . "\">&nbsp;1</a>";
			}
			if ($start_loop > 2) {
				$ret .= "\n<span class=\"pagenav\"> <strong>...</strong> </span>";
			}
		} else {
			$html .= "\n<span class=\"pagenav\">&lt;&lt;&nbsp;" . _UE_FIRST_PAGE . "</span>";
			$html .= "\n<span class=\"pagenav\">&lt;&nbsp;" . _UE_PREV_PAGE . "</span>";
		}

		for ($i=$start_loop; $i <= $stop_loop; $i++) {
			$page = ($i - 1) * $this->limit;
			if ($i == $this_page) {
				$html .= "\n<span class=\"pagenav\"> $i </span>";
			} else {
				$html .= "\n<a href=\"#$i\" class=\"pagenav\" onclick=\"" . $this->js_limitstart( $page ) . "\"><strong>$i</strong></a>";
			}
		}

		if ($this_page < $total_pages) {
			$page = $this_page * $this->limit;
			$end_page = ($total_pages-1) * $this->limit;
			if ($stop_loop < $total_pages-1) {
				$html .= "\n<span class=\"pagenav\"> <strong>...</strong> </span>";
			}
			if ($stop_loop < $total_pages) {
				$html .= "\n<a href=\"#end\" class=\"pagenav\" title=\"" . _UE_END_PAGE . "\" onclick=\"" . $this->js_limitstart( $end_page ) . "\"> <strong>" . $total_pages."</strong></a>";
			}
			$html .= "\n<a href=\"#next\" class=\"pagenav\" title=\"" . _UE_NEXT_PAGE . "\" onclick=\"" . $this->js_limitstart( $page ) . "\"> " . _UE_NEXT_PAGE . "&nbsp;&gt;</a>";
			$html .= "\n<a href=\"#end\" class=\"pagenav\" title=\"" . _UE_END_PAGE . "\" onclick=\"" . $this->js_limitstart( $end_page ) . "\"> " . _UE_END_PAGE . "&nbsp;&gt;&gt;</a>";
		} else {
			$html .= "\n<span class=\"pagenav\">Next&nbsp;&gt;</span>";
			$html .= "\n<span class=\"pagenav\">End&nbsp;&gt;&gt;</span>";
		}
		return $html;
	}

	function getListFooter() {
		$html = '<table class="adminlist"><tr><th colspan="3" style="text-align:center;">';
		$html .= $this->getPagesLinks();
		$html .= '</th></tr><tr>';
		$html .= '<td nowrap="nowrap" width="48%" align="right">Display #</td>';
		$html .= '<td>' .$this->getLimitBox() . '</td>';
		$html .= '<td nowrap="nowrap" width="48%" align="left">' . $this->getPagesCounter() . '</td>';
		$html .= '</tr></table>';
  		return $html;
	}
/**
* @param int The row index
* @return int
*/
	function rowNumber( $i ) {
		return $i + 1 + $this->limitstart;
	}


/**
* @param int The row index
* @param string The task to fire
* @param string The alt text for the icon
* @return string
*/
	function orderUpIcon( $i=null, $condition=true, $task='orderup', $alt="Move Up" ) {
		if ( $i === null ) {
			$i	=	$this->_i;
		}
		if (($i > 0 || ($i+$this->limitstart > 0)) && $condition) {
			return "<a href=\"#reorder\" onClick=\"return cbListItemTask(this, '" . $this->_controllerView->taskName( false ). "','"
					. $this->_controllerView->subtaskName( false ). "','" . $this->_controllerView->subtaskValue( $task, false ) . "', '" 
					. $this->_controllerView->fieldId( 'id', null, false ) . "', " . $i . ')" title="'.$alt.'">'
					. '<img src="images/uparrow.png" width="12" height="12" border="0" alt="'.$alt.'">'
					. '</a>';
  		} else {
  			return '&nbsp;';
		}
	}
/**
* @param int The row index
* @param int The number of items in the list
* @param string The task to fire
* @param string The alt text for the icon
* @return string
*/
	function orderDownIcon( $i=null, $n=null, $condition=true, $task='orderdown', $alt="Move Down" ) {
		if ( $i === null ) {
			$i	=	$this->_i;
		}
		if ( $n === null ) {
			$n	=	$this->_n;
		}
		if (($i < $n-1 || $i+$this->limitstart < $this->total-1) && $condition) {
			return "<a href=\"#reorder\" onClick=\"return cbListItemTask(this, '" . $this->_controllerView->taskName( false ). "','" 
					. $this->_controllerView->subtaskName( false ). "','" . $this->_controllerView->subtaskValue( $task, false ) . "', '" 
					. $this->_controllerView->fieldId( 'id', null, false ) . "', " . $i . ')" title="'.$alt.'">'
						 .	'<img src="images/downarrow.png" width="12" height="12" border="0" alt="'.$alt.'">'
						 .	'</a>';
  		} else {
  			return '&nbsp;';
		}
	}
/**
* @param string  $value  The current value
* @param boolean $toggling  if it's toggling or just displaying icon
* @param int     $i      The row index
* @return string
*/
	function publishedToggle( $value, $toggling, $i=null ) {
		if ( $i === null ) {
			$i	=	$this->_i;
		}
		$img		= $value ? 'publish_g.png' 		: 'publish_x.png';
		$task 		= $value ? 'unpublish'			: 'publish';
		$alt 		= $value ? 'Published'			: 'Unpublished';
		$action		= $value ? 'Unpublish Item'		: 'Publish item';
		$html = '';
		if ( $toggling ) {
			$html .= '<a href="javascript: void(0);" onclick="return cbListItemTask(this, '	// cb
					. "'" . $this->_controllerView->taskName( false ). "','" 				// task
					. $this->_controllerView->subtaskName( false ). "','" 					// subtaskName
					. $this->_controllerView->subtaskValue( $task, false ) . "', '" 		// subtaskValue
					. $this->_controllerView->fieldId( 'id', null, false ) . "', "			// fldName
					. $i																	// id
					. ")\" title=\"". $action .'">';
		}
		$html 		.= '<img src="images/' . $img . '" border="0" alt="'. $alt . '" />';
		if ( $toggling ) {
			$html  .= '</a>';
		}
		return $html;
	}

/**
* @param string  $name      The field name (task to fire: enable_fieldname / disable_fieldname)
* @param string  $value     The current value
* @param boolean $toggling  if it's toggling or just displaying icon
* @param int     $i         The row index
* @return string
*/
	function checkMarkToggle( $name, $value, $toggling, $i=null ) {
		if ( $i === null ) {
			$i	=	$this->_i;
		}
		$img		= $value ? 'tick.png' 			: 'publish_x.png';
		$task 		= $value ? 'disable/' . $name	: 'enable/' . $name;
		$alt 		= $value ? 'Yes'				: 'No';
		$action		= $value ? 'Disable Item'		: 'Enable item';
		$html = '';
		if ( $toggling ) {
			$html .= '<a href="javascript: void(0);" onclick="return cbListItemTask(this, '	// cb
					. "'" . $this->_controllerView->taskName( false ). "','" 				// task
					. $this->_controllerView->subtaskName( false ). "','" 					// subtaskName
					. $this->_controllerView->subtaskValue( $task, false ) . "', '" 		// subtaskValue
					. $this->_controllerView->fieldId( 'id', null, false ) . "', "			// fldName
					. $i																	// id
					. ")\" title=\"". $action .'">';
		}
		$html 		.= '<img src="images/' . $img . '" border="0" alt="'. $alt . '" />';
		if ( $toggling ) {
			$html  .= '</a>';
		}
		return $html;
	}

	/**
	 * Set Current index of row during display for ordering icons feature
	 *
	 * @param cbDrawController $controllerView
	 */
	function setControllerView( &$controllerView ) {
		$this->_controllerView	=&	$controllerView;
	}
	/**
	 * Set Number of rows displayed on the page
	 *
	 * @param int $n
	 */
	function setN( $n ) {
		$this->_n	=	$n;
	}
	/**
	 * Set Current index of row during display for ordering icons feature
	 *
	 * @param unknown_type $i
	 */
	function setI( $i ) {
		$this->_i	=	$i;
	}

//TBD: //FIXME methods below are not yet adapted to CB:
	/**
	 * @param int The row index
	 * @param string The task to fire
	 * @param string The alt text for the icon
	 * @return string
	 */
	function orderUpIcon2( $id, $order, $condition=true, $task='orderup', $alt='#' ) {
		// handling of default value
		if ($alt = '#') {
			$alt = 'Move Up';
		}

		if ($order == 0) {
			$img = 'uparrow0.png';
			$show = true;
		} else if ($order < 0) {
			$img = 'uparrow-1.png';
			$show = true;
		} else {
			$img = 'uparrow.png';
			$show = true;
		};
		if ($show) {
			$output = '<a href="#ordering" onClick="listItemTask(\'cb'.$id.'\',\'orderup\')" title="'. $alt .'">';
			$output .= '<img src="images/' . $img . '" width="12" height="12" border="0" alt="'. $alt .'" title="'. $alt .'" /></a>';

			return $output;
   		} else {
  			return '&nbsp;';
		}
	}

	/**
	 * @param int The row index
	 * @param int The number of items in the list
	 * @param string The task to fire
	 * @param string The alt text for the icon
	 * @return string
	 */
	function orderDownIcon2( $id, $order, $condition=true, $task='orderdown', $alt='#' ) {
		// handling of default value
		if ($alt = '#') {
			$alt = 'Move Down';
		}

		if ($order == 0) {
			$img = 'downarrow0.png';
			$show = true;
		} else if ($order < 0) {
			$img = 'downarrow-1.png';
			$show = true;
		} else {
			$img = 'downarrow.png';
			$show = true;
		};
		if ($show) {
			$output = '<a href="#ordering" onClick="listItemTask(\'cb'.$id.'\',\'orderdown\')" title="'. $alt .'">';
			$output .= '<img src="images/' . $img . '" width="12" height="12" border="0" alt="'. $alt .'" title="'. $alt .'" /></a>';

			return $output;
  		} else {
  			return '&nbsp;';
		}
	}

	/**
	 * Sets the vars for the page navigation template
	 */
	function setTemplateVars( &$tmpl, $name = 'admin-list-footer' ) {
		$tmpl->addVar( $name, 'PAGE_LINKS', $this->getPagesLinks() );
		$tmpl->addVar( $name, 'PAGE_LIST_OPTIONS', $this->getLimitBox() );
		$tmpl->addVar( $name, 'PAGE_COUNTER', $this->getPagesCounter() );
	}
}
?>