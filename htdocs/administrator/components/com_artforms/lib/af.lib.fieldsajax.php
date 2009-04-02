<?php
/**
* @version $Id: af.lib.fieldsajax.php v.2.1b7 2007-11-24 23:59:23Z GMT-3 $
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

function showEditFields( $option, $formid, &$items, &$itlists, $afcfg_usebehelper='0', $afcfg_fieldsdefaultlayout='' ) {

   include( AFPATH_LIB_ADM_SITE.'af.lib.loadhelper.php' );
   afLoadMTMultiAcord();

   $typ = array( '', JText::_('ARTF_FORM_INPUT' ), JText::_('ARTF_FORM_TEXTAREA' ), JText::_('ARTF_FORM_LIST' ), JText::_('ARTF_FORM_CHECKBOX' ), JText::_('ARTF_FORM_DROPDS' ), JText::_('ARTF_FORM_DROPDM' ), JText::_('ARTF_FORM_DATE' ), JText::_('ARTF_FORM_HTMLTEXT' ), JText::_('ARTF_FORM_TEXTAREAPLAIN' ), JText::_('ARTF_FORM_HIDDENINPUT' ), JText::_('ARTF_FORM_PASSWORD' ), JText::_('ARTF_FORM_PASSWORD2' ) );
   $a_typeslist  = JHTML::_('select.genericlist', $itlists['a_types'], 'type[]', 'AFTYPESCHANGE class="text_area" size="1"', 'value', 'text' );
   $a_requlist   = JHTML::_('select.genericlist', $itlists['a_requ'], 'required[]', 'class="text_area" size="1"', 'value', 'text' );
   $a_validlist  = JHTML::_('select.genericlist', $itlists['a_valid'], 'validation[]', 'class="text_area" size="1"', 'value', 'text'  );
   $a_ronlylist  = JHTML::_('select.genericlist', $itlists['a_ronly'], 'readonly[]', 'class="text_area" size="1"', 'value', 'text'  );
   $addFieldx    = JHTML::_('select.genericlist', $itlists['addFieldx'], 'addFieldx', 'id="addFieldx" class="text_area"', 'value', 'text', 'n' );

   $a_typeslistone  = eregi_replace( 'AFTYPESCHANGE', 'id="aftypes1" onChange="javascript:function fieldprevb1(){document.getElementById(\'paftypes1\').innerHTML = document.getElementById(\'aftypes1\').options[document.getElementById(\'aftypes1\').value-1].text;}fieldprevb1();"', $a_typeslist );

   $dolayout = urldecode( $afcfg_fieldsdefaultlayout );
   ?>
   <div class="afadmform">
      <div class="afaftop">
         <div class="afafdiv"><strong><?php echo JText::_('ARTF_FORM_TITLEFIELDS' ); ?></strong></div>
         <div class="afafdiv" width="90px">
            <?php echo '<a href="javascript:void(0);" id="hideall">
            <img src="'.AFPATH_WEB_IMG_ADM_SITE.'hideall.png" width="16" height="16" border="0" alt="'.JText::_('ARTF_FORM_HIDEALL' ).'" class="MTTips" title="'.JText::_('ARTF_FORM_TABFIELDS' ).' :: '.JText::_('ARTF_FORM_HIDEALL' ).'" />
	    </a>'; ?>
            <?php echo '<a href="javascript:void(0);" id="showall">
            <img src="'.AFPATH_WEB_IMG_ADM_SITE.'showall.png" width="16" height="16" border="0" alt="'.JText::_('ARTF_FORM_SHOWALL' ).'" class="MTTips" title="'.JText::_('ARTF_FORM_TABFIELDS' ).' :: '.JText::_('ARTF_FORM_SHOWALL' ).'" />
	    </a>'; ?>
         </div>
      </div>
      <div class="afafclose" >&nbsp;</div>
      <div id="maccordion">
      <?php
      $i=0;

      if ($formid == ''){
         $ordering = '0';
         $i=1;
         echo '<h3 class="toggler atStart">'.JText::_('ARTF_FORM_FIELD' ).' '.$i.' ::  <span id="pafname1">-</span>  ::  <span id="paftypes1">'.JText::_( 'ARTF_FORM_INPUT' ).'</span></h3>
               <input type="hidden" name="form_id[]" value="'.$formid.'" />
               <input type="hidden" name="item_id[]" value="" />
               <div class="element atStart">
                  <div class="affields" width="90px"><div class="affieldstxt">'.JText::_('ARTF_FORM_ORDER').'</div><input class="text_area" type="text" name="item_ordering[]" maxlength="4" style="width:25px;text-align:center;" value="0"/>'.$helper_order.'</div>
                  <div class="affields" width="128px"><div class="affieldstxt">'.JText::_('ARTF_FORM_FIELDNAME').'</div><input class="text_area" type="text" size="20" name="name[]" id="afname1" onkeyup="javascript:function fieldpreva1(){document.getElementById(\'pafname1\').innerHTML = document.getElementById(\'afname1\').value;}fieldpreva1();" value="" />'.$helper_fieldname.'</div>
                  <div class="affields" width="90px"><div class="affieldstxt">'.JText::_('ARTF_FORM_FIELDTYPE').'</div>'.$a_typeslistone.$helper_fieldtype.'</div>
                  <div class="affields" width="90px"><div class="affieldstxt">'.JText::_('ARTF_FORM_REQUIRED').'</div>'.$a_requlist.$helper_required.'</div>
                  <div class="affields" width="90px"><div class="affieldstxt">'.JText::_('ARTF_FORM_VALIDE').'</div>'.$a_validlist.$helper_valide.'</div>
                  <div class="affields" width="128px"><div class="affieldstxt">'.JText::_('ARTF_FORM_CUSTOMCODE').'</div><input class="text_area" type="text" name="customcode[]" value=""/>'.$helper_customcode.'</div>
                  <div class="affields" width="90px"><div class="affieldstxt">'.JText::_('ARTF_FORM_READONLY').'</div>'.$a_ronlylist.$helper_readonly.'</div><div class="clear"></div>
                  <div class="affields" width="128px"><div class="affieldstxt">'.JText::_('ARTF_FORM_VALUES').'</div><textarea class="text_area" type="text" cols="33" rows="10" name="values[]" /></textarea>'.$helper_values.'</div>
                  <div class="affields" width="128px"><div class="affieldstxt">'.JText::_('ARTF_FORM_DEFVALUES').'</div><textarea class="text_area" type="text" cols="33" rows="10" name="default_values[]" /></textarea>'.$helper_defvalues.'</div>
                  <div class="affields" width="128px"><div class="affieldstxt">'.JText::_('ARTF_FORM_LAYOUT').'</div><textarea class="text_area" type="text" cols="43" rows="10" name="layout[]" />'.$dolayout.'</textarea>'.$helper_layout.'</div>
                  <div>&nbsp;</div>
               </div>
               <div class="clear"></div>';

      } else {

         foreach ($items as $item) {
         $ordering = $item->item_ordering;
         $i++;

         $a_typeslistf  = JHTML::_('select.genericlist', $itlists['a_types'], 'type[]', 'id="aftypes'.$i.'" onChange="javascript:function fieldprevb'.$i.'(){document.getElementById(\'paftypes'.$i.'\').innerHTML = document.getElementById(\'aftypes'.$i.'\').options[document.getElementById(\'aftypes'.$i.'\').value-1].text;}fieldprevb'.$i.'();" class="text_area" size="1"', 'value', 'text', $item->type );
         $a_requlistf   = JHTML::_('select.genericlist', $itlists['a_requ'], 'required[]', 'class="text_area" size="1"', 'value', 'text', $item->required );
         $a_validlistf  = JHTML::_('select.genericlist', $itlists['a_valid'], 'validation[]', 'class="text_area" size="1"', 'value', 'text', $item->validation );
         $a_ronlylistf  = JHTML::_('select.genericlist', $itlists['a_ronly'], 'readonly[]', 'class="text_area" size="1"', 'value', 'text', $item->readonly );
         
         $item->values = str_replace("<","&lt;",$item->values);
	 $item->values = str_replace(">","&gt;",$item->values);
         $item->default_values = str_replace("<","&lt;",$item->default_values);
	 $item->default_values = str_replace(">","&gt;",$item->default_values);
         $item->layout = str_replace("<","&lt;",$item->layout);
	 $item->layout = str_replace(">","&gt;",$item->layout);
	 
         echo '<h3 class="toggler atStart">';
                  if ($i > 1)echo '<a href="javascript:void(0);" onClick="window.location=\'index.php?option=com_artforms&task=delrow&id='.$formid.'&itemdel='.$item->item_id.'\'">
                     <img src="'.JURI::base().'components/com_artforms/assets/images/delete.png" width="16" height="16" border="0" alt="'.JText::_('ARTF_FORM_ITEMDEL').'" class="MTTips" title="'.JText::_('ARTF_FORM_FIELD').' '.$i.' :: '.JText::_('ARTF_FORM_ITEMDEL').'" />
		     </a>  ';
               echo JText::_('ARTF_FORM_FIELD' ).' '.$i.' :: <span id="pafname'.$i.'">'.$item->name.'</span> :: <span id="paftypes'.$i.'">'.$typ[$item->type];if(isset($item->item_id))echo '</span> :: Item-ID: '.$item->item_id;echo '</h3>
               <input type="hidden" name="form_id[]" value="'.$formid.'" />
               <input type="hidden" name="item_id[]" value="'.$item->item_id.'" />
               <div class="element atStart">
                  <div class="affields" width="90px"><div class="affieldstxt">'.JText::_('ARTF_FORM_ORDER').'</div><input class="text_area" type="text" name="item_ordering[]" maxlength="4" style="width:25px;text-align:center;" value="'.$item->item_ordering.'"/>'.$helper_order.'</div>
                  <div class="affields" width="128px"><div class="affieldstxt">'.JText::_('ARTF_FORM_FIELDNAME').'</div><input class="text_area" type="text" size="20" name="name[]" id="afname'.$i.'" onkeyup="javascript:function fieldpreva'.$i.'(){document.getElementById(\'pafname'.$i.'\').innerHTML = document.getElementById(\'afname'.$i.'\').value;}fieldpreva'.$i.'();" value="'.$item->name.'" />'.$helper_fieldname.'</div>
                  <div class="affields" width="90px"><div class="affieldstxt">'.JText::_('ARTF_FORM_FIELDTYPE').'</div>'.$a_typeslistf.$helper_fieldtype.'</div>
                  <div class="affields" width="90px"><div class="affieldstxt">'.JText::_('ARTF_FORM_REQUIRED').'</div>'.$a_requlistf.$helper_required.'</div>
                  <div class="affields" width="90px"><div class="affieldstxt">'.JText::_('ARTF_FORM_VALIDE').'</div>'.$a_validlistf.$helper_valide.'</div>
                  <div class="affields" width="128px"><div class="affieldstxt">'.JText::_('ARTF_FORM_CUSTOMCODE').'</div><input class="text_area" type="text" name="customcode[]" value="'.$item->customcode.'"/>'.$helper_customcode.'</div>
                  <div class="affields" width="90px"><div class="affieldstxt">'.JText::_('ARTF_FORM_READONLY').'</div>'.$a_ronlylistf.$helper_readonly.'</div><div class="clear"></div>
                  <div class="affields" width="128px"><div class="affieldstxt">'.JText::_('ARTF_FORM_VALUES').'</div><textarea class="text_area" type="text" cols="33" rows="10" name="values[]" />'.$item->values.'</textarea>'.$helper_values.'</div>
                  <div class="affields" width="128px"><div class="affieldstxt">'.JText::_('ARTF_FORM_DEFVALUES').'</div><textarea class="text_area" type="text" cols="33" rows="10" name="default_values[]" />'.$item->default_values.'</textarea>'.$helper_defvalues.'</div>
                  <div class="affields" width="128px"><div class="affieldstxt">'.JText::_('ARTF_FORM_LAYOUT').'</div><textarea class="text_area" type="text" cols="43" rows="10" name="layout[]" />'.($item->layout ? $item->layout : $dolayout).'</textarea>'.$helper_layout.'</div>
                  <div>&nbsp;</div>
               </div>
               <div class="clear"></div>';
         }

      }

      if(!$items)$ordering = '0';

      $a_typeslist  = eregi_replace( 'ze="1">', 'ze="1">\\', $a_typeslist );
      $a_requlist   = eregi_replace( 'ze="1">', 'ze="1">\\', $a_requlist );
      $a_validlist  = eregi_replace( 'ze="1">', 'ze="1">\\', $a_validlist );
      $a_ronlylist  = eregi_replace( 'ze="1">', 'ze="1">\\', $a_ronlylist );
      $a_typeslist  = eregi_replace( 'n>', 'n>\\', $a_typeslist );
      $a_requlist   = eregi_replace( 'n>', 'n>\\', $a_requlist );
      $a_validlist  = eregi_replace( 'n>', 'n>\\', $a_validlist );
      $a_ronlylist  = eregi_replace( 'n>', 'n>\\', $a_ronlylist );
      $a_typeslist  = eregi_replace( 'ct>', 'ct>\\', $a_typeslist );
      $a_requlist   = eregi_replace( 'ct>', 'ct>\\', $a_requlist );
      $a_validlist  = eregi_replace( 'ct>', 'ct>\\', $a_validlist );
      $a_ronlylist  = eregi_replace( 'ct>', 'ct>\\', $a_ronlylist );

      $a_typeslist  = eregi_replace( 'AFTYPESCHANGE',
                                     "id=\"aftypes';
                                      var einputs11 = '\" onChange=\"javascript:function fieldprevb';
                                      var einputs12 = '(){document.getElementById(\'paftypes';
                                      var einputs13 = '\').innerHTML = document.getElementById(\'aftypes';
                                      var einputs14 = '\').options[document.getElementById(\'aftypes';
                                      var einputs15 = '\').value-1].text;}fieldprevb';
                                      var einputs16 = '();\"",
                                     $a_typeslist );
                                     
      $dolayout     = base64_encode( $dolayout );
      
      if( $helper_order != '' ){
         $helper_order = str_replace('"','\"', $helper_order);
         $helper_fieldname = str_replace('"','\"', $helper_fieldname);
         $helper_fieldtype = str_replace('"','\"', $helper_fieldtype);
         $helper_required = str_replace('"','\"', $helper_required);
         $helper_valide = str_replace('"','\"', $helper_valide);
         $helper_customcode = str_replace('"','\"', $helper_customcode);
         $helper_readonly = str_replace('"','\"', $helper_readonly);
         $helper_values = str_replace('"','\"', $helper_values);
         $helper_defvalues = str_replace('"','\"', $helper_defvalues);
         
         $helper_order = str_replace("'", "\'", $helper_order);
         $helper_fieldname = str_replace("'", "\'", $helper_fieldname);
         $helper_fieldtype = str_replace("'", "\'", $helper_fieldtype);
         $helper_required = str_replace("'", "\'", $helper_required);
         $helper_valide = str_replace("'", "\'", $helper_valide);
         $helper_customcode = str_replace("'", "\'", $helper_customcode);
         $helper_readonly = str_replace("'", "\'", $helper_readonly);
         $helper_values = str_replace("'", "\'", $helper_values);
         $helper_defvalues = str_replace("'", "\'", $helper_defvalues);
         
         $helper_order = str_replace('MTTips','MTTips2', $helper_order);
         $helper_fieldname = str_replace('MTTips','MTTips2', $helper_fieldname);
         $helper_fieldtype = str_replace('MTTips','MTTips2', $helper_fieldtype);
         $helper_required = str_replace('MTTips','MTTips2', $helper_required);
         $helper_valide = str_replace('MTTips','MTTips2', $helper_valide);
         $helper_customcode = str_replace('MTTips','MTTips2', $helper_customcode);
         $helper_readonly = str_replace('MTTips','MTTips2', $helper_readonly);
         $helper_values = str_replace('MTTips','MTTips2', $helper_values);
         $helper_defvalues = str_replace('MTTips','MTTips2', $helper_defvalues);
      }
                                     
      echo '<script type="text/javascript" src="'.AFPATH_WEB_JS_SITE.'base64/webtoolkit.base64.js"></script>';
      echo "
      <script type=\"text/javascript\">
         function extrainputbox(form) {
            var b64layout = '".$dolayout."';
            var getlayout = Base64.decode(b64layout);
            var einputs1 = '<h3 class=\"toggler atStart\">".JText::_('ARTF_FORM_FIELD' )." ';
            var einputs2 = ' :: <span id=\"pafname';
            var einputs3 = '\">-</span> :: <span id=\"paftypes';
            var einputs4 = '\">Input</span></h3>\
                           <input type=\"hidden\" name=\"form_id[]\" value=\"".$formid."\" />\
                           <input type=\"hidden\" name=\"item_id[]\" value=\"\" />\
                           <div class=\"element atStart\">\
                              <div class=\"affields\" width=\"90px\"><div class=\"affieldstxt\">".JText::_('ARTF_FORM_ORDER')."</div><input class=\"text_area\" type=\"text\" name=\"item_ordering[]\" maxlength=\"4\" style=\"width:25px;text-align:center;\" value=\"';
            var einputs5 = '\"/>".$helper_order."</div>\
                              <div class=\"affields\" width=\"128px\"><div class=\"affieldstxt\">".JText::_('ARTF_FORM_FIELDNAME')."</div><input class=\"text_area\" type=\"text\" size=\"20\" name=\"name[]\" id=\"afname';
            var einputs6 = '\" onkeyup=\"javascript:function fieldpreva';
            var einputs7 = '(){document.getElementById(\'pafname';
            var einputs8 = '\').innerHTML = document.getElementById(\'afname';
            var einputs9 = '\').value;}fieldpreva';
            var einputs10 = '();\" value=\"\" />".$helper_fieldname."</div>\
                              <div class=\"affields\" width=\"90px\"><div class=\"affieldstxt\">".JText::_('ARTF_FORM_FIELDTYPE')."</div>\\".$a_typeslist.$helper_fieldtype."</div>\
                              <div class=\"affields\" width=\"90px\"><div class=\"affieldstxt\">".JText::_('ARTF_FORM_REQUIRED')."</div>\\".$a_requlist.$helper_required."</div>\
                              <div class=\"affields\" width=\"90px\"><div class=\"affieldstxt\">".JText::_('ARTF_FORM_VALIDE')."</div>\\".$a_validlist.$helper_valide."</div>\
                              <div class=\"affields\" width=\"128px\"><div class=\"affieldstxt\">".JText::_('ARTF_FORM_CUSTOMCODE')."</div><input class=\"text_area\" type=\"text\" name=\"customcode[]\" value=\"\"/>".$helper_customcode."</div>\
                              <div class=\"affields\" width=\"90px\"><div class=\"affieldstxt\">".JText::_('ARTF_FORM_READONLY')."</div>\\".$a_ronlylist.$helper_readonly."</div><div class=\"clear\"></div>\
                              <div class=\"affields\" width=\"128px\"><div class=\"affieldstxt\">".JText::_('ARTF_FORM_VALUES')."</div><textarea class=\"text_area\" type=\"text\" cols=\"33\" rows=\"10\" name=\"values[]\" /></textarea>".$helper_values."</div>\
                              <div class=\"affields\" width=\"128px\"><div class=\"affieldstxt\">".JText::_('ARTF_FORM_DEFVALUES')."</div><textarea class=\"text_area\" type=\"text\" cols=\"33\" rows=\"10\" name=\"default_values[]\" /></textarea>".$helper_defvalues."</div>\
                              <div class=\"affields\" width=\"128px\"><div class=\"affieldstxt\">".JText::_('ARTF_FORM_LAYOUT')."</div><textarea class=\"text_area\" type=\"text\" cols=\"43\" rows=\"10\" name=\"layout[]\" />'+getlayout+'</textarea>".$helper_layout."</div>\
                              <div>&nbsp;</div>\
                           </div><div class=\"clear\"></div>';
            
            var numObj = parseInt(form.addFieldx.value);
            var html = '';
            var container = document.getElementById('divAddField');

            if (numObj > 0) {
               for(i=1; i<=numObj; i++) {
                  var n2 = ".$i." - 1 + i;
                  n2++;
                  foid = ".$ordering." - 1 + i;
                  foid++;
                  einputs = ( einputs1 + n2 + einputs2 + n2 + einputs3 + n2 + einputs4 + foid + einputs5 + n2 + einputs6 + n2 + einputs7 + n2 + einputs8 + n2 + einputs9 + n2 + einputs10 + n2 + einputs11 + n2 + einputs12 + n2 + einputs13 + n2 + einputs14 + n2 + einputs15 + n2 + einputs16 );
                  html += (einputs);
               }
            }

            container.innerHTML = html;

         }
      </script>";
      ?>
   </div>
      <div id="divAddField" align="left" width="100%"style="margin-left:-2px;"></div>
      <br />
      <input type="hidden" name="id" value="<?php echo $formid; ?>" />
      <input type="hidden" name="option" value="<?php echo $option; ?>" />
      <input type="hidden" name="boxchecked" value="0" />
      <input type="hidden" name="task" value="" />
   </form>
   <div class="clear"></div>
   <form name="adminForm2" method="" action="">
      <div width="100%" align="left" height="30">
         <?php echo JText::_('ARTF_FORM_NEWFIELD' ).' '.$addFieldx.$helper_addfieldssel;?>
      </div>
   </form>
   <?php

}

?>
