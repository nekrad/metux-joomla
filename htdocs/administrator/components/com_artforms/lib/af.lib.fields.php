<?php
/**
* @version $Id: af.lib.fields.php v.2.1b7 2007-11-25 00:17:58Z GMT-3 $
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

function showEditFields( $option, $formid, &$items, &$itlists, $afcfg_usebehelper='0', $afcfg_fieldsdefaultlayout=''  ) {

   include( AFPATH_LIB_ADM_SITE.'af.lib.loadhelper.php' );
   
   $a_typeslist = JHTML::_('select.genericlist', $itlists['a_types'], 'type[]', 'class="text_area" size="1"', 'value', 'text' );
   $a_requlist  = JHTML::_('select.genericlist', $itlists['a_requ'], 'required[]', 'class="text_area" size="1"', 'value', 'text' );
   $a_validlist = JHTML::_('select.genericlist', $itlists['a_valid'], 'validation[]', 'class="text_area" size="1"', 'value', 'text'  );
   $a_ronlylist = JHTML::_('select.genericlist', $itlists['a_ronly'], 'readonly[]', 'class="text_area" size="1"', 'value', 'text'  );
   $addFieldx   = JHTML::_('select.genericlist', $itlists['addFieldx'], 'addFieldx', 'class="text_area" onChange="extrainputbox(this.form)"', 'value', 'text', 'n' );
   $dolayout = urldecode( $afcfg_fieldsdefaultlayout );
   ?>
   <table class="adminform" border="0" cellpadding="3" cellspacing="0" width="100%">
      <tr>
         <th align="left" width="125px"><?php echo JText::_( 'ARTF_FORM_FIELDS' );?></th>
         <th align="left" width="40px"><?php echo JText::_( 'ARTF_FORM_ORDER' ).$helper_order;?></th>
         <th align="left" width="128px"><?php echo JText::_( 'ARTF_FORM_FIELDNAME' ).$helper_fieldname;?></th>
         <th align="left" width="90px"><?php echo JText::_( 'ARTF_FORM_FIELDTYPE' ).$helper_fieldtype;?></th>
         <th align="left" width="90px"><?php echo JText::_( 'ARTF_FORM_REQUIRED' ).$helper_required;?></th>
         <th align="left" width="90px"><?php echo JText::_( 'ARTF_FORM_VALIDE' ).$helper_valide;?></th>
         <th align="left" width="128px"><?php echo JText::_( 'ARTF_FORM_VALUES' ).$helper_values;?></th>
         <th align="left" width="128px"><?php echo JText::_( 'ARTF_FORM_DEFVALUES' ).$helper_defvalues;?></th>
         <th align="left" width="128px"><?php echo JText::_( 'ARTF_FORM_LAYOUT' ).$helper_layout;?></th>
         <th align="left" width="90px"><?php echo JText::_( 'ARTF_FORM_READONLY' ).$helper_readonly;?></th>
         <th align="left" width="128px"><?php echo JText::_( 'ARTF_FORM_CUSTOMCODE' ).$helper_customcode;?></th>
         <th align="left" width="90px"><?php echo JText::_( 'ARTF_FORM_ITEMDEL' );?></th>
         <th>&nbsp;</th>
      </tr>
      <?php
      $i=0;

      if ($formid == ''){

                       $i=1;
                       echo "<tr>
			        <td width=\"182px\" valign=\"top\">
                                   <input type=\"hidden\" name=\"form_id[]\" value=\"".$formid."\" />
                                   <input type=\"hidden\" name=\"item_id[]\" value=\"\" />
                                   &nbsp;".JText::_( 'ARTF_FORM_FIELD' )."_".$i.":
                                </td>
                                <td align=\"center\" valign=\"top\">
                                   <input class=\"text_area\" type=\"text\" name=\"item_ordering[]\" maxlength=\"4\" align=\"center\" style=\"width:25px;text-align:center;\" value=\"\"/>
                                </td>
				<td width=\"128px\" valign=\"top\">
                                   <input class=\"text_area\" type=\"text\" size=\"20\" name=\"name[]\" value=\"\" />
                                </td>
                                <td width=\"90px\" valign=\"top\">";
                                   echo $a_typeslist."
                                </td>
                                <td width=\"90px\" valign=\"top\">";
                                   echo $a_requlist."
                                </td>
                                <td width=\"90px\" valign=\"top\">";
                                   echo $a_validlist."
                                </td>
                                <td width=\"128px\" valign=\"top\">
                                <textarea class=\"text_area\" type=\"text\" cols=\"20\" rows=\"3\" name=\"values[]\" /></textarea>
                                </td>
                                <td width=\"128px\" valign=\"top\">
                                <textarea class=\"text_area\" type=\"text\" cols=\"20\" rows=\"3\" name=\"default_values[]\" /></textarea>
                                </td>
                                <td width=\"128px\" valign=\"top\">
                                <textarea class=\"text_area\" type=\"text\" cols=\"30\" rows=\"3\" name=\"layout[]\" />".$dolayout."</textarea>
                                </td>
                                <td width=\"90px\" valign=\"top\">";
                                   echo $a_ronlylist."
                                </td>
                                <td width=\"128px\" valign=\"top\">
                                   <input class=\"text_area\" type=\"text\" name=\"customcode[]\" value=\"\"/>
                                </td>
                                <td width=\"90px\" valign=\"top\">
                                   &nbsp;
                                </td>
                                <td valign=\"top\">
                                   &nbsp;
                                </td>
                                </tr>";

			 } else {

			   foreach ($items as $item) {
                           $i++;
                           $item->values = str_replace("<","&lt;",$item->values);
	                   $item->values = str_replace(">","&gt;",$item->values);
                           $item->default_values = str_replace("<","&lt;",$item->default_values);
	                   $item->default_values = str_replace(">","&gt;",$item->default_values);
	                   $item->layout = str_replace("<","&lt;",$item->layout);
                           $item->layout = str_replace(">","&gt;",$item->layout);
	 
                           echo "<tr>
			        <td width=\"182px\" valign=\"top\">
                                   <input type=\"hidden\" name=\"form_id[]\" value=\"".$formid."\" />
                                   <input type=\"hidden\" name=\"item_id[]\" value=\"".$item->item_id."\" />
                                   &nbsp;".JText::_( 'ARTF_FORM_FIELD' )."_".$i.":
                                </td>
                                <td align=\"center\" valign=\"top\">
                                   <input class=\"text_area\" type=\"text\" name=\"item_ordering[]\" maxlength=\"4\" align=\"center\" style=\"width:25px;text-align:center;\" value=\"".$item->item_ordering."\"/>
                                </td>
				<td width=\"128px\" valign=\"top\">
                                   <input class=\"text_area\" type=\"text\" size=\"20\" name=\"name[]\" value=\"".$item->name."\" />
                                </td>
                                <td width=\"90px\" valign=\"top\">";
                                   $a_typeslistf = JHTML::_('select.genericlist', $itlists['a_types'], 'type[]', 'class="text_area" size="1"', 'value', 'text', $item->type );
                                   echo $a_typeslistf."
                                </td>
                                <td width=\"90px\" valign=\"top\">";
                                   $a_requlistf = JHTML::_('select.genericlist', $itlists['a_requ'], 'required[]', 'class="text_area" size="1"', 'value', 'text', $item->required );
                                   echo $a_requlistf."
                                </td>
                                <td width=\"90px\" valign=\"top\">";
                                   $a_validlistf = JHTML::_('select.genericlist', $itlists['a_valid'], 'validation[]', 'class="text_area" size="1"', 'value', 'text', $item->validation );
                                   echo $a_validlistf."
                                </td>
                                <td width=\"128px\" valign=\"top\">
                                   <textarea class=\"text_area\" type=\"text\" cols=\"20\" rows=\"3\" name=\"values[]\" />".$item->values."</textarea>
                                </td>
                                <td width=\"128px\" valign=\"top\">
                                   <textarea class=\"text_area\" type=\"text\" cols=\"20\" rows=\"3\" name=\"default_values[]\" />".$item->default_values."</textarea>
                                </td>
                                <td width=\"128px\" valign=\"top\">
                                   <textarea class=\"text_area\" type=\"text\" cols=\"20\" rows=\"3\" name=\"layout[]\" />".($item->layout ? $item->layout : $dolayout)."</textarea>
                                </td>
                                <td width=\"90px\" valign=\"top\">";
                                   $a_ronlylistf = JHTML::_('select.genericlist', $itlists['a_ronly'], 'readonly[]', 'class="text_area" size="1"', 'value', 'text', $item->readonly );
                                   echo $a_ronlylistf."
                                </td>
                                <td width=\"128px\" valign=\"top\">
                                   <input class=\"text_area\" type=\"text\" name=\"customcode[]\" value=\"".$item->customcode."\"/>
                                </td>
                                <td width=\"90px\" valign=\"top\">";
                                if ($i > 1){
                                   echo "<a href=\"javascript:void(0);\" onClick=\"window.location='index.php?option=com_artforms&task=delrow&id=".$formid."&itemdel=".$item->item_id."'\">
                                         <img src=\"".AFPATH_WEB_IMG_ADM_SITE."delete.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"".JText::_( 'ARTF_FORM_ITEMDEL' )."\" />
				         </a>";
                                }
                                echo "</td>
                                <td valign=\"top\">
                                   &nbsp;
                                </td>
                                </tr>";
                           }
                         }

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

      $dolayout     = base64_encode( $dolayout );
      
      echo '<script type="text/javascript" src="'.AFPATH_WEB_JS_SITE.'base64/webtoolkit.base64.js"></script>';
                                echo "<script type=\"text/javascript\">

                                     function extrainputbox(form) {

                                     var b64layout = '".$dolayout."';
                                     var getlayout = Base64.decode(b64layout);
                                     var einputs1 = '<table><tr><td width=\"179px\" valign=\"top\"><input type=\"hidden\" name=\"form_id[]\" value=\"".$formid."\" /><input type=\"hidden\" name=\"item_id[]\" value=\"\" />".JText::_( 'ARTF_FORM_FIELD' )."_';
				     var einputs2 = ':</td><td align=\"center\" width=\"40px\" valign=\"top\"><input class=\"text_area\" type=\"text\" name=\"item_ordering[]\" maxlength=\"4\" style=\"width:25px;text-align:center;\" value=\"\"/></td>\
                                                     <td width=\"128px\" valign=\"top\"><input class=\"text_area\" type=\"text\" size=\"20\" name=\"name[]\" value=\"\" /></td>\
                                                     <td width=\"90px\" valign=\"top\">\\".$a_typeslist."</td>\
                                                     <td width=\"90px\" valign=\"top\">\\".$a_requlist."</td>\
                                                     <td width=\"90px\" valign=\"top\">\\".$a_validlist."</td>\
                                                     <td width=\"128px\" valign=\"top\"><textarea class=\"text_area\" type=\"text\" cols=\"20\" rows=\"3\" name=\"values[]\" /></textarea></td>\
                                                     <td width=\"128px\" valign=\"top\"><textarea class=\"text_area\" type=\"text\" cols=\"20\" rows=\"3\" name=\"default_values[]\" /></textarea></td>\
                                                     <td width=\"128px\" valign=\"top\"><textarea class=\"text_area\" type=\"text\" cols=\"20\" rows=\"3\" name=\"layout[]\" />'+getlayout+'</textarea></td>\
                                                     <td width=\"90px\" valign=\"top\">\\".$a_ronlylist."</td>\
                                                     <td width=\"128px\" valign=\"top\"><input class=\"text_area\" type=\"text\" name=\"customcode[]\" value=\"\"/></td>\
                                                     <td width=\"90px\" valign=\"top\">&nbsp;</td>\
                                                     <td valign=\"top\">&nbsp;</td>\
                                                     </tr></table>';

                                     var numObj = parseInt(form.addFieldx.value);
                                     var html = '';
                                     var container = document.getElementById('divAddField');

                                     if (numObj > 0) {
                                         for(i=1; i<=numObj; i++) {
                                             var n2 = ".$i." - 1 + i;
                                             n2++;
                                             einputs = (einputs1 + n2 + einputs2);
                                             html += (einputs);
                                         }
                                     }

                                     container.innerHTML = html;

                                }

                                </script>
                                     ";
                ?>
		<tr>
                  <td colspan="10">
                    <div id="divAddField" align="left" width="100%"style="margin-left:-2px;"></div>
                  </td>
                </tr>
              </table>
              <br />

		<input type="hidden" name="id" value="<?php echo $formid; ?>" />
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="task" value="" />
   </form>
   <form name="adminForm2" method="" action="">
      <div width="100%" align="left" height="30">
         <?php echo JText::_( 'ARTF_FORM_NEWFIELD' ).' '.$addFieldx.$helper_addfieldssel;?>
      </div>
   </form>
   <?php

}

?>
