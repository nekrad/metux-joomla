/* (C) 2007 YOOtheme.com */

var YOOTools = {
		
	start: function() {
		
		/* Match height of div tags */
		YOOTools.setDivHeight();

		/* Accordion menu */
		new YOOAccordionMenu('div#middle ul.menu li.toggler', 'ul.accordion', { accordion: 'slide' });

		/* Dropdown menu */
		new YOODropdownMenu('div#menu li.parent');

		/* Color settings */
		var page = $('page');		
		var currentColor = '#e6e9eb'; /* default */
		if (page.hasClass('blue'))   currentColor = '#e1f0fa';
		if (page.hasClass('pink'))   currentColor = '#e6e1f0';
		if (page.hasClass('orange')) currentColor = '#f0e6d7';
		if (page.hasClass('green'))  currentColor = '#e6f0dc';

		/* Main menu */
		var menuEnter = { 'background-color': currentColor };
		var menuLeave = { 'background-color': '#ffffff' };
		
		new YOOMorph('div#menu li.level2 a, div#menu li.level2 span.separator', menuEnter, menuLeave,
			{ transition: Fx.Transitions.expoOut, duration: 300 },
			{ transition: Fx.Transitions.sineIn, duration: 500 });
		
		/* Sub menu all levels */
		var submenuEnter = { 'background-color': currentColor };
		var submenuLeave = { 'background-color': '#ffffff' };

		new YOOMorph('div#middle ul.menu a, div#middle ul.menu span.separator', submenuEnter, submenuLeave,
			{ transition: Fx.Transitions.expoOut, duration: 300 },
			{ transition: Fx.Transitions.sineIn, duration: 500 });
		
		/* Style switcher */
		new YOOStyleSwitcher($ES('.wrapper'), { 
			widthDefault: YtSettings.widthDefault,
			widthThinPx: YtSettings.widthThinPx,
			widthWidePx: YtSettings.widthWidePx,
			widthFluidPx: YtSettings.widthFluidPx,
			afterSwitch: YOOTools.setDivHeight,
			transition: Fx.Transitions.expoOut,
			duration: 500
		});		

		/* Lightbox */
	    Shadowbox.init({
	        loadingImage: YtSettings.tplurl + '/lib/js/lightbox/css/loading.gif',
        	overlayBgImage: YtSettings.tplurl + '/lib/js/lightbox/css/overlay-85.png'
	    });

		/* Spotlight */
		new YOOSpotlight('div.spotlight, span.spotlight');
		
		/* Smoothscroll */
		new SmoothScroll({ duration: 500, transition: Fx.Transitions.Expo.easeOut });
	},

	/* Match height of div tags */
	setDivHeight: function() {
		YOOBase.matchDivHeight('div.topbox div', 0, 40);
		YOOBase.matchDivHeight('div.bottombox div div div div', 0, 50);
		YOOBase.matchDivHeight('div.maintopbox div div div div', 0, 50);
		YOOBase.matchDivHeight('div.mainbottombox div div div div', 0, 50);
		YOOBase.matchDivHeight('div.contenttopbox div div div div', 0, 50);
		YOOBase.matchDivHeight('div.contentbottombox div div div div', 0, 50);
	}

};

/* Add functions on window load */
window.addEvent('load', YOOTools.start);