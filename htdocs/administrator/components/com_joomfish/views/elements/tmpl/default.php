<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
$user =& JFactory::getUser();
$db =& JFactory::getDBO();
?>
<?php if ($this->showMessage) : ?>
<?php echo $this->loadTemplate('message'); ?>
<?php endif; ?>
<?php echo $this->loadTemplate('list'); ?>