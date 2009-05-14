<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

//********************************************
// CBE-Beta1-1/2 Tools Language File - German*
// Copyright (c) 2005 Philipp Kolloczek      *
// Released under the GNU/GPL License        *
// Version 1.0                               *
// File date: 11-06-2006                     *
//********************************************

//Tools Menu Language
DEFINE('_UE_TOOLS_MANAGER','Tools Manager');
DEFINE('_UE_TOOLS_SAMPLEDATA','Lade Beispiele');
DEFINE('_UE_TOOLS_SAMPLEDATA_DESC','Lädt Beispieldaten und Felder in die CBE Datentabellen. Als Ansichtsmaterial gedacht, wenn man gerade startet.');
DEFINE('_UE_TOOLS_SYNCUSERS','Usertabellen synchronisieren');
DEFINE('_UE_TOOLS_SYNCUSERS_DESC','Synchronisiert die CBE- ( #__cbe ) mit der Joomla-Usertabelle ( #__users ). <br>Hier wird von Joomla ==> CBE gearbeitet.');
DEFINE('_UE_TOOLS_SYNCUSERS_JOOMLA_SHOW','Userleichen zeigen');
DEFINE('_UE_TOOLS_SYNCUSERS_JOOMLA_SHOW_DESC','Zeigt eine liste von Userleichen die in der CBE Tabelle aber nicht mehr in der Joomla-User-Tabelle vorhanden sind.( LOST--x )');
DEFINE('_UE_TOOLS_SYNCUSERS_JOOMLA','Userleichen konvertieren');
DEFINE('_UE_TOOLS_SYNCUSERS_JOOMLA_DESC','Legt die Leichen in der Joomla-User-Tabelle neu an. Sie können dann über den CBE-UserManager einfach gelöscht werden.');
DEFINE('_UE_TOOLS_SYNCSEARCHTABLE','CB-Search Abgleich');
DEFINE('_UE_TOOLS_SYNCSEARCHTABLE_DESC','Führt eine Intitialisierung der erweiterten Suche ( CB-Search ) durch. <br>
Damit werden alle derzeit eingerichteten Felder, auch Systemfelder, in den Search-Manager übertragen. Diese Option sollte nach der Ersteinrichtung einmal aufgerufen werden.<br>
Hinweis: Ein erneutes Aufrufen löscht erst alle Inhalte des Search-Managers um ihn dann mit allen verfügbaren Feldern zu füllen.');
DEFINE('_UE_TOOLS_REASIGNFIELDS','Felder einem Tab zuordnen');
DEFINE('_UE_TOOLS_REASIGNFIELDS_DEC','Diese Option dient dazu nichtverbundene Felder wieder dem Kontaktinfo-Tab zuzuordnen. Dies kann hilfreich sein wenn man vom CB auf den CBE umgestiegen ist.');
DEFINE('_UE_TOOLS_LOADCOUNTRIES','Ländernamen einbinden');
DEFINE('_UE_TOOLS_LOADCOUNTRIES_DESC','Es werden die internationalen Ländernamen in die Datenbank eingebracht und ein entsprechendes Auswahlfeld in der Feldverwaltung eingetragen.');
DEFINE('_UE_TOOLS_LOADUSSTATES','US-Staten einbinden');
DEFINE('_UE_TOOLS_LOADUSSTATES_DESC','Es werden die Namen der Staaten der USA in die Datenbank eingebracht und ein entsprechendes Auswahlfeld in der Feldverwaltung eingetragen.');
DEFINE('_UE_TOOLS_LOADSIMPLEBOARD','JoomlaBoard / SimpleBoard Einstellungsfelder');
DEFINE('_UE_TOOLS_LOADSIMPLEBOARD_DESC','Richtet die Einstellungsfelder zur Unterstützung des JoomlaBoard / SimpleBoard ein. Diese werden benoetigt wenn der Forum-Tab aktiviert wird.');
DEFINE('_UE_TOOLS_LOADPROFILE_COLOR','Profilfarben laden');
DEFINE('_UE_TOOLS_LOADPROFILE_COLOR_DESC','Erstellt das Farbauswahlfeld für das Profil in der Feldverwaltung und lädt die Farbwerte in die Datenbank.');
DEFINE('_UE_TOOLS_LOADGERMANSTATES','Deutsche Bundesländer');
DEFINE('_UE_TOOLS_LOADGERMANSTATES_DESC','Erstellt ein Auswahlfeld in der Feldverwaltung und lädt die Namen der deutschen Bundesländer in die Datenbank. Dabei werden Sprachtags verwendet!');
DEFINE('_UE_TOOLS_CLEANLVTAB','LastVisitor Daten löschen');
DEFINE('_UE_TOOLS_CLEANLVTAB_DESC','Löscht den Inhalt der LastVisitors Datentabelle für alle User.');
DEFINE('_UE_TOOLS_CREATETOPVOTE','TopVote Übergabefelder erstellen');
DEFINE('_UE_TOOLS_CREATETOPVOTE_DESC','Erstellt die von mod_cbetopvotes benötigten Datenfelder um die Werte des ProfilRatings verwenden zu können.
Mittels dieser Option kann auch der alte VoteProfile Enhanced Tab verwendet werden.');
DEFINE('_UE_TOOLS_CREATEZODIACS','Sternzeichenfelder erstellen');
DEFINE('_UE_TOOLS_CREATEZODIACS_DESC','Es werden die Auswahlfelder für chinesische und westliche Sternzeichen erstellt und Auswahlwerte in die Datenbank eingebracht.');
DEFINE('_UE_TOOLS_UNPUBLISHZODIACS','(un)publizieren der Sternzeichenfelder');
DEFINE('_UE_TOOLS_UNPUBLISHZODIACS_DESC','Mittels dieser Option können die Sternzeichenauswahlfelder versteckt od. wieder aktiviert werden. Ein User sieht versteckte Felder nicht.<br>
Diese Felder sind nicht in der Feldverwaltung zu sehen, da sie als Systemfelder behandelt werden und ein Löschen vermieden werden soll.');
DEFINE('_UE_TOOLS_PREPARELVTAB','Datenbank für LastVisitors vorbereiten');
DEFINE('_UE_TOOLS_PREPARELVTAB_DESC','Diese Option braucht nur bei älteren Installationen des CBE nach einem Upgrade ausgeführt zu werden.<br>
Mit ihr wird die Datenbanktabelle des neuen LastVisitors Tab eingerichtet und initialisiert.');
DEFINE('_UE_TOOLS_DOWATERMARKALL','Wasserzeichen auf alle aktiven Avatare');
DEFINE('_UE_TOOLS_DOWATERMARKALL_DESC','Mit dieser Option werden die Einstellung der Konfiguration für das Wasserzeichen, <br>
den Stempeltext und die Größenanpassung auf alle derzeit vorhandenen Avatar Bilder angewendet. Wird diese Option mehrfach ausgeführt verstärkt sich der Wasserzeicheneffekt!');
DEFINE('_UE_TOOLS_GEOCODER_GENXML','Generiert die XML Datei für die Usermap');
DEFINE('_UE_TOOLS_GEOCODER_GENXML_DESC','Hiermit wird die XML Datei welche die Geokoordinaten der User enthält erstellt. Bitte stelle sicher das die Datei cbe_usermap.xml.php durch den Webserver beschreibbar ist.');
DEFINE('_UE_TOOLS_CBE_GALLERY','CBE-Gallery einrichten');
DEFINE('_UE_TOOLS_CBE_GALLERY_DESC','Erstellt die Datentabelle und den Tab für die CBE-Gallery (>1.3, by ejjoman).');
DEFINE('_UE_TOOLS_CBE_GALLERY_ADM','Config Module (Backend) einfügen');
DEFINE('_UE_TOOLS_CBE_GALLERY_ADM_DESC','Fügt das Config Module in das CBE Control-Panel ein. Dadurch erhält die CBE-Gallery (>1.3, by ejjoman) einen Konfigurationsbereich.');
//DEFINE('_UE_TOOLS_','');
?>