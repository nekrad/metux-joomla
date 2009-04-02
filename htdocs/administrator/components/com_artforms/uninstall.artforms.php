<?php
/**
* @version $Id: uninstall.artforms.php v.2.1b7 2007-12-08 16:44:59Z GMT-3 $
* @package ArtForms 2.1b7
* @subpackage ArtForms Component
* @copyright Copyright (C) 2005 Andreas Duswald
* @copyright Copyright (C) 2007 InterJoomla. All rights reserved.
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2, see LICENSE.txt
* This version may have been modified pursuant to the
* GNU General Public License, and as distributed it includes or is derivative
* of works licensed under the GNU General Public License or other free
* or open source software licenses.
* See COPYRIGHT.txt for copyright notices and details.
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

function com_uninstall() {

  $db =& JFactory::getDBO();
  $lang =& JFactory::getLanguage();
  $check_lang = $lang->getBackwardLang();

  $droptable1 = "DROP TABLE IF EXISTS #__artforms";
  $droptable2 = "DROP TABLE IF EXISTS #__artforms_inbox";
  $droptable3 = "DROP TABLE IF EXISTS #__artforms_items";
  $db->setQuery($droptable1);
  $db->query();
  $db->setQuery($droptable2);
  $db->query();
  $db->setQuery($droptable3);
  $db->query();

  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast01.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast02.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast03.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast04.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast05.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast06.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast07.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast08.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast09.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast10.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast11.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast12.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast13.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast14.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast15.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast16.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast17.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast18.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast19.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast20.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast21.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast22.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast23.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast24.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast25.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast26.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast27.png');
  unlink(JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS.'ast28.png');
  rmdir (JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS);
  rmdir (JPATH_SITE.DS.'images'.DS.'artforms'.DS.'attachedfiles'.DS);
  rmdir (JPATH_SITE.DS.'images'.DS.'artforms'.DS);

  if($check_lang == 'spanish') {
     echo "Desinstalado con éxito. Gracias por usar ArtForms.";
  } else {
     echo "Uninstalled successful. Thank you for using ArtForms.";
  }
}

?>
