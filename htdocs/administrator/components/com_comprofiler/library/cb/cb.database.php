<?php
/**
* @version $Id: cb.database.php 344 2007-07-25 02:25:39Z beat $
* @package Community Builder
* @subpackage cb.database.php
* @author Beat and various
* @copyright (C) Beat and various, www.joomlapolis.com
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );


/* MAMBO 4.5.2.3 FIXES + EXTENSIONS: */

/**
*	Corrects bugs in mambo core class mosDBTable ! :
*	1) NULL values from SQL tables are not loaded !
*	2) updateOrder method is buggy and does not allow to specify modified row ids to force them into the right position !
*/
class comprofilerDBTable extends mosDBTable {
	/**
	*	Object constructor to set table and key field
	*
	*	Can be overloaded/supplemented by the child class
	*	@param string $table name of the table in the db schema relating to child class
	*	@param string $key name of the primary key field in the table
	*/
	function comprofilerDBTable( $table, $key, &$db ) {
		$this->mosDBTable($table, $key, $db);
	}
	/**
	*	binds an array/hash to this object
	*	@param int $oid optional argument, if not specifed then the value of current key is used
	*	@return any result from the database operation
	*/
	function load( $oid=null ) {
		$k = $this->_tbl_key;
		if ($oid !== null) {
			$this->$k = $oid;
		}
		$oid = $this->$k;
		if ($oid === null) {
			return false;
		}
		
		//BB fix : resets default values to all object variables, because NULL SQL fields do not overide existing variables !
		//Note: Prior to PHP 4.2.0, Uninitialized class variables will not be reported by get_class_vars().
		$class_vars = get_class_vars(get_class($this));
		foreach ($class_vars as $name => $value) {
			if (($name != $k) and ($name != "_db") and ($name != "_tbl") and ($name != "_tbl_key")) {
				$this->$name = $value;
			}
		}
		//end of BB fix.

		return parent::load( $oid );
	}
	/**
	* @param string $where This is expected to be a valid (and safe!) SQL expression
	*/
	function move( $dirn, $where = '', $ordering = 'ordering' ) {
		$k = $this->_tbl_key;

		$sql = "SELECT $this->_tbl_key, $ordering FROM $this->_tbl";

		if ($dirn < 0) {
			$sql .= "\n WHERE $ordering < " . (int) $this->$ordering;
			$sql .= ($where ? "\n	AND $where" : '');
			$sql .= "\n ORDER BY $ordering DESC";
			$sql .= "\n LIMIT 1";
		} else if ($dirn > 0) {
			$sql .= "\n WHERE $ordering > " . (int) $this->$ordering;
			$sql .= ($where ? "\n	AND $where" : '');
			$sql .= "\n ORDER BY $ordering";
			$sql .= "\n LIMIT 1";
		} else {
			$sql .= "\nWHERE $ordering = " . (int) $this->$ordering;
			$sql .= ($where ? "\n AND $where" : '');
			$sql .= "\n ORDER BY $ordering";
			$sql .= "\n LIMIT 1";
		}

		$this->_db->setQuery( $sql );

		$row = null;
		if ($this->_db->loadObject( $row )) {
			$query = "UPDATE $this->_tbl"
			. "\n SET $ordering = " . (int) $row->$ordering
			. "\n WHERE $this->_tbl_key = " . $this->_db->Quote( $this->$k )
			;
			$this->_db->setQuery( $query );

			if (!$this->_db->query()) {
				$err = $this->_db->getErrorMsg();
				die( $err );
			}

			$query = "UPDATE $this->_tbl"
			. "\n SET $ordering = " . (int) $this->$ordering
			. "\n WHERE $this->_tbl_key = " . $this->_db->Quote( $row->$k )
			;
			$this->_db->setQuery( $query );

			if (!$this->_db->query()) {
				$err = $this->_db->getErrorMsg();
				die( $err );
			}

			$this->$ordering = $row->$ordering;
		} else {
			$query = "UPDATE $this->_tbl"
			. "\n SET $ordering = " . (int) $this->$ordering
			. "\n WHERE $this->_tbl_key = " . $this->_db->Quote( $this->$k )
			;
			$this->_db->setQuery( $query );

			if (!$this->_db->query()) {
				$err = $this->_db->getErrorMsg();
				die( $err );
			}
		}
	}

	/** private utility method for updateOrder() back-called by usort() for comparing orderings
	*/
	function _cmp_obj($a, $b) {
		$k = $this->_cbc_cbc_ordering_tmp;
		if ($a->$k == $b->$k) {
           return 0;
       }
       return ($a->$k > $b->$k) ? +1 : -1;
   }
	/**
	* Compacts the ordering sequence of the selected records
	* @param string Additional where query to limit ordering to a particular subset of records
	* @param array of table key ids which should preserve their position (in addition of the negative positions) 
	*/
	function updateOrder( $where = '' , $cids = null, $ordering = 'ordering' ) {
		$k = $this->_tbl_key;

		if (!array_key_exists( $ordering, get_class_vars( strtolower(get_class( $this )) ) )) {
			$this->_error = "WARNING: ".strtolower(get_class( $this ))." does not support ordering field" . $ordering . ".";
			return false;
		}

		if ($this->_tbl == "#__content_frontpage") {
			$order2 = ", content_id DESC";
		} else {
			$order2 = "";
		}

		$this->_db->setQuery( "SELECT $this->_tbl_key, $ordering FROM $this->_tbl"
		. ($where ? "\nWHERE $where" : '')
		. "\nORDER BY " . $ordering . $order2
		);
		if (!($orders = $this->_db->loadObjectList())) {
			$this->_error = $this->_db->getErrorMsg();
			return false;
		}

		$n=count( $orders );
		$iOfThis = null;
		
		if($cids !== null) {
			$cidsOrderings = array();			// determine list of reserved/changed ordering numbers
			for ($i=0; $i < $n; $i++) {
				if (in_array($orders[$i]->$k, $cids)) {
					$cidsOrderings[$orders[$i]->$k] = $orders[$i]->$ordering;
				}
			}

			$j = 1;								// change ordering numbers outside of reserved and negative ordering numbers list
			for ($i=0; $i < $n; $i++) {
				if ($orders[$i]->$k == $this->$k) {
					// place 'this' record in the desired location at the end !
					$iOfThis = $i;
					if ($orders[$i]->$ordering == $j) $j++;
				} else if (in_array($orders[$i]->$k, $cids)) {
					if ($orders[$i]->$ordering == $j) $j++;
				} else {
					if ($orders[$i]->$ordering >= 0) $orders[$i]->$ordering = $j++;
					while (in_array($orders[$i]->$ordering, $cidsOrderings)) $orders[$i]->$ordering = $j++;
				}
			}
		} else {
			$j = 1;
			for ($i=0; $i < $n; $i++) {
				if ($orders[$i]->$k == $this->$k) {
					// place 'this' record in the desired location at the end !
					$iOfThis = $i;
					if ($orders[$i]->$ordering == $j) $j++;
				} else if ($orders[$i]->$ordering != $this->$ordering && $this->$ordering > 0 && $orders[$i]->$ordering >= 0) {
					$orders[$i]->$ordering = $j++;
				} else if ($orders[$i]->$ordering == $this->$ordering && $this->$ordering > 0 && $orders[$i]->$ordering >= 0) {
					if ($orders[$i]->$ordering == $j) $j++;
					$orders[$i]->$ordering = $j++;
				}
			}
		}
		if ($iOfThis !== null) {
			$orders[$iOfThis]->$ordering = min( $this->$ordering, $j );
		}
		// sort entries by ->$ordering:
		$this->_cbc_cbc_ordering_tmp	=	$ordering;
		usort($orders, array("comprofilerDBTable", "_cmp_obj"));
		unset( $this->_cbc_cbc_ordering_tmp );

		// compact ordering:
		$j = 1;
		for ($i=0; $i < $n; $i++) {
			if ($orders[$i]->$ordering >= 0) {
				$orders[$i]->$ordering = $j++;
			}
		}

		for ($i=0; $i < $n; $i++) {
			if (($orders[$i]->$ordering >= 0) or ($orders[$i]->$k == $this->$k)) {
				$this->_db->setQuery( "UPDATE $this->_tbl"
				. "\nSET $ordering='".$orders[$i]->$ordering."' WHERE $k='".$orders[$i]->$k."'"
				);
				$this->_db->query();
			}
		}

		// if we didn't find to reorder the current record, make it last
		if (($iOfThis === null) && ($this->$ordering > 0)) {
			$order = $n+1;
			$this->_db->setQuery( "UPDATE $this->_tbl"
			. "\nSET $ordering='$order' WHERE $k='".$this->$k."'"
			);
			$this->_db->query();
		}
		return true;
	}

	// MISSING FROM EARLY VERSIONS:
	/**
	* Resets public properties
	* @param mixed The value to set all properties to, default is null
	*/
	function reset( $value=null ) {
		$keys = $this->getPublicProperties();
		foreach ($keys as $k) {
			$this->$k = $value;
		}
	}
	/**
	* Tests if item is checked out
	* @param  int      A user id
	* @return boolean
	 */
	function isCheckedOut( $user_id = 0 ) {
		if ( $user_id ) {
			return ( $this->checked_out && ( $this->checked_out != $user_id ) );
		} else {
			return $this->checked_out;
		}
	}
	// EXTENSIONS: EXPERIMENTAL IN CB 1.1, NOT PART OF API:
	/**
	* Loads an array of typed objects of a given class (same class as current object by default)
	*
	* @param  string $class [optional] class name
	* @param  string $key [optional] key name in db to use as key of array
	* @param  array  $additionalVars [optional] array of string additional key names to add as vars to object
	* @return array  of objects of the same class (empty array if no objects)
	*/
	function & loadTrueObjects( $class=null, $key="", $additionalVars=array() ) {
		$objectsArray = array();
		$resultsArray = $this->_db->loadAssocList( $key );
		if ( is_array($resultsArray) ) {
			if ( $class == null ) {
				$class = get_class($this);
			}
			foreach ( $resultsArray as $k => $value ) {
				$objectsArray[$k] =& new $class( $this->_db );
				mosBindArrayToObject( $value, $objectsArray[$k], null, null, false );
				foreach ( $additionalVars as $index ) {
					if ( array_key_exists( $index, $value ) ) {
						$objectsArray[$k]->$index = $value[$index];
					}
				}
			}
		}
		return $objectsArray;
	}
}	// end class comprofilerDBTable

/**
*	Provides CMS database independance and
*	Corrects bugs and backwards compatibility issues in mambo core class mosDBTable ! :
*	1) empty lists return empty arrays and not NULL values !
*	2) gives a coherent interface to CB, independant of various CMS flavors
*/
class CBdatabase {
	/**  Host CMS database class
	* @var database */
	var $_db;

	/**
	* Database object constructor
	*/
	function CBdatabase( &$_CB_database ) {
		$this->_db	=&	$_CB_database;
	}
	/**
	* Sets debug level
	* @param int
	*/
	function debug( $level ) {
		$this->_db->debug( $level );
	}
	/**
	* @return int The error number for the most recent query
	*/
	function getErrorNum( ) {
		return $this->_db->getErrorNum();
	}
	/**
	* @return string The error message for the most recent query
	*/
	function getErrorMsg( ) {
		return $this->_db->getErrorMsg();
	}
	/**
	* Get a database escaped string
	* @return string
	*/
	function getEscaped( $text ) {
		return $this->_db->getEscaped( $text );
	}
	/**
	* Get a quoted database escaped string
	* @return string
	*/
	function Quote( $text ) {
		return '\'' . $this->_db->getEscaped( $text ) . '\'';
	}
	/**
	* Quote an identifier name (field, table, etc)
	* @param  string  The name
	* @return string  The quoted name
	*/
	function NameQuote( $s ) {
		return '`' . $s . '`';
	}
	/**
	* @return string Quoted null/zero date string
	*/
	function getNullDate( ) {
		return '0000-00-00 00:00:00';
	}
	/**
	* Sets the SQL query string for later execution.
	*
	* This function replaces a string identifier <var>$prefix</var> with the
	* string held is the <var>_table_prefix</var> class variable.
	*
	* @param string $sql     The SQL query
	* @param int    $offset  The offset to start selection
	* @param int    $limit   The number of results to return
	* @param string $prefix  The common table prefix search for replacement string
	*/
	function setQuery( $sql, $offset = 0, $limit = 0, $prefix='#__' ) {
		global $_VERSION;

		if ( ( $_VERSION->PRODUCT == "Joomla!" || $_VERSION->PRODUCT == "Accessible Joomla!" ) ) {
			$this->_db->setQuery( $sql, $offset, $limit, $prefix );
		} else {
			// Mambo:
			if ( $offset || $limit ) {
				$sql		.=	" LIMIT ";
				if ( $offset ) {
					$sql	.=	( (int) $offset ) . ', ';
				}
				$sql		.=	( (int) $limit );
			}
			$this->_db->setQuery( $sql, $prefix );
		}
	}
	/**
	* @return string The current value of the internal SQL vairable
	*/
	function getQuery( ) {
		return $this->_db->getQuery();
	}
	/**
	* Execute the query
	* 
	* @param  string  the query (optional, it will use the setQuery one otherwise)
	* @return mixed A database resource if successful, FALSE if not.
	*/
	function query( $sql = null ) {
		if ( $sql ) {
			$this->setQuery( $sql );
		}
		return $this->_db->query();
	}
	/**
	 * Executes a series of SQL orders, optionally as a transaction
	 *
	 * @param  boolean $abort_on_error      Aborts on error (true by default)
	 * @param  boolean $p_transaction_safe  Encloses all in a single transaction (false by default)
	 * @return boolean true: success, false: error(s)
	 */
	function query_batch( $abort_on_error = true, $p_transaction_safe = false) {
		return $this->_db->query_batch( $abort_on_error, $p_transaction_safe );
	}
	/** for compatibility only: */
	function queryBatch( $abort_on_error = true, $p_transaction_safe = false) {
		return $this->query_batch( $abort_on_error, $p_transaction_safe );
	}
	/**
	* @return int The number of affected rows in the previous operation
	*/
	function getAffectedRows( ) {
		if ( is_callable( array( $this->_db, 'getAffectedRows' ) ) ) {
			$affected	=	$this->_db->getAffectedRows();
		} else {
			$affected	=	mysql_affected_rows( $this->_db->_resource );
		}
		return $affected;
	}
	/**
	* Returns the number of rows returned from the most recent query.
	* 
	* @return int
	*/
	function getNumRows( $cur = null ) {
		return $this->_db->getNumRows( $cur );
	}
	/**
	 * Explain of SQL
	 * 
	 * @return string
	 */
	function explain( ) {
		return $this->_db->explain();
	}
	/**
	* This method loads the first field of the first row returned by the query.
	*
	* @return The value returned in the query or null if the query failed.
	*/
	function loadResult( ) {
		return $this->_db->loadResult();
	}
	function & _nullToArray( &$resultArray ) {
		if ( $resultArray === null ) {		// mambo strangeness
			$resultArray	=	array();
		}
		return $resultArray;
	}
	/**
	* Load an array of single field results into an array
	*/
	function loadResultArray( $numinarray = 0 ) {
		return $this->_nullToArray( $this->_db->loadResultArray( $numinarray ) );
	}
	/**
	* Fetch a result row as an associative array
	*
	* @return array
	*/
	function loadAssoc( ) {
		if ( is_callable( array( $this->_db, 'loadAssoc' ) ) ) {
			return $this->_db->loadAssoc( );
		} else {
			// new independant efficient implementation:
			if ( ! ( $cur = $this->query() ) ) {
				$result	=	null;
			} else {
				$result		=	mysql_fetch_assoc( $cur );
				if ( ! $result ) {
					$result	=	null;
				}
				mysql_free_result( $cur );
				return $result;
			}
		}
	}
	/**
	* Load a assoc list of database rows
	* 
	* @param string The field name of a primary key
	* @return array If <var>key</var> is empty as sequential list of returned records.
	*/
	function loadAssocList( $key = null ) {
		global $_VERSION;
		if ( ( $key == '' ) || ( $_VERSION->PRODUCT == "Joomla!" || $_VERSION->PRODUCT == "Accessible Joomla!" ) ) {
			return $this->_nullToArray( $this->_db->loadAssocList( $key ) );
		} else {
			// mambo 4.5.2 - 4.6.2 has a bug in key:
			if ( ! ( $cur = $this->_db->query() ) ) {
				return null;
			}
			$array = array();
			while ( $row = mysql_fetch_assoc( $cur ) ) {
				if ( $key ) {
					$array[$row[$key]]	=	$row;		//  $row->key is not an object, but an array
				} else {
					$array[]			=	$row;
				}
			}
			mysql_free_result( $cur );
			return $array;
		}
	}
	/**
	* This global function loads the first row of a query into an object
	*
	* If an object is passed to this function, the returned row is bound to the existing elements of <var>object</var>.
	* If <var>object</var> has a value of null, then all of the returned query fields returned in the object.
	* @param string The SQL query
	* @param object The address of variable
	*/
	function loadObject( &$object ) {
		return $this->_db->loadObject( $object );
	}
	/**
	* Load a list of database objects
	* @param string The field name of a primary key
	* @return array If <var>key</var> is empty as sequential list of returned records.
	* If <var>key</var> is not empty then the returned array is indexed by the value
	* the database key.  Returns <var>null</var> if the query fails.
	*/
	function loadObjectList( $key = null ) {
		return $this->_nullToArray( $this->_db->loadObjectList( $key ) );
	}
	/**
	* @return The first row of the query.
	*/
	function loadRow( ) {
		return $this->_db->loadRow();
	}
	/**
	* Load a list of database rows (numeric column indexing)
	* @param string The field name of a primary key
	* @return array If <var>key</var> is empty as sequential list of returned records.
	* If <var>key</var> is not empty then the returned array is indexed by the value
	* the database key.  Returns <var>null</var> if the query fails.
	*/
	function loadRowList( $key = null ) {
		return $this->_nullToArray( $this->_db->loadRowList( $key ) );
	}
	/**
	* Insert an object into database
	*
	* @param string   $table This is expected to be a valid (and safe!) table name
	* @param stdClass $object
	* @param string   $keyName
	* @param boolean  $verbose
	* @param boolean  TRUE if insert succeeded, FALSE when error
	*/
	function insertObject( $table, &$object, $keyName = NULL, $verbose=false ) {
		return $this->_db->insertObject( $table, $object, $keyName, $verbose );
	}
	/**
	* Updates an object into a database
	*
	* @param  string   $table        This is expected to be a valid (and safe!) table name
	* @param  stdClass $object
	* @param  string   $keyName
	* @param  boolean  $updateNulls
	* @return mixed    A database resource if successful, FALSE if not.
	*/
	function updateObject( $table, &$object, $keyName, $updateNulls=true ) {
		// return $this->_db->updateObject( $table, $object, $keyName, $updateNulls );
		$fmtsql = "UPDATE $table SET %s WHERE %s";
		$tmp = array();
		foreach (get_object_vars( $object ) as $k => $v) {
			if( is_array($v) or is_object($v) or $k[0] == '_' ) { // internal or NA field
				continue;
			}
			if( $k == $keyName ) { // PK not to be updated
				$where = $keyName . '=' . $this->Quote( $v );
				continue;
			}
			if ($v === NULL && !$updateNulls) {
				continue;
			}
			if( $v === NULL ) {
				$val = "NULL";			// this case was missing in Mambo
			} elseif( $v == '' ) {
				$val = "''";
			} else {
				$val = $this->Quote( $v );
			}
			$tmp[] = $this->NameQuote( $k ) . '=' . $val;
		}
		$this->setQuery( sprintf( $fmtsql, implode( ",", $tmp ) , $where ) );
		return $this->query();
	}

	/**
	* Returns the formatted standard error message of SQL
	* @param  boolean $showSQL  If TRUE, displays the last SQL statement sent to the database
	* @return string  A standised error message
	*/
	function stderr( $showSQL = false ) {
		return $this->_db->stderr( $showSQL );
	}
	/**
	* Returns the insert_id() from Mysql
	*
	* @return int
	*/
	function insertid( ) {
		return $this->_db->insertid();
	}
	/**
	* Returns the version of MySQL
	*
	* @return string
	*/
	function getVersion( ) {
		return $this->_db->getVersion();
	}
	/**
	* @return array A list of all the tables in the database
	*/
	function getTableList( ) {
		return $this->_db->getTableList();
	}
	/**
	 * @param array A list of valid (and safe!) table names
	 * @return array A list the create SQL for the tables
	 */
	function getTableCreate( $tables ) {
		return $this->_db->getTableCreate( $tables );
	}
	/**
	 * @param array A list of valid (and safe!) table names
	 * @return array An array of fields by table
	 */
	function getTableFields( $tables ) {
		return $this->_db->getTableFields( $tables );
	}
	/**
	* Fudge method for ADOdb compatibility
	*/
	function GenID( $foo1=null, $foo2=null ) {
		return '0';
	}
	/**
	 * Checks if database's collation is case-INsensitive
	 * WARNING: individual table's fields might have a different collation
	 *
	 * @return boolean  TRUE if case INsensitive
	 */
	function isDbCollationCaseInsensitive( ) {
		static $result = null;

		if ( $result === null ) {
			$query = "SELECT IF('a'='A', 1, 0);";
			$this->setQuery( $query );
			$result		=	$this->loadResult();
		}
		return ( $result == 1 );
	}
}	// class CBdatabase

// ----- NO MORE CLASSES OR FUNCTIONS PASSED THIS POINT -----
// Post class declaration initialisations
// some version of PHP don't allow the instantiation of classes
// before they are defined

global $_CB_database;
global $database;
/** @global CBdatabase $_CB_Database */
$_CB_database	=	new CBdatabase( $database );

?>
