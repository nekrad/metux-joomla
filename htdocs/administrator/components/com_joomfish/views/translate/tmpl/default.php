<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

if ($this->showMessage) {
	echo $this->loadTemplate('message');
}

if( !isset($this->catid) || $this->catid == "" || $this->language_id==-1) {
	echo $this->loadTemplate('noselection');
} else {
	echo $this->loadTemplate('list');
}
?>