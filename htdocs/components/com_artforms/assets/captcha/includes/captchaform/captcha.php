<?php
/**
* @version $Id: captcha.php v.2.1b7 2007-11-23 02:17:46Z GMT-3 $
* @package ArtForms 2.1b7 - CaptchaForm Bridge
* @subpackage ArtForms Component
* @copyright Copyright (C) 2007 InterJoomla. All rights reserved.
* @Original Capctha Code: captchaform
* @Original Capctha Copyright (C) 2007 scripts.titude.nl - NLD
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2, see LICENSE.txt
* This version may have been modified pursuant to the
* GNU General Public License, and as distributed it includes or is derivative
* of works licensed under the GNU General Public License or other free
* or open source software licenses.
* See COPYRIGHT.txt for copyright notices and details.
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

function doCaptchaFormAF(){

  require( AFPATH_ADM_SITE.'config.artforms.php' );

  if (!session_id()) {
    @session_start();
  }

  if (version_compare(phpversion(), "5.0.0", ">=")) {
    require_once(AFPATH_ASSETS_SITE.'captcha'.DS.'includes'.DS.'captchaform'.DS.'captchaform5.php');
  } else {
    require_once(AFPATH_ASSETS_SITE.'captcha'.DS.'includes'.DS.'captchaform'.DS.'captchaform4.php');
  }

  $captcha= new captchaform();
  $html = '';
  $lang =& JFactory::getLanguage();
  $mp3lang = $lang->getbackwardLang();

  $html .= '<div class="clear"></div>
            <div align="center" style="margin:0 auto 0 auto;padding:0;">
              <div id="imgcode" style="margin:0 auto 0 auto;width:200px;height:100%;border:1px solid #ddd;">
                <div style="padding:8px 8px 8px 8px;float:left;">';
  if (($afcfg_captcha_mode=='image') || ($afcfg_captcha_mode=='both')) {
    $html .= '<img src="'.AFPATH_WEB_CAPTCHA_SITE.'includes/captchaform/imgcaptcha.php?nc='.date('YmHis').'" width="'.$captcha->width.'" height="'.$captcha->height.'" border="0" name="imgcf" alt="'.JText::_( 'ARTF_CAPTCHA_TITLE' ).'" /><br />';
  }

$html .= '<br />'.JText::_( 'ARTF_CAPTCHA_TITLE' ).': <input type="text" name="'.$captcha->formkey.'" size="6" />
          </div>
          <div style="padding:14px 2px 0px 2px;float:left;width:30px;height:100%;">';

  if (($afcfg_captcha_mode=='audio') || ($afcfg_captcha_mode=='both')) {
    $html .= '<div style="padding:3px 3px 3px 3px;float:left;">
                <a href="javascript:captchaMp3();void(0)" onmouseover="window.status=\'\'; return true;"><img src="'.AFPATH_WEB_CAPTCHA_SITE.'images/speaker.png" alt="SP" title="" border="0"></a>
              </div>';
  }

  if (($afcfg_captcha_mode=='image') || ($afcfg_captcha_mode=='both')) {
     $html .= '<div style="padding:3px 3px 3px 3px;float:left;">
                 <a href="javascript:captchaNew();void(0)" onmouseover="window.status=\'\'; return true;"><img src="'.AFPATH_WEB_CAPTCHA_SITE.'images/reload.png" alt="RL" title="" border="0"></a>
               </div>';
  }

  $html .= '</div>
         <div class="clear"></div>
      </div>
    </div>
    <div class="clear"></div>';

  $html .= '
  <script type="text/javascript"><!--
  ';

  if (($afcfg_captcha_mode=='audio') || ($afcfg_captcha_mode=='both')) {
    $html .= 'var mp3cf = "'.AFPATH_WEB_CAPTCHA_SITE.'includes/captchaform/mp3captcha.php?l='.$mp3lang.'";
  	      var msie = navigator.userAgent.toLowerCase();
	      msie = (msie.indexOf("msie") > -1) ? true : false;
	      function captchaMp3() {
		   var d = new Date();
		   if (document.all && msie) {
			embed = document.createElement("bgsound");
			embed.setAttribute("src", mp3cf + "&nc=" + d.getTime());
			document.getElementsByTagName("body")[0].appendChild(embed);
		   } else if (document.getElementById) {
			var mp3player = \'<embed src="\'+mp3cf + "&nc=" + d.getTime()+\'"\';
			mp3player += \' hidden="true" type="audio/x-mpeg" autostart="true" />\';
			document.getElementById(\'codecf\').innerHTML = mp3player;
			return true;
		   }
	      }';
  }

  if (($afcfg_captcha_mode=='image') || ($afcfg_captcha_mode=='both')) {
    $html .= 'var imgcf = "'.AFPATH_WEB_CAPTCHA_SITE.'includes/captchaform/imgcaptcha.php";
	      function captchaNew() {
		 if (document.images[\'imgcf\']) {
			var d = new Date();
			document.images[\'imgcf\'].src = imgcf + "?nc=" + d.getTime();
		 }
	      }';
  }

  $html .= '//--></script>';

  if (($afcfg_captcha_mode=='audio') || ($afcfg_captcha_mode=='both')) {
    $html .= '<div id="codecf" style="position: absolute; width: 1px; height: 1px; visible: hidden;">
              </div>';
  }

  return $html;

}


?>
