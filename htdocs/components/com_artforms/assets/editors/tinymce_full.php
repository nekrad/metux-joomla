<?php
/**
* @version $Id: tinymce_full.php v.2.1b7 2007-08-31 16:44:59Z GMT-3 $
* @package ArtForms 2.1b7
* @subpackage ArtForms Component
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
            disk_cache : true,
            directionality: "'.$txtdir.'",
	    debug : false,
            plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,flash,searchreplace,print,contextmenu",
            theme_advanced_buttons1_add_before : "",
            theme_advanced_buttons1_add : "fontselect,fontsizeselect,separator,forecolor,backcolor,separator,printseparator,emotions",
            theme_advanced_buttons2_add : "separator,insertdate,inserttime",
            theme_advanced_buttons2_add_before: "save,separator,cut,copy,paste,separator,search,replace",
            theme_advanced_buttons3_add_before : "tablecontrols,separator",
            theme_advanced_buttons3_add : "iespell,flash,separator,preview,zoom",
            theme_advanced_disable : "styleselect,formatselect,help",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_path_location : "bottom",
            plugin_insertdate_dateFormat : "%Y-%m-%d",
            plugin_insertdate_timeFormat : "%H:%M:%S",
            extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
            external_link_list_url : "example_data/example_link_list.js",
            external_image_list_url : "example_data/example_image_list.js",
            flash_external_list_url : "example_data/example_flash_list.js"});
         </script>';
   $mainframe->addCustomHeadTag( $html );
}
?>
