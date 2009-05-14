<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $mainframe, $mosConfig_sitename;
$mosConfig_sitename =  $mainframe->getCfg('sitename');

class moscbeGeoObj extends JTable {

	var $_id=null;
	var $uid=null;
	var $GeoLat=null;
	var $GeoLng=null;
	var $GeoAddr=null;
	var $Geo_street=null;
	var $Geo_postcode=null;
	var $Geo_city=null;
	var $Geo_state=null;
	var $Geo_country=null;
	var $GeoText=null;
	var $GeoAccCode=null;
	var $GeoAllowShow=null;
	var $_Geocoder_doUpdate=null;
	/**
    * @param database A database connector object
    */

	function __construct(&$database) {
		$this->moscbeGeoObj($database);
	}

	function moscbeGeoObj( &$db ) {
		//$this->JTable( '#__cbe_fields', 'fieldid', $db );
		parent::__construct( '#__cbe_geodata', 'uid', $db );
	} //end func


	// function delete defined in joomla database.php

	function bindme( $arr, $ignore='' ) {
		if (!is_array( $arr )) {
			$this->_error = strtolower(get_class( $this ))."::bind failed.";
			return false;
		} else {
			$this->_Geocoder_doUpdate = intval($_POST['GeoCoder_doUpdate']);
			if (empty($_POST['GeoAllowShow']))
				$this->GeoAllowShow = 0;

			// parent-class
			return $this->bind($arr);
		}
	}

	function check() {
		if ($this->_Geocoder_doUpdate == 0) {
			return 0;
		}
		if ($this->_Geocoder_doUpdate == 1) {
			return 1;
		}
		if ($this->_Geocoder_doUpdate == 3) {
			return 3;
		}
	}

	function store( $uid, $updateNulls=false) {
		global $acl, $migrate, $_POST;
		$database = &JFactory::getDBO();

		if($_POST['id']==null || $_POST['id']=='' || !isset($_POST['id'])) $this->uid =0;
		else $this->uid=$_POST['id'];
		$sql="Select count(*) from #__cbe_geodata where uid = '".  $this->uid."'";
		$database->setQuery($sql);
		$total = $database->loadResult();

		if ($this->check() == 1) {
			if( $total > 0 ) {
				// existing record
				$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );
			} else {
				// new record
				$this->uid = $uid;
				$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
			}

			if( !$ret ) {
				$this->_error = get_class( $this )."::store failed <br />" . $this->_db->getErrorMsg();
				return false;
			} else {
				// cb_geolatitude cb_geolongitude passover Fields to GoogleMaps in #__cbe
				// update functions must be insterted here.
				return true;
			}
		} else if ($this->check() == 3 && $total > 0) {
			$ret = $this->delete($uid);
			if( !$ret ) {
				$this->_error = get_class( $this )."::delete failed <br />" . $this->_db->getErrorMsg();
				return false;
			} else {
				return true;
			}
		} else if ($this->check() == 0) {
			return true;
		} else {
			$this->_error = get_class( $this )."::Operation failed <br /> Undefined condition::";
			return false;
		}
	}
} //end class
?>