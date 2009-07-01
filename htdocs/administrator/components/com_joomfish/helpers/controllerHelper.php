<?php

defined( 'JPATH_BASE' ) or die( 'Direct Access to this location is not allowed.' );


class  JoomfishControllerHelper  {
	
	/**
	 * Sets up ContentElement Cache - mainly used for data to determine primary key id for tablenames ( and for
	 * future use to allow tables to be dropped from translation even if contentelements are installed )
	 */
	function _setupContentElementCache()
	{
		$db =& JFactory::getDBO();
		// Make usre table exists otherwise create it.
		$db->setQuery( "CREATE TABLE IF NOT EXISTS `#__jf_tableinfo` ( `id` int(11) NOT NULL auto_increment, `joomlatablename` varchar(100) NOT NULL default '',  `tablepkID`  varchar(100) NOT NULL default '', PRIMARY KEY (`id`)) TYPE=MyISAM");
		$db->query();
		// clear out existing data
		$db->setQuery( "DELETE FROM `#__jf_tableinfo`");
		$db->query();
		$joomfishManager =& JoomFishManager::getInstance();
		$contentElements = $joomfishManager->getContentElements(true);
		$sql = "INSERT INTO `#__jf_tableinfo` (joomlatablename,tablepkID) VALUES ";
		$firstTime = true;
		foreach ($contentElements as $contentElement){
			$tablename = $contentElement->getTableName();
			$refId = $contentElement->getReferenceID();
			$sql .= $firstTime?"":",";
			$sql .= " ('".$tablename."', '".$refId."')";
			$firstTime = false;
		}

		$db->setQuery( $sql);
		$db->query();

	}

	
	/**
	 * Testing state of the system bot
	 *
	 */
	function _testSystemBotState()
	{
		$db =& JFactory::getDBO();
		$botState = false;

		$db->setQuery( "SELECT * FROM #__plugins WHERE element='jfdatabase'");
		$db->query();
		$plugin = $db->loadObject();
		if ($plugin != null && $plugin->published == "1") {
			$botState = $plugin->id;
		}
		return $botState;
	}
	
}