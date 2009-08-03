<?php
/**
 * A Who's online jPFChat module
 * 
 * @version $Id: mod_jpfchatonline.php
 * @author Tim Milo
 * @link http://www.jPFChat.com
 * @copyright (C) 2008 ViziMetrics, Inc. - All rights reserved.
 * @license GNU/GPL License
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class jPFChatList {

        function showit(&$params){

                $channel      = $params->get( 'channel','' );
                $timeout      = $params->get( 'timeout','20' );
                $display_what = $params->get( 'display_what', '' );

                $db =& JFactory::getDBO();
                $db->setQuery("SELECT value FROM #__jpfchat WHERE name = 'serverid'");
                $serverid = $db->loadResult();

                require_once "./components/com_jpfchat/pfc/src/pfcinfo.class.php";

                $info  = new pfcInfo($serverid);
                
                $room = '('.$channel.')';
                if ( ($channel =='') OR ($channel =='NULL') ) {
                        $channel =  NULL;
                        $room ='Online';
                }

                $users = $info->getOnlineNick($channel, $timeout);
                $nb_users = count($users);

                echo '<div>';
                if ($nb_users < 1) {
                    echo "<p>No users online</p>";
                } else {
                    if ($display_what == '1'){
                        if ($nb_users = 1) {
                                echo "<p><strong>1</strong> User ".$room."</p>";
                        } else {
                                echo "<p><strong>".$nb_users."</strong> Users ".$room;
                        }
                   } else {
                        echo "<ul>";
                        foreach($users as $u) {
                           echo "<li>".$u."</li>";
                        }
                        echo "</ul>";
                   }
                }
                echo "</div>";
        }
}

echo jPFChatList::showit($params);

?>
