<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

$elementTable = $this->actContentObject->getTable();
$field =  $this->field;
foreach ($elementTable->Fields as $fld) {
	if ($fld->Name ==$this->field ){
		echo $fld->originalValue;
	}
}
