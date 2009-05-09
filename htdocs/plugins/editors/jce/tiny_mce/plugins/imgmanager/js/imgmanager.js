var ImageManagerDialog = {
	preInit : function() {
		tinyMCEPopup.requireLangPack();
	},
	init : function() {
		var ed = tinyMCEPopup.editor, n = ed.selection.getNode(), br;
		tinyMCEPopup.resizeToInnerSize();		
		// Convert from absolute to relative
		var src = ed.documentBaseURI.toRelative(ed.dom.getAttrib(n, 'src'));
		
		// Setup Manager plugin
		this.imgmanager = initManager(src);
		
		TinyMCE_Utils.fillClassList('classlist');
	
		if (n.nodeName == 'IMG') {
			dom.value('src', src);
			dom.value('width', ed.dom.getAttrib(n, 'width') || ed.dom.getStyle(n, 'width') || n.width || '');
			dom.value('height', ed.dom.getAttrib(n, 'height') || ed.dom.getStyle(n, 'height') || n.height || '');
			dom.value('tmp-width', dom.value('width'));
			dom.value('tmp-height', dom.value('height'));
			
			dom.value('alt', ed.dom.getAttrib(n, 'alt'));
			dom.value('title', ed.dom.getAttrib(n, 'title'));
			dom.value('vspace', this.getAttrib(n, 'vspace'));
			dom.value('hspace', this.getAttrib(n, 'hspace'));
			dom.setSelect('border_width', this.getAttrib(n, 'border-width'));
			dom.setSelect('border_style', this.getAttrib(n, 'border-style'));
			dom.value('border_color', this.getAttrib(n, 'border-color'));
			dom.setSelect('align', this.getAttrib(n, 'align'));
			dom.setSelect('classlist', ed.dom.getAttrib(n, 'class'));
			dom.value('style', ed.dom.getAttrib(n, 'style'));
			dom.value('id', ed.dom.getAttrib(n, 'id'));
			dom.value('dir', ed.dom.getAttrib(n, 'dir'));
			dom.value('lang', ed.dom.getAttrib(n, 'lang'));
			dom.value('usemap', ed.dom.getAttrib(n, 'usemap'));
			dom.value('insert', ed.getLang('update'));
			
			// Longdesc may contain absolute url too
			var longdesc = ed.dom.getAttrib(n, 'longdesc');
			if(longdesc.indexOf(ed.getParam('document_base_url')) != -1){
				longdesc = ed.documentBaseURI.toRelative(longdesc);
			}
			dom.value('longdesc', longdesc)
			dom.value('onmouseoutsrc', src);
			
			if (/^\s*this.src\s*=\s*\'([^\']+)\';?\s*$/.test(ed.dom.getAttrib(n, 'onmouseover'))){
				var onmouseoversrc 	= ed.dom.getAttrib(n, 'onmouseover').replace(/^\s*this.src\s*=\s*\'([^\']+)\';?\s*$/, '$1')
				onmouseoversrc 		= ed.documentBaseURI.toRelative(onmouseoversrc);
				dom.value('onmouseoversrc', onmouseoversrc);
			}

			if (/^\s*this.src\s*=\s*\'([^\']+)\';?\s*$/.test(ed.dom.getAttrib(n, 'onmouseout'))){
				var onmouseoutsrc 	= ed.dom.getAttrib(n, 'onmouseout').replace(/^\s*this.src\s*=\s*\'([^\']+)\';?\s*$/, '$1')
				onmouseoutsrc 		= ed.documentBaseURI.toRelative(onmouseoutsrc);
				dom.value('onmouseoutsrc', onmouseoutsrc);
			}
			
			br = n.nextSibling;
			if(br && br.nodeName == 'BR' && ed.dom.getStyle(br, 'clear')){
				dom.setSelect('clear', ed.dom.getStyle(br, 'clear'));
			}

		}else{
			// Setup default values
			this.setDefaults();	
		}
		dom.html('border_color_pickcontainer', TinyMCE_Utils.getColorPickerHTML('border_color'));
	
		// Setup browse button
		dom.html('longdesccontainer', TinyMCE_Utils.getBrowserHTML('longdescbrowser','longdesc','file','imgmanager'));
	
		// Check swap image if valid data
		if (dom.value('onmouseoversrc') && dom.value('onmouseoutsrc')){
			dom.check('onmousemovecheck', true);
			this.setSwapImage();
		}else{
			dom.check('onmousemovecheck', false);
			this.setSwapImage();
		}
		this.updateStyles();
		this.setBorder();
		TinyMCE_EditableSelects.init();
	},
	setDefaults : function(){
		var d = this.imgmanager.getParam('defaults');
		
		for(n in d){
			if(n == 'align' && d[n] == 'default'){
				dom.value('align', '');
			}else if(n == 'border'){
				dom.check('border', parseInt(d[n]));
			}else if(n == 'border_width'){
				dom.value('border_width', d[n] + 'px');
			}else{
				dom.value(n, d[n]);
			}
		}
	},
	insert : function(){
		var ed = tinyMCEPopup.editor, t = this;

		if (dom.value('src') === '') {
			ed.dom.remove(ed.selection.getNode());
			ed.execCommand('mceRepaint');
			tinyMCEPopup.close();
			return;
		}

		if (tinyMCEPopup.getParam("accessibility_warnings", 1)) {
			if (dom.value('alt') === '') {
				tinyMCEPopup.editor.windowManager.confirm(tinyMCEPopup.getLang('imgmanager_dlg.missing_alt'), function(s) {
					if (s)
						t.insertAndClose();
				});
				return;
			}
		}
		t.insertAndClose();
	},
	insertAndClose : function() {
		var ed = tinyMCEPopup.editor, v, args = {}, el, br = '';
		
		this.updateStyles();

		// Fixes crash in Safari
		if (tinymce.isWebKit)
			ed.getWin().focus();

		if (!ed.settings.inline_styles) {
			args = {
				vspace : dom.value('vspace'),
				hspace : dom.value('hspace'),
				border : dom.value('border'),
				align : dom.getSelect('align')
			};
		} else {
			// Remove deprecated values
			args = {
				vspace : '',
				hspace : '',
				border : '',
				align : ''
			};
		}

		tinymce.extend(args, {
			src : dom.value('src'),
			width : dom.value('width'),
			height : dom.value('height'),
			alt : dom.value('alt'),
			title : dom.value('title'),
			'class' : dom.getSelect('classlist'),
			style : dom.value('style'),
			id : dom.value('id'),
			dir : dom.getSelect('dir'),
			lang : dom.value('lang'),
			usemap : dom.value('usemap'),
			longdesc : dom.value('longdesc')
		});

		args.onmouseover = args.onmouseout = '';

		if (dom.ischecked('onmousemovecheck')){
			var onmouseoversrc 	= dom.value('onmouseoversrc');
			var onmouseoutsrc 	= dom.value('onmouseoutsrc');
			
			if(!ed.getParam('relative_urls')){
				onmouseoversrc 	= new tinymce.util.URI(ed.getParam('document_base_url')).toAbsolute(onmouseoversrc);	
				onmouseoutsrc 	= new tinymce.util.URI(ed.getParam('document_base_url')).toAbsolute(onmouseoutsrc);	
			}			
			if (dom.value('onmouseoversrc')){
				args.onmouseover = "this.src='" + onmouseoversrc + "';";
			}
			if (dom.value('onmouseoutsrc')){
				args.onmouseout = "this.src='" + onmouseoutsrc + "';";
			}
		}

		el = ed.selection.getNode();
		br = el.nextSibling;
				
		if (el && el.nodeName == 'IMG') {
			ed.dom.setAttribs(el, args);
			// BR clear
			if(br && br.nodeName == 'BR'){
				if(dom.disabled('clear') || dom.getSelect('clear') === ''){
					ed.dom.remove(br);	
				}
				if(!dom.disabled('clear') && dom.getSelect('clear') !== ''){
					ed.dom.setStyle(br, 'clear', dom.getSelect('clear'));
				}
			}else{
				if(!dom.disabled('clear') && dom.getSelect('clear') !== ''){
					br = ed.dom.create('br');
					ed.dom.setStyle(br, 'clear', dom.getSelect('clear'));
					ed.dom.insertAfter(br, el);
				}
			}
		} else {
			ed.execCommand('mceInsertContent', false, '<img id="__mce_tmp" src="javascript:;" />', {skip_undo : 1});
			el = ed.dom.get('__mce_tmp');
			if(!dom.disabled('clear') && dom.getSelect('clear') !== ''){
				br = ed.dom.create('br');
				ed.dom.setStyle(br, 'clear', dom.getSelect('clear'));
				ed.dom.insertAfter(br, el);
			}			
			ed.dom.setAttribs('__mce_tmp', args);
			ed.dom.setAttrib('__mce_tmp', 'id', '');
			ed.undoManager.add();
		}

		tinyMCEPopup.close();
	},
	getAttrib : function(e, at) {
		var ed = tinyMCEPopup.editor, v, v2;

		if(ed.settings.inline_styles){
			switch (at) {
				case 'align':
					if(v = ed.dom.getStyle(e, 'float')){
						return v;
					}
					if(v = ed.dom.getStyle(e, 'vertical-align')){
						return v;
					}
					break;
				case 'hspace':
					v = ed.dom.getStyle(e, 'margin-left')
					v2 = ed.dom.getStyle(e, 'margin-right');

					if(v && v == v2){
						return parseInt(v.replace(/[^0-9]/g, ''));
					}
					break;
				case 'vspace':
					v = ed.dom.getStyle(e, 'margin-top')
					v2 = ed.dom.getStyle(e, 'margin-bottom');
					if(v && v == v2){
						return parseInt(v.replace(/[^0-9]/g, ''));
					}
					break;
				case 'border-width':
					v = 0;
					tinymce.each(['top', 'right', 'bottom', 'left'], function(sv) {
						sv = ed.dom.getStyle(e, 'border-' + sv + '-width');

						// False or not the same as prev
						if(!sv || (sv != v && v !== 0)){
							v = 0;
							return false;
						}
						if (sv){
							v = sv;
						}
					});

					if(v){
						dom.check('border', true);
						return parseInt(v.replace(/[^0-9]/g, ''));
					}
					break;
				case 'border-style':
					return ed.dom.getStyle(e, 'borderStyle');
					break;
				case 'border-color':
					return string.toHex(ed.dom.getStyle(e, 'borderColor'));
					break;
			}
		}
		if(v = ed.dom.getAttrib(e, at)){
			return v;
		}
		return '';
	},
	setSwapImage : function() {
		var st = dom.ischecked('onmousemovecheck');
		
		dom.disable('onmouseoversrc', !st);
		dom.disable('onmouseoutsrc', !st);
	},
	setBorder : function(){
		if(dom.ischecked('border')){
			dom.disable('border_width', false); 
			dom.disable('border_style', false);
			dom.disable('border_color', false);
		}else{
			dom.disable('border_width', true); 
			dom.disable('border_style', true);
			dom.disable('border_color', true);
		}
		this.updateStyles();
	},
	updateStyles : function(ty) {
		var ed = tinyMCEPopup, st, v, br, img = dom.get('sample');
		
		if(ty == 'dir'){
			return ed.dom.setAttrib(img, 'dir', dom.value('dir'));
		}
		
		if (tinyMCEPopup.editor.settings.inline_styles) {
			// Handle align
			ed.dom.setStyle(img, 'float', '');
			ed.dom.setStyle(img, 'vertical-align', '');

			v = dom.getSelect('align');
			if (v == 'left' || v == 'right'){
				dom.disable('clear', false);
				dom.removeClass('clearlabel', 'disabled');					
				ed.dom.setStyle(img, 'float', v);
			}else{
				img.style.verticalAlign = v;
				dom.disable('clear', true);
				dom.addClass('clearlabel', 'disabled');	
			}
			// Handle clear
			v = dom.getSelect('clear');
			if (v && !dom.disabled('clear')) {
				br = dom.get('sample-br');
				if(!br){
					br = ed.dom.create('br', {'id': 'sample-br'});
					ed.dom.insertAfter(br, img);
				}
				ed.dom.setStyle(br, 'clear', v);
			}else{
				if(dom.get('sample-br')){
					ed.dom.remove('sample-br');
				}
			}
			
			// Handle border
			if(dom.ischecked('border')) {
				ed.dom.setStyle(img, 'borderWidth', '');
				ed.dom.setStyle(img, 'borderColor', '');
				ed.dom.setStyle(img, 'borderStyle', '');

				v = dom.value('border_width');
				if (v || v == '0') {
					img.style.borderWidth = v + 'px';
				}
				v = dom.value('border_color');
				if (v) {
					img.style.borderColor = v;
				}
				v = dom.value('border_style');
				if (v) {
					img.style.borderStyle = v;
				}
			}else{
				ed.dom.setStyle(img, 'borderWidth', '');
				ed.dom.setStyle(img, 'borderColor', '');
				ed.dom.setStyle(img, 'borderStyle', '');	
			}
			// Handle hspace
			ed.dom.setStyle(img, 'marginLeft', '');
			ed.dom.setStyle(img, 'marginRight', '');

			v = dom.value('hspace');
			if (v) {
				img.style.marginLeft = v + 'px';
				img.style.marginRight = v + 'px';
			}
			// Handle vspace
			ed.dom.setStyle(img, 'marginTop', '');
			ed.dom.setStyle(img, 'marginBottom', '');

			v = dom.value('vspace');
			if (v) {
				img.style.marginTop = v + 'px';
				img.style.marginBottom = v + 'px';
			}
			// Merge
			ed.dom.get('style').value = ed.dom.serializeStyle(ed.dom.parseStyle(img.style.cssText));
		}
	}
}
var ImageManager = Manager.extend({
	otherOptions : function(){
		return {
			onFileClick : function(file){
				this.selectFile(file);
			}
		};
	},
	initialize : function(src, options){
		this.setOptions(this.otherOptions(), options);
		this.parent('imgmanager', src, '', this.options);
	},
	selectFile : function(title){
		var url		= string.path(this.getDir(), title);
		var src 	= string.path(this.getParam('base'), url);
			
		if(dom.hasClass('swap_panel', 'current') && dom.ischecked('onmousemovecheck') ){
			if(dom.value('onmouseoutsrc') == ''){
				dom.value('onmouseoutsrc', src);
			}else{
				dom.value('onmouseoversrc', src);
			}
		}else{		
			dom.disable('insert', true);
			dom.value('title', title);
			dom.value('alt', title);
			dom.value('onmouseoutsrc', src);
			dom.value('src', src);
					
			$('dim_loader').className = 'loader-on';
			this.json('getDimensions', [url], function(o){
				if(!o.error){
					dom.value('width', o.width);
					dom.value('tmp-width', o.width);
					dom.value('height', o.height);
					dom.value('tmp-height', o.height);
				}
				$('dim_loader').className = 'loader-off';
				dom.disable('insert', false);
				ImageManagerDialog.updateStyles();										
			});
		}
	}
});
ImageManager.implement(new Events, new Options);
ImageManagerDialog.preInit();
tinyMCEPopup.onInit.add(ImageManagerDialog.init, ImageManagerDialog);