/*
Class: Plugin
	Base plugin class for creating a JCE plugin object.

Arguments:
	options - optional, an object containing options.

Options:
	site - the base site url.
	plugin - the plugin name
	lang - the language code, eg: en.
	params - parameter object.

Example:
	var advlink = new Plugin('advlink', {params: {'key': 'value'}});
*/
var Plugin = new Class({
	getOptions : function(){
		return {
			site : tinyMCEPopup.getParam('document_base_url'),
			lang : 'en',
			params : {}
		}
	},
	initialize : function(plugin, options){
		this.setOptions(this.getOptions(), options);		
		this._plugin = plugin;
		// fallback for no plugin set
		if(!this._plugin){
			var q = string.query(document.location.href);
			this._plugin = q['plugin'];
		}
	},
	/*
	 * Return site url option
	 * @param {String} The site url variable
	*/
	getSite : function(){
		return this.options.site;	
	},
	/*
	 * Store custom plugin parameters
	 * Example: {'animals': ['dog', 'cat', 'mouse']}
	 * @param {Object} The parameters object
	*/
	setParams : function(p){
		for(n in p){
			this.setParam(n, p[n]);
		}
	},
	/*
	 * Store a custom plugin parameter
	 * Example: 'animals', ['dog', 'cat', 'mouse']
	 * @param {string} The parameter key/name
	 * @param {string/array/object} The value
	*/
	setParam : function(p, v){
		this.options.params[p] = v;
	},
	/*
	 * Return a custom plugin parameter
	 * @param {string} The parameter key/name
	*/
	getParam : function(p){
		return this.options.params[p] || false;
	},
	/*
	 * Set the plugin as current
	 * @param {string} The plugin name
	*/
	setPlugin : function(p){
		this._plugin = p;
	},
	/*
	 * Return the current plugin
	 * @return {string} The plugin name
	*/
	getPlugin : function(){
		return this._plugin;	
	},
	/*
	 * Return a full resource url
	 * @param {string} The url type, eg: img, plugin
	 * @return {string} The url
	*/
	getUrl : function( type ){
		if( type == 'plugins' ){
			type += '/' + this.getPlugin();
		}
		return string.path(this.options.site, '/plugins/editors/jce/' + type);
	},
	/*
	 * Return a full image url
	 * @param {string} The image name
	 * @return {string} The url
	*/
	getImage : function(name){
		var parts 	= name.split('.');
		var path 	= parts[0].replace(/[^a-z0-9-_]/i, '');
		var file 	= parts[1].replace(/[^a-z0-9-_]/i, '');
		var ext 	= parts[2].replace(/[^a-z0-9-_]/i, '');
		
		return this.getUrl(path) + '/img/' + file + '.' + ext;
	},
	/*
	 * Resolve a TinyMCE language string
	 * @param {string} The variable name
	 * @param {string} The default translation
	 * @return {string} The language string
	*/
	getLang : function(s, dv){
		return tinyMCEPopup.getLang(s, dv);
	},
	/*
	 * Loads a TinyMCE plugin or theme dialog language file. Requires asset.js
	 * @param {string} The variable name
	 * @param {string} The default translation
	 * @return {string} The language string
	*/
	loadLanguage : function(name){
		var path = '', parts = '', file = '';
		if(name){
			parts 	= name.split('.');
			path 	= parts[0].replace(/[^a-z0-9-_]/i, '');
			file 	= parts[1].replace(/[^a-z0-9-_]/i, '');
			path 	= path + '/' + file + '/';
		}
		var u = this.options.site + '/plugins/editors/jce/tiny_mce/' + path + 'langs/' + this.options.lang + '_dlg.js';
		new Asset.javascript(u);
	},
	/*
	 * Open help window for current language
	*/
	openHelp : function(type){
		if(!type) type = 'standard';
		tinyMCE.activeEditor.windowManager.open({
			url : this.options.site + 'index.php?option=com_jce&task=help&lang='+ this.options.lang +'&plugin='+ this._plugin +'&type='+ type +'&file=help',
			width : 640,
		    height : 480,
		    resizable : "yes",
            inline : "yes",
        	close_previous : "no"
		});
	},
	/*
	 * JSON XHR request. Requires json.js
	 * @param {string} The target function to call
	 * @param {array} An array of arguments
	 * @param {function} The callback function on success
	*/
	json : function(fn, args, cb){	
		new Json.Remote(document.location.href, {
			onComplete: function(o){
				if(o.error){
					alert(o.error);	
				}
				r = o.result || {error: false};
				cb.pass(r, this)();
			}.bind(this),
			onFailure: function(x){
				alert('Request failed with status code: '+ x.status);	
			}
		}).send({'fn': fn, 'args': args});
	},
	showAlerts : function(o){
		if(o.length){
			var h = '<dl class="alert">';
			o.each(function(a){
				h += '<dt class="' + a['class'] + '">' + a['title'] + '</dt><dd>' + a['text'] + '</dd>';				
			});
			h += '</dl>'
			new Alert(h, {height: 150 + o.length * 50});
		}
	}
});
Plugin.implement(new Events, new Options);