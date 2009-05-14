<?php
/*************************************************************
* Mambo Community Builder
* Author MamboJoe
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*************************************************************/

/**************************************************************
* German Translation (informell) germani.php
* Benjamin Zweifel, as of 26 Apr 2005
**************************************************************/

defined( '_JEXEC' ) or die( 'Direkter Zugriff auf diese Seite nicht gestattet.' );

//Field Labels
DEFINE('_UE_HITS','Hits');
DEFINE('_UE_USERNAME','Benutzername');
DEFINE('_UE_Address','Adresse');
DEFINE('_UE_City','Stadt');
DEFINE('_UE_State','Region');
DEFINE('_UE_PHONE','Telefon');
DEFINE('_UE_FAX','Fax');
DEFINE('_UE_ZipCode','PLZ');
DEFINE('_UE_Country','Land');
DEFINE('_UE_Occupation','Beruf');
DEFINE('_UE_Company','Firma');
DEFINE('_UE_Interests','Interessen');
DEFINE('_UE_Birthday','Geburtsdatum');
DEFINE('_UE_AVATAR','Bild');
DEFINE('_UE_Website','Website');
DEFINE('_UE_Location','Ort');
DEFINE('_UE_EDIT_TITLE','Deine Angaben ändern');
DEFINE('_UE_YOUR_NAME','Dein Name');
DEFINE('_UE_EMAIL','E-Mail-Adresse');
DEFINE('_UE_UNAME','Benutzername');
DEFINE('_UE_PASS','Passwort');
DEFINE('_UE_VPASS','Passwort bestätigen');
DEFINE('_UE_SUBMIT_SUCCESS','Eingabe erfolgreich!');
DEFINE('_UE_SUBMIT_SUCCESS_DESC','Deine Eingabe wurde an den Administrator weitergeleitet. Sie wird vor der Freischaltung überprüft.');
DEFINE('_UE_WELCOME','Willkommen!');
DEFINE('_UE_WELCOME_DESC','Willkommen im geschlossenen Bereich unseres Sites.');
DEFINE('_UE_CONF_CHECKED_IN','Alle zur Bearbeitung geöffneten Objekte wurden jetzt geschlossen.');
DEFINE('_UE_CHECK_TABLE','&Uuml;bermittlungstabelle');
DEFINE('_UE_CHECKED_IN','&Uuml;bermittelt ');
DEFINE('_UE_CHECKED_IN_ITEMS',' Objekt(e)');
DEFINE('_UE_PASS_MATCH','Passwörter nicht identisch.');
DEFINE('_UE_USERNAME_DESC','Auf &quot;Ja&quot; setzen, um das Ändern des Benutzernamens zu erlauben. Bei &quot;Nein&quot; kann der Benutzername nach der Registrierung nicht mehr geändert werden.');
DEFINE('_UE_ALLOW_EMAIL_USERCONTR','E-Mail-Adresse des Benutzers verbergen');
DEFINE('_UE_ALLOW_EMAIL_USERCONTR_DESC','"Ja" gestattet den Benutzern, ihre E-Mail-Adresse zu verbergen. ANMERKUNG: Diese Einstellung betrifft nur die Darstellung der E-Mail-Adresse im Rahmen dieser Komponente!');
DEFINE('_UE_USERAPPROVAL_SUCCESSFUL','Benutzer freigeschaltet!');
DEFINE('_UE_ICQ','ICQ Nummer'); //old
DEFINE('_UE_AIM','AIM Nick'); //old
DEFINE('_UE_YIM','YIM Nick'); //old
DEFINE('_UE_MSNM','MSNM Nick'); //old
DEFINE('_UE_RTE','WYSIWYG Editor aktivieren'); //old
DEFINE('_UE_RTE_DESC','Auf &quot;Ja&quot; setzen, um den WYSIWYG Editor für die Benutzerbiografie zu aktivieren. Bei &quot;Nein&quot; wird das normale Textfeld verwendet.'); //old

//Front End Profile Lables
DEFINE('_UE_MEMBERSINCE','Mitglied seit');
DEFINE('_UE_LASTONLINE','Zuletzt online');
DEFINE('_UE_ONLINESTATUS','Online-Status');
DEFINE('_UE_ISONLINE','ONLINE');
DEFINE('_UE_ISOFFLINE','OFFLINE');
DEFINE('_UE_PROFILE_TITLE',' Benutzerprofil');
DEFINE('_UE_UPDATEPROFILE','Profil ändern');
DEFINE('_UE_UPDATEAVATAR','Bild ändern');
DEFINE('_UE_CONTACT_INFO_HEADER','Kontaktinfo');
DEFINE('_UE_ADDITIONAL_INFO_HEADER','Mehr Info');
DEFINE('_UE_REQUIRED_ERROR','Dieses Feld ist ein Pflichtfeld!');
DEFINE('_UE_FIELD_REQUIRED',' Pflichtfeld!');
DEFINE('_UE_DELETE_AVATAR',' Bild löschen');
DEFINE('_UE_MALE','Mann'); //old
DEFINE('_UE_FEMALE','Frau'); //old

//Administrator Tab Names
DEFINE('_UE_USERPROFILE','Benutzerprofil');
DEFINE('_UE_USERLIST','Benutzerliste');
DEFINE('_UE_AVATARS','Bilder');
DEFINE('_UE_REGISTRATION','Registrierung');
DEFINE('_UE_SUBSCRIPTION','Abo');
DEFINE('_UE_INTEGRATION','Integrierung');

//Administrator Integration Tab
DEFINE('_UE_PMS','myPMS2 Private Nachrichten');
DEFINE('_UE_PMS_DESC','Auf &quot;Nein&quot; setzen, falls du myPMS2 für Private Nachrichten nicht installiert hast. Andernfalls wähle die entsprechende Version, um myPMS2 zu integrieren.');


//Administrator Labels
DEFINE('_UE_FIELD_NAME','Feldname');
DEFINE('_UE_EXPLANATION','Erklärung');
DEFINE('_UE_FIELD_EXPLAINATION','Soll dieses Feld ein Pflichtfeld sein und dem Benutzer angezeigt werden?');
DEFINE('_UE_CONFIG','Konfiguration');
DEFINE('_UE_CONFIG_DESC','Konfiguration ändern');
DEFINE('_UE_VERSION','Deine Version ist ');
DEFINE('_UE_BY','Eine Mambo 4.5 Zusatzkomponente von');
DEFINE('_UE_CURRENT_SETTINGS','Aktuelle Einstellung');
DEFINE('_UE_A_EXPLANATION','Erklärung');
DEFINE('_UE_DISPLAY','Anzeigen?');
DEFINE('_UE_REQUIRED','Pflichtfeld?');
DEFINE('_UE_YES','Ja');
DEFINE('_UE_NO','Nein');

//Admin Avatar Tab Labels
DEFINE('_UE_AVATAR_DESC','Auf &quot;Ja&quot; setzen, um registrierten Benutzern das Hochladen eines Bilders zu gestatten. (Im Benutzerprofil zu verwalten.)');
DEFINE('_UE_AVHEIGHT','Max. Bildhöhe');
DEFINE('_UE_AVWIDTH','Max. Bildbreite');
DEFINE('_UE_AVSIZE','Max. Dateigröße des Bildes<br/><em>in Kilobyte</em>');
DEFINE('_UE_AVATARUPLOAD','Hochladen von Bildern erlauben');
DEFINE('_UE_AVATARUPLOAD_DESC','Auf &quot;Ja&quot; setzen, um Benutzern das Hochladen eines Bildes zu gestatten.');
DEFINE('_UE_AVATARIMAGERESIZE','Bildgröße automatisch ändern'); //old
DEFINE('_UE_AVATARIMAGERESIZE_DESC','Automatische Bildgrößenänderung erfordert die GD Library.  GD2 installiert:'); //old
DEFINE('_UE_AVATARGALLERY','Bildgalerie verwenden');
DEFINE('_UE_AVATARGALLERY_DESC','Auf &quot;Ja&quot; setzen, damit registrierte Benutzer ein Bild aus der Galerie wählen können.');
DEFINE('_UE_TNWIDTH','Max. Breite des Vorschaubildes');
DEFINE('_UE_TNHEIGHT','Max. Höhe des Vorschaubildes');

//Admin User List Tab Labels
DEFINE('_UE_USERLIST_TITLE','Titel der Benutzerliste');
DEFINE('_UE_USERLIST_TITLE_DESC','Titel der Benutzerliste');
DEFINE('_UE_LISTVIEW','Liste');
DEFINE('_UE_PICTLIST','Bildliste');
DEFINE('_UE_PICTDETAIL','Bilddetail');
DEFINE('_UE_NUM_PER_PAGE','Benutzer pro Seite');
DEFINE('_UE_NUM_PER_PAGE_DESC','Zahl der Benutzer pro Seite');
DEFINE('_UE_VIEW_TYPE','Art der Darstellung');
DEFINE('_UE_VIEW_TYPE_DESC','Art der Darstellung');
DEFINE('_UE_ALLOW_EMAIL','E-Mail-Links');
DEFINE('_UE_ALLOW_EMAIL_DESC','E-Mail-Links gestatten. ANMERKUNG: Diese Einstellung gilt nur für Felder vom Typ E-Mail');
DEFINE('_UE_ALLOW_WEBSITE','Weblinks');
DEFINE('_UE_ALLOW_WEBSITE_DESC','Weblinks gestatten');
DEFINE('_UE_ALLOW_IM','Instant-Messenger-Links');
DEFINE('_UE_ALLOW_IM_DESC','Instant-Messenger-Links gestatten');
DEFINE('_UE_ALLOW_ONLINESTATUS','Online-Status');
DEFINE('_UE_ALLOW_ONLINESTATUS_DESC','Online-Status zeigen');
DEFINE('_UE_ALLOW_EMAIL_DISPLAY_DESC','ANMERKUNG: Diese Einstellung gilt nur für die erste E-Mail-Adresse des Benutzers');

//Admin Moderate Tab labels
DEFINE('_UE_MODERATE','Moderation');
DEFINE('_UE_AVATARUPLOADAPPROVALGROUP','Moderatorgruppen');
DEFINE('_UE_AVATARUPLOADAPPROVALGROUP_DESC','Alle Benutzer in der gewählten Gruppe und darüber sind Moderatoren.');
DEFINE('_UE_ALLOWUSERREPORTS','Benutzerbeschwerden gestatten');
DEFINE ('_UE_ALLOWUSERREPORTS_DESC','Gestatte Benutzern, sich über das Verhalten anderer zu beschweren.');
DEFINE ('_UE_AVATARUPLOADAPPROVAL','Bilderfreischaltung erforderlich');
DEFINE ('_UE_AVATARUPLOADAPPROVAL_DESC','Alle hochgeladenen Bilder benötigen eine Freischaltung, bevor sie angezeigt werden.');
DEFINE ('_UE_ALLOWUSERPROFILEBANNING_DESC','Ermöglicht Benutzern, die Anzeige eines Benutzerprofils zu sperren.');
DEFINE ('_UE_ALLOWUSERPROFILEBANNING','Benutzerprofilsperren ermöglichen');

//Admin Registration tab labels
DEFINE('_UE_NAME_FORMAT','Format Name');
DEFINE('_UE_DATE_FORMAT','Format Datum');
DEFINE('_UE_NAME_FORMAT_DESC','Wähle das Format, in dem Name/Benutzername angezeigt werden sollen.');
DEFINE('_UE_DATE_FORMAT_DESC','Wähle das Format, in dem das Datum angezeigt werden soll.');
DEFINE ('_UE_REG_CONFIRMATION_DESC','Auf "Ja" setzen, um den Benutzern nach der Registrierung eine E-Mail mit Bestätigungslink zu senden');
DEFINE ('_UE_REG_CONFIRMATION','E-Mail-Bestätigung erforderlich');
DEFINE ('_UE_REG_ADMIN_APPROVAL','Freischaltung durch den Administrator erforderlich');
DEFINE ('_UE_REG_ADMIN_APPROVAL_DESC','Alle Registrierungen müssen von einem Administrator freigeschaltet werden.');
DEFINE ('_UE_REG_EMAIL_NAME','Registrierung E-Mail-Absendername');
DEFINE ('_UE_REG_EMAIL_NAME_DESC','Name, unter dem deine E-Mails versendet werden');
DEFINE ('_UE_REG_EMAIL_FROM','Registrierung E-Mail-Adresse');
DEFINE ('_UE_REG_EMAIL_FROM_DESC','E-Mail-Adresse, mit der deine E-Mails versendet werden');
DEFINE ('_UE_REG_EMAIL_REPLYTO','Registrierung Antwortadresse');
DEFINE ('_UE_REG_EMAIL_REPLYTO_DESC','E-Mail-Adresse, die als Antwortadresse (reply-to) in deinen E-Mails aufscheint');
DEFINE ('_UE_REG_PEND_APPR_MSG','E-Mail "Ausstehende Freischaltung"');
DEFINE ('_UE_REG_WELCOME_MSG','E-Mail "Willkommen"');
DEFINE ('_UE_REG_REJECT_MSG','E-Mail "Ablehnung"');
DEFINE ('_UE_REG_PEND_APPR_SUB','Betreff in der E-Mail "Ausstehende Freischaltung"');
DEFINE ('_UE_REG_WELCOME_SUB','Betreff in der E-Mail "Willkommen"');
DEFINE ('_UE_REG_PEND_APPR_SUB_DESC','Betreff in der E-Mail "Ausstehende Freischaltung"');
DEFINE ('_UE_REG_WELCOME_SUB_DESC','Betreff in der E-Mail "Willkommen"');
DEFINE ('_UE_REG_REJECT_SUB_DESC','Betreff in der E-Mail "Ablehnung"');
DEFINE ('_UE_REG_SIGNATURE','E-Mail-Signatur');
DEFINE ('_UE_REG_ADMIN_PA_SUB','AKTION NÖTIG! Neue Registrierungen warten auf Freischaltung');
DEFINE ('_UE_REG_ADMIN_PA_MSG','Ein neuer Benutzer hat sich auf [SITEURL] angemeldet und wartet auf Freischaltung.\n'
.'Diese E-Mail enthält die Anmeldedaten\n\n'
.'Name - [NAME]\n'
.'E-Mail - [EMAILADDRESS]\n'
.'Benutzername - [USERNAME]\n\n\n'
.'Diese Nachricht wurde automatisch generiert und dient nur zur Information. Bitte nicht darauf antworten\n');
DEFINE ('_UE_REG_ADMIN_SUB','Registrierung eines neuen Benutzers');
DEFINE ('_UE_REG_ADMIN_MSG','Ein neuer Benutzer hat sich auf [SITEURL] angemeldet.\n'
.'Diese E-Mail enthält die Anmeldedaten\n\n'
.'Name - [NAME]\n'
.'E-Mail - [EMAILADDRESS]\n'
.'Benutzername - [USERNAME]\n\n\n'
.'Diese Nachricht wurde automatisch generiert und dient nur zur Information. Bitte nicht darauf antworten\n');
DEFINE('_UE_REG_EMAIL_TAGS','[NAME] - Name des Benutzers<br />'
.'[USERNAME] - Benutzername<br />'
.'[DETAILS] - Details im Benutzerkonto (wie E-Mail-Adresse, Benutzername, Passwort)<br />'
.'[CONFIRM] - fügt einen Bestätigungslink in die E-Mail an, falls diese Funktion aktiviert ist<br />');

//Registration form
DEFINE('_UE_REG_COMPLETE_NOPASS','<span class="componentheading">Registrierung abgeschlossen!</span><br />&nbsp;&nbsp;'
.'Das Passwort wurde an die angegebene E-Mail-Adresse gesendet.<br />&nbsp;&nbsp;'
.'Sobald du es erhalten hast, kannst du dich anmelden.');
DEFINE('_UE_REG_COMPLETE','<span class="componentheading">Registrierung abgeschlossen!</span><br />&nbsp;&nbsp;'
.'Du kannst dich jetzt anmelden.<br />&nbsp;&nbsp;');
DEFINE('_UE_REG_COMPLETE_NOPASS_NOAPPR','<span class="componentheading">Registrierung abgeschlossen!</span><br />&nbsp;&nbsp;'
.'Deine Registrierung muss erst überprüft und freigeschaltet werden.<br />&nbsp;&nbsp;'
.'Bei Freischaltung erhältst du ein Passwort per E-Mail und kannst dich dann anmelden.');
DEFINE('_UE_REG_COMPLETE_NOAPPR','<span class="componentheading">Registrierung abgeschlossen!</span><br />&nbsp;&nbsp;'
.'Deine Registrierung muss erst überprüft und freigeschaltet werden. <br />&nbsp;&nbsp;'
.'Bei Freischaltung erhältst du eine E-Mail und kannst dich dann anmelden.');
DEFINE('_UE_REG_COMPLETE_CONF','<span class="componentheading">Registrierung abgeschlossen!</span><br />&nbsp;&nbsp;'
.'Eine E-Mail mit weiteren Informationen wurde an die angegebene Adresse geschickt. Bitte folge den Anweisungen in dieser Mail, um die Registrierung abzuschließen.<br />&nbsp;&nbsp;');
DEFINE('_UE_REG_COMPLETE_NOPASS_CONF','<span class="componentheading">Registrierung abgeschlossen!</span><br />&nbsp;&nbsp;'
.'Dein Passwort wurde an die angegebene E-Mail-Adresse gesendet.<br />&nbsp;&nbsp;'
.'Wenn du das Passwort erhalten hast, folge den Anweisungen in der E-Mail, um dich anmelden zu können.');

// User List Labels
DEFINE ('_UE_HAS','hat');
DEFINE ('_UE_USERS','Benutzer');
DEFINE ('_UE_SEARCH_ALERT','Bitte Suchbegriff eingeben!');
DEFINE ('_UE_SEARCH','Benutzer finden');
DEFINE ('_UE_ENTER_EMAIL','Gib E-Mail-Adresse, Namen oder Benutzernamen des Benutzers an!');
DEFINE ('_UE_SEARCH_BUTTON','Suchen');
DEFINE ('_UE_SHOW_ALL','Alle Benutzer zeigen');
DEFINE ('_UE_NAME','Name');
DEFINE ('_UE_UL_USERNAME','Benutzername');
DEFINE ('_UE_USERTYPE','Benutzertyp');
DEFINE ('_UE_VIEWPROFILE','Benutzerprofil ansehen');
DEFINE ('_UE_LIST_ALL','Alle anzeigen');
DEFINE ('_UE_PAGE','Seite');
DEFINE ('_UE_RESULTS','Treffer');
DEFINE ('_UE_OF_TOTAL','von insgesamt');
DEFINE ('_UE_NO_RESULTS','Keine Treffer');
DEFINE ('_UE_FIRST_PAGE','Erste Seite');
DEFINE ('_UE_PREV_PAGE','Vorherige Seite');
DEFINE ('_UE_NEXT_PAGE','Nächste Seite');
DEFINE ('_UE_END_PAGE','Letzte Seite');
DEFINE('_UE_CONTACT','Kontakt');
DEFINE('_UE_INSTANT_MESSAGE','Instant Message');
DEFINE('_UE_IMAGEAVAILABLE','Foto');
DEFINE('_UE_INFO','Info');
DEFINE('_UE_PROFILE','Benutzerprofil');
DEFINE('_UE_PRIVATE_MESSAGE','Private Message');
DEFINE('_UE_ADDITIONAL','Mehr Info');
DEFINE('_UE_NO_DATA','Keine Angabe');
DEFINE('_UE_CLICKTOVIEW','Klicke für');
DEFINE('_UE_UL_USERNAME_NAME','Benutzername(Name)');
DEFINE('_UE_PM','Private Nachricht');
DEFINE('UE_PM_USER','Private Nachricht senden');

//mod_userextraslogin
DEFINE('_UE_NO_ACCOUNT','Noch nicht dabei?');
DEFINE('_UE_CREATE_ACCOUNT','Benutzer neu anmelden');
DEFINE('_LOGIN_NOT_CONFIRMED','Registrierung nicht vollständig! Weitere Hinweise findest du in deinem E-Mail-Posteingang.');
DEFINE('_LOGIN_NOT_APPROVED','Deine Anmeldung wurde noch nicht freigeschaltet.');
DEFINE('_UE_USER_CONFIRMED','Deine Anmeldung ist freigeschaltet. Du kannst dich jetzt anmelden!');
DEFINE('_UE_USER_NOTCONFIRMED','Deine Anmeldung ist noch nicht freigeschaltet. Weitere Hinweise findest du in deinem E-Mail-Posteingang.');


//Avatar
DEFINE('_UE_UPLOAD_UPLOAD','Hochladen');
DEFINE('_UE_UPLOAD_DIMENSIONS','Maximale Bildgröße (Breite x Höhe - Dateigröße)');
DEFINE('_UE_UPLOAD_SUBMIT','Neues Bild auswählen');
DEFINE('_UE_UPLOAD_SELECT_FILE','Datei auswählen');
DEFINE('_UE_UPLOAD_ERROR_TYPE','Es werden nur .jpg, .png und .gif Dateien akzeptiert.');
DEFINE('_UE_UPLOAD_ERROR_EMPTY','Vor dem Hochladen bitte eine Datei auswählen!');
DEFINE('_UE_UPLOAD_ERROR_NAME','Der Dateiname darf nur alphanumerische Zeichen und keine Leerzeichen beinhalten.');
DEFINE('_UE_UPLOAD_ERROR_SIZE','Die Dateigröße des Bildes überschreitet den erlaubten Höchstwert.');
DEFINE('_UE_UPLOAD_ERROR_WIDTHHEIGHT','Bildbreite oder -höhe überschreiten den erlaubten Höchstwert.');
DEFINE('_UE_UPLOAD_ERROR_WIDTH','Das Bild ist zu breit.');
DEFINE('_UE_UPLOAD_ERROR_HEIGHT','Das Bild ist zu hoch.');
DEFINE('_UE_UPLOAD_ERROR_CHOOSE', 'Kein Bild aus der Galerie ausgewählt.');
DEFINE('_UE_UPLOAD_UPLOADED','Das Bild wurde hochgeladen.');
DEFINE('_UE_UPLOAD_GALLERY','Wähle ein Bild aus der Galerie');
DEFINE('_UE_UPLOAD_CHOOSE','Auswahl bestätigen.');
DEFINE('_UE_UPLOAD_UPDATED','Das Bild wurde aktualisiert.');
DEFINE('_UE_USER_PROFILE_NOT','Dein Benutzerprofil konnte nicht aktualisiert werden.');
DEFINE('_UE_USER_PROFILE_UPDATED','Benutzerprofil aktualisiert.');
DEFINE('_UE_USER_RETURN_A','Wenn du nicht in wenigen Augenblicken zu deinem Benutzerprofil weitergeleitet wirst, ');
DEFINE('_UE_USER_RETURN_B','klicke hier.');
DEFINE('_UPDATE','UPDATE'); //old?

//Moderator
DEFINE('_UE_USERPROFILEBANNED','Benutzerprofil von Moderator gesperrt.');
DEFINE('_UE_REQUESTUNBANPROFILE','Entsperrung beantragen');
DEFINE('_UE_REPORTUSER','Beschwerde über Benutzer abgeben');
DEFINE('_UE_BANPROFILE','Benutzerprofil sperren');
DEFINE('_UE_UNBANPROFILE','Benutzerprofil entsperren');
DEFINE('_UE_REPORTUSER_TITLE','Benutzerbeschwerde');
DEFINE('_UE_USERREASON','Warum beschwerst du dich über diesen Benutzer?');
DEFINE('_UE_BANREASON','Grund der Benutzerprofilsperre');
DEFINE('_UE_SUBMITFORM','Abschicken');
DEFINE('_UE_NOUNBANREQUESTS','Es liegen keine Entsperrungsanträge vor.');
// DEFINE('_UE_BANREASON','Grund der Sperre'); //old
DEFINE('_UE_IMAGE_MODERATE','Bild freischalten');
DEFINE('_UE_APPROVE_IMAGES','Freischalten');
DEFINE('_UE_REJECT_IMAGES','Ablehnen');
DEFINE('_UE_MODERATE_TITLE','Moderator');
DEFINE('_UE_NOIMAGESTOAPPROVE','Keine Bilder zum Freischalten');
DEFINE('_UE_USERREPORT_MODERATE','Benutzerbeschwerden bearbeiten');
DEFINE('_UE_REPORTEDUSER','Beschwerde über Benutzer');
DEFINE('_UE_REPORT','Beschwerde');
DEFINE('_UE_REPORTEDONDATE','Datum der Beschwerde');
DEFINE('_UE_REPORTEDBY','Beschwerde stammt von');
DEFINE('_UE_PROCESSUSERREPORT','IN BEARBEITUNG');
DEFINE('_UE_NONEWUSERREPORTS','Es liegen keine Benutzerbeschwerden vor.');
DEFINE('_UE_USERUNBAN_SUCCESSFUL','Benutzerprofil erfolgreich entsperrt.');
DEFINE('_UE_REPORTUSERSACTIVITY','Beschreibe die Aktivitäten des Benutzers');
DEFINE('_UE_USERREPORT_SUCCESSFUL','Benutzerbeschwerde erfolgreich abgeschickt.');
DEFINE('_UE_USERBAN_SUCCESSFUL','Sperre des Benutzerprofils erfolgreich.');
DEFINE('_UE_FUNCTIONALITY_DISABLED','Diese Funktion ist derzeit deaktiviert.');
DEFINE('_UE_UPLOAD_PEND_APPROVAL','Dein Bild muss noch freigeschaltet werden.');
DEFINE('_UE_UPLOAD_SUCCESSFUL','Bild erfolgreich hochgeladen!');
DEFINE('_UE_UNBANREQUEST','Entsperrung beantragen');
DEFINE('_UE_USERUNBANREQUEST_SUCCESSFUL','Dein Benutzerprofil-Entsperrungsantrag ist erfolgreich übermittelt worden.');
DEFINE('_UE_USERREPORT','Benutzerbeschwerde');
DEFINE('_UE_VIEWUSERREPORTS','Benutzerbeschwerden ansehen');
DEFINE('_UE_USERREQUESTRESPONSE','Benutzerbeschwerden ansehen');
DEFINE('_UE_MODERATORREQUESTRESPONSE','Benutzerbeschwerden ansehen');
DEFINE('_UE_REPORTBAN_TITLE','Sperrbericht');
DEFINE('_UE_REPORTUNBAN_TITLE','Sperrbericht');

DEFINE('_UE_UNBANREQUIREACTION',' Entsperrungsantrag/anträge');
DEFINE('_UE_USERREPORTSREQUIREACTION','Benutzerbeschwerde(n)');
DEFINE('_UE_IMAGESREQUIREACTION','Bild(er)');
DEFINE('_UE_NOACTIONREQUIRED','Keine Aktionen nötig.');

DEFINE('_UE_UNBAN_MODERATE','Entsperrungsanträge');
DEFINE('_UE_BANNEDUSER','Gesperrter Benutzer');
DEFINE('_UE_BANNEDREASON','Grund der Sperre');
DEFINE('_UE_BANNEDON','Datum der Sperre');
DEFINE('_UE_BANNEDBY','Gesperrt von');

DEFINE('_UE_MODERATORBANRESPONSE','Antwort des Moderators');
DEFINE('_UE_USERBANRESPONSE','Antwort des Benutzers');

DEFINE('_UE_IMAGE_ADMIN_SUB','Bildfreischaltung wartet');
DEFINE('_UE_IMAGE_ADMIN_MSG','Das Bild von [USERNAME] wartet auf Freischaltung.
Bitte einloggen und freischalten!');
DEFINE('_UE_USERREPORT_SUB','Benutzerbeschwerde eingetroffen');
DEFINE('_UE_USERREPORT_MSG','Eine Benutzerbeschwerde ist eingetroffen. Bitte einloggen und bearbeiten.');
DEFINE('_UE_IMAGEAPPROVED_SUB','Bild akzeptiert.');
DEFINE('_UE_IMAGEAPPROVED_MSG','Dein Bild wurde vom Moderator freigeschaltet.');
DEFINE('_UE_IMAGEREJECTED_SUB','Bild abgelehnt.');
DEFINE('_UE_IMAGEREJECTED_MSG','Dein Bild wurde vom Moderator abgelehnt. Bitte melde dich an und lade ein neues hoch.');
DEFINE('_UE_BANUSER_SUB','Benutzerprofil gesperrt');
DEFINE('_UE_BANUSER_MSG','Dein Benutzerprofil wurde von einem Administrator gesperrt. Bitte melde dich an, um den Grund für die Sperre zu erfahren.');
DEFINE('_UE_UNBANUSER_SUB','Benutzerprofil entsperrt');
DEFINE('_UE_UNBANUSER_MSG','Die Sperre deines Benutzerprofils wurde aufgehoben. Es ist jetzt wieder für alle Benutzer sichtbar.');
DEFINE('_UE_UNBANUSERREQUEST_SUB','Entsperrungantrag liegt vor');
DEFINE('_UE_UNBANUSERREQUEST_MSG','Ein Benutzer hat einen Entsperrungsantrag gestellt. Bitte einloggen und bearbeiten!');


//Alpha 3 Build
DEFINE('_UE_IMAGE','Vorschaubild');
DEFINE('_UE_FORMATNAME','Formatierter Name');

//Alpha 4 Build
DEFINE('_UE_ADMINREQUIREDFIELDS','Pflichtfelder in der Benutzerverwaltung');
DEFINE('_UE_ADMINREQUIREDFIELDS_DESC','Auf &quot;Ja&quot; sind Pflichtfelder auch in der Benutzerverwaltung verpflichtend. Bei &quot;Nein&quot; kann der Administrator Pflichtfelder frei lassen.');
DEFINE('_UE_CANCEL','Abbrechen');
DEFINE('_UE_NA','nicht verfügbar');
DEFINE('_UE_MODERATOREMAIL','E-Mails an Moderatoren senden');
DEFINE('_UE_MODERATOREMAIL_DESC','Bei &quot;Ja&quot; erhalten die Moderator eine E-Mail, wenn ihr Handeln erforderlich ist (Freischaltungen, usw.).');

//Beta 1 Build
DEFINE('_UE_UPDATE','Aktualisieren');

//Beta 2 Build
DEFINE('_UE_FIELDONPROFILE','Dieses Feld wird im Profil angezeigt.');
DEFINE('_UE_FIELDNOPROFILE','Dieses Feld wird NICHT im Profil angezeigt.');
DEFINE('_UE_FIELDREQUIRED','Pflichtfeld');
DEFINE('_UE_NOT_AUTHORIZED','Du hast keinen Zugriff auf diese Seite!');
DEFINE('_UE_ALLOW_LISTVIEWBY','Zugriff gewähren für:');
DEFINE('_UE_ALLOW_LISTVIEWBY_DESC','Wähle die Gruppe, die die Liste sehen darf. Diese Gruppe und alle höheren haben Zugriff.');
DEFINE('_UE_ALLOW_PROFILEVIEWBY','Zugriff gewähren für:');
DEFINE('_UE_ALLOW_PROFILEVIEWBY_DESC','Wähle die Gruppe, die die Liste sehen darf. Diese Gruppe und alle höheren haben Zugriff.');

//Beta 3 Build
DEFINE('_UE_NOLISTFOUND','Es gibt keine veröffentlichten Benutzerlisten!');
DEFINE('_UE_ALLOW_PROFILELINK','Link zu Benutzerprofil erlauben');
DEFINE('_UE_ALLOW_PROFILELINK_DESC','Auf &quot;Ja&quot; setzen, um in jede Zeile einen Link zum Benutzerprofil einzufügen. Bei &quot;Nein&quot; wird kein solcher Link eingefügt.');
DEFINE('_UE_REGISTERFORPROFILE','Bitte melde dich an, um das Benutzerprofil anzusehen oder zu verändern.');
DEFINE('_UE_UPLOAD_ERROR_GDNOTINSTALLED','Die GD2 Library ist nicht installiert oder nicht mit PHP kompiliert. Bitte wende dich an den Systemadministrator, um die automatische Bildgrößenänderung zu deaktivieren.');
DEFINE('_UE_UPLOAD_ERROR_UPLOADFAILED','Fehler beim Hochladen des Bildes!');
DEFINE('_UE_TOC','Nutzungsbedingungen akzeptieren');
DEFINE('_UE_TOC_REQUIRED','Zur Registrierung musst du die Nutzungsbedingungen akzeptieren');
DEFINE('_UE_REG_TOC_MSG','Nutzungsbedingungen aktivieren');
DEFINE('_UE_REG_TOC_DESC','Auf &quot;Ja&quot; setzen, falls Benutzer vor der Registrierung die Nutzungsbedingungen akzeptieren müssen!');
DEFINE('_UE_REG_TOC_URL_MSG','Link zu den Nutzungsbedingungen');
DEFINE('_UE_REG_TOC_URL_DESC','Link zu den Nutzungsbedingungen angeben.');
DEFINE('_UE_LASTUPDATEDON','Letzte Aktualisierung');

//Beta 4 Build
DEFINE('_UE_EMAILFORMWARNING','ACHTUNG: Falls du weitermachst, kann der Benutzer deine E-Mail-Adresse in der E-Mail sehen.');
DEFINE('_UE_EMAILFORMSUBJECT','Betreff:');
DEFINE('_UE_EMAILFORMMESSAGE','Nachricht:');
DEFINE('_UE_EMAILFORMINSTRUCT','E-Mail senden an <a href="index.php?option=com_cbe&task=UserDetails&user=%s">%s </a>.');
DEFINE('_UE_GENERAL','Allgemein');
DEFINE('_UE_SENDEMAILNOTICE','ANMERKUNG: Das ist eine Nachricht von %s bei %s ( %s ). Der Benutzer hat deine E-Mail-Adresse nicht gesehen. Falls du darauf antwortest, wird der Benutzer deine E-Mail-Adresse sehen können. %s ist für den Inhalt der E-Mail nicht verantwortlich.');
DEFINE('_UE_SENDEMAIL','E-Mail senden');
DEFINE('_UE_SENTEMAILSUCCESS','Deine E-Mail wurde erfolgreich versendet!');
DEFINE('_UE_SENTEMAILFAILED','E-Mail konnte nicht gesendet werden. Bitte noch einmal versuchen!');
DEFINE('_UE_ALLOW_EMAIL_DISPLAY','E-Mail-Darstellung');
DEFINE('_UE_REGISTERDATE','Datum der Registrierung');
DEFINE('_UE_ACTION','Aktion');
DEFINE('_UE_USER','Benutzer');
DEFINE('_UE_USERAPPROVAL_MODERATE','Benutzer akzeptieren/ablehnen');
DEFINE('_UE_USERPENDAPPRACTION',' Benutzer');
DEFINE('_UE_APPROVEUSER','Benutzer in Bearbeitung');
DEFINE('_UE_REG_REJECT_SUB','Deine Registrierung wurde abgelehnt!');
DEFINE('_UE_USERREJECT_MSG','Deine Registrierung für %s wurde abgelehnt. Grund: \n %s');
DEFINE('_UE_COMMENT','Grund der Ablehnung');
DEFINE('_UE_APPROVE','Freischalten');
DEFINE('_UE_REJECT','Ablehnen');
DEFINE('_UE_USERREJECT_SUCCESSFUL','Benutzer wurde abgelehnt!');
DEFINE('_UE_USERAPPROVE_SUCCESSFUL','Benutzer wurde freigeschaltet!');
DEFINE('_LOGIN_REJECTED','Deine Registrierung wurde abgelehnt!');
DEFINE('_UE_EMAILFOOTER','ANMERKUNG: Das ist eine automatisch generierte Nachricht von %s (%s).');
DEFINE('_UE_MODERATORUSERAPPOVAL','Moderatoren können Benutzer freischalten');
DEFINE('_UE_MODERATORUSERAPPOVAL_DESC','Diese Einstellung erlaubt Moderatoren, Benutzer im Frontend der Website freizuschalten.');
DEFINE('_UE_REG_COMPLETE_NOAPPR_CONF','<span class="componentheading">Registrierung abgeschlossen!</span><br />&nbsp;&nbsp;'
.'Deine Registrierung erfordert Freischaltung und E-Mail-Rückbestätigung. Bitte folge den Anweisungen in der E-Mail, die du erhalten hast. Nach der Freischaltung kannst du dich anmelden.<br />&nbsp;&nbsp;');
DEFINE('_UE_REG_COMPLETE_NOPASS_NOAPPR_CONF','<span class="componentheading">Registrierung abgeschlossen!</span><br />&nbsp;&nbsp;'
.'Deine Registrierung erfordert Freischaltung und E-Mail-Rückbestätigung. Bitte folge den Anweisungen in der E-Mail, die du erhalten hast.<br />&nbsp;&nbsp;'
.'Nach Freischaltung wird dir ein Passwort zugesendet, mit dem du dich einloggen kannst.');
DEFINE('_UE_NAME_STYLE','Name Felder');
DEFINE('_UE_NAME_STYLE_DESC','Hier kannst du angeben, wie viele Felder der Benutzername in Mambo umfassen soll.');
DEFINE('_UE_USER_CONFIRMED_NEEDAPPR','Danke für die Bestätigung deiner E-Mail-Adresse. Deine Registrierung muss jetzt noch von einem Moderator freigeschaltet werden. Du erhältst eine E-Mail, nachdem deine Anmeldung geprüft wurde.');
DEFINE('_UE_YOUR_FNAME','Vorname');   
DEFINE('_UE_YOUR_MNAME','Zweiter Vorname');
DEFINE('_UE_YOUR_LNAME','Nachname');

//RC 1 Build
DEFINE('_UE_NOSELFEMAIL','Du kannst keine E-Mail an dich selbst senden!');
DEFINE('_UE_PROFILETAB','Profil');
DEFINE('_UE_AUTHORTAB','Artikel');
DEFINE('_UE_FORUMTAB','Forum');
DEFINE('_UE_BLOGTAB','Blog');
DEFINE('_UE_ARTICLEDATE','Datum');
DEFINE('_UE_ARTICLETITLE','Titel');
DEFINE('_UE_ARTICLERATING','Bewertung');
DEFINE('_UE_ARTICLEHITS','Aufrufe');
DEFINE('_UE_FORUMDATE','Datum');
DEFINE('_UE_FORUMCATEGORY','Kategorie');
DEFINE('_UE_FORUMSUBJECT','Betreff');
DEFINE('_UE_FORUMHITS','Aufrufe');
DEFINE('_UE_FORUM_TOP10','Letzte 10 Forumeinträge');
DEFINE('_UE_FORUM_STATS','Forum-Statistik');
DEFINE('_RANK_MODERATOR','Moderator');
DEFINE('_RANK_ADMINISTRATOR','Administrator');
DEFINE('_UE_SBNOTINSTALLED','Die Simpleboard-Komponente ist nicht installiert. Bitte wende dich an den Administrator.');
DEFINE('_UE_NOFORUMPOSTS','Dieser Benutzer hat keine Forumeinträge verfasst.');
DEFINE('_UE_NESTTABS','Tabs verschachteln');
DEFINE('_UE_NESTTABS_DESC','Alle Tabs unter einem einzigen Profil-Tab anordnen. Das ist zu empfehlen, wenn es sehr viele Tabs gibt.');
DEFINE('_UE_TEMPLATEDIR','Tab-Vorlage');
DEFINE('_UE_TEMPLATEDIR_DESC','Wähle eine Vorlagedatei (template) für die im Community Builder verwendeten Tabs aus.');
DEFINE('_UE_MAMBLOGNOTINSTALLED','Die Mamblog-Komponente ist nicht installiert. Bitte wende dich an den Administrator.');
DEFINE('_UE_BLOGDATE','Datum');
DEFINE('_UE_BLOGTITLE','Titel');
DEFINE('_UE_BLOGHITS','Aufrufe');
DEFINE('_UE_NOBLOGS','Dieser Benutzer hat keine Blog-Einträge verfasst.');
DEFINE('_UE_NOARTICLES','Dieser Benutzer hat keine Artikel verfasst.');
DEFINE('_UE_IMPATH','Pfad zu ImageMagick');
DEFINE('_UE_IMPATH_DESC','Pfad zu ImageMagick');
DEFINE('_UE_NETPBMPATH','Pfad zu NetPBM');
DEFINE('_UE_NETPBMPATH_DESC','Pfad zu NetPBM');
DEFINE('_UE_AUTODET','Automatisch erkannt');
DEFINE('_UE_ERROR_NOTINSTALLED','Nicht installiert');
DEFINE('_UE_CONVERSIONTYPE','Art der Bildumwandlung');
DEFINE('_UE_NEWPASS_FAILED','Das Zurücksetzen des Passwortes ist gescheitert!');
DEFINE('_UE_USER_SUBSCRIPTIONS','Deine Abos');
DEFINE('_UE_THREAD_UNSUBSCRIBE',':: abbestellen ::');
DEFINE('_UE_USER_NOSUBSCRIPTIONS','Du hast keine Abos.');
DEFINE('_UE_GEN_BY','von');
DEFINE('_UE_USER_UNSUBSCRIBE_ALL','Alle abbestellen');
DEFINE('_UE_USERREPORTMODERATED_SUCCESSFUL','Benutzerbeschwerde erfolgreich bearbeitet!');
DEFINE('_UE_USERIMAGEMODERATED_SUCCESSFUL','Benutzerbildmoderation erfolgreich durchgeführt!');
DEFINE('_UE_NOREPORTSTOPROCESS','Es liegen keine Benutzerbeschwerden vor');
DEFINE('_UE_NOUSERSPENDING','Es liegen keine Registrierungsanträge vor');
DEFINE('_UE_BLANK','');
DEFINE('_UE_REG_FIRST_VISIT_URL_MSG','URL bei der ersten Anmeldung');
DEFINE('_UE_REG_FIRST_VISIT_URL_DESC','Gib die URL der Seite an, die der Benutzer nach seiner ersten Anmeldung nach der Registrierung zu sehen bekommen soll. Diese Seite kann zum Beispiel eine Willkommen-Seite für neue Mitglieder sein, wichtige Anleitungen enthalten oder die Profil-Seite des Benutzer sein. Wenn du dieses Feld frei lässt, wird der Benutzer auch bei der ersten Anmeldung normal weitergeleitet.');
DEFINE('_UE_NOSUCHPROFILE','Dieses Profil existiert nicht (mehr).');

//SB Integration Support
DEFINE('_UE_SB_TABTITLE','Forum Einstellungen');
DEFINE('_UE_SB_TABDESC','Das sind deine Forumseinstellungen');
DEFINE('_UE_SB_VIEWTYPE_TITLE','Bevorzugte Darstellung');
DEFINE('_UE_SB_VIEWTYPE_FLAT','als Liste');
DEFINE('_UE_SB_VIEWTYPE_THREADED','als Baum');
DEFINE('_UE_SB_ORDERING_TITLE','Bevorzugte Reihenfolge');
DEFINE('_UE_SB_ORDERING_OLDEST','Ältester Beitrag zuerst');
DEFINE('_UE_SB_ORDERING_LATEST','Jüngster Beitrag zuerst');
DEFINE('_UE_SB_SIGNATURE','Signatur');
//added for SB 1.5 during 1.0 RC 1
DEFINE('_UE_SB_POSTSPERPAGE','Einträge pro Seite'); 
DEFINE('_UE_SB_USERTIMEOFFSET','Lokale Zeitdifferenz zur Serverzeit');

//Not used within application but are needed to translate default images for profile.
DEFINE('_UE_IMG_NOIMG','Kein Bild');
DEFINE('_UE_IMG_PENDIMG','Bild noch nicht freigeschaltet');

DEFINE('_PROMPT_PASSWORD', 'Passwort vergessen');

// hinzugefuegt von www.joomla-cbe.de
DEFINE('_UE_REG_TITLE', 'Registrierung');
DEFINE('_UE_REG_UNAME', 'Benutzername:');
DEFINE('_UE_REG_EMAIL', 'E-Mail:');
DEFINE('_UE_REG_PASS', 'Passwort:');
DEFINE('_UE_REG_VPASS', 'Passwort bestätigen:');
DEFINE('_BUTTON_SEND_REG', 'Absenden');
DEFINE('_USER_DETAILS_SAVE', "Die Änderungen wurden gespeichert.");

DEFINE('_SEL_CATEGORY', 'Bitte Kategorie auswählen');
//DEFINE('_PROMPT_PASSWORD', 'Passwort vergessen');
DEFINE('_NEW_PASS_DESC', 'Neues Passwort erstellen');
DEFINE('_PROMPT_UNAME', 'Username');
DEFINE('_PROMPT_EMAIL', 'Email');
DEFINE('_BUTTON_SEND_PASS', 'Passwort schicken');
DEFINE('_ERROR_PASS', 'Falscher Username und/oder Emailadresse');

DEFINE('_LOGIN_INCORRECT', 'Benutzer und / oder Passwort falsch');
DEFINE('_VALID_AZ09', 'Das Format des Benutzers und / oder des Passworts ist falsch.');
DEFINE('_NEWPASS_SENT', 'Neues Passwort gesendet');


?>