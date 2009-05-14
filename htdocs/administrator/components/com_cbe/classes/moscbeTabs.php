<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $mainframe, $mosConfig_sitename;
$mosConfig_sitename =  $mainframe->getCfg('sitename');

//class moscbeTabs extends JTable {
class moscbeTabs extends JTable {
	var $tabid=null;
	var $title=null;
	var $tabname=null;
	var $description=null;
	var $ordering=null;
	var $plugin=null;
	var $width=null;
	var $enabled=null;
	var $sys=null;
	var $enhanced_params=null;
	var $aclgroups=null;
	var $nested=null;
	var $nest_id=null;
	var $is_nest=null;
	var $q_me=null;
	var $q_you=null;
	var $q_bind=null;

	/**
    * @param database A database connector object
    */

	function __construct(&$db) {
		$this->moscbeTabs($db);
	}

	function moscbeTabs( &$db ) {

		//$this->JTable( '#__cbe_tabs', 'tabid', $db );
		parent::__construct( '#__cbe_tabs', 'tabid', $db );

	} //end func

	function store( $tabid=0, $updateNulls=false) {
		global $acl, $migrate, $database, $_POST;
		$acl =& JFactory::getACL();
		$database = &JFactory::getDBO();
		
		if($_POST['tabid']==null || $_POST['tabid']=='' || !isset($_POST['tabid'])) $this->tabid=$tabid;
		else $this->tabid=$_POST['tabid'];
		$sql="Select count(*) from #__cbe_tabs where tabid = '".  $this->tabid."'";
		$database->SetQuery($sql);
		$total = $database->LoadResult();
		if( $total > 0 ) {
			// existing record
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );

		} else {
			$sql="Select max(ordering) from #__cbe_tabs";
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