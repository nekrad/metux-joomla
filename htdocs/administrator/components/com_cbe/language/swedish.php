<?php
/*************************************************************
* Mambo Community Builder
* Author MamboJoe
* Translated to Swedish by Chrille (Christer Gerhardsson) and trotslos. Updated RC 1 by Chrille 2005-04-26
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*************************************************************/

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

//Field Labels
DEFINE('_UE_HITS','Träffar');
DEFINE('_UE_USERNAME','Användarnamn');
DEFINE('_UE_Address','Adress');
DEFINE('_UE_City','Stad');
DEFINE('_UE_State','Stat');
DEFINE('_UE_PHONE','Telefon nr.');
DEFINE('_UE_FAX','Fax nr.');
DEFINE('_UE_ZipCode','Postnummer');
DEFINE('_UE_Country','Land');
DEFINE('_UE_Occupation','Yrke');
DEFINE('_UE_Company','Företag');
DEFINE('_UE_Interests','Intressen');
DEFINE('_UE_Birthday','Födelsedag');
DEFINE('_UE_AVATAR','Bild');
DEFINE('_UE_Website','Hemsida');
DEFINE('_UE_Location','Plats');
DEFINE('_UE_EDIT_TITLE','Ändra dina uppgifter');
DEFINE('_UE_YOUR_NAME','Ditt nanmn');
DEFINE('_UE_EMAIL','E-post');
DEFINE('_UE_UNAME','Användarnamn');
DEFINE('_UE_PASS','Lösenord');
DEFINE('_UE_VPASS','Bekräfta lösenord');
DEFINE('_UE_SUBMIT_SUCCESS','Vi har mottagit dina uppgifter!');
DEFINE('_UE_SUBMIT_SUCCESS_DESC','Dina uppgifter har skickats till våra administratörer. Uppgifterna kommer att granskas innan de publiceras på denna sida.');
DEFINE('_UE_WELCOME','Välkommen!');
DEFINE('_UE_WELCOME_DESC','Välkommen till användardelen av vår sida');
DEFINE('_UE_CONF_CHECKED_IN','Uttagna objekt har nu "checkats in"');
DEFINE('_UE_CHECK_TABLE','Granskar tabellen');
DEFINE('_UE_CHECKED_IN','Checkat in ');
DEFINE('_UE_CHECKED_IN_ITEMS',' saker');
DEFINE('_UE_PASS_MATCH','Lösenordet stämmer inte');
DEFINE('_UE_USERNAME_DESC','&quot;Ja&quot; för att tillåta att användarnamnet kan ändras. &quot;Nej&quot; så kommer inte användarnamnet att kunna ändras efter registrering.');
DEFINE('_UE_ALLOW_EMAIL_USERCONTR','Gömma användarens e-postadress');
DEFINE('_UE_ALLOW_EMAIL_USERCONTR_DESC','&quot;Ja&quot; tillåter att användaren att gömma deras e-postadress för allmänheten. OBS: Denna inställning kommer endast att kontrollera visningen inom denna komponent!');
DEFINE('_UE_USERAPPROVAL_SUCCESSFUL','Användaren blev godkänd!');

//Front End Profile Lables
DEFINE('_UE_MEMBERSINCE','Medlem sedan');
DEFINE('_UE_LASTONLINE','Senast inloggad');
DEFINE('_UE_ONLINESTATUS','Inloggad');
DEFINE('_UE_ISONLINE','INLOGGAD');
DEFINE('_UE_ISOFFLINE','EJ INLOGGAD');
DEFINE('_UE_PROFILE_TITLE',' Profilsida');
DEFINE('_UE_UPDATEPROFILE','Uppdatera din profil');
DEFINE('_UE_UPDATEAVATAR','Uppdatera din bild');
DEFINE('_UE_CONTACT_INFO_HEADER','Kontaktinformation');
DEFINE('_UE_ADDITIONAL_INFO_HEADER','Övrig information');
DEFINE('_UE_REQUIRED_ERROR','Detta är ett obligatoriskt fält!');
DEFINE('_UE_FIELD_REQUIRED',' Obligatoriskt!');
DEFINE('_UE_DELETE_AVATAR',' Ta bort bild');

//Administrator Tab Names
DEFINE('_UE_USERPROFILE','Användarprofil');
DEFINE('_UE_USERLIST','Användarlista');
DEFINE('_UE_AVATARS','Bilder');
DEFINE('_UE_REGISTRATION','Registrering');
DEFINE('_UE_SUBSCRIPTION','Prenumerationer');
DEFINE('_UE_INTEGRATION','Integration');

//Administrator Integration Tab
DEFINE('_UE_PMS','myPMS2 Private Messaging');
DEFINE('_UE_PMS_DESC','Sätt till &quot;Nej&quot; om du inte har myPMS2 installerad för privata meddelanden, välj annars den version du vill integrera med.');


//Administrator Labels
DEFINE('_UE_FIELD_NAME','Fältnamn');
DEFINE('_UE_EXPLANATION','Förklaring');
DEFINE('_UE_FIELD_EXPLAINATION','Välj om du vill att detta fält skall vara obligatoriskt och visas för användaren.');
DEFINE('_UE_CONFIG','Konfiguration');
DEFINE('_UE_CONFIG_DESC','Ändra konfigurationen');
DEFINE('_UE_VERSION','Din version är ');
DEFINE('_UE_BY','En Mambo 4.5 komponent av');
DEFINE('_UE_CURRENT_SETTINGS','Nuvarande inställning');
DEFINE('_UE_A_EXPLANATION','Förklaring');
DEFINE('_UE_DISPLAY','Visa?');
DEFINE('_UE_REQUIRED','Obligatorisk?');
DEFINE('_UE_YES','Ja');
DEFINE('_UE_NO','Nej');

//Admin Avatar Tab Labels
DEFINE('_UE_AVATAR_DESC','Sätt till &quot;Ja&quot; Om du vill att registrerade användare skall kunna ha en bild (hanteras via deras profil)');
DEFINE('_UE_AVHEIGHT','Max. höjd på bilden');
DEFINE('_UE_AVWIDTH','Max. bredd på bilden');
DEFINE('_UE_AVSIZE','Max. filstorlek på bilden<br/><em>i kilobyte</em>');
DEFINE('_UE_AVATARUPLOAD','Tillåt uppladdning av bild');
DEFINE('_UE_AVATARUPLOAD_DESC','Sätt till &quot;Ja&quot; Om du vill att registrerade användare skall kunna ladda up en bild.');
DEFINE('_UE_AVATARGALLERY','Använd Bildgalleri');
DEFINE('_UE_AVATARGALLERY_DESC','Sätt till &quot;Ja&quot; om registrerade användare skall kunna välja en bild från hemsidans bildgalleri.');
DEFINE('_UE_TNWIDTH','Max. bredd på miniatyren');
DEFINE('_UE_TNHEIGHT','Max. höjd på miniatyren');

//Admin User List Tab Labels
DEFINE('_UE_USERLIST_TITLE','Användarlistans titel');
DEFINE('_UE_USERLIST_TITLE_DESC','Användarlistans titel');
DEFINE('_UE_LISTVIEW','Lista');
DEFINE('_UE_PICTLIST','Bildlista');
DEFINE('_UE_PICTDETAIL','Bilddetaljer');
DEFINE('_UE_NUM_PER_PAGE','Användare per sida');
DEFINE('_UE_NUM_PER_PAGE_DESC','Användare per sida');
DEFINE('_UE_VIEW_TYPE','Visningstyp');
DEFINE('_UE_VIEW_TYPE_DESC','Visningstyp');
DEFINE('_UE_ALLOW_EMAIL','E-postlänkar');
DEFINE('_UE_ALLOW_EMAIL_DESC','Tillåt e-postlänkar. OBS! Denna inställning gäller endast de tillagda fälten av typen e-post');
DEFINE('_UE_ALLOW_WEBSITE','Länkar till webbsida');
DEFINE('_UE_ALLOW_WEBSITE_DESC','Tillåt länkar till hemsida');
DEFINE('_UE_ALLOW_IM','IM-Länkar');
DEFINE('_UE_ALLOW_IM_DESC','Tillåt IM Länkar');
DEFINE('_UE_ALLOW_ONLINESTATUS','Inloggningsstatus');
DEFINE('_UE_ALLOW_ONLINESTATUS_DESC','Visa om användaren är inloggad');
DEFINE('_UE_ALLOW_EMAIL_DISPLAY_DESC','OBS! Denna inställning påverkar endast användarens första e-postadress.');

//Admin Moderate Tab labels
DEFINE('_UE_MODERATE','Moderering');
DEFINE('_UE_AVATARUPLOADAPPROVALGROUP','Moderatorgrupper');
DEFINE('_UE_AVATARUPLOADAPPROVALGROUP_DESC','Alla användare i den valda gruppen och ovanför kommer att bli moderatorer.');
DEFINE('_UE_ALLOWUSERREPORTS','Tillåt användarrapporter');
DEFINE ('_UE_ALLOWUSERREPORTS_DESC','Tillåt användare att anmäla oönskat uppträdande av andra användare till moderatorerna.');
DEFINE ('_UE_AVATARUPLOADAPPROVAL','Kräver godkännande av uppladdad bild');
DEFINE ('_UE_AVATARUPLOADAPPROVAL_DESC','Kräver att alla uppladdade bilder skall godkännas innan de visas.');
DEFINE ('_UE_ALLOWUSERPROFILEBANNING_DESC','Tillåt moderatorerna att förhindra att en användarprofil visas offentligt.');
DEFINE ('_UE_ALLOWUSERPROFILEBANNING','Tillåt uteslutning av användare');

//Admin Registration tab labels
DEFINE('_UE_NAME_FORMAT','Namnformat');
DEFINE('_UE_DATE_FORMAT','Datumformat');
DEFINE('_UE_NAME_FORMAT_DESC','Välj vilket format du vill att fälten Namn-/Användarnamn skall visas.');
DEFINE('_UE_DATE_FORMAT_DESC','Välj vilket datumformat du vill att datumet skall visas.');
DEFINE ('_UE_REG_CONFIRMATION_DESC','Sätt till ja för att skicka e-post med en länk för att bekräfta registrering till användare.');
DEFINE ('_UE_REG_CONFIRMATION','Kräver bekräftelse via e-post');
DEFINE ('_UE_REG_ADMIN_APPROVAL','Kräver administratörens godkännande');
DEFINE ('_UE_REG_ADMIN_APPROVAL_DESC','Kräver att all användarregistrering skall godkännas av en administratör');
DEFINE ('_UE_REG_EMAIL_NAME','E-postämne vid registrering');
DEFINE ('_UE_REG_EMAIL_NAME_DESC','Ange ämnet när du sänder e-post');
DEFINE ('_UE_REG_EMAIL_FROM','E-postadress vid registrering');
DEFINE ('_UE_REG_EMAIL_FROM_DESC','E-postadress som de som registrerar sig ser som avsändare');
DEFINE ('_UE_REG_EMAIL_REPLYTO','E-postadress för registreringssvar');
DEFINE ('_UE_REG_EMAIL_REPLYTO_DESC','E-postadress dit svar på registreringar skickas');
DEFINE ('_UE_REG_PEND_APPR_MSG','Kvittens på mottagen ansökan');
DEFINE ('_UE_REG_WELCOME_MSG','Välkomstbrev per e-post');
DEFINE ('_UE_REG_REJECT_MSG','E-brev vid avslagen ansökan');
DEFINE ('_UE_REG_PEND_APPR_SUB','Ämne för kvittensmeddelande');
DEFINE ('_UE_REG_WELCOME_SUB','Ämne för välkomstmeddelande');
DEFINE ('_UE_REG_PEND_APPR_SUB_DESC','Ämne för kvittens på mottagen ansökan');
DEFINE ('_UE_REG_WELCOME_SUB_DESC','Ämne för välkomstmeddelande');
DEFINE ('_UE_REG_REJECT_SUB_DESC','Ämne för avslagen ansökan');
DEFINE ('_UE_REG_SIGNATURE','E-postsignatur');
DEFINE ('_UE_REG_ADMIN_PA_SUB','Behandling av ansökan! Ny ansökan om registrering är mottagen');
DEFINE ('_UE_REG_ADMIN_PA_MSG','En ny användare har registrerat sig på [SITEURL] och önskar godkännande.\n'
.'Detta e-brev innehåller deras uppgifter\n\n'
.'Namn - [NAME]\n'
.'E-post - [EMAILADDRESS]\n'
.'Användarnamn - [USERNAME]\n\n\n'
.'Var vänlig och svara inte på detta meddelandet eftersom det är automatgenererat och endast är avsett som information\n');
DEFINE ('_UE_REG_ADMIN_SUB','Registrering av ny användare');
DEFINE ('_UE_REG_ADMIN_MSG','En ny användare har registrerat sig på [SITEURL].\n'
.'Detta mail innehåller deras uppgifter\n\n'
.'Namn - [NAME]\n'
.'E-post - [EMAILADDRESS]\n'
.'Användarnamn - [USERNAME]\n\n\n'
.'Var vänlig och svara inte på detta meddelandet eftersom det är automatgenererat och endast är avsett som information\n');
DEFINE('_UE_REG_EMAIL_TAGS','[NAME] - Namnet på användaren<br />'
.'[USERNAME] - Användarnamn<br />'
.'[DETAILS] - Kontouppgifter på användaren som exvis e-postadress, användarnamn, och lösenord<br />'
.'[CONFIRM] - Sätter in länk för bekräftelse om bekräftelsefunktionen är påslagen<br />');

//Registration form
DEFINE('_UE_REG_COMPLETE_NOPASS','<span class="componentheading">Registreringen slutförd!</span><br />&nbsp;&nbsp;'
.'Ditt lösenord har skickats till den e-postadress du angett.<br />&nbsp;&nbsp;'
.'När du har fått ditt lösenord kan du logga in.');
DEFINE('_UE_REG_COMPLETE','<span class="componentheading">Registrering slutförd!</span><br />&nbsp;&nbsp;'
.'Du kan nu logga in.<br />&nbsp;&nbsp;');
DEFINE('_UE_REG_COMPLETE_NOPASS_NOAPPR','<span class="componentheading">Registrering utförd!</span><br />&nbsp;&nbsp;'
.'Din registrering kräver godkännande.  När den har blivit godkänd kommer ditt lösenord att skickas till den e-postadress du angivit.<br />&nbsp;&nbsp;'
.'När du erhåller godkännandet och lösenordet kan du logga in.');
DEFINE('_UE_REG_COMPLETE_NOAPPR','<span class="componentheading">Registrering utförd!</span><br />&nbsp;&nbsp;'
.'Din registrering kräver godkännande.  När den blivit godkänd kommer du att få ett meddelande om detta till den e-postadress du angivit.<br />&nbsp;&nbsp;'
.'När du får godkännandet kan du logga in.');
DEFINE('_UE_REG_COMPLETE_CONF','<span class="componentheading">Registrering utförd!</span><br />&nbsp;&nbsp;'
.'Ett e-brev med ytterligare instruktioner om hur du fullföljer din registrering har skickats till den e-postadress du angivit.  Var vänlig och kontrollera din inbox för att fullfölja din registrering.<br />&nbsp;&nbsp;');
DEFINE('_UE_REG_COMPLETE_NOPASS_CONF','<span class="componentheading">Registrering utförd!</span><br />&nbsp;&nbsp;'
.'Ditt lösenord har skickats till den e-postadress som du angivit.<br />&nbsp;&nbsp;'
.'När du erhållit ditt lösenord och följt instruktionerna för bekräftelse i e-brevet så kommer du att kunna logga in.');

// User List Labels
DEFINE ('_UE_HAS','har');
DEFINE ('_UE_USERS','registrerade användare');
DEFINE ('_UE_SEARCH_ALERT','Var vänlig och skriv in ett värde att söka efter!');
DEFINE ('_UE_SEARCH','Sök användare');
DEFINE ('_UE_ENTER_EMAIL','Skriv in användarens e-postadress, namn eller användarnamn');
DEFINE ('_UE_SEARCH_BUTTON','Sök');
DEFINE ('_UE_SHOW_ALL','Visa alla användare');
DEFINE ('_UE_NAME','Namn');
DEFINE ('_UE_UL_USERNAME','Användarnamn');
DEFINE ('_UE_USERTYPE','Typ av användare');
DEFINE ('_UE_VIEWPROFILE','Visa profil');
DEFINE ('_UE_LIST_ALL','Lista alla');
DEFINE ('_UE_PAGE','Sida');
DEFINE ('_UE_RESULTS','Resultat');
DEFINE ('_UE_OF_TOTAL','av totalt');
DEFINE ('_UE_NO_RESULTS','Inga resultat');
DEFINE ('_UE_FIRST_PAGE','första sidan');
DEFINE ('_UE_PREV_PAGE','föregående sida');
DEFINE ('_UE_NEXT_PAGE','nästa sida');
DEFINE ('_UE_END_PAGE','sista sidan');
DEFINE('_UE_CONTACT','Kontakt');
DEFINE('_UE_INSTANT_MESSAGE','Snabbmeddelande');
DEFINE('_UE_IMAGEAVAILABLE','Bild');
DEFINE('_UE_INFO','Info');
DEFINE('_UE_PROFILE','Profil');
DEFINE('_UE_PRIVATE_MESSAGE','PM');
DEFINE('_UE_ADDITIONAL','Övrig information');
DEFINE('_UE_NO_DATA','Finns ej');
DEFINE('_UE_CLICKTOVIEW','Klicka för');
DEFINE('_UE_UL_USERNAME_NAME','Användarnamn(Namn)');
DEFINE('_UE_PM','PM');
DEFINE('UE_PM_USER','Skicka privat meddelande');

//mod_userextraslogin
DEFINE('_UE_NO_ACCOUNT','Inget konto än?');
DEFINE('_UE_CREATE_ACCOUNT','Skapa ett');
DEFINE('_LOGIN_NOT_CONFIRMED','Din registrering är inte komplett ännu! Var vänlig och kontrollera din e-post för ytterligare instruktioner.');
DEFINE('_LOGIN_NOT_APPROVED','Ditt konto har ännu inte blivit godkänt!');
DEFINE('_UE_USER_CONFIRMED','Ditt konto är nu aktiverat. Du kan nu logga in!');
DEFINE('_UE_USER_NOTCONFIRMED','Ditt konto är ännu inte aktiverat.  Var vänlig kontrollera din e-post och följ instruktionerna för att fullfölja registreringsprocessen.');


//Avatar
DEFINE('_UE_UPLOAD_UPLOAD','Uppladdning');
DEFINE('_UE_UPLOAD_DIMENSIONS','Din bild kan maximalt vara (bredd x höjd - storlek)');
DEFINE('_UE_UPLOAD_SUBMIT','Välj ett nytt bild för uppladdning');
DEFINE('_UE_UPLOAD_SELECT_FILE','Välj fil');
DEFINE('_UE_UPLOAD_ERROR_TYPE','Var vänlig och använd endast jpeg, jpg eller png bilder');
DEFINE('_UE_UPLOAD_ERROR_EMPTY','Var vänlig och välj en fil för uppladdning');
DEFINE('_UE_UPLOAD_ERROR_NAME','Filnamnet på bilden får endast innehålla alfanumeriska tecken och inga mellanslag.');
DEFINE('_UE_UPLOAD_ERROR_SIZE','Storleken på bilden överskrider den maximalt tillåtna.');
DEFINE('_UE_UPLOAD_ERROR_WIDTHHEIGHT','Bildens höjd eller bredd överskrider det maximalt tillåtna.');
DEFINE('_UE_UPLOAD_ERROR_WIDTH','Bildens bredd överskrider det maximalt tillåtna.');
DEFINE('_UE_UPLOAD_ERROR_HEIGHT','Bildens höjd överskrider det maximalt tillåtna.');
DEFINE('_UE_UPLOAD_ERROR_CHOOSE',"Du valde inte en bild från galleriet..");
DEFINE('_UE_UPLOAD_UPLOADED','Din bild har blivit uppladdad.');
DEFINE('_UE_UPLOAD_GALLERY','Välj en bild från bildgalleriet');
DEFINE('_UE_UPLOAD_CHOOSE','Bekräfta ditt val.');
DEFINE('_UE_UPLOAD_UPDATED','Ditt bildval har bekräftats.');
DEFINE('_UE_USER_PROFILE_NOT','Din profil kunde inte uppdateras.');
DEFINE('_UE_USER_PROFILE_UPDATED','Din profil är uppdaterad.');
DEFINE('_UE_USER_RETURN_A','Om du inte förflyttas till din profil om några ögonblick ');
DEFINE('_UE_USER_RETURN_B','tryck här');
//DEFINE('_UPDATE','UPPDATERA');

//Moderator
DEFINE('_UE_USERPROFILEBANNED','Denna profil har blivit utesluten av en moderator.');
DEFINE('_UE_REQUESTUNBANPROFILE','Överklaga uteslutning');
DEFINE('_UE_REPORTUSER','Rapportera användare');
DEFINE('_UE_BANPROFILE','Uteslut profil');
DEFINE('_UE_UNBANPROFILE','Ta tillbaka utesluten profil');
DEFINE('_UE_REPORTUSER_TITLE','Rapportera användare');
DEFINE('_UE_USERREASON','Orsak till rapporten');
DEFINE('_UE_BANREASON','Orsak till uteslutning');
DEFINE('_UE_SUBMITFORM','Skicka');
DEFINE('_UE_NOUNBANREQUESTS','Ingen överklagan att behandla');
DEFINE('_UE_IMAGE_MODERATE','Moderera Bilder');
DEFINE('_UE_APPROVE_IMAGES','Godkänn');
DEFINE('_UE_REJECT_IMAGES','AVSLÅ');
DEFINE('_UE_MODERATE_TITLE','Moderator');
DEFINE('_UE_NOIMAGESTOAPPROVE','Inga bilder att behandla');
DEFINE('_UE_USERREPORT_MODERATE','Moderera användarrapporter');
DEFINE('_UE_REPORT','Rapportera');
DEFINE('_UE_REPORTEDONDATE','Rapportdatum');
DEFINE('_UE_REPORTEDUSER','Rapporterad användare');
DEFINE('_UE_REPORTEDBY','Rapporterad av');
DEFINE('_UE_PROCESSUSERREPORT','Behandla');
DEFINE('_UE_NONEWUSERREPORTS','Inga nya användarrapporter');
DEFINE('_UE_USERUNBAN_SUCCESSFUL','Borttagning av uteslutning genomförd.');
DEFINE('_UE_REPORTUSERSACTIVITY','Beskriv användaraktivitet');
DEFINE('_UE_USERREPORT_SUCCESSFUL','Användarrapport inskickad.');
DEFINE('_UE_USERBAN_SUCCESSFUL','Uteslutning av profil genomförd.');
DEFINE('_UE_FUNCTIONALITY_DISABLED','Denna funktion är för tillfället ej i bruk.');
DEFINE('_UE_UPLOAD_PEND_APPROVAL','Din bild väntar nu på moderatorns godkännande.');
DEFINE('_UE_UPLOAD_SUCCESSFUL','Din bild är uppladdad.');
DEFINE('_UE_UNBANREQUEST','Önskan om överklagande av uteslutning');
DEFINE('_UE_USERUNBANREQUEST_SUCCESSFUL','Din överklagan av uteslutning är inskickad.');
DEFINE('_UE_USERREPORT','Användarrapporter');
DEFINE('_UE_VIEWUSERREPORTS','Visa användarrapporter');
DEFINE('_UE_USERREQUESTRESPONSE','Visa användarrapporter');
DEFINE('_UE_MODERATORREQUESTRESPONSE','Visa användarrapporter');
DEFINE('_UE_REPORTBAN_TITLE','Rapport om uteslutning');
DEFINE('_UE_REPORTUNBAN_TITLE','Rapport om uteslutning');

DEFINE('_UE_UNBANREQUIREACTION',' Överklagande(n)');
DEFINE('_UE_USERREPORTSREQUIREACTION','Användarrapport(er)');
DEFINE('_UE_IMAGESREQUIREACTION','Bild(er)');
DEFINE('_UE_NOACTIONREQUIRED','Inga väntande beslut');

DEFINE('_UE_UNBAN_MODERATE','Överklagan av uteslutning');
DEFINE('_UE_BANNEDUSER','Utesluten användare');
DEFINE('_UE_BANNEDREASON','Orsak till uteslutning');
DEFINE('_UE_BANNEDON','Datum för uteslutning');
DEFINE('_UE_BANNEDBY','Utesluten av');

DEFINE('_UE_MODERATORBANRESPONSE','Moderatorns svar');
DEFINE('_UE_USERBANRESPONSE','Användarens svar');

DEFINE('_UE_IMAGE_ADMIN_SUB','Bild väntar på godkännande');
DEFINE('_UE_IMAGE_ADMIN_MSG','En användare har laddat upp en bild för godkännade. Var vänlig och logga in och vidtag nödvändiga åtgärder.');
DEFINE('_UE_USERREPORT_SUB','Användarrapport väntar på granskning');
DEFINE('_UE_USERREPORT_MSG','En användare har skickat in en rapport om en annan användare som kräver din granskning.  Var vänlig och logga in och vidtag nödvändiga åtgärder.');
DEFINE('_UE_IMAGEAPPROVED_SUB','Din bild är godkänd');
DEFINE('_UE_IMAGEAPPROVED_MSG','Din bild har blivit godkänd av en moderator.');
DEFINE('_UE_IMAGEREJECTED_SUB','Bilden EJ godkänd');
DEFINE('_UE_IMAGEREJECTED_MSG','Din bild har ej blivit godkänd av en moderator.  Var vänlig och logga in och skicka in en ny bild.');
DEFINE('_UE_BANUSER_SUB','Användarprofil utesluten.');
DEFINE('_UE_BANUSER_MSG','Din användarprofil blev utesluten av en moderator.  Var vänlig och logga in och se efter vad orsaken till uteslutningen var.');
DEFINE('_UE_UNBANUSER_SUB','Användarprofil öppnad');
DEFINE('_UE_UNBANUSER_MSG','Din användarprofil är återigen godkänd.  Din profil kan nu ses av alla användare igen.');
DEFINE('_UE_UNBANUSERREQUEST_SUB','Överklagan av uteslutning kräver granskning');
DEFINE('_UE_UNBANUSERREQUEST_MSG','En användare har skickat in ett önskemål om överklagan av uteslutning.  Var vänlig och logga in och vidtag nödvändiga åtgärder.');


//Alpha 3 Build
DEFINE('_UE_IMAGE','Miniatyr');
DEFINE('_UE_FORMATNAME','Formaterat namn');

//Alpha 4 Build
DEFINE('_UE_ADMINREQUIREDFIELDS','Obligatoriska fält i Admin');
DEFINE('_UE_ADMINREQUIREDFIELDS_DESC','Ja så att administratörsdelen kräver samma inställningar för fält enligt inställningarna eller Nej så att inställningarna ignoreras för admin.');
DEFINE('_UE_CANCEL','Avbryt');
DEFINE('_UE_NA','N/A');
DEFINE('_UE_MODERATOREMAIL','Skicka e-post till moderatorer');
DEFINE('_UE_MODERATOREMAIL_DESC','Om Ja, så kommer moderatorerna att erhålla e-post när någon händelse inträffar som kräver deras uppmärksamhet.');

//Beta 1 Build
DEFINE('_UE_UPDATE','Uppdatera');

//Beta 2 Build
DEFINE('_UE_FIELDONPROFILE','Detta fält är synligt i profilen');
DEFINE('_UE_FIELDNOPROFILE','Detta fält är INTE synligt i profilen');
DEFINE('_UE_FIELDREQUIRED','Detta fält är obligatoriskt');
DEFINE('_UE_NOT_AUTHORIZED','Du har inte tillstånd att se denna sida!');
DEFINE('_UE_ALLOW_LISTVIEWBY','Tillåt tillgång till:');
DEFINE('_UE_ALLOW_LISTVIEWBY_DESC','Välj den grupp som du önskar skall kunna se listan.  Alla användare på vald nivå och uppåt kommer att ha tillgång.');
DEFINE('_UE_ALLOW_PROFILEVIEWBY','Tillåt tillgång för:');
DEFINE('_UE_ALLOW_PROFILEVIEWBY_DESC','Välj den grupp du vill skall kunna se profilerna.  Alla användare på vald nivå och uppåt kommer att ha tillgång.');

//Beta 3 Build
DEFINE('_UE_NOLISTFOUND','Det finns inga publicerade användarlistor!');
DEFINE('_UE_ALLOW_PROFILELINK','Tillåt länk till profil');
DEFINE('_UE_ALLOW_PROFILELINK_DESC','Välj Ja för att tillåta att varje rad länkas till kopplad användarprofil och Nej för att hindra länk till profil på listan.');
DEFINE('_UE_REGISTERFORPROFILE','Var vänlig och logga in eller registrera för att se eller ändra din profil.');
DEFINE('_UE_UPLOAD_ERROR_GDNOTINSTALLED','GD2 Image Library är inte installerad eller kompilerad med PHP!  Var vänlig och meddela systemadministratören för att ta bort funktionen för den automatiska bildstorleken.');
DEFINE('_UE_UPLOAD_ERROR_UPLOADFAILED','Ett fel uppstod vid uppladdningen eller bearbetningen av bilden!');
DEFINE('_UE_TOC','Acceptera användarvillkor');
DEFINE('_UE_TOC_REQUIRED','Du måste acceptera användarvillkoren före registrering!');
DEFINE('_UE_REG_TOC_MSG','Använd användarvillkor');
DEFINE('_UE_REG_TOC_DESC','Välj Ja för att kräva av användarna att de måste acceptera dina användarvillkor före registrering!');
DEFINE('_UE_REG_TOC_URL_MSG','URL till användarvillkor');
DEFINE('_UE_REG_TOC_URL_DESC','Skriv in URL till dina användarvillkor.');
DEFINE('_UE_LASTUPDATEDON','Senast uppdaterad');

//Beta 4 Build
DEFINE('_UE_EMAILFORMWARNING','OBS! Om du fortsätter kommer din e-postadress att bli synlig för användaren som du skickar till.');
DEFINE('_UE_EMAILFORMSUBJECT','Ämne:');
DEFINE('_UE_EMAILFORMMESSAGE','Meddelande:');
DEFINE('_UE_EMAILFORMINSTRUCT','Sänd meddelande via e-post till <a href="index.php?option=com_cbe&task=UserDetails&user=%s">%s </a>.');
DEFINE('_UE_GENERAL','Generell');
DEFINE('_UE_SENDEMAILNOTICE','OBS! Detta är ett meddelande från %s hos %s ( %s ).  Denna användaren såg inte din e-postadress vid sändningen. Om du svarar kommer mottagaren att se din e-postadress.  %s ägare åtar sig inte något som helst ansvar för innehållet i e-brevet.');
DEFINE('_UE_SENDEMAIL','Skicka e-post');
DEFINE('_UE_SENTEMAILSUCCESS','Ditt e-brev är skickat!');
DEFINE('_UE_SENTEMAILFAILED','Det gick inte att skicka ditt e-brev!  Var vänlig och försök igen.');
DEFINE('_UE_ALLOW_EMAIL_DISPLAY','E-posthantering');
DEFINE('_UE_REGISTERDATE','Datum registrerat');
DEFINE('_UE_ACTION','Åtgärd');
DEFINE('_UE_USER','Användare');
DEFINE('_UE_USERAPPROVAL_MODERATE','Användargodkännande/avslag');
DEFINE('_UE_USERPENDAPPRACTION',' Användare');
DEFINE('_UE_APPROVEUSER','Behandla användare');
DEFINE('_UE_REG_REJECT_SUB','Din registrering har blivit avslagen!');
DEFINE('_UE_USERREJECT_MSG','Din registrering hos %s har  blivit avslagen på följande grunder: \n %s');
DEFINE('_UE_COMMENT','Kommentar på avslag');
DEFINE('_UE_APPROVE','Godkänn');
DEFINE('_UE_REJECT','Avslå');
DEFINE('_UE_USERREJECT_SUCCESSFUL','Användaren har fått avslag!');
DEFINE('_UE_USERAPPROVE_SUCCESSFUL','Användaren har blivit godkänd!');
DEFINE('_LOGIN_REJECTED','Din ansökan om registrering har blivit avslagen!');
DEFINE('_UE_EMAILFOOTER','OBS! Detta e-brev var automatsikt genererat av %s (%s).');
DEFINE('_UE_MODERATORUSERAPPOVAL','Moderatorer kan godkänna användare');
DEFINE('_UE_MODERATORUSERAPPOVAL_DESC','Denna inställning tillåter moderatorer att godkänna ansökan via hemsidan.');
DEFINE('_UE_REG_COMPLETE_NOAPPR_CONF','<span class="componentheading">Registrering genomförd!</span><br />&nbsp;&nbsp;'
.'Din ansökan kräver godkännande och e-postkonfirmering. Var vänlig och följ stegen som är skickat till dig i ett e-brev.  När du blivit godkänd kommer du att få ett meddelande till den e-postadress du uppgivit.<br />&nbsp;&nbsp;'
.'När du fått godkännandet kan du logga in.');
DEFINE('_UE_REG_COMPLETE_NOPASS_NOAPPR_CONF','<span class="componentheading">Registrering genomförd!</span><br />&nbsp;&nbsp;'
.'Din ansökan kräver godkännande och e-postkonfirmering. Var vänlig och följ stegen som är skickat till dig i ett e-brev. <br />&nbsp;&nbsp;'
.'När du fått godkännandet så kommer ett lösenord att skickas till dig i ett e-brev du kommer därefter att kunna logga in.');
DEFINE('_UE_NAME_STYLE','Utseende på namnen');
DEFINE('_UE_NAME_STYLE_DESC','Utseende på namnen bestämmer hur du vill fånga namnfälten i mambo.');
DEFINE('_UE_USER_CONFIRMED_NEEDAPPR','Tack för att du bekräftat din e-postadress.  Ditt konto kräver också godkännande av en moderator.  Du kommer att få ett e-post som ger dig besked om beslutet.');
DEFINE('_UE_YOUR_FNAME','Förnamn');   
DEFINE('_UE_YOUR_MNAME','Mellannamn');
DEFINE('_UE_YOUR_LNAME','Efternamn');

//RC 1 Build
DEFINE('_UE_NOSELFEMAIL','Du kan inte skicka e-post till dig själv');
DEFINE('_UE_PROFILETAB','Profil');
DEFINE('_UE_AUTHORTAB','Inlägg');
DEFINE('_UE_FORUMTAB','Forum');
DEFINE('_UE_BLOGTAB','Blog');
DEFINE('_UE_ARTICLEDATE','Datum');
DEFINE('_UE_ARTICLETITLE','Titel');
DEFINE('_UE_ARTICLERATING','Ranking');
DEFINE('_UE_ARTICLEHITS','Träffar');
DEFINE('_UE_FORUMDATE','Datum');
DEFINE('_UE_FORUMCATEGORY','Kategori');
DEFINE('_UE_FORUMSUBJECT','Ämne');
DEFINE('_UE_FORUMHITS','Träffar');
DEFINE('_UE_FORUM_TOP10','De 10 senaste inläggen i forumet');
DEFINE('_UE_FORUM_STATS','Forumstatistik');
DEFINE('_RANK_MODERATOR','Moderator');
DEFINE('_RANK_ADMINISTRATOR','Administratör');
DEFINE('_UE_SBNOTINSTALLED','Komponenten för Simpleboard forum är inte installerad. Kontakta din administratör.');
DEFINE('_UE_NOFORUMPOSTS','Denna användare har gjort något inlägg.');
DEFINE('_UE_NESTTABS','Samla flikar');
DEFINE('_UE_NESTTABS_DESC','Samla alla flikar under en profilsida vilket är mycket användbart vid ett stort antal flikar.');
DEFINE('_UE_TEMPLATEDIR','Mall för flikar');
DEFINE('_UE_TEMPLATEDIR_DESC','Välj en mall för alla flikar inom hela Community Builder.');
DEFINE('_UE_MAMBLOGNOTINSTALLED','Komponenten  för Mamblog blogger är inte installerad. Kontakta din administratör.');
DEFINE('_UE_BLOGDATE','Datum');
DEFINE('_UE_BLOGTITLE','Titel');
DEFINE('_UE_BLOGHITS','Träffar');
DEFINE('_UE_NOBLOGS','Denna användare har inga publicerade bloggar.');
DEFINE('_UE_NOARTICLES','Denna användare har inga publicerade inlägg.');
DEFINE('_UE_IMPATH','Sökväg till ImageMagick');
DEFINE('_UE_IMPATH_DESC','Sökväg till ImageMagick');
DEFINE('_UE_NETPBMPATH','Sökväg till NetPBM');
DEFINE('_UE_NETPBMPATH_DESC','Sökväg till NetPBM');
DEFINE('_UE_AUTODET','Automatiskt detekterad');
DEFINE('_UE_ERROR_NOTINSTALLED','Ej installerad');
DEFINE('_UE_CONVERSIONTYPE','Mjukvara för bildhantering');
DEFINE('_UE_NEWPASS_FAILED','Återställning av lösenord misslyckades!');
DEFINE('_UE_USER_SUBSCRIPTIONS','Dina prenumerationer');
DEFINE('_UE_THREAD_UNSUBSCRIBE',':: Avsluta prenumeration ::');
DEFINE('_UE_USER_NOSUBSCRIPTIONS','Du har inga prenumerationer');
DEFINE('_UE_GEN_BY','av');
DEFINE('_UE_USER_UNSUBSCRIBE_ALL','Avsluta prenumerationer för alla');
DEFINE('_UE_USERREPORTMODERATED_SUCCESSFUL','Användarrapport modererad!');
DEFINE('_UE_USERIMAGEMODERATED_SUCCESSFUL','Användarbild modererad!');
DEFINE('_UE_NOREPORTSTOPROCESS','Inga användarraporter att bearbeta');
DEFINE('_UE_NOUSERSPENDING','Inga väntande beslut');
DEFINE('_UE_BLANK','');
DEFINE('_UE_REG_FIRST_VISIT_URL_MSG','URL som startsida efter inloggning');
DEFINE('_UE_REG_FIRST_VISIT_URL_DESC','Skriv in URL som visas efter den allra första
inloggningen efter registrering. Denna sida kan innehålla ett välkomstmeddelande till nya
medlemmar och eller en speciell instruktion eller omdirigering till användarens profil. Lämna
tomt för normal inloggning första gången.');

//SB Integration Support
DEFINE('_UE_SB_TABTITLE','Inställningar för forum');
DEFINE('_UE_SB_TABDESC','Detta är dina inställningar för forum');
DEFINE('_UE_SB_VIEWTYPE_TITLE','Föredraget visningssätt');
DEFINE('_UE_SB_VIEWTYPE_FLAT','Flat');
DEFINE('_UE_SB_VIEWTYPE_THREADED','Trådad');
DEFINE('_UE_SB_ORDERING_TITLE','Föredragen sortering av inlägg');
DEFINE('_UE_SB_ORDERING_OLDEST','Äldsta inlägget först');
DEFINE('_UE_SB_ORDERING_LATEST','Senaste inlägget först');
DEFINE('_UE_SB_SIGNATURE','Signatur');
//added for SB 1.5 during 1.0 RC 1
DEFINE('_UE_SB_POSTSPERPAGE','Inlägg per sida'); 
DEFINE('_UE_SB_USERTIMEOFFSET','Lokal tidsförskjutning i förhållande till servern');

//Not used within application but are needed to translate default images for profile.
DEFINE('_UE_IMG_NOIMG','Ingen bild');
DEFINE('_UE_IMG_PENDIMG','Väntar på godkännande');


?>