var AdvLinkDialog = {
	preInit : function() {
		tinyMCEPopup.requireLangPack();
	},
	init : function() {
		var ed = tinyMCEPopup.editor, n = ed.selection.getNode(), action = 'insert';
		tinyMCEPopup.resizeToInnerSize();		

		dom.html('anchorlistcontainer', this.getAnchorListHTML('anchorlist','href'));
		dom.html('hrefbrowsercontainer', TinyMCE_Utils.getBrowserHTML('hrefbrowser','href','file','advlink'));
	
		el = ed.dom.getParent(n, "A");
		if (el != null && el.nodeName == "A"){
			action = "update";
		}
		
		TinyMCE_Utils.fillClassList('classlist');
		
		var target = advlink.getParam('target');
		if(target == 'default') target = '';

		dom.value('insert', tinyMCEPopup.getLang(action, 'Insert', true)); 
		dom.setSelect('targetlist', target);

		if (action == "update") {
			var href = ed.documentBaseURI.toRelative(ed.dom.getAttrib(el, 'href'));
			// Setup form data
			dom.value('href', href);
			dom.value('title', ed.dom.getAttrib(el, 'title'));
			dom.value('id', ed.dom.getAttrib(el, 'id'));
			dom.value('style', ed.dom.getAttrib(el, "style"));
			dom.value('rel', ed.dom.getAttrib(el, 'rel'));
			dom.value('rev', ed.dom.getAttrib(el, 'rev'));
			dom.value('charset', ed.dom.getAttrib(el, 'charset'));
			dom.value('hreflang', ed.dom.getAttrib(el, 'hreflang'));
			dom.value('dir', ed.dom.getAttrib(el, 'dir'));
			dom.value('lang', ed.dom.getAttrib(el, 'lang'));
			dom.value('tabindex', ed.dom.getAttrib(el, 'tabindex', typeof(el.tabindex) != "undefined" ? el.tabindex : ""));
			dom.value('accesskey', ed.dom.getAttrib(el, 'accesskey', typeof(el.accesskey) != "undefined" ? el.accesskey : ""));
			dom.value('type', ed.dom.getAttrib(el, 'type'));
			dom.value('onfocus', ed.dom.getAttrib(el, 'onfocus'));
			dom.value('onblur', ed.dom.getAttrib(el, 'onblur'));
			dom.value('onclick', ed.dom.getAttrib(el, 'onclick'));
			dom.value('ondblclick', ed.dom.getAttrib(el, 'ondblclick'));
			dom.value('onmousedown', ed.dom.getAttrib(el, 'onmousedown'));
			dom.value('onmouseup', ed.dom.getAttrib(el, 'onmouseup'));
			dom.value('onmouseover', ed.dom.getAttrib(el, 'onmouseover'));
			dom.value('onmousemove', ed.dom.getAttrib(el, 'onmousemove'));
			dom.value('onmouseout', ed.dom.getAttrib(el, 'onmouseout'));
			dom.value('onkeypress', ed.dom.getAttrib(el, 'onkeypress'));
			dom.value('onkeydown', ed.dom.getAttrib(el, 'onkeydown'));
			dom.value('onkeyup', ed.dom.getAttrib(el, 'onkeyup'));
			dom.value('target', ed.dom.getAttrib(el, 'target'));
			dom.value('classes', ed.dom.getAttrib(el, 'class'));
	
			// Select by the values
			dom.setSelect('targetlist', ed.dom.getAttrib(el, 'target'));
			dom.setSelect('dir', ed.dom.getAttrib(el, 'dir'));
			dom.setSelect('rel', ed.dom.getAttrib(el, 'rel'));
			dom.setSelect('rev', ed.dom.getAttrib(el, 'rev'));
	
	
			if (href.charAt(0) == '#')
				dom.setSelect('anchorlist', href);
	
			dom.setSelect('classlist', ed.dom.getAttrib(el, 'class'), true);
			dom.setSelect('targetlist', ed.dom.getAttrib(el, 'target'), true);
		}
		
		TinyMCE_EditableSelects.init();
		window.focus();
	},
	getAnchorListHTML : function(id, target){
		var ed = tinyMCEPopup.editor;
		var n = ed.getBody().getElementsByTagName("a");
	
		var html = "";
	
		html += '<select id="' + id + '" name="' + id + '" class="mceAnchorList" onfocus="tinyMCE.addSelectAccessibility(event, this, window);" onchange="this.form.' + target + '.value=';
		html += 'this.options[this.selectedIndex].value;">';
		html += '<option value="">---</option>';
	
		for (var i=0; i<n.length; i++) {
			if ((name = ed.dom.getAttrib(n[i], "name")) != "")
				html += '<option value="#' + name + '">' + name + '</option>';
		}
	
		html += '</select>';
	
		return html;
	},
	checkPrefix : function(n) {
		if (Validator.isEmail(n) && !/^\s*mailto:/i.test(n.value) && confirm(tinyMCEPopup.getLang('lang_is_email', 'The URL you entered seems to be an email address, do you want to add the required mailto: prefix?')))
			n.value = 'mailto:' + n.value;
	
		if (/^\s*www./i.test(n.value) && confirm(tinyMCEPopup.getLang('lang_is_external', 'The URL you entered seems to external link, do you want to add the required http:// prefix?')))
			n.value = 'http://' + n.value;
	},
	insert : function(){
		var ed = tinyMCEPopup.editor, el, elementArray, i, args = {};
	
		this.checkPrefix(dom.value('href'));
	
		el = ed.dom.getParent(ed.selection.getNode(), "A");
		tinyMCEPopup.execCommand("mceBeginUndoLevel");
			
		tinymce.extend(args, {
			href 		: dom.value('href'),
			title 		: dom.value('title'),
			target		: dom.getSelect('targetlist'),
			id 			: dom.value('id'),
			style 		: dom.value('style'),
			'class' 	: dom.getSelect('classlist') == '' ? dom.value('classes') : dom.getSelect('classlist'),
			rel 		: dom.value('rel'),
			rev 		: dom.value('rev'),
			charset 	: dom.value('charset'),
			hreflang 	: dom.value('hreflang'),
			dir 		: dom.value('dir'),
			lang 		: dom.value('lang'),
			tabindex 	: dom.value('tabindex'),
			accesskey 	: dom.value('accesskey'),
			type 		: dom.value('type'),
			onfocus 	: dom.value('onfocus'),
			onblur 		: dom.value('onblur'),
			onclick 	: dom.value('onclick'),
			ondblclick 	: dom.value('ondblclick'),
			onmousedown : dom.value('onmousedown'), 
			onmouseup 	: dom.value('onmouseup'),
			onmouseover : dom.value('onmouseover'),
			onmousemove : dom.value('onmousemove'),
			onmouseout 	: dom.value('onmouseout'), 
			onkeypress 	: dom.value('onkeypress'),
			onkeydown 	: dom.value('onkeydown'), 
			onkeyup 	: dom.value('onkeyup')
		});
	
		// Create new anchor elements
		if (el == null) {
			tinyMCEPopup.execCommand("CreateLink", false, "#mce_temp_url#");
			elementArray = tinymce.grep(ed.dom.select("a"), function(n) {return ed.dom.getAttrib(n, 'href') == '#mce_temp_url#';});
			for (i=0; i<elementArray.length; i++) {
				el = elementArray[i];
	
				// Move cursor to end
				try {
					tinyMCEPopup.editor.selection.collapse(false);
				} catch (ex) {
					// Ignore
				}
				ed.dom.setAttribs(el, args);
			}
		} else
			ed.dom.setAttribs(el, args);
	
		tinyMCEPopup.execCommand("mceEndUndoLevel");
		tinyMCEPopup.close();
	},
	buildAddress : function(){
		var address = dom.value('emailaddress');
		if(!Validator.isEmail(address)){
			alert(tinyMCEPopup.getLang('invalid_email', true, 'Invalid e-mail address!'));
		}else{
			subject = dom.value('emailsubject') !== '' ? '?subject=' + dom.value('emailsubject') : '';
			dom.value('href', 'mailto:' + address + subject);
		}
	},
	setClass : function(v){
		dom.value('classes', v);
	},
	setTargetList : function(v){
		dom.setSelect('targetlist', v, true);
	},
	setClassList : function(v){
		dom.setSelect('classlist', v, true);
	},
	insertLink : function(v){
		dom.value('href', v);
	},
	clearLists : function(){
		for(var i=1; i<=4; i++){
			if(dom.get('link-items-' + i)){
				dom.html('link-items-' + i, '');	
			}
		}
	},
	getList : function(type, level, id){
		var h, onchange, s;
		if(type){
			dom.setClass('loader', 'loader-on');
			advlink.json('getLinks', [type, level, id], function(o){			
				this.level = o.level;
				onchange = !o.next ? "AdvLinkDialog.insertLink(this.value);" : "AdvLinkDialog.getList('"+ o.next +"', "+ o.level +", this.value);";
				
				h = '<select class="link-items" onchange="' + onchange + '">';
				h += '<option value="">--'+ o.label +'--</option>';
				
				for(var i=0; i<o.items.length; i++){
					h += '<option value="'+ string.decode(o.items[i].value) +'">'+ string.decode(o.items[i].text) +'</option>';
				}				
				h += '</select>';
				dom.html('link-items-' + o.level || 1, h);
				dom.removeClass('loader', 'loader-on');
			});
		}
	}
}
AdvLinkDialog.preInit();
tinyMCEPopup.onInit.add(AdvLinkDialog.init, AdvLinkDialog);