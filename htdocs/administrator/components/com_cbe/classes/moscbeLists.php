<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $mainframe, $mosConfig_sitename;
$mosConfig_sitename =  $mainframe->getCfg('sitename');

//class moscbeLists extends JTable {
class moscbeLists extends JTable {
	var $listid=null;
	var $title=null;
	var $description=null;
	var $published=null;
	var $default=null;
	var $usergroupids=null;
	var $aclgroup=null;
	var $sortfields=null;
	var $filterfields=null;
	var $filteronline=null;
	var $ordering=null;
	var $col1title=null;
	var $col1enabled=null;
	var $col1fields=null;
	var $col1captions=null;
	var $col2title=null;
	var $col2enabled=null;
	var $col2fields=null;
	var $col2captions=null;
	var $col3title=null;
	var $col3enabled=null;
	var $col3fields=null;
	var $col3captions=null;
	var $col4title=null;
	var $col4enabled=null;
	var $col4fields=null;
	var $col4captions=null;



	/**
    * @param database A database connector object
    */

	function __construct(&$db) {
		$this->moscbeLists($db);
	}

	function moscbeLists( &$db ) {
		//$this->JTable( '#__cbe_fields', 'fieldid', $db );
		parent::__construct( '#__cbe_lists', 'listid', $db );
	} //end func

	function store( $listid=0, $updateNulls=false) {
		global $acl, $migrate, $database, $_POST;
		$acl =& JFactory::getACL();
		$database = &JFactory::getDBO();

		if($_POST['listid']==null || $_POST['listid']=='' || !isset($_POST['listid'])) $this->listid =$listid;
		else $this->listid=$_POST['listid'];
		$sql="Select count(*) from #__cbe_lists where listid = '".  $this->listid."'";
		$database->SetQuery($sql);
		$total = $database->LoadResult();
		if($this->default==1) {
			$sql="UPDATE #__cbe_lists SET `default` = 0";
			$database->SetQuery($sql);
			$database->LoadResult();
		}
		if( $total > 0 ) {
			// existing record
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );

		} else {
			// new record
			$sql="Select max(ordering) from #__cbe_lists";
			$database->SetQuery($sql);
			$max = $database->LoadResult();
			$this->ordering=$max+1;
			$this->listid = null;
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