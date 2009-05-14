<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $mainframe, $mosConfig_sitename;
$mosConfig_sitename =  $mainframe->getCfg('sitename');

//class moscbeFields extends JTable {
class moscbeFields extends JTable {
	var $fieldid=null;
	var $name=null;
	var $title=null;
	var $type=null;
	var $information=null;
	var $infotag=null;
	var $maxlength=null;
	var $size=null;
	var $required=null;
	var $tabid=null;
	var $ordering=null;
	var $cols=null;
	var $rows=null;
	var $value=null;
	var $default=null;
	var $sys=null;
	var $delete_able=null;
	var $profile=null;
	var $published=null;
	var $readonly=null;
	var $registration=null;
	var $table=null;


	/**
    * @param database A database connector object
    */

	function __construct(&$db) {
		$this->moscbeFields($db);
	}

	function moscbeFields( &$db ) {
		//$this->JTable( '#__cbe_fields', 'fieldid', $db );
		parent::__construct( '#__cbe_fields', 'fieldid', $db );
	} //end func

	function store( $fieldid=0, $updateNulls=false) {
		global $acl, $migrate, $database, $_POST;
		$acl =& JFactory::getACL();
		$database = &JFactory::getDBO();

		if($_POST['fieldid']==null || $_POST['fieldid']=='' || !isset($_POST['fieldid'])) {
			$this->fieldid =$fieldid;
		} else {
			$this->fieldid=$_POST['fieldid'];
		}
		$sql="Select count(*) from #__cbe_fields where fieldid = '".  $this->fieldid."'";
		$database->SetQuery($sql);
		$total = $database->LoadResult();

			SWITCH($this->type) {
				CASE 'date':
				CASE 'birthdate':
				CASE 'dateselect':
				CASE 'dateselectrange':
				 $cType='DATE';
				break;
				CASE 'editorta':
				CASE 'textarea':
				CASE 'multiselect':
				CASE 'multicheckbox':
				 $cType='MEDIUMTEXT';
				break;
				CASE 'checkbox':
				 $cType='TINYINT';
				break;
				CASE 'numericfloat':
				 $cType='FLOAT';
				break;
				CASE 'numericint':
				 $cType='INT';
				break;
				default:
				 $cType='VARCHAR(255)';
				break;

			}


		if( $total > 0 ) {
			// existing record

			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );

		} else {
			// new record
			$sql="SELECT COUNT(*) FROM #__cbe_fields WHERE name='".$this->name."'";
			$database = &JFactory::getDBO();

			$database->SetQuery($sql);
			if($database->LoadResult() > 0) {
				$this->_error = "The field name ".$this->name." is already in use!";
				return false;
			}
			$sql="Select max(ordering) from #__cbe_fields WHERE tabid=".$this->tabid;
			$database->SetQuery($sql);
			$max = $database->LoadResult();
			$this->ordering=$max+1;
			$this->fieldid = null;
			//$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
			$ret2 = $this->createColumn('#__cbe',$this->name,$cType);
			if ($ret2) {
				$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
				if (!$ret) {
					return false;
				}
			} else {
				return false;
			}
		}
		if( !$ret ) {
			$this->_error = get_class( $this )."::store failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}

	function createColumn( $table, $column, $type) {
		global $acl, $migrate;
		$database = &JFactory::getDBO();
		$ck_obj = NULL;
		$sql="SELECT * FROM `".$table."` LIMIT 1";
		$database->setQuery($sql);
		if ($database->loadObject($ck_obj) && array_key_exists($column, $ck_obj)) {
			return $this->updateColumn( $table, $column, $type);
		} else {
			$sql="ALTER TABLE `$table` ADD `$column` $type";
			$database->SetQuery($sql);
			$ret = $database->query();
			if( !$ret ) {
				$this->_error .= get_class( $this )."::createColumn failed <br />" . $this->_db->getErrorMsg();
				return false;
			} else {
				return true;
			}
		}
	}
	function deleteColumn( $table, $column) {
		global $acl, $migrate, $database;
		$database = &JFactory::getDBO();

		$sql="ALTER TABLE `$table` DROP `$column`";
		$database->SetQuery($sql);
		$ret = $database->LoadResult();
		if( !$ret ) {
			$this->_error .= get_class( $this )."::deleteColumn failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}
	function updateColumn( $table, $column, $type) {
		global $acl, $migrate, $database;
		$database = &JFactory::getDBO();

		$sql="ALTER TABLE `".$table."` CHANGE `".$column."` `".$column."` ".$type;
		$database->setQuery($sql);
		$ret = $database->query();
		if( !$ret ) {
			$this->_error .= get_class( $this )."::updateColumn failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}
} //end class
?>