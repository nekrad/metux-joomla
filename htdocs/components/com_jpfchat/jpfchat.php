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
define( 'COM_PATH', dirname(__FILE__) );
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.$option.DS.'tables');

$user =& JFactory::getUser();
$name = $user->name;
$uname = $user->username;

$db =& JFactory::getDBO();
$query = "SELECT * FROM #__jpfchat";
$db->setQuery($query);
$rows = $db->loadObjectList();

foreach ($rows as $row) {
    if ($row->name == 'name_or_uname') {
         $displayChoice = $row->value;
    } elseif ($row->name == 'channels') {
         $jPFCparams['channels']  = explode(",", $row->value);
    } elseif ($row->name == 'shownotice') {
         $jPFCparams['shownotice'] = (int)$row->value;
    } else {
         if ($row->type == 'B') {
                if ($row->value == '1')     $jPFCparams[$row->name] = true;
                if ($row->value == '0')     $jPFCparams[$row->name] = false;
         } elseif (($row->type == 'T')&&(is_intval($row->value))) {
                    $jPFCparams[$row->name] = (int)$row->value;
         } else {
                $jPFCparams[$row->name] = $row->value;
         }
    }
}

if (strlen($uname)>0) {
   if (false === strpos("*".$jPFCparams['isadmin'], $uname)) {
        $jPFCparams['isadmin'] = false;
   } else {
        $jPFCparams['isadmin'] = true;
   }
   $iconv_string = (($displayChoice == "Name") ? $name : $uname );
} else {
   $jPFCparams['isadmin'] = false;
   $iconv_string = 'guest'.rand(100,999);
}

if (function_exists('iconv'))  {
        $jPFCparams['nick'] = iconv("ISO-8859-1", "UTF-8", $iconv_string );
} elseif (function_exists('libiconv'))  {
        $jPFCparams['nick'] = libiconv("ISO-8859-1", "UTF-8", $iconv_string);
} else {
   $jPFCparams['nick'] = $iconv_string;
}

$jPFCparams['data_private_path']  = COM_PATH. "/pfc/data/private";
$jPFCparams['data_public_path']   = COM_PATH. "/pfc/data/public";
$jPFCparams['client_script_path'] = COM_PATH. "/jpfchat.php";
$jPFCparams['server_script_path'] = COM_PATH. "/jpfchat.php";
$jPFCparams['data_public_url']    = JURI::base(). "/components/com_jpfchat/pfc/data/public";

require_once COM_PATH. "/pfc/src/phpfreechat.class.php";

$chat = new phpFreeChat($jPFCparams);
$chat->printChat();

//*** NOTE: YOU MAY NOT REMOVE OR COMMENT OUT THE FOLLOWING LINE WITHOUT EXPRESS WRITTEN CONSENT FROM VIZIMETRICS, INC REPRESENTATIVES!
echo "<br /><p align='center'>Powered by <a href='http://www.jpfchat.com'>jPFChat</a> for Joomla 1.5.x!</p>";
//************************************************************************************************************

function is_intval($a) {
   return ((string)$a === (string)(int)$a);
}
?>
