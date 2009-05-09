//Requires mootools.js
var Dialog = new Class({
	getOptions : function(){
		return {			
			width: 250,
			height: 250,
			deltaWidth: 0,
			deltaHeight: 0,
			parent: 'body',
			onOpen: Class.empty,
			onClose: Class.empty,
			buttons: [{
				'text': tinyMCEPopup.getLang('dlg.cancel', 'Cancel'),
				'class': 'mceButton mceCancel',
				'click': function(){
					this.close();
				}.bind(this)
			}],
			features: {
				movable: true,
				resizable: true,
				minimize: false,
				modal: true,
				focus: true
			}
		};
	},
	initialize : function(type, title, body, options){
		this.setOptions(this.getOptions(), options);
		if (this.options.initialize) this.options.initialize.call(this);
		this.type 	= type;
		this.title 	= title;
		this.body 	= body;
		this.skin 	= tinyMCEPopup.editor.settings.inlinepopups_skin;
		this.id 	= 'inline-'+ this.type;					
		if($(this.id)) return;
		this.open();	
	},
	setContent : function(){
		var c = $(this.id + '-content-body');
		if($type(this.body) == 'string'){
			c.setHTML(this.body);
		}else{
			c.adopt(this.body);	
		}
	},
	open : function(){		
		this.features = ['mce' + this.type.capitalize()];
		for(n in this.options.features){
			if(this.options.features[n]){
				this.features.push('mce' + n.capitalize());	
			}
		}		
		this.dialog = new Element('div', {
			'class': this.skin,
			'id': this.id,
			'styles': {
				'width': this.options.width.toInt() + 2 + this.options.deltaWidth, 
				'height': this.options.height.toInt() + this.options.deltaHeight,
				'z-index': 1000
			}
		}).injectInside($E(this.options.parent));
		
		this.wrapper = new Element('div', {'class': 'mceWrapper ' + this.features.join(' ')}).adopt(
			new Element	('div').addClass('mceTop').adopt([
				new Element('div').addClass('mceLeft')	,																			 
				new Element('div').addClass('mceCenter'),
				new Element('div').addClass('mceRight'),
				new Element('span').setHTML(this.title)																			 
			])
		).adopt(
			new Element	('div').addClass('mceMiddle').adopt([
				new Element('div').addClass('mceLeft'),																				 
				new Element('span', {'id': this.id + '-content'}).adopt(
					new Element('div', {'id': this.id + '-content-body'})
				),
				new Element('div').addClass('mceRight'),
				new Element('div').addClass('mceIcon')
			])
		).adopt(
			new Element	('div').addClass('mceBottom').adopt([
				new Element('div').addClass('mceLeft'), 																				 
				new Element('div').addClass('mceCenter'),
				new Element('div').addClass('mceRight')
			])
		).adopt([
			new Element('a', {
				'href': 'javascript:;',
				'class': 'mceMove', 
				'events': {
					'mousedown': function(e){
						this.startMove(e);
					}.bind(this)
				}
			}),
			new Element('a', {
				'href': 'javascript:;',
				'class': 'mceClose', 
				'events': {
					'click': function(e){
						this.close();
					}.bind(this)
				}
			})
		]).adopt(this.getResizeHandles()).injectInside(this.dialog);
				
		this.setContent();
		this.addButtons();
			
		if(window.ie6){ 
			this.blocker = new Element('iframe', {
				'src': 'about:blank', 
				'frameborder': '0', 
				'scrolling': 'no',
				'class': 'blocker',
				styles : {
					width: window.getWidth(),
					height: window.getHeight()
				}
			}).injectInside(document.body);
		}
		if($(this.wrapper).hasClass('mceModal')){
			if(!$('inline-overlay')){
				this.overlay = new Element('div', {
					id: 'inline-overlay',
					'class': 'overlay',
					styles: {
						position: 'absolute',
						left: 0,
						top: 0,
						width: '100%',
						height: '100%',
						'background-color': '#fff',
						'z-index': 998
					}
				}).setOpacity(0.5).injectInside(document.body);	
			}
		}
		this.content = $(this.id + '-content');
		this.centerWindow();
		this.fireEvent('onOpen');
	},
	getResizeHandles : function(){
		var points = ['S', 'E', 'SE'];
		var links = [];
		points.each(function(el){
			links.push(
				new Element('a', {
					'href': 'javascript:;',
					'class': 'mceResize mceResize' + el,
					'events': {
						'mousedown': function(e){
							this.startResize(e, el);
						}.bind(this)
					}
				})
			)
		}.bind(this))
		return links;
	},
	addButtons : function(){
		if(this.options.buttons.length > 0){
			this.options.buttons.each(function(b){
				$(this.wrapper).adopt(
					new Element('a', {
						'href': 'javascript:;',
						'class': 'mceButton',
						'events': {
							'click': function(args){
								b['click'].pass(args, this)();
							}
						}
					}).addClass(b['class'] || '').setHTML(b.text)						  
				)								   
			}.bind(this));
		}
	},
	centerWindow : function(){
		var s 	= $(this.dialog).getSize().size;
		var w 	= window.getSize().size;
				
		var x = w.x / 2 - s.x / 2;
		var y = w.y / 2 - s.y / 2;
		
		$(this.dialog).setStyles({'left': x + 'px', 'top': y + 'px'});	
	},
	setWidth: function(w){
		if(w.toInt() < 250) w = 250;
		this.options.width = w.toInt();
		this.dialog.setStyle('width', w.toInt() + 'px');
	},
	setHeight: function(h){
		if(h.toInt() < 250) h = 250;
		this.options.height = h.toInt();
		this.dialog.setStyle('height', this.options.height + 'px');
	},
	close : function() {			
		this.fireEvent('onClose');
		if(this.content){
			this.content.remove();
		}
		if(this.dialog){
			this.dialog.remove();
		}
		if(window.ie6){
			this.blocker.remove();
		}
		if(this.overlay){
			this.overlay.remove();
		}
		this.type 	= null;
		this.id 	= null;
	},
	startResize : function(e, dir){
		e = new Event(e).stop();
		var d	= $(this.dialog);
		var s 	= d.getSize();
		var ph = new Element('div', {
			'class': 'mcePlaceHolder', 
			'styles': {
				width: s.size.x,
				height: s.size.y
			}
		}).injectInside(d);
		ph.makeResizable({
			limit: {
				x: [this.options.width, this.options.width * 2], 
				y: [this.options.height, this.options.height * 2]
			},
			modifiers: {
				x: dir.test(/e|se/i) ? 'width' : false, 
				y: dir.test(/s|se/i) ? 'height' : false
			},
			onComplete: function(){
				var s 	= $(ph).getSize();
				d.setStyles({
					width: s.size.x,
					height: s.size.y
				})
				$(ph).remove();
			}	
		}).start(e);
	},
	startMove : function(e){
		e = new Event(e).stop();
		var d	= $(this.dialog);
		var s 	= d.getSize();
		var ph = new Element('div', {
			'class': 'mcePlaceHolder', 
			'styles': {
				width: s.size.x,
				height: s.size.y
			}
		}).injectInside(d);
		ph.makeDraggable({
			onComplete: function(){
				d.setStyles({
					top: $(ph).getTop(),
					left: $(ph).getLeft()
				})
				$(ph).remove();
			}	
		}).start(e);
	}
});
Dialog.implement(new Options);
Dialog.implement(new Events);

var Alert = Dialog.extend({
    getExtended : function(){
		return {
			width: 300,
			height: 150,
			buttons: [{
				'text': tinyMCEPopup.getLang('dlg.ok', 'OK'),
				'class': 'mceOk',
				'click': function(){
					this.close();
				}.bind(this)
			}]
		}
	},
	initialize: function(html, options){
        this.setOptions(this.getExtended(), options);
		this.parent('alert', tinyMCEPopup.getLang('dlg.alert', 'Alert'), html, this.options);
    }
});
var Confirm = Dialog.extend({
    getExtended : function(){
		return {
			onConfirm: Class.empty,
			width: 300,
			height: 120,
			buttons: [{
				'text': tinyMCEPopup.getLang('dlg.yes', 'Yes'),
				'class': 'mceOk',
				'click': function(){
					this.fireEvent('onConfirm');
					this.close();
				}.bind(this)
			},{
				'text': tinyMCEPopup.getLang('dlg.no', 'No'),
				'class': 'mceCancel',
				'click': function(){
					this.close();
				}.bind(this)
			}]
		}
	},
	initialize: function(html, options){
        this.setOptions(this.getExtended(), options);
		this.parent('confirm', tinyMCEPopup.getLang('dlg.confirm', 'Confirm'), html, this.options);
    }
});
var Prompt = Dialog.extend({
	getExtended : function(){
		return {
			onConfirm : Class.empty,
			text : '',
			id : 'prompt',
			value : '',
			multiline : false,
			promptOptions: '',
			width: 250,
			height: 120,
			buttons: [{
				'text': tinyMCEPopup.getLang('dlg.ok', 'OK'),
				'class': 'mceOk',
				'click': function(){
					this.fireEvent('onConfirm');
				}.bind(this)
			},{
				'text': tinyMCEPopup.getLang('dlg.cancel', 'Cancel'),
				'class': 'mceCancel',
				'click': function(){
					this.close();
				}.bind(this)
			}]
		};
	},
	initialize: function(title, options){
        this.setOptions(this.getExtended(), options);
		this.html = new Element('div');
		if(this.options.text){
			this.html.adopt(
				new Element('label', {
					'for': this.options.id
				}).setHTML(this.options.text)
			)
		}
		if(this.options.multiline){
			this.html.adopt(
				new Element('textarea', {
					'id': this.options.id, 
					styles: {
						'width': '200px',
						'height': '75px'
					}
				}).setHTML(this.options.value)
			)
		}else{
			this.html.adopt(
				new Element('input', {
					'id': this.options.id,
					'type': 'text',
					'size': '30',
					'value': this.options.value
				})
			)
		}
		this.html.adopt(this.options.promptOptions);
		this.parent('prompt', title, this.html, this.options);
    }					   
});
var basicDialog = Dialog.extend({
	initialize: function(title, body, options){
		this.parent('dialog', title, body, options);
    }							
});
var uploadDialog = Dialog.extend({
	getExtended : function(){
		return {
			parent: 'form',
			width: 350,
			height: 300,
			buttons: [{
				'text': tinyMCEPopup.getLang('dlg.cancel', 'Cancel'),
				'class': 'mceCancel',
				'click': function(){
					this.close();
				}.bind(this)
			}],
			onSelectFile: Class.empty,
			extended: {
				deltaWidth: 0,
				deltaHeight: 0,
				body: null,
				onLoad : Class.empty
			}
		};
	},
	initialize: function(options){
		this.setOptions(this.getExtended(), options);		
		
		this.options.deltaWidth 	= this.options.extended.deltaWidth || 0;
		this.options.deltaHeight 	= this.options.extended.deltaHeight || 0;
		var moreBody 				= this.options.extended.body || '';
		
		var body = new Element('div', {
			id: 'upload-body'
		}).adopt(
			new Element('fieldset').adopt(
				new Element('legend').setHTML(tinyMCEPopup.getLang('dlg.browse', 'Browse'))							  
			).adopt(
				new Element('input', {
					type: 'hidden',
					id: 'upload-dir',
					name: 'upload-dir'
				})
			).adopt(
				new Element('input', {
					type: 'hidden',
					id: 'upload-method',
					name: 'upload-method',
					value: 'html',
					'class': 'upload-html-only'
				})
			).adopt(	
				new Element('input', {
					type: 'file',
					size: '40%',
					id: 'upload-input',
					'class': 'upload-html-only',
					name: 'Filedata',
					styles: {
						position: 'relative'
					},
					events: {
						change: function(){
							this.fireEvent('onSelectFile', [$('upload-input').value]);
						}.bind(this)
					}
				})
			)
		).adopt(
			new Element('fieldset').adopt(
				new Element('legend').setHTML(tinyMCEPopup.getLang('dlg.options', 'Options'))							  
			).adopt(
				new Element('div', {
					id: 'upload-options',
					styles: {
						position: 'relative'
					}		
				}).adopt(
					new Element('div').adopt(
						new Element('label').setHTML(tinyMCEPopup.getLang('dlg.upload_exists', 'Action if file exists:'))
					).adopt(
						new Element('select', {
							id: 'upload-overwrite',
							name: 'upload-overwrite'
						}).adopt(
							new Element('option', {
								value: 1 			
							}).setHTML(tinyMCEPopup.getLang('dlg.overwrite', 'Overwrite file'))
						).adopt(
							new Element('option', {
								value: 0 			
							}).setHTML(tinyMCEPopup.getLang('dlg.unique', 'Create unique name'))
						)
					)
				).adopt(moreBody)
			)
		).adopt(
			new Element('fieldset').adopt(
				new Element('legend').setHTML(tinyMCEPopup.getLang('dlg.queue', 'Queue'))							  
			).adopt(
				new Element('div', {
					id: 'upload-queue-block',
					styles: {
						position: 'relative'
					}		
				}).adopt(
					new Element('ul', {id: 'upload-queue'}).adopt(
						new Element('li', {
							styles: {'display': 'none'}
						})
					)
				)
			)
		)
		this.parent('dialog', tinyMCEPopup.getLang('dlg.upload', 'Upload'), body, this.options);
		$(this.wrapper).adopt(
			new Element('input', {
				styles: {
					position: 'absolute'
				},
				'id': 'upload-submit',
				'type': 'submit',
				'class': 'mceButton mceOk',
				value : tinyMCEPopup.getLang('dlg.upload', 'Upload')
			})
		)
    }
});
var iframeDialog = Dialog.extend({
	moreOptions : function(){
		return {
			buttons: [],
			onFrameLoad: Class.empty
		};
	},
	initialize: function(title, url, options){
		this.setOptions(this.moreOptions(), options);
		this.display = new Element('div').addClass('iframe-preview').adopt(
			new Element('iframe', {
				'src': url,
				'scrolling': 'auto',
				'frameborder': '0',
				'styles': {
					'width': '99%',
					'height': '95%'
				},
				'events': {
					'load': function(){
						this.fireEvent('onFrameLoad');	
					}.bind(this)
				}
			})
		)
		this.parent('iframe', title, this.display, this.options);
    }							
});
var mediaPreview = basicDialog.extend({
    moreOptions : function(){
        return {
            buttons: [],
			modal: true,
			width: 640,
			height: 480,
			onOpen: function(){
				this.displayMedia();	
			}.bind(this)
        };
    },
    initialize: function(title, url, options){		
		this.setOptions (this.moreOptions(), options);
		this.url 	= url;
		this.title 	= title;
		this.parent('media', '', this.options);
    },
	displayMedia : function(){
		// Image
		if(/\.(jpg|jpeg|gif|png)/i.test(this.url)){
			this.display = new Element('div').addClass('image-preview').addClass('loader').injectInside($(this.id + '-content'));
			this.img = new Asset.image(this.url, {
				onload : function(){
					if(this.loaded) return false;
					this.loaded = true;
					this.options.width 	= this.img.width;
					this.options.height = this.img.height;
					this.setDimensions();
					this.img.width 	= this.mediaWidth;
					this.img.height = this.mediaHeight;
					this.display.removeClass('loader');
					this.display.adopt(this.img).addEvent('click', function(){
						this.close();
					}.bind(this));
				}.bind(this),
				title : this.title
			})
		}else{
			type = this.getType(this.url);
			this.display = new Element('div').addClass('media-preview').injectInside($(this.id + '-content'));
			this.setDimensions();
		
			var html = '';	
			switch(type){
				case 'flash':
					cls = 'clsid:D27CDB6E-AE6D-11cf-96B8-444553540000';
					codebase = 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0';
					type = 'application/x-shockwave-flash';
					break;
				case 'shockwave':
				cls = 'clsid:166B1BCA-3F9C-11CF-8075-444553540000';
				codebase = 'http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#version=8,5,1,0';
				type = 'application/x-director';
					break;	
				case "qt":
					cls = 'clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B';
					codebase = 'http://www.apple.com/qtactivex/qtplugin.cab#version=6,0,2,0';
					type = 'video/quicktime';
					break;	
				case "wmp":
					cls = tinyMCE.getParam('media_wmp6_compatible') ? 'clsid:05589FA1-C356-11CE-BF01-00AA0055595A' : 'clsid:6BF52A52-394A-11D3-B153-00C04F79FAA6';
					codebase = 'http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701';
					type = 'application/x-mplayer2';
					break;	
				case "rmp":
					cls = 'clsid:CFCDAA03-8BE4-11CF-B84B-0020AFBBCCFA';
					codebase = 'http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701';
					type = 'audio/x-pn-realaudio-plugin';
					break;
				case "divx":
					cls = 'clsid:67DABFBF-D0AB-41FA-9C46-CC0F21721616';
					codebase = ed.getParam('media_codebase_divx', 'http://go.divx.com/plugin/DivXBrowserPlugin.cab');
					type = 'video/divx';
					break;
			}
			html += '<object classid="' + cls + '" codebase="' + codebase + '" width="' + this.mediaWidth + '" height="' + this.mediaHeight + '">';
			html += '<param name="url" value="' + this.url + '">';
			html += '<param name="src" value="' + this.url + '">';
			html += '<embed type="' + type + '" width="' + this.mediaWidth + '" height="' + this.mediaHeight + '" src="' + this.url + '">';
			html += '</embed></object>';
			
			this.display.setHTML(html);
		}
	},
	getType : function(v){
		var fo = tinyMCEPopup.editor.getParam("media_types", "flash=swf,flv,xml;shockwave=dcr;qt=mov,qt,mpg,mp3,mp4,mpeg;shockwave=dcr;wmp=avi,wmv,wm,asf,asx,wmx,wvx;rmp=rm,ra,ram;divx=divx").split(';'), i, c, el, x;
		for (i=0; i<fo.length; i++) {
			c = fo[i].split('=');
	
			el = c[1].split(',');
			for (x=0; x<el.length; x++){
				if (v.indexOf('.' + el[x]) != -1){
					return c[0];
				}
			}
		}
		return null;
	},
	setDimensions: function(){
		var x = Math.round(window.getWidth()) - 100;
	   	var y = Math.round(window.getHeight()) - 100;
		
		var w = this.options.width.toInt();
		var h = this.options.height.toInt();
		
		if(w > x){
			h = h * (x / w); 
			w = x; 
			if(h > y){ 
				w = w * (y / h); 
				h = y; 
			}
		}else if(h > y){ 
			w = w * (y / h); 
			h = y; 
			if(w > x){ 
				h = h * (x / w); 
				w = x;
			}
		}		
		this.options.width 	= this.mediaWidth 	= w;
		this.options.height = this.mediaHeight 	= h;
		
        this.setWidth(w + 40);
		this.setHeight(h + 60);
		this.centerWindow();
	}
});