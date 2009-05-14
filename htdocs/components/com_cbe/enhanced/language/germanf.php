<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

//********************************************
// MamboMe Enhanced Language File - German   *
// Copyright (c) 2005 Philipp Kolloczek      *
// http://mambome.com                        *
// Released under the GNU/GPL License        *
// Version 1.0                               *
// File date: 29-09-2005                     *
//********************************************

//Profile Color Language
DEFINE('_UE_PROFILE_COLOR','Profil Hintergrundfarbe');
DEFINE('_UE_PROFILE_COLOR_BLUE','Blau');	//blue
DEFINE('_UE_PROFILE_COLOR_GREEN','Gr�n');	//green
DEFINE('_UE_PROFILE_COLOR_RED','Rot');		//red
DEFINE('_UE_PROFILE_COLOR_PINK','Rosa');	//pink
DEFINE('_UE_PROFILE_COLOR_ORANGE','Orange');//orange
DEFINE('_UE_PROFILE_COLOR_YELLOW','Gelb');//yellow
DEFINE('_UE_PROFILE_COLOR_BLACK','Schwarz');	//black
DEFINE('_UE_PROFILE_COLOR_LIME','Lindgr�n');	//lime
DEFINE('_UE_PROFILE_COLOR_FUCHIA','Fuchsia');//fuchia
DEFINE('_UE_PROFILE_COLOR_NAVY','Marineblau');	//navy
DEFINE('_UE_PROFILE_COLOR_PURPLE','Purpur');//purple
DEFINE('_UE_PROFILE_COLOR_MAROON','Braun');//maroon
DEFINE('_UE_PROFILE_COLOR_TEAL','Petrol');	//teal
DEFINE('_UE_PROFILE_COLOR_AQUA','Blau-Gr�n');	//aqua
DEFINE('_UE_PROFILE_COLOR_OLIVE','Olive-Gr�n');	//olive
DEFINE('_UE_PROFILE_COLOR_SILVER','Silbergrau');//silver
DEFINE('_UE_PROFILE_COLOR_GREY','Grau');	//grey
DEFINE('_UE_PROFILE_COLOR_WHITE','Wei�');	//white

//Profile Color Admin Language
DEFINE('_UE_COLORS_TAB_ADMIN_LABEL','Profil Farbe');
DEFINE('_UE_PROFILE_COLOR_ALLOW','Profil Farbe');
DEFINE('_UE_PROFILE_COLOR_ALLOW_DESC','Benutzer d�rfen die Hintegrundfarbe ihres Profils �ndern');
DEFINE('_UE_PROFILE_COLOR_DEFAULT','Keine');
DEFINE('_UE_PROFILE_COLOR_SET_DEFAULT','Standardfarbe');
DEFINE('_UE_PROFILE_COLOR_SET_DEFAULT_DESC','Difiniert die Standardfarbe. Die Auswahl "Keine" �bernimmt die Farbe der Vorlage.');

//User unregister language
DEFINE('_UE_USER_UNREGISTER_CONFIRM','Sie sind dabei Ihren Account zu l�schen, alle Ihre Daten werden gel�scht und die Anmeldung mit diesen umn�glich. Sollten Sie danach wieder als User aktiv werden wollen, registrieren Sie sich bitte neu.');
DEFINE('_UE_USER_UNREGISTER_PASSWORD','Passwort:');
DEFINE('_UE_USER_UNREGISTER_PASSWORD_VERIFY','Passwort wiederholen:');
DEFINE('_UE_USER_UNREGISTER_PASSWORD_INCORRECT','Falsches Passwort');
DEFINE('_UE_USER_UNREGISTER_UNREGISTER','Austragen');
DEFINE('_UE_USER_UNREGISTER_PASSWORDS_NO_MATCH','Die Passw�rter stimmen nicht �berein.');
DEFINE('_UE_USER_UNREGISTER_REDIRECT','Umleitung....');
DEFINE('_UE_USER_UNREGISTER_DESCRIPTION','Sie sind aktuell als User registriert. Um Ihren Account zu l�schen, gebens Sie bitte Ihr Passwort zweimal zur Best�tigung ein. Danach klicken Sie auf den Austragen-Button.');
DEFINE('_UE_USER_UNREGISTER_UNREGISTERED','Sie sind nun von dieser Seite ausgetragen und Ihr Account wurde gel�scht.');
DEFINE('_UE_USER_UNREGISTER_SECURITY_QUESTION','Sicherheitsfrage:');
DEFINE('_UE_USER_UNREGISTER_SECURITY_QUESTION_ANSWER','Antwort');
DEFINE('_UE_USER_UNREGISTER_SUPERADMIN','Der Superadministrator kann nicht ausgetragen werden!');
//User unregister Admin
DEFINE('_UE_REG_UNREGISTER_ALLOW','unRegister erlauben');
DEFINE('_UE_REG_UNREGISTER_ALLOW_DESC','Erlaubt es dem User seinen Account selber zu loeschen');
DEFINE('_UE_REG_UNREGISTER_EDITMODE','Link im Edit-Modus');
DEFINE('_UE_REG_UNREGISTER_EDITMODE_DESC','Zeigt den unregister-Link in der Dateneingabemaske des Profils');
DEFINE('_UE_REG_UNREGISTER_PROFILEMODE','Link im Profil-Modus');
DEFINE('_UE_REG_UNREGISTER_PROFILEMODE_DESC','Zeigt den unregister-Link in der normalen Profilansicht');
DEFINE('_UE_REG_UNREGISTER_SENDMAILUSER','Mail zum User');
DEFINE('_UE_REG_UNREGISTER_SENDMAILUSER_DESC','Informiert den User auch per Mail ueber das Austragen');
DEFINE('_UE_REG_UNREGISTER_SENDMAILADMIN','Informiere Moderator');
DEFINE('_UE_REG_UNREGISTER_SENDMAILADMIN_DESC','Informiert die Moderatoren ueber eine Austragung');
DEFINE('_UE_REG_UNREGISTER_MAILSUB','Betreff der unRegister Mail');
DEFINE('_UE_REG_UNREGISTER_MAILSUB_DESC','Gib hier die Betreffzeile fuer die Bestaetigung des Austragens an. (user)');
DEFINE('_UE_REG_UNREGISTER_MAILMSG','Mailtext der unRegister Mail');
DEFINE('_UE_REG_UNREGISTER_MAILMSG_DESC','Gib hier den Text der Mail ein, od. verwende eine Sprachvariable');
// Unregister Mail Text
DEFINE('_UE_MAIL_UNREG_SUB','Account geloescht');
DEFINE('_UE_MAIL_UNREG_MSG','Hallo [NAME],

Ihrem Wunsch ihren Account bei [SITEURL] zu loeschen
wurde nachgekommen. Alle Daten, sowie ihr evtl. Profilbild
fuer den Account:
[DETAILS]
wurden von unseren Systemen geloescht.

Sollten Sie unser System wieder nutzen wollen,
registrieren Sie sich bitte neu.

Mit freundlichen Gruessen,
Website-Admin-Team');
DEFINE('_UE_UNREGISTER_ADMIN_SUB','User Loeschung');
DEFINE('_UE_UNREGISTER_ADMIN_MSG','Hallo Moderator,
Der User mit den aufgelisteten Daten hat sich selber
ausgetragen. Bitte kontrolliere ggf. den Datendump

[FULLDUMP] 

Mit freundlichen Gruessen,
Website-Admin-Team.');


//Display language
DEFINE('_UE_FORUM_NO_KARMA','Kein Karma');
DEFINE('_UE_FORUM_KARMA','Karma');
DEFINE('_UE_PHOTOSNUMBER', 'Anzahl der Bilder');
DEFINE('_UE_MP3SNUMBER','Anzahl der MP3s');
DEFINE('_UE_VIEWBLOG','Tagebuch lesen');
DEFINE('_UE_BLOG_HEADER','Mitglieder Tagebuch');
DEFINE('_UE_BUDDYLIST','Freundesliste');
DEFINE('_UE_BUDDYLIST_ADD','Einladung aussprechen');
DEFINE('_UE_BUDDYLIST_DELETE','Von der Freundesliste l�schen');

//Search Manager
DEFINE('_UE_PROFILESEARCH','Suche nach Profilen');
DEFINE('_UE_SELECTCRITERIA','W�hle eine od. mehrere Optionen');
DEFINE('_UE_QUERY_NOT_VALID','Dies ist keine g�ltige Abfrage');
DEFINE('_UE_FORMSEARCH','Suche');
DEFINE('_UE_FORMRESET','Zur�cksetzen');
DEFINE('_UE_SEARCH_TO','bis');
DEFINE('_UE_SEARCHRESULTS','Suchergebniss');


//Search Manager Admin Language
DEFINE('_UE_SEARCH_MANAGER','CB Suche');
DEFINE('_UE_SEARCH_MANAGER_SHOW_ADVANCED','Zeige erweiterte Optionen');
DEFINE('_UE_SEARCH_MANAGER_SHOW_ADVANCED_DESC','Erlaubt es die erweiterten Optionen anzuzeigen');
DEFINE('_UE_SEARCHTAB1','Suchmaske 1');
DEFINE('_UE_SEARCHTAB1_DESC','Titel auf Suchmaske 1 (ohne erweiterte Optionen)');
DEFINE('_UE_CBSEARCH_TITLE_TAB1','Einfach');
DEFINE('_UE_SEARCHTAB2','Suchmaske 2');
DEFINE('_UE_SEARCHTAB2_DESC','Titel auf Suchmaske 2 (mit erweiterten Optionen)');
DEFINE('_UE_CBSEARCH_TITLE_TAB2','Erweitert');
DEFINE('_UE_SEARCHTAB_COLOR','Tab-Hintergrundfarbe');
DEFINE('_UE_SEARCHTAB_COLOR_DESC','Definiert die Hintergrundfarbe der CBSearch Tabs. Es k�nnen #hex Code als auch Bezeichner, z.B. gray, verwendet werden.');
DEFINE('_UE_SEARCH_SHOW_DISTANCE','Entfernungssuche');
DEFINE('_UE_SEARCH_SHOW_DISTANCE_DESC','Aktiviert die Umkreis/Entfernungssuche sofern der GeoCoder aktiv ist und GeoDaten vorliegen.');
DEFINE('_UE_ONLINE_NOW_ONLY','Nur Mitglieder die derzeit Online sind');
DEFINE('_UE_ONLINE_NOW_ONLY_DESC','Ist diese Option erlaubt werden nur Mitglieder ausgegeben, die auch gerade online sind');
DEFINE('_UE_PICTURE_ONLY','Nur Mitglieder mit einem Bild im Profil');
DEFINE('_UE_PICTURE_ONLY_DESC','Ist diese Option erlaubt werden nur Mitglieder ausgegeben, die ein Bild im Profil haben');
DEFINE('_UE_ONLINE_10_DAYS_OR_LESS','Nur Profile der letzten 10 Tage');
DEFINE('_UE_ONLINE_10_DAYS_OR_LESS_DESC','Ist diese Option erlaubt werden nur Mitgliederprofile ausgegeben, die in den letzten 10 Tagen aktiv waren');
DEFINE('_UE_ADDED_10_DAYS_OR_LESS','Nur neue Profile der letzten 10 Tage');
DEFINE('_UE_ADDED_10_DAYS_OR_LESS_DESC','Ist diese Option erlaubt werden nur Mitgliederprofile ausgegeben, die in den letzten 10 Tagen hinzugekommen sind');
DEFINE('_UE_SEARCH_ANY','Egal');
DEFINE('_UE_SEARCH_AGE_COMMON_STYLE','Unscharfe Alterssuche');
DEFINE('_UE_SEARCH_AGE_COMMON_STYLE_DESC','Wenn diese Option aktiv ist wird die Suche auf das Lebensalter ausgedehnt. Jemand der seinen 23 Geburtstag hatte ist im 24ten Lebensjahr.');
DEFINE('_UE_ALLOW_CBESEARCH_MODULE','erlaube Module');
DEFINE('_UE_ALLOW_CBESEARCH_MODULE_DESC','Erlaubt die Nutzung von CBSearch durch das CBEsearch Module. Bitte kontollieren Sie auch die Gruppenbrechtigung.');
DEFINE('_UE_CBSEARCH_DO_LOGIN','Um weitere Treffer der Suche zu sehen m�ssen Sie sich anmelden oder registrieren.');
DEFINE('_UE_CBSEARCH_ERR_ACL','Leider reichen die Rechte Ihrer Benutzergruppe nicht aus, um noch mehr Treffer der Suche zu sehen.');
DEFINE('_UE_CBSEARCH_QUERY_EXPIRED','Die G�ltigkeitsdauer Ihrer Suchanfrage ist leider abgelaufen.');

//SB Forum Admin Language
DEFINE('_UE_SIMPLEBOARD_FORUM_TAB','SB forum');
DEFINE('_UE_SBJB_FORUM','FireBoard / JoomlaBoard / SimpleBoard');
DEFINE('_UE_SBJB_FORUM_DESC','Die Bezeichnungen dieses Tabs richten sich zwar an das Simpleboad, gelten aber auch f�r den Nachfolger Joomlaboard!<br />Ebenso werden die Einstellungen auch vom FireBoard Tab genutzt!');
DEFINE('_UE_SHOW_FORUM_RANKING','Simpleboard forum rank im Profil anzeigen');
DEFINE('_UE_SHOW_FORUM_RANKING_DESC','Erlaubt die Anzeige des Forumranges im Profil');
DEFINE('_UE_SHOW_FORUM_POST_NUMBER','Simpleboard, Anzahl der Beitr�ge');
DEFINE('_UE_SHOW_FORUM_POST_NUMBER_DESC','Erlaubt die Anzeige der Beitragsanzahl');
DEFINE('_UE_SHOW_FORUM_KARMA','Simpleboard forum karma im Profil');
DEFINE('_UE_SHOW_FORUM_KARMA_DESC','Erlaubt die Anzeige des Karma im Profil');
DEFINE('_UE_SHOW_FORUM_USEGID','Betrachtergruppe pr�fen');
DEFINE('_UE_SHOW_FORUM_USEGID_DESC','Pr�ft ob der Betrachter berechtigt ist das entsprechende Forum eines Beitrages zu sehen');
DEFINE('_UE_SHOW_FORUM_USE_FB','FireBoard');
DEFINE('_UE_SHOW_FORUM_USE_FB_DESC','Wenn anstelle des SB/JB-Forums der Nachfolger Fireboad verwendet wird ist dieser Switch zu aktivieren.');
// Profile Enhancements
// Phil_K
// German Federal States
DEFINE('_UE_DE_STATE_TITLE','Bundesland');
DEFINE('_UE_DE_STATE01','Baden-W�rttemberg');
DEFINE('_UE_DE_STATE02','Bayern');
DEFINE('_UE_DE_STATE03','Berlin');
DEFINE('_UE_DE_STATE04','Brandenburg');
DEFINE('_UE_DE_STATE05','Bremen');
DEFINE('_UE_DE_STATE06','Hamburg');
DEFINE('_UE_DE_STATE07','Hessen');
DEFINE('_UE_DE_STATE08','Mecklenburg-Vorpommern');
DEFINE('_UE_DE_STATE09','Niedersachsen');
DEFINE('_UE_DE_STATE10','Nordrhein-Westfalen');
DEFINE('_UE_DE_STATE11','Rheinland-Pfalz');
DEFINE('_UE_DE_STATE12','Saarland');
DEFINE('_UE_DE_STATE13','Sachsen');
DEFINE('_UE_DE_STATE14','Sachsen-Anhalt');
DEFINE('_UE_DE_STATE15','Schleswig-Holstein');
DEFINE('_UE_DE_STATE16','Th�ringen');
// Admin Infos
DEFINE('_UE_PSPECIAL_TAB_ADMIN_LABEL','Profile Specials');
DEFINE('_UE_PROFILE_BY_NAME','Aufruf mit Namen');
DEFINE('_UE_PROFILE_BY_NAME_DESC','Erlaubt es in der URL zum Aufruf eines Profils den Namen anstelle der UID anzugeben');
DEFINE('_UE_TOOLTIP_WZ','WZtooltip nutzen');
DEFINE('_UE_TOOLTIP_WZ_DESC','Bei <b>Nein</b> wird der Joomla Mechanismus benutzt, bei <b>Ja</b> muss wztooltip.js im Template eingebunden sein.');
DEFINE('_UE_PROFILE_LANGFILTER','Word-Zensur');
DEFINE('_UE_PROFILE_LANGFILTER_DESC','Aktiviert die Nutzung des Language-Filters im Profile fuer Texte die durch User eingegeben wurden.');
DEFINE('_UE_PIC2PIC_ALLOW','Bild-2-Bild');
DEFINE('_UE_PIC2PIC_ALLOW_DESC','Bei Ja ist es nur Mitgliedern mit freigegebenem Bild erlaubt andere Avatarbilder zu sehen');
DEFINE('_UE_PIC2PROFILE_ALLOW','Bild-2-Profil');
DEFINE('_UE_PIC2PROFILE_ALLOW_DESC','Bei Ja is es nur Mitgliedern mit freigegebenm Bild erlaubt andere Profile anzusehen');
DEFINE('_UE_PIC2PROFILE_WARNING','Die Ansicht des Profils ist Ihnen nicht erlaubt. Bitte speichern Sie erst ein eigenes Bild im System um Zugang zu erhalten.');
DEFINE('_UE_SHOWAGE','Alter zeigen');
DEFINE('_UE_SHOWAGE_TITLE','Alter');
DEFINE('_UE_SHOWAGE_DESC','Ist diese Option aktiviert, wird im Profil das Alter des Mitglied angezeigt');
DEFINE('_UE_SHOWAGE_NOTE1','! WICHTIG ! Vergiss nicht das Geburtstagdatumsfeld unter ');
DEFINE('_UE_SHOWAGE_NOTE2',' auszuf�llen!');
DEFINE('_UE_SHOWAGE_NO','kein Geburtsdatum eingegeben');
DEFINE('_UE_RATEIT_ALLOW','Bewertung aktivieren');
DEFINE('_UE_RATEIT_ALLOW_DESC','Aktiviert die generelle Anzeige der Bewertungsdaten /-maske ( <b>Hauptschalter</b> )');
DEFINE('_UE_RATEIT_FORM','Formular zeigen');
DEFINE('_UE_RATEIT_FORM_DESC','Zeigt das Abstimmungsformular an');
DEFINE('_UE_RATEIT_SELF','Eigene Bewertung');
DEFINE('_UE_RATEIT_SELF_DESC','Erlaubt es f�r sich selbst zu bewerten');
DEFINE('_UE_RATEIT_GUEST','Gast Bewertung ');
DEFINE('_UE_RATEIT_GUEST_DESC','Erlaubt es nicht registrierten (G�sten) Profile zu bewerten');
DEFINE('_UE_RATEIT_STARS','Symbolanzeige');
DEFINE('_UE_RATEIT_STARS_DESC','Zeigt das Ergebniss durch Bildsymbole an');
DEFINE('_UE_RATEIT_COUNT','Stimmenzahl');
DEFINE('_UE_RATEIT_COUNT_DESC','Zeigt die Anzahl der abgegeben Stimmen f�r ein Profil an');
DEFINE('_UE_RATEIT_PRECISION','Nachkommastellen');
DEFINE('_UE_RATEIT_PRECISION_DESC','Gibt die Anzahl der Nachkommastellen des Durchschnittswertes an.');
DEFINE('_UE_RATEIT_RESULT_ALLOW','Zeige Durchschnitt');
DEFINE('_UE_RATEIT_RESULT_ALLOW_DESC','Aktiviert die Anzeige der durchschnittlichen Bewertung');
DEFINE('_UE_RATEIT_DAYS','pro x Tage');
DEFINE('_UE_RATEIT_DAYS_DESC','Gibt an wieviel Tage zwischen zwei Stimmen f�r ein Profil liegen m�ssen');
DEFINE('_UE_RATEIT_MOD','�bertrage Daten');
DEFINE('_UE_RATEIT_MOD_DESC','Diese Option �bertr�gt Daten in die Haupttabelle um sie fuer mod_cbetopvotes zug�nglich zu machen');
DEFINE('_UE_RATEIT_MOD_TXT1','Als Standard sind hier die Felder <b>votecount</b> und <b>voteresult</b> verwendet.');
DEFINE('_UE_RATEIT_MOD_TXT2','Diese Felder k�nnen entwender normal als read-only Felder erstellt werden, oder -was zu empfehlen ist- �ber das Tools Menu eingerichtet werden.');
DEFINE('_UE_RATEIT_ICON_FULL','1 Punkt');
DEFINE('_UE_RATEIT_ICON_FULL_DESC','Gibt den relativen Pfad zum Bild f�r einen vollen Wertepunkt an');
DEFINE('_UE_RATEIT_ICON_HALF','1/2 Punkt');
DEFINE('_UE_RATEIT_ICON_HALF_DESC','Gibt den relativen Pfad zum Bild f�r einen halben Wertepunkt an');
DEFINE('_UE_RATEIT_MC_VALUE_DESC1','Formel: gewichteter Rang (WR) = (v � (v+m)) � R + (m � (v+m)) � C');
DEFINE('_UE_RATEIT_MC_VALUE_DESC2','m = minimale Anzahl der Stimmen um ber�cksichtigt zu werden');
DEFINE('_UE_RATEIT_MC_VALUE_DESC3','C = Durchschnittliche Bewertung �ber alles');
DEFINE('_UE_RATEIT_M_VALUE','Setze m Wert');
DEFINE('_UE_RATEIT_M_VALUE_DESC','Gibt den Wert f�r m an. Dient der Berechnung des vergleichbaren Durchschnitt unabh�ngig von der Anzahl abgegebenen Stimmen');
DEFINE('_UE_RATEIT_C_VALUE','Setze C Wert');
DEFINE('_UE_RATEIT_C_VALUE_DESC','Gibt den Wert f�r C an. Dient der Berechnung des vergleichbaren Durchschnitt unabh�ngig von der Anzahl abgegebenen Stimmen');
DEFINE('_UE_USEWORDWRAP_TXT','Textfelder limitieren');
DEFINE('_UE_USEWORDWRAP_TXT_DESC','F�gt in Textbereichfelder und Editorfelder anhand ihrer Spaltenangabe Leerzeichen zwecks Begrenzung der maximalen Zeilenl�nge ein.');

// LastVisitors
DEFINE('_UE_LASTVISITORS_TAB_ADMIN_LABEL','Last Visitors');
DEFINE('_UE_LASTVISITORS_COUNT','Besucherz�hler');
DEFINE('_UE_LASTVISITORS_COUNT_DESC','W�hle wieviele Besucher angezeigt werden sollen');
DEFINE('_UE_LASTVISITORS_DATE','Zeitstempel');
DEFINE('_UE_LASTVISITORS_DATE_DESC','W�hle aus ob und wie angezeigt werden soll wann ein Besucher ein Profil betrachtet hat');
DEFINE('_UE_LASTVISITORS_NODATE','Kein Zeitstempel');
DEFINE('_UE_LASTVISITORS_SHOWDATE','Datum');
DEFINE('_UE_LASTVISITORS_SHOWSINCE','Zeit seit');
DEFINE('_UE_LASTVISITORS_GENDER','Geschlecht');
DEFINE('_UE_LASTVISITORS_GENDER_DESC','Zeige das Geschlecht der Besucher');
DEFINE('_UE_LASTVISITORS_GENDERSYMBOL','Als Symbol');
DEFINE('_UE_LASTVISITORS_GENDERTEXT','Als Text');
DEFINE('_UE_LASTVISITORS_NOGENDER','nicht zeigen');
DEFINE('_UE_LASTVISITORS_SHOWSELF','Inhaber z�hlen');
DEFINE('_UE_LASTVISITORS_SHOWSELF_DESC','Zeigt auch an, wann der Inhaber sein Profil angesehen hat');
DEFINE('_UE_LASTVISITORS_OWNERONLY','Nur Inhaber');
DEFINE('_UE_LASTVISITORS_OWNERONLY_DESC','Gibt die Ansicht der Liste nur dem Profilinhaber frei');
DEFINE('_UE_LASTVISITORS_SHOWONLINE','Online Status');
DEFINE('_UE_LASTVISITORS_SHOWONLINE_DESC','Zeigt an ob der Besucher gerade online ist');
DEFINE('_UE_LASTVISITORS_SHOWAGE','Besucher Alter');
DEFINE('_UE_LASTVISITORS_SHOWAGE_DESC','Zeigt das Alter der Besucher an. Vergiss nicht ein Geburtstagsdatumsfeld zu definieren');
DEFINE('_UE_LASTVISITORS_BIRTHDAYFIELD','Geburtstagsdatum (Feld)');
DEFINE('_UE_LASTVISITORS_BIRTHDAYFIELD_DESC','Gib den Feldnamen ein, der in CBE das Geburtsdatum enth�lt');
DEFINE('_UE_LASTVISITORS_GENDERFIELD','Geschlecht (Feld)');
DEFINE('_UE_LASTVISITORS_GENDERFIELD_DESC','Gib den Feldnamen ein, der in CBE das Geschlecht enth�lt');
DEFINE('_UE_LASTVISITORS_DATESTRING','Datumsformat');
DEFINE('_UE_LASTVISITORS_DATESTRING_DESC','Gib die Formatierung des Datums ein. F�r die m�glichen Kombinationen siehe <a href="http://de2.php.net/manual/de/function.date.php" target=_new>date()</a> Funktion.');
//
DEFINE('_UE_LASTVISITORS_SHOW_VISITCOUNT','Besuchsz�hler');
DEFINE('_UE_LASTVISITORS_SHOW_VISITCOUNT_DESC','Zeigt die Anzahl der Besuche des jeweiligen Users an. Die Ansicht ist nur dem Profilinhaber m�glich.');
DEFINE('_UE_LASTVISITORS_SHOW_VISITEDTAB','Besuchte zeigen');
DEFINE('_UE_LASTVISITORS_SHOW_VISITEDTAB_DESC','Zeigt einen extra Sub-Tab mit den Usern die von diesem User besucht worden sind. "Nein" zeigt den Tab nur dem Profilinhaber.');
DEFINE('_UE_LASTVISITORS_SHOW_HEADERS','Titelzeile');
DEFINE('_UE_LASTVISITORS_SHOW_HEADERS_DESC','Zeigt eine Titelzeile mit einer Bennenung der Felder in der Liste.');
DEFINE('_UE_LASTVISITORS_SHOW_USERFIELD','Extra Feld');
DEFINE('_UE_LASTVISITORS_SHOW_USERFIELD_DESC','Erm�glicht die Anzeige des Inhaltes eines extra Feldes in der Liste des LastVisitor Tab');
DEFINE('_UE_LASTVISITORS_USERFIELD','Feldname');
DEFINE('_UE_LASTVISITORS_USERFIELD_DESC','Gib hier den Feldnamen des zus�tzlichen Feldes an. Dieser Name muss genauso in der Datenbank im _cbe Table zu finden sein!');
//
DEFINE('_UE_LASTVISITORS_GENDERFIELDS_DESC','Im folgendem k�nnen Sie die verwendeten Geschlechter und passenden Bilder definieren. Der Pfad zu einem Bild ist relativ zum Verzeichnis des lastvisitors tab zu sehen.');
DEFINE('_UE_LASTVISITORS_FEMALE','Frau');
DEFINE('_UE_LASTVISITORS_MALE','Mann');
DEFINE('_UE_LASTVISITORS_COUPLE1','Paar 1');
DEFINE('_UE_LASTVISITORS_COUPLE2','Paar 2');
DEFINE('_UE_LASTVISITORS_COUPLE3','Paar 3');
DEFINE('_UE_LASTVISITORS_NEUTRAL','Neutral');
DEFINE('_UE_LASTVISITORS_NEUTRAL_DESC','Dies ist notwendig um Besuchern / gel�schten Benutzern ein Bild zuzuordnen');
DEFINE('_UE_LASTVISITORS_IMAGEPATH','Image path');
DEFINE('_UE_LASTVISITORS_ONLINEOFFLINE','Gib den Pfad zu den Bildern f�r Online / Offline an.');
DEFINE('_UE_LASTVISITORS_ONLINE','Online');
DEFINE('_UE_LASTVISITORS_OFFLINE','Offline');
DEFINE('_UE_LASTVISITORS_CLEANED','LastVisitors Datenbankfeld wurde geleert, aber nicht gel�scht.');

// Username / Password max/min Settings
DEFINE('_UE_REG_USERNAME_MIN','Username min. L�nge');
DEFINE('_UE_REG_USERNAME_MIN_DESC','Gibt die minimale L�nge des Usernamens vor');
DEFINE('_UE_REG_USERNAME_MAX','Username max. L�nge');
DEFINE('_UE_REG_USERNAME_MAX_DESC','Gibt die maximale L�nge des Usernamens vor');
DEFINE('_UE_REG_PASSWORD_MIN','Password min. L�nge');
DEFINE('_UE_REG_PASSWORD_MIN_DESC','Gibt die minimale L�nge des Kennwortes vor');
DEFINE('_UE_REG_PASSWORD_MAIL','Passwort mailen');
DEFINE('_UE_REG_PASSWORD_MAIL_DESC','Versendet das Passwort im Klartext in der Begr�ssungs Mail.');
DEFINE('_UE_REG_GENPASSWORD','Anfangspasswort');
DEFINE('_UE_REG_GENPASSWORD_DESC','Generiert ein Anfangspasswort und versendet es auf jeden Fall mit der Mail. Die Eingabe eines Passworts in der Registrierung wird deaktiviert.');
// RegEx Settings sv0.621
DEFINE('_UE_REG_REGEX','RegEx');
DEFINE('_UE_REG_REGEX_DESC','Hier wird die Regular Expression definiert die auf Usernamen und Kennw�rter beim Anlegen und Registrieren von Benutzern verwendet wird.');
DEFINE('_UE_REG_REGEX_NOTE','CBE-Beta1-1/2 default: ^\_|^\-|[^a-z|A-Z|^0-9|\_|\-]|\_$|\-$ <br> Joomla default: [\<|\>|"|\'|\%|\;|\(|\)|\&|\+|\-|\u0020]');

// Registration Ajax sv0.6232
DEFINE('_UE_REG_USEAJAX','AJAX Pruefung');
DEFINE('_UE_REG_USEAJAX_DESC','Prueft den Usernamen bei der Eingabe auf Verfuegbarkeit. Verwendet AJAX');
DEFINE('_UE_REG_USEAJAX_BUTTON','Pruefknopf');
DEFINE('_UE_REG_USEAJAX_BUTTON_DESC','Bei <b>Nein</b> wird die Pruefung in Echtzeit durchgefuehrt, bei <b>Ja</b> muss ein extra Button benutzt werden.');
DEFINE('_USEAJAX_FAIL_USR','Dieser Username wird verwendet.');
DEFINE('_USEAJAX_TRUE_USR','Der Username ist noch verfuegbar.');

// Registration DataSecurity Ecceptance sv0.6237/0.7
DEFINE('_UE_REG_DATASEC_MSG','Datenschutzhinweis aktivieren');
DEFINE('_UE_REG_DATASEC_MSG_DESC','Zeigt Link und Checkboxfeld zum akzeptieren der Datenschutzhinweise an.');
DEFINE('_UE_REG_DATASEC_URL_MSG','Link zum Datenschutzhinweis');
DEFINE('_UE_REG_DATASEC_URL_MSG_DESC','Vollst�ndige URL zur Contentseite');
DEFINE('_UE_REG_DATASEC_REQUIRED','Die Annahme der Datenschutzhinweise ist notwendig.');
DEFINE('_UE_REG_DATASEC','Datenschutzhinweise gelesen');
//DEFINE('','');

// Admin Switch Userlist->search in username?
DEFINE('_UE_USERLIST_SEARCH_USERNAME','Suche auch im Namen');
DEFINE('_UE_USERLIST_SEARCH_USERNAME_DESC','Erlaubt der Suche in der Benutzerliste auch im realem Namen zu suchen.');

// Admin Switch Userlist-> show lists box?
DEFINE('_UE_USERLIST_SHOW_LISTSBOX','Listen anzeigen');
DEFINE('_UE_USERLIST_SHOW_LISTSBOX_DESC','Gibt an ob die PullDown Auswahl verschiedener publizierter Listen angezeigt werden soll.');
DEFINE('_UE_ALLOW_PROFILE_POPUP','Im PopUp oeffnen');
DEFINE('_UE_ALLOW_PROFILE_POPUP_DESC','Profile werden in einem extra Fenster ohne sonstiges Beiwerk geoeffnet.');
DEFINE('_UE_USERLIST_SHOW_SEARCHBOX','Suchfeld anzeigen');
DEFINE('_UE_USERLIST_SHOW_SEARCHBOX_DESC','Steuert die Anzeige des Suchfeldes in Userlisten zur Suche in den Namen.');


// UHP Integration
DEFINE('_UE_UHP_ALLOW','UHP Link');
DEFINE('_UE_UHP_ALLOW_DESC','Zeigt einen direkten Link zur UHP Seite des Users an.');
DEFINE('_UE_UHP','Mini-HP');
DEFINE('_UE_UHP_LINK','Mini-Homepage und Bilder');
DEFINE('_UE_UHP_LINK_NO',' -- ');

//sv0.621 EasyProfileLink
DEFINE('_UE_SHOW_EASYPROFILELINK','Easy Profile-Link');
DEFINE('_UE_SHOW_EASYPROFILELINK_DESC','Zeigt einen Link zum Bookmarken (IE) der URL Abk�rzung zum betrachteten Profil.');

DEFINE('_UE_FLATTEN_TABS','Tabs als Tabellen');
DEFINE('_UE_FLATTEN_TABS_DESC','Stellt die einzelnen Tabs in der Art einer Tabelle untereinander dar.');
DEFINE('_UE_FLATTEN_TABS_NOTE','Es sei darauf hingewiesen das dies nur eine <b>experimentelle</b> Funktion ist und einen JavaScript Fehler produzieren wird!');

// Sternzeichen
DEFINE('_UE_SHOWZODIAC','Sternzeichen');
DEFINE('_UE_SHOWZODIAC_DESC','Aktiviert die Anzeige des Sternzeichens im Profil ( Hauptschalter )');
DEFINE('_UE_SHOWZODIAC_STATIC','Berechnung statisch');
DEFINE('_UE_SHOWZODIAC_STATIC_DESC','Aktiviert die statische Berechnung der westlichen Sternzeichen.');
DEFINE('_UE_SHOWZODIAC_CH','chin.Sternzeichen');
DEFINE('_UE_SHOWZODIAC_CH_DESC','Aktiviert die Anzeige des chinesischen Sternzeichens im Profil');
DEFINE('_UE_SHOWZODIAC_NOTE','Es muss auf dem LastVisitors-Admin-Tab ein Feld f�r das Geburtsdatum definiert werden, damit die Sternzeichenberechnung funktioniert.
Das Sternzeichen wird basierend auf der 30 Grad Einteilung fuer jedes Sternzeichen berechnet, dies ist genauer als die Zuordnung nach reinen Daten.
Den chinesischen Zeichen fehlt die Ber�cksichtigung des Unterschiedes zum Mondjahr.');
DEFINE('_UE_SHOWZODIAC_TITLE','Sternzeichen');
DEFINE('_UE_SHOWZODIAC_TITLE_CHINESE','Sternzeichen (chinesisch)');
DEFINE('_UE_ZODIAC_NO','keine Daten');
DEFINE('_UE_A_ARIES','Widder');
DEFINE('_UE_A_TAURUS','Stier');
DEFINE('_UE_A_GEMINI','Zwillinge');
DEFINE('_UE_A_CANCER','Krebs');
DEFINE('_UE_A_LEO','L�we');
DEFINE('_UE_A_VIRGO','Jungfrau');
DEFINE('_UE_A_LIBRA','Waage');
DEFINE('_UE_A_SCORPIO','Scorpion');
DEFINE('_UE_A_SAGITTARIUS','Sch�tze');
DEFINE('_UE_A_CAPRICORN','Steinbock');
DEFINE('_UE_A_AQUARIUS','Wassermann');
DEFINE('_UE_A_PISCES','Fische');
DEFINE('_UE_AC_MONKEY','Affe');
DEFINE('_UE_AC_ROOSTER','Hahn');
DEFINE('_UE_AC_DOG','Hund');
DEFINE('_UE_AC_PIG','Schwein');
DEFINE('_UE_AC_RAT','Ratte');
DEFINE('_UE_AC_OX','Ochse');
DEFINE('_UE_AC_TIGER','Tiger');
DEFINE('_UE_AC_RABBIT','Hase');
DEFINE('_UE_AC_DRAGON','Drache');
DEFINE('_UE_AC_SERPENT','Schlange');
DEFINE('_UE_AC_HORSE','Pferd');
DEFINE('_UE_AC_GOAT','Ziege');

// Messages Tags ( Reg. Aproval / Welcome / Reject )
DEFINE('_UE_MAIL_REG_REJECT_SUB','Ihre Registrierung wurde abgelehnt');
DEFINE('_UE_MAIL_REG_REJECT_MSG','Hallo [NAME],

leider musste Ihre Registrierung abgelehnt werden.
Wahrscheinlich passte sie nicht zu den Benutzungsbedingungen.

Mit freundlichen Gruessen,
Website-Admin-Team');
DEFINE('_UE_MAIL_REG_PEND_APPR_SUB','Bitte bestaetigen Sie ihre Registrierung');
DEFINE('_UE_MAIL_REG_PEND_APPR_MSG','Hallo [NAME],

vielen Dank das Sie sich auf unserer Seite registriert haben.
Um Ihre Registrierung abzuschliessen ist es notwendig, 
das Sie diese ueber den folgenden Link bestaetigen:

[CONFIRM]

Sobald dadurch Ihre eMail Adresse bestaetigt wurde, werden unsere Administratoren
Ihre Registrierung weiter bearbeiten. Sobald Ihr Account mit den Daten

[DETAILS]
freigeschaltet ist, erhalten Sie eine weitere Nachricht per eMail.

Mit freundlichen Gruessen,
Website-admin-Team');
DEFINE('_UE_MAIL_REG_WELCOME_SUB','Registrierung abgeschlossen');
DEFINE('_UE_MAIL_REG_WELCOME_MSG','Willkommen [NAME],

Ihre Registrierung ist hiermit abgeschlossen.
Sie k�nnen sich nun auf [SITEURL] 
mit Ihren eingetragenen Daten einloggen:

[DETAILS]

Mit freundlichen Gruessen,
Website-Admin-Team');
//
DEFINE('_UE_ACCTEXP','Verwende com_acctexp');
DEFINE('_UE_ACCTEXP_DESC','Aktiviert die Unterstuetzung von com_acctexp um den Zugang zu limitieren bzw. per Payment einzuschr�nken.');
DEFINE('_UE_ACCTEXP_NOTE','Um diese Hacks zu verwenden, ben�tigt man <b>Account Expiration Control</b> Version 0.8.x');
DEFINE('_UE_ACCTEXP_INSTALLED','AcctExp installiert:');
DEFINE('_UE_SECIMAGES','Verwende com_securityimages');
DEFINE('_UE_SECIMAGES_DESC','Aktiviert die Unterstuetzung von Walter Cedrics Security-Images bei der Registrierung.');
DEFINE('_UE_SECIMAGES_LOSTPASS','Bei LostPass verwenden');
DEFINE('_UE_SECIMAGES_LOSTPASS_DESC','Aktiviert die Unterstuetzung von Security-Images im LostPass-Dialog.');
DEFINE('_UE_SECIMAGES_CBE_LOGIN','Beim Login verwenden');
DEFINE('_UE_SECIMAGES_CBE_LOGIN_DESC','Aktiviert die Unterstuetzung von Security-Images im Login. <br /><b>Bitte unbedingt auch die mod_cbelogin Parameter pr�fen!</b>');
DEFINE('_UE_SECIMAGES_ERROR','Die Eingabe passt nicht zu den Bilddaten.');
DEFINE('_UE_SECIMAGES_NOTE','Um diese Hacks zu verwenden, ben�tigt man <b>Security Images</b> Version 3.x.x');
DEFINE('_UE_SECIMAGES_INSTALLED','SecImage installiert:');
DEFINE('_UE_SMFBRIDGE','Verwende SMF-Bridge (com_smf)');
DEFINE('_UE_SMFBRIDGE_DESC','Aktiviert einen Kompatiblitaetsmodul in der Login Funktion fuer die SMF-Bridge von www.joomlahacks.com.');
DEFINE('_UE_SMFBRIDGE_NOTE','Es wird die Komponente <b>Joomla-SMF Forum</b> Version 1.1 oder hoeher benoetigt.');
DEFINE('_UE_SMFBRIDGE_INSTALLED','SMF-Bridge installiert:');
DEFINE('_UE_FQMULTI','Verwende FQ Multicorreos');
DEFINE('_UE_FQMULTI_DESC','Integriert die Abonierung des FQ Multicorreos Newsletters in den Registrierungsvorgang.');
DEFINE('_UE_FQMULTI_NOTE','Es wird die Komponente <b>FQ Multicorreos</b> Version 1.1 oder hoeher benoetigt.');
DEFINE('_UE_FQMULTI_INSTALLED','FQ Multicorreos installiert:');
DEFINE('_UE_YANC','Verwende YANC');
DEFINE('_UE_YANC_DESC','Integriert die Abonierung des YANC Newsletters in den Registrierungsvorgang.');
DEFINE('_UE_YANC_NOTE','Es wird die Komponente <b>YANC</b> Version 1.4 oder hoeher benoetigt.');
DEFINE('_UE_YANC_INSTALLED','YANC installed:');
//
//
DEFINE('_UE_ALLOW_MAILCHANGE','Wechsel der Mailadresse erlauben');
DEFINE('_UE_ALLOW_MAILCHANGE_DESC','Ermoeglicht das �ndern der hinterlegten eMailadresse zu blocken.');
DEFINE('_UE_FULL_EDITORFIELD','Kein Feldnamen bei Editorfeldern');
DEFINE('_UE_FULL_EDITORFIELD_DESC','Deaktiviert die Anzeige des Feldnamens bei Editor-Feldern. Daten werden dann auf der gesammten Tab breite angezeigt.');
//
// sv0.62 Profile Stats Admin
DEFINE('_UE_PROFILE_STATS_TAB_ADMIN_LABEL','Statistiken');
DEFINE('_UE_SHOW_PROFILE_HITS','Hits anzeigen');
DEFINE('_UE_SHOW_PROFILE_HITS_DESC','Zeigt die Anzahl der Profilaufrufe durch andere User an');
DEFINE('_UE_SHOW_PROFILE_STATS','Account Infos anzeigen');
DEFINE('_UE_SHOW_PROFILE_STATS_DESC','Zeigt Account bezogene Statistikdaten an. ( Datum der Registrierung, zuletzt Online, letztes Profile Update)');
DEFINE('_UE_SHOW_CORE_USERTYPE','Benutzergruppe zeigen');
DEFINE('_UE_SHOW_CORE_USERTYPE_DESC','Zeigt im Profil die aktive Benutzergruppe des Users an');
DEFINE('_UE_CB_CORE_USERTYPE','Benutzergruppe');
//
// sv0.623 Mail on Profile Update
DEFINE('_UE_SENDMAIL_ON_PROFILE_UPDATE','Profileaenderungen melden');
DEFINE('_UE_SENDMAIL_ON_PROFILE_UPDATE_DESC','Sendet eine Info-Mail an die Moderatoren wenn ein User sein Profil aendert');
DEFINE('_UE_USER_PROFILE_UPDATE','User-Profil-Aenderung');
DEFINE('_UE_USER_PROFILE_UPDATE_MSG','Hallo,

Der User mit den Daten
[NAME]
[DETAILS]
hat in seinem Profil Aenderngen gespeichert.

Mit freundlichen Gruessen,
Website-Admin-Team');
//
// Mailer X-Header Changer
DEFINE('_UE_SET_MAIL_XHEADER','Mail X-Header');
DEFINE('_UE_SET_MAIL_XHEADER_DESC','�ndert den Mailer Typ f�r versandte Mails. Dies kann Probleme mit einigen Providern beheben. <b>Nur aktiv wenn kein mosMailer gefunden wurde!</b>');
//
// GroupJive Admin 
DEFINE('_UE_PROFILE_GROUPJIVE_TAB_ADMIN_LABEL','GroupJive');
DEFINE('_UE_GROUPJIVE_NOTE','Bitte stellen Sie sicher das GroupJive ( www.groupjive.com ) installiert ist bevor eine dieser Optionen aktiviert wird. Es wird ihnen angezeigt ob und welche Version evtl. installiert ist.');
DEFINE('_UE_GROUPJIVE_INSTALLED','GroupJive Version');
DEFINE('_UE_GJ_INTEGRATION','GroupJive Integration');
DEFINE('_UE_GJ_INTEGRATION_DESC','Aktiviert die Unterst�tzung f�r GJ. Es werden GJ relevante Infos im Profil / Tab angezeigt ');
DEFINE('_UE_GJ_SHOW_OWNDED_GROUPS','Eigene Gruppen zeigen');
DEFINE('_UE_GJ_SHOW_OWNDED_GROUPS_DESC','Zeigt die Gruppen im Profil bei denen ein Nutzer Moderator bzw. Eigent�mer ist');
DEFINE('_UE_GJ_LINK_OWNED_GROUPS','Eigene Gruppen verlinken');
DEFINE('_UE_GJ_LINK_OWNED_GROUPS_DESC','Erg�nzt die Anzeige der moderierten Gruppen im Profil um einen Link zum Tab wenn mehr als eine Gruppe gefunden wurde.');
// GJ Frontend
DEFINE('_UE_GROUPJIVE_OWNER','Gr�nder von');
DEFINE('_UE_GROUPJIVE_G','Gruppe');
DEFINE('_UE_GROUPJIVE_GS','Gruppen');
//
// sv0.6232
DEFINE('_UE_FIELDINFORMATION','hilfreiche Informationen');
DEFINE('_UE_AVATARUPLOADONREG','Hochladen bei der Registrierung?');
DEFINE('_UE_AVATARUPLOADONREG_DESC','Erlaubt die Angabe eines Avatarbildes bei der Registrierung.');
DEFINE('_UE_AVATARUPLOADONREGFRONT','Avatar Upload');
DEFINE('_UE_AVATARDELETE_JS','L�schbestetigung erforderlich?');
DEFINE('_UE_AVATARDELETE_JS_DESC','Fragt per JavaScript vor dem L�schen des Avatars beim Nutzer nach.');
// sv0.701
DEFINE('_UE_AVATAR_SHOW_RULES','Leitlinien anzeigen');
DEFINE('_UE_AVATAR_SHOW_RULES_DESC','Aktiviert den Link zu den Regeln f�r Bilder.');
DEFINE('_UE_AVATAR_SHOW_RULES_URL','Leitlinien URL');
DEFINE('_UE_AVATAR_SHOW_RULES_URL_DESC','Die URL zum Content mit den Leitiniern / Regeln.');
DEFINE('_UE_AVATAR_RULES_LINKTEXT','Bitte beachten Sie die Regeln f�r Profilbilder.');
DEFINE('_UE_AVATAR_RULES_IGNORED','Bitte best�tigen Sie die Einhaltung der Regeln.');
//
// sv0.6233
DEFINE('_UE_UNAME_PATHWAY','User in Pathway');
DEFINE('_UE_UNAME_PATHWAY_DESC','Bei Ja wird der Username im Pathway angezeigt, bei Nein wird das Namensformat benutzt.');
DEFINE('_UE_SHOW_JEDITOR','Editoren Auswahl zeigen');
DEFINE('_UE_SHOW_JEDITOR_DESC','Zeigt dem User eine Auswahl an Editoren f�r Joomla. Dies ist nicht unter Mambo verf�gbar.');
DEFINE('_UE_CBE_DELET_AVATAR_NOTE','Soll das aktuelle Bild tats�chlich gel�scht werden?');
DEFINE('_UE_USERSLIST_CSS1','ungerade Zeilen');
DEFINE('_UE_USERSLIST_CSS1_DESC','Gibt die CSS Klasse f�r die ungeraden Zeilen innerhalb der Liste an. Die Klasse mu� am Ende die Ziffer 1 tragen!');
DEFINE('_UE_USERSLIST_CSS2','gerade Zeilen');
DEFINE('_UE_USERSLIST_CSS2_DESC','Gibt die CSS Klasse f�r die geraden Zeilen innerhalb der Liste an. Die Klasse mu� am Ende die Ziffer 2 tragen!');
DEFINE('_UE_USERSLIST_RNR','Anzahl pro Zeile');
DEFINE('_UE_USERSLIST_RNR_DESC','Gibt die Anzahl Profile in einer Zeile der Userliste an wenn nur eine Spalte zur Anzeige aktiv ist.');
DEFINE('_UE_AVATARGALLERY_ROWS','Spaltenzahl');
DEFINE('_UE_AVATARGALLERY_ROWS_DESC','Gibt die Anzahl der Spalten an in denen die zur Auswahl stehenden Bilder angezeigt werden sollen.');
DEFINE('_UE_WATERMARKS','Wasserzeichen');
DEFINE('_UE_WATERMARKS_NOTE','Die Funktion des Wasserzeichens setzt ein 24Bit PNG Bild vorraus.<br>Ebenso muss der nachfolgende Check erfolgreich sein.');
DEFINE('_UE_WM_BASICS','Pr�fung bestanden');
DEFINE('_UE_WM_BASICS_DESC','Prueft grundlegende Funktionen der Bildbearbeitung. Diese sind f�r das Auff�llen und Wasserzeichen notwendig');
DEFINE('_UE_WM_FORCEPNG','zu PNG wandeln');
DEFINE('_UE_WM_FORCEPNG_DESC','Erzwingt die Wandlung aller Bilder in das PNG Format. Dies ist f�r das Wasserzeichen notwendig. Bei GIF Bildern wird nur der erste Frame uebernommen.');
DEFINE('_UE_WM_FORCEZOOM','HochZoomen');
DEFINE('_UE_WM_FORCEZOOM_DESC','Erzwingt das Hochzoomen kleiner Bilder auf mindestens einen Wert von definierter H�he und Breite.');
DEFINE('_UE_WM_CANVAS','Bild auff�llen');
DEFINE('_UE_WM_CANVAS_DESC','F�llt das hochgeladenen Bild auf die eingestellten max. Werte auf.');
DEFINE('_UE_WM_CANVAS_TRANS','Transparent');
DEFINE('_UE_WM_CANVAS_TRANS_DESC','Setzt die gewaehlte Farbe als transparent fuer die verwendete Leinwand des Auff�llens.');
DEFINE('_UE_WM_CANVAS_COLOR','Leinwandfarbe');
DEFINE('_UE_WM_CANVAS_COLOR_DESC','Die Farbe der Leinwand beim Auffuellen. Ein hex Farbwert ohne #');
DEFINE('_UE_WM_STAMPIT','Stempel aktiv');
DEFINE('_UE_WM_STAMPIT_DESC','Stempelt einen Text vertikal ins Bild. Sofern leer wird die ShortURL des Profils verwendet.Aktiv wenn Wasserzeichen aktiv.');
DEFINE('_UE_WM_STAMPIT_TEXT','Stempeltext');
DEFINE('_UE_WM_STAMPIT_SIZE','Textgr��e');
DEFINE('_UE_WM_STAMPIT_SIZE_DESC','Gibt die Gr��e des Textes an.');
DEFINE('_UE_WM_STAMPIT_COLOR','Textfarbe');
DEFINE('_UE_WM_STAMPIT_COLOR_DESC','Angabe der Textfarbe als sechstelliger HexCode ohne #');
DEFINE('_UE_WM_DOIT','Wasserzeichen');
DEFINE('_UE_WM_DOIT_DESC','Gibt an ob ein Wasserzeichen eingebunden werden soll');
DEFINE('_UE_WM_FILENAME','Dateiname');
DEFINE('_UE_WM_FILENAME_DESC','Der Name der Wasserzeichendatei. Diese muss im /images/cbe/watermark/ gespeichert sein.');
//
DEFINE('_UE_CBE_ADD','Hinzuf�gen');
DEFINE('_UE_CBE_REMOVE','Entfernen');
DEFINE('_UE_CBE_DELETE','L�schen');
DEFINE('_UE_CBE_M_CLICK','(klick)');
DEFINE('_UE_CBE_M_ADMIN','(Admin)');
DEFINE('_UE_CBE_M_USER','(User)');
DEFINE('_UE_CBE_M_JOOMLA','(System)');
// List Manager
DEFINE('_UE_CBE_LIST_MANAGER','Suchlisten Verwaltung');
DEFINE('_UE_CBE_NR_DISPLAY','Anzahl pro Seite');
DEFINE('_UE_CBE_LM_SEARCH','Suche');
DEFINE('_UE_CBE_TITLE','Titel');
DEFINE('_UE_CBE_DESCRIPTION','Beschreibung');
DEFINE('_UE_CBE_PUBLISHED','Ver�ffentlicht');
DEFINE('_UE_CBE_DEFAULT','Standardliste');
DEFINE('_UE_CBE_LIST_ID','ID der Liste');
DEFINE('_UE_CBE_RE_ORDER','Sortierung');
DEFINE('_UE_CBE_LM_EDIT','Liste bearbeiten');
DEFINE('_UE_CBE_LM_ADD','Liste hinzuf�gen');
DEFINE('_UE_CBE_GID_INCL','einzubeziehende Usergruppen');
DEFINE('_UE_CBE_GID_ACL','Usergruppen mit Zugriffsrechten');
DEFINE('_UE_CBE_GID_ACL_DESC','Alle Gruppen �ber der gew�hlten haben Zugriff.');
DEFINE('_UE_CBE_SORT_BY','Sortiert nach');
DEFINE('_UE_CBE_LM_ASC','Aufsteigend');
DEFINE('_UE_CBE_LM_DESC','Absteigend');
DEFINE('_UE_CBE_LM_FILTER','SQL-Filter');
DEFINE('_UE_CBE_LM_FSIMPLE','Einfach');
DEFINE('_UE_CBE_LM_FADVANCED','Komplex');
DEFINE('_UE_CBE_LM_SQL_1','Gr��er als');
DEFINE('_UE_CBE_LM_SQL_2','Gr��er als od. Gleich');
DEFINE('_UE_CBE_LM_SQL_3','Kleiner als');
DEFINE('_UE_CBE_LM_SQL_4','Kleiner als od. Gleich');
DEFINE('_UE_CBE_LM_SQL_5','ist Gleich');
DEFINE('_UE_CBE_LM_SQL_6','ist nicht Gleich');
DEFINE('_UE_CBE_LM_SQL_7','ist Leer');
DEFINE('_UE_CBE_LM_SQL_8','ist nicht Leer');
DEFINE('_UE_CBE_LM_SQL_9','ist wie');
DEFINE('_UE_CBE_LM_FILTER_ONLINE','Nur Online-User anzeigen');
DEFINE('_UE_CBE_LM_FIELD_LIST','Liste verf�gbarer Felder');
DEFINE('_UE_CBE_LM_COLUMN_ENABLE','Aktive Spalte');
DEFINE('_UE_CBE_LM_COLUMN_TITLE','Titel der Spalte');
DEFINE('_UE_CBE_LM_COLUMN_CAPTIONS','Feldtitel in Spalte');
// Field Manager
DEFINE('_UE_CBE_FIELD_MANAGER','Datenfeld Verwaltung');
DEFINE('_UE_CBE_FM_SEARCH','Suche');
DEFINE('_UE_CBE_FM_DBNAME','Name in DB');
DEFINE('_UE_CBE_FM_FIELDNAME','Bezeichnung');
DEFINE('_UE_CBE_FM_FIELDTYPE','Feldtyp');
DEFINE('_UE_CBE_FM_FIELDTAB','Tab');
DEFINE('_UE_CBE_FM_REQUIRED','Erforderlich');
DEFINE('_UE_CBE_FM_PROFILE','Profil');
DEFINE('_UE_CBE_FM_SHOW_ON_PROFILE','Im Profil anzeigen');
DEFINE('_UE_CBE_FM_REGISTRATION','Registrierung');
DEFINE('_UE_CBE_FM_REQUIRED_FOR_REGISTRATION','Pflichtfeld bei Registrierung');
DEFINE('_UE_CBE_FM_PUBLISHED','Aktiviert');
DEFINE('_UE_CBE_FM_RE_ORDER','Sortierung');
DEFINE('_UE_CBE_FM_EDIT','Datenfeld bearbeiten');
DEFINE('_UE_CBE_FM_ADD','Datenfeld hinzufügen');
DEFINE('_UE_CBE_FM_READ_ONLY','User darf nur lesen');
DEFINE('_UE_CBE_FM_USE_IN_CBSEARCH','Feld in erweiterter Suche (cbsearch) verwenden');
DEFINE('_UE_CBE_FM_FIELD_TOOLTIP','Hinweise zum Feld (ToolTip)');
DEFINE('_UE_CBE_FM_FIELD_NO_TP','Keine Hinweise');
DEFINE('_UE_CBE_FM_FIELD_ICON_TP','als Icon anzeigen');
DEFINE('_UE_CBE_FM_FIELD_TAGED_TP','als Overlay zur Bezeichnung');
DEFINE('_UE_CBE_FM_FIELD_BOTH_TP','beide Varianten anzeigen');
DEFINE('_UE_CBE_FM_SIZE','Feldgr��e');
DEFINE('_UE_CBE_FM_MAX_LENGTH','max. L�nge');
DEFINE('_UE_CBE_FM_COLS','Anzahl Spalten');
DEFINE('_UE_CBE_FM_ROWS','Anzahl Reihen');
DEFINE('_UE_CBE_FM_VALUES_INFO','In der nachfolgenden Tabelle werden die Inhaltswerte des Feldes verwaltet.');
DEFINE('_UE_CBE_FM_ADD_VALUE','Wert hinzuf�gen');
DEFINE('_UE_CBE_FM_BD_LOWRANGE','kleinstes Jahr');
DEFINE('_UE_CBE_FM_BD_HIGHRANGE','gr��tes Jahr');
DEFINE('_UE_CBE_FM_BD_STARTDATE','Vorauswahl (Jahr)');
// Tab Manager
DEFINE('_UE_CBE_TAB_MANAGER','Tab Verwaltung');
DEFINE('_UE_CBE_TM_SEARCH','Suche');
DEFINE('_UE_CBE_TM_TITLE','Bezeichnung');
DEFINE('_UE_CBE_TM_DESCRIPTION','Beschreibung');
DEFINE('_UE_CBE_TM_PUBLISHED','Aktiviert');
DEFINE('_UE_CBE_TM_RE_ORDER','Sortierung');
DEFINE('_UE_CBE_TM_EDIT','Tab bearbeiten');
DEFINE('_UE_CBE_TM_ADD','Tab hinzuf�gen');
DEFINE('_UE_CBE_TM_ENH_PARAMS','Erweiterte Parameter');
DEFINE('_UE_CBE_TM_NESTED','SubTab bzw. verschachtelt');
DEFINE('_UE_CBE_TM_ISNEST','Sammeltab');
DEFINE('_UE_CBE_TM_NESTID','SubTab von');
DEFINE('_UE_CBE_TM_ACL_DESC1','<b>STRG zur Mehrfachauswahl verwenden!</b><br>Der Zugriff f�r alle Nutzer ist gegeben, wenn alle od. keine Gruppe ausgew�hlt ist.');
DEFINE('_UE_CBE_TM_ACL_DESC2','Tabs deren Zugriff auf Admin oder Super-Admin beschr�nkt sind, k�nnen vom Benutzer im EditMode nicht gesehen werden!');
DEFINE('_UE_CBE_TM_FEXPLAIN','wichtiger Hinweis');
DEFINE('_UE_CBE_TM_FEXPLAIN_DESC','Die nachfolgenden Bedingungen steuern wann welcher Tab angezeigt wird.
Beim Experten-Modus wird als Ergebnis immer nur ein Wert ausgelesen und dieser muss entweder auf die UserID des Eigentuemers od. die UserID des Betrachters passen.
Entsprechend sind als Variabeln nur $my->id und $user->id erlaubt. Tabellen koennen per #__cbe Notation angesprochen werden. Es sind aber nur SELECT Zugriffe erlaubt.');
DEFINE('_UE_CBE_TM_FSIMPLE','Einfach');
DEFINE('_UE_CBE_TM_FADVANCED','Fortgeschritten');
DEFINE('_UE_CBE_TM_FINDIVIDUAL','Experten-Modus');
DEFINE('_UE_CBE_TM_FQME','Bedingungen f�r den Eigner');
DEFINE('_UE_CBE_TM_FQYOU','Bedingungen f�r den Betrachter');
DEFINE('_UE_CBE_TM_FQBIND','Bedingungen verbinden mit');
DEFINE('_UE_CBE_TM_FINVALID','SQL-Bedingung ung�ltig');
DEFINE('_UE_CBE_TM_FQYOU_INVERT','Wendet die Bedingung des Besuchers auf den Eigner an, so das der Eigner das Profil immer sieht, der Besucher aber von den Einstellungen des Eigners abh�ngig ist.');
DEFINE('_UE_CBE_TM_FHELP','');
// User Manager
DEFINE('_UE_CBE_USER_MANAGER','Benutzer Verwaltung');
DEFINE('_UE_CBE_UM_SEARCH','Suche');
DEFINE('_UE_CBE_UM_REALNAME','Name');
DEFINE('_UE_CBE_UM_USERNAME','UserName');
DEFINE('_UE_CBE_UM_LOGGED_IN','Angemeldet');
DEFINE('_UE_CBE_UM_USERGROUP','Benutzergruppe');
DEFINE('_UE_CBE_UM_USER_PARAMS','pers�nliche Parameter');
DEFINE('_UE_CBE_UM_EMAIL','eMail');
DEFINE('_UE_CBE_UM_LAST_VISIT','Letzte Anmeldung');
DEFINE('_UE_CBE_UM_ENABLED','Aktiviert');
DEFINE('_UE_CBE_UM_CONFIRMED','Best�tigt');
DEFINE('_UE_CBE_UM_APPROVED','Freigegeben');
DEFINE('_UE_CBE_UM_AVATAR_APPROVED','Avatar freigegeben');
DEFINE('_UE_CBE_UM_EDIT','Benutzer bearbeiten');
DEFINE('_UE_CBE_UM_ADD','Benutzer hinzuf�gen');
DEFINE('_UE_CBE_UM_BLOCK_USER','Anmeldung gesperrt');
DEFINE('_UE_CBE_UM_BAN_USER','Profil gesperrt');
DEFINE('_UE_CBE_UM_USERDATA_APPROVED','Benutzerdaten freigegeben');
DEFINE('_UE_CBE_UM_USER_CONFIRMED','Anmeldung best�tigt');
DEFINE('_UE_CBE_UM_SUBMISSION_MAIL','HinweisMails des Systems empfangen');
DEFINE('_UE_CBE_UM_REGISTER_DATE','Registriert am');
DEFINE('_UE_CBE_UM_USERMAIL_ON_ADMIN_ADD','Hallo [NAME],

Sie sind durch einen Administrator als Benuter der Site [SITEURL] eingetragen worden.
Diese eMail enth�lt Ihren Benutzernamen und das Anfangskennwort mit denen Sie sich auf
[SITEURL] Site anmelden koennen:

Username - [USERNAME]
Password - [PASSWORD-CLEAR]

Bitte aendern Sie ihr Kennwort bei Ihrer ersten Anmeldung.

Diese Nachricht wurde automatisch generiert und dient nur der Information.

Mit freundlichen Gruessen,
Website-Admin-Team
(Robot)
');
// Search Manager - einige Tags sind dem Field-Manager entliehen
DEFINE('_UE_CBE_SEARCH_MANAGER','CBsearch Verwaltung');
DEFINE('_UE_CBE_SM_SEARCH','Suche');
DEFINE('_UE_CBE_SM_RANGE','�ber Bereich suchen');
DEFINE('_UE_CBE_SM_MODULE','Module');
DEFINE('_UE_CBE_SM_USERLISTID','Darstellung mit');
DEFINE('_UE_CBE_SM_USERLISTID_DESC','Gibt als Ausgabetemplate die ausgew�hlte UsersList vor.');
DEFINE('_UE_CBE_SM_SEARCH_TIMEOUT','G�ltigkeitsdauer');
DEFINE('_UE_CBE_SM_SEARCH_TIMEOUT_DESC','Gibt die G�ltigkeitsdauer einer Suchanfrage an. Alle Anfragen �lter als x Minuten werden aus der DB gel�scht. Bl�ttern verl�ngert die G�ltigkeit nicht.');
// Blocked Names Management
DEFINE('_UE_CBE_BLOCKED_NAMES_MANAGER','Verwaltung zensierter Namensteile');
DEFINE('_UE_CBE_BNM_LIST_OF_PARTS','Liste der Namesteile');
DEFINE('_UE_CBE_BNM_PUBLISHED','Aktiviert');
DEFINE('_UE_CBE_BNM_POPERROR','Es muss ein Namensteil angegeben werden.');
DEFINE('_UE_CBE_BNM_NAME_PART','gesperrter Namensteil');
// Language Filter Management
DEFINE('_UE_CBE_LANGUAGE_FILTER_MANAGER','Verwaltung zensierter W�rter');
DEFINE('_UE_CBE_LFM_LIST_OF_WORDS','Liste zensierter W�rter');
DEFINE('_UE_CBE_LFM_PUBLISHED','Aktiviert');
DEFINE('_UE_CBE_LFM_POPERROR','Es muss ein (Teil)Wort angegeben werden.');
DEFINE('_UE_CBE_LFM_WORD','zensiertes Wort');
//
// 0.6235
DEFINE('_UE_CBEDOLOGIN','CBE Login');
DEFINE('_UE_CBEDOLOGIN_DESC','Aktiviert die Anmeldung des Users an Joomla durch den CBE. Andernfalls werden die Daten an die index.php weitergereicht. <b>Aktivierung empfohlen sofern keinerlei Bridgen benutzt werden.</b>');
// TopMostUser
DEFINE('_UE_TPM_FETITLE','Onlinezeit Statistik');
DEFINE('_UE_TPM_COUNT','Anzahl Anmeldungen');
DEFINE('_UE_TPM_TIMESUM','Zeit');
DEFINE('_UE_TPM_AVG','Durchschnitt');
DEFINE('_UE_TPM_NOTACTIVE','TopMostUser Statistik ist nicht aktiviert');
DEFINE('_UE_TPMA_ACTIVE','TopMost aktivieren');
DEFINE('_UE_TPMA_ACTIVE_DESC','Aktiviert die Statistik f�r die TopMostUser Statistik');
DEFINE('_UE_TPMA_LIMIT','Top x User');
DEFINE('_UE_TPMA_LIMIT_DESC','Anzahl der User in der TopListe');
// JSe
DEFINE('_UE_CBE_EMAIL_ERROR','Das Format der eMail stimmt nicht.');
DEFINE('_UE_CBE_FLOAT_ERROR','Bitte keine Buchstaben. Es sind nur Zahlen erlaubt.');
DEFINE('_UE_CBE_INTEGER_ERROR','Bitte keine Buchstaben. Es sind nur ganze Zahlen erlaubt.');
DEFINE('_CBE_TEXTAREA_LIMIT_ERROR','Maximale Zeichenanzahl:');
DEFINE('_UE_CBE_FILL_ALL_ERROR','Bitte f�llen Sie alle Felder aus.');
DEFINE('_UE_CBE_JS_DATE_INVALID','Das eigetragene Datum ist fehlerhaft.');
DEFINE('_UE_CBE_JS_DATE_OUTOFRANGE','Das eingetragene Datum liegt ausserhalb des zul�ssigen Bereiches.');
//
DEFINE('_UE_REG_CONFIRMATION_HASH','Hash-Zahl');
DEFINE('_UE_REG_CONFIRMATION_HASH_DESC','Eine Flie�kommazahl die den Confirmcode erg�nzt um Bruteforce-Aktivierungen zu verhinden.');
DEFINE('_UE_ADMINSHOWALLTABS','Im Backend alle Tabs anzeigen');
DEFINE('_UE_ADMINSHOWALLTABS_DESC','Ignoriert die Tab-Regeln bezogen auf den Eigner im Backend.');
DEFINE('_UE_CBE_BE_NEW_ORDER','Neu ordnen');
DEFINE('_UE_CBE_BE_NEW_ORDER_SAVED','Neue Reihenfolge wurde gespeichert!');
DEFINE('_UE_CBE_BANREQUEST_DOBLOCK','Anmeldung des Users komplett sperren und Begr�ndung per Mail versenden?');
DEFINE('_UE_CBE_BANUSER_BLOCK_MSG','Ihr Benutzerprofil, sowie die Moeglichkeit zur Anmeldung wurden von einem Administrator gesperrt.
Bitte kontaktieren Sie die Verantwortlichen per eMail od. Site-Kontaktformular.

Der verantwortliche Administrator/Moderator hat den folgenden Grund mit angegeben.\r\n');
//
DEFINE('_UE_CBE_GALLERY','CBE-Gallery');
DEFINE('_UE_CBE_GALLERY_DESC','Nur aktivieren wenn die CBE-Gallery (>1.3) installiert ist.');
DEFINE('_UE_CBE_GALLERY_REQUIREACTION','User-Gallery-Bild(er)');
//
DEFINE('_UE_CBE_CALCED_AGE','Alter');
DEFINE('_UE_PROFILE_GEOCODER_TAB_ADMIN_LABEL','GeoCoder');
DEFINE('_UE_CBE_GEOCODER_GOOGLE_APIKEY','ApiKey');
DEFINE('_UE_CBE_GEOCODER_GOOGLE_APIKEY_DESC','Bitte geben Sie ihren Google Maps Api Key hier ein. Wenn die Komponente GoogleMaps installiert ist wird der dortige Key ausgelesen.');
DEFINE('_UE_CBE_GEOCODER_CODERMETHOD','Api Connect');
DEFINE('_UE_CBE_GEOCODER_CODERMETHOD_DESC','Bestimmt die Art wie die API aufgerufen wird um die Adresse umzuwandeln. HTTP benutzt fsockopen() was nicht jeder Hoster erlaubt, JavaScript sollte generell funktionieren.');
DEFINE('_UE_CBE_GEOCODER_USERAGREE','Userzustimmung');
DEFINE('_UE_CBE_GEOCODER_USERAGREE_DESC','Aktiviert eine Checkbox mit der der User die Nutzung der GeoCoord im CBE zustimmen kann.');
DEFINE('_UE_CBE_GEOCODER_LOCK_ADDR','Adresse sperren');
DEFINE('_UE_CBE_GEOCODER_LOCK_ADDR_DESC','Bei erfolgreicher Geocodierung wird das Adressfeld gesperrt um eine erneute Codierung zu verhindern.');
DEFINE('_UE_CBE_GEOCODER_SHOW_ACC','Genaugigkeit zeigen');
DEFINE('_UE_CBE_GEOCODER_SHOW_ACC_DESC','Zeigt den Grad der Genauigkeit der Geocodierung an.');
DEFINE('_UE_CBE_GEOCODER_USE_ADDRFIELD','CBE Feld verwenden');
DEFINE('_UE_CBE_GEOCODER_USE_ADDRFIELD_DESC','Bei Aktivierung werden die unten per DB-Namen angegebenen Felder zum Auslesen der Adresse verwendet.');
DEFINE('_UE_CBE_GEOCODER_SINGLE_ADDRFIELD','Adresse in einem Feld');
DEFINE('_UE_CBE_GEOCODER_SINGLE_ADDRFIELD_DESC','Zeigt zur Eingabe der Adresse nur ein Feld, ansonsten werden mehrere anzezeigt.');
DEFINE('_UE_CBE_GEOCODER_USE_ADDRFIELD_AUTO','Automatisch Speichern');
DEFINE('_UE_CBE_GEOCODER_USE_ADDRFIELD_AUTO_DESC','Liest, codiert und speichert die Koordinaten aus den Feldern beim Speichern des Profils');
DEFINE('_UE_CBE_GEOCODER_ALLOW_DIRECTINPUT','GeoCoord Eingabe erlauben');
DEFINE('_UE_CBE_GEOCODER_ALLOW_DIRECTINPUT_DESC','Erlaubt die Eingabe von GeoCoordinaten ohne vorhergehende Codierung einer Adresseingabe.');
DEFINE('_UE_CBE_GEOCODER_ALLOW_VISUALVERIFY','Visuelle Kontrolle');
DEFINE('_UE_CBE_GEOCODER_ALLOW_VISUALVERIFY_DESC','Zeigt bei erfolgreicher Codierung od. direkten GeoCoord eine Google-Map zur visuellen Verifizierung an.');
DEFINE('_UE_CBE_GEOCODER_VISUALRELOCATE','Erlaube Versetzung');
DEFINE('_UE_CBE_GEOCODER_VISUALRELOCATE_DESC','(Drag&Drop) Erlaubt die Versetzung des Markers bei visueller Verfizierung incl. automatischer Aktualisierung der GeoCoordinaten');
DEFINE('_UE_CBE_GEOCODER_VISUALRELOCATE_ONCLICK','Versetzung per Click');
DEFINE('_UE_CBE_GEOCODER_VISUALRELOCATE_ONCLICK_DESC','(Click) Erlaubt die Versetzung des Markers bei visueller Verfizierung incl. automatischer Aktualisierung der GeoCoordinaten');
DEFINE('_UE_CBE_GEOCODER_FIELD_DBNAME','DB-Name');
DEFINE('_UE_CBE_GEOCODER_STREET_DBNAME','Strasse/Nr');
DEFINE('_UE_CBE_GEOCODER_POSTCODE_DBNAME','Postleitzahl');
DEFINE('_UE_CBE_GEOCODER_CITY_DBNAME','Stadt');
DEFINE('_UE_CBE_GEOCODER_STATE_DBNAME','Kreis/Land');
DEFINE('_UE_CBE_GEOCODER_COUNTRY_DBNAME','Staat');
DEFINE('_UE_CBE_GEOCODER_DO_EXPORT','GeoCoords exportieren');
DEFINE('_UE_CBE_GEOCODER_DO_EXPORT_DESC','Schreibt die Lat/Lang Coordinaten in cb_geolatitude & cb_geolongitude. Diese Felder m�ssen eigenh�ndig erstellt werden!');
// usermap
DEFINE('_UE_PROFILE_GEOCODER_USERMAP_ADMIN_LABEL','GeoUserMap');
DEFINE('_UE_CBE_GEOCODER_SHOW_USERMAP','Zentrale Karte aktivieren');
DEFINE('_UE_CBE_GEOCODER_SHOW_USERMAP_DESC','Aktiviert die Erreichbarkeit der UserMap hinter der CBE Funktion');
DEFINE('_UE_CBE_GEOCODER_ALLOW_VIEWBYGID','Zugriff erlaubt f�r');
DEFINE('_UE_CBE_GEOCODER_ALLOW_VIEWBYGID_DESC','Gibt die kleineste zugriffsberechtigte Gruppe an.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_HEIGHT','H�he');
DEFINE('_UE_CBE_GEOCODER_USERMAP_HEIGHT_DESC','H�he der angezeigten Karte. Die Verwendung von absoluten Werten ist angeraten.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_WIDE','Breite');
DEFINE('_UE_CBE_GEOCODER_USERMAP_WIDE_DESC','Breite der angezeigten Karte. Die Verwendung von absoluten Werten ist angeraten.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_XML_UPDATE_INTERVAL','XML Update Interval');
DEFINE('_UE_CBE_GEOCODER_USERMAP_XML_UPDATE_INTERVAL_DESC','Gibt die Zeit <b>in Minuten</b> an, nachdenen die XML Datei der Koordinaten neu geschrieben wird. Bei 0 muss das Update per Tools vollzogen werden.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_SCANWIDE','Anzahl User');
DEFINE('_UE_CBE_GEOCODER_USERMAP_SCANWIDE_DESC','0 bedeutet alle User werden erfasst. Jede andere Zahl gibt das Maximum der in der Karte dargestellten Nutzer an.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCECENTER','Startpunkt erzwingen');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCECENTER_DESC','Erzwingt den Start der Map vom unten angegebenen Punkt. Andernfalls werden die GeoCoordinaten des Betrachters als Startpunkt verwendet.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCECENTER_LAT','Latitute');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCECENTER_LAT_DESC','geographische Breite');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCECENTER_LNG','Longitute');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCECENTER_LNG_DESC','geographische L�nge');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCEUNSHARP','Unsch�rfe erzwingen');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCEUNSHARP_DESC','Begrenzt die Genauigkeit der Geokoordinaten auf 6 Nachkommastellen. Manuell nachplazierte Adress-Marker werden dadurch unscharf.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCEUNSHARP_DIGIT','Nachkommastellen');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCEUNSHARP_DIGIT_DESC','Anzahl der zu nutzenden Nachkommastellen. Gilt nur wenn Unsch�rfe erzwungen wird.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_SHOWSEARCH','Suchzeile');
DEFINE('_UE_CBE_GEOCODER_USERMAP_SHOWSEARCH_DESC','Aktiviert eine Suchzeile zum einfachen Neuausrichten der Karte.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_STARTZOOM','Zoomfaktor');
DEFINE('_UE_CBE_GEOCODER_USERMAP_STARTZOOM_DESC','Gibt den Zoomfaktor beim ersten Aufruf der Karte und beim Neuausrichten an.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_STARTTYPE','Kartentyp');
DEFINE('_UE_CBE_GEOCODER_USERMAP_STARTTYPE_DESC','Gibt den Kartentyp beim ersten Aufruf an.');
//
DEFINE('_UE_GEOCODER_USERMAP_NOT_ACTIVE','Die CBE UserMap ist nicht aktiviert.');
//
DEFINE('_UE_CBE_GEOCODER_Q_WORKING','.. Abfrage l�uft ..');
DEFINE('_UE_CBE_GEOCODER_Q_OVERLOADBLOCK','Bitte warte Sie 30 Sek. bis zur n�chsten Anfrage.');
DEFINE('_UE_CBE_GEOCODER_EDIT_LABEL','GeoCoder');
DEFINE('_UE_CBE_GEOCODER_E_ADDR','Adresseingabe');
DEFINE('_UE_CBE_GEOCODER_E_BTN','Pr�fen');
DEFINE('_UE_CBE_GEOCODER_CHANGE_BTN','�ndern');
DEFINE('_UE_CBE_GEOCODER_CLEARALL_BTN','L�schen');
DEFINE('_UE_CBE_GEOCODER_E_STATUS','Status');
DEFINE('_UE_CBE_GEOCODER_E_ACC','Genauigkeit');
DEFINE('_UE_CBE_GEOCODER_E_GEOLNG','L�nge');
DEFINE('_UE_CBE_GEOCODER_E_GEOLAT','Breite');
DEFINE('_UE_CBE_GEOCODER_E_ALLOWVIEW','Im Profil darstellen');
DEFINE('_UE_CBE_GEOCODER_E_ALLOWVIEW_CHECKSAVED','.:Gespeicherte Koordinaten anzeigen:.');
DEFINE('_UE_CBE_GEOCODER_E_QSUCCESS','Gefunden');
DEFINE('_UE_CBE_GEOCODER_E_QFAILURE','Adresse nicht aufl�sbar');
DEFINE('_UE_CBE_GEOCODER_E_QSTATUSRDB','aus Profil');
DEFINE('_UE_CBE_GEOCODER_E_UNCHANCHED','Adresse unver�ndert');
DEFINE('_UE_CBE_GEOCODER_E_ASNOTDONE','GeoCoding unvollst�ndig');
DEFINE('_UE_CBE_GEOCODER_E_ASNOSUCCESS','GeoCoding: Adresse nicht aufl�sbar');
DEFINE('_UE_CBE_GEOCODER_E_ACC_ADDR','auf Adresse');
DEFINE('_UE_CBE_GEOCODER_E_ACC_STREET','auf Stra�e');
DEFINE('_UE_CBE_GEOCODER_E_ACC_ZIPPLZ','auf PLZ Bereich');
DEFINE('_UE_CBE_GEOCODER_E_ACC_CITY','auf Stadtbereich');
DEFINE('_UE_CBE_GEOCODER_E_ACC_SUBREGION','auf Landbezirk');
DEFINE('_UE_CBE_GEOCODER_E_ACC_REGION','auf Region');
DEFINE('_UE_CBE_GEOCODER_E_ACC_COUNTRY','auf Land');
DEFINE('_UE_CBE_GEOCODER_F_DISTANCE','Entfernung');
DEFINE('_UE_CBE_GEOCODER_F_m','m');
DEFINE('_UE_CBE_GEOCODER_F_Km','Km');
DEFINE('_UE_CBE_GEOCODER_F_NODATA','n/a');
//
DEFINE('_UE_CBE_JS_SWITCH','JS Einbindung');
DEFINE('_UE_CBE_JS_SWITCH_DESC','Gibt an ob der CBE seine erweiterten Javascript per javascript Tag od. in den Code der Seite direkt einbinden soll.');
//
DEFINE('_UE_CBE_ADMODS_M','AdminModule Verwaltung');
DEFINE('_UE_CBE_ADMODS_M_EDIT','AdminModule bearbeiten');
DEFINE('_UE_CBE_ADMODS_M_ADD','AdminModule hinzuf�gen');
DEFINE('_UE_CBE_ADM_POSITION','Position');
DEFINE('_UE_CBE_ADM_PUBLISHED','Aktiviert');
DEFINE('_UE_CBE_ADM_MODULE','Modul-Name');
DEFINE('_UE_CBE_ADM_MODULE_DESC','Die Angabe des Namens muss ohne das Prefix cbe_ und ohne den Postfix .php erfolgen.');
DEFINE('_UE_CBE_ADM_PLUGIN_NAME','Plugin-Datei');
DEFINE('_UE_CBE_ADM_PLUGIN_NAME_DESC','Die Angabe der einzubindenden Datei muss ohne den Postfix .php erfolgen.');
DEFINE('_UE_CBE_ADM_PLUGIN_FUNC','Funktionsaufrufe');
DEFINE('_UE_CBE_ADM_PLUGIN_FUNC_DESC','Die Funktionsaufrufe m�ssen in korrekter Schreibweise, ohne (), und durch Komma getrennt angegebene werden.');
DEFINE('_UE_CBE_ADM_DOUBLET_ERROR','Diese Parameter werden schon verwendet!');
//
DEFINE('_UE_CB_ENHANCED','CB Enhanced by');
?>