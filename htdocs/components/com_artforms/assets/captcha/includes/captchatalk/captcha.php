<?php
/**
* @version $Id: captcha.php v.2.1b7 2007-11-23 02:17:46Z GMT-3 $
* @package ArtForms 2.1b7 - CaptchaTalk Bridge
* @subpackage ArtForms Component
* @copyright Copyright (C) 2007 InterJoomla. All rights reserved.
* @Original Capctha Code: captchatalk
* @Original Capctha Copyright (C) 2007 scripts.titude.nl - NLD
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2, see LICENSE.txt
* This version may have been modified pursuant to the
* GNU General Public License, and as distributed it includes or is derivative
* of works licensed under the GNU General Public License or other free
* or open source software licenses.
* See COPYRIGHT.txt for copyright notices and details.
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

function doCaptchaTalkAF(){

  if (!session_id()) {
    @session_start();
  }

  if (version_compare(phpversion(), "5.0.0", ">=")) {
    include_once(AFPATH_ASSETS_SITE.'captcha'.DS.'includes'.DS.'captchatalk'.DS.'swfcaptcha5.php');
  } else {
    include_once(AFPATH_ASSETS_SITE.'captcha'.DS.'includes'.DS.'captchatalk'.DS.'swfcaptcha4.php');
  }
  require( AFPATH_ADM_SITE.'config.artforms.php' );

  $swfc = new swfcaptcha();
  $swfc->bgcolors = array('000000');
  $swfc->swf_url = AFPATH_WEB_CAPTCHA_SITE.'includes/captchatalk/swfmovie.php';
  $swfc->swf_transparent = false;
  $swfc->post_captcha = "captcha";

  $swfhtml = $swfc->swfhtml();

  $html = '<div class="clear"></div>
           <div align="center" style="margin:0;padding:0;">
              <div id="imgcode" style="width:260px;">
                <div style="border:1px solid #ddd;padding:8px 8px 8px 8px;float:left;width:100%;">
                  '.$swfhtml.'
                </div>
                <div style="border:1px solid #ddd;padding:8px 8px 8px 8px;float:left;width:100%;">
                  '.JText::_( 'ARTF_CAPTCHA_TITLE' ).':
                  <input type="text" name="captcha" size="'.$afcfg_captcha_length.'"  maxlength="'.$afcfg_captcha_length.'" />
                </div>
              </div>
           </div>
           <div class="clear"></div>';

  return $html;
  
}


?>
