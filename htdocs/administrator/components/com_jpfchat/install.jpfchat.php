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

defined ( '_JEXEC' ) or die ( 'Restricted Access' );

function com_install() {
    global $mainframe;

    $version = new JVersion();
    if ( (real)$version->RELEASE < 1.5 ) {
        echo '<h1 style="color: red;">This jPFChat component will only work on Joomla version 1.5 or later!</h1>';
        return false;
    } else {

        $serverid = md5(__FILE__);
        $db =& JFactory::getDBO();

        $query = "SELECT id FROM #__components WHERE admin_menu_link = 'option=com_jpfchat'";
        $db->setQuery($query);
        $id = $db->loadResult();

        $query = "UPDATE #__components SET admin_menu_img  = '../administrator/components/com_jpfchat/images/jpfchat_menu.png' WHERE id='$id'";
        $db->setQuery($query);
        $db->query();

        $query = "UPDATE #__jpfchat SET value = '" . $serverid . "' WHERE name = 'serverid'";
        $db->setQuery($query);
        $db->query();
        
        $path = $mainframe->getSiteURL()."index.php?option=com_jpfchat";
        $db->setQuery("UPDATE #__jpfchat SET value = '$path' WHERE name='server_script_url'");
        $db->query();
    }
}
?>
