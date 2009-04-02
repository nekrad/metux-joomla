<?php
/**
* @version $Id: captcha.php v.2.1b7 2007-11-23 02:17:46Z GMT-3 $
* @package ArtForms 2.1b7 - Alikon Mod Captcha
* @subpackage ArtForms Component
* @based on version 0.3.0.1 05/09/06 alikonweb capctha bot
* @copyright Copyright (C) 2005-2006 AlikonWeb
* @copyright Copyright (C) 2007 InterJoomla. All rights reserved.
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2, see LICENSE.txt
* This version may have been modified pursuant to the
* GNU General Public License, and as distributed it includes or is derivative
* of works licensed under the GNU General Public License or other free
* or open source software licenses.
* See COPYRIGHT.txt for copyright notices and details.
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

class alikoncaptcha {

   var $codelength = '';


   function doVerifyAF($pasw){

      session_start();
      $digit = $_SESSION['digit'];

      session_destroy();

      $digit = strtolower($digit);
      $pasw = strtolower($pasw);
 
      if  ( $digit != $pasw ){
         return false;
      }else{
         return true;
      }
 
   }


   function captchacode() {

      $chars = "abcdefghijkmnpqrstuvwxyz";
      $chars .= "ABCDEFGHIJKMNPQRSTUVWXYZ";
      $chars .= "23456789";

      $fullchar='';
      for ($i = 0; $i < $this->codelength; $i++) {
         $fullchar .= $chars[rand(0, strlen($chars) - 1)];
      }
      
      session_start();
      $_SESSION['digit'] = $fullchar;

   }


   function image() {

      alikoncaptcha::captchacode();

      $rndstring = $_SESSION['digit'] ;
      
      $font='../../fonts/Arial.ttf';

      /* output type */
      # $output_type='jpeg';
      $output_type='png';

      /* font size range, angle range, character padding */
      $min_font_size = 14;
      $max_font_size = 20;
      $min_angle = -20;
      $max_angle = 20;
      $char_padding = 1;

      /* initialize variables  */
      $turing_string='';
      $data = array();
      $image_width = $image_height = 0;

      /* build the data array of the characters, size, placement, etc. */
      for($i=0; $i<$this->codelength; $i++) {

         $char = substr($rndstring, $i, 1);

         $size = mt_rand($min_font_size, $max_font_size);
         $angle = mt_rand($min_angle, $max_angle);

         $bbox = ImageTTFBBox( $size, $angle, $font, $char );

         $char_width = max($bbox[2],$bbox[4]) - min($bbox[0],$bbox[6]);
         $char_height = max($bbox[1],$bbox[3]) - min($bbox[7],$bbox[5]);

         $image_width += $char_width + $char_padding;
         $image_height = max($image_height, $char_height);

         $data[] = array(
            'char'        => $char,
            'size'        => $size,
            'angle'       => $angle,
            'height'      => $char_height,
            'width'       => $char_width,
         );
      }

      /* calculate the final image size, adding some padding */
      $x_padding = 12;

      $image_width += ($x_padding * 1);
      $image_height = ($image_height * 1.5) + 2;

      /* build the image, and allocte the colors  */
      $im = ImageCreate($image_width, $image_height);

      $r = 51 * mt_rand(4,5);
      $g = 51 * mt_rand(4,5);
      $b = 51 * mt_rand(4,5);
      $color_bg = ImageColorAllocate($im,  $r,  $g,  $b );

      $r = 51 * mt_rand(3,4);
      $g = 51 * mt_rand(3,4);
      $b = 51 * mt_rand(3,4);
      $color_line0 = ImageColorAllocate($im,  $r,  $g,  $b );

      $r = 51 * mt_rand(3,4);
      $g = 51 * mt_rand(3,4);
      $b = 51 * mt_rand(3,4);
      $color_line1    = ImageColorAllocate($im,  $r,  $g,  $b );

      $r = 51 * mt_rand(1,2);
      $g = 51 * mt_rand(1,2);
      $b = 51 * mt_rand(1,2);
      $color_text = ImageColorAllocate($im,  $r,  $g,  $b );

      $color_border = ImageColorAllocate($im,   0,   0,   0 );

      /* make the random background lines */
      for($l=0; $l<10; $l++) {

         $c = 'color_line' . ($l%2);
         $lx = mt_rand(0,$image_width+$image_height);
         $lw = mt_rand(0,3);
         if ($lx > $image_width) {
            $lx -= $image_width;
            ImageFilledRectangle($im, 0, $lx, $image_width-1, $lx+$lw, $$c );
         } else {
            ImageFilledRectangle($im, $lx, 0, $lx+$lw, $image_height-1, $$c );
         }

      }

      /* output each character */
      $pos_x = $x_padding + ($char_padding / 2);
      foreach($data as $d) {

         $pos_y = ( ( $image_height + $d['height'] ) / 2 );
         ImageTTFText($im, $d['size'], $d['angle'], $pos_x, $pos_y, $color_text, $font, $d['char'] );
         $pos_x += $d['width'] + $char_padding;
         $generatecode=$d['char'];

      }

      /* a nice border */
      ImageRectangle($im, 0, 0, $image_width-1, $image_height-1, $color_border);

      /* write it */
      header('Content-type: image/png');
      ImagePNG($im);

      /* free memory */
      ImageDEstroy($im);

   }


   function mp3captcha() {

      session_start();
      $rndstring = $_SESSION['digit'];
      
      $file_array = array();
      $char = array();
      $lang = $_GET['l'];

      for($i=0; $i<$this->codelength; $i++) {
         $char[$i] = substr($rndstring, $i, 1);
         $file_array[$i]= '../../audio/'.$lang.'/'.strtolower($char[$i]).'.mp3';
      }

      $out = '';
      $len = 0;
      $audioname="AudioForm.mp3";

      foreach ($file_array as $file){
         $fh = fopen($file, 'rb');
         $size = filesize($file);
         $out .= fread($fh, $size);

         $len += $size;
         fclose($fh);
      }

      header("Content-Type: audio/mpeg");
      header("Content-Disposition: attachment; filename=$audioname;");
      header("Content-Transfer-Encoding: binary");
      header("Content-Length: ".$len);
      echo $out;

   }


   function doViewAF(){

      $lang =& JFactory::getLanguage();
      $getlang = $lang->getBackwardLang();

      require( AFPATH_ADM_SITE.'config.artforms.php' );
      $html = '';

      $html .= '<div class="clear"></div>
                <div align="center" style="margin:0;padding:0;">
                  <div style="width:260px;">
                    <table border="0" align="center"><tr><td><fieldset><legend>'.JText::_( 'ARTF_CAPTCHA_TITLE' ).'</legend>
                      <div style="border:1px solid #ddd;padding:8px 8px 8px 8px;float:left;">';

      if (($afcfg_captcha_mode=='audio') || ($afcfg_captcha_mode=='both')) {
        $html .= '<div style="padding:8px 8px 8px 8px;float:left;">
                     <object type="application/x-shockwave-flash" data="'.AFPATH_WEB_CAPTCHA_SITE.'swf/dp.swf?son='.AFPATH_WEB_CAPTCHA_SITE.'includes/alikon/playcode.php?l='.$mosConfig_lang.'" width="65" height="30"><param name="movie" value="'.AFPATH_WEB_CAPTCHA_SITE.'includes/alikon/dp.swf?son='.AFPATH_WEB_CAPTCHA_SITE.'includes/alikon/playcode.php?l='.$getlang.'" /></object>
                  </div>';
      }

      if (($afcfg_captcha_mode=='image') || ($afcfg_captcha_mode=='both')) {
        $html .= '<div style="padding:8px 8px 8px 8px;float:left;"
                     <img src="'.AFPATH_WEB_CAPTCHA_SITE.'includes/alikon/showcode.php" alt="'.JText::_( 'ARTF_CAPTCHA_IMGALT' ).'" />
                  </div>';
      }

      $html .= '</div>
                <div style="border:1px solid #ddd;padding:8px 8px 8px 8px;clear:left;">
                  '.JText::_( 'ARTF_CAPTCHA_WRITECODE' ).'
                  <input class="inputbox" type="text" name="password3" size="'.$this->codelength.'"  maxlength="'.$this->codelength.'" value="" />
                </div>
                </fieldset></td></tr></table>
                </div>
                </div>';

      return $html;

   }


}

?>
