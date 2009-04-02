<?php
/**
* @version $Id: tinymce_simple.php v.2.1b7 2007-08-31 16:44:59Z GMT-3 $
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

function afHtmlEditor( $editorlang, $txtdir, $hiddenField ) {

   global $mainframe;
   if(file_exists(AFPATH_WEB_JPLUGINS_SITE.'editors/tinymce/jscripts/tiny_mce/langs/'.$editorlang.'.js')){
      $lang = $editorlang;
   } else {
      $lang = 'en';
   }

   $html = '<script language="javascript" type="text/javascript" src="'.AFPATH_WEB_JPLUGINS_SITE.'editors/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
         <script language="javascript" type="text/javascript">tinyMCE.init({
            mode : "specific_textareas",
            editor_selector : "inputboxhtml",
            theme : "advanced",
            language : "'.$lang.'",
            directionality: "'.$txtdir.'",
            plugins : "save,advhr,advimage,advlink,media,contextmenu,paste",
            theme_advanced_disable : "styleselect,formatselect,anchor,sub,sup,strikethrough,help",
            theme_advanced_buttons1_add : "cut,copy,paste,separator,fontselect,separator,fontsizeselect",
            theme_advanced_buttons2: "",
            theme_advanced_buttons3: "",
            disk_cache : true,
            debug : false,
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_path_location : "bottom"});
         </script>';
   //$mainframe->addCustomHeadTag( $html );
   return $html;
}
?>
