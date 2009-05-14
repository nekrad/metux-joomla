<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $mainframe, $mosConfig_sitename;
$mosConfig_sitename =  $mainframe->getCfg('sitename');

class moscbeCBSObj extends JTable {

	var $id=null;
	var $uid=null;
	var $mod_cbe_search=null;
	var $mod_cbe_search1=null;
	var $listid=null;
	var $do_cbquery=null;
	var $cbquery=null;
	var $geo_distance=null;
	var $onlinenow=null;
	var $picture=null;
	var $added10=null;
	var $online10=null;
	var $q_time=null;
	var $_loadstate=null;
	var $_sessiontimeout = 5; // min
	/**
    * @param database A database connector object
    */

	function __construct(&$db) {
		$this->moscbeCBSObj($db);
	}

	function moscbeCBSObj( &$db ) {
		//$this->JTable( '#__cbe_fields', 'fieldid', $db );
		parent::__construct( '#__cbe_cbsearch_ses', 'id', $db );
	} //end func

	// function delete(id) defined in joomla database.php
	function bind( $array, $ignore='' ) {
		//echo "in moscbecbsobj->bind";
		if (!is_array( $array )) {
			$this->_error = strtolower(get_class( $this ))."::bind failed.";
			//die( "falsch");
			return false;
		} else {
			//die("richtig");
			//JArrayHelper::toObject( $array, $this);
			foreach ($array as $k=>$v)
				$this->$k = $v;
			//return mosBindArrayToObject();
		}
	}

	function check($cbsearchid=null, $searcht=null, $uid) {
		$check_clean = $this->cleanUp();
		$this->_loadstate = false;
		$this->load($cbsearchid, $searcht);
		//die(print_r($this));
		if (!empty($this->id) && ($this->uid == $uid)) {
			$this->_loadstate = true;
		}
		return $this;
	}

	function store( $uid, $cbsearchid=null, $updateNulls=false) {
		global $acl, $migrate, $database;

		$database =& JFactory::getDBO();
		$check_clean = $this->cleanUp();
		$this->uid = $uid;
		
		if(empty($cbsearchid)) { 
			$this->id = 0;
		} else {
			$this->id = $cbsearchid;
		}
		$sql="Select count(*) from #__cbe_cbsearch_ses where id = '".$this->id."'";
		$database->SetQuery($sql);
		$total = $database->LoadResult();
		if( $total > 0 ) {
			// existing record
			$this->q_time = time();
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );
		} else {
			// new record
			$database->setQuery("SELECT max(id) FROM #__cbe_cbsearch_ses");
			$max_count = $database->LoadResult();
			if (empty($max_count)) {
				$this->id = 0;
			} else {
				$this->id = $max_count + 1;
			}
			$this->q_time = time();
			$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
		}
		if( !$ret ) {
			$this->_error = get_class( $this )."::store failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}

	function load( $oid=null, $searcht=null ) {
		// $check_clean = $this->cleanUp();
		
		$k = $this->_tbl_key;
		if ($oid !== null) {
			$this->$k = $oid;
		}
		$oid = $this->$k;
		if ($oid === null) {
			return false;
		}
		//Note: Prior to PHP 4.2.0, Uninitialized class variables will not be reported by get_class_vars().
		/*
		$class_vars = $this->getPublicProperties();
		foreach ($class_vars as $name => $value) {
			if ($name != $k) {
				$this->$name = $value;
			}
		}
		*/
		$class_vars = get_class_vars(get_class($this));
		//die("class_vars: " . print_r($class_vars));
		foreach ($class_vars as $name => $value) {
			if (($name != $k) and ($name != "_db") and ($name != "_tbl") and ($name != "_tbl_key")) {
				$this->$name = $value;
			}
		}
		$this->reset();
		//die(print_r($this));
		$query = "SELECT *"
		. "\n FROM $this->_tbl"
		. "\n WHERE $this->_tbl_key = '$oid' AND q_time='".$searcht."'"
		;
		$this->_db->setQuery( $query );
		//$erg = $this->_db->loadObject( $this );
		$erg = $this->_db->loadObject();
		//die(print_r($erg));
		//$erg1 = JArrayHelper::toObject( $erg, $this);
		
		foreach ($erg as $k=>$v)
			$this->$k = $v;
		//return $erg;
	}
	
	// remove outdated search sessions	
	function cleanUp() {
		global $database;
		
		$database =& JFactory::getDBO();
		$act_time = time();
		$clean_time = $act_time - ( $this->_sessiontimeout * 60 );
		$database->setQuery("DELETE FROM #__cbe_cbsearch_ses WHERE q_time < '".$clean_time."'");
		if (!$database->query()) {
			$this->_error = get_class( $this )."::cleanUp failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}
	
	function reset( $value=null ) {
		$keys = $this->getProperties();
		//$keys = $this->getPublicProperties();
		foreach ($keys as $key=>$val) {
			$this->$key = $value;
		}
	}

} //end class
?>