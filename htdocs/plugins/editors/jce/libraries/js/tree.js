/*
Class: Tree
	Creates an interface for <Drag.Base> and drop, resorting of a list.

Note:
	The Sortables require an XHTML doctype.

Arguments:
	container 	- the container element
	options 	- an Object, see options below.

Options:
	
Events:
	onNodeToggle 	- function executed when a node is toggled
	onNodeClick 	- function executed when a node is clicked
*/
var Tree = new Class({
	getOptions : function(){
		return {
			rootName: 'Root',
			rootClass: 'root',
			onInit: Class.empty,
			onNodeClick: Class.empty,
			onNodeLoad: Class.empty,
			onNodeCreate: Class.empty
		};
	},	
	initialize : function(container, options){
		this.setOptions(this.getOptions(), options);
		this.container = $(container);

		this.fireEvent('onInit', function(){
			this.nodeEvents();		
		}.bind(this));
		
		return this;
	},
	nodeEvents : function(parent){
		if(!parent){
			parent = this.container;	
		}
		$ES('div', parent).each(function(el){
			var p = el.getParent();
			el.addEvent('click', function(e){
				this.toggleNode(p.id, e);							  
			}.bind(this))
			if(this.getNode(p)){
				el.addClass('open');	
			}
		}.bind(this));
		
		$ES('span', this.container).each(function(el){
			if(window.ie){
				el.onselectstart = function(){
					return false;
				}
			}
			if(window.gecko){
				el.setStyle('moz-user-select', 'none');
			}
			el.addEvent('mouseover', function(){
				el.addClass('hover');							  
			})
			el.addEvent('mouseout', function(){
				el.removeClass('hover');							  
			}.bind(this))
			if(this.getNode(el.getParent())){
				el.addClass('open');	
			}
		}.bind(this));
		
		$ES('a', this.container).each(function(el){
			el.addEvent('click', function(e){
				this.fireEvent('onNodeClick', el.getParent().getParent().id);						  
			}.bind(this))
		}.bind(this));
	},
	/*
	 * Does the node exist?
	 * @param {String} The node title
	 * @param {String or Element} The parent node
	 * @return {Boolean}.
	*/
	isNode : function(id, parent){
		return this.findNode(id, parent) ? true : false;
	},
	/*
	 * Does a parent have subnodes?
	 * @param {String or Element} The parent node
	 * @return {Boolean}.
	*/
	getNode : function(parent){
		if($type(parent) == 'string'){
			parent = this.findParent(parent);	
		}
		return $E('ul', parent);
	},
	/*
	 * Reset all nodes. Set to closed
	*/
	resetNodes : function(){
		$ES('span', this.container).each(function(el){
			el.removeClass('open');										  
		});
		$ES('div', this.container).each(function(el){
			el.removeClass('open');										  
		});
	},
	/*
	 * Rename a node
	 * @param {String} The node title
	 * @param {String} The new title
	*/
	renameNode : function(id, name){
		var parent 	= string.dirname(id);
		var node 	= this.findNode(id, parent);
		// Rename the node
		node.setProperty('id', name);
		// Rename the span
		$E('a', node).setHTML(string.basename(name));
		// Rename each of the child nodes
		$ES('li[id^='+ string.escape(id) +']', node).each(function(n){
			var nt = n.getProperty('id');
			n.setProperty('id', nt.replace(id, name));
		})
	},
	/*
	 * Remove a node
	 * @param {String} The node title
	*/
	removeNode : function(id){
		var parent 	= string.dirname(id);
		var node 	= this.findNode(id, parent);
		// Remove the node
		node.remove();
		// Find the parent ul node
		var ul = $E('ul', this.findParent(parent));
		// Remove it if it is now empty
		if(ul && !this.getNode(ul)){
			ul.remove();	
		}
	},
	/*
	 * Create a node <ul></ul>
	 * @param {String or Element} The parent node
	 * @return {Array} An array of nodes to create.
	*/
	createNode : function(nodes, parent){				
		// If parent is not an element, find the parent element
		if(!parent){
			parent = string.dirname(nodes[0].url);	
		}
		if($type(parent) == 'string'){
			parent = this.findParent(parent);	
		}
		// Get parent ul
		var ul = $E('ul', parent);
		// Create it if it doesn't exist
		if(!ul){
			ul = new Element('ul').adopt(
				new Element('li').addClass('spacer')
			).injectInside(parent);	
		}
		/* Create the nodes from the array
		 * <li><div></div><span><a>node</a></span></li>
		*/
		if(nodes && nodes.length){
			// Iterate through nodes array
			nodes.each(function(node){
				if(!this.isNode(node.url, parent)){
					ul.adopt(
						new Element('li', {
							'id': string.escape(node.url)
						}).adopt(
							new Element('div', {
								events: {
									'click': function(e){
										this.toggleNode(node.url, e);
									}.bind(this)
								}
							})
						).adopt(
							new Element('span', {
								events: {
									mouseover: function(){
										this.addClass('hover');
									},
									mouseout: function(){
										this.removeClass('hover');
									}
								}			
							}).adopt(
								new Element('a', {
									'href': 'javascript:;',
									'tabindex': '1',
									events: {
										'click': function(){
											this.fireEvent('onNodeClick', node.url)	
										}.bind(this)
									}
								}).setHTML(node.name || node.url)
							)
						)
					)
					this.toggleNodeState(parent, true);
					this.fireEvent('onNodeCreate');
				}else{
					// Node exists, set as open
					this.toggleNodeState(parent, true);	
				}
			}.bind(this))
		}else{
			// No new nodes, set as open
			this.toggleNodeState(parent, 'open');	
		}
	},
	/*
	 * Find the parent node
	 * @param {String} The child node id
	 * @return {Element} The parent node.
	*/
	findParent : function(id){
		return $E('li[id='+ string.escape(id) +']', this.container);
	},
	/*
	 * Find a node by id
	 * @param {String} The child node title
	 * @param {String / Element} The parent node
	 * @return {Element} The node.
	*/
	findNode : function(id, parent){
		if(!parent){
			parent = this.container;
		}
		if($type(parent) == 'string'){
			parent = this.findParent(parent);	
		}
		return $E('li[id='+ string.escape(id) +']', parent) || false;	
	},
	/*
	 * Toggle a node's state, open or closed
	 * @param {Element} The node
	*/
	toggleNodeState : function(node, state){
		var span 	= $E('span', node);
		var div 	= $E('div', node);
		
		// If state, set as 'open'
		if(state){
			span.addClass('open');
			div.addClass('open');
		// Toggle state
		}else{
			span.toggleClass('open');
			div.toggleClass('open');
		}
	},
	/*
	 * Toggle a node
	 * @param {Element} The node
	*/
	toggleNode : function(node, event){
		e 			= new Event(event);
		node 		= this.findNode(node);			
		var child	= this.getNode(node);
		
		// Force reload
		if(e.shift){
			return this.fireEvent('onNodeLoad', node);	
		}
		// No children load or close
		if(!child){
			if($E('div', node).hasClass('open')){
				this.toggleNodeState(node);
			}else{
				this.fireEvent('onNodeLoad', node);
			}
		// Hide children, toggle node
		}else{
			child.toggleClass('hide');
			this.toggleNodeState(node);	
		}
	}
});
Tree.implement(new Events, new Options);