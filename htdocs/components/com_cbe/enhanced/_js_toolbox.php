<?php
/*************************************************************
* Community Builder Enhanced
* Author Phil_K
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*************************************************************/

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

$js_cbe_toolbox = <<<EOT

<script language="javascript" type="text/javascript">
<!--

var cbeDefaultFieldBackground;

function cbe_getObject(obj) {
	var strObj;
	if (document.all) {
		strObj = document.all.item(obj);
	} else if (document.getElementById) {
		strObj = document.getElementById(obj);
	}
	return strObj;
}

function submitViaEnter(evt)
{
	evt = (evt) ? evt : event;
	var target = (evt.target) ? evt.target : evt.srcElement;
	var form = target.form;
	var charCode = (evt.charCode) ? evt.charCode :
	((evt.which) ? evt.which : evt.keyCode);
	if (charCode == 13 || charCode == 3)
	{
		form.submit();
	}
}
function isNotEmpty(elm)
{
	var str = elm.value;
	var reWhitespace = /^\s+$/;
	if(str == null || str.length == 0 || reWhitespace.test(str))
	{
		alert("Please fill in the required field.");
		return false;
	}
	else
	{
		return true;
	}
}
function focusElement(formName, elemName)
{
	var elem = document.forms[formName].elements[elemName];
	elem.focus();
	elem.select();
}
function cbe_focusSelElement(formName, elemName)
{
	var elem = document.forms[formName].elements[elemName];
	elem.focus();
}
function isValidEmailAddress(elem)
{
	var str = elem.value;
	var re = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
	if (cbeDefaultFieldBackground === undefined) {
		cbeDefaultFieldBackground = ((cbeForm['username'].style.getPropertyValue) ? cbeForm['username'].style.getPropertyValue("background-color") : cbeForm['username'].style.backgroundColor);
	}
	if (!str.match(re) && str != "")
	{
		alert("_UE_CBE_EMAIL_ERROR");
		//alert("Verify the email address format.");
		elem.style.backgroundColor = "red";
		setTimeout("focusElement('" + elem.form.name + "', '" + elem.name + "')", 0);
		elem.focus();
		elem.select();
		return false;
	}
	else
	{
		if (elem.style.backgroundColor.slice(0,3)=="red") {
			elem.style.backgroundColor = cbeDefaultFieldBackground;
		}
		return true;
	}
}

function isNummericFieldFloat(elem)
{
	var str = elem.value;
	var re = /[-+]?\b[0-9]+(\.[0-9]+)?\b/;
	if (cbeDefaultFieldBackground === undefined) {
		cbeDefaultFieldBackground = ((cbeForm['username'].style.getPropertyValue) ? cbeForm['username'].style.getPropertyValue("background-color") : cbeForm['username'].style.backgroundColor);
	}

	if ((!str.match(re) || (str.match(/[,]/))) && str!='')
	{
		alert("_UE_CBE_FLOAT_ERROR");
		//alert("Verify the value format. Only floating point nummerics allowed.");
		elem.style.backgroundColor = "red";
		setTimeout("focusElement('" + elem.form.name + "', '" + elem.name + "')", 0);
		return false;
	}
	else
	{
		if (elem.style.backgroundColor.slice(0,3)=="red") {
			elem.style.backgroundColor = cbeDefaultFieldBackground;
		}
		return true;
	}
}

function isNummericFieldInt(elem)
{
	var str = elem.value;
	var re = /[-+]?\b[0-9]+\b/;
	if (cbeDefaultFieldBackground === undefined) {
		cbeDefaultFieldBackground = ((cbeForm['username'].style.getPropertyValue) ? cbeForm['username'].style.getPropertyValue("background-color") : cbeForm['username'].style.backgroundColor);
	}

	if ((!str.match(re) || (str.match(/[,|.]/))) && str!='')
	{
		alert("_UE_CBE_INTEGER_ERROR");
		//alert("Verify the value format. Only integer nummerics allowed.");
		elem.style.backgroundColor = "red";
		setTimeout("focusElement('" + elem.form.name + "', '" + elem.name + "')", 0);
		return false;
	}
	else
	{
		if (elem.style.backgroundColor.slice(0,3)=="red") {
			elem.style.backgroundColor = cbeDefaultFieldBackground;
		}
		return true;
	}
}

// Euro Date -> (0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)[0-9]{2} (RegExBuddie)

function limitText(limitField, limitNum)
{
	if (limitNum == 0) {
		limitNum = 16777216;
	}
	if (limitField.value.length > limitNum)
	{
		limitField.value = limitField.value.substring(0, limitNum);
		alert("_CBE_TEXTAREA_LIMIT_ERROR"+" "+limitNum);
	}
	//else
	//{
	//	limitCount.value = limitNum - limitField.value.length;
	//}
}

function emoticon(text)
{
	var txtarea = document.post.form;
	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos)
	{
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		txtarea.focus();
	}
	else
	{
		txtarea.value  += text;
		txtarea.focus();
	}
}

function storeCaret(textEl)
{
	if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}
function checkAll( n, fldName ) {
	if (!fldName) {
		fldName = 'cb';
	}
	var f = document.deleteChecked;
	var c = f.toggle.checked;
	var n2 = 0;
	for (i=0; i < n; i++) {
		cb = eval( 'f.' + fldName + '' + i );
		if (cb) {
			cb.checked = c;
			n2++;
		}
	}
	if (c) {
		document.deleteChecked.boxchecked.value = n2;
	} else {
		document.deleteChecked.boxchecked.value = 0;
	}
}
function showControl(evt) {
	evt = (evt) ? evt : event;
	var target = (evt.target) ? evt.target : evt.srcElement;
	var block = document.getElementById("controlhide");
	if (target.id == "flag1") {
		block.style.display = "block";
	} else {
		block.style.display = "none";
	}
}

function CheckInput(formName) {
  for (i = 0; i < document.forms[formName].elements.length; ++i)
    if (document.forms[formName].elements[i].value == "") {
      alert("_UE_CBE_FILL_ALL_ERROR");
      document.forms[formName].elements[i].focus();
      return false;
    }
  return true;
}

function updateHiddenData(elem, elemTarget) {
	var sf_value = elem.value;
	var hf_value = elemTarget.value;
	hf_value = sf_value;
	elemTarget.value = elem.value;
	return true;
}

function cbe_compareHidden(elem, elemTarget) {
	var sf_value = elem.value;
	var hf_value = elemTarget.value;
	if ( sf_value != hf_value) {
		return false;
	}
	return true;
}

function checkCalDate(elem) {
	var d=cbeDateBox_parseDate(elem.value,0);
	if (cbeDefaultFieldBackground === undefined) {
		//var cbeForm = document.adminForm.elements;
		cbeDefaultFieldBackground = ((cbeForm['username'].style.getPropertyValue) ? cbeForm['username'].style.getPropertyValue("background-color") : cbeForm['username'].style.backgroundColor);
	}

	if(d==null && elem.value != ''){
		alert("_UE_CBE_JS_DATE_INVALID");
		elem.style.backgroundColor = "red";
		setTimeout("focusElement('" + elem.form.name + "', '" + elem.name + "')", 0);
		return false;
	} else {
		if (elem.style.backgroundColor.slice(0,3)=="red") {
			elem.style.backgroundColor = cbeDefaultFieldBackground;
		}
		return true;
	}
}

function checkCalDateRange(elem) {
	var cbe_test = cbeDateBox_checkDateRange(elem.value,elem.getAttribute('lowRange'),elem.getAttribute('highRange'));
	if (cbe_test == false) {
		var alMSG = " _UE_CBE_JS_DATE_OUTOFRANGE " + " ( " + elem.getAttribute('lowRange') + " - " + elem.getAttribute('highRange') + " ) ";
		alert(alMSG);
		elem.style.backgroundColor = "red";
		setTimeout("focusElement('" + elem.form.name + "', '" + elem.name + "')", 0);
		return false;
	} else {
		cbe_test2 = checkCalDate(elem);
		if (elem.style.backgroundColor.slice(0,3)=="red" && cbe_test2 == true) {
			elem.style.backgroundColor = cbeDefaultFieldBackground;
			return true;
		} else {
			return false;
		}
	}
}

function cbe_checkCalCall(elem) {
	if (elem.getAttribute('cbe_type') == 'birthdate' || elem.getAttribute('cbe_type') == 'dateselect' || elem.getAttribute('cbe_type') == 'dateselectrange') {
		var elem_hid = cbe_getObject(elem.id + "_hid");
		updateHiddenData(elem, elem_hid);
	}
}

function cbe_checkDateSelect(df_name, do_update) {
	var df_day = cbe_getObject(df_name + "_day");
	var dfv_day = df_day.options[df_day.selectedIndex].value;
	var df_month = cbe_getObject(df_name + "_mon");
	var dfv_month = df_month.options[df_month.selectedIndex].value;
	var df_year = cbe_getObject(df_name + "_year");
	var dfv_year = df_year.options[df_year.selectedIndex].value;
	var df_hid = cbe_getObject(df_name + "_hid");
	var chk_date = dfv_day + "." + dfv_month + "." + dfv_year;
	var d=cbeDateBox_parseDate(chk_date,0);
	if (cbeDefaultFieldBackground === undefined) {
		cbeDefaultFieldBackground = ((cbeForm['username'].style.getPropertyValue) ? cbeForm['username'].style.getPropertyValue("background-color") : cbeForm['username'].style.backgroundColor);
	}
	if(d==null){
		alert("_UE_CBE_JS_DATE_INVALID");
		df_day.style.backgroundColor = "red";
		df_month.style.backgroundColor = "red";
		df_year.style.backgroundColor = "red";
		setTimeout("cbe_focusSelElement('" + df_day.form.name + "', '" + df_day.name + "')", 0);
		if (do_update == 1) {
			df_hid.value = '';
		}
		return false;
	} else {
		if (df_day.style.backgroundColor.slice(0,3)=="red") {
			df_day.style.backgroundColor = cbeDefaultFieldBackground;
			df_month.style.backgroundColor = cbeDefaultFieldBackground;
			df_year.style.backgroundColor = cbeDefaultFieldBackground;
		}
		if (do_update == 1) {
			df_hid.value = chk_date;
		}
		return true;
	}
}

function cbe_checkDayCount(df_name) {
	var df_day = cbe_getObject(df_name + "_day");
	var dfv_day = df_day.options[df_day.selectedIndex].value;
	var df_month = cbe_getObject(df_name + "_mon");
	var dfv_month = df_month.options[df_month.selectedIndex].value;
	var df_year = cbe_getObject(df_name + "_year");
	var dfv_year = df_year.options[df_year.selectedIndex].value;
	var df_hid = cbe_getObject(df_name + "_hid");
	var DpM = cbeDateBox_DpM(dfv_year, dfv_month);
	var df_was_Index = df_day.selectedIndex;
	df_day.selectedIndex = 0;
	if (df_day.length != DpM) {
		var ck_l = df_day.length -1;
		var ck_n = 0;
		for ( i = ck_l; i >= ck_n; i--) {
			df_day.options[i] = null;
		}
		var n_day = 0;
		for (i = 0; i < DpM; i++) {
			n_day++;
			df_day.options[i] = new Option(n_day, n_day, false, false);
		}
	}
	if (df_day.length >= df_was_Index) {
		df_day.selectedIndex = df_was_Index;
		var chk_date = df_day.options[df_day.selectedIndex].value + "." + dfv_month + "." + dfv_year;
		df_hid.value= chk_date;
	} else {
		df_hid.value = '';
	}
	return true;
}

function cbe_randomPassword(length)
{
   chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
   pass = "";

   for(x=0;x<length;x++)
   {
      i = Math.floor(Math.random() * 62);
      pass += chars.charAt(i);
   }

   return pass;
}

//-->
</script>

EOT;

$js_cbe_toolbox = str_replace('_UE_CBE_EMAIL_ERROR', _UE_CBE_EMAIL_ERROR, $js_cbe_toolbox);
$js_cbe_toolbox = str_replace('_UE_CBE_FLOAT_ERROR', _UE_CBE_FLOAT_ERROR, $js_cbe_toolbox);
$js_cbe_toolbox = str_replace('_UE_CBE_INTEGER_ERROR', _UE_CBE_INTEGER_ERROR, $js_cbe_toolbox);
$js_cbe_toolbox = str_replace('_CBE_TEXTAREA_LIMIT_ERROR', _CBE_TEXTAREA_LIMIT_ERROR, $js_cbe_toolbox);
$js_cbe_toolbox = str_replace('_UE_CBE_FILL_ALL_ERROR', _UE_CBE_FILL_ALL_ERROR, $js_cbe_toolbox);
$js_cbe_toolbox = str_replace('_UE_CBE_JS_DATE_INVALID', _UE_CBE_JS_DATE_INVALID, $js_cbe_toolbox);
$js_cbe_toolbox = str_replace('_UE_CBE_JS_DATE_OUTOFRANGE', _UE_CBE_JS_DATE_OUTOFRANGE, $js_cbe_toolbox);

?>