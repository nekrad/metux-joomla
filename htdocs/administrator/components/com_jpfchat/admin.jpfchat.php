<?php
/**
 * jPFChat15 - A joomla 1.5.x chatroom component
 *
 * @version $Id: jPFChat.php
 * @author Tim Milo
 * @link http://www.jPFChat.com
 * @copyright (C) 2008 ViziMetrics, Inc - All rights reserved.
 * @license GNU/GPL License
 */

defined( '_JEXEC' ) or die( 'Restricted Access' );
require_once( JApplicationHelper::getPath( 'admin_html' ) );
JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');

define ( 'COM_PATH', JPATH_ROOT . '/components/com_jpfchat' );
define ( 'jPFC_VERSION', '1.0.1');

switch ($task) {
       case "save":
                $newValues = JRequest::getVar( 'newValues', '', 'POST');
                saveParams ( $option, $newValues );
                break;
       default:
                showConf( $option );
                break;
}

function showConf ($option) {

     $db =& JFactory::getDBO();
     $query = "SELECT * FROM #__jpfchat WHERE tab>0 ORDER BY tab,seq";
     $db->setQuery($query);
     $rows = $db->loadObjectList();

     jPFChatView::showjPFChat( $option, $rows );
}

function saveParams ( $option , $newValues ) {
     global $mainframe;

     $db =& JFactory::getDBO();
     $query = "SELECT * FROM #__jpfchat";
     $db->setQuery($query);
     $rows = $db->loadObjectList();

     foreach ($rows as $row) {
         if ($row->name == 'serverid') {
              $serverid = $row->value;
         } else {
              if ($row->type == 'T') {
                   if (is_intval2($row->value) !== is_intval2($newValues[$row->name])) {
                          $newValues[$row->name] = $row->value;
                   }
              }
              $query = "UPDATE #__jpfchat SET value ='".$newValues[$row->name]."' WHERE name ='".$row->name."'";
              $db->setQuery($query);
              $db->query();
         }
     }

     require_once ( COM_PATH . '/pfc/src/pfcinfo.class.php');
     $info = new pfcInfo($serverid);
     $xmsg = ($info->rehash() ? "Configuration cache was reset" : "No cache file to reset");

     $mainframe->redirect( 'index.php?option=' . $option . '&task=showConf', 'Settings Updated! - ' . $xmsg );
}

function is_intval2($a) {
   return ((string)$a === (string)(int)$a);
}

?>
