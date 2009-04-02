<?php
/**
* @version $Id: af.lib.loadhelper.php v.2.1b7 2007-11-24 20:36:45Z GMT-3 $
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

      /*Variables Form Editor Start*/
      $helper_title = '';
      $helper_destto = '';
      $helper_destcc = '';
      $helper_destbcc = '';
      $helper_confirmationemail = '';
      $helper_htmlmode = '';
      $helper_editorsel = '';
      $helper_allsendcopy = '';
      $helper_custjscode = '';
      $helper_custcss = '';
      $helper_captcha = '';
      $helper_metadesc = '';
      $helper_metakey = '';
      $helper_publish = '';
      $helper_access = '';
      $helper_authoralias = '';
      $helper_creator = '';
      $helper_forder = '';
      $helper_createddate = '';
      $helper_publishup = '';
      $helper_publishdown = '';
      $helper_resetbtn = '';
      $helper_backbtn = '';
      $helper_showtitle = '';
      $helper_dynpagetitle = '';
      $helper_showcreated = '';
      $helper_showmodif = '';
      $helper_showauthor = '';
      $helper_usecustcss = '';
      $helper_useredir = '';
      $helper_redirurl = '';
      $helper_text = '';
      $helper_danktext = '';
      $helper_allowattfiles = '';
      $helper_allowattfilessize = '';
      $helper_limitatt = '';
      $helper_attmanditory = '';
      $helper_allowattfilesset = '';
      $helper_selmenu = '';
      $helper_seltitletype = '';
      $helper_menutitle = '';
      $helper_menuaccess = '';
      $helper_menupublish = '';
      /*Variables Form Editor End*/
      
      /*Variables FieldsAjax Start*/
      $helper_order = '';
      $helper_fieldname = '';
      $helper_fieldtype = '';
      $helper_required = '';
      $helper_valide = '';
      $helper_customcode = '';
      $helper_readonly = '';
      $helper_values = '';
      $helper_defvalues = '';
      $helper_layout = '';
      $helper_addfieldssel = '';
      /*Variables FieldsAjax End*/

      if( $afcfg_usebehelper == '1' ){

         $helpimg = AFPATH_WEB_IMG_ADM_SITE.'info.png';

         /*Variables Form Editor Start*/
         $helper_title = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_FORMTITLE' ).' :: '.JText::_( 'ARTF_HELPER_FCFG_TITLE' ).'" />';
         $helper_destto = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_TO' ).' :: '.JText::_( 'ARTF_HELPER_FCFG_DESTTO' ).'" />';
         $helper_destcc = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_CC' ).' :: '.JText::_( 'ARTF_HELPER_FCFG_DESTCC' ).'" />';
         $helper_destbcc = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_BCC' ).' :: '.JText::_( 'ARTF_HELPER_FCFG_DESTBCC' ).'" />';
         $helper_confirmationemail = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_CONFIRMATIONEMAIL' ).' :: '.JText::_( 'ARTF_HELPER_FCFG_CONFIRMATIONEMAIL' ).'" />';
         $helper_htmlmode = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_TEXTHTMLSET' ).' :: '.JText::_( 'ARTF_HELPER_FCFG_HTMLMODE' ).'" />';
         $helper_editorsel = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_EDITORSEL' ).' :: '.JText::_( 'ARTF_HELPER_FCFG_EDITORSEL' ).'" />';
         $helper_allsendcopy = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_EMAILCOPYFIELD' ).' :: '.JText::_( 'ARTF_HELPER_FCFG_ALLOWSENDCOPY' ).'" />';
         $helper_custjscode = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_CUSTOMJSCODE' ).' :: '.JText::_( 'ARTF_HELPER_FCFG_CUSTOMJSCODE' ).'" />';
         $helper_custcss = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_CUSTOMCSS' ).' :: '.JText::_( 'ARTF_HELPER_FCFG_CUSTOMCSS' ).'" />';
         $helper_captcha = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_CAPTCHASYSTEM' ).' :: '.JText::_( 'ARTF_HELPER_FCFG_CAPTCHA' ).'" />';
         $helper_metadesc = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_METADESCRIPTION' ).' :: '.JText::_( 'ARTF_HELPER_FCFG_METADESC' ).'" />';
         $helper_metakey = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_METAKEYWORDS' ).' :: '.JText::_( 'ARTF_HELPER_FCFG_METAKEY' ).'" />';
         $helper_publish = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_PUBLISH' ).' :: '.JText::_( 'ARTF_HELPER_FPUB_PUBLISH' ).'" />';
         $helper_access = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_MENUACCESS' ).' :: '.JText::_( 'ARTF_HELPER_FPUB_MENUACCESS' ).'" />';
         $helper_authoralias = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_AUTHORALIAS' ).' :: '.JText::_( 'ARTF_HELPER_FPUB_AUTHORALIAS' ).'" />';
         $helper_creator = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_MODCREATEDBY' ).' :: '.JText::_( 'ARTF_HELPER_FPUB_MODCREATEDBY' ).'" />';
         $helper_forder = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_ORDER' ).' :: '.JText::_( 'ARTF_HELPER_FPUB_ORDER' ).'" />';
         $helper_createddate = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_MODCREATEDDATE' ).' :: '.JText::_( 'ARTF_HELPER_FPUB_MODCREATEDDATE' ).'" />';
         $helper_publishup = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_PUBLISHUP' ).' :: '.JText::_( 'ARTF_HELPER_FPUB_PUBLISHUP' ).'" />';
         $helper_publishdown = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_PUBLISHDOWN' ).' :: '.JText::_( 'ARTF_HELPER_FPUB_PUBLISHDOWN' ).'" />';
         $helper_resetbtn = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_SHOWRESETBTN' ).' :: '.JText::_( 'ARTF_HELPER_PARAM_SHOWRESETBTN' ).'" />';
         $helper_backbtn = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_SHOWBACKBTN' ).' :: '.JText::_( 'ARTF_HELPER_PARAM_SHOWBACKBTN' ).'" />';
         $helper_showtitle = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_SHOWFORMTITLE' ).' :: '.JText::_( 'ARTF_HELPER_PARAM_SHOWFORMTITLE' ).'" />';
         $helper_dynpagetitle = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_DYNAMICPAGETITLES' ).' :: '.JText::_( 'ARTF_HELPER_PARAM_DYNAMICPAGETITLES' ).'" />';
         $helper_showcreated = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_SHOWCREATEDDATE' ).' :: '.JText::_( 'ARTF_HELPER_PARAM_SHOWCREATEDDATE' ).'" />';
         $helper_showmodif = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_SHOWMODIFDATE' ).' :: '.JText::_( 'ARTF_HELPER_PARAM_SHOWMODIFDATE' ).'" />';
         $helper_showauthor = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_SHOWAUTHOR' ).' :: '.JText::_( 'ARTF_HELPER_PARAM_SHOWAUTHOR' ).'" />';
         $helper_usecustcss = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_USECUSTOMCSS' ).' :: '.JText::_( 'ARTF_HELPER_PARAM_USECUSTOMCSS' ).'" />';
         $helper_useredir = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_USEREDIRECTURL' ).' :: '.JText::_( 'ARTF_HELPER_PARAM_USEREDIRECTURL' ).'" />';
         $helper_redirurl = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_REDIRECTURL' ).' :: '.JText::_( 'ARTF_HELPER_PARAM_REDIRECTURL' ).'" />';
         $helper_text = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_INFTEXT' ).' :: '.JText::_( 'ARTF_HELPER_TEXT_INFTEXT' ).'" />';
         $helper_danktext = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_SENDEDTEXT' ).' :: '.JText::_( 'ARTF_HELPER_TEXT_SENDEDTEXT' ).'" />';
         $helper_allowattfiles = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_ALLOWATTFILES' ).' :: '.JText::_( 'ARTF_HELPER_ATTF_ALLOWATTFILES' ).'" />';
         $helper_allowattfilessize = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_ALLOWATTFILESSIZE' ).' :: '.JText::_( 'ARTF_HELPER_ATTF_ALLOWATTFILESSIZE' ).'" />';
         $helper_limitatt = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_LIMITATT' ).' :: '.JText::_( 'ARTF_HELPER_ATTF_LIMITATT' ).'" />';
         $helper_attmanditory = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_SETATTMANDITORY' ).' :: '.JText::_( 'ARTF_HELPER_ATTF_SETATTMANDITORY' ).'" />';
         $helper_allowattfilesset = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_ALLOWATTFILESSET' ).' :: '.JText::_( 'ARTF_HELPER_ATTF_ALLOWATTFILESSET' ).'" />';
         $helper_selmenu = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_MENUSELMENU' ).' :: '.JText::_( 'ARTF_HELPER_MENU_MENUSELMENU' ).'" />';
         $helper_seltitletype = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_MENUTYPE' ).' :: '.JText::_( 'ARTF_HELPER_MENU_MENUTYPE' ).'" />';
         $helper_menutitle = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_MENUINSERTNAME' ).' :: '.JText::_( 'ARTF_HELPER_MENU_MENUINSERTNAME' ).'" />';
         $helper_menuaccess = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_MENUACCESS' ).' :: '.JText::_( 'ARTF_HELPER_MENU_MENUACCESS' ).'" />';
         $helper_menupublish = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_MENUPUBLISH' ).' :: '.JText::_( 'ARTF_HELPER_MENU_MENUPUBLISH' ).'" />';
         $helper_newslettersel = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_NEWSLETTERSEL' ).' :: '.JText::_( 'ARTF_HELPER_NLET_NEWSLETTERSEL' ).'" />';
         /*Variables Form Editor End*/

         /*Variables FieldsAjax Start*/
         $helper_order = ' <img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_ORDER' ).' :: '.JText::_( 'ARTF_HELPER_FIELD_ORDER' ).'" />';
         $helper_fieldname = ' <img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_FIELDNAME' ).' :: '.JText::_( 'ARTF_HELPER_FIELD_FIELDNAME' ).'" />';
         $helper_fieldtype = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_FIELDTYPE' ).' :: '.JText::_( 'ARTF_HELPER_FIELD_FIELDTYPE' ).'" />';
         $helper_required = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_REQUIRED' ).' :: '.JText::_( 'ARTF_HELPER_FIELD_REQUIRED' ).'" />';
         $helper_valide = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_VALIDE' ).' :: '.JText::_( 'ARTF_HELPER_FIELD_VALIDE' ).'" />';
         $helper_customcode = ' <img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_CUSTOMCODE' ).' :: '.JText::_( 'ARTF_HELPER_FIELD_CUSTOMCODE' ).'" />';
         $helper_readonly = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_READONLY' ).' :: '.JText::_( 'ARTF_HELPER_FIELD_READONLY' ).'" />';
         $helper_values = ' <img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_VALUES' ).' :: '.JText::_( 'ARTF_HELPER_FIELD_VALUES' ).'" />';
         $helper_defvalues = ' <img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_DEFVALUES' ).' :: '.JText::_( 'ARTF_HELPER_FIELD_DEFVALUES' ).'" />';
         $helper_layout = ' <img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_LAYOUT' ).' :: '.JText::_( 'ARTF_HELPER_FIELD_LAYOUT' ).'" />';
         $helper_addfieldssel = '<img src="'.$helpimg.'" width="16" height="16" border="0" alt="" class="MTTips" title="'.JText::_( 'ARTF_FORM_NEWFIELD' ).' :: '.JText::_( 'ARTF_HELPER_FIELD_NEWFIELD' ).'" />';
         /*Variables FieldsAjax End*/
         
      }

?>
