<?php
/*************************************************************
* Mambo Community Builder
* Author MamboJoe
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*************************************************************/

/**************************************************************
* German Translation (formell) germanf.php
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
DEFINE('_UE_EDIT_TITLE','Ihre Angaben �ndern');
DEFINE('_UE_YOUR_NAME','Ihr Name');
DEFINE('_UE_EMAIL','E-Mail-Adresse');
DEFINE('_UE_UNAME','Benutzername');
DEFINE('_UE_PASS','Passwort');
DEFINE('_UE_VPASS','Passwort best�tigen');
DEFINE('_UE_SUBMIT_SUCCESS','Eingabe erfolgreich!');
DEFINE('_UE_SUBMIT_SUCCESS_DESC','Ihre Eingabe wurde an den Administrator weitergeleitet. Sie wird vor der Freischaltung �berpr�ft.');
DEFINE('_UE_WELCOME','Willkommen!');
DEFINE('_UE_WELCOME_DESC','Willkommen im geschlossenen Bereich unseres Sites.');
DEFINE('_UE_CONF_CHECKED_IN','Alle zur Bearbeitung ge�ffneten Objekte wurden jetzt geschlossen.');
DEFINE('_UE_CHECK_TABLE','�bermittlungstabelle');
DEFINE('_UE_CHECKED_IN','�bermittelt ');
DEFINE('_UE_CHECKED_IN_ITEMS',' Objekt(e)');
DEFINE('_UE_PASS_MATCH','Passw�rter nicht identisch.');
DEFINE('_UE_USERNAME_DESC','Auf &quot;Ja&quot; setzen, um das �ndern des Benutzernamens zu erlauben. Bei &quot;Nein&quot; kann der Benutzername nach der Registrierung nicht mehr ge�ndert werden.');
DEFINE('_UE_ALLOW_EMAIL_USERCONTR','E-Mail-Adresse des Benutzers verbergen');
DEFINE('_UE_ALLOW_EMAIL_USERCONTR_DESC','&quot;Ja&quot; gestattet den Benutzern, ihre E-Mail-Adresse zu verbergen. ANMERKUNG: Diese Einstellung betrifft nur die Darstellung der E-Mail-Adresse im Rahmen dieser Komponente!');
DEFINE('_UE_USERAPPROVAL_SUCCESSFUL','Benutzer freigeschaltet!');
DEFINE('_UE_ICQ','ICQ Nummer'); //old
DEFINE('_UE_AIM','AIM Nick'); //old
DEFINE('_UE_YIM','YIM Nick'); //old
DEFINE('_UE_MSNM','MSNM Nick'); //old
DEFINE('_UE_RTE','WYSIWYG Editor aktivieren'); //old
DEFINE('_UE_RTE_DESC','Auf &quot;Ja&quot; setzen, um den WYSIWYG Editor f�r die Benutzerbiografie zu aktivieren. Bei &quot;Nein&quot; wird das normale Textfeld verwendet.'); //old

//Front End Profile Lables
DEFINE('_UE_MEMBERSINCE','Mitglied seit');
DEFINE('_UE_LASTONLINE','Zuletzt online');
DEFINE('_UE_ONLINESTATUS','Online-Status');
DEFINE('_UE_ISONLINE','ONLINE');
DEFINE('_UE_ISOFFLINE','OFFLINE');
DEFINE('_UE_PROFILE_TITLE',' Benutzerprofil');
DEFINE('_UE_UPDATEPROFILE','Profil �ndern');
DEFINE('_UE_UPDATEAVATAR','Bild �ndern');
DEFINE('_UE_CONTACT_INFO_HEADER','Kontaktinfo');
DEFINE('_UE_ADDITIONAL_INFO_HEADER','Mehr Info');
DEFINE('_UE_REQUIRED_ERROR','Dieses Feld ist ein Pflichtfeld!');
DEFINE('_UE_FIELD_REQUIRED',' Pflichtfeld!');
DEFINE('_UE_DELETE_AVATAR',' Bild l�schen');
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
DEFINE('_UE_PMS_DESC','Auf &quot;Nein&quot; setzen, falls Sie myPMS2 f�r Private Nachrichten nicht installiert haben. Andernfalls w�hlen Sie die entsprechende Version, um myPMS2 zu integrieren.');


//Administrator Labels
DEFINE('_UE_FIELD_NAME','Feldname');
DEFINE('_UE_EXPLANATION','Erkl�rung');
DEFINE('_UE_FIELD_EXPLAINATION','Soll dieses Feld ein Pflichtfeld sein und dem Benutzer angezeigt werden?');
DEFINE('_UE_CONFIG','Konfiguration');
DEFINE('_UE_CONFIG_DESC','Konfiguration �ndern');
DEFINE('_UE_VERSION','Ihre Version ist ');
DEFINE('_UE_BY','Eine Mambo 4.5 Zusatzkomponente von');
DEFINE('_UE_CURRENT_SETTINGS','Aktuelle Einstellung');
DEFINE('_UE_A_EXPLANATION','Erkl�rung');
DEFINE('_UE_DISPLAY','Anzeigen?');
DEFINE('_UE_REQUIRED','Pflichtfeld?');
DEFINE('_UE_YES','Ja');
DEFINE('_UE_NO','Nein');

//Admin Avatar Tab Labels
DEFINE('_UE_AVATAR_DESC','Auf &quot;Ja&quot; setzen, um registrierten Benutzern das Hochladen eines Bilders zu gestatten. (Im Benutzerprofil zu verwalten.)');
DEFINE('_UE_AVHEIGHT','Max. Bildh�he');
DEFINE('_UE_AVWIDTH','Max. Bildbreite');
DEFINE('_UE_AVSIZE','Max. Dateigr��e des Bildes<br/><em>in Kilobyte</em>');
DEFINE('_UE_AVATARUPLOAD','Hochladen von Bildern erlauben');
DEFINE('_UE_AVATARUPLOAD_DESC','Auf &quot;Ja&quot; setzen, um Benutzern das Hochladen eines Bildes zu gestatten.');
DEFINE('_UE_AVATARIMAGERESIZE','Bildgr��e automatisch �ndern'); //old
DEFINE('_UE_AVATARIMAGERESIZE_DESC','Automatische Bildgr��en�nderung erfordert die GD Library.  GD2 installiert:'); //old
DEFINE('_UE_AVATARGALLERY','Bildgalerie verwenden');
DEFINE('_UE_AVATARGALLERY_DESC','Auf &quot;Ja&quot; setzen, damit registrierte Benutzer ein Bild aus der Galerie w�hlen k�nnen.');
DEFINE('_UE_TNWIDTH','Max. Breite des Vorschaubildes');
DEFINE('_UE_TNHEIGHT','Max. H�he des Vorschaubildes');

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
DEFINE('_UE_ALLOW_EMAIL_DESC','E-Mail-Links gestatten. ANMERKUNG: Diese Einstellung gilt nur f�r Felder vom Typ E-Mail');
DEFINE('_UE_ALLOW_WEBSITE','Weblinks');
DEFINE('_UE_ALLOW_WEBSITE_DESC','Weblinks gestatten');
DEFINE('_UE_ALLOW_IM','Instant-Messenger-Links');
DEFINE('_UE_ALLOW_IM_DESC','Instant-Messenger-Links gestatten');
DEFINE('_UE_ALLOW_ONLINESTATUS','Online-Status');
DEFINE('_UE_ALLOW_ONLINESTATUS_DESC','Online-Status zeigen');
DEFINE('_UE_ALLOW_EMAIL_DISPLAY_DESC','ANMERKUNG: Diese Einstellung gilt nur f�r die erste E-Mail-Adresse des Benutzers');

//Admin Moderate Tab labels
DEFINE('_UE_MODERATE','Moderation');
DEFINE('_UE_AVATARUPLOADAPPROVALGROUP','Moderatorgruppen');
DEFINE('_UE_AVATARUPLOADAPPROVALGROUP_DESC','Alle Benutzer in der gew�hlten Gruppe und dar�ber sind Moderatoren.');
DEFINE('_UE_ALLOWUSERREPORTS','Benutzerbeschwerden gestatten');
DEFINE ('_UE_ALLOWUSERREPORTS_DESC','Gestattet Benutzern, sich �ber das Verhalten anderer zu beschweren.');
DEFINE ('_UE_AVATARUPLOADAPPROVAL','Bilderfreischaltung erforderlich');
DEFINE ('_UE_AVATARUPLOADAPPROVAL_DESC','Alle hochgeladenen Bilder ben�tigen eine Freischaltung, bevor sie angezeigt werden.');
DEFINE ('_UE_ALLOWUSERPROFILEBANNING_DESC','Erm�glicht Benutzern, die Anzeige eines Benutzerprofils zu sperren.');
DEFINE ('_UE_ALLOWUSERPROFILEBANNING','Benutzerprofilsperren erm�glichen');

//Admin Registration tab labels
DEFINE('_UE_NAME_FORMAT','Format Name');
DEFINE('_UE_DATE_FORMAT','Format Datum');
DEFINE('_UE_NAME_FORMAT_DESC','W�hlen Sie das Format, in dem Name/Benutzername angezeigt werden sollen.');
DEFINE('_UE_DATE_FORMAT_DESC','W�hlen Sie das Format, in dem das Datum angezeigt werden soll.');
DEFINE ('_UE_REG_CONFIRMATION_DESC','Auf &quot;Ja&quot; setzen, um den Benutzern nach der Registrierung eine E-Mail mit Best�tigungslink zu senden');
DEFINE ('_UE_REG_CONFIRMATION','E-Mail-Best�tigung erforderlich');
DEFINE ('_UE_REG_ADMIN_APPROVAL','Freischaltung durch den Administrator erforderlich');
DEFINE ('_UE_REG_ADMIN_APPROVAL_DESC','Alle Registrierungen m�ssen von einem Administrator freigeschaltet werden.');
DEFINE ('_UE_REG_EMAIL_NAME','Registrierung E-Mail-Absendername');
DEFINE ('_UE_REG_EMAIL_NAME_DESC','Name, unter dem Ihre E-Mails versendet werden');
DEFINE ('_UE_REG_EMAIL_FROM','Registrierung E-Mail-Adresse');
DEFINE ('_UE_REG_EMAIL_FROM_DESC','E-Mail-Adresse, mit der Ihre E-Mails versendet werden');
DEFINE ('_UE_REG_EMAIL_REPLYTO','Registrierung Antwortadresse');
DEFINE ('_UE_REG_EMAIL_REPLYTO_DESC','E-Mail-Adresse, die als Antwortadresse (reply-to) in Ihren E-Mails aufscheint');
DEFINE ('_UE_REG_PEND_APPR_MSG','E-Mail &quot;Ausstehende Freischaltung&quot;');
DEFINE ('_UE_REG_WELCOME_MSG','E-Mail &quot;Willkommen&quot;');
DEFINE ('_UE_REG_REJECT_MSG','E-Mail &quot;Ablehnung&quot;');
DEFINE ('_UE_REG_PEND_APPR_SUB','Betreff in der E-Mail &quot;Ausstehende Freischaltung&quot;');
DEFINE ('_UE_REG_WELCOME_SUB','Betreff in der E-Mail &quot;Willkommen&quot;');
DEFINE ('_UE_REG_PEND_APPR_SUB_DESC','Betreff in der E-Mail &quot;Ausstehende Freischaltung&quot;');
DEFINE ('_UE_REG_WELCOME_SUB_DESC','Betreff in der E-Mail &quot;Willkommen&quot;');
DEFINE ('_UE_REG_REJECT_SUB_DESC','Betreff in der E-Mail &quot;Ablehnung&quot;');
DEFINE ('_UE_REG_SIGNATURE','E-Mail-Signatur');
DEFINE ('_UE_REG_ADMIN_PA_SUB','AKTION N�TIG! Neue Registrierungen warten auf Freischaltung');
DEFINE ('_UE_REG_ADMIN_PA_MSG','Ein neuer Benutzer hat sich auf [SITEURL] angemeldet und wartet auf Freischaltung.\n'
.'Diese E-Mail enth�lt die Anmeldedaten\n\n'
.'Name - [NAME]\n'
.'E-Mail - [EMAILADDRESS]\n'
.'Benutzername - [USERNAME]\n\n\n'
.'Diese Nachricht wurde automatisch generiert und dient nur zur Information. Bitte nicht darauf antworten\n');
DEFINE ('_UE_REG_ADMIN_SUB','Registrierung eines neuen Benutzers');
DEFINE ('_UE_REG_ADMIN_MSG','Ein neuer Benutzer hat sich auf [SITEURL] angemeldet.\n'
.'Diese E-Mail enth�lt die Anmeldedaten\n\n'
.'Name - [NAME]\n'
.'E-Mail - [EMAILADDRESS]\n'
.'Benutzername - [USERNAME]\n\n\n'
.'Diese Nachricht wurde automatisch generiert und dient nur zur Information. Bitte nicht darauf antworten\n');
DEFINE('_UE_REG_EMAIL_TAGS','[NAME] - Name des Benutzers<br />'
.'[USERNAME] - Benutzername<br />'
.'[DETAILS] - Details im Benutzerkonto (wie E-Mail-Adresse, Benutzername, Passwort)<br />'
.'[CONFIRM] - f�gt einen Best�tigungslink in die E-Mail an, falls diese Funktion aktiviert ist<br />');

//Registration form
DEFINE('_UE_REG_COMPLETE_NOPASS','<span class="componentheading">Registrierung abgeschlossen!</span><br />&nbsp;&nbsp;'
.'Das Passwort wurde an die angegebene E-Mail-Adresse gesendet.<br />&nbsp;&nbsp;'
.'Sobald Sie es erhalten haben, k�nnen Sie sich anmelden.');
DEFINE('_UE_REG_COMPLETE','<span class="componentheading">Registrierung abgeschlossen!</span><br />&nbsp;&nbsp;'
.'Sie k�nnen sich jetzt anmelden.<br />&nbsp;&nbsp;');
DEFINE('_UE_REG_COMPLETE_NOPASS_NOAPPR','<span class="componentheading">Registrierung abgeschlossen!</span><br />&nbsp;&nbsp;'
.'Ihre Registrierung muss erst �berpr�ft und freigeschaltet werden.<br />&nbsp;&nbsp;'
.'Bei Freischaltung erhalten Sie ein Passwort per E-Mail und k�nnen sich dann anmelden.');
DEFINE('_UE_REG_COMPLETE_NOAPPR','<span class="componentheading">Registrierung abgeschlossen!</span><br />&nbsp;&nbsp;'
.'Ihre Registrierung muss erst �berpr�ft und freigeschaltet werden. <br />&nbsp;&nbsp;'
.'Bei Freischaltung erhalten Sie eine E-Mail und k�nnen sich dann anmelden.');
DEFINE('_UE_REG_COMPLETE_CONF','<span class="componentheading">Registrierung abgeschlossen!</span><br />&nbsp;&nbsp;'
.'Eine E-Mail mit weiteren Informationen wurde an die angegebene Adresse geschickt. Bitte folgen Sie den Anweisungen in dieser Mail, um die Registrierung abzuschlie�en.<br />&nbsp;&nbsp;');
DEFINE('_UE_REG_COMPLETE_NOPASS_CONF','<span class="componentheading">Registrierung abgeschlossen!</span><br />&nbsp;&nbsp;'
.'Ihr Passwort wurde an die angegebene E-Mail-Adresse gesendet.<br />&nbsp;&nbsp;'
.'Wenn Sie das Passwort erhalten haben, folgen Sie den Anweisungen in der E-Mail, um sich anmelden zu k�nnen.');

// User List Labels
DEFINE ('_UE_HAS','hat');
DEFINE ('_UE_USERS','Benutzer');
DEFINE ('_UE_SEARCH_ALERT','Bitte Suchbegriff eingeben!');
DEFINE ('_UE_SEARCH','Benutzer finden');
DEFINE ('_UE_ENTER_EMAIL','Geben Sie E-Mail-Adresse, Namen oder Benutzernamen des Benutzers an!');
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
DEFINE ('_UE_NEXT_PAGE','N�chste Seite');
DEFINE ('_UE_END_PAGE','Letzte Seite');
DEFINE('_UE_CONTACT','Kontakt');
DEFINE('_UE_INSTANT_MESSAGE','Instant Message');
DEFINE('_UE_IMAGEAVAILABLE','Foto');
DEFINE('_UE_INFO','Info');
DEFINE('_UE_PROFILE','Benutzerprofil');
DEFINE('_UE_PRIVATE_MESSAGE','Private Message');
DEFINE('_UE_ADDITIONAL','Mehr Info');
DEFINE('_UE_NO_DATA','Keine Angabe');
DEFINE('_UE_CLICKTOVIEW','Klicken Sie f�r');
DEFINE('_UE_UL_USERNAME_NAME','Benutzername(Name)');
DEFINE('_UE_PM','Private Nachricht');
DEFINE('UE_PM_USER','Private Nachricht senden');

//mod_userextraslogin
DEFINE('_UE_NO_ACCOUNT','Noch nicht dabei?');
DEFINE('_UE_CREATE_ACCOUNT','Benutzer neu anmelden');
DEFINE('_LOGIN_NOT_CONFIRMED','Registrierung nicht vollst�ndig! Weitere Hinweise finden Sie in Ihrem E-Mail-Posteingang.');
DEFINE('_LOGIN_NOT_APPROVED','Ihre Anmeldung wurde noch nicht freigeschaltet.');
DEFINE('_UE_USER_CONFIRMED','Ihre Anmeldung ist freigeschaltet. Sie k�nnen sich jetzt anmelden!');
DEFINE('_UE_USER_NOTCONFIRMED','Ihre Anmeldung ist noch nicht freigeschaltet. Weitere Hinweise finden Sie in Ihrem E-Mail-Posteingang.');


//Avatar
DEFINE('_UE_UPLOAD_UPLOAD','Hochladen');
DEFINE('_UE_UPLOAD_DIMENSIONS','Maximale Bildgr��e (Breite x H�he - Dateigr��e)');
DEFINE('_UE_UPLOAD_SUBMIT','Neues Bild ausw�hlen');
DEFINE('_UE_UPLOAD_SELECT_FILE','Datei ausw�hlen');
DEFINE('_UE_UPLOAD_ERROR_TYPE','Es werden nur .jpg, .png und .gif Dateien akzeptiert.');
DEFINE('_UE_UPLOAD_ERROR_EMPTY','Vor dem Hochladen bitte eine Datei ausw�hlen!');
DEFINE('_UE_UPLOAD_ERROR_NAME','Der Dateiname darf nur alphanumerische Zeichen und keine Leerzeichen beinhalten.');
DEFINE('_UE_UPLOAD_ERROR_SIZE','Die Dateigr��e des Bildes �berschreitet den erlaubten H�chstwert.');
DEFINE('_UE_UPLOAD_ERROR_WIDTHHEIGHT','Bildbreite oder -h�he �berschreiten den erlaubten H�chstwert.');
DEFINE('_UE_UPLOAD_ERROR_WIDTH','Das Bild ist zu breit.');
DEFINE('_UE_UPLOAD_ERROR_HEIGHT','Das Bild ist zu hoch.');
DEFINE('_UE_UPLOAD_ERROR_CHOOSE', 'Kein Bild aus der Galerie ausgew�hlt.');
DEFINE('_UE_UPLOAD_UPLOADED','Das Bild wurde hochgeladen.');
DEFINE('_UE_UPLOAD_GALLERY','W�hlen Sie ein Bild aus der Galerie');
DEFINE('_UE_UPLOAD_CHOOSE','Auswahl best�tigen.');
DEFINE('_UE_UPLOAD_UPDATED','Das Bild wurde aktualisiert.');
DEFINE('_UE_USER_PROFILE_NOT','Ihr Benutzerprofil konnte nicht aktualisiert werden.');
DEFINE('_UE_USER_PROFILE_UPDATED','Benutzerprofil aktualisiert.');
DEFINE('_UE_USER_RETURN_A','Wenn Sie nicht in wenigen Augenblicken zu Ihrem Benutzerprofil weitergeleitet werden, ');
DEFINE('_UE_USER_RETURN_B','klicken Sie hier.');
DEFINE('_UPDATE','UPDATE'); //old?

//Moderator
DEFINE('_UE_USERPROFILEBANNED','Benutzerprofil von Moderator gesperrt.');
DEFINE('_UE_REQUESTUNBANPROFILE','Entsperrung beantragen');
DEFINE('_UE_REPORTUSER','Beschwerde �ber Benutzer abgeben');
DEFINE('_UE_BANPROFILE','Benutzerprofil sperren');
DEFINE('_UE_UNBANPROFILE','Benutzerprofil entsperren');
DEFINE('_UE_REPORTUSER_TITLE','Benutzerbeschwerde');
DEFINE('_UE_USERREASON','Warum beschweren Sie sich �ber diesen Benutzer?');
DEFINE('_UE_BANREASON','Grund der Benutzerprofilsperre');
DEFINE('_UE_SUBMITFORM','Abschicken');
DEFINE('_UE_NOUNBANREQUESTS','Es liegen keine Entsperrungsantr�ge vor.');
// DEFINE('_UE_BANREASON','Grund der Sperre'); //old
DEFINE('_UE_IMAGE_MODERATE','Bild freischalten');
DEFINE('_UE_APPROVE_IMAGES','Freischalten');
DEFINE('_UE_REJECT_IMAGES','Ablehnen');
DEFINE('_UE_MODERATE_TITLE','Moderator');
DEFINE('_UE_NOIMAGESTOAPPROVE','Keine Bilder zum Freischalten');
DEFINE('_UE_USERREPORT_MODERATE','Benutzerbeschwerden bearbeiten');
DEFINE('_UE_REPORTEDUSER','Beschwerde �ber Benutzer');
DEFINE('_UE_REPORT','Beschwerde');
DEFINE('_UE_REPORTEDONDATE','Datum der Beschwerde');
DEFINE('_UE_REPORTEDBY','Beschwerde stammt von');
DEFINE('_UE_PROCESSUSERREPORT','IN BEARBEITUNG');
DEFINE('_UE_NONEWUSERREPORTS','Es liegen keine Benutzerbeschwerden vor.');
DEFINE('_UE_USERUNBAN_SUCCESSFUL','Benutzerprofil erfolgreich entsperrt.');
DEFINE('_UE_REPORTUSERSACTIVITY','Beschreiben Sie die Aktivit�ten des Benutzers');
DEFINE('_UE_USERREPORT_SUCCESSFUL','Benutzerbeschwerde erfolgreich abgeschickt.');
DEFINE('_UE_USERBAN_SUCCESSFUL','Sperre des Benutzerprofils erfolgreich.');
DEFINE('_UE_FUNCTIONALITY_DISABLED','Diese Funktion ist derzeit deaktiviert.');
DEFINE('_UE_UPLOAD_PEND_APPROVAL','Ihr Bild muss noch freigeschaltet werden.');
DEFINE('_UE_UPLOAD_SUCCESSFUL','Bild erfolgreich hochgeladen!');
DEFINE('_UE_UNBANREQUEST','Entsperrung beantragen');
DEFINE('_UE_USERUNBANREQUEST_SUCCESSFUL','Ihr Benutzerprofil-Entsperrungsantrag ist erfolgreich �bermittelt worden.');
DEFINE('_UE_USERREPORT','Benutzerbeschwerde');
DEFINE('_UE_VIEWUSERREPORTS','Benutzerbeschwerden ansehen');
DEFINE('_UE_USERREQUESTRESPONSE','Benutzerbeschwerden ansehen');
DEFINE('_UE_MODERATORREQUESTRESPONSE','Benutzerbeschwerden ansehen');
DEFINE('_UE_REPORTBAN_TITLE','Sperrbericht');
DEFINE('_UE_REPORTUNBAN_TITLE','Sperrbericht');

DEFINE('_UE_UNBANREQUIREACTION',' Entsperrungsantrag/antr�ge');
DEFINE('_UE_USERREPORTSREQUIREACTION','Benutzerbeschwerde(n)');
DEFINE('_UE_IMAGESREQUIREACTION','Bild(er)');
DEFINE('_UE_NOACTIONREQUIRED','Keine Aktionen n�tig.');

DEFINE('_UE_UNBAN_MODERATE','Entsperrungsantr�ge');
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
DEFINE('_UE_IMAGEAPPROVED_MSG','Ihr Bild wurde vom Moderator freigeschaltet.');
DEFINE('_UE_IMAGEREJECTED_SUB','Bild abgelehnt.');
DEFINE('_UE_IMAGEREJECTED_MSG','Ihr Bild wurde vom Moderator abgelehnt. Bitte melden Sie sich an und laden Sie ein neues hoch.');
DEFINE('_UE_BANUSER_SUB','Benutzerprofil gesperrt');
DEFINE('_UE_BANUSER_MSG','Ihr Benutzerprofil wurde von einem Administrator gesperrt. Bitte melden Sie sich an, um den Grund f�r die Sperre zu erfahren.');
DEFINE('_UE_UNBANUSER_SUB','Benutzerprofil entsperrt');
DEFINE('_UE_UNBANUSER_MSG','Die Sperre Ihres Benutzerprofils wurde aufgehoben. Es ist jetzt wieder f�r alle Benutzer sichtbar.');
DEFINE('_UE_UNBANUSERREQUEST_SUB','Entsperrungantrag liegt vor');
DEFINE('_UE_UNBANUSERREQUEST_MSG','Ein Benutzer hat einen Entsperrungsantrag gestellt. Bitte einloggen und bearbeiten!');


//Alpha 3 Build
DEFINE('_UE_IMAGE','Vorschaubild');
DEFINE('_UE_FORMATNAME','Formatierter Name');

//Alpha 4 Build
DEFINE('_UE_ADMINREQUIREDFIELDS','Pflichtfelder in der Benutzerverwaltung');
DEFINE('_UE_ADMINREQUIREDFIELDS_DESC','Auf &quot;Ja&quot; sind Pflichtfelder auch in der Benutzerverwaltung verpflichtend. Bei &quot;Nein&quot; kann der Administrator Pflichtfelder frei lassen.');
DEFINE('_UE_CANCEL','Abbrechen');
DEFINE('_UE_NA','nicht verf�gbar');
DEFINE('_UE_MODERATOREMAIL','E-Mails an Moderatoren senden');
DEFINE('_UE_MODERATOREMAIL_DESC','Bei &quot;Ja&quot; erhalten die Moderator eine E-Mail, wenn ihr Handeln erforderlich ist (Freischaltungen, usw.).');

//Beta 1 Build
DEFINE('_UE_UPDATE','Aktualisieren');

//Beta 2 Build
DEFINE('_UE_FIELDONPROFILE','Dieses Feld wird im Profil angezeigt.');
DEFINE('_UE_FIELDNOPROFILE','Dieses Feld wird NICHT im Profil angezeigt.');
DEFINE('_UE_FIELDREQUIRED','Pflichtfeld');
DEFINE('_UE_NOT_AUTHORIZED','Sie haben keinen Zugriff auf diese Seite!');
DEFINE('_UE_ALLOW_LISTVIEWBY','Zugriff gew�hren f�r:');
DEFINE('_UE_ALLOW_LISTVIEWBY_DESC','W�hlen Sie die Gruppe, die die Liste sehen darf. Diese Gruppe und alle h�heren haben Zugriff.');
DEFINE('_UE_ALLOW_PROFILEVIEWBY','Zugriff gew�hren f�r:');
DEFINE('_UE_ALLOW_PROFILEVIEWBY_DESC','W�hlen Sie die Gruppe, die die Liste sehen darf. Diese Gruppe und alle h�heren haben Zugriff.');

//Beta 3 Build
DEFINE('_UE_NOLISTFOUND','Es gibt keine ver�ffentlichten Benutzerlisten!');
DEFINE('_UE_ALLOW_PROFILELINK','Link zu Benutzerprofil erlauben');
DEFINE('_UE_ALLOW_PROFILELINK_DESC','Auf &quot;Ja&quot; setzen, um in jede Zeile einen Link zum Benutzerprofil einzuf�gen. Bei &quot;Nein&quot; wird kein solcher Link eingef�gt.');
DEFINE('_UE_REGISTERFORPROFILE','Bitte melden Sie sich an, um das Benutzerprofil anzusehen oder zu ver�ndern.');
DEFINE('_UE_UPLOAD_ERROR_GDNOTINSTALLED','Die GD2 Library ist nicht installiert oder nicht mit PHP kompiliert. Bitte wenden Sie sich an den Systemadministrator, um die automatische Bildgr��en�nderung zu deaktivieren.');
DEFINE('_UE_UPLOAD_ERROR_UPLOADFAILED','Fehler beim Hochladen des Bildes!');
DEFINE('_UE_TOC','Nutzungsbedingungen akzeptieren');
DEFINE('_UE_TOC_REQUIRED','Zur Registrierung m�ssen Sie die Nutzungsbedingungen akzeptieren');
DEFINE('_UE_REG_TOC_MSG','Nutzungsbedingungen aktivieren');
DEFINE('_UE_REG_TOC_DESC','Auf &quot;Ja&quot; setzen, falls Benutzer vor der Registrierung die Nutzungsbedingungen akzeptieren m�ssen!');
DEFINE('_UE_REG_TOC_URL_MSG','Link zu den Nutzungsbedingungen');
DEFINE('_UE_REG_TOC_URL_DESC','Link zu den Nutzungsbedingungen angeben.');
DEFINE('_UE_LASTUPDATEDON','Letzte Aktualisierung');

//Beta 4 Build
DEFINE('_UE_EMAILFORMWARNING','ACHTUNG: Falls Sie weitermachen, kann der Benutzer Ihre E-Mail-Adresse in der E-Mail sehen.');
DEFINE('_UE_EMAILFORMSUBJECT','Betreff:');
DEFINE('_UE_EMAILFORMMESSAGE','Nachricht:');
DEFINE('_UE_EMAILFORMINSTRUCT','E-Mail senden an <a href="index.php?option=com_cbe&task=UserDetails&user=%s">%s </a>.');
DEFINE('_UE_GENERAL','Allgemein');
DEFINE('_UE_SENDEMAILNOTICE','ANMERKUNG: Das ist eine Nachricht von %s bei %s ( %s ). Der Benutzer hat Ihre E-Mail-Adresse nicht gesehen. Falls Sie darauf antworten, wird der Benutzer Ihre E-Mail-Adresse sehen k�nnen. %s ist f�r den Inhalt der E-Mail nicht verantwortlich.');
DEFINE('_UE_SENDEMAIL','E-Mail senden');
DEFINE('_UE_SENTEMAILSUCCESS','Ihre E-Mail wurde erfolgreich versendet!');
DEFINE('_UE_SENTEMAILFAILED','E-Mail konnte nicht gesendet werden. Bitte versuchen Sie es noch einmal!');
DEFINE('_UE_ALLOW_EMAIL_DISPLAY','E-Mail-Darstellung');
DEFINE('_UE_REGISTERDATE','Datum der Registrierung');
DEFINE('_UE_ACTION','Aktion');
DEFINE('_UE_USER','Benutzer');
DEFINE('_UE_USERAPPROVAL_MODERATE','Benutzer akzeptieren/ablehnen');
DEFINE('_UE_USERPENDAPPRACTION',' Benutzer');
DEFINE('_UE_APPROVEUSER','Benutzer in Bearbeitung');
DEFINE('_UE_REG_REJECT_SUB','Ihre Registrierung wurde abgelehnt!');
DEFINE('_UE_USERREJECT_MSG','Ihre Registrierung f�r %s wurde abgelehnt. Grund: \n %s');
DEFINE('_UE_COMMENT','Grund der Ablehnung');
DEFINE('_UE_APPROVE','Freischalten');
DEFINE('_UE_REJECT','Ablehnen');
DEFINE('_UE_USERREJECT_SUCCESSFUL','Benutzer wurde abgelehnt!');
DEFINE('_UE_USERAPPROVE_SUCCESSFUL','Benutzer wurde freigeschaltet!');
DEFINE('_LOGIN_REJECTED','Ihre Registrierung wurde abgelehnt!');
DEFINE('_UE_EMAILFOOTER','ANMERKUNG: Das ist eine automatisch generierte Nachricht von %s (%s).');
DEFINE('_UE_MODERATORUSERAPPOVAL','Moderatoren k�nnen Benutzer freischalten');
DEFINE('_UE_MODERATORUSERAPPOVAL_DESC','Diese Einstellung erlaubt Moderatoren, Benutzer im Frontend der Website freizuschalten.');
DEFINE('_UE_REG_COMPLETE_NOAPPR_CONF','<span class="componentheading">Registrierung abgeschlossen!</span><br />&nbsp;&nbsp;'
.'Ihre Registrierung erfordert Freischaltung und E-Mail-R�ckbest�tigung. Bitte folgen Sie den Anweisungen in der E-Mail, die Sie erhalten haben. Nach der Freischaltung k�nnen Sie sich anmelden.<br />&nbsp;&nbsp;');
DEFINE('_UE_REG_COMPLETE_NOPASS_NOAPPR_CONF','<span class="componentheading">Registrierung abgeschlossen!</span><br />&nbsp;&nbsp;'
.'Ihre Registrierung erfordert Freischaltung und E-Mail-R�ckbest�tigung. Bitte folgen Sie den Anweisungen in der E-Mail, die Sie erhalten haben.<br />&nbsp;&nbsp;'
.'Nach Freischaltung wird Ihnen ein Passwort zugesendet, mit dem Sie sich einloggen k�nnen.');
DEFINE('_UE_NAME_STYLE','Name Felder');
DEFINE('_UE_NAME_STYLE_DESC','Hier k�nnen Sie angeben, wie viele Felder der Benutzername in Mambo umfassen soll.');
DEFINE('_UE_USER_CONFIRMED_NEEDAPPR','Danke f�r die Best�tigung Ihrer E-Mail-Adresse. Ihre Registrierung muss jetzt noch von einem Moderator freigeschaltet werden. Sie erhalten eine E-Mail, nachdem Ihre Anmeldung gepr�ft wurde.');
DEFINE('_UE_YOUR_FNAME','Vorname');   
DEFINE('_UE_YOUR_MNAME','Zweiter Vorname');
DEFINE('_UE_YOUR_LNAME','Nachname');

//RC 1 Build
DEFINE('_UE_NOSELFEMAIL','Sie k�nnen keine E-Mail an sich selbst senden!');
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
DEFINE('_UE_FORUM_TOP10','Letzte 10 Forumeintr�ge');
DEFINE('_UE_FORUM_STATS','Forum-Statistik');
DEFINE('_RANK_MODERATOR','Moderator');
DEFINE('_RANK_ADMINISTRATOR','Administrator');
DEFINE('_UE_SBNOTINSTALLED','Die Simpleboard-Komponente ist nicht installiert. Bitte wenden Sie sich an den Administrator.');
DEFINE('_UE_NOFORUMPOSTS','Dieser Benutzer hat keine Forumeintr�ge verfasst.');
DEFINE('_UE_NESTTABS','Tabs verschachteln');
DEFINE('_UE_NESTTABS_DESC','Alle Tabs unter einem einzigen Profil-Tab anordnen. Das ist zu empfehlen, wenn es sehr viele Tabs gibt.');
DEFINE('_UE_TEMPLATEDIR','Tab-Vorlage');
DEFINE('_UE_TEMPLATEDIR_DESC','W�hle eine Vorlagedatei (template) f�r die im Community Builder verwendeten Tabs aus.');
DEFINE('_UE_MAMBLOGNOTINSTALLED','Die Mamblog-Komponente ist nicht installiert. Bitte wenden Sie sich an den Administrator.');
DEFINE('_UE_BLOGDATE','Datum');
DEFINE('_UE_BLOGTITLE','Titel');
DEFINE('_UE_BLOGHITS','Aufrufe');
DEFINE('_UE_NOBLOGS','Dieser Benutzer hat keine Blog-Eintr�ge verfasst.');
DEFINE('_UE_NOARTICLES','Dieser Benutzer hat keine Artikel verfasst.');
DEFINE('_UE_IMPATH','Pfad zu ImageMagick');
DEFINE('_UE_IMPATH_DESC','Pfad zu ImageMagick');
DEFINE('_UE_NETPBMPATH','Pfad zu NetPBM');
DEFINE('_UE_NETPBMPATH_DESC','Pfad zu NetPBM');
DEFINE('_UE_AUTODET','Automatisch erkannt');
DEFINE('_UE_ERROR_NOTINSTALLED','Nicht installiert');
DEFINE('_UE_CONVERSIONTYPE','Art der Bildumwandlung');
DEFINE('_UE_NEWPASS_FAILED','Das Zur�cksetzen des Passwortes ist gescheitert!');
DEFINE('_UE_USER_SUBSCRIPTIONS','Ihre Abos');
DEFINE('_UE_THREAD_UNSUBSCRIBE',':: abbestellen ::');
DEFINE('_UE_USER_NOSUBSCRIPTIONS','Sie haben keine Abos.');
DEFINE('_UE_GEN_BY','von');
DEFINE('_UE_USER_UNSUBSCRIBE_ALL','Alle abbestellen');
DEFINE('_UE_USERREPORTMODERATED_SUCCESSFUL','Benutzerbeschwerde erfolgreich bearbeitet!');
DEFINE('_UE_USERIMAGEMODERATED_SUCCESSFUL','Benutzerbildmoderation erfolgreich durchgef�hrt!');
DEFINE('_UE_NOREPORTSTOPROCESS','Es liegen keine Benutzerbeschwerden vor');
DEFINE('_UE_NOUSERSPENDING','Es liegen keine Registrierungsantr�ge vor');
DEFINE('_UE_BLANK','');
DEFINE('_UE_REG_FIRST_VISIT_URL_MSG','URL bei der ersten Anmeldung');
DEFINE('_UE_REG_FIRST_VISIT_URL_DESC','Geben Sie die URL der Seite an, die der Benutzer nach seiner ersten Anmeldung nach der Registrierung zu sehen bekommen soll. Diese Seite kann zum Beispiel eine Willkommen-Seite f�r neue Mitglieder sein, wichtige Anleitungen enthalten oder die Profil-Seite des Benutzer sein. Wenn Sie dieses Feld frei lassen, wird der Benutzer auch bei der ersten Anmeldung normal weitergeleitet.');
DEFINE('_UE_NOSUCHPROFILE','Dieses Profil existiert nicht (mehr).');


//SB Integration Support
DEFINE('_UE_SB_TABTITLE','Forum Einstellungen');
DEFINE('_UE_SB_TABDESC','Das sind Ihre Forumseinstellungen');
DEFINE('_UE_SB_VIEWTYPE_TITLE','Bevorzugte Darstellung');
DEFINE('_UE_SB_VIEWTYPE_FLAT','als Liste');
DEFINE('_UE_SB_VIEWTYPE_THREADED','als Baum');
DEFINE('_UE_SB_ORDERING_TITLE','Bevorzugte Reihenfolge');
DEFINE('_UE_SB_ORDERING_OLDEST','�ltester Beitrag zuerst');
DEFINE('_UE_SB_ORDERING_LATEST','J�ngster Beitrag zuerst');
DEFINE('_UE_SB_SIGNATURE','Signatur');
//added for SB 1.5 during 1.0 RC 1
DEFINE('_UE_SB_POSTSPERPAGE','Eintr�ge pro Seite'); 
DEFINE('_UE_SB_USERTIMEOFFSET','Lokale Zeitdifferenz zur Serverzeit');

//Not used within application but are needed to translate default images for profile.
DEFINE('_UE_IMG_NOIMG','Kein Bild');
DEFINE('_UE_IMG_PENDIMG','Bild noch nicht freigeschaltet');
?>