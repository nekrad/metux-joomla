<?php
defined( '_JEXEC' ) or die( 'Restricted Access' );
class TableReview extends JTable {

	var $id = null;
	var $name = null;
	var $tab = null;
	var $seq = null;
	var $prompt = null;
	var $value = null;
	var $description = null;
	var $type = null;

	function __construct(&$db)  {
	   parent::__construct ('#__jpfchat', 'id', $db);
	}
}
?>
