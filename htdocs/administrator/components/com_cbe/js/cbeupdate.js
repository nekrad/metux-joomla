		window.addEvent('domready', function() {
			new Ajax('index.php?option=com_cbe&task=cbeUpdateFeed&format=raw',
			{method: 'get', onComplete: getUpdateLinks}).request();
		});

		function cbe_xml_parser(txt) {
			var xmlDoc;
			try {
				xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
				xmlDoc.async="false";
				xmlDoc.loadXML(txt);
			}
			catch (e) {
				var parser=new DOMParser();
				xmlDoc=parser.parseFromString(txt,"text/xml");
			}
			return xmlDoc;
		}

		function cbe_install_update(url, ind) {
			var baseURL = 'index.php?option=com_cbe&task=cbeInstallUpdate&format=raw&ext=';
			$('cbe_updates_' + ind).innerHTML = "<img src='../components/com_cbe/images/wait.gif' />";
			var instURL = baseURL + escape(url);
			new Ajax(instURL,
			{method: 'get', update: 'cbe_updates_' + ind}).request();
		}

		function getUpdateLinks (responseXML) {
			var t = cbe_xml_parser(responseXML);

			var eDOM = DomBuilder.apply();
			var checkURLs = new Array();
			var eTABLE = eDOM.TABLE({width: '100%', class: 'adminform'}, eDOM.TR(eDOM.TH({align: 'left', width: '10%'}, 'Installiert'), eDOM.TH({align: 'left', width: '20%'}, 'Name'), eDOM.TH({align: 'left', width: '70%'}, 'Beschreibung')));
			var eROW;

			var items = t.getElementsByTagName('item');
			for (var j=0;j<items.length;j++) {
				var links = items[j].getElementsByTagName('link');
				var titles = items[j].getElementsByTagName('title');
				var descs = items[j].getElementsByTagName('description');

				for (var i=0;i<links.length;i++) {
					var link = (links[i].firstChild.nodeValue != '')?links[i].firstChild.nodeValue:' ';
					var title = (titles[i].firstChild.nodeValue != '')?titles[i].firstChild.nodeValue:' ';
					var desc = (descs[i].firstChild.nodeValue != '')?descs[i].firstChild.nodeValue:' ';

					eROW = eDOM.TR(eDOM.TD(eDOM.DIV({id: 'cbe_updates_' + j})), eDOM.TD(eDOM.A({href: "javascript:cbe_install_update('" + link + "', " + j + ")", title: title}, title)), eDOM.TD(desc));
					eTABLE.appendChild(eROW);
					checkURLs.push(link);
				}
			}
			// gucken, ob es schon installiert ist
			
			$('cbe_update').addEvents({rssready: function() {
				for (var i=0;i<checkURLs.length;i++) {
					new Ajax('index.php?option=com_cbe&task=cbeCheckUpdate&format=raw&was=' + escape(checkURLs[i]),
					{method: 'get', update: 'cbe_updates_' + i}).request();
				}
			}});
			
			$('cbe_update').innerHTML = "";
			$('cbe_update').appendChild(eTABLE);
			//$('cbe_update').fireEvent('rssready');
		}
