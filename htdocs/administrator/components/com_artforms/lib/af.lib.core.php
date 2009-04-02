<?php
/**
* @version $Id: af.lib.core.php v.2.1b7 2007-12-16 16:44:59Z GMT-3 $
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

/* Defined Paths Start*/

/* Getting Live Site */
$live_site = $mainframe->isAdmin() ? $mainframe->getSiteURL() : JURI::base();

/* Absolute FrontEnd Paths */
DEFINE('AFPATH_SITE', JPATH_SITE.DS.'components'.DS.'com_artforms'.DS );
DEFINE('AFPATH_ASSETS_SITE', JPATH_SITE.DS.'components'.DS.'com_artforms'.DS.'assets'.DS );
DEFINE('AFPATH_ASTERISKS_SITE', JPATH_SITE.DS.'images'.DS.'artforms'.DS.'asterisks'.DS );
DEFINE('AFPATH_ATTACHS_SITE', JPATH_SITE.DS.'images'.DS.'artforms'.DS.'attachedfiles'.DS );
DEFINE('AFPATH_JPLUGINS_SITE',  JPATH_SITE.DS.'plugins'.DS );

/* FrontEnd URL Live Site Paths */
DEFINE('AFPATH_WEB_SITE', $live_site.'components/com_artforms/' );
DEFINE('AFPATH_WEB_IMG_SITE', AFPATH_WEB_SITE.'assets/images/' );
DEFINE('AFPATH_WEB_CAPTCHA_SITE', AFPATH_WEB_SITE.'assets/captcha/' );
DEFINE('AFPATH_WEB_CSS_SITE', AFPATH_WEB_SITE.'assets/css/' );
DEFINE('AFPATH_WEB_JS_SITE', AFPATH_WEB_SITE.'assets/js/' );
DEFINE('AFPATH_WEB_ASTERISKS_SITE', $live_site.'images/artforms/asterisks/' );
DEFINE('AFPATH_WEB_ATTACHS_SITE', $live_site.'images/artforms/attachedfiles/' );
DEFINE('AFPATH_WEB_JPLUGINS_SITE', $live_site.'plugins/' );

/* Absolute BackEnd Paths */
DEFINE('AFPATH_ADM_SITE', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_artforms'.DS );
DEFINE('AFPATH_LIB_ADM_SITE', AFPATH_ADM_SITE.'lib'.DS );
DEFINE('AFPATH_DOC_ADM_SITE', AFPATH_ADM_SITE.'assets'.DS.'docs'.DS );
DEFINE('AFPATH_TUTORIAL_ADM_SITE', AFPATH_ADM_SITE.'assets'.DS.'tutorial'.DS );

/* BackEnd URL Live Site Paths */
DEFINE('AFPATH_WEB_ADM_SITE', $live_site.'administrator/components/com_artforms/' );
DEFINE('AFPATH_WEB_IMG_ADM_SITE', AFPATH_WEB_ADM_SITE.'assets/images/' );
DEFINE('AFPATH_WEB_CSS_ADM_SITE', AFPATH_WEB_ADM_SITE.'assets/css/' );
DEFINE('AFPATH_WEB_LIB_ADM_SITE', AFPATH_WEB_ADM_SITE.'lib'.DS );

/* Defined Paths End */


function afLoadLib( $libname ) {

      $path = AFPATH_LIB_ADM_SITE.'af.lib.'.$libname.'.php';
      if (file_exists( $path )) {
         require ( $path );
      }
		
}


function afGetItemid( $id ) {

      $db =& JFactory::getDBO();
      $query = "SELECT a.id"
             . "\n FROM #__menu AS a "
             . "\n WHERE a.published = 1"
             . "\n AND a.link = 'index.php?option=com_artforms&formid=".(int)$id."' "
             . "\n AND a.type = 'url' OR "
             . "\n a.link = 'index.php?option=com_artforms&formid=".(int)$id."' "
             . "\n AND a.type = 'artforms_form_link'"
             ;
      $db->setQuery( $query );
      $result = $db->loadResult();

      return $result;

}

   
function showErrRep() {

      require ( AFPATH_ADM_SITE.'config.artforms.php');
      if ($afcfg_allowerr_rep == '1'){
         return error_reporting(E_ALL);
      } else {
         return error_reporting(0);
      }

}


function afFooter($reqver=1) {

    if($reqver!=0)require( AFPATH_SITE.'version.php' );

    $html = '<div class="clear"></div>
             <div style="text-align:center;">
                <div style="font:normal normal bold small normal arial;">
                   <a href="http://joomlacode.org/gf/project/jartforms/" target="_blank">
                      <img style="margin-bottom:-4px;" border="0" src="'.AFPATH_WEB_IMG_SITE.'minilogo.png" alt="ArtForms" title="" />
                      v. '.afVersion().'
                   </a>
                </div>
                <div style="font:normal normal normal xx-small normal Arial;">
                   New Development by <a href="http://www.interjoomla.com.ar/" target="_blank">InterJoomla</a>
                </div>
             </div>
             <div class="clear"></div>';

    if( JArrayHelper::getValue( $_GET, 'no_affoo', '0' ) != '1' ){
       return $html;
    }
    
}


function afLoadSectionTitle( $title, $image, $notaflogo=0, $otherimgpath='' ) {

   global $mosConfig_live_site;

   if ($notaflogo != 0 ){
      $classtitle = 'aftitle2';
   } else {
      $classtitle = 'aftitle';
      global $mainframe;
      $html  = '<style type="text/css">';
      $html .= '.icon-48-'.$image.' {
	     background-image: url('.AFPATH_WEB_IMG_ADM_SITE.$image.'.png);
             background-repeat: no-repeat;
          }';
      $html .= '</style>';
      $mainframe->addCustomHeadTag( $html );
   }
   
   $afmsg = stripslashes( strval( JArrayHelper::getValue( $_REQUEST, 'afmsg', '' ) ) );
   $afimg = JArrayHelper::getValue( $_REQUEST, 'afimg', '' );
   $imgpath = AFPATH_WEB_IMG_ADM_SITE;
   $titleimgpath = $imgpath;
   
   if( $otherimgpath ) $titleimgpath = $otherimgpath;

   $afimg = $afimg ? 'success.png' : 'error.png';
   echo '
   <div class="'.$classtitle.'">
      <div class="aftitlebox" style="background: #f4f4f4 url('.$titleimgpath.$image.'.png) left center no-repeat;" valign="middle">
         '.$title.'
      </div>';
      if ( $afmsg && $notaflogo == 0 ){
         echo '<div class="aferror"><img src="'.$imgpath.$afimg.'"> '.$afmsg.'</div>';
      }
   echo '
   </div>';

}


function afLoadTitleError( $frontend=0 ) {

   $html = '';
   $afmsg = stripslashes( strval( JArrayHelper::getValue( $_REQUEST, 'afmsg', '' ) ) );
   $afimg = JArrayHelper::getValue( $_REQUEST, 'afimg', '' );

   if( $frontend == 0 ){
      $imgpath = AFPATH_WEB_IMG_ADM_SITE;
   } else {
      $imgpath = AFPATH_WEB_IMG_SITE;
   }
   
   $image = $afimg ? 'success.png' : 'error.png';

   if ( $afmsg ){

      $html .= '<div class="clear"></div>
                  <div class="aferrorm">
                  <img src="'.$imgpath.$image.'">'.' '.$afmsg.'
               </div>
               <div class="clear"></div>';

   }

   return $html;

}


function afPanelButton( $task, $image, $text ) {

     $task  = 'index.php?option=com_artforms&task='.$task;
     $image = $image.'.png';
     ?>
     <div class="pbtn">
        <div class="icon">
           <a href="<?php echo $task;?>">
              <img src="<?php echo AFPATH_WEB_IMG_ADM_SITE.$image;?>" alt="<?php echo $text;?>">
              <span><?php echo $text;?></span>
           </a>
        </div>
     </div>
     <?php
}


?>
