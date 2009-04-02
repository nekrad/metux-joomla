<?php
/**
* @version $Id: af.lib.attfiles.php v.2.1b7 2007-12-16 16:44:59Z GMT-3 $
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

function afAdmShowAttSelCombo( $switch, $chkarr ) {

   switch ( $switch ) {

      case 'compress':
      echo '<fieldset>
               <legend>'.JText::_( 'ARTF_FORM_ATTCOMPRESS' ).'</legend>';
               afAdmShowAttSel( 'zip', $chkarr );
               afAdmShowAttSel( 'bzip', $chkarr );
               afAdmShowAttSel( 'rar', $chkarr );
               afAdmShowAttSel( 'ace', $chkarr );
               afAdmShowAttSel( 'tar', $chkarr );
               afAdmShowAttSel( 'gzip', $chkarr );
               afAdmShowAttSel( '7z', $chkarr );
      echo '</fieldset>';
      break;
      
      case 'office':
      echo '<fieldset>
               <legend>'.JText::_( 'ARTF_FORM_ATTOPDF' ).'</legend>';
               afAdmShowAttSel( 'doc', $chkarr );
               afAdmShowAttSel( 'wri', $chkarr );
               afAdmShowAttSel( 'xls', $chkarr );
               afAdmShowAttSel( 'ppt', $chkarr );
               afAdmShowAttSel( 'pub', $chkarr );
               afAdmShowAttSel( 'mpp', $chkarr );
               afAdmShowAttSel( 'pdf', $chkarr );
      echo '</fieldset>';
      break;
      
      case 'image':
      echo '<fieldset>
               <legend>'.JText::_( 'ARTF_FORM_ATTIMG' ).'</legend>';
               afAdmShowAttSel( 'bmp', $chkarr );
               afAdmShowAttSel( 'ico', $chkarr );
               afAdmShowAttSel( 'gif', $chkarr );
               afAdmShowAttSel( 'jpg', $chkarr );
               afAdmShowAttSel( 'png', $chkarr );
               afAdmShowAttSel( 'tif', $chkarr );
               afAdmShowAttSel( 'cdr', $chkarr );
               afAdmShowAttSel( 'svg', $chkarr );
               afAdmShowAttSel( 'mac', $chkarr );
               afAdmShowAttSel( 'pic', $chkarr );
               afAdmShowAttSel( 'psd', $chkarr );
               afAdmShowAttSel( 'psp', $chkarr );
               afAdmShowAttSel( 'wbmp', $chkarr );
      echo '</fieldset>';
      break;
      
      case 'misc':
      echo '<fieldset>
               <legend>'.JText::_( 'ARTF_FORM_ATTMISC' ).'</legend>';
               afAdmShowAttSel( 'exe', $chkarr );
               afAdmShowAttSel( 'hqx', $chkarr );
               afAdmShowAttSel( 'swf', $chkarr );
               afAdmShowAttSel( 'fla', $chkarr );
               afAdmShowAttSel( 'txt', $chkarr );
               afAdmShowAttSel( 'css', $chkarr );
               afAdmShowAttSel( 'html', $chkarr );
               afAdmShowAttSel( 'xml', $chkarr );
               afAdmShowAttSel( 'wml', $chkarr );
               afAdmShowAttSel( 'mht', $chkarr );
      echo '</fieldset>';
      break;
      
      case 'audio':
      echo '<fieldset>
               <legend>'.JText::_( 'ARTF_FORM_ATTAUD' ).'</legend>';
               afAdmShowAttSel( 'mp3', $chkarr );
               afAdmShowAttSel( 'm4a', $chkarr );
               afAdmShowAttSel( 'mpega', $chkarr );
               afAdmShowAttSel( 'wma', $chkarr );
               afAdmShowAttSel( 'wav', $chkarr );
               afAdmShowAttSel( 'm3u', $chkarr );
               afAdmShowAttSel( 'pls', $chkarr );
               afAdmShowAttSel( 'ssm', $chkarr );
               afAdmShowAttSel( 'smi', $chkarr );
               afAdmShowAttSel( 'sdp', $chkarr );
               afAdmShowAttSel( 'ogg', $chkarr );
               afAdmShowAttSel( 'mka', $chkarr );
               afAdmShowAttSel( 'mid', $chkarr );
               afAdmShowAttSel( 'aif', $chkarr );
               afAdmShowAttSel( 'rma', $chkarr );
               afAdmShowAttSel( 'ac3', $chkarr );
               afAdmShowAttSel( 'aac', $chkarr );
               afAdmShowAttSel( 'au', $chkarr );
      echo '</fieldset>';
      break;
      
      case 'video':
      echo '<fieldset>
               <legend>'.JText::_( 'ARTF_FORM_ATTVID' ).'</legend>';
               afAdmShowAttSel( 'avi', $chkarr );
               afAdmShowAttSel( 'wmv', $chkarr );
               afAdmShowAttSel( 'asf', $chkarr );
               afAdmShowAttSel( 'ogm', $chkarr );
               afAdmShowAttSel( 'mkv', $chkarr );
               afAdmShowAttSel( 'mpegv', $chkarr );
               afAdmShowAttSel( 'mov', $chkarr );
               afAdmShowAttSel( 'rm', $chkarr );
               afAdmShowAttSel( '3gp', $chkarr );
               afAdmShowAttSel( 'flv', $chkarr );
      echo '</fieldset>';
      break;
      
      case 'p2p':
      echo '<fieldset>
               <legend>'.JText::_( 'ARTF_FORM_ATTP2P' ).'</legend>';
               afAdmShowAttSel( 'emule', $chkarr );
               afAdmShowAttSel( 'torrent', $chkarr );
      echo '</fieldset>';
      break;
      
   }
      
}


function afAdmShowAttSel( $name, $check ) {

   $attfiledata = afMimeTypesAllowed();
   $attfiledata = $attfiledata[$name];
   $checked = '';
   
   if ( in_array( $name, $check ) ) $checked = ' checked';

   $input = '<input type="Checkbox" name="'.$name.'" value="'.$name.'"'.$checked.'><label for="'.$name.'"><span class="MTTips" title="'.$name.' :: '.$attfiledata['ext'].'">'.$name;
   if( $attfiledata['app'] != '' )$input .= ' ('.$attfiledata['app'].')';
   $input .= '</span></label><br />';
   echo $input;
   
}


function afPostAtt2DB() {

   $attfiledata = afMimeTypesAllowed();
   $result = '';
   foreach( $attfiledata as $fileext ){
      if( JArrayHelper::getValue( $_POST, $fileext['fid']) != '' ){
         $result .= JArrayHelper::getValue( $_POST, $fileext['fid'] ).',';
      }
   }
   $result = substr($result,0,-3);
   
   return $result;

}


function afMimeTypesAllowed() {

   $array  = array
             (
                  ('zip') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/zip',
                                                (1) => 'application/x-zip-compressed',
                                                (2) => 'multipart/x-zip',
                                                (3) => 'application/x-compressed'
                                            ),
                                 ('fid') => 'zip',
                                 ('app') => 'WinZip',
                                 ('ext') => '*.zip'
                            ),
                  ('bzip') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/x-bzip',
                                                (1) => 'application/x-bzip2'
                                            ),
                                 ('fid') => 'bzip',
                                 ('app') => '',
                                 ('ext') => '*.bz, *.bz2, *.boz'
                            ),
                  ('rar') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/rar',
                                                (1) => 'application/x-rar-compressed'
                                            ),
                                 ('fid') => 'rar',
                                 ('app') => 'WinRAR',
                                 ('ext') => '*.rar'
                            ),
                  ('ace') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/ace',
                                                (1) => 'application/x-ace-compressed'
                                            ),
                                 ('fid') => 'ace',
                                 ('app') => 'WinACE',
                                 ('ext') => '*.ace'
                            ),
                  ('tar') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/x-tar',
                                                (1) => 'application/x-gzip-compressed',
                                                (2) => 'application/gnutar', //tgz
                                                (3) => 'application/x-compressed', //tgz
                                                (4) => 'application/x-gtar' //gtar
                                            ),
                                 ('fid') => 'tar',
                                 ('app') => '',
                                 ('ext') => '*.tar.gz, *.tgz, *.tar, *.gtar'
                            ),
                  ('gzip') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/x-gzip',
                                                (1) => 'application/x-gzip-compressed',
                                                (2) => 'application/x-compressed'
                                            ),
                                 ('fid') => 'gzip',
                                 ('app') => '',
                                 ('ext') => '*.gz, *.gzip, *.gzip'
                            ),
                  ('7z') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/x-7z-compressed'
                                            ),
                                 ('fid') => '7z',
                                 ('app') => '',
                                 ('ext') => '*.7z'
                            ),
          //Images
                  ('bmp') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'image/bmp',
                                                (1) => 'image/x-windows-bmp'
                                            ),
                                 ('fid') => 'bmp',
                                 ('app') => '',
                                 ('ext') => '*.bmp'
                            ),
                  ('ico') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'image/x-icon'
                                            ),
                                 ('fid') => 'ico',
                                 ('app') => '',
                                 ('ext') => '*.ico'
                            ),
                  ('gif') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'image/gif'
                                            ),
                                 ('fid') => 'gif',
                                 ('app') => '',
                                 ('ext') => '*.gif'
                            ),
                  ('jpg') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'image/jpeg',
                                                (1) => 'image/pjpeg'
                                            ),
                                 ('fid') => 'jpg',
                                 ('app') => '',
                                 ('ext') => '*.jpg, *.jpeg, *.jfif, *.jpe, *.jfif-tbnl'
                            ),
                  ('png') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'image/png',
                                                (1) => 'image/x-png'
                                            ),
                                 ('fid') => 'png',
                                 ('app') => '',
                                 ('ext') => '*.png'
                            ),
                  ('tif') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'image/tif',
                                                (1) => 'image/x-tif'
                                            ),
                                 ('fid') => 'tif',
                                 ('app') => '',
                                 ('ext') => '*.tif, *.tiff'
                            ),
                  ('cdr') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/octet-stream',
                                                (1) => 'application/cdr',
                                                (2) => 'application/coreldraw',
                                                (3) => 'application/x-cdr',
                                                (4) => 'application/x-coreldraw',
                                                (5) => 'image/cdr',
                                                (6) => 'image/x-cdr'
                                            ),
                                 ('fid') => 'cdr',
                                 ('app') => 'CorelDraw',
                                 ('ext') => '*.bmp'
                            ),
                  ('svg') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'image/svg+xml',
                                                (1) => 'image/svg'
                                            ),
                                 ('fid') => 'svg',
                                 ('app') => '',
                                 ('ext') => '*.svg, *.svgz'
                            ),
                  ('mac') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/mac',
                                                (1) => 'application/x-mac',
                                                (2) => 'image/mac',
                                                (3) => 'image/x-mac',
                                                (4) => 'image/x-macpaint',
                                                (5) => 'image/x-quicktime'
                                            ),
                                 ('fid') => 'mac',
                                 ('app') => '',
                                 ('ext') => '*.mac'
                            ),
                  ('pic') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'image/pict'
                                            ),
                                 ('fid') => 'pic',
                                 ('app') => '',
                                 ('ext') => '*.pic, *.pict'
                            ),
                  ('psd') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/octet-stream'
                                            ),
                                 ('fid') => 'psd',
                                 ('app') => 'PhotoShop',
                                 ('ext') => '*.psd'
                            ),
                  ('psp') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/octet-stream'
                                            ),
                                 ('fid') => 'psp',
                                 ('app') => 'Paint Shop Pro',
                                 ('ext') => '*.psp, *.pspimage'
                            ),
                  ('wbmp') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'image/vnd.wap.wbmp'
                                            ),
                                 ('fid') => 'wbmp',
                                 ('app') => 'PM for WAP',
                                 ('ext') => '*.wbmp, *.wbm'
                            ),
            //Audio
                  ('mp3') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'audio/mp3',
                                                (1) => 'audio/mpeg3',
                                                (2) => 'audio/x-mpeg-3',
                                                (3) => 'audio/mpeg',
                                                (4) => 'audio/x-mpeg'
                                            ),
                                 ('fid') => 'mp3',
                                 ('app') => 'MPEG Layer-3',
                                 ('ext') => '*.mp3'
                            ),
                  ('m4a') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'audio/m4a'
                                            ),
                                 ('fid') => 'm4a',
                                 ('app') => '',
                                 ('ext') => '*.m4a'
                            ),
                  ('mpega') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'audio/mpeg',
                                                (1) => 'audio/x-mpeg',
                                                (2) => 'audio/mp1',
                                                (3) => 'audio/mp2'
                                            ),
                                 ('fid') => 'mpega',
                                 ('app') => '',
                                 ('ext') => '*.mpa, *.m1a, *.m2a, *.mp1, *.mp2, *.mpga, *.mpa'
                            ),
                  ('wma') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'audio/x-ms-wma',
                                                (1) => 'audio/x-ms-wmv',
                                                (2) => 'audio/x-ms-wax',
                                                (3) => 'audio/x-ms-wmv'
                                            ),
                                 ('fid') => 'wma',
                                 ('app') => 'Wndows Media Player',
                                 ('ext') => '*.wma, *.wmv, *.wax'
                            ),
                  ('wav') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'audio/wav',
                                                (1) => 'audio/x-wav',
                                                (2) => 'audio/x-pn-wav',
                                                (3) => 'audio/x-pn-windows-acm',
                                                (4) => 'audio/x-pn-windows-pcm'
                                            ),
                                 ('fid') => 'wav',
                                 ('app') => '',
                                 ('ext') => '*.wav'
                            ),
                  ('m3u') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'audio/mpegurl',
                                                (1) => 'audio/x-mpequrl'
                                            ),
                                 ('fid') => 'm3u',
                                 ('app') => '',
                                 ('ext') => '*.m3u'
                            ),
                  ('pls') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'audio/scpls',
                                                (1) => 'audio/x-scpls'
                                            ),
                                 ('fid') => 'pls',
                                 ('app') => '',
                                 ('ext') => '*.pls, *.xpl'
                            ),
                  ('ssm') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/streamingmedia'
                                            ),
                                 ('fid') => 'ssm',
                                 ('app') => '',
                                 ('ext') => '*.ssm'
                            ),
                  ('smi') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/smil'
                                            ),
                                 ('fid') => 'smi',
                                 ('app') => '',
                                 ('ext') => '*.smi, *.smil'
                            ),
                  ('sdp') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/sdp'
                                            ),
                                 ('fid') => 'sdp',
                                 ('app') => '',
                                 ('ext') => '*.sdp'
                            ),
                  ('ogg') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/ogg',
                                                (1) => 'application/x-ogg',
                                                (1) => 'audio/x-ogg'
                                            ),
                                 ('fid') => 'ogg',
                                 ('app') => '',
                                 ('ext') => '*.ogg'
                            ),
                  ('mka') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'audio/x-matroska'
                                            ),
                                 ('fid') => 'mka',
                                 ('app') => 'Matroska Audio',
                                 ('ext') => '*.mka'
                            ),
                  ('mid') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/x-midi',
                                                (1) => 'audio/midi',
                                                (2) => 'audio/x-mid',
                                                (3) => 'audio/x-midi',
                                                (4) => 'music/crescendo',
                                                (5) => 'x-music/x-midi',
                                                (6) => 'application/x-midi',
                                                (7) => 'audio/midi',
                                                (8) => 'audio/x-mid',
                                                (9) => 'audio/x-midi',
                                                (10) => 'music/crescendo',
                                                (11) => 'x-music/x-midi'
                                            ),
                                 ('fid') => 'mid',
                                 ('app') => '',
                                 ('ext') => '*.mid, *.midi, *.kar'
                            ),
                  ('aif') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'audio/aiff',
                                                (1) => 'audio/x-aiff'
                                            ),
                                 ('fid') => 'aif',
                                 ('app') => '',
                                 ('ext') => '*.aif, *.aifc, *.aiff'
                            ),
                  ('rma') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'audio/x-pn-realaudio',
                                                (1) => 'audio/x-realaudio',
                                                (2) => 'audio/x-realaudio-secure'
                                            ),
                                 ('fid') => 'rma',
                                 ('app') => 'RealMedia',
                                 ('ext') => '*.ram, *.ra, *.rms, *.rmm'
                            ),
                  ('ac3') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'audio/ac3'
                                            ),
                                 ('fid') => 'ac3',
                                 ('app') => '',
                                 ('ext') => '*.ac3'
                            ),
                  ('aac') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'audio/aac'
                                            ),
                                 ('fid') => 'aac',
                                 ('app') => '',
                                 ('ext') => '*.aac'
                            ),
                  ('au') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'audio/x-pn-au',
                                                (1) => 'audio/basic'
                                            ),
                                 ('fid') => 'au',
                                 ('app') => '',
                                 ('ext') => '*.au'
                            ),
            //Video
                  ('avi') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'video/avi',
                                                (1) => 'video/msvideo',
                                                (2) => 'video/x-msvideo',
                                                (3) => 'video/avs-video',
                                                (4) => 'application/x-troff-msvideo'
                                            ),
                                 ('fid') => 'avi',
                                 ('app') => 'Video for Windows',
                                 ('ext') => '*.avi, *.XviD, *.DivX'
                            ),
                  ('wmv') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'video/x-ms-wvx',
                                                (1) => 'video/x-ms-wm',
                                                (2) => 'video/x-ms-wmx',
                                                (3) => 'application/x-ms-wmz',
                                                (4) => 'application/x-ms-wmd'
                                            ),
                                 ('fid') => 'wmv',
                                 ('app') => 'Windows Media Player',
                                 ('ext') => '*.wmv, *.wvx, *.wm, *.wmx, *.wmz, *.wmd'
                            ),
                  ('asf') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'video/x-ms-asf',
                                                (1) => 'application/x-mplayer2',
                                                (2) => 'video/x-ms-asf-plugin'
                                            ),
                                 ('fid') => 'asf',
                                 ('app') => 'Windows Media Player',
                                 ('ext') => '*.asf, *.asx'
                            ),
                  ('ogm') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/ogg',
                                                (1) => 'video/x-ogm',
                                                (2) => 'video/x-theora'
                                            ),
                                 ('fid') => 'ogm',
                                 ('app') => '',
                                 ('ext') => '*.ogm'
                            ),
                  ('mkv') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'video/x-matroska'
                                            ),
                                 ('fid') => 'mkv',
                                 ('app') => 'Matroska Video',
                                 ('ext') => '*.mkv'
                            ),
                  ('mpegv') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'video/mpeg',
                                                (1) => 'video/x-mpeg',
                                                (2) => 'video/x-mpeq2a',
                                                (3) => 'video/x-mpeg',
                                                (4) => 'video/x-mpeg',
                                                (5) => 'video/x-mpeg',
                                                (6) => 'video/x-mpeg'
                                            ),
                                 ('fid') => 'mpegv',
                                 ('app') => 'MPEG',
                                 ('ext') => '*.mpg, *.mpeg, *.m1v, *.m2v, *.mp2, *.mp3, *.mpa, *.mpe, *.mp2, *.mpeg2, *.mp4, *.mpeg4'
                            ),
                  ('mov') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'video/quicktime'
                                            ),
                                 ('fid') => 'mov',
                                 ('app') => 'QuickTime',
                                 ('ext') => '*.mov, *.moov, *.qt'
                            ),
                  ('rm') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'video/vnd.rn-realvideo',
                                                (1) => 'application/vnd.rn-realmedia',
                                                (2) => 'application/vnd.rn-realmedia-vbr',
                                                (3) => 'video/vnd.rn-realvideo-secure',
                                                (4) => 'application/vnd.rn-realsystem-rmx'
                                            ),
                                 ('fid') => 'rm',
                                 ('app') => 'RealMedia',
                                 ('ext') => '*.rm, *.rv, *.rms, *.rmx, *.rmvb'
                            ),
                  ('3gp') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'audio/amr',
                                                (1) => 'audio/amr-wb',
                                                (2) => 'audio/amr-encrypted',
                                                (3) => 'audio/3gpp',
                                                (4) => 'audio/3gpp2',
                                                (5) => 'audio/3gpp-encrypted',
                                                (6) => 'audio/x-rn-3gpp-amr',
                                                (7) => 'audio/x-rn-3gpp-amr-wb',
                                                (8) => 'audio/x-rn-3gpp-amr-encrypted',
                                                (9) => 'audio/x-rn-3gpp-amr-wb-encrypted'
                                            ),
                                 ('fid') => '3gp',
                                 ('app') => '',
                                 ('ext') => '*.3gp, *.3g2, *.amr'
                            ),
                  ('flv') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'video/flv',
                                                (1) => 'video/x-flv'
                                            ),
                                 ('fid') => 'flv',
                                 ('app') => 'Flash Video',
                                 ('ext') => '*.flv'
                            ),
            //P2P
                  ('emule') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/octet-stream',
                                            ),
                                 ('fid') => 'emule',
                                 ('app') => '',
                                 ('ext') => '*.emulecollection'
                            ),
                  ('torrent') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/x-bittorrent'
                                            ),
                                 ('fid') => 'torrent',
                                 ('app') => '',
                                 ('ext') => '*.torrent'
                            ),
            //Texto & MS-Office
                  ('txt') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'text/plain',
                                                (1) => 'application/plain',
                                                (2) => 'application/txt'
                                            ),
                                 ('fid') => 'txt',
                                 ('app') => '',
                                 ('ext') => '*.txt, *.text'
                            ),
                  ('doc') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/msword',
                                                (1) => 'application/doc',
                                                (2) => 'appl/text',
                                                (3) => 'application/vnd.msword',
                                                (4) => 'application/vnd.ms-word',
                                                (5) => 'application/winword',
                                                (6) => 'application/word',
                                                (7) => 'application/x-msw6',
                                                (8) => 'application/x-msword'
                                            ),
                                 ('fid') => 'doc',
                                 ('app') => 'MS-Word',
                                 ('ext') => '*.doc, *.docx'
                            ),
                  ('wri') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/mswrite',
                                                (1) => 'application/x-wri'
                                            ),
                                 ('fid') => 'wri',
                                 ('app') => 'MS-Write',
                                 ('ext') => '*.wri'
                            ),
                  ('xls') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/excel',
                                                (1) => 'application/xmsexcel',
                                                (2) => 'application/x-ms-excel',
                                                (3) => 'application/x-excel',
                                                (4) => 'application/xls',
                                                (5) => 'application/x-xls',
                                                (6) => 'application/vnd.ms-excel'
                                            ),
                                 ('fid') => 'xls',
                                 ('app') => 'MS-Excel',
                                 ('ext') => '*.xls, *.csv, *.xlsx'
                            ),
                  ('ppt') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/powerpoint',
                                                (1) => 'application/x-powerpoint',
                                                (2) => 'application/powerpnt',
                                                (3) => 'application/mspowerpoint',
                                                (4) => 'application/x-mspowerpoint',
                                                (5) => 'application/vnd.ms-powerpoint'
                                            ),
                                 ('fid') => 'ppt',
                                 ('app') => 'MS-PowerPoint',
                                 ('ext') => '*.ppt, *.pps'
                            ),
                  ('pub') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/vnd.ms-publisher',
                                                (1) => 'application/x-mspublisher'
                                            ),
                                 ('fid') => 'pub',
                                 ('app') => 'MS-Publisher',
                                 ('ext') => '*.pub'
                            ),
                  ('mpp') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/mpp',
                                                (1) => 'application/vnd.ms-project',
                                                (2) => 'application/msproj',
                                                (3) => 'application/msproject',
                                                (4) => 'application/x-msproject',
                                                (5) => 'application/x-ms-project'
                                            ),
                                 ('fid') => 'mpp',
                                 ('app') => 'MS-Project',
                                 ('ext') => '*.mpp'
                            ),
                  ('pdf') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/pdf',
                                                (1) => 'application/x-pdf',
                                                (2) => 'application/acrobat',
                                                (3) => 'applications/vnd.pdf',
                                                (4) => 'text/pdf',
                                                (5) => 'text/x-pdf'
                                            ),
                                 ('fid') => 'pdf',
                                 ('app') => 'Adobe Acrobat',
                                 ('ext') => '*.pdf'
                            ),
            //Miseláneos
                  ('exe') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/x-sdlc',
                                                (1) => 'application/octet-stream',
                                                (2) => 'application/x-msdownload',
                                                (3) => 'application/exe',
                                                (4) => 'application/x-exe',
                                                (5) => 'application/dos-exe',
                                                (6) => 'vms/exe',
                                                (7) => 'application/x-winexe',
                                                (8) => 'application/msdos-windows',
                                                (9) => 'application/x-msdos-program'
                                            ),
                                 ('fid') => 'exe',
                                 ('app') => '',
                                 ('ext') => '*.exe'
                            ),
                  ('hqx') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/binhex',
                                                (1) => 'application/binhex4',
                                                (2) => 'application/mac-binhex',
                                                (3) => 'application/mac-binhex40',
                                                (4) => 'application/x-binhex40',
                                                (5) => 'application/x-mac-binhex40'
                                            ),
                                 ('fid') => 'hqx',
                                 ('app') => '',
                                 ('ext') => '*.exe, *.fla (etc)'
                            ),
                  ('swf') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/x-shockwave-flash',
                                                (1) => 'application/x-shockwave-flash2-preview',
                                                (2) => 'application/futuresplash',
                                                (3) => 'image/vnd.rn-realflash'
                                            ),
                                 ('fid') => 'swf',
                                 ('app') => '',
                                 ('ext') => '*.swf'
                            ),
                  ('fla') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'application/octet-stream'
                                            ),
                                 ('fid') => 'fla',
                                 ('app') => 'Adobe Flash',
                                 ('ext') => '*.fla'
                            ),
                  ('css') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'text/css'
                                            ),
                                 ('fid') => 'css',
                                 ('app') => '',
                                 ('ext') => '*.css'
                            ),
                  ('html') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'text/html'
                                            ),
                                 ('fid') => 'html',
                                 ('app') => '',
                                 ('ext') => '*.html, *.html, *.htmls, *.htx'
                            ),
                  ('xml') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'text/xml',
                                                (1) => 'application/xml'
                                            ),
                                 ('fid') => 'xml',
                                 ('app') => '',
                                 ('ext') => '*.xml'
                            ),
                  ('wml') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'text/vnd.wap.wml'
                                            ),
                                 ('fid') => 'wml',
                                 ('app') => '',
                                 ('ext') => '*.wml'
                            ),
                  ('mht') => array
                            (
                                 ('mime') => array
                                            (
                                                (0) => 'message/rfc822'
                                            ),
                                 ('fid') => 'mht',
                                 ('app') => 'Internet Explorer',
                                 ('ext') => '*.mht, *.mhtml'
                            )
             );

   return $array;

}


function afMimeTypeIsInArray($needle, $haystack, $case_sensitive=true)
  {
    if($case_sensitive===false)
      $needle=strtolower($needle);

    foreach($haystack as $v)
    {
        if(!is_array($v))
        {
          if(!$case_sensitive)
            $v=strtolower($v);

          if($needle == $v)
            return true;
        }
        else
        {
            if(afMimeTypeIsInArray($needle, $v, $case_sensitive) === true)
              return true;
        }
    }
    return false;
}


function afGetFileExt( $file ){

   $extmatch = explode(".", $file);
   $extension = $extmatch[count($extmatch)-1];
   return $extension;

}


function afGetFileSize ($size, $retstring = null) {
        $sizes = array('Bytes', 'KBytes', 'MBytes', 'GBytes');
        if ($retstring === null) { $retstring = '%01.2f %s'; }
        $lastsizestring = end($sizes);
        foreach ($sizes as $sizestring) {
                if ($size < 1024) { break; }
                if ($sizestring != $lastsizestring) { $size /= 1024; }
        }
        if ($sizestring == $sizes[0]) { $retstring = '%01d %s'; }
        return sprintf($retstring, $size, $sizestring);
}


function afDLFileFromRForms ( $file ) {

   global $afcfg_att_path;

   if( $afcfg_att_path != '' && is_dir(JPATH_SITE.$afcfg_att_path.$file) ){
      $fulllink = JURI::base().$afcfg_att_path.$file;
      $fulllinkp = JPATH_SITE.$afcfg_att_path.$file;
   } else {
      $fulllink = AFPATH_WEB_ATTACHS_SITE.$file;
      $fulllinkp = AFPATH_ATTACHS_SITE.$file;
   }

   header( 'Content-Description: File Transfer' );
   header( 'Content-Type: application/octet-stream' );
   header( 'Content-Length: '.filesize($fulllinkp) );
   header( 'Content-Disposition: attachment; filename='.$file );
   header( 'Content-Transfer-Encoding: binary' );
   readfile( $fulllink );
   exit;
}


function afDoAttachmentsInForm ( $sysattsel, $att_mand_ast, $afcfg_asteriskimg='', $limitattach = '' ) {

    global $mainframe;

   if( $sysattsel == '0' )return;
   if( $att_mand_ast == '1'){
      $asterisk =  '   '.'<img border="0" src="'.JURI::base().'images/artforms/asterisks/'.$afcfg_asteriskimg.'" alt="*" title="" />';
   } else {
      $asterisk = '';
   }
   
   switch ( $sysattsel ) {

      case '1': //One simple attachment

         $sysattatch = '<div id="attsysbox">
                           <div align="center">
                              '.JText::_( 'ARTF_MULTI_ATTACHFILE' ).':
	                      <input class="inputbox" type="file" name="attfile[]" style="height:20px;"/>'.$asterisk.'
                           </div>
                        </div>';
         return $sysattatch;
         
      break;
      
      case '2': //Multiple Attachments - Like GMail

         $html = '<script type="text/javascript">
                     delbutton = \''.JText::_( 'ARTF_ATTDELFILE' ).'\';
                     aflimitatt = \''.$limitattach.'\';
                  </script>';
         $mainframe->addCustomHeadTag( $html );
         afLoadMultiAttG();
         
         $sysattatch = '<div id="attsysbox">
                           <dl>
                              <dt style="text-align:left;margin-left:120px;">'.JText::_( 'ARTF_ATTDELFILE' ).': '.$asterisk.'</dt>
	                      <dd style="text-align:left;margin-left:120px;">
                              <span id="file0" class="attfile"><input name="attfile[]" type="file"></span>
                              <div id="attfiles"></div>
                              <a href="javascript:void(0);" onclick="javascript:addField();">'.JText::_( 'ARTF_MULTI_ATTACHFILE' ).'</a>
                              </dd>
                           </dl>
                        </div>';

         return $sysattatch;
         
      break;
      
      case '3': //Stickman MultiUpload

         $html = '<script type="text/javascript">
                     delbutton = \''.JText::_( 'ARTF_ATTDELFILE' ).'\';
                  </script>';
         $mainframe->addCustomHeadTag( $html );
         afLoadMultiAttSM();
         
         $sysattatch = '<div id="attsysbox" align="center">
                           <div align="center">
                              <input id="attfiles" type="file" name="attfile" >'.$asterisk.'
                              <div id="attfiles_list"></div>
                           </div>
                        </div>
                        <script type="text/javascript">
                           var multi_selector = new MultiSelector( document.getElementById( \'attfiles_list\' ), \''.$limitattach.'\' );
                           multi_selector.addElement( document.getElementById( \'attfiles\' ) );
                        </script>';

         return $sysattatch;
         
      break;
      
      case '4': //Stickman MultiUpload - Mootools

         $html = '<script type="text/javascript">
                     delbutton = \''.JText::_( 'ARTF_ATTDELFILE' ).'\';
                     confirmdel1 = \''.JText::_( 'ARTF_ATTCONFIRMDELETE1' ).'\';
                     confirmdel2 = \''.JText::_( 'ARTF_ATTCONFIRMDELETE2' ).'\';
                  </script>';
         $mainframe->addCustomHeadTag( $html );
         afLoadMooToolsJS();
         afLoadMultiAttSMMT();
         
         $sysattatch = '<div id="attsysbox" style="margin:0 auto 0 auto;">
                           <div style="margin:0 auto 0 auto;">
                              <span class="afattastfix">'.$asterisk.'</span>
                              <input id="attfiles" type="file" name="attfile" ><br clear="all"/>
                           </div>
                        </div>
                        <script type="text/javascript">
                           var load_method = (window.ie ? \'load\' : \'load\');
                           window.addEvent(load_method, function(){
		              new MultiUpload( $( \'ArtForms\' ).attfile, \''.$limitattach.'\', \'\', true, true );
	                   });
                        </script>';
                        
         return $sysattatch;
         
      break;
      
      case '5': //FancyUploads

         $sysattatch = 'FancyUploads no longer available!!!';

         return $sysattatch;
         
      break;
      
   }
   
}


?>
