function cbsaveorder( cb, n, fldName, task, subtaskName, subtaskValue ) {
    cbCheckAllRowsAndSubTask( cb, n, fldName, subtaskName, subtaskValue );
    submitform( task );
}
//needed by cbsaveorder function
function cbCheckAllRowsAndSubTask( cb, n, fldName, subtaskName, subtaskValue ) {
    if (!fldName) {
        fldName = 'cb';
    }
    f = cbParentForm( cb );
    for ( var i = 0; i < n; i++ ) {
             box = f.elements[fldName+i];
             if ( box.checked == false ) {
                     box.checked = true;
             }
    }
	if (subtaskName && subtaskValue) {
		f.elements[subtaskName].value = subtaskValue;
	}
}
/**
* Toggles the check state of a group of boxes
*
* Checkboxes must have an id attribute in the form cb0, cb1...
* @param the id of the toggle button
* @param The number of box to 'check'
* @param An alternative field name id prefix
*/
function cbToggleAll( tgl, n, fldName ) {
    if (!fldName) {
        fldName = 'cb';
    }
    var frm = tgl.form;
    for (i=0; i < n; i++) {
        cb = eval( 'frm.' + fldName + i );
        if (cb) {
            cb.checked = tgl.checked;
        }
    }
    return true;
}

function cbParentForm(cb) {
	var f = cb;
	while (f) {
		f = f.parentNode;
		if (f.nodeName == 'FORM') {
			break;
		}
	}
	return f;
}
/**
* Performs task/subtask on table row id
*/
function cbListItemTask( cb, task, subtaskName, subtaskValue, fldName, id ) {
    var f = cbParentForm(cb);
    if (cb) {
        for (i = 0; true; i++) {
            cbx = f.elements[fldName+i];
            if (!cbx) break;
            if ( i == id ) {
	            cbx.checked = true;
            } else {
	            cbx.checked = false;
        	}
        }
		f.elements[subtaskName].value = subtaskValue;
        submitbutton(task);
    }
    return false;
}
/**
* Performs task/subtask on selected table rows
*/
function cbDoListTask( cb, task, subtaskName, subtaskValue, fldName ) {
    var f = document.forms['adminForm'];
    if (cb) {
    	var oneChecked = false;
        for (i = 0; true; i++) {
            cbx = f.elements[fldName+i];
            if ( ! cbx ) {
            	break;
            }
            if ( cbx.checked ) {
	            oneChecked = true;
	            break;
        	}
        }
        if ( oneChecked ) {
        	if ( subtaskValue == 'deleterows' ) {
        		if ( ! confirm('Are you sure you want to delete selected items ?') ) { 
        			return false;
        		}
        	}
			f.elements[subtaskName].value = subtaskValue;
    	    submitbutton(task);
        } else {
        	alert( "no items selected" );
        }
    }
    return false;
}

function submitbutton(pressbutton) {
	if (pressbutton == "showPlugins" || pressbutton == "cancelPlugin" || pressbutton == "cancelPluginAction") {
		cbsubmitform(pressbutton);
		return;
	}
	// validation
	var form = document.forms['adminForm'];
	if ( ( typeof(form.elements['name']) != "undefined") && ( form.elements['name'].value == "" ) ) {
		alert( "Plugin must have a name" );
	} else {
		cbsubmitform(pressbutton);
	}
}

/**
* Submit the admin form
*/
function cbsubmitform(pressbutton){
	document.forms['adminForm'].elements['task'].value = pressbutton;
	if ( typeof(document.forms['adminForm']) != 'undefined' ) {
		try {
			document.forms['adminForm'].onsubmit();
			}
		catch(e){}
	}
	document.forms['adminForm'].submit();
}

/**
* general cb DOM events handler
*/

var cbW3CDOM = (document.createElement && document.getElementsByTagName);

function cbGetElementsByClass(searchClass,node,tag) {
	var classElements = new Array();
	if ( node == null )
		node = document;
	if ( tag == null )
		tag = '*';
	var els = node.getElementsByTagName(tag);
	var elsLen = els.length;
	var pattern = new RegExp('(^|\\s)'+searchClass+'(\\s|$)');
	for (i = 0, j = 0; i < elsLen; i++) {
		if ( pattern.test(els[i].className) ) {
			classElements[j] = els[i];
			j++;
		}
	}
	return classElements;
}

function cbAddEvent(obj, evType, fn){
	if (obj.addEventListener){
		obj.addEventListener(evType, fn, true);
		return true;
	} else if (obj.attachEvent){
		var r = obj.attachEvent("on"+evType, fn);
		return r;
	} else {
		return false;
	}
}

function cbAddEventObjArray(objArr, evType, fn){
	for (var j=0;j<objArr.length;j++) {
		if (objArr[j].type != 'hidden') {
			eval('objArr[j].on' + evType + '=fn');
			/* cbAddEvent( objArr[j], evType, fn ); */
		}
	}
}

/**
* CB filters events handler
*/
function cbInitFiltersBlur()
{
	if (!cbW3CDOM) return;
	var nav = cbGetElementsByClass('cbFilters');
	if ((nav.length == 1) && (nav[0].getElementsByTagName('input').length == 1)) {		//TBD TEST!
		for (var i=0;i<nav.length;i++) {
			cbAddEventObjArray( nav[i].getElementsByTagName('input'),  'change', cbFilterInputBlur );
			cbAddEventObjArray( nav[i].getElementsByTagName('select'), 'change', cbFilterInputBlur );
		}
	}
}

function cbFilterInputBlur(thisevent) {
//	var mine;
//	if (thisevent) {
//		mine = (thisevent.target.parentNode == this);
//	} else if (window.event.target) {
//		mine = (window.event.target==window.event.currentTarget);
//	} else if (window.event.srcElement) {
//		mine = (window.event.srcElement.parentNode == this);
//	}
//	if (mine) {
		cbParentForm(this).submit();
		return false;
//	}
//	return !mine;
}

cbAddEvent(window, 'load', cbInitFiltersBlur);

/**
* CB hide and set fields depending on other fields:
*/

var cbHideFields = new Array();
var cbParamsSaveBefHide = new Array();
var cbSels = new Array();

function cbGetDisplayStyle( dt ) {
	var ds;
	if (dt.style.getPropertyValue) {
		ds = dt.style.getPropertyValue("display");
	} else {
		ds = dt.style.display;
	}
	return ds;
}
/**
* CB change params hidding/showing actions
*/
function cbParamChange() {
	var fieldsToShow = new Array()
	var fieldsToHide = new Array()
	var fieldsToSet  = new Array()
	var fieldsToRestore = new Array()
	var value;
	for (var i=0;i<cbHideFields.length;i++) {
		for (var j=1;j<cbSels[i].length;j++) {
			if (cbSels[i][j].type != 'hidden') {
				/*
				var name = cbSels[i][j].name;
				if ( name.substr(-2, 2)  == '[]' ) {
					name = name.substr(0, name.length-2);
				}
				*/
				if ((cbSels[i][j].type == 'radio') || (cbSels[i][j].type == 'checkbox') ) {
					if ( cbSels[i][j].checked ) {
						value = cbSels[i][j].value;
					}
				} else {
					value = cbSels[i][j].value;
				}
			}
		}
		// already the case: if (cbHideFields[1] == cbSels[i][0].id)
		var cMatch = false;
		switch (cbHideFields[i][2]) {
			case '==': if ( value == cbHideFields[i][3] ) { cMatch = true; } break;
			case '!=': if ( value != cbHideFields[i][3] ) { cMatch = true; } break;
			case '>=': if ( value >= cbHideFields[i][3] ) { cMatch = true; } break;
			case '<=': if ( value <= cbHideFields[i][3] ) { cMatch = true; } break;
			case '>' : if ( value >  cbHideFields[i][3] ) { cMatch = true; } break;
			case '<' : if ( value <  cbHideFields[i][3] ) { cMatch = true; } break;
			case 'regexp' :
				var cbRegexp = new RegExp(cbHideFields[i][3]);
				cMatch = ( ! cbRegexp.test(value) );
				break;
			default: alert('js error operator "'+cbHideFields[i][2]+'" unknown.');
		}
		if ( cMatch ) {
			fieldsToHide = fieldsToHide.concat( cbHideFields[i][4] );
			if ( cbHideFields[i][5].length > 0 ) {
				fieldsToSet  = fieldsToSet.concat( i );
			}
		} else {
			fieldsToShow = fieldsToShow.concat( cbHideFields[i][4] );
			if ( cbHideFields[i][5].length > 0 ) {
				fieldsToRestore  = fieldsToSet.concat( i );
			}
		}
	}
	for (var i=0;i<fieldsToSet.length;i++) {
		if ( cbGetDisplayStyle( document.getElementById( cbHideFields[fieldsToSet[i]][0] ) ) != 'none' ) {
			for (var j=0;j<cbHideFields[fieldsToSet[i]][5].length;j++) {
				var nameValue  = cbHideFields[fieldsToSet[i]][5][j].split('=',3);
				if ( cbGetDisplayStyle( document.getElementById( nameValue[0] ) ) != 'none' ) {
					var inputToSet = document.getElementById( nameValue[1] );
					if (typeof(cbParamsSaveBefHide[fieldsToSet[i]])=='undefined') {
						cbParamsSaveBefHide[fieldsToSet[i]] = new Array();
					}
					cbParamsSaveBefHide[fieldsToSet[i]][j] = inputToSet.value;
					inputToSet.value = nameValue[2];
				}
			}
		}
	}
	for (var i=0;i<fieldsToRestore.length;i++) {		// TBD:Opera doesn't restore correctly with radio choice
		if ( cbGetDisplayStyle( document.getElementById( cbHideFields[fieldsToRestore[i]][0] ) ) != 'none' ) {
			for (var j=0;j<cbHideFields[fieldsToRestore[i]][5].length;j++) {
				var nameValue  = cbHideFields[fieldsToRestore[i]][5][j].split('=',3);
				if ( cbGetDisplayStyle( document.getElementById( nameValue[0] ) ) == 'none' ) {
					var inputToSet = document.getElementById( nameValue[1] );
					inputToSet.value = cbParamsSaveBefHide[fieldsToRestore[i]][j];
				}
			}
		}
	}
	for (var i=0;i<fieldsToShow.length;i++) {
		document.getElementById(fieldsToShow[i]).style.display = '';
	}
	for (var i=0;i<fieldsToHide.length;i++) {
		document.getElementById(fieldsToHide[i]).style.display = 'none';
	}
}

function cbInitFields()
{
	if (!cbW3CDOM) return;
	if (typeof(cbHideFields)=='undefined') return;

	for (var i=0;i<cbHideFields.length;i++) {
		var inputDom = document.getElementById(cbHideFields[i][0]);
		var sels = inputDom.getElementsByTagName('input');
		if ( sels.length == 0 ) {
			sels = inputDom.getElementsByTagName('select');
		}
		var k = 1;
		cbSels[i] = new Array();
		cbSels[i][0] = inputDom;
		for (var j=0;j<sels.length;j++) {
			if (sels[j].type != 'hidden') {
				if (sels[j].type == 'text') {
					cbAddEvent( sels[j], 'change', cbParamChange );
				} else {
					cbAddEvent( sels[j], 'click', cbParamChange );
				}
				cbSels[i][k++] = sels[j];
			}
		}
	}
	cbParamChange();
}

cbAddEvent(window, 'load', cbInitFields);


/**
* CB basic ajax library (experimental)
*/


function CBgetHttpRequestInstance() {
	var http_request = false;

	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		http_request = new XMLHttpRequest();
		if (http_request.overrideMimeType) {
			http_request.overrideMimeType('text/xml');
		}
	} else if (window.ActiveXObject) { // IE
		try {
			http_request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				http_request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}
	return http_request;
}

function CBmakeHttpRequest(url, id, errorText, postsVars, http_request) {
	if ((arguments.length < 5) || (http_request==null) ) {
		http_request = CBgetHttpRequestInstance();
	}
	if (!http_request) {
		// alert('Giving up: Cannot create an XMLHTTP instance');
		return false;
	}
	http_request.cbId = id;
	http_request.cbErrorText = errorText;
	http_request.onreadystatechange = function() { CBalertContents(http_request); };
	if (postsVars == null) {
		http_request.open('GET', url, true);
		http_request.send(null);
	} else {
		http_request.open('POST', url, true);
		http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http_request.setRequestHeader("Content-length", postsVars.length);
		http_request.send(postsVars);
	}
}

function CBalertContents(http_request) {
	if (http_request.readyState == 4) {
		if ((http_request.status == 200) && (http_request.responseText.length < 1025)) {
			document.getElementById(http_request.cbId).innerHTML = http_request.responseText;
		} else {
			document.getElementById(http_request.cbId).innerHTML = http_request.cbErrorText;
		}
	}
}

/*
* Safari 1.3 + 2.0 labels fix:
*/

function cbAddLabelFocus() {
	var item = document.getElementById(this.getAttribute("for"));
	item.focus();
	if (item.getAttribute("type") == "checkbox") {
		if (!item["checked"]) {
			item["checked"] = true;
		} else {
			item["checked"] = false;
		}
	} else if (item.getAttribute("type") == "radio") {
		var allRadios = document.getElementsByTagName("input");
		var radios = new Array();
		for (i = 0; i < allRadios.length; i++) {
			if (allRadios[i].getAttribute("name") == item.getAttribute("name")) {
				radios.push(allRadios[i]);
			}
		}
		for (i = 0; i < radios.length; i++) {
			if (radios[i]["checked"] &&
			radios[i].getAttribute("id") != item.getAttribute("id")) {
				radios[i]["checked"] = false;
			}
		}
		item["checked"] = true;
	}
}
if (navigator.userAgent.indexOf("Safari") > 0) {
	var labels = document.getElementsByTagName("label");
	for (i = 0; i < labels.length; i++) {
		labels[i].addEventListener("click", cbAddLabelFocus, true);
		// labels[i].style.background = "red";
	}
}
