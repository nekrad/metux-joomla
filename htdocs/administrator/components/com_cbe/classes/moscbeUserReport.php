<?php

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $mainframe, $mosConfig_sitename;
$mosConfig_sitename =  $mainframe->getCfg('sitename');

class moscbeUserReport extends JTable {
	var $reportid=null;
	var $reporteduser=null;
	var $reportedbyuser=null;
	var $reportedondate=null;
	var $reportexplaination=null;


	/**
    * @param database A database connector object
    */

	function __construct(&$db) {
		$this->moscbeUserReport($db);
	}

	function moscbeUserReport( &$db ) {
		//$this->JTable( '#__cbe_fields', 'fieldid', $db );
		parent::__construct( '#__cbe_userreports', 'reportid', $db );
	} //end func


} //end class
?>