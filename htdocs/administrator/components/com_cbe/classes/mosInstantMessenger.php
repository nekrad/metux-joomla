<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $mainframe, $mosConfig_sitename;
$mosConfig_sitename =  $mainframe->getCfg('sitename');

class mosInstantMessenger {

	var $id=null; 		//Users ID
	var $IMType=null; 		//Instant Messenger Type (MSNM,AIM,YIM,etc)
	var $IMHandle=null;		//User Name, Number or Handle used by IM System


	/**
    * @param database A database connector object
    */

	function moscbe( &$db ) {

		$this->JTable( '#__cbe', 'id', $db );

	} //end func

	function storeExtras( $id, $updateNulls=false) {
		global $acl, $migrate, $database;

		$sql="Select count(*) from #__cbe where id = '". $_POST['id']."'";
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