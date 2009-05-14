<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $mainframe, $mosConfig_sitename;
$mosConfig_sitename =  $mainframe->getCfg('sitename');

class moscbeFieldValues extends JTable {
	var $fieldvalueid=null;
	var $fieldid=null;
	var $fieldtitle=null;
	var $sys=null;


	/**
    * @param database A database connector object
    */

	function __construct(&$db) {
		$this->moscbeFieldValues($db);
	}

	function moscbeFieldValues( &$db ) {
		//$this->JTable( '#__cbe_fields', 'fieldid', $db );
		parent::__construct( '#__cbe_field_values', 'fieldvalueid', $db );
	} //end func

	function store( $fieldvalueid, $updateNulls=false) {
		global $acl, $migrate, $database, $_POST;

		if($_POST['fieldvalueid']==null || $_POST['fieldvalueid']=='' || !isset($_POST['fieldvalueid'])) $this->fieldvalueid =0;
		else $this->tabid=$_POST['fieldvalueid'];
		$sql="Select count(*) from #__cbe_field_values where fieldvalueid = '".  $this->fieldvalueid."'";
		$database->SetQuery($sql);
		$total = $database->LoadResult();
		if( $total > 0 ) {
			// existing record
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );

		} else {
			// new record
			$this->fieldvalueid = null;
			$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
		}
		if( !$ret) {
			$this->_error = get_class( $this )."::store failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {

			return true;
		}
	}


} //end class
?>