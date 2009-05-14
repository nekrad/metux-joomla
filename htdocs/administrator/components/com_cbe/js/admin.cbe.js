	function getObject(obj) {
		var strObj;
		if (document.all) {
			strObj = document.all.item(obj);
		} else if (document.getElementById) {
			strObj = document.getElementById(obj);
		}
		return strObj;
	}
	function shDiv(objID,sh) {
		var strObj;
		strObj = getObject(objID);
		if(sh==0) {
			strObj.style.display="none";
		} else {
			strObj.style.display="block";
		}
	}
	function submitbutton(pressbutton) {
		if (pressbutton == 'showLists') {
			submitform( pressbutton );
			return;
		}
		var coll = document.adminForm;
		var errorMSG = '';
		var iserror=0;
		if (coll.col1enabled.checked == true) coll.col1title.setAttribute('mosReq',1);
		if (coll.col2enabled.checked == true) coll.col2title.setAttribute('mosReq',1);
		if (coll.col3enabled.checked == true) coll.col3title.setAttribute('mosReq',1);
		if (coll.col4enabled.checked == true) coll.col4title.setAttribute('mosReq',1);
		getSortList(document.adminForm.sort);
		getFilterList(document.adminForm.filter);
		if (coll != null) {
			var elements = coll.elements;
			// loop through all input elements in form
			for (var i=0; i < elements.length; i++) {
				// check if element is mandatory; here mosReq=1
				if (elements.item(i).getAttribute('mosReq') == 1) {
					if (elements.item(i).value == '') {
						//alert(elements.item(i).getAttribute('mosLabel') + ':' + elements.item(i).getAttribute('mosReq'));
						// add up all error messages
						errorMSG += elements.item(i).getAttribute('mosLabel') + ' <?php echo _UE_REQUIRED_ERROR; ?>\n';
						// notify user by changing background color, in this case to red
						elements.item(i).style.background = "red";
						iserror=1;
					}
				}
			}
		}
		if(iserror==1) { alert(errorMSG); }
		else {
			selectAll(document.adminForm.col1);
			selectAll(document.adminForm.col2);
			selectAll(document.adminForm.col3);
			selectAll(document.adminForm.col4);
			submitform( pressbutton );
		}

	}

	function addOption(selectObj, value)
	{
		optionSelected = (value == null);
		if(value == null) value = prompt('', '');
		if(value != null)
		{
			if(value.indexOf(',') != -1)
			alert('Commas are not allowed in size values');
			else
			{
				var i = selectObj.options.length;
				value = value.replace(/1\/2/g, '�');
				selectObj.options.length = i + 1;
				selectObj.options[i].value = (value != '' && value != ' ') ? value : ' ';
				selectObj.options[i].text = (value != '' && value != ' ') ? value : '[empty]';
				selectObj.options[i].selected = optionSelected;
				// uncomment the line below if you want the select list to change it's size to match the number of options it contains.
				//          selectObj.size = selectObj.options.length;
			}
		}
	}

	function editOptions(selectObj)
	{
		for(var i = 0; i < selectObj.options.length; i++)
		{
			if(selectObj.options[i].selected)
			{
				var value = prompt('', selectObj.options[i].value);
				if(value != null)
				{
					if(value.indexOf(',') != -1)
					alert('Commas are not allowed in size values');
					else
					{
						selectObj.options[i].value = value;
						selectObj.options[i].text = (value != '') ? value : '[empty]';
						selectObj.options[i].selected = true;
					}
				}
			}
		}
	}

	function deleteOptions(selectObj)
	{
		for(var i = 0; i < selectObj.options.length; i++)
		{
			if(selectObj.options[i].selected)
			{
				for(var j = i; j < selectObj.options.length - 1; j++)
				{
					selectObj.options[j].value = selectObj.options[j + 1].value;
					selectObj.options[j].text = selectObj.options[j + 1].text;
					selectObj.options[j].selected = selectObj.options[j + 1].selected;
				}
				selectObj.options.length = selectObj.options.length - 1;
				i--;
			}
		}
	}

	function moveOptions(selectObj, direction)
	{
		if(selectObj.selectedIndex != -1)
		{
			if(direction < 0)
			{
				for(i = 0; i < selectObj.options.length; i++)
				{
					swapValue = (i == 0 || selectObj.options[i + direction].selected) ? null : selectObj.options[i + direction].value;
					swapText = (i == 0 || selectObj.options[i + direction].selected) ? null : selectObj.options[i + direction].text;
					if(selectObj.options[i].selected && swapValue != null && swapText != null)
					{
						thisValue = selectObj.options[i].value;
						thisText = selectObj.options[i].text;
						selectObj.options[i].value = swapValue;
						selectObj.options[i].text = swapText;
						selectObj.options[i + direction].value = thisValue;
						selectObj.options[i + direction].text = thisText;
						selectObj.options[i].selected = false;
						selectObj.options[i + direction].selected = true;
					}
				}
			}
			else
			{
				for(i = selectObj.options.length - 1; i >= 0; i--)
				{
					swapValue = (i == selectObj.options.length - 1 || selectObj.options[i + direction].selected) ? null : selectObj.options[i + direction].value;
					swapText = (i == selectObj.options.length - 1 || selectObj.options[i + direction].selected) ? null : selectObj.options[i + direction].text;
					if(selectObj.options[i].selected && swapValue != null && swapText != null)
					{
						thisValue = selectObj.options[i].value;
						thisText = selectObj.options[i].text;
						selectObj.options[i].value = swapValue;
						selectObj.options[i].text = swapText;
						selectObj.options[i + direction].value = thisValue;
						selectObj.options[i + direction].text = thisText;
						selectObj.options[i].selected = false;
						selectObj.options[i + direction].selected = true;
					}
				}
			}
		}
	}
	var NS4 = (document.layers);

	function moveOption(fromObj, toObj)
	{
		for(var i = fromObj.options.length - 1; i >= 0; i--)
		{
			if(fromObj.options[i].selected)
			{
				fromObj.options[i].selected = false;
				optionText = fromObj.options[i].text.replace(' [ASC]','');
				optionText = optionText.replace(' [DESC]','');
				optionValue = fromObj.options[i].value.replace(' ASC','');
				optionValue = optionValue.replace(' DESC','');
				for(var j = i; j < fromObj.options.length - 1; j++)
				{
					fromObj.options[j].text = fromObj.options[j + 1].text;
					fromObj.options[j].value = fromObj.options[j + 1].value;
				}
				fromObj.options.length = fromObj.options.length - 1;
				toObjIndex = toObj.options.length;
				toObj.options.length = toObj.options.length + 1;
				toObj.options[toObjIndex].text = optionText;
				toObj.options[toObjIndex].value = optionValue;
				if(NS4)
				history.go(0);
			}
		}
	}

	function moveOption2(fromObj, toObj, appendValue)
	{
		if(fromObj.options[fromObj.selectedIndex].selected)
		{
			fromObjIndex=fromObj.selectedIndex;
			fromObj.options[fromObjIndex].selected = false;
			optionText = fromObj.options[fromObjIndex].text+ ' ['+appendValue+']';
			optionValue = fromObj.options[fromObjIndex].value+' '+appendValue;
			for(var j = fromObjIndex; j < fromObj.options.length - 1; j++)
			{
				fromObj.options[j].text = fromObj.options[j + 1].text;
				fromObj.options[j].value = fromObj.options[j + 1].value;
			}
			fromObj.options.length = fromObj.options.length - 1;
			toObjIndex = toObj.options.length;
			toObj.options.length = toObj.options.length + 1;
			toObj.options[toObjIndex].text = optionText;
			toObj.options[toObjIndex].value = optionValue;
			toObj.options[toObjIndex].selected=false;
			if(NS4)
			history.go(0);
		}

	}

	function moveOption3(fromObj, toObj, comparison, condition)
	{
		if(fromObj.options[fromObj.selectedIndex].selected)
		{
			if((condition=='' || condition==null) && document.adminForm.condition.getAttribute('Req')==1) {
				alert("You must define a condition text!");
				return;
			}
			fromObjIndex=fromObj.selectedIndex;
			fromObj.options[fromObjIndex].selected = false;
			optionText = fromObj.options[fromObjIndex].text+ ' '+comparison+' '+condition;
			condition=condition.replace("'", "\\'");
			if(condition!='' && condition!=null) condition="'"+escape(condition)+"'";
			optionValue = fromObj.options[fromObjIndex].value+' '+comparison+condition;
			toObjIndex = toObj.options.length;
			toObj.options.length = toObj.options.length + 1;
			toObj.options[toObjIndex].text = optionText;
			toObj.options[toObjIndex].value = optionValue;
			toObj.options[toObjIndex].selected=false;
			if(NS4)
			history.go(0);
		}

	}
	function moveOption4(fromObj, toObj)
	{
		for(var i = fromObj.options.length - 1; i >= 0; i--)
		{
			if(fromObj.options[i].selected)
			{
				fromObj.options[i].selected = false;
				for(var j = i; j < fromObj.options.length - 1; j++)
				{
					fromObj.options[j].text = fromObj.options[j + 1].text;
					fromObj.options[j].value = fromObj.options[j + 1].value;
				}
				fromObj.options.length = fromObj.options.length - 1;
				if(NS4)
				history.go(0);
			}
		}
	}


	function getSortList(selectObj) {
		var sortfields='';
		var j=0;
		selectAll(selectObj);
		if(selectObj.selectedIndex != -1)
		{
			for(i = 0; i < selectObj.options.length; i++)
			{
				if(j>0) sortfields +=  ', ';
				sortfields +=  selectObj.options[i].value;
				j++
			}
			//alert(sortfields);
			document.adminForm.sortfields.value=sortfields;
		}
	}

	function getFilterList(selectObj) {
		var filterfields='';
		var j=0;
		var advType=getObject('ft2');
		var simType=getObject('ft1');
		//alert(simType.checked);
		if(simType.checked) {
			selectAll(selectObj);
			if(selectObj.selectedIndex != -1)
			{
				for(i = 0; i < selectObj.options.length; i++)
				{
					if(j>0) filterfields +=  ' AND ';
					filterfields +=  selectObj.options[i].value;
					j++
				}
				//alert(filterfields);
				if(filterfields!="") {
					document.adminForm.filterfields.value="s("+filterfields+")";
				} else {
					document.adminForm.filterfields.value="";
				}
			}
		} else {
			if(document.adminForm.advFilterText.value!="") {
				document.adminForm.filterfields.value="a("+escape(document.adminForm.advFilterText.value)+")";
			} else {
				document.adminForm.filterfields.value="";
			}
		}
	}

	function selectAll(selectObj)
	{
		if(selectObj.options.length)
		for(i = 0; i < selectObj.options.length; i++)
		selectObj.options[i].selected = true;
		return false;
	}

	function loadUGIDs(selectObj)
	{
		var UGIDs='';
		var j=0;
		if(selectObj.selectedIndex != -1)
		{
			for(i = 0; i < selectObj.options.length; i++)
			{
				if(selectObj.options[i].selected) {
					if(j>0) UGIDs +=  ', ';
					UGIDs +=  selectObj.options[i].value;
					j++;
				}
			}
			document.adminForm.usergroupids.value=UGIDs;
		}
	}
	function enableListColumn(colnum) {
		var oForm;
		var colName;
		oForm=document.adminForm;
		colName="col"+colnum;
		if(oForm.col1enabled.checked) {
			//alert("Enabled");

		} else {
			//alert("Disabled");
			oForm.col1title.readOnly=true;
			oForm.col1captions.disabled=true;
			//document.col1.disabled=true;
			oForm.col1up.disabled=true;
			oForm.col1down.disabled=true;
			oForm.col1remove.disabled=true;
			oForm.addcol1.disabled=true;
		}

	}
	function filterCondition(needCond) {
		if(needCond==0) {
			document.adminForm.condition.value="";
			document.adminForm.condition.readOnly=true;
			document.adminForm.condition.setAttribute("Req",0);
		} else {
			document.adminForm.condition.value="";
			document.adminForm.condition.readOnly=false;
			document.adminForm.condition.setAttribute("Req",1);
		}

	}

