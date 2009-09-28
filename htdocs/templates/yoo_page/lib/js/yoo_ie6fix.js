/* (C) 2007 YOOtheme.com */

function loadIE6Fix() {
	correctPngInline();
	correctPngBackground('.correct-png');
	sfHover('#menu span.separator');
	sfHover('#menu li');
	sfHover('.module_menu span.separator');
	sfHover('.module_menu li');
	sfHover('.moduletable_menu span.separator');
	sfHover('.moduletable_menu li');
	sfHover('#search div');
	sfHover('#search input');
	sfHover('.yoo-login input');
	sfHover('.yoo-login button');
	sfFocus('#search div');
	sfFocus('#search input');
	sfFocus('.yoo-login input');
}

/* Add functions on window load */
window.addEvent('load', loadIE6Fix);