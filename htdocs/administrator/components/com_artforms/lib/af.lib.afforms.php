<?php
/**
* @version $Id: af.class.afforms.php v.2.1b7 2007-12-16 02:45:59Z GMT-3 $
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


function stripData( $data ){

   return ini_get('magic_quotes_gpc') ? stripslashes($data) : $data;

}


function afRadioList( &$arr, $tag_name, $tag_attribs, $selected=null, $key='value', $text='text' ){

     reset( $arr );
     $html = "";
     for ($i=0, $n=count( $arr ); $i < $n; $i++ )
     {
	$k = $arr[$i]->$key;
	$t = $arr[$i]->$text;
	$id = isset($arr[$i]->id) ? $arr[$i]->id : null;
	$extra = '';
	$extra .= $id ? " id=\"" . $arr[$i]->id . "\"" : '';
	if (is_array( $selected ))
        {
           foreach ($selected as $obj)
           {
	      $k2 = $obj->$key;
              if ($k == $k2)
              {
	         $extra .= " checked=\"checked\"";
	         break;
	      }
	   }
        } else {
	   $extra .= ($k == $selected ? " checked=\"checked\"" : '');
	}
	   $html .= "\n\t<input type=\"radio\" name=\"$tag_name\" value=\"".$k."\"$extra $tag_attribs />" . $t . "<br />\n";
     }
     $html .= "\n";
     return $html;
     
}


function afCheckboxList( &$arr, $tag_name, $tag_attribs, $selected=null, $key='value', $text='text' ){

     reset( $arr );
     $html = "";
     $tagNcount = "0";
     for ($i=0, $n=count( $arr ); $i < $n; $i++ )
     {
        $k = $arr[$i]->$key;
        $t = $arr[$i]->$text;
        $id = isset($arr[$i]->id) ? $arr[$i]->id : null;
	$extra = '';
	$extra .= $id ? " id=\"" . $arr[$i]->id . "\"" : '';
	if (is_array( $selected ))
        {
	   foreach ($selected as $obj)
           {
	      $k2 = $obj->$key;
	      if ($k == $k2)
              {
		 $extra .= " checked=\"checked\"";
		 break;
	      }
	   }
	} else {
	   $extra .= ($k == $selected ? " checked=\"checked\"" : '');
	}

	$tag_n=$tag_name.'['.$tagNcount.']';
	$html .= "\n\t<input type=\"checkbox\" name=\"$tag_n\" value=\"".$k."\" $extra $tag_attribs />" . $t . "<br />";
	$tagNcount=$tagNcount+1;
     }

     $html .= "\n";
     return $html;
     
}


function afSelectList( &$arr, $tag_name, $tag_attribs, $key, $text, $selected=NULL ){

     reset( $arr );
     $html = "\n<select name=\"$tag_name\" $tag_attribs>";
     for ($i=0, $n=count( $arr ); $i < $n; $i++ )
     {
        $k = $arr[$i]->$key;
        $t = $arr[$i]->$text;
        if ( 'class="inputbox" size="1"' === $tag_attribs ){
        $value = $t;
        } else {
        $value = $k;
        }
        $id = isset($arr[$i]->id) ? $arr[$i]->id : null;
        $extra = '';
        $extra .= $id ? " id=\"" . $arr[$i]->id . "\"" : '';
        if (is_array( $selected ))
        {
           foreach ($selected as $obj)
           {
              $k2 = $obj->$key;
              if ($k == $k2)
              {
                 $extra .= " selected=\"selected\"";
                 break;
              }
           }
	} else {
           $extra .= ($k == $selected ? " selected=\"selected\"" : '');

        }
        $html .= "\n\t<option value=\"".$value."\"$extra>" . $t . "</option>";
     }
     $html .= "\n</select>\n";
     return $html;

}


function validate_email( $email ){

   $regExp="^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,4})$";
   if (ereg($regExp, $email)){
      return true;
   }
   return false;
     
}


function afHitCounter( $formid ){

   $db =& JFactory::getDBO();
   $db->setQuery("UPDATE #__artforms SET hits=hits+1 WHERE id=".$formid );
   $db->query();
      
}
   
   
function saveDBForms( &$db, $option, $name, $data, $formtitle, $formid ) {

   require_once( AFPATH_ADM_SITE.'artforms.class.php' );

   $row = new mosartforms_inbox( $db );

   $date_time = date( JText::_( 'ARTF_DATETIME' ) );

   $row->title     = $formtitle;
   $row->form_id   = $formid;
   $row->item_name = $name;
   $row->item_data = $data;
   $row->form_date = $date_time;

   // Bind the varibales submitted to the row
   if (!$row->bind( $_POST )) {
      return $db->getErrorMsg();
   }

   // Set the primary key of the table
   $row->_tbl_key = "id";

   if (!$row->store()) {
      return $db->getErrorMsg();
   }

   return NULL;

}


function afCreateDate( &$row, &$params ) {

   $create_date = null;
   $create_date = JHTML::_('date', $row->created );

   if ( $params->get( 'show_created_date' ) && intval( $row->created ) != 0 ) {

      $html = '<div align="right" class="createdate">
	       '.$create_date.'
	       </div>';
      return $html;

   } else {

      return;

   }
   
}
	
	
function afModifiedDate( &$row, &$params ) {

   $mod_date = null;
   if( intval( $row->modified ) != 0)$mod_date = JHTML::_('date', $row->modified );

   if ( ( $mod_date != '' ) && $params->get( 'show_modif_date' ) ) {

      $html = '<div align="right" class="modifydate">
	       '.JText::_( 'LAST UPDATED').' ( '.$mod_date.' )
	       </div>';
      return $html;

   } else {

      return;

   }
   
}


function afAuthor( &$row, &$params ) {

   if ( ( $params->get( 'show_author' ) ) && ( $row->author != '' ) ) {

      $html = '<div align="right">
               <span class="small">
               '.JText::_( 'WRITTEN BY'). ' '.( $row->created_by_alias ? $row->created_by_alias : $row->author ).'
               </span>
               </div>';
      return $html;

   } else {

      return;

   }
   
}


function afBackBtn( &$params ) {

   if( $params->get( 'show_back_button' ) == '1' ){

      $html = '<br />
               <div class="back_button">
               <a href="javascript:history.go(-1)">'.JText::_( 'BACK').'</a>
               </div><br />';
      return $html;
      
   } else {
   
      return;
      
   }
  
}


function afMakeFieldName( $item, $a_error_ids='' ) {

   if( $item->type == '8' || $item->type == '10' ) return;

   $fieldname = '';
   
   if(in_array($item->item_id, $a_error_ids))$fieldname .= '<div class="artforms-errorftxt">';
   $fieldname .= '<div class="affieldname">'.$item->name.': </div>';
   if(in_array($item->item_id, $a_error_ids))$fieldname .= '</div>';
   
   return $fieldname;
	        
}


function afMakeField( $item, $rowhtml='0', $afhtmleditor='tinymce_light' ) {

   $value = '';
   if( $item->readonly == '1' ) {
      $readonly = ' readonly="true"';
   } else {
      $readonly = '';
   }
   if( $item->customcode != '' ) {
      $customcode = ' '.$item->customcode;
   } else {
      $customcode = '';
   }
   $item->values = str_replace("&lt;","<",$item->values);
   $item->values = str_replace("&gt;",">",$item->values);
   $item->default_values = str_replace("&lt;","<",$item->default_values);
   $item->default_values = str_replace("&gt;",">",$item->default_values);
   
   switch ( $item->type ) {

      case '1': //Input Field
         if(isset($_POST['item_'.$item->item_id])){
            $value = $_POST['item_'.$item->item_id];
         } else {
            $value = $item->default_values;
         }
         $field = '<input type="text" class="inputbox" name="item_'.$item->item_id.'" size="35" maxlength="70" value="'.$value.'"'.$readonly.$customcode.' />';
         return $field;
      break;

      case '2': //Textarea - With editor in case of html mode
         $field = '';
         if ($rowhtml=='1'){
            $field .= '<div align="center" class="artformstextarea-html">';
            if(isset($_POST['item_'.$item->item_id])){
               $value = $_POST['item_'.$item->item_id];
            } else {
               $value = $item->default_values;
            }
            include(AFPATH_ASSETS_SITE.'editors'.DS.$afhtmleditor.'.php');
            $field .= '<textarea align="center" class="inputboxhtml" name="item_'.$item->item_id.'" id="item_'.$item->item_id.'" cols="60" rows="15"'.$readonly.$customcode.'>'.$value.'</textarea>';
            $field .= afHtmlEditor( JText::_( 'ARTF_EDITORLANG' ), JText::_( 'ARTF_LANGDIRECTION'), 'item_'.$item->item_id );
            $field .= '</div>'.JText::_( 'ARTF_HTMLON' );
         } else {
            $field .= '<div align="center" class="artformstextarea-txt">
                          <textarea align="center" class="inputboxtxt" name="item_'.$item->item_id.'" cols="40" rows="10"'.$readonly.$customcode.'>'.$value.'</textarea>
                       </div>';
         }
         return $field;
      break;
      
      case '3': //List
         $item_values = array();
         $item_default_values = array();
         if($item->values!=''){
            $tmp = explode(';', $item->values);
            $tmp_default = explode(';', $item->default_values);
            foreach($tmp as $key => $tmp_item){
               $item_values[] = JHTML::_('select.option', $key, $tmp_item);
               if(isset($_POST['do']) && isset($_POST['item_'.$item->item_id])){
                  $posted_value = $_POST['item_'.$item->item_id];
                  if(is_array($posted_value)){
                     if(in_array($key, $posted_value))$item_default_values[] = JHTML::_('select.option', $key, $tmp_item );
                  } else {
                     if($key == $posted_value)$item_default_values[] = JHTML::_('select.option', $key, $tmp_item );
                  }
               } else {
                  if(in_array($tmp_item, $tmp_default))$item_default_values[] = JHTML::_('select.option', $key, $tmp_item );
               }
            }
         }
	 $html_attr = "\n\n";
	 $field = afRadioList( $item_values, 'item_'.$item->item_id, $html_attr, $item_default_values, 'value', 'text');
         return $field;
      break;
      
      case '4': //Checkbox
         $item_values = array();
         $item_default_values = array();
         if($item->values!=''){
            $tmp = explode(';', $item->values);
            $tmp_default = explode(';', $item->default_values);
            foreach($tmp as $key => $tmp_item){
               $item_values[] = JHTML::_('select.option', $key, $tmp_item);
               if(isset($_POST['do']) && isset($_POST['item_'.$item->item_id])){
                  $posted_value = $_POST['item_'.$item->item_id];
                  if(is_array($posted_value)){
                     if(in_array($key, $posted_value))$item_default_values[] = JHTML::_('select.option', $key, $tmp_item );
                  } else {
                     if($key == $posted_value)$item_default_values[] = JHTML::_('select.option', $key, $tmp_item );
                  }
               } else {
                  if(in_array($tmp_item, $tmp_default))$item_default_values[] = JHTML::_('select.option', $key, $tmp_item );
               }
            }
         }
         $html_attr = "\n\n";
         $field = afCheckboxList( $item_values, 'item_'.$item->item_id, $html_attr, $item_default_values, 'value', 'text');
         return $field;
      break;
      
      case '5': //Dropdown - Simple
         $item_values = array();
         $item_default_values = array();
         if($item->values!=''){
            $tmp = explode(';', $item->values);
            $tmp_default = explode(';', $item->default_values);
            foreach($tmp as $key => $tmp_item){
               $item_values[] = JHTML::_('select.option', $key, $tmp_item);
               if(isset($_POST['do']) && isset($_POST['item_'.$item->item_id])){
                  $posted_value = $_POST['item_'.$item->item_id];
                  if(is_array($posted_value)){
                     if(in_array($key, $posted_value))$item_default_values[] = JHTML::_('select.option', $key, $tmp_item );
                  } else {
                     if($key == $posted_value)$item_default_values[] = JHTML::_('select.option', $key, $tmp_item );
                  }
               } else {
                  if(in_array($tmp_item, $tmp_default))$item_default_values[] = JHTML::_('select.option', $key, $tmp_item );
               }
            }
         }
         $html_attr = 'class="inputbox" size="1"';
         $field = afSelectList( $item_values, 'item_'.$item->item_id, $html_attr, 'value', 'text', $item_default_values);
         return $field;
      break;
      
      case '6': //Dropdown - Multiple
         $item_values = array();
         $item_default_values = array();
         if($item->values!=''){
            $tmp = explode(';', $item->values);
            $tmp_default = explode(';', $item->default_values);
            foreach($tmp as $key => $tmp_item){
               $item_values[] = JHTML::_('select.option', $key, $tmp_item);
               if(isset($_POST['do']) && isset($_POST['item_'.$item->item_id])){
                  $posted_value = $_POST['item_'.$item->item_id];
                  if(is_array($posted_value)){
                     if(in_array($key, $posted_value))$item_default_values[] = JHTML::_('select.option', $key, $tmp_item );
                  } else {
                     if($key == $posted_value)$item_default_values[] = JHTML::_('select.option', $key, $tmp_item );
                  }
               } else {
                  if(in_array($tmp_item, $tmp_default))$item_default_values[] = JHTML::_('select.option', $key, $tmp_item );
               }
            }
         }
         $listHeight = '8';
         if(count($item_values)<10)$listHeight = '4';
         
         $html_attr = 'class="inputbox" size="'.$listHeight.'" multiple="multiple"';
         $field = afSelectList( $item_values, 'item_'.$item->item_id.'[]', $html_attr, 'value', 'text', $item_default_values);
         return $field;
      break;
      
      case '7': //Date Field
         if(isset($_POST['item_'.$item->item_id])){
            $value = $_POST['item_'.$item->item_id];
         } else {
            $value = $item->default_values;
         }
         $field = '<div class="artforms-date">
                      <input class="inputbox" type="text" name="item_'.$item->item_id.'" id="item_'.$item->item_id.'" value="'.$value.'" size="10" maxlength="15"'.$readonly.$customcode.' />
		      <input type="reset" class="artforms-button" value="'.JText::_( 'ARTF_DATEBTN').'" onclick="return showCalendar(\'item_'.$item->item_id.'\', \'y-mm-dd\');" />
                   </div>';
         return $field;
      break;
      
      case '8': //HTML Code
	 $field = '<div id="artforms-text">
		      '.$item->default_values.'
		      <input type="hidden" name="item_'.$item->item_id.'" value="-" />
                   </div>';
         return $field;
      break;
      
      case '9': //Textarea -plain text-
         if(isset($_POST['item_'.$item->item_id])){
            $value = $_POST['item_'.$item->item_id];
         } else {
            $value = $item->default_values;
         }
         $field = '<div class="artformstextarea-txt">
                      <textarea class="inputboxtxt" name="item_'.$item->item_id.'" cols="40" rows="10"'.$readonly.$customcode.'>'.$value.'</textarea>
                   </div>';
         return $field;
      break;
      
      case '10': //Hidden Field
         if(isset($_POST['item_'.$item->item_id])){
            $value = $_POST['item_'.$item->item_id];
         } else {
            $value = $item->default_values;
         }
         $field = '<input type="hidden" name="item_'.$item->item_id.'" value="'.$value.'"'.$readonly.$customcode.' />';
         return $field;
      break;
      
      case '11': //Pasword input
         if(isset($_POST['item_'.$item->item_id])){
            $value = $_POST['item_'.$item->item_id];
         } else {
            $value = $item->default_values;
         }
         $field = '<div class="artforms-password">
                      <input type="password" name="item_'.$item->item_id.'" size="35" maxlength="70" value="'.$value.'"'.$readonly.$customcode.' />
                   </div>';
         return $field;
      break;
      
      case '12': //Password input with checker
         if(isset($_POST['item_'.$item->item_id][0])){
            $valuea = $_POST['item_'.$item->item_id][0];
         } else {
            $valuea = $item->default_values;
         }
         if(isset($_POST['item_'.$item->item_id][1])){
            $valueb = $_POST['item_'.$item->item_id][1];
         } else {
            $valueb = $item->default_values;
         }
         $field = '<div class="artforms-password">
                      <input type="password" name="item_'.$item->item_id.'[0]" size="35" maxlength="70" value="'.$valuea.'"'.$readonly.$customcode.' />
                      <br />
                      <input type="password" name="item_'.$item->item_id.'[1]" size="35" maxlength="70" value="'.$valueb.'"'.$readonly.$customcode.' />
                   </div>';
         return $field;
      break;

   }

}


function afCheckFieldReq( $itemreq, $afcfg_asteriskimg='' ) {

   if ( $itemreq == '2' ){

      $asterisk = '&nbsp;&nbsp;<img border="0" src="'.AFPATH_WEB_ASTERISKS_SITE.$afcfg_asteriskimg.'" alt="*" title="" />';
      return $asterisk;

   } else {

      return;

   }

}


function afPerformFields( $itemlayout, $fieldname, $thefield, $asterisk='' ) {

   if($itemlayout == ''){
      $itemlayout = '<div style="margin-left:15px;">
                        <div style="float:left;margin-top:5px;width:100px;">###FIELDNAME###</div>
                        <div style="float:left;margin-top:5px;">###THEFIELD###</div>
                        <div style="float:left;margin-top:5px;">###ASTERISK###</div>
                     </div>
                     <div class="clear"></div>';
   }
   
   $itemlayout = str_replace("&lt;","<",$itemlayout);
   $itemlayout = str_replace("&gt;",">",$itemlayout);
   
   $itemlayout = str_replace( "###FIELDNAME###" , $fieldname, $itemlayout );
   $itemlayout = str_replace( "###THEFIELD###" , $thefield, $itemlayout );
   $itemlayout = str_replace( "###ASTERISK###" , $asterisk, $itemlayout );
                
   return $itemlayout;

}


function afEmailCopy( $checker ) {

   if ( $checker !='0' ){
      $html = '<div id="af-emailcopy">
                  '.JText::_( 'ARTF_EMAILCOPY').'  '.'
		  <input name="email_copy" value="1" type="checkbox" />
               </div>';
      return $html;
   } else {
      return;
   }

}


function afShowRequirer( $reqchecker, $astimg ) {

   global $mosConfig_live_site;
   
   $reqchecker = substr($reqchecker,0,-1);
   $reqchecker = explode(',', $reqchecker);
	           
   if (in_array('2', $reqchecker)){
      $html = '<div id="artforms-reqtext">
                  <img border="0" src="'.AFPATH_WEB_ASTERISKS_SITE.$astimg.'" alt="*" title="" />
                  '.JText::_( 'ARTF_REQINFTEXT').'
               </div>';
      return $html;
   } else {
      return;
   }

}


function afShowButtons( $resetchecker ) {

   $html = '<div id="artforms-buttons" style="width:100%;text-align:center;">
            <input class="artforms-button" type="submit" name="submit" value="'.JText::_( 'ARTF_SEND').'" />';

   if( $resetchecker == '1' ){
      $html .= '   <input class="artforms-button" type="reset" value="'.JText::_( 'ARTF_RESET').'" />';
   }

   $html .= '</div>';

   return $html;

}


function afDoCaptchasInForm( $captchasel ) {

   include( AFPATH_ADM_SITE.'config.artforms.php' );
   
   if( $captchasel == '0' )return;
   
   switch ( $captchasel ) {

      case '1': //adapted alikon captcha

         $html = '<div>';
         require(AFPATH_ASSETS_SITE.'captcha'.DS.'includes'.DS.'alikon'.DS.'captcha.php');
         $captcha = new alikoncaptcha() ;
         $captcha->codelength = $afcfg_captcha_length;
         $html .= $captcha->doViewAF();
         $html .= '</div>';
         return $html;
         
      break;
      
      case '2': //captchaform

         $html = '<div>';
         require(AFPATH_ASSETS_SITE.'captcha'.DS.'includes'.DS.'captchaform'.DS.'captcha.php');
         $html .= doCaptchaFormAF();
         $html .= '</div>';
         return $html;
         
      break;
      
      case '3':  //captchatalk (requiere php extension called ming installed in sever)

         $html = '<div>';
         require(AFPATH_ASSETS_SITE.'captcha'.DS.'includes'.DS.'captchatalk'.DS.'captcha.php');
         $html .= doCaptchaTalkAF( 1 );
         $html .= '</div>';
         return $html;
         
      break;
      
      case '4':  //recaptcha

         $html = '<div align="center">';
         $html .= '<script type="text/javascript">
                     var RecaptchaOptions = {
                        theme : \''.$afcfg_captcha_recapt_theme.'\',
                        tabindex : '.$afcfg_captcha_recapt_tabindex.'
                     };
                  </script>';
         require_once(AFPATH_ASSETS_SITE.'captcha'.DS.'includes'.DS.'recaptcha'.DS.'captcha.php');
         $html .= recaptcha_get_html($afcfg_captcha_recapt_publickey);
         $html .= '</div>';
         return $html;
         
      break;
      
      case '5':  //alikon mambot secure captcha

         if ( JPluginHelper::importPlugin( 'alikonweb' ) ) {
            $mainframe->triggerEvent( 'onView', array( 'com' ) );
         }

      break;
      
      case '6':  //securityimages captcha component

         if (file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_securityimages'.DS.'client.php')) {
            $html = '<div align="center">';
            include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_securityimages'.DS.'client.php');
            $html .= '<div>'.insertSecurityImage("artforms").'</div>';
            $html .= '<div>'.getSecurityImageText("artforms").'</div>';
            $html .= '</div>';
            return $html;
         } else {
            return;
         }

      break;
      
      case '7':  //easycaptcha component

         if(file_exists(JPATH_SITE.DS.'components'.DS.'com_easycaptcha'.DS.'class.easycaptcha.php')) {
            $html = '<div align="center">';
            include_once(JPATH_SITE.DS.'components'.DS.'com_easycaptcha'.DS.'class.easycaptcha.php');
            $captcha = new easyCaptcha();
            $html .= '<input type="hidden" name="captcha_id" value="'.$captcha->getCaptchaId().'" />
                     <img src="'.$captcha->getImageUrl().'" alt="'.$captcha->getAltText().'" /><br /><br />
                     '.JText::_( 'ARTF_CAPTCHA_TITLE').': <input type="text" name="captcha_code" class="easycomments_post_input" />';
            $html .= '</div>';
            return $html;
         } else {
            return;
         }

      break;
      
      default:

         $html = '<div align="center">';
         $html .= JText::_( 'ARTF_CAPTCHA_NOTDEFINED');
         $html .= '</div>';
         return $html;
         
      break;
      
   }
   
   $html .= '</div>';

   return $html;

}


function afMakeNewsletterBridge( $newsletter ) {

   if( $newsletter == '0' || $newsletter == '' )return;
   
   switch ( $newsletter ) {

      case 'letterman': //adapted alikon captcha
         if( file_exists(JPATH_SITE.DS.'components'.DS.'com_letterman'.DS.'letterman.php')) {

            $html = '<div id="afnewsletter">
                        '.JText::_( 'ARTF_SUBSCRIPTTONL').'<br />
                        <input name="afnewsletter" value="1" checked="checked" type="radio">
	                '.JText::_( 'ARTF_MULTI_YES').'
	                <input name="afnewsletter" value="0"type="radio">
	                '.JText::_( 'ARTF_MULTI_NO').'
                     </div>';
            $html .= JArrayHelper::getValue( $_POST, 'afnewsletter' );
            return $html;
      
         } else {
            return;
         }
         
      break;
   
   }

}


function afMakeNewsletterBridgeToDB( $newsletter, $user_id, $user_name, $user_email  ) {

   if( $newsletter == '0' || $newsletter == '' )return;
   $db =& JFactory::getDBO();
   $lang =& JFactory::getLanguage();
   $check_lang = $lang->getBackwardLang();

   switch ( $newsletter ) {

      case 'letterman': //Letterman's Newsletter Component

         if( file_exists( JPATH_SITE.DS.'components'.DS.'com_letterman'.DS.'letterman.php')) {
            require_once( JPATH_SITE.DS.'components'.DS.'com_letterman'.DS.'letterman.class.php');
            $row = new mosLettermanSubscribers($db);
            $row->subscriber_id = '';
 	    $row->user_id = $user_id;
 	    $row->subscriber_name = $user_name;
 	    $row->subscriber_email = $user_email;
	    $row->subscribe_date = date( 'Y-m-d H:i:s' );
            if (!$row->store()) {
                if( !@include( JPATH_ADMINISTRATOR.DS.'administrator'.DS.'components'.DS.'com_letterman'.DS.'language'.DS.$check_lang.'.messages.php' ) ) {
                   include( JPATH_ADMINISTRATOR.DS.'administrator'.DS.'components'.DS.'com_letterman'.DS.'language'.DS.'english.messages.php' );
                }
                echo "<script type=\"text/javascript\"> alert('".JText::_( 'LM_SAME_EMAIL_TWICE')."');</script>\n";
	    }

         }

      break;

   }

}


?>
