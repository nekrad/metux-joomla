<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $mainframe, $mosConfig_sitename;
$mosConfig_sitename =  $mainframe->getCfg('sitename');

//class moscbeSearchField extends JTable {
class moscbeSearchField extends JTable {
	var $id=null;
	var $fieldid=null;
	var $range=null;
	var $simple=null;
	var $advanced=null;
	var $ordering=null;
	var $module=null;

	/**
    * @param database A database connector object
    */

	function __construct(&$db) {
		$this->moscbeSearchField($db);
	}

	function moscbeSearchField( &$db ) {
		//$this->JTable( '#__cbe_fields', 'fieldid', $db );
		parent::__construct( '#__cbe_searchmanager', 'fieldid', $db );
	} //end func
	
	function store( $id, $updateNulls=false) {
		global $acl, $migrate, $database, $_POST;

		if($_POST['fieldid']==null || $_POST['fieldid']=='' || !isset($_POST['fieldid'])) $this->fieldid =0;
		else $this->tabid=$_POST['id'];
		$sql="Select count(*) from #__cbe_searchmanager where fieldid = '".  $this->fieldid."'";
		$database->SetQuery($sql);
		$total = $database->LoadResult();
		if( $total > 0 ) {
			// existing record
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );

		} else {
			$sql="Select max(ordering) from #__cbe_searchmanager";
			$database->SetQuery($sql);
			$max = $database->LoadResult();
			$this->ordering=$max+1;
			// new record
			$this->tabid = null;
			$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );

		}
		if( !$ret ) {
			$this->_error = get_class( $this )."::store failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}
} //end class
?>