<?php
/**
* @version $Id: artforms.html.php v.2.1b7 2007-12-03 15:23:45Z GMT-3 $
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

class HTML_beartforms {

   function ShowFrontArtForms ( $row, $items, $params, $option ){

      global $mainframe, $gid;
      require( AFPATH_ADM_SITE.'config.artforms.php' );
      require_once( AFPATH_SITE.'version.php' );

      afLoadLib ( 'afforms' );
      afLoadLib ( 'attfiles' );
      
      $user =& JFactory::getUser();
      
      $do = JArrayHelper::getValue( $_POST, 'do' );
      $formtitle = JArrayHelper::getValue( $_POST, 'formtitle' );
      $formid = JArrayHelper::getValue( $_REQUEST, 'formid' );

      $joomlauser = JArrayHelper::getValue( $_POST, 'joomlauser', '' );
      $joomlausername = JArrayHelper::getValue( $_POST, 'joomlausername', '' );
      $joomlauserip = JArrayHelper::getValue( $_POST, 'joomlauserip', '' );
      if ( $joomlauser == '' ) $joomlauser = JText::_( 'ARTF_ANONYMOUS' );
      if ( $joomlausername == '' ) $joomlausername = JText::_( 'ARTF_ANONYMOUS' );
      if ( $joomlauserip == '' ) $joomlauserip = JText::_( 'ARTF_NOIP' );

      if( JArrayHelper::getValue( $_GET, 'af_mod' ) == '1' ){
         $alink = 'index2.php?option=com_artforms&af_mod=1';
      } else {
         $alink = 'index.php?option=com_artforms';
      }

      $a_errors = array();
      $a_error_ids = array();
      $attfileerrchk = array();
      $uploadedfile = '';
      $itemname_todb = '';
      $itemdata_todb = '';
      $mail_data = '';
      $html = '';
      
      if(JArrayHelper::getValue( $_GET, 'option' ) == 'com_artforms' ){
         $Itemid = JArrayHelper::getValue( $_GET, 'Itemid' );
         if($Itemid == '' )$Itemid = afGetItemid( $formid );
         if($Itemid == '' )$Itemid = '99999';
      } else {
         $Itemid = afGetItemid( $formid );
         if($Itemid == '' )$Itemid = '99999';
      }

      if( !$row ) {
         $user =& JFactory::getUser();
         echo JText::_('ALERTNOTAUTH');
         if ($user->get('id') < 1) {
            echo "<br />" . JText::_( 'You need to login.' );
         }
      }

      if ( '1' != JArrayHelper::getValue( $_GET, 'no_aftitle' ) && $params->get( 'change_page_title' ) == '1' ){
         $mainframe->setPageTitle( $row->titel );
      }
      
      if ( '1' === $afcfg_loadfrontcss && $params->get( 'use_custom_css' ) != '1' ){
         afLoadFECSS();
      }
      
      if ( $params->get( 'use_custom_css' ) === '1' ){
         $htmlh = '<style type="text/css">
                  '.$row->customcss.'
                  </style>';
         $mainframe->addCustomHeadTag( $htmlh );
      }

      $mainframe->appendMetaTag( 'description', $row->metadesc );
      $mainframe->appendMetaTag( 'keywords', $row->metakey );

      if ( $params->get( 'show_form_title' ) == '1' ){
         $html .= '<div class="componentheading" width="100%">
                  '.$row->titel.'
	       </div>';
      }

      $html .= afLoadTitleError(1);

      $html .= '<div id="artforms-box">';
    
      if ($do == 'send'){

         if ( $row->seccode == '1' ){ //adapted alikon captcha

            include(AFPATH_ASSETS_SITE.'captcha'.DS.'includes'.DS.'alikon'.DS.'captcha.php');
            $pasw = strtolower(JArrayHelper::getValue( $_POST, 'password3', '' ));
            $captcha = new alikoncaptcha() ;
            $results = $captcha->doVerifyAF( $pasw );
            if (!$results == true){
               $msg = JText::_( 'ARTF_CAPTCHA_FAIL' ).'&afimg=0';
               $mainframe->redirect( JRoute::_( $alink.'&formid='.$formid.'&Itemid='.$Itemid.'&afmsg='.$msg ) );
            }
                  
         } elseif ( $row->seccode == '2' ){ //captchaform

            if (version_compare(phpversion(), "5.0.0", ">=")) {
               include_once(AFPATH_ASSETS_SITE.'captcha'.DS.'includes'.DS.'captchaform'.DS.'captchaform5.php');
            } else {
               include_once(AFPATH_ASSETS_SITE.'captcha'.DS.'includes'.DS.'captchaform'.DS.'captchaform4.php');
            }
            $captcha = new captchaform();
            if(!$captcha->post()){
               $msg = JText::_( 'ARTF_CAPTCHA_FAIL' ).'&afimg=0';
               $mainframe->redirect( JRoute::_( $alink.'&formid='.$formid.'&Itemid='.$Itemid.'&afmsg='.$msg ) );
            }
                  
         } elseif ( $row->seccode == '3' ){ //captchatalk (requiere php extension called ming installed in sever)
               
            if (version_compare(phpversion(), "5.0.0", ">=")) {
               include_once(AFPATH_ASSETS_SITE.'captcha'.DS.'includes'.DS.'captchatalk'.DS.'swfcaptcha5.php');
            } else {
               include_once(AFPATH_ASSETS_SITE.'captcha'.DS.'includes'.DS.'captchatalk'.DS.'swfcaptcha4.php');
            }
            $swfc = new swfcaptcha();
            if(!$swfc->validate()){
               $msg = JText::_( 'ARTF_CAPTCHA_FAIL' ).'&afimg=0';
               $mainframe->redirect( JRoute::_( $alink.'&formid='.$formid.'&Itemid='.$Itemid.'&afmsg='.$msg ) );
            }
                  
         } elseif ( $row->seccode == '4' ){ //recaptcha

            require_once(AFPATH_ASSETS_SITE.'captcha'.DS.'includes'.DS.'recaptcha'.DS.'captcha.php');
            $resp = recaptcha_check_answer( $afcfg_captcha_recapt_privatekey, $_SERVER["REMOTE_ADDR"], JArrayHelper::getValue( $_POST, 'recaptcha_challenge_field' ), JArrayHelper::getValue( $_POST, 'recaptcha_response_field' ) );
            if (!$resp->is_valid) {
               $msg = JText::_( 'ARTF_CAPTCHA_FAIL' ).' '.$resp->error.'&afimg=0';
               $mainframe->redirect( JRoute::_( $alink.'&formid='.$formid.'&Itemid='.$Itemid.'&afmsg='.$msg ) );
            }
                  
         } elseif ( $row->seccode == '5' ){ //alikon mambot secure captcha

            $pasw = strtolower(JArrayHelper::getValue($_POST,'password3'));
            $code	= JArrayHelper::getValue($_POST,'gencode');
            if (JPluginHelper::importPlugin( 'alikonweb' )){
               $results = $mainframe->triggerEvent( 'onVerify', array( $pasw, $code)  );
               if ( !$results[0] ) {
                  $msg = JText::_( 'ARTF_CAPTCHA_FAIL' ).'&afimg=0';
                  $mainframe->redirect( JRoute::_( $alink.'&formid='.$formid.'&Itemid='.$Itemid.'&afmsg='.$msg ) );
	       }
            }
	          
	 } elseif ( $row->seccode == '6' ){ //securityimages captcha component

            if(file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_securityimages'.DS.'server.php')) {
               $securityimage_refid  = JArrayHelper::getValue( $_POST, 'artforms_refid', '' );
               $securityimage_try    = JArrayHelper::getValue( $_POST, 'artforms_try', '' );
               $securityimage_reload = JArrayHelper::getValue( $_POST, 'artforms_reload', '' );
               include_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_securityimages'.DS.'server.php');
               $checkSecurity = checkSecurityImage($securityimage_refid, $securityimage_try, $securityimage_reload);
               if ( !$checkSecurity ) {
                  $msg = JText::_( 'ARTF_CAPTCHA_FAIL' ).'&afimg=0';
                  $mainframe->redirect( JRoute::_( $alink.'&formid='.$formid.'&Itemid='.$Itemid.'&afmsg='.$msg ) );
	       }
            }
	  
         } elseif ( $row->seccode == '7' ){ //easycaptcha component

            if(file_exists(JPATH_SITE.DS.'components'.DS.'com_easycaptcha'.DS.'class.easycaptcha.php')) {
               $captcha_code = JArrayHelper::getValue( $_POST, "captcha_code" );
               $captcha_id = JArrayHelper::getValue( $_POST, "captcha_id");
               include_once(JPATH_SITE.DS.'components'.DS.'com_easycaptcha'.DS.'class.easycaptcha.php');
               $captcha = new easyCaptcha($captcha_id);
               if ( !$captcha->checkEnteredCode($captcha_code) ) {
                  $msg = JText::_( 'ARTF_CAPTCHA_FAIL' ).'&afimg=0';
                  $mainframe->redirect( JRoute::_( $alink.'&formid='.$formid.'&Itemid='.$Itemid.'&afmsg='.$msg ) );
               }
            }
         }

	 //Check submited Values
	 foreach($items as $item){
	    $data = $_POST['item_'.$item->item_id];
	    
	    if($item->type == '8') continue;
	    if(is_array($data)){
	       $values = split(';', $item->values);
	       $dt = '';
	       foreach($data as $d){
                  $dt .= $values[$d] . ', ';
	       }
	       $data = substr($dt, 0, -2);
	    }
	    $submited_value = trim(stripData($data));
            if( $item->required != '1' ){
               if( $submited_value == '' ){
                  $a_errors[] = '<div class="artforms-errorfield">'.$item->name.' '.JText::_( 'ARTF_MANDATORY' ).'</div>';
     	          $a_error_ids[] = $item->item_id;
	          continue;
	       }
	    }
	    if (strrchr( $data, '@') && $row->emailfield != '0' ){
               for( $j=0; $j < count( $data ); $j++ ){
                  $email_copy_to_sender = array();
	          $email_copy_to_sender[$j]=$data;
               }
            }
	    if($item->validation != '0' || $item->validation != ''){//validations start
               if($item->type == '8')continue;
               if($submited_value == '')continue;
               if($item->validation == '1'){ // email
                  if(!validate_email($submited_value)){
                     if($submited_value != ''){
                        $nonemailfix = '-';
                     }else{
                        $nonemailfix = '';
                     }
		     $a_errors[] = '<div class="artforms-errorfield">'.$item->name.' - '.JText::_( 'ARTF_ONLYEMAILALLOWED' ).' '.$nonemailfix.' '.$submited_value.'</div>';
		     $a_error_ids[] = $item->item_id;
		  }
	       } else if($item->validation == '2') { // number
	          $regExp='[0-9]';
	          if (!ereg($regExp, $submited_value)){
		     $a_errors[] = '<div class="artforms-errorfield">'.$item->name.' - '.JText::_( 'ARTF_ONLYNUMBERALLOWED' ).'</div>';
		     $a_error_ids[] = $item->item_id;
	          }
	       } else if($item->validation == '3') { // text
	          $regExp='[a-zA-Z]';
	          if (!ereg($regExp, $submited_value)) {
	              $a_errors[] = '<div class="artforms-errorfield">'.$item->name.' - '.JText::_( 'ARTF_ONLYTEXTALLOWED' ).'</div>';
	              $a_error_ids[] = $item->item_id;
	          }
               } else if($item->validation == '4') { // text&number
	          $regExp='[0-9a-zA-Z]';
	          if (!ereg($regExp, $submited_value)) {
	              $a_errors[] = '<div class="artforms-errorfield">'.$item->name.' - '.JText::_( 'ARTF_ONLYTEXTNUMBERALLOWED' ).'</div>';
	              $a_error_ids[] = $item->item_id;
	          }
               } else if($item->validation == '5') { // decimal
	          $regExp='-?(0|[1-9]{1}\d{0,})(\.(\d{1}\d{0,}))?';
	          if (!ereg($regExp, $submited_value)) {
	              $a_errors[] = '<div class="artforms-errorfield">'.$item->name.' - '.JText::_( 'ARTF_ONLYDECIMALALLOWED' ).'</div>';
	              $a_error_ids[] = $item->item_id;
	          }
               } else if($item->validation == '6') { // date
                  if ( JText::_( 'ARTF_DATEVALIDATION' ) == 'dd-mm-Y' ){
                     $afcfg_valide_date = '^([1-9]|0[1-9]|[12][0-9]|3[01])\D([1-9]|0[1-9]|1[012])\D(19[0-9][0-9]|20[0-9][0-9])$';
                  } else {
                     $afcfg_valide_date = '^([2][0]|[1][9])\d{2}\-([0]\d|[1][0-2])\-([0-2]\d|[3][0-1])$';
                  }
                  if (!ereg($afcfg_valide_date, $submited_value)) {
	              $a_errors[] = '<div class="artforms-errorfield">'.$item->name.' - '.JText::_( 'ARTF_ONLYDATEALLOWED' ).'</div>';
	              $a_error_ids[] = $item->item_id;
	          }
               } else if($item->validation == '7') { // zipcode
	          if (!ereg($afcfg_valide_zipcode, $submited_value)) {
	              $a_errors[] = '<div class="artforms-errorfield">'.$item->name.' - '.JText::_( 'ARTF_ONLYZIPCODEALLOWED' ).'</div>';
	              $a_error_ids[] = $item->item_id;
	          }
               } else if($item->validation == '8') { // IP
	          $regExp='^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$';
	          if (!ereg($regExp, $submited_value)) {
	              $a_errors[] = '<div class="artforms-errorfield">'.$item->name.' - '.JText::_( 'ARTF_ONLYIPALLOWED' ).'</div>';
	              $a_error_ids[] = $item->item_id;
	          }
               } else if($item->validation == '9') { // URL
	          $regExp='(((ht|f)tp(s?))\:\/\/)([0-9a-zA-Z\-]+\.)+[a-zA-Z]{2,6}(\:[0-9]+)?(\/\S*)?';
	          if (!ereg($regExp, $submited_value)) {
	              $a_errors[] = '<div class="artforms-errorfield">'.$item->name.' - '.JText::_( 'ARTF_ONLYURLALLOWED' ).'</div>';
	              $a_error_ids[] = $item->item_id;
	          }
	       } else if($item->validation == '10') { // Credit Card
	          $regExp='([0-3]*[0-9]+[0-9]+)\.([0-3]*[0-9]+[0-9]+)\.([0-3]*[0-9]+[0-9]+)\.([0-3]*[0-9]+[0-9]+)';
	          if (!ereg($regExp, $submited_value)) {
	              $a_errors[] = '<div class="artforms-errorfield">'.$item->name.' - '.JText::_( 'ARTF_ONLYCREDITCARDALLOWED' ).'</div>';
	              $a_error_ids[] = $item->item_id;
	          }
               } else if($item->validation == '11') { // custom 1
	          if (!ereg($afcfg_valide_custom1, $submited_value)) {
	              $a_errors[] = '<div class="artforms-errorfield">'.$item->name.' - '.$afcfg_valide_custom1_legend.'</div>';
	              $a_error_ids[] = $item->item_id;
	          }
               } else if($item->validation == '12') { // custom 2
	          if (!ereg($afcfg_valide_custom2, $submited_value)) {
	              $a_errors[] = '<div class="artforms-errorfield">'.$item->name.' - '.$afcfg_valide_custom2_legend.'</div>';
	              $a_error_ids[] = $item->item_id;
	          }
	       } else if($item->validation == '13') { // custom 3
	          if (!ereg($afcfg_valide_custom3, $submited_value)) {
	              $a_errors[] = '<div class="artforms-errorfield">'.$item->name.' - '.$afcfg_valide_custom3_legend.'</div>';
	              $a_error_ids[] = $item->item_id;
	          }
	       } else if($item->validation == '14') { // custom 4
	          if (!ereg($afcfg_valide_custom4, $submited_value)) {
	              $a_errors[] = '<div class="artforms-errorfield">'.$item->name.' - '.$afcfg_valide_custom4_legend.'</div>';
	              $a_error_ids[] = $item->item_id;
	          }
	       } else if($item->validation == '15') { // custom 5
	          if (!ereg($afcfg_valide_custom5, $submited_value)) {
	              $a_errors[] = '<div class="artforms-errorfield">'.$item->name.' - '.$afcfg_valide_custom5_legend.'</div>';
	              $a_error_ids[] = $item->item_id;
	          }
	       }
	    }//validations end
            if($item->type == '3' || $item->type == '4') {
	       $a_values = explode(';', $item->values);
	       $submited_value = $_POST['item_'.$item->item_id];
	       if(is_array($submited_value)){
	          $a_tmp = $submited_value;
	          $submited_value = array();
	          foreach($a_tmp as $index){
                     $submited_value[] = $a_values[$index];
		  }
	       } else {
	          $submited_value = $a_values[$submited_value];
	       }
	    }
	    if(is_array($submited_value)){
	       $mail_data[$item->name] = implode(', ', $submited_value);
            } else {
               $mail_data[$item->name] = $submited_value;
            }
            $getitems = $data;
            if (is_array($getitems)){
	       $dt = '';
	       foreach($getitems as $d){
		  $dt .= $d. ', ';
	       }
	       $getitems = substr($dt, 0, -2);
	    }
	    if (isset($item->name)){
	       $itemname_todb .= eregi_replace(';',',',$item->name).';';
	    } else {
               $itemname_todb .= eregi_replace(';',',','-').';';
            }
            $itemdata_todb .= eregi_replace(';',',',$getitems).';';
            
         }//foreach items

         if(count($a_errors) == 0){

            $attachments = null;
            $attachmentstodb = null;
            $meldung = null;
            $meldung2 = null;

            if ( $row->allowatt != '0' ){ // Upload and Attachment start

               $max_size = $row->allowattfilesize; // in KBytes
               if( $afcfg_att_path != '' && is_dir(JPATH_SITE.DS.$afcfg_att_path) ){
                  $artuplpfad = JPATH_SITE.DS.$afcfg_att_path;
               } else {
                  $artuplpfad = AFPATH_ATTACHS_SITE;
               }
               $attachments = array();
               $attachmentstodb = array();

               $mtypes_key_array = explode(",",$row->allowattfiles);
               $mtypes_allowed = afMimeTypesAllowed();
               $mimetypen_array = array();
               foreach( $mtypes_key_array as $key ){
                  $mimetypen_array[$key] = $mtypes_allowed[$key]['mime'];
               }

               $meldung = '';
               $meldung2 = '';
	       $ok = false;
               $attfilescount = @count($_FILES['attfile']['tmp_name']);

               for( $g = '0'; $g < $attfilescount; $g++ ) {

                  if ( $_FILES['attfile']['error'][$g] == '4' && $_FILES['attfile']['name'][0] == '' && count($_FILES['attfile']['name']) != 1 ){
                     $attfileerrchk[] = '';
                  } elseif ( $_FILES['attfile']['error'][$g] == '4' && $_FILES['attfile']['name'][0] == '' && count($_FILES['attfile']['name']) == 1 ){
                     $meldung .='<div class="artforms-error">'.JText::_( 'ARTF_SENTWOUTFILES' ).'</div>';
                     $attfileerrchk[] = 'error';
                  } else {
                     if ($_FILES['attfile']['size'][$g] == 0){
	                $a_errors[] = '<div class="artforms-errorwsize">'.JText::_( 'ARTF_EMPTYORFILESIZESTOP' ).'<br />( '.JText::_( 'ARTF_MAX' ).' '.$max_size.' KBytes )<br />'.JText::_( 'ARTF_MULTI_ATTACHFILE' ).': '.$_FILES['attfile']['name'][$g].'</div>';
                        $attfileerrchk[] = 'error';
                        $meldung2 .= '<div class="artforms-error">'.JText::_( 'ARTF_NOTATTFILES' ).':<br />'.JText::_( 'ARTF_MULTI_ATTACHFILE' ).': '.$_FILES['attfile']['name'][$g].'</div>';
                     } elseif ($_FILES['attfile']['size'][$g] > ($max_size * 1024)){
	               $a_errors[] = '<div class="artforms-error">'.JText::_( 'ARTF_FILESIZESTOP' ).' <br />(max. '.$max_size.' KBytes)<br />'.JText::_( 'ARTF_MULTI_ATTACHFILE' ).': '.$_FILES['attfile']['name'][$g].'</div>';
                       $attfileerrchk[] = 'error';
                       $meldung2 .= '<div class="artforms-error">'.JText::_( 'ARTF_NOTATTFILES' ).':<br />'.JText::_( 'ARTF_MULTI_ATTACHFILE' ).': '.$_FILES['attfile']['name'][$g].'</div>';
                     } elseif (!afMimeTypeIsInArray($_FILES['attfile']['type'][$g], $mimetypen_array)){
                       $chktypealert = '<div class="artforms-errorwtype">';
	               $chktypealert .= JText::_( 'ARTF_WRONGTYPE' ).'<br />*.'.afGetFileExt( $_FILES['attfile']['name'][$g] ).' ('.$_FILES['attfile']['type'][$g].')<br /><br />'.JText::_( 'ARTF_MULTI_ATTACHFILE' ).': '.$_FILES['attfile']['name'][$g].'<br />';
                       $chktypealert .= '<br />'.JText::_( 'ARTF_ONLYFILESALLOWED' ).'<br /><a href="javascript:void(0);" onClick="javascript:if(document.getElementById(\'afallowedfilesspoiler'.$g.'\').style.display != \'\') { document.getElementById(\'afallowedfilesspoiler'.$g.'\').style.display = \'\';this.innerText = \'\'; this.value = \'Hide\'; } else { document.getElementById(\'afallowedfilesspoiler'.$g.'\').style.display = \'none\'; this.innerText = \'\'; this.value = \'Show\'; };">'.JText::_( 'ARTF_CLICKTOSHOW' ).'</a><div><div id="afallowedfilesspoiler'.$g.'" style="display: none;"><ul>';
                       foreach ($mtypes_key_array as $key){
	                  $chktypealert .= "\n<li>".$mtypes_allowed[$key]['ext']."</li>";
	               }
	               $chktypealert .= '</ul></div></div></div>';
	               //$chktypealert .= '<div class="artforms-error">'.JText::_( 'ARTF_NOTATTFILES' ).':<br />'.JText::_( 'ARTF_MULTI_ATTACHFILE' ).': '.$_FILES['attfile']['name'][$g].'</div>';
                       $a_errors[] = $chktypealert;
                       $meldung2 .= '<div class="artforms-error">'.JText::_( 'ARTF_NOTATTFILES' ).':<br />'.JText::_( 'ARTF_MULTI_ATTACHFILE' ).': '.$_FILES['attfile']['name'][$g].'</div>';
                       $attfileerrchk[] = 'error';
                     } elseif ($_FILES['attfile']['error'][$g] == '0'){
	                $groesse = GetImageSize($_FILES['attfile']['tmp_name'][$g]);
		        if (is_array($groesse)){
		           if ($groesse[0] > $afcfg_attimagew || $groesse[1] > $afcfg_attimageh){
		              $a_errors[] ='<div class="artforms-error">'.JText::_( 'ARTF_PICSIZEERROR' ).' <br />( '.JText::_( 'ARTF_MAX' ).' '.$afcfg_attimagew.' px X '.$afcfg_attimageh.' px )<br />'.JText::_( 'ARTF_MULTI_ATTACHFILE' ).': '.$_FILES['attfile']['name'][$g].'</div>';
                              $attfileerrchk[] = 'error';
                              $meldung2 .= '<div class="artforms-error">'.JText::_( 'ARTF_NOTATTFILES' ).':<br />'.JText::_( 'ARTF_MULTI_ATTACHFILE' ).': '.$_FILES['attfile']['name'][$g].'</div>';
                           }
		        }
	             } else {
	                $a_errors[] ='<div class="artforms-error">'.JText::_( 'ARTF_EMPTYFILE' ).'<br />'.JText::_( 'ARTF_MULTI_ATTACHFILE' ).': '.$_FILES['attfile']['name'][$g].'</div>';
                        $attfileerrchk[] = 'error';
                        $meldung2 .= '<div class="artforms-error">'.JText::_( 'ARTF_NOTATTFILES' ).':<br />'.JText::_( 'ARTF_MULTI_ATTACHFILE' ).': '.$_FILES['attfile']['name'][$g].'</div>';
                     }
                  }//if
          
                  if (!in_array('error', $attfileerrchk) && $_FILES['attfile']['name'][$g] != '' ){
                     jimport('joomla.user.helper');
                     $saltpass = JUserHelper::genRandomPassword('5');
                     $attachmentsucc = $_FILES['attfile']['name'][$g];
                     $attachmentsname = date('Y-m-d-H-i-s-').$saltpass.'-'.str_replace(' ','-',$_FILES['attfile']['name'][$g]);
                     $attachments[] = $artuplpfad.$attachmentsname;
                     $attachmentstodb[] = $attachmentsname;
                     move_uploaded_file($_FILES['attfile']['tmp_name'][$g],$artuplpfad.$attachmentsname);
                     $meldung .= '<font style="color:green">'.$attachmentsucc.': '.JText::_( 'ARTF_SUCCESS' ).'</font><br />';
                  }
               }//for - end attachment validation

            }// Upload and Attachment end

            //start of attachment's manditory checker
            if( in_array('error', $attfileerrchk) && $params->get( 'set_att_manditory' ) == '1' ){

               $a_errors[] = '<div class="artforms-error"><br />'.JText::_( 'ARTF_ATTMANDITORY' ).'</div>';

            } else {

               if( $row->allowatt != '0' ){
                  if(@!$_FILES['attfile']) $meldung .= '<div class="artforms-error"><br />'.JText::_( 'ARTF_SENTWOUTFILES' ).'</div>';
               }
               
               // Mailbody
               $subject = $mainframe->getCfg('sitename').': '.stripslashes($formtitle.' - '.$joomlauser);
               $crlf  = '<br />';
	       $hrline = '<hr>';
	       if ($row->html!='1'){
	          $crlf = "\n";
	          $hrline = "-----------------------------------------------";
	       }
               $email_copy_header = JText::_( 'ARTF_EMAILCOPYMAIL' ).$crlf.$crlf;
	       $body  = stripslashes($formtitle.' - '.$joomlauser.'('.$joomlausername.')').$crlf;
               $body .= $hrline.$crlf.$crlf;

               if($mail_data){
                  foreach($mail_data as $data_name => $data){
                     $body .= $data_name.': ';
                     if(is_array($data)){
                        $body .= $crlf;
                        $d2 = '';
	                foreach($data as $d){
		           $d2 .= $d;
	                }
	                $data = $d2;
	             }
                  $body .= $data.$crlf;
                  $body .= $hrline.$crlf;
                  }
               }
               $body .= JText::_( 'ARTF_MULTI_JUSER' ).': '.$joomlauser.$crlf;
               $body .= JText::_( 'ARTF_MULTI_JUSERNAME' ).': '.$joomlausername.$crlf;
               $body .= JText::_( 'ARTF_MULTI_JUSERIP' ).': '.$joomlauserip.$crlf;
	       $body .= $hrline.$crlf;
               // End Mailbody

	       //Send copy of e-mail to sender
	       $confirm = '';
	       $copyconfirm = '';

               $mail =& JFactory::getMailer();
               
               if( $params->get( 'confirmation_email' ) != '' ){
                  $bodyc = $crlf.JText::_( 'ARTF_CONFIRMATIONEMAILTEXT' ).$crlf;
	          if (JUTility::sendMail($mail->From, $mail->FromName, $params->get( 'confirmation_email' ), $subject,
	 				$bodyc, ($row->html=='1'), null, null, null)){
                     $copyconfirm = '';
	          } else {
	             $confirm = '';
	          }
               }
               
               if ( $row->emailfield != '0' && JArrayHelper::getValue( $_POST, 'email_copy', '' ) == '1'  && isset( $email_copy_to_sender ) ){
	          if (JUTility::sendMail($mail->From, $mail->FromName, $email_copy_to_sender[0], $subject,
	 				$email_copy_header.$body, ($row->html=='1'), null, null,
	 				($attachments) ? $attachments:null)){
                     $copyconfirm = JText::_( 'ARTF_EMAILCOPYSENDED' );
	          } else {
	             $confirm = '<div class="artforms-error">'.JText::_( 'ARTF_MAILSENDERERRORCOPY' ).'</div>';
                  }
	       }

	       if (JUTility::sendMail($mail->From, $mail->FromName, $row->email, $subject, $body, ($row->html=='1'),
	 			 ($row->ccmail) ? $row->ccmail : null, ($row->bccmail) ? $row->bccmail : null, 
	 			 ($attachments) ? $attachments : null)){

	          $confirm = '<div id="artforms-text">'.$row->danktext.'<br />'.$copyconfirm.'</div>';
	       } else {
	          $confirm = '<div class="artforms-error">'.JText::_( 'ARTF_MAILSENDERERROR' ).'<br />'.$confirm.'</div>';
	       }
        
	       //Delete upload file?
	       if ( $afcfg_attfilesave != '1' && isset($_FILES['attfile']['name'])){
                  for ( $g='0'; $g < $attfilescount; $g++ ) {
                     unlink ( $attachments[$g] );
                  }
               }
            }//end of attachment's manditory checker
            
         }//End of if(count($a_errors) == 0)


         if ($afcfg_dbsaveforms == '1' && count($a_errors) == 0 ){

            $itemname_todb = $itemname_todb.'ARTFJUSER;ARTFJUSERNAME;ARTFJUSERIP';
            $itemdata_todb = $itemdata_todb.$joomlauser.';'.$joomlausername.';'.$joomlauserip;
            if ($params->get( 'show_newsletter_system' ) != '0' && $params->get( 'show_newsletter_system' ) != '' && JArrayHelper::getValue( $_POST, 'afnewsletter' ) == '1' ){
               $itemname_todb = $itemname_todb.';ARTFNLYES';
               $itemdata_todb = $itemdata_todb.';'.JText::_( 'ARTF_MULTI_YES' );
            }
            if( is_array($attachmentstodb) ){
               $itemname_todb = $itemname_todb.';ARTFATTACHFILE';
               $itemdata_todb = $itemdata_todb.';'.implode('|', $attachmentstodb);
            }
            $db =& JFactory::getDBO();
            saveDBForms( $db, $option, $itemname_todb, $itemdata_todb, $formtitle, $formid );

         }
         if ($params->get( 'show_newsletter_system' ) != '0' && $params->get( 'show_newsletter_system' ) != '' && count($a_errors) == 0 && JArrayHelper::getValue( $_POST, 'afnewsletter' ) == '1' ){
            $afgetuser = $joomlausername;
            if( $afgetuser == JText::_( 'ARTF_ANONYMOUS' ) || $afgetuser == '' )$afgetuser = JArrayHelper::getValue( $_POST, 'item_'.$items[0]->item_id );
            afMakeNewsletterBridgeToDB( $params->get( 'show_newsletter_system' ), ($user->id) ? $user->id : '0', $afgetuser, $email_copy_to_sender[0]  );
         }
         if ( $params->get( 'use_redirect_url' ) == '1' && $params->get( 'redirect_url' ) != '' && count($a_errors) == 0 ){
            $mainframe->redirect( $params->get( 'redirect_url' ) );
         }

      } //end of do send

      if(isset($confirm)) {
         if ($meldung!='') {
	    $html .= $meldung;
         }
         if ($meldung2!='') {
	    $html .= $meldung2;
         }
         foreach($a_errors as $error){
            $html .= $error;
	 }
         $html .= $confirm;
      } else {

         if(count($a_errors) != 0){
            foreach($a_errors as $error){
               $html .= $error;
	    }
	 }

         $html .= '<div id="artforms-text">'.$row->text.'</div>';
         
         $actionURL = JRoute::_( $alink.'&formid='.$formid.'&Itemid='.(int)$Itemid );

         if ( $row->customjscode != '' ){

            $htmlh = '<script type="text/javascript">';
               $customjscode = urldecode( $row->customjscode );
               if( get_magic_quotes_gpc()) {
                 $customjscode = stripcslashes($customjscode);
               }
               $customjscode = str_replace("&lt;","<",$customjscode);
	       $customjscode = str_replace("&gt;",">",$customjscode);
               $htmlh .= $customjscode;
            $htmlh .= '</script>';
            $mainframe->addCustomHeadTag( $htmlh );

         }

         afHitCounter( $formid );

         $html .= '<div id="artforms-form">';

            if ($row->allowatt=='0'){
               $html .= '<form method="post" name="ArtForms" id="ArtForms" action="'.$actionURL.'">';
            } else {
               $html .= '<form method="post" name="ArtForms" id="ArtForms" enctype="multipart/form-data" action="'.$actionURL.'">
                         <input type="hidden" name="MAX_FILE_SIZE" value="'.($row->allowattfilesize * 1024).'" />';
            }
            $html .= '<input type="hidden" name="afversion" value="ArtForms '.afVersion().'" />
                      <input type="hidden" name="formid" value="'.$row->id.'" />
                      <input type="hidden" name="do" value="send" />
                      <input type="hidden" name="formtitle" value="'.$row->titel.'" />
                      <input type="hidden" name="joomlauser" value="'.$user->name.'" />
                      <input type="hidden" name="joomlausername" value="'.$user->username.'" />
                      <input type="hidden" name="joomlauserip" value="'.$_SERVER['REMOTE_ADDR'].'" />';
            //(?) check
            $ARTF_req  = '';
            $ARTF_datejs  = '';

            foreach($items as $item){

               $ARTF_req .= $item->required.',';
               $ARTF_datejs .= $item->type.',';

               $fieldname = afMakeFieldName( $item, $a_error_ids );
               $thefield = afMakeField( $item, $row->html, $row->afeditor );
               $asterisk = afCheckFieldReq( $item->required, $afcfg_asteriskimg );
               $html .= afPerformFields( $item->layout, $fieldname, $thefield, $asterisk );

            }
            
            $html .= afMakeNewsletterBridge( $params->get( 'show_newsletter_system' ) );
            
            $html .= afDoAttachmentsInForm ( $row->allowatt, $params->get( 'set_att_manditory' ), $afcfg_asteriskimg, $params->get( 'limit_attachs' ) );

            $html .= afEmailCopy( $row->emailfield );

            $html .= afDoCaptchasInForm( $row->seccode );
	    
            $html .= afShowRequirer( $ARTF_req, $afcfg_asteriskimg );

            $ARTF_datejs = substr($ARTF_datejs,0,-1);
	    $ARTF_datejs = explode(',', $ARTF_datejs);
            if (in_array('7', $ARTF_datejs)){
               afLoadCal( JText::_( 'ARTF_EDITORLANG' ) );
            }

            $html .= afShowButtons( $params->get( 'show_reset_button' ) );

         $html .= '</div></form></div><div id="artforms-forminfo">';
         $html .= afAuthor( $row, $params );
         $html .= afCreateDate( $row, $params );
         $html .= afModifiedDate( $row, $params );
         $html .= afBackBtn( $params );
         $html .= '</div>';
      
      }

      echo $html;

   } //End of function ShowFrontArtForms


   function ShowFrontRootForms( $rows, $params, $option ){

      $user	=& JFactory::getUser();
      $rootfronttitle = $params->get( 'rootfronttitle' );
      $fronttext = urldecode( $params->get( 'fronttext' ) );

      if( get_magic_quotes_gpc())$fronttext = stripcslashes($fronttext);

      echo '<div class="componentheading">
           '.$rootfronttitle.'
           </div>';
      echo '<div style="text-align:left;">
           '.$fronttext.'
           </div>';
      echo '<div style="font-size:12px;text-align:left;line-height:16px;"><ul>';

      if(isset($rows)){
         foreach ($rows as $row){
             if( $row->published == '1' && $row->access <= (int) $user->get('aid', 0) ) {
                $_Itemid = afGetItemid( $row->id );
                echo '<li><a href="'.JRoute::_( 'index.php?option='.$option.'&formid='.$row->id.($_Itemid ? '&Itemid='.$_Itemid : '&Itemid=99999') ).'">'.$row->titel.'</a></li>';
             }
         }
      }
      echo '</ul></div>';
 
   }
 
 
   function ShowFrontRecivedForms( $rows, $pageNav, $option ){

      global $mainframe;
      afLoadHSJS();
      echo '<div class="componentheading">'.JText::_( 'ARTF_MENU_RFORMS' ).'</div>';
      ?>
      <form action="index.php?option=com_artforms&task=ferforms" method="post" name="adminForm">
         <table width="100%" border="0" cellpadding="4" cellspacing="0" class="adminlist">
            <tr>
               <th width="15">#</th>
               <th width="70">
                  <?php echo JText::_( 'ARTF_FERFORMS_DATE' ); ?>
               </th>
               <th>
                  <?php echo JText::_( 'ARTF_FERFORMS_FORMTITLE' ); ?>
               </th>
               <th>
                  <?php echo JText::_( 'ARTF_FERFORMS_JUSER' ); ?>
               </th>
               <th>
                  <?php echo JText::_( 'ARTF_FERFORMS_FIRSTFIELD' ); ?>
               </th>
               <th>
                  <?php echo JText::_( 'ARTF_FERFORMS_SECONDFIELD' ); ?>
               </th>
               <th>
                  <?php echo JText::_( 'ARTF_FERFORMS_EMAIL' ); ?>
               </th>
            </tr>
            <?php
	    $k = 0;
            for ($i=0, $n=count( $rows ); $i < $n; $i++) {
               $row = $rows[$i];
               $link = 'index2.php?option=com_artforms&task=vferforms&id='.$row->id;
               $item_name = explode(";", $row->item_name);
               $item_data = explode(";", $row->item_data);
               ?>
               <tr class="<?php echo "row$k"; ?>">
                  <td>
                     <?php echo $pageNav->rowNumber( $i ); ?>
                  </td>
                  <td width="70">
                     <?php echo $row->form_date; ?>
                  </td>
                  <td>
                     <?php echo "<a href=\"".JRoute::_( $link."&no_html=1&no_affoo=1&afjcss=1" )."\" onclick=\"return hs.htmlExpand(this, { contentId: 'highslide-html', objectType: 'iframe', objectWidth: 700, objectHeight: 900} )\" class=\"highslide\">".$row->title."</a>";?>
                  </td>
                  <td>
                     <?php echo $item_data[array_search('ARTFJUSER', $item_name)];?>
                  </td>
                  <td>
                     <?php
                     if( !empty( $item_data[0] ) ){
                        if(strrchr( $item_data[0], '@')){
                           echo '<img src="'.AFPATH_WEB_LIB_ADM_SITE.'af.lib.hideemail.php?r=100&g=150&b=0&text='.base64_encode(strip_tags($item_data[0])).'">';
		        } else {
                           echo strip_tags($item_data[0]);
		        }
                     } else {
                        echo '-';
                     }
                     ?>
                  </td>
                  <td>
                     <?php
                     if( !empty( $item_data[1] ) ){
                        if(strrchr( $item_data[1], '@')){
                           echo '<img src="'.AFPATH_WEB_LIB_ADM_SITE.'af.lib.hideemail.php?r=100&g=150&b=0&text='.base64_encode(strip_tags($item_data[1])).'">';
		        } else {
                           echo strip_tags($item_data[1]);
		        }
                     } else {
                        echo '-';
                     }
                     ?>
                  </td>
                  <td>
                  <?php
                     foreach ($item_data as $itd){
                        if (strrchr($itd, '@')){
                           $item_email = array();
                           for ($j=0;$j < count($item_data); $j++ ){
                              $item_email[$j] = $itd;
                           }
                           if( !empty( $itd ) ){
                              echo '<img src="'.AFPATH_WEB_LIB_ADM_SITE.'af.lib.hideemail.php?r=100&g=150&b=0&text='.base64_encode($item_email[0]).'">';
                           } else {
                              echo '-';
                           }
                        }
                     }
                  ?>
                  </td>
               </tr>
               <?php
               $k = 1 - $k;
            }
            ?>
         </table>
         <?php echo $pageNav->getListFooter(); ?>
         <input type="hidden" name="option" value="<?php echo $option;?>" />
         <input type="hidden" name="task" value="ferforms" />
      </form>
      <?php
      afLoadHSDivs();

   }


   function ShowFrontViewRecivedForms( $row, $option ){

      global $mainframe;
      
      require( AFPATH_ADM_SITE.'config.artforms.php' );
      afLoadLib ( 'attfiles' );

      $subtask = JArrayHelper::getValue( $_GET, 'subtask' );
      switch ( $subtask ) {
          case 'dattach':

              $nfile = JArrayHelper::getValue( $_GET, 'dattachfile' );
              afDLFileFromRForms ( $nfile );

          break;

          default:

           $item_name = explode(";", $row->item_name);
           $item_data = explode(";", $row->item_data);

           if( JArrayHelper::getValue( $_GET, 'afjcss' ) == '1' ){
              afLoadVRAdmCSS();
              afLoadCurrentFETplCSS();
           }

           echo '<p></p><div class="componentheading">'.JText::_( 'ARTF_MENU_RFORMS' ).'</div>';
           ?>
                 <table width="100%" border="0" cellpadding="4" cellspacing="4" class="adminlist">
                    <tr>
			<th colspan="2"><?php echo JText::_( 'ARTF_RFORMS_FORMTITLE' ).': '.$row->title; ?></th>
                    </tr>
                    <tr>
			<td colspan="2" align="right"><?php echo $row->form_date; ?></td>
                    </tr>
                    <?php
                    for($i=0; $i < count( $item_name ); $i++) {

                       if ( $item_name[$i] == 'ARTFJUSER' ){
                           echo '<tr>
			           <td align="right"><strong>'.JText::_( 'ARTF_MULTI_JUSER' ).':</strong></td>
			           <td align="left">'.$item_data[$i].'</td>
		                </tr>';
                       } elseif ( $item_name[$i] == 'ARTFJUSERNAME' ){
                           echo '<tr>
			           <td align="right"><strong>'.JText::_( 'ARTF_MULTI_JUSERNAME' ).':</strong></td>
			           <td align="left">'.$item_data[$i].'</td>
		                </tr>';
                       } elseif ( $item_name[$i] == 'ARTFJUSERIP' ){
                           echo '<tr>
			           <td align="right"><strong>'.JText::_( 'ARTF_MULTI_JUSERIP' ).':</strong></td>
			           <td align="left">'.$item_data[$i].'</td>
		                </tr>';
		       } elseif ( $item_name[$i] == 'ARTFNLYES' ){
                           echo '<tr>
			           <td align="right"><strong>'.JText::_( 'ARTF_RFORMS_USERSUBSCNL' ).':</strong></td>
			           <td align="left">'.$item_data[$i].'</td>
		                </tr>';
		       } elseif ( $item_name[$i] == 'ARTFATTACHFILE' && $item_data[$i] == '' ){
		       
                       } elseif ( $item_name[$i] == 'ARTFATTACHFILE' && $item_data[$i] != '' && $afcfg_showattinvferforms  != '1' ){

                       } elseif ( $item_name[$i] == 'ARTFATTACHFILE' && $item_data[$i] != '' && $afcfg_showattinvferforms  == '1' ){

                          $dlink = $mosConfig_live_site.'/index2.php?option=com_artforms&task=vferforms&subtask=dattach&id='.$row->id.'&no_html=1&no_affoo=1';
                          $dattachfiles = explode('|', $item_data[$i]);

                          if( $afcfg_att_path != '' && is_dir(JPATH_SITE.DS.$afcfg_att_path) ){
                             $dattachfilepath = JPATH_SITE.DS.$afcfg_att_path;
                          } else {
                             $dattachfilepath = AFPATH_ATTACHS_SITE;
                          }

                          foreach($dattachfiles as $dattachfile){
                             echo '<tr>
			              <td align="right">
                                         <strong>'.JText::_( 'ARTF_MULTI_ATTACHFILE' ).':</strong>
                                      </td>
			              <td align="left">
                                         <a href="'.JRoute::_( $dlink.'&dattachfile='.$dattachfile ).'">'.$dattachfile.'</a> ( '.afGetFileSize( filesize( $dattachfilepath.$dattachfile ) ).' )
                                      </td>
		                   </tr>';
		          }
		          
                       } else {

                          if(strrchr( $item_data[$i], '@')){
                             echo '<tr>
			              <td align="right"><strong>'.$item_name[$i].':</strong></td>
			              <td align="left"><img src="'.$mosConfig_live_site.'/administrator/components/com_artforms/lib/af.lib.hideemail.php?r=100&g=150&b=0&text='.base64_encode($item_data[$i]).'"></td>
		                   </tr>';
		          } else {

                             echo '<tr>
			              <td align="right"><strong>'.$item_name[$i].':</strong></td>
                                      <td align="left">'.$item_data[$i].'</td>
		                   </tr>';
		          
		          }
		                
                       }
		    }
                    echo '</table>';

          break;
      }

   }
   

   function ShowFrontTableRecivedForms( $rows, $pageNav, $option ){

      global $mainframe;

      require( AFPATH_ADM_SITE.'config.artforms.php' );
      afLoadLib ( 'attfiles' );
      
      $subtask = JArrayHelper::getValue( $_GET, 'subtask' );
      switch ( $subtask ) {
          case 'dattach':

              $nfile = JArrayHelper::getValue( $_GET, 'dattachfile' );
              afDLFileFromRForms ( $nfile );

          break;

          default:
          
      echo '<div class="componentheading">'.JText::_( 'ARTF_MENU_RFORMS' ).'</div>';
      ?>
      <div style="">
      <form action="index.php?option=com_artforms&task=tferforms" method="post" name="adminForm">
         <table width="100%" border="0" cellpadding="4" cellspacing="0" class="adminlist">
            <tr>
               <th width="15" valign="top">#</th>
               <th width="70" valign="top">
                  <?php echo JText::_( 'ARTF_FERFORMS_DATE' ); ?>
               </th>
               <th valign="top">
                  <?php echo JText::_( 'ARTF_FERFORMS_FORMTITLE' ); ?>
               </th>
               <th valign="top">
                  <?php echo JText::_( 'ARTF_FERFORMS_JUSER' ); ?>
               </th>
               <th valign="top">
                  <?php echo JText::_( 'ARTF_FERFORMS_EMAIL' ); ?>
               </th>
               <th valign="top">
                  <?php echo JText::_( 'ARTF_FERFORMS_FIELDS' ); ?>
               </th>
            </tr>
            <?php
	    $k = 0;
            for ($i=0, $n=count( $rows ); $i < $n; $i++) {
               $row = $rows[$i];
               $item_name = explode(";", $row->item_name);
               $item_data = explode(";", $row->item_data);
               ?>
               <tr class="<?php echo "row$k"; ?>">
                  <td valign="top">
                     <?php echo $pageNav->rowNumber( $i ); ?>
                  </td>
                  <td width="70" valign="top">
                     <?php echo $row->form_date; ?>
                  </td>
                  <td valign="top">
                     <?php echo $row->title;?>
                  </td>
                  <td valign="top">
                     <?php echo $item_data[array_search('ARTFJUSER', $item_name)];?>
                  </td>
                  <td valign="top">
                  <?php
                     foreach ($item_data as $itd){
                        if (strrchr($itd, '@')){
                           $item_email = array();
                           for ($j=0;$j < count($item_data); $j++ ){
                              $item_email[$j] = $itd;
                           }
                           if( !empty( $itd ) ){
                              echo '<img src="'.AFPATH_WEB_LIB_ADM_SITEe.'af.lib.hideemail.php?r=100&g=150&b=0&text='.base64_encode($item_email[0]).'">';
                           } else {
                              echo '-';
                           }
                        }
                     }
                  ?>
                  </td>
                  <td valign="top">
                    <div style="overflow:auto;">
                     <table width="100%" border="0" cellpadding="4" cellspacing="0" class="adminlist">
                     <?php
                     for ($j=0, $m=count( $item_data ); $j < $m; $j++) {
                       if ( $item_name[$j] == 'ARTFJUSER' ){
                           echo '<tr>
			           <td align="right"><strong>'.JText::_( 'ARTF_MULTI_JUSER' ).':</strong></td>
			           <td align="left">'.$item_data[$j].'</td>
		                </tr>';
                       } elseif ( $item_name[$j] == 'ARTFJUSERNAME' ){
                           echo '<tr>
			           <td align="right"><strong>'.JText::_( 'ARTF_MULTI_JUSERNAME' ).':</strong></td>
			           <td align="left">'.$item_data[$j].'</td>
		                </tr>';
                       } elseif ( $item_name[$j] == 'ARTFJUSERIP' ){
                           echo '<tr>
			           <td align="right"><strong>'.JText::_( 'ARTF_MULTI_JUSERIP' ).':</strong></td>
			           <td align="left">'.$item_data[$j].'</td>
		                </tr>';
		       } elseif ( $item_name[$j] == 'ARTFNLYES' ){
                           echo '<tr>
			           <td align="right"><strong>'.JText::_( 'ARTF_RFORMS_USERSUBSCNL' ).':</strong></td>
			           <td align="left">'.$item_data[$j].'</td>
		                </tr>';
		       } elseif ( $item_name[$j] == 'ARTFATTACHFILE' && $item_data[$j] == '' ){

                       } elseif ( $item_name[$j] == 'ARTFATTACHFILE' && $item_data[$j] != '' && $afcfg_showattinvferforms  != '1' ){

                       } elseif ( $item_name[$j] == 'ARTFATTACHFILE' && $item_data[$j] != '' && $afcfg_showattinvferforms  == '1' ){

                          $dlink = $mosConfig_live_site.'/index2.php?option=com_artforms&task=tferforms&subtask=dattach&id='.$row->id.'&no_html=1&no_affoo=1';
                          $dattachfiles = explode('|', $item_data[$j]);

                          if( $afcfg_att_path != '' && is_dir(JPATH_SITE.DS.$afcfg_att_path) ){
                             $dattachfilepath = JPATH_SITE.DS.$afcfg_att_path;
                          } else {
                             $dattachfilepath = AFPATH_ATTACHS_SITE;
                          }

                          foreach($dattachfiles as $dattachfile){
                             echo '<tr>
			              <td align="right">
                                         <strong>'.JText::_( 'ARTF_MULTI_ATTACHFILE' ).':</strong>
                                      </td>
			              <td align="left">
                                         <a href="'.JRoute::_( $dlink.'&dattachfile='.$dattachfile ).'">'.$dattachfile.'</a> ( '.afGetFileSize( filesize( $dattachfilepath.$dattachfile ) ).' )
                                      </td>
		                   </tr>';
		          }

                       } else {

                          if(strrchr( $item_data[$j], '@')){
                             echo '<tr>
			              <td align="right"><strong>'.$item_name[$j].':</strong></td>
			              <td align="left"><img src="'.AFPATH_WEB_LIB_ADM_SITE.'af.lib.hideemail.php?r=100&g=150&b=0&text='.base64_encode($item_data[$j]).'"></td>
		                   </tr>';
		          } else {

                             echo '<tr>
			              <td align="right"><strong>'.$item_name[$j].':</strong></td>
                                      <td align="left">'.$item_data[$j].'</td>
		                   </tr>';

		          }

                       }
		     }
                     ?>
                     </table>
                    </div>
                  </td>
               </tr>
               <?php
               $k = 1 - $k;
            }
            ?>
         </table>
         <?php echo $pageNav->getListFooter(); ?>
         <input type="hidden" name="option" value="<?php echo $option;?>" />
         <input type="hidden" name="task" value="tferforms" />
      </form>
      </div>
      <?php
      }
      
   }
   
   
}

?>
