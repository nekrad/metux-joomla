<?php
/**
* @version $Id: fckeditor_silver.php v.2.1b7 2007-08-31 16:44:59Z GMT-3 $
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

  if(file_exists( AFPATH_JPLUGINS_SITE.DS.'editors'.DS.'fckeditor'.DS.'fckeditor_php4.php' )){

   if ( version_compare( phpversion(), '5', '<' ) ){
	include_once( AFPATH_JPLUGINS_SITE.DS.'editors'.DS.'fckeditor'.DS.'fckeditor_php4.php' ) ;
   } else {
	include_once( AFPATH_JPLUGINS_SITE.DS.'editors'.DS.'fckeditor'.DS.'fckeditor_php5.php' ) ;
   }
   if(file_exists( AFPATH_JPLUGINS_SITE.DS.'editors'.DS.'fckeditor'.DS.'editor'.DS.'lang'.DS.$editorlang.'.js' )){
      $lang = $editorlang;
   } else {
      $lang = 'en';
   }
   $toolbar = 'Compact';
           
   $html = '<script language="javascript" type="text/javascript" src="'.AFPATH_WEB_JPLUGINS_SITE.'editors/fckeditor/fckeditor.js"></script>
            <script type="text/javascript">
            var oFCKeditor = new FCKeditor(\''.$hiddenField.'\');
		oFCKeditor.BasePath = "/mambots/editors/fckeditor/" ;
		oFCKeditor.Config["CustomConfigurationsPath"] = "'.AFPATH_WEB_JPLUGINS_SITE.'editors/fckconfigjoomla.js";
		oFCKeditor.ToolbarSet = "'.$toolbar.'" ;
		oFCKeditor.Config[\'AutoDetectLanguage\'] = "false" ;
                oFCKeditor.Config[\'DefaultLanguage\'] = "'.$lang.'" ;
		oFCKeditor.Config[\'UseBROnCarriageReturn\'] = "false" ;
		oFCKeditor.Config[\'EditorAreaCSS\'] = "'.AFPATH_WEB_JPLUGINS_SITE.'editors/fckeditor/editor/css/fck_editorarea.css";
		oFCKeditor.Config[\'ContentLangDirection\'] = "'.$txtdir.'" ;
		oFCKeditor.Config[\'SkinPath\'] = oFCKeditor.BasePath + \'editor/skins/\' + \'silver\' + \'/\' ;
		oFCKeditor.Width = "555px" ;
		oFCKeditor.Height = "250px" ;
		oFCKeditor.ReplaceTextarea() ;

		function InsertHTML(field, value) {
		// Get the editor instance that we want to interact with.
		var oEditor = FCKeditorAPI.GetInstance(field) ;
                }
            </script>';
   return $html;
  } else {
   return;
  }
  
}
?>
