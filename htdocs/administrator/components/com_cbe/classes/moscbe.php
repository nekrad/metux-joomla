<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $mainframe, $mosConfig_sitename;
$mosConfig_sitename =  $mainframe->getCfg('sitename');

//class moscbe extends JTable {
class moscbe extends JTable {
	var $id=null;
	var $user_id=null;
	var $avatar=null;
	var $avatarapproved=null;
	var $approved=null;
	var $confirmed=null;
	var $hits=null;


	/**
    * @param database A database connector object
    */

	function __construct(&$db) {
		$this->moscbe($db);
	}

	function moscbe( &$db ) {
		//$this->JTable( '#__cbe_fields', 'fieldid', $db );
		parent::__construct( '#__cbe', 'id', $db );
	} //end func

	function storeExtras( $id, $updateNulls=false) {
		global $acl, $migrate, $database, $_POST;

		if($_POST['id']==null || $_POST['id']=='' || !isset($_POST['id'])) $this->id =0;
		else $this->id=$_POST['id'];
		$sql="Select count(*) from #__cbe where id = '".  $this->id."'";
		$database->SetQuery($sql);
		$total = $database->LoadResult();
		if( $total > 0 ) {
			// existing record
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );

		} else {
			// new record
			$sql="Select max(id) from #__users";
			$database->SetQuery($sql);
			$last_id = $database->LoadResult();
			$this->id = $last_id;
			$this->user_id = $last_id;
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