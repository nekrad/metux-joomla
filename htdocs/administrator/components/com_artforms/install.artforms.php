<?php 
/**
* @version $Id: install.artforms.php v.2.1b7 2007-12-09 04:52:59Z 16:44:59Z GMT-3 $
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

function com_install() {

   global $mainframe;
   require(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_artforms'.DS.'lib'.DS.'af.lib.core.php');
   afLoadLib( 'upd' );
   $db =& JFactory::getDBO();
   $lang =& JFactory::getLanguage();
   $lang->load('com_artforms');

   echo '<table border="0" cellspacing="0" cellpadding="0" width="75%" style="font-family:Arial;font-size:11px;color:#555;">
            <tr>
               <td valign="top" colspan="2" " style="background-image:url('.AFPATH_WEB_IMG_ADM_SITE.'logo.png);background-repeat:no-repeat;background-position:top center;height:78px;" >
               </td>
            </tr>
            <tr>
               <td valign="top" style="width:180px;">
                  <img title="ArtForms Box" alt="ArtForms Box" hspace="6" src="'.AFPATH_WEB_IMG_ADM_SITE.'artformsbox.png" align="left" border="0">
               </td>
               <td valign="top">
                  <p><br /><strong>'.JText::_( 'ARTF_INST_TEXT1').'</strong></p>
                  <p>'.JText::_( 'ARTF_INST_TEXT2').'</p>
                  <p>'.JText::_( 'ARTF_INST_TEXT3').'</p>
               </td>
            </tr>
            <tr>
               <td valign="top" colspan="2">
                  <p><br />'.JText::_( 'ARTF_INST_TEXT4').'</p>
                  <p>'.JText::_( 'ARTF_INST_TEXT5').'</p>
               </td>
            </tr>
         </table><br /><br />';

     $cdir1 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms\'';
     $cdir2 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms/attachedfiles\'';
     $cdir3 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms/asterisks\'';
     if(!file_exists(AFPATH_ASTERISKS_SITE.'ast01.png') && file_exists(AFPATH_ASSETS_SITE.'images'.DS.'temp'.DS.'ast01.png')) {
        $cdir1 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms\'';
	if (@mkdir (JPATH_SITE.DS.'images'.DS.'artforms'.DS, 0766) || is_dir(JPATH_SITE.DS.'images'.DS.'artforms'.DS)) {
    	   @chmod (JPATH_SITE.DS.'images'.DS.'artforms'.DS, 0766);
	   $cdirtask1 = '<font color=\'green\'>'.JText::_( 'ARTF_INST_CREATEDIRSUCC' ).'</font>';

	   $cdir2 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms/attachedfiles\'';
	   if (@mkdir (AFPATH_ATTACHS_SITE, 0766) || is_dir(AFPATH_ATTACHS_SITE)) {
    	      @chmod (AFPATH_ATTACHS_SITE, 0766);
    	      $cdirtask2 = '<font color=\'green\'>'.JText::_( 'ARTF_INST_CREATEDIRSUCC' ).'</font>';
	   } else {
	      $cdirtask2 = '<font color=\'red\'><strong>'.JText::_( 'ARTF_INST_CREATEDIRFAIL' ).': '.AFPATH_ATTACHS_SITE.'</strong></font>';
	   }

	   $cdir3 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms/asterisks\'';
	   if (@mkdir (AFPATH_ASTERISKS_SITE, 0766) || is_dir(AFPATH_ASTERISKS_SITE)) {
    	      @chmod (AFPATH_ASTERISKS_SITE, 0766);
    	      $cdirtask3 = '<font color=\'green\'>'.JText::_( 'ARTF_INST_CREATEDIRSUCC' ).'</font>';
	   } else {
	      $cdirtask3 = '<font color=\'red\'><strong>'.JText::_( 'ARTF_INST_CREATEDIRFAIL' ).': '.AFPATH_ASTERISKS_SITE.'</strong></font>';
	   }

	   afCopyImgTmp( 'ast01.png' );
           afCopyImgTmp( 'ast02.png' );
           afCopyImgTmp( 'ast03.png' );
           afCopyImgTmp( 'ast04.png' );
           afCopyImgTmp( 'ast05.png' );
           afCopyImgTmp( 'ast06.png' );
           afCopyImgTmp( 'ast07.png' );
           afCopyImgTmp( 'ast08.png' );
           afCopyImgTmp( 'ast09.png' );
           afCopyImgTmp( 'ast10.png' );
           afCopyImgTmp( 'ast11.png' );
           afCopyImgTmp( 'ast12.png' );
           afCopyImgTmp( 'ast13.png' );
           afCopyImgTmp( 'ast14.png' );
           afCopyImgTmp( 'ast15.png' );
           afCopyImgTmp( 'ast16.png' );
           afCopyImgTmp( 'ast17.png' );
           afCopyImgTmp( 'ast18.png' );
           afCopyImgTmp( 'ast19.png' );
           afCopyImgTmp( 'ast20.png' );
           afCopyImgTmp( 'ast21.png' );
           afCopyImgTmp( 'ast22.png' );
           afCopyImgTmp( 'ast23.png' );
           afCopyImgTmp( 'ast24.png' );
           afCopyImgTmp( 'ast25.png' );
           afCopyImgTmp( 'ast26.png' );
           afCopyImgTmp( 'ast27.png' );
           afCopyImgTmp( 'ast28.png' );

           afDelImgTmp( 'ast01.png' );
           afDelImgTmp( 'ast02.png' );
           afDelImgTmp( 'ast03.png' );
           afDelImgTmp( 'ast04.png' );
           afDelImgTmp( 'ast05.png' );
           afDelImgTmp( 'ast06.png' );
           afDelImgTmp( 'ast07.png' );
           afDelImgTmp( 'ast08.png' );
           afDelImgTmp( 'ast09.png' );
           afDelImgTmp( 'ast10.png' );
           afDelImgTmp( 'ast11.png' );
           afDelImgTmp( 'ast12.png' );
           afDelImgTmp( 'ast13.png' );
           afDelImgTmp( 'ast14.png' );
           afDelImgTmp( 'ast15.png' );
           afDelImgTmp( 'ast16.png' );
           afDelImgTmp( 'ast17.png' );
           afDelImgTmp( 'ast18.png' );
           afDelImgTmp( 'ast19.png' );
           afDelImgTmp( 'ast20.png' );
           afDelImgTmp( 'ast21.png' );
           afDelImgTmp( 'ast22.png' );
           afDelImgTmp( 'ast23.png' );
           afDelImgTmp( 'ast24.png' );
           afDelImgTmp( 'ast25.png' );
           afDelImgTmp( 'ast26.png' );
           afDelImgTmp( 'ast27.png' );
           afDelImgTmp( 'ast28.png' );
           afDelDirTmp( 'temp');
           
           echo $cdirtask1.'<br />';
           echo $cdirtask2.'<br />';
           echo $cdirtask3.'<br />';

      }

      echo "<br /><br />";
      afUpdMLangEnt();
      echo "<br /><br />";
      afJoomFish();
      echo "<br /><br />";

      if( is_dir(JPATH_SITE.DS.'images'.DS.'artforms'.DS) && is_dir(AFPATH_ASTERISKS_SITE) && is_dir(AFPATH_ATTACHS_SITE) ) {
           chmod (JPATH_SITE.DS.'images'.DS.'artforms'.DS, 0755);
           chmod (AFPATH_ASTERISKS_SITE, 0755);
           chmod (AFPATH_ATTACHS_SITE, 0755);
         $updmsg = '<font color=green>
                       <strong>'.JText::_( 'ARTF_UPD_DIRCHMSUCC').'
                       <br />'.JPATH_SITE.DS.'images'.DS.'artforms'.DS.'
                       <br />'.AFPATH_ASTERISKS_SITE.'
                       <br />'.AFPATH_ATTACHS_SITE.'
                       </strong>
                    </font><br /><br />';
      } else {
         $updmsg = '<font color=green>
                       <strong>'.JText::_( 'ARTF_UPD_DIRCHMERROR').'
                       <br />'.JPATH_SITE.DS.'images'.DS.'artforms'.DS.'
                       <br />'.AFPATH_ASTERISKS_SITE.'
                       <br />'.AFPATH_ATTACHS_SITE.'
                       </strong>
                    </font><br /><br />';
      }
      echo $updmsg;
      
      echo ('<table border="0" cellspacing="0" cellpadding="0" width="75%">'
	        .'<tr><td align="center">'
	        .'<p style="font-size:18px;color:green;">'.JText::_( 'ARTF_INST_MESS').'</p>'
                .'</td></tr></table><br /><br />');

   } else {
	
           echo "<br /><br />";
           afUpdMLangEnt();
           echo "<br /><br />";
	
	   afJoomFish();
	   
	   afSEFsh404SEF();
	   
           echo ('<font color="red" style="font-size:18px;><strong>'.'&nbsp;'.JText::_( 'ARTF_INST_CREATEDIRFAIL').'</strong></font></p>'
	       . '<table border="0" cellspacing="0" cellpadding="0" background="'.AFPATH_WEB_IMG_ADM_SITE.'logo.png" style="background-repeat:no-repeat; background-position:top right;" width="75%">'
	       . '<tr><td align="left">'
	       . '<p style="font-size:12px;"><strong>'.JText::_( 'ARTF_INST_MESSFAIL1').'</strong></p>'
	       . '<p style="font-size:12px;>'.JText::_( 'ARTF_INST_MESSFAIL2').'</p>'
	       . '<p style="font-size:12px;>'.JText::_( 'ARTF_INST_MESSFAIL3').'</p'
	       . '</td></tr></table><br /><br /><br /><br />');
   }
   
   $update = "UPDATE #__components SET `params` = 'rootfronttitle=ArtForms\nfronttext=Select a form' WHERE link = 'option=com_artforms' AND parent = '0'";
   $db->setQuery($update);
   $db->query();
   
   afFooter();

}


?>
