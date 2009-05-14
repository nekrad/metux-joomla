<?php
//************************************************************************
// Mambo Enhanced Tools for CB                                           *
// http://mambome.com                                                    *
// Copyright (C) Jeffrey Randall 2005.                                   *
// Released under GNU/GPL License										 *
// http://www.gnu.org/copyleft/gpl.html 								 *
// Released : 23-05-2005                                                 *
// Version 1.0                                                           *
//************************************************************************

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
$user = & JFactory::getUser();

/*
if (!$user->authorize( 'com_cbe', 'manage' )) {
	$mainframe->redirect( 'index.php', JText::_('ALERTNOTAUTH') );
}
/*
if (!$acl->acl_check( 'administration', 'manage', 'users', $my->usertype, 'components', 'com_users' )) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}
*/

function cbe_switch_func($func=null) {
	switch ($func)
	{
		case "loadCountries":
		loadCountries();
		break;

		case "loadUSstates":
		loadUSstates();
		break;

		case "syncSearchTable":
		syncSearchTable();
		break;

		case "reasignFields":
		reasignFields();
		break;

		case "loadSimpleBoardSettings":
		loadSimpleBoardSettings();
		break;

		case "loadProfileColors":
		loadProfileColors();
		break;

		case "loadDEstates":
		loadDEstates();
		break;

		case "createLastVisitors":
		createLastVisitors();
		break;

		case "clearLastVisitors":
		clearLastVisitors();
		break;
		
		case "createTopVoteFields":
		createTopVoteFields();
		break;

		case "createZodiacFields":
		createZodiacFields();
		break;

		case "publishZodiacFields":
		publishZodiacFields();
		break;

		case "showsyncUsersJoomla":
		showsyncUsersJoomla();
		break;

		case "syncUsersJoomla":
		syncUsersJoomla();
		break;
		
		case "NewLastVisitor":
		checkNewLastVisitor();
		break;
		
		case "WatermarkAllAvatars":
		doWatermarkAllAvatars();
		break;
		
		case "GeocoderUserMapGen":
		doGeocoderUserMapGenXML();
		break;

		case "GalleryCBEDB":
		doGalleryCBEDB();
		break;

		case "GalleryCBEadm":
		doGalleryCBEadm();
		break;
		
		case "backupDB":
		createBackupDB();
		break;
		
		case "backup":
		doCBEBackupRestore($option, $task, $func, $pathtoadmin, $config);		// func=emtpy, backup, restore
		break;
		
		case "restore":
		doCBEBackupRestore($option, $task, $func, $pathtoadmin, $config);		// func=emtpy, backup, restore
		break;
		
		case "backupenh":
		doCBEBackupRestoreEnh($option, $task, $func, $pathtoadmin, $config);		// func=emtpy, backup, restore
		break;
		
		case "restoreenh":
		doCBEBackupRestoreEnh($option, $task, $func, $pathtoadmin, $config);		// func=emtpy, backup, restore
		break;
	}
}

function loadUSstates()
{
	//************************************************************************
	// Mambo Me US States For CB                                             *
	// http://mambome.com                                                    *
	// Copyright (C) Jeffrey Randall 2005.                                   *
	// Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html *
	// Released : 22-04-2005                                                 *
	// Version 1.0                                                           *
	//************************************************************************

	$database = &JFactory::getDBO();

	$state = "us_state";  //Set the name of the state field
	$stateTitle = "State"; //Set the title of the state field, this is what users will see

	$tabid ="2"; //leave as default

	$database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE title='_UE_CONTACT_INFO_HEADER'");
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$tabid=$database->loadResult();

	$database->setQuery("SELECT fieldid FROM #__cbe_fields WHERE name='".$state."'");
        $usa_result = $database->loadResult();
        if ($usa_result != '') {
                echo '<font color="red">US-State field already exists</font><br/>';
                echo "<script> alert('US-State field already exists!'); window.history.go(-1); </script>\n";
                exit();
        } else {
		$database->setQuery("INSERT INTO #__cbe_fields SET name='".$state."', title='".$stateTitle."', type='select', ordering='1', published='1', profile='1', calculated='0', sys='0',tabid=$tabid");
	
		if(!$database->query())
		echo '<font color="red">Failed inserting state field to cbe_fields</font><br/>';
		else
		echo '<font color="green">Successfully inserted state field to cbe_fields</font><br/>';
	
		$database->setQuery("SELECT fieldid FROM #__cbe_fields WHERE name='".$state."'");
		$fieldid=$database->loadResult();
	
		if(!$database->query())
		echo '<font color="red">Failed getting field id</font><br/>';
		else
		echo '<font color="green">Successfully retrieved field id</font><br/>';
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Alabama', ordering='1'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Alaska', ordering='2'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Arizona', ordering='3'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Arkansas', ordering='4'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='California', ordering='5'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Colorado', ordering='6'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Connecticut', ordering='7'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Delaware', ordering='8'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Florida', ordering='9'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Georgia', ordering='10'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Hawaii', ordering='11'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Idaho', ordering='12'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Illinois', ordering='13'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Indiana', ordering='14'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Iowa', ordering='15'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Kansas', ordering='16'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Kentucky', ordering='17'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Louisiana', ordering='18'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Maine', ordering='19'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Maryland', ordering='20'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Massachusetts', ordering='21'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Michigan', ordering='22'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Minnesota', ordering='23'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Mississippi', ordering='24'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Missouri', ordering='25'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Montana', ordering='26'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Nebraska', ordering='27'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Nevada', ordering='28'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='New Hampshire', ordering='29'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='New Jersey', ordering='30'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='New Mexico', ordering='31'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='New York', ordering='32'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='North Carolina', ordering='33'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='North Dakota', ordering='34'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Ohio', ordering='35'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Oklahoma', ordering='36'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Oregon', ordering='37'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Pennsylvania', ordering='38'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Rhode Island', ordering='39'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='South Carolina', ordering='40'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='South Dakota', ordering='41'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Tennessee', ordering='42'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Texas', ordering='43'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Utah', ordering='44'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Vermont', ordering='45'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Virginia', ordering='46'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Washington', ordering='47'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Washington DC', ordering='48'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='West Virginia', ordering='49'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Wisconsin', ordering='50'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Wyoming', ordering='51'");
	
		if(!$database->query())
		echo '<font color="red">Failed storing states,</font><br/>';
		else
		echo '<font color="green">Successfully added state list to field values</font><br/>';
	
		$database->setQuery("ALTER TABLE #__cbe ADD $state varchar(255)");
	
		if(!$database->query())
		echo '<font color="red">Failed altering table</font><br/>';
		else
		echo '<font color="green">Successfully altered cbe table</font><br/><br/>';
	
		echo "<a href=\"http://MamboMe.com\">http://MamboMe.com</a><br/>";
		echo '<font color="blue">Hey Mambo! MamboMe!';
	} // end else
}

function loadCountries()
{

	//************************************************************************
	// Mambo Me Countries For CB                                             *
	// http://mambome.com                                                    *
	// Copyright (C) Jeffrey Randall 2005.                                   *
	// Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html *
	// Released : 22-04-2005                                                 *
	// Version 1.0                                                           *
	//************************************************************************

	$database = &JFactory::getDBO();

	$country = "country_list";  //Set the name of the country field
	$countryTitle = "Country"; //Set the title of the country field, this is what users will see

	$tabid ="3"; //leave as default
	$database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE title='_UE_CONTACT_INFO_HEADER'");
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$tabid=$database->loadResult();

	$database->setQuery("SELECT fieldid FROM #__cbe_fields WHERE name='".$country."'");
        $usac_result = $database->loadResult();
        if ($usac_result != '') {
                echo '<font color="red">US-Country field already exists</font><br/>';
                echo "<script> alert('US-Country field already exists!'); window.history.go(-1); </script>\n";
                exit();
        } else {
		$database->setQuery("INSERT INTO #__cbe_fields SET name='".$country."', title='".$countryTitle."', type='select', ordering='1', published='1', profile='1', calculated='0', sys='0',tabid=$tabid");
	
		if(!$database->query()) {
			echo '<font color="red">Failed inserting country field to cbe_fields</font><br/>';
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		} else {
			echo '<font color="green">Successfully inserted country field to cbe_fields</font><br/>';
		}
	
		$database->setQuery("SELECT fieldid FROM #__cbe_fields WHERE name='".$country."'");
		$fieldid=$database->loadResult();
	
		if(!$database->query()) {
			echo '<font color="red">Failed getting field id<br/>';
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		} else {
			echo '<font color="green">Successfully retrieved field id</font><br/>';
		}
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Afghanistan', ordering='1'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Albania', ordering='2'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Algeria', ordering='3'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='American Samoa', ordering='4'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Andorra', ordering='5'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Angola', ordering='6'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Anguilla', ordering='7'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Antarctica', ordering='8'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Antigua and Barbuda', ordering='9'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Argentina', ordering='10'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Armenia', ordering='11'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Aruba', ordering='12'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Australia', ordering='13'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Austria', ordering='14'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Azerbaijan', ordering='15'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Bahamas', ordering='16'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Bahrain', ordering='17'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Bangladesh', ordering='18'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Barbados', ordering='19'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Belarus', ordering='20'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Belgium', ordering='21'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Belize', ordering='22'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Benin', ordering='23'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Bermuda', ordering='24'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Bhutan', ordering='25'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Bolivia', ordering='26'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Bosnia and Herzegowina', ordering='27'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Botswana', ordering='28'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Bouvet Island', ordering='29'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Brazil', ordering='30'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='British Indian Ocean Territory', ordering='31'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Brunei Darussalam', ordering='32'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Bulgaria', ordering='33'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Burkina Faso', ordering='34'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Burundi', ordering='35'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Cambodia', ordering='36'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Cameroon', ordering='37'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Canada', ordering='38'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Cape Verde', ordering='39'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Cayman Islands', ordering='40'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Central African Republic', ordering='41'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Chad', ordering='42'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Chile', ordering='43'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='China', ordering='44'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Christmas Island', ordering='45'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Cocos (Keeling) Islands', ordering='46'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Colombia', ordering='47'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Comoros', ordering='48'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Congo', ordering='49'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Cook Islands', ordering='50'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Costa Rica', ordering='51'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Cote D\'Ivoire', ordering='52'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Croatia', ordering='53'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Cuba', ordering='54'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Cyprus', ordering='55'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Czech Republic', ordering='56'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Denmark', ordering='57'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Djibouti', ordering='58'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Dominica', ordering='59'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Dominican Republic', ordering='60'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='East Timor', ordering='61'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Ecuador', ordering='62'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Egypt', ordering='63'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='El Salvador', ordering='64'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Equatorial Guinea', ordering='65'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Eritrea', ordering='66'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Estonia', ordering='67'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Ethiopia', ordering='68'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Falkland Islands (Malvinas)', ordering='69'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Faroe Islands', ordering='70'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Fiji', ordering='71'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Finland', ordering='72'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='France', ordering='73'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='France, Metropolitan', ordering='74'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='French Guiana', ordering='75'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='French Polynesia', ordering='76'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='French Southern Territories', ordering='77'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Gabon', ordering='78'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Gambia', ordering='79'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Georgia', ordering='80'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Germany', ordering='81'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Ghana', ordering='82'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Gibraltar', ordering='83'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Greece', ordering='84'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Greenland', ordering='85'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Grenada', ordering='86'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Guadeloupe', ordering='87'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Guam', ordering='88'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Guatemala', ordering='89'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Guinea', ordering='90'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Guinea-bissau', ordering='91'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Guyana', ordering='92'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Haiti', ordering='93'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Heard and Mc Donald Islands', ordering='94'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Honduras', ordering='95'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Hong Kong', ordering='96'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Hungary', ordering='97'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Iceland', ordering='98'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='India', ordering='99'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Indonesia', ordering='100'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Iran (Islamic Republic of)', ordering='101'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Iraq', ordering='102'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Ireland', ordering='103'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Israel', ordering='104'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Italy', ordering='105'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Jamaica', ordering='106'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Japan', ordering='107'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Jordan', ordering='108'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Kazakhstan', ordering='109'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Kenya', ordering='110'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Kiribati', ordering='111'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Korea, Democratic People\'s Republic of', ordering='112'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Korea, Republic of', ordering='113'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Kuwait', ordering='114'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Kyrgyzstan', ordering='115'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Lao People\'s Democratic Republic', ordering='116'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Latvia', ordering='117'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Lebanon', ordering='118'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Lesotho', ordering='119'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Liberia', ordering='120'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Libyan Arab Jamahiriya', ordering='121'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Liechtenstein', ordering='122'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Lithuania', ordering='123'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Luxembourg', ordering='124'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Macau', ordering='125'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Macedonia, The Former Yugoslav Republic of', ordering='126'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Madagascar', ordering='127'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Malawi', ordering='128'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Malaysia', ordering='129'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Maldives', ordering='130'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Mali', ordering='131'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Malta', ordering='132'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Marshall Islands', ordering='133'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Martinique', ordering='134'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Mauritania', ordering='135'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Mauritius', ordering='136'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Mayotte', ordering='137'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Mexico', ordering='138'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Micronesia, Federated States of', ordering='139'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Moldova, Republic of', ordering='140'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Monaco', ordering='141'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Mongolia', ordering='142'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Montserrat', ordering='143'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Morocco', ordering='144'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Mozambique', ordering='145'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Myanmar', ordering='146'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Namibia', ordering='147'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Nauru', ordering='148'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Nepal', ordering='1499'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Netherlands', ordering='150'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Netherlands Antilles', ordering='151'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='New Caledonia', ordering='152'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='New Zealand', ordering='153'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Nicaragua', ordering='154'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Niger', ordering='155'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Nigeria', ordering='156'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Niue', ordering='157'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Norfolk Island', ordering='158'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Northern Mariana Islands', ordering='159'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Norway', ordering='160'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Oman', ordering='161'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Pakistan', ordering='162'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Palau', ordering='163'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Panama', ordering='164'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Papua New Guinea', ordering='165'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Paraguay', ordering='166'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Peru', ordering='167'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Philippines', ordering='168'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Pitcairn', ordering='169'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Poland', ordering='170'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Portugal', ordering='171'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Puerto Rico', ordering='172'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Qatar', ordering='173'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Reunion', ordering='174'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Romania', ordering='175'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Russian Federation', ordering='176'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Rwanda', ordering='177'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Saint Kitts and Nevis', ordering='178'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Saint Lucia', ordering='9'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Saint Vincent and the Grenadines', ordering='179'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Samoa', ordering='180'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='San Marino', ordering='181'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Sao Tome and Principe', ordering='182'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Saudi Arabia', ordering='183'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Senegal', ordering='184'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Seychelles', ordering='185'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Sierra Leone', ordering='186'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Singapore', ordering='187'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Slovakia (Slovak Republic)', ordering='188'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Slovenia', ordering='189'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Solomon Islands', ordering='190'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Somalia', ordering='191'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='South Africa', ordering='192'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='South Georgia and the South Sandwich Islands', ordering='193'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Spain', ordering='194'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Sri Lanka', ordering='195'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='St. Helena', ordering='196'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='St. Pierre and Miquelon', ordering='197'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Sudan', ordering='198'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Suriname', ordering='199'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Svalbard and Jan Mayen Islands', ordering='200'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Swaziland', ordering='201'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Sweden', ordering='202'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Switzerland', ordering='203'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Syrian Arab Republic', ordering='204'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Taiwan', ordering='205'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Tajikistan', ordering='206'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Tanzania, United Republic of', ordering='207'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Thailand', ordering='208'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Togo', ordering='209'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Tokelau', ordering='210'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Tonga', ordering='211'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Trinidad and Tobago', ordering='212'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Tunisia', ordering='213'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Turkey', ordering='214'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Turkmenistan', ordering='215'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Turks and Caicos Islands', ordering='216'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Tuvalu', ordering='217'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Uganda', ordering='218'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Ukraine', ordering='219'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='United Arab Emirates', ordering='220'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='United Kingdom', ordering='221'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='United States', ordering='221'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='United States Minor Outlying Islands', ordering='222'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Uruguay', ordering='223'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Uzbekistan', ordering='224'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Vanuatu', ordering='225'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Vatican City State (Holy See)', ordering='226'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Venezuela', ordering='227'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Viet Nam', ordering='228'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Virgin Islands (British)', ordering='229'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Virgin Islands (U.S.)', ordering='230'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Wallis and Futuna Islands', ordering='231'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Western Sahara', ordering='232'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Yemen', ordering='233'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Yugoslavia', ordering='234'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Zaire', ordering='235'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Zambia', ordering='236'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='Zimbabwe', ordering='237'");$database->query();
	
		if(!$database->query()) {
			echo '<font color="red">Failed storing countries</font><br/>';
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		} else {
			echo '<font color="green">Successfully added country list to field values</font><br/>';
		}
	
		$database->setQuery("ALTER TABLE #__cbe ADD $country varchar(255)");
		if(!$database->query()) {
			echo '<font color="red">Failed altering table</font><br/>';
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		} else {
			echo '<font color="green">Successfully altered cbe table</font><br/><br/>';
		}
	
		echo "<a href=\"http://MamboMe.com\">http://MamboMe.com</a><br/>";
		echo '<font color="blue">Hey Mambo! MamboMe!';
	} // end else
}

function syncSearchTable()
{

	global $my, $ueConfig;
	$database = &JFactory::getDBO();

	// get all fieldid's from #__cbe_searchmanager

	$sql='';
	$sql="TRUNCATE TABLE #__cbe_searchmanager";
	$database->setQuery($sql);
	if (!$database->query())
	{
		print("<font color=red>SQL error" . $database->stderr(true)."</font><br />");
	}
	else
	{
		echo "All rows have been deleted from the search manager table<br>";
		echo "......<br>";
	}

	$query_ordering = "SHOW FIELDS FROM #__cbe_searchmanager";
	$database->setQuery($query_ordering);
	$res_order = $database->loadAssocList();
	$res_order3 = $res_order[7];
	$res_order2 = $res_order[6];
	$res_order1 = $res_order[5];
	if ("ordering" != $res_order1['Field']) {
		$database->setQuery("ALTER TABLE #__cbe_searchmanager ADD ordering INT(11) DEFAULT '0' AFTER `advanced`");
		if (!$database->query()) {
			print("<font color=red>SQL error" . $database->stderr(true)."</font><br />");
		} else {
			echo "<font color=green>Search Manager Table enhanced by ordering!</font><br>";
		}
	} else {
		echo "<font color=green>Search Manager Table ordering-field checked!</font><br>";
	}
	
	if ("odering" == $res_order2['Field']) {
		$database->setQuery("ALTER TABLE `#__cbe_searchmanager` DROP `odering`");
		if(!$database->query()) {
			print("<font color=red>SQL error" . $database->stderr(true)."</font><br />");
		} else {
			echo "<font color=green>Search Manager Table cleaned from wrong field name!</font><br>";
		}
		if ("module" != $res_order3['Field']) {
			$database->setQuery("ALTER TABLE #__cbe_searchmanager ADD module TINYINT(1) DEFAULT '0' NOT NULL AFTER `ordering`");
			if (!$database->query()) {
				print("<font color=red>SQL error" . $database->stderr(true)."</font><br />");
			} else {
				echo "<font color=green>Search Manager Table enhanced by module option!</font><br>";
			}
		} else {
			echo "<font color=green>Search Manager Table module-field checked!</font><br>";
		}
	} else if ("module" != $res_order2['Field']) {
		$database->setQuery("ALTER TABLE #__cbe_searchmanager ADD module TINYINT(1) DEFAULT '0' NOT NULL AFTER `ordering`");
		if (!$database->query()) {
			print("<font color=red>SQL error" . $database->stderr(true)."</font><br />");
		} else {
			echo "<font color=green>Search Manager Table enhanced by module option!</font><br>";
		}
	} else {
		echo "<font color=green>Search Manager Table module-field checked!</font><br>";
	}

	$query='';
	$query="INSERT IGNORE INTO #__cbe_searchmanager(fieldid) "
	."SELECT fieldid FROM #__cbe_fields "
//	."WHERE sys='0' AND published='1'";
	."WHERE ((sys='0' AND published='1') OR (sys='1' AND published='1' AND (name LIKE 'zodiac%' OR name='name' OR name='username')))";
	$database->setQuery($query);
	if (!$database->query())
	{
		print("<font color=red>SQL error" . $database->stderr(true)."</font><br />");
	}
	else
	{
		echo "<font color=green>Mambo Search Manager Table has been reset and synchronized to Mambo Comprofiler Fields Table!</font><br>";
	}
	$query="SELECT id FROM #__cbe_searchmanager ORDER BY id ASC";
	$database->setQuery($query);
	$entries = $database->loadObjectList();
        $order=0;
        foreach($entries AS $entry) {
        	$database->setQuery("UPDATE #__cbe_searchmanager SET ordering = $order WHERE id='".$entry->id."'");
        	$database->query();
        	$order++;
        }
}

function loadSimpleBoardSettings()
{
	$database = &JFactory::getDBO();

	$database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE title='_UE_SB_TABTITLE'");
	$forum_tabid = $database->loadResult();
	if (count($forum_tabid) == '0') {
		$database->setQuery("SELECT max(ordering)+1 FROm #__cbe_tabs");
		$tab_max = $database->loadResult();
		$database->setQuery("INSERT INTO #__cbe_tabs SET title='_UE_SB_TABTITLE', description='_UE_SB_TABDESC', ordering='".$tab_max."'");
		if (!$database->query()) {
      			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
      			exit();
		}
		$database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE title='_UE_SB_TABTITLE'");
		$forum_tabid = $database->loadResult();
		if (count($forum_tabid) == '0') {
			echo "<font color=red>NO CBE TAB FOR JOOMLABOARD FOUND!</font><br>";
		}
	}

	//$database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE title='_UE_SB_FORUM_TAB_LABEL' AND enhanced_params LIKE '%sb_forum%'");
	//$forum_tabid = $database->loadResult();
	//if (count($forum_tabid) == '0') {
	//	echo "<font color=red>NO CBE TAB FOR JOOMLABOARD FOUND!</font><br>";
	//}
	
	//$database->setQuery("SELECT fieldid from #__cbe_fields WHERE title LIKE '_UE_SB_%'");
	$database->setQuery("SELECT fieldid from #__cbe_fields WHERE name='sbviewtype' OR name='sbordering' OR name='sbsignature'");
	$field_result = $database->loadObjectList();
	$field_count = count($field_result);
	if ($field_count > 0) {
		
			$query_check1 = "SHOW COLUMNS FROM #__cbe LIKE 'sbviewtype'";
			$database->setQuery($query_check1);
			$check1_result = $database->loadAssocList();
			$check1_result = $check1_result[0];
		
			$query_check2 = "SHOW COLUMNS FROM #__cbe LIKE 'sbordering'";
			$database->setQuery($query_check2);
			$check2_result = $database->loadAssocList();
			$check2_result = $check2_result[0];

			$query_check3 = "SHOW COLUMNS FROM #__cbe LIKE 'sbsignature'";
			$database->setQuery($query_check3);
			$check3_result = $database->loadAssocList();
			$check3_result = $check3_result[0];
		
			
			if ($check1_result[Field] != "" && $check2_result[Field] != "" && $check3_result[Field] != "") {
				echo "<font color=red>SB Forum Fields already exists!</font><br /><br />";
				exit();
			} else {
				$query = "ALTER TABLE #__cbe DROP `sbviewtype`";
				$query2 = "ALTER TABLE #__cbe DROP `sbordering`";
				$query3 = "ALTER TABLE #__cbe DROP `sbsignature`";
				$database->setQuery($query);
				$database->query();
				$database->setQuery($query2);
				$database->query();
				$database->setQuery($query3);
				$database->query();
				
				$database->setQuery("DELETE FROM #__cbe_fields WHERE name='sbsignature'");
				$database->query();
				$database->setQuery("SELECT fieldid FROM #__cbe_fields WHERE name='sbordering'");
				$sig_id = $database->loadResult();
				if ($sig_id != "") {
					$database->setQuery("DELETE FROM #__cbe_fields WHERE name='sbordering'");
					$database->query();
					$database->setQuery("DELETE FROM #__cbe_field_values WHERE fieldid='".$sig_id."'");
					$database->query();
				}
				$database->setQuery("SELECT fieldid FROM #__cbe_fields WHERE name='sbviewtype'");
				$view_id = $database->loadResult();
				if ($view_id != "") {
					$database->setQuery("DELETE FROM #__cbe_fields WHERE name='sbviewtype'");
					$database->query();
					$database->setQuery("DELETE FROM #__cbe_field_values WHERE fieldid='".$view_id."'");
					$database->query();
				}
				echo "<font color=red>SB Forum Fields cleaned up! Please run again to reinstall these fields</font><br /><br />";
				echo "<a href=\"index2.php?option=com_cbe&func=loadSimpleBoardSettings\">Click to reinstall fields</a><br /><br />";
			}
	} else {
	
		$database->setQuery("INSERT INTO #__cbe_fields SET name='sbviewtype', title='_UE_SB_VIEWTYPE_TITLE', type='select', tabid='".$forum_tabid."', ordering='1', published='1', profile='0', calculated='0', sys='0'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("SELECT fieldid FROM #__cbe_fields WHERE name='sbviewtype'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$fieldid=$database->loadResult();
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_SB_VIEWTYPE_FLAT', ordering='1'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_SB_VIEWTYPE_THREADED', ordering='2'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_fields SET name='sbordering', title='_UE_SB_ORDERING_TITLE', type='select', tabid='".$forum_tabid."', ordering='2', published='1', profile='0', calculated='0', sys='0'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$database->setQuery("SELECT fieldid FROM #__cbe_fields WHERE name='sbordering'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$fieldid=$database->loadResult();
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_SB_ORDERING_OLDEST', ordering='1'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_SB_ORDERING_LATEST', ordering='2'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_fields SET name='sbsignature', title='_UE_SB_SIGNATURE', type='textarea', maxlength='300', cols='60', rows='5', tabid='".$forum_tabid."', ordering='3', published='1', profile='0', calculated='0', sys='0'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("ALTER TABLE #__cbe ADD sbviewtype varchar(255) DEFAULT '_UE_SB_VIEWTYPE_FLAT' NOT NULL");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$database->setQuery("ALTER TABLE #__cbe ADD sbordering varchar(255) DEFAULT '_UE_SB_ORDERING_OLDEST' NOT NULL");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$database->setQuery("ALTER TABLE #__cbe ADD sbsignature mediumtext");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
		echo "<font color='green'>SB Forum Fields successfully added!</font><br/><p>&nbsp;</p>";
	} // end else
	echo "<font color='black'>CBE-Tools Option for JoomlaBoard fields was executed!</font><br/><p>&nbsp;</p>";
	exit();
}

function loadProfileColors()
{
	$database = &JFactory::getDBO();

	$database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE title='_UE_CONTACT_INFO_HEADER'");
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$tabid=$database->loadResult();

	$database->setQuery("SELECT fieldid FROM #__cbe_fields WHERE name='profile_color'");
        $procol_result = $database->loadResult();
        if ($procol_result != '') {
                echo '<font color="red">Profile-Color field already exists</font><br/>';
                echo "<script> alert('Profile-Color field already exists!'); window.history.go(-1); </script>\n";
                exit();
        } else {
		$database->setQuery("INSERT INTO #__cbe_fields SET name='profile_color', title='_UE_PROFILE_COLOR', type='select', ordering='1', published='1', profile='0', calculated='0', sys='0', tabid=$tabid");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("SELECT fieldid FROM #__cbe_fields WHERE name='profile_color'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$fieldid=$database->loadResult();
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_RED', ordering='1'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_GREEN', ordering='2'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_BLUE', ordering='3'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_PINK', ordering='4'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_ORANGE', ordering='5'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_YELLOW', ordering='6'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_BLACK', ordering='7'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_LIME', ordering='8'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_FUCHIA', ordering='9'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_NAVY', ordering='10'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_PURPLE', ordering='11'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_MAROON', ordering='12'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_TEAL', ordering='13'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_AQUA', ordering='14'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_OLIVE', ordering='15'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_SILVER', ordering='16'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_GREY', ordering='17'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_PROFILE_COLOR_WHITE', ordering='18'");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		$database->setQuery("ALTER TABLE #__cbe ADD profile_color varchar(255)");
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	} // end else
}

function loadDEstates()
{
	//************************************************************************
	// Germany Federal States                                              *
	//************************************************************************
	$database = &JFactory::getDBO();

	$state = "de_state";  //Set the name of the state field
	$stateTitle = "German Federal States"; //Set the title of the state field, this is what users will see

	$tabid ="3"; //leave as default

	$database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE title='_UE_CONTACT_INFO_HEADER'");
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$tabid=$database->loadResult();

	$DE_sql = "SELECT COUNT(fieldid) as counter FROM #__cbe_fields WHERE name='".$state."'";
	$database->setQuery($DE_sql);
	$DE_count = $database->loadResult();
	if ($DE_count != 0) {
                echo '<font color="red">German-Federal-State field already exists</font><br/>';
                echo "<script> alert('German-Federal-State field already exists!'); window.history.go(-1); </script>\n";
                exit();
        } else {
		$database->setQuery("INSERT INTO #__cbe_fields SET name='".$state."', title='".$stateTitle."', type='select', ordering='1', published='1', profile='1', calculated='0', sys='0',tabid=$tabid");
	
		if(!$database->query())
		echo '<font color="red">Failed inserting de_state field to cbe_fields</font><br/>';
		else
		echo '<font color="green">Successfully inserted de_state field to cbe_fields</font><br/>';
	
		$database->setQuery("SELECT fieldid FROM #__cbe_fields WHERE name='".$state."'");
		$fieldid=$database->loadResult();
	
		if(!$database->query())
		echo '<font color="red">Failed getting field id</font><br/>';
		else
		echo '<font color="green">Successfully retrieved field id</font><br/>';
	
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_DE_STATE01', ordering='1'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_DE_STATE02', ordering='2'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_DE_STATE03', ordering='3'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_DE_STATE04', ordering='4'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_DE_STATE05', ordering='5'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_DE_STATE06', ordering='6'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_DE_STATE07', ordering='7'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_DE_STATE08', ordering='8'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_DE_STATE09', ordering='9'"); $database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_DE_STATE10', ordering='10'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_DE_STATE11', ordering='11'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_DE_STATE12', ordering='12'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_DE_STATE13', ordering='13'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_DE_STATE14', ordering='14'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_DE_STATE15', ordering='15'");$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_DE_STATE16', ordering='16'");$database->query();
	
		if(!$database->query())
		echo '<font color="red">Failed storing German Federal states,</font><br/>';
		else
		echo '<font color="green">Successfully added German Federal state list to field values</font><br/>';
	
		$database->setQuery("ALTER TABLE #__cbe ADD $state varchar(255)");
	
		if(!$database->query())
		echo '<font color="red">Failed altering table</font><br/>';
		else
		echo '<font color="green">Successfully altered cbe table</font><br/><br/>';
	
		echo "<a href=\"http://MamboMe.com\">http://MamboMe.com</a><br/>";
		echo '<font color="blue">Hey Mambo! MamboMe!';
	} // end else
}

function createLastVisitors() {
	global $database;
	
//	$query = "SELECT lastusers FROM #__cbe";
//	$database->setQuery($query);
//	if (!$database->query()) {
//		$database->setQuery("ALTER TABLE #__cbe ADD lastusers varchar(255) AFTER acceptedterms");
//		if (!$database->query()) {
//			echo '<font color="red">Failed altering table to add lastusers for LastVisitors-Tab.</font><br/>';
//		} else {
//			echo '<font color="Green">Added lastusers for LastVisitors-Tab to cbe table.</font><br/>';
//		}
//	} else {
//		echo '<font color="red">lastusers for LastVisitors-Tab DOES exist, no changes needed.</font><br/>';
//	}
	echo '<font color="blue">Function has expired since sv0.621</font><br/>';
	echo "<script> alert('Function has expired since sv0.621!'); window.history.go(-1); </script>\n";
	exit();

}

function clearLastVisitors() {
	
	$database = &JFactory::getDBO();
	
	$data_cleaned = "LastVisitor database Table cleared";
	
	$c_query = "DELETE FROM #__cbe_lastvisitor WHERE uid!=''";
	$database->setQuery($c_query);
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	} else {
		echo "<script> alert('".$data_cleaned."'); window.history.go(-1); </script>\n";
	}
//	echo '<font color="blue">Function has expired since sv0.621</font><br/>';
//	echo "<script> alert('Function has expired since sv0.621!'); window.history.go(-1); </script>\n";
//	exit();

}

function createTopVoteFields() {
	$database = &JFactory::getDBO();
		
	$query_check1 = "SHOW COLUMNS FROM #__cbe LIKE 'votecount'";
	$database->setQuery($query_check1);
	$check1_result = $database->loadAssocList();
	$check1_result = $check1_result[0];

	$query_check2 = "SHOW COLUMNS FROM #__cbe LIKE 'voteresult'";
	$database->setQuery($query_check2);
	$check2_result = $database->loadAssocList();
	$check2_result = $check2_result[0];

	
	if (($check1_result[Field] != "votecount") && ($check2_result[Field] != "voteresult")) {
		$database->setQuery("ALTER TABLE #__cbe ADD votecount varchar(255)");
		if(!$database->query()) {
			echo '<font color="red">Failed altering table</font><br/>';
		} else {
			echo '<font color="green">Successfully altered cbe table (votecount)</font><br/><br/>';
			$database->setQuery("ALTER TABLE #__cbe ADD voteresult varchar(255)");
			if(!$database->query()) {
				echo '<font color="red">Failed altering table</font><br/>';
			} else {
				echo '<font color="green">Successfully altered cbe table (voteresult)</font><br/><br/>';
			}
		}
	} else {
		echo "<script> alert('The fields votecount and voteresult exists already!'); window.history.go(-1); </script>\n";
	}
}

function createZodiacFields() {
	
	$database = &JFactory::getDBO();
	
	$query_check1 = "SHOW COLUMNS FROM #__cbe LIKE 'zodiac'";
	$database->setQuery($query_check1);
	$check1_result = $database->loadAssocList();
	$check1_result = $check1_result[0];

	$query_check2 = "SHOW COLUMNS FROM #__cbe LIKE 'zodiac_c'";
	$database->setQuery($query_check2);
	$check2_result = $database->loadAssocList();
	$check2_result = $check2_result[0];

	
	if (($check1_result[Field] != "zodiac") && ($check2_result[Field] != "zodiac_c")) {
		$database->setQuery("ALTER TABLE #__cbe ADD zodiac varchar(255) AFTER lastname");
		if(!$database->query()) {
			echo '<font color="red">Failed altering cbe table (Zodiac)</font><br/>';
		} else {
			echo '<font color="green">Successfully altered cbe table (Zodiac-west)</font><br/><br/>';
			$database->setQuery("ALTER TABLE #__cbe ADD zodiac_c varchar(255) AFTER zodiac");
			if(!$database->query()) {
				echo '<font color="red">Failed altering table</font><br/>';
			} else {
				echo '<font color="green">Successfully altered cbe table (Zodiac-chinese)</font><br/><br/>';
			}
		}
	} else {
//		echo "<script> alert('The fields Zodiac-Fields exists already!'); window.history.go(-1); </script>\n";
	}
	
	$tabid ="3"; //leave as default

	$database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE title='_UE_CONTACT_INFO_HEADER'");
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$tabid=$database->loadResult();

	$query_zods = "SELECT count(name) AS num FROM #__cbe_fields WHERE name='zodiac' OR name='zodiac_c'";
	$database->setQuery($query_zods);
	$zod_num = $database->loadResult();

	if ($zod_num == '0') {
		$query_zod1 = "INSERT INTO #__cbe_fields SET name='zodiac', title='_UE_SHOWZODIAC_TITLE', type='select', published='1', profile='0', readonly='1', calculated='0', sys='1', tabid=$tabid";
		$database->setQuery($query_zod1);
		$database->query();
		$query_zod2 = "INSERT INTO #__cbe_fields SET name='zodiac_c', title='_UE_SHOWZODIAC_TITLE_CHINESE', type='select', published='1', profile='0', readonly='1', calculated='0', sys='1', tabid=$tabid";
		$database->setQuery($query_zod2);
		$database->query();
		
		$database->setQuery("SELECT fieldid FROM #__cbe_fields WHERE name='zodiac'");
//		$database->query();
		$fieldid=$database->loadResult();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_ARIES', ordering='1'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_TAURUS', ordering='2'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_GEMINI', ordering='3'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_CANCER', ordering='4'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_LEO', ordering='5'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_VIRGO', ordering='6'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_LIBRA', ordering='7'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_SCORPIO', ordering='8'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_SAGITTARIUS', ordering='9'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_CAPRICORN', ordering='10'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_AQUARIUS', ordering='11'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_A_PISCES', ordering='12'");
		$database->query();

		$database->setQuery("SELECT fieldid FROM #__cbe_fields WHERE name='zodiac_c'");
//		$database->query();
		$fieldid=$database->loadResult();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_MONKEY', ordering='1'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_ROOSTER', ordering='2'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_DOG', ordering='3'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_PIG', ordering='4'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_RAT', ordering='5'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_OX', ordering='6'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_TIGER', ordering='7'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_RABBIT', ordering='8'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_DRAGON', ordering='9'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_SERPENT', ordering='10'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_HORSE', ordering='11'");
		$database->query();
		$database->setQuery("INSERT INTO #__cbe_field_values SET fieldid=$fieldid, fieldtitle='_UE_AC_GOAT', ordering='12'");
		$database->query();

		echo '<font color="green">Successfully inserted Zodiac values to _cbe_field_values.</font><br/><br/>';
		
	} else if ($zod_num == '2') {

		$database->setQuery("UPDATE #__cbe_fields SET tabid=$tabid WHERE name='zodiac'");
		$database->query();

		$database->setQuery("UPDATE #__cbe_fields SET tabid=$tabid WHERE name='zodiac_c'");
		$database->query();
		
		echo '<font color="green">Successfully updated Zodiac tab-ids.</font><br/><br/>';
	} else {
		echo '<font color="red">It seems there is only one zodiac field. Please check _cbe_fields with a MySQL Tool.</font><br/><br/>';
	}
	
}

function publishZodiacFields() {
	
	$database = &JFactory::getDBO();
	
	$query_z = "SELECT published FROM #__cbe_fields WHERE name='zodiac'";
	$database->setQuery($query_z);
	$zod_pub = $database->loadResult();
	
	if ($zod_pub =='1') {
		$query_set1 = "UPDATE #__cbe_fields SET published='0' WHERE name='zodiac'";
		$database->setQuery($query_set1);
		if(!$database->query()) {
			echo ' <font color="red">Unpublishing of chaldean zodiac failed</font><br>';
		} else {
			echo ' <font color="green">Unpublishing of chaldean zodiac successfull</font><br>';
		}
	} else {
		$query_set1 = "UPDATE #__cbe_fields SET published='1' WHERE name='zodiac'";
		$database->setQuery($query_set1);
		if(!$database->query()) {
			echo ' <font color="red">Publishing of chaldean zodiac failed</font><br>';
		} else {
			echo ' <font color="green">Publishing of chaldean zodiac successfull</font><br>';
		}
	}
	
	$query_zch = "SELECT published FROM #__cbe_fields WHERE name='zodiac_c'";
	$database->setQuery($query_zch);
	$zodch_pub = $database->loadResult();
	
	if ($zodch_pub =='1') {
		$query_set2 = "UPDATE #__cbe_fields SET published='0' WHERE name='zodiac_c'";
		$database->setQuery($query_set2);
		if(!$database->query()) {
			echo ' <font color="red">Unpublishing of chinese zodiac failed</font><br>';
		} else {
			echo ' <font color="green">Unpublishing of chinese zodiac successfull</font><br>';
		}
	} else {
		$query_set2 = "UPDATE #__cbe_fields SET published='1' WHERE name='zodiac_c'";
		$database->setQuery($query_set2);
		if(!$database->query()) {
			echo ' <font color="red">Publishing of chinese zodiac failed</font><br>';
		} else {
			echo ' <font color="green">Publishing of chinese zodiac successfull</font><br>';
		}
	}
}


function checkNewLastVisitor() {
	$database = &JFactory::getDBO();

	$queck_check = "SELECT uid FROM #__cbe_lastvisitor LIMIT 1";
	$database->setQuery($queck_check);
	
	if ( !$database->query() ) {
		$query_update  = "CREATE TABLE IF NOT EXISTS `#__cbe_lastvisitor` (";
		$query_update .= "  `uid` int(11) default '0',";
		$query_update .= "  `visitor` int(11) default '0',";
		$query_update .= "  `vdate` timestamp(14) NOT NULL,";
		$query_update .= "  `visits` INT(11) UNSIGNED default '1'";
		$query_update .= ") TYPE=MyISAM;";
		$database->setQuery($query_update);
		if (!$database->query()) {
			echo ' <font color="red">Creating lastvisitor table failed</font><br>';
		} else {
			echo ' <font color="green">Creating lastvisitor table successfull</font><br>';
		}
	} else {
		echo ' <font color="green">Lastvisitor table exists!</font><br>';
	}

	$query_all = "SELECT user_id, lastusers FROM #__cbe ORDER by user_id ASC";
	$database->setQuery($query_all);
	$all_users = $database->loadObjectList();
	
	foreach ($all_users as $all_user) {
		$db_lastusers = $all_user->lastusers;

		if ($db_lastusers !='' || $db_lastusers != NULL) {
			$tmp_array_all = explode("--", $db_lastusers);
			$ID_timestamps = $tmp_array_all[1];
			$userIDs_time = explode(',', $ID_timestamps);
			// $userIDs = $tmp_array_all[0];
			
			foreach ($userIDs_time as $userID_time) {
				$user_time = explode('=', $userID_time);
				$visitor = $user_time[0];
				$vdate = $user_time[1];
				$owner_uid = $all_user->user_id;
				
//				echo "Profile -> ".$owner_uid." -- Visitor -> ".$visitor." -- Date -> ".$vdate."<br>\n";
				
				$query_visit = "INSERT INTO #__cbe_lastvisitor (uid, visitor, vdate, visits) VALUES ('".$owner_uid."','".$visitor."',FROM_UNIXTIME(".$vdate.")+0,'1')";
				$database->setQuery($query_visit);
				if (!$database->query()) {
					echo "DB Update Error<br>";
					echo "Profile -> ".$owner_uid." -- Visitor -> ".$visitor." -- Date -> ".$vdate."<br>\n";
				}
			}
		}

	}
	echo ' <font color="green">-> Migration of lastvisitor successfull</font><br>';
}

function reasignFields() {
	$database = &JFactory::getDBO();
	
	$tabid ="3"; //leave as default

	$database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE title='_UE_CONTACT_INFO_HEADER'");
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$tabid=$database->loadResult();
	
	$tabs = $database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE `fields`=1 ORDER BY ordering");
	$tabs = $database->loadResultArray();
	
	$database->setQuery("SELECT fieldid, title, tabid FROM #__cbe_fields WHERE tabid IS NOT NULL AND sys!='1'");
	$fields = $database->loadObjectList();
	
	$i=0;
	foreach ($fields as $field) {
		if (!in_array($field->tabid, $tabs)) {
			echo "Found <b>".$field->title."</b> not at an existing tab<br>";
			$database->setQuery("UPDATE #__cbe_fields SET tabid='".$tabid."' WHERE fieldid='".$field->fieldid."'");
			if (!$database->query()) {
				echo "<font color=red> -> Could not reasign field.</font><br>";
			} else {
				echo "<font color=green> -> Field reasigned to Contact-Info Tab.</font><br>";
			}
			$i++;
		}
	}
	echo "<br> ".$i." fields found for reasignment.<br>";
	die;
}

function doWatermarkAllAvatars() {
	global $ueConfig,$mosConfig_live_site,$mosConfig_absolute_path;
	$database = &JFactory::getDBO();
	
	$ava_users_query = "SELECT c.user_id, u.username, c.avatar FROM #__users as u, #__cbe as c WHERE c.avatar!='' AND c.avatar NOT LIKE '%gallery%' AND u.id=c.user_id";
	$database->setQuery($ava_users_query);
	$ava_users = $database->loadObjectList();

	$imgToolBox = new imgToolBox();
	$imgToolBox->_conversiontype=$ueConfig['conversiontype'];
	$imgToolBox->_IM_path = $ueConfig['im_path'];
	$imgToolBox->_NETPBM_path = $ueConfig['netpbm_path'];
	$imgToolBox->_maxsize = $ueConfig['avatarSize'];
	$imgToolBox->_maxwidth = $ueConfig['avatarWidth'];
	$imgToolBox->_maxheight = $ueConfig['avatarHeight'];
	$imgToolBox->_thumbwidth = $ueConfig['thumbWidth'];
	$imgToolBox->_thumbheight = $ueConfig['thumbHeight'];
	$imgToolBox->_debug = 0;
	//	sv0.6233
	$imgToolBox->_wm2_canvas = $ueConfig['wm_canvas'];
	$imgToolBox->_wm2_stampit = $ueConfig['wm_stampit'];
	$imgToolBox->_wm2_stampit_txt = $ueConfig['wm_stampit_text'];
	$imgToolBox->_wm2_stampit_size = $ueConfig['wm_stampit_size'];
	if (!($ueConfig['wm_stampit_color']=='' || $ueConfig['wm_stampit_color']==null || strlen(trim($ueConfig['wm_stampit_color']))!=6)) {
		$red = hexdec(substr($ueConfig['wm_stampit_color'],0,2));
		$yellow = hexdec(substr($ueConfig['wm_stampit_color'],2,2));
		$green = hexdec(substr($ueConfig['wm_stampit_color'],4,2));
		
		$imgToolBox->_wm2_stampit_cred = $red;
		$imgToolBox->_wm2_stampit_cyellow = $yellow;
		$imgToolBox->_wm2_stampit_cgreen = $green;
	}
	$imgToolBox->_wm2_doit = $ueConfig['wm_doit'];
	$imgToolBox->_wm2_img = $ueConfig['wm_filename'];
	//

	$i=0;
	$j=$i;
	foreach ($ava_users as $ava_user) {
		if ($ueConfig['wm_stampit_text']=='' ||$ueConfig['wm_stampit_text']==null) {
			$imgToolBox->_wm2_stampit_txt = JURI::root().$ava_user->username;
		}
		$ava_usr_file= array();
		$ava_usr_file['name'] = JPATH_SITE.'/images/cbe/'.$ava_user->avatar;
		$ava_usr_file['tmp_name'] = $ava_usr_file['name'];
		if(!($ret_check=$imgToolBox->processImage($ava_usr_file, $ava_user->user_id,JPATH_SITE.'/images/cbe/', 0, 0, 0))) {
			echo "<br><font color=\"red\">".$ava_user->username."'s avatar not watermarked.</font><br>";
			echo $imgToolBox->_errMSG."<br>";
		} else {
			$ava_up = "UPDATE #__cbe SET avatar='".$ret_check."' where user_id='".$ava_user->user_id."'";
			$database->setQuery($ava_up);
			if (!$database->query()) {
				echo "Database update failed, please set file postfix to .png in database->avatar<br>";
			}
			echo "<br><font color=\"green\">".$ava_user->username."'s avatar watermarked.</font><br>";
			$j++;
		}
		$i++;
	}
	echo "<br><br>Processed ".$j." avatars from total ".$i." images successfull.<br>";
}

function doGeocoderUserMapGenXML() {
	global $mosConfig_absolute_path, $enhanced_Config;
	
	if (file_exists(JPATH_SITE.'/components/com_cbe/enhanced/geocoder/geocoder.mapclass.php')) {
		include_once(JPATH_SITE.'/components/com_cbe/enhanced/geocoder/geocoder.mapclass.php');
		$scan_wide = $enhanced_Config['geocoder_usermap_scanwide'];
		// -> 0 exit, 1 genXML/write and return, 2 only genXML/write, 3 readXML, 4 auto with update-interval
		$ret_xml = cbeGeoMap::genXML($scan_wide, 2, $enhanced_Config['geocoder_usermap_interval']);

		if ($ret_xml !== true) {
			$ret_msg = $ret_xml;
			//echo $ret_msg;
			return JError::raiseWarning( '', JText::_( $ret_msg ) );
		} else {
			//echo "<br><font color=\"green\">CBE-UserMap XML Data file was generated.</font><br>";
			$mainframe->redirect( "index.php?option=com_cbe&task=tools", "CBE-UserMap XML Data file was generated.");
		}
	} else {
		$mosmsg = "GeoCoder Frontend Map not installed - Code XML";
		echo $mosmsg;
	}
	die();
}

function showsyncUsersJoomla() {
	global $my, $ueConfig;
	
	$database = &JFactory::getDBO();
	$dif_query = "select c.user_id, c.firstname, c.lastname FROM #__cbe as c LEFT JOIN #__users as u ON u.id = c.user_id WHERE u.id IS NULL ORDER by c.user_id";
	$database->setQuery($dif_query);
	$dif_obj = $database->loadObjectList();
	if (count($dif_obj) > 0) {
		$iu = 0;
		echo "<font color=\"red\"><table border=\"1\" width=\"400\"><tr><td>USER-ID</td><td>Name</td></tr>\n";
		foreach ( $dif_obj as $dif_user ) {
			echo "<tr><td>".$dif_user->user_id."</td><td>".$dif_user->firstname." ".$dif_user->lastname."</td></tr>\n";
			$iu++;
		}
		echo "</table> </font>\n";
		echo "<br><font color=\"green\">".$iu." unconnected CBE-Users to Joomla User-Table found.</font><br>";
		echo "<br><font color=\"green\">You may want to <a href=\"index2.php?option=com_cbe&func=syncUsersJoomla\">reconnect</a> them for easy deletion.</font><br>";
	} else {
		echo "<br><font color=\"green\">No unconnected CBE-Users for Joomla User-Table found.</font><br>";
	}
	echo "<br><br>Listing of unconnected CBE-Users done.<br>";
}
function syncUsersJoomla() {
	global $my, $ueConfig;
	
	$database = &JFactory::getDBO();
	$dif_query = "select c.user_id FROM #__cbe as c LEFT JOIN #__users as u ON u.id = c.user_id WHERE u.id IS NULL";
	$database->setQuery($dif_query);
	$dif_ar = $database->loadResultArray();
	if (count($dif_ar) > 0) {
		$iu = 0;
		foreach ( $dif_ar as $dif_user ) {
			if ($dif_user != 0) {
				$database->setQuery("INSERT INTO #__users (id,name,username,block) VALUES ('".$dif_user."','LOST--".$iu."','LOST--".$iu."','1')");
				if (!$database->query()) {
					echo "<br><font color=\"red\">Error reconnecting USER-ID ".$dif_user." to Joomla User-Table.<br />".$database->getErrorMsg()."</font><br>";
				}
				$iu++;
			}
		}
		echo "<br><font color=\"green\">Reconnected ".$iu." CBE-Users back to Joomla User-Table. Look for name like LOST--x.</font><br>";
	} else {
		echo "<br><font color=\"green\">No unconnected CBE-Users for Joomla User-Table found.</font><br>";
	}
	echo "<br><br>Check for unconnected CBE-Users done.<br>";
}

function doGalleryCBEDB() {
	global $my, $ueConfig;

	$database = &JFactory::getDBO();
	$database->setQuery("SELECT id FROM #__cbe_gallery LIMIT 1");
	$test_1 = $database->loadResult();
	if($database->query()) {
		echo "<br><font color=\"green\">CBE-Gallery table already exists. Nothing needs to be done!</font><br>";
	} else {
		$gal_ins_query = "CREATE TABLE IF NOT EXISTS `#__cbe_gallery` ("
	 			."`id` int(100) NOT NULL auto_increment,"
				."`uid` int(11) NOT NULL default '0',"
				."`datei` varchar(100) NOT NULL default '',"
				."`titel` varchar(100) NOT NULL default '',"
				."`datum` datetime NOT NULL default '0000-00-00 00:00:00',"
				."`approved` tinyint(4) NOT NULL default '0',"
				."PRIMARY KEY  (`id`)"
				.") TYPE=MyISAM";
		$database->setQuery($gal_ins_query);
		if (!$database->query()) {
			echo "<br><font color=\"red\">Error creating CBE-Gallery DB-Table.<br />".$database->getErrorMsg()."</font><br>";
		} else {
			echo "<br><font color=\"green\">CBE-Gallery DB-Table created.</font><br>";
		}
	}
	
	$database->setQuery("SELECT tabid FROM #__cbe_tabs WHERE title='GALLERY_TAB_TITLE'");
	$gTab_id = $database->loadResult();
	if ($gTab_id > 0 && !empty($gTab_id)) {
		echo "<br><font color=\"green\">CBE-Gallery Tab already exists. Nothing needs to be done!</font><br>";
	} else {
		$database->setQuery("SELECT max(tabid)+1 as tabid FROM #__cbe_tabs");
		$gTabid = $database->loadResult();
		$tabins_query = "INSERT INTO `#__cbe_tabs` (`tabid`, `title`, `description`, `ordering`, `width`, `enabled`, `aclgroups`, `enhanced_params`) VALUES "
				."(".$gTabid.", 'GALLERY_TAB_TITLE', '', 1, '1', 1, '-2', 'profile=1\n tabtype=1\n enhancedname=gallery')";
		$database->setQuery($tabins_query);
		if (!$database->query()) {
			echo "<br><font color=\"red\">Error creating CBE-Gallery TAB.<br />".$database->getErrorMsg()."</font><br>";
		} else {
			echo "<br><font color=\"green\">CBE-Gallery Tab added. Please use Tab-Management to check ACLs and ordering!</font><br>";
		}
	}
}

function doGalleryCBEadm() {
	global $my, $ueConfig;
	$database = &JFactory::getDBO();
	$ck_query = "SELECT module FROM #__cbe_admods WHERE module='adm_cbegallery'";
	$database->setQuery($ck_query);
	$adm_res = $database->loadResult();
	if (!$database->query()) {
		echo "<br><font color=\"red\">Error while checking the DB.<br />".$database->getErrorMsg()."</font><br>";
	} else {
		if (count($adm_res) >= 1) {
			echo "<br><font color=\"bluen\">CBE-Gallery Backend-Module already exists.!</font><br>";
		} else {
			$ins_adm = "INSERT INTO #__cbe_admods (id, title, content, ordering, position, published, module, plugin, plugin_func, showtitle, params, iscore)"
				 ." VALUES (1, 'CBE-Gallery', '', 0, 'ccpanel', 1, 'adm_cbegallery', 'adm_inc_cbegallery', 'showCBEGalleryConfig, saveCBEGalleryConfig', 1, '', 0)";
			$database->setQuery($ins_adm);
			if (!$database->query()) {
				echo "<br><font color=\"red\">Error inserting CBE-Gallery AdminModule to CBE.<br />".$database->getErrorMsg()."</font><br>";
			} else {
				echo "<br><font color=\"green\">CBE-Gallery Admin Module added to CBE Control Panel.</font><br>";
			}
		}
	}
}

function createBackupDB() {
	global $mainframe;
	$database = JFactory::getDBO();
	
	$dbquery = "CREATE TABLE IF NOT EXISTS `#__cbe_config` ("
			."`varname` tinytext NOT NULL,"
			."`value` tinytext NOT NULL,"
	 	   	."PRIMARY KEY  (`varname`(30))"
	 	   	." ) TYPE=MyISAM";
 		
	$database->setQuery($dbquery);
	if (!$database->query())
		echo("SQL error: ".$database->stderr(true));
		 	   	
	 $db2query = "CREATE TABLE IF NOT EXISTS `#__cbe_config_enh` ("
	   		."`varname` tinytext NOT NULL,"
	   		."`value` tinytext NOT NULL,"
	   		."PRIMARY KEY  (`varname`(40))"
	 		.") TYPE=MyISAM";
	 		
	$database->setQuery($db2query);
	if (!$database->query())
		echo("SQL error: ".$database->stderr(true));
	
	$mainframe->redirect( "index.php?option=com_cbe&task=tools", "Tables successfully created in DB");
}

function doCBEBackupRestore($option, $task, $func, $pathtoadmin, $config) {
	global $mainframe;
	$database = JFactory::getDBO();
	
	if ($func=="backup") {
		require(JPATH_ADMINISTRATOR."/components/com_cbe/ue_config.php");	// configuration file
		
		$backup = array();
		$backup['backupdate']					= date('Y-m-d H:i:s');
		$backup['version']						= $ueConfig['version'];
		$backup['name_style'] 					= $ueConfig['name_style'];
		$backup['name_format'] 					= $ueConfig['name_format'];
		$backup['date_format'] 					= $ueConfig['date_format'];
		$backup['uname_pathway'] 				= $ueConfig['uname_pathway'];
		$backup['allow_email_display'] 			= $ueConfig['allow_email_display'];
		$backup['allow_email'] 					= $ueConfig['allow_email'];
		$backup['allow_website'] 				= $ueConfig['allow_website'];
		$backup['allow_onlinestatus'] 			= $ueConfig['allow_onlinestatus'];
		$backup['show_jeditor'] 				= $ueConfig['show_jeditor'];
		$backup['cbedologin'] 					= $ueConfig['cbedologin'];
		$backup['switch_js_inc'] 				= $ueConfig['switch_js_inc'];
		$backup['username_min'] 				= $ueConfig['username_min'];
		$backup['username_max'] 				= $ueConfig['username_max'];
		$backup['password_min'] 				= $ueConfig['password_min'];
		$backup['generatepass_on_reg'] 			= $ueConfig['generatepass_on_reg'];
		$backup['emailpass_on_reg'] 			= $ueConfig['emailpass_on_reg'];
		$backup['reg_regex'] 					= $ueConfig['reg_regex'];
		$backup['reg_useajax'] 					= $ueConfig['reg_useajax'];
		$backup['reg_useajax_button']			= $ueConfig['reg_useajax_button'];
		$backup['user_unregister_allow']		= $ueConfig['user_unregister_allow'];
		$backup['show_unregister_editmode'] 	= $ueConfig['show_unregister_editmode'];
		$backup['show_unregister_profilemode'] 	= $ueConfig['show_unregister_profilemode'];
		$backup['unregister_send_email']		= $ueConfig['unregister_send_email'];
		$backup['unregister_moderatorEmail']	= $ueConfig['unregister_moderatorEmail'];
		$backup['reg_unregister_sub']			= $ueConfig['reg_unregister_sub'];
		$backup['reg_unregister_msg']			= $ueConfig['reg_unregister_msg'];
		$backup['reg_admin_approval']			= $ueConfig['reg_admin_approval'];
		$backup['reg_confirmation']				= $ueConfig['reg_confirmation'];
		$backup['reg_confirmation_hash']		= $ueConfig['reg_confirmation_hash'];
		$backup['reg_email_name']				= $ueConfig['reg_email_name'];
		$backup['reg_email_from']				= $ueConfig['reg_email_from'];
		$backup['reg_email_replyto']			= $ueConfig['reg_email_replyto'];
		$backup['reg_pend_appr_sub']			= $ueConfig['reg_pend_appr_sub'];
		$backup['reg_pend_appr_msg']			= $ueConfig['reg_pend_appr_msg'];
		$backup['reg_welcome_sub']				= $ueConfig['reg_welcome_sub'];
		$backup['reg_welcome_msg']				= $ueConfig['reg_welcome_msg'];
		$backup['set_mail_xheader']				= $ueConfig['set_mail_xheader'];
		$backup['reg_enable_toc']				= $ueConfig['reg_enable_toc'];
		$backup['reg_toc_url']					= $ueConfig['reg_toc_url'];
		$backup['reg_enable_datasec']			= $ueConfig['reg_enable_datasec'];
		$backup['reg_datasec_url']				= $ueConfig['reg_datasec_url'];
		$backup['reg_first_visit_url']			= $ueConfig['reg_first_visit_url'];
		$backup['search_username']				= $ueConfig['search_username'];
		$backup['hide_searchbox']				= $ueConfig['hide_searchbox'];
		$backup['hide_listsbox']				= $ueConfig['hide_listsbox'];
		$backup['num_per_page']					= $ueConfig['num_per_page'];
		$backup['userslist_rnr']				= $ueConfig['userslist_rnr'];
		$backup['allow_profilelink']			= $ueConfig['allow_profilelink'];
		$backup['allow_profile_popup']			= $ueConfig['allow_profile_popup'];
		$backup['allow_listviewbyGID']			= $ueConfig['allow_listviewbyGID'];
		$backup['userslist_css1']				= $ueConfig['userslist_css1'];
		$backup['userslist_css2']				= $ueConfig['userslist_css2'];
		$backup['usernameedit']					= $ueConfig['usernameedit'];
		$backup['allow_mailchange']				= $ueConfig['allow_mailchange'];
		$backup['adminrequiredfields']			= $ueConfig['adminrequiredfields'];
		$backup['adminshowalltabs']				= $ueConfig['adminshowalltabs'];
		$backup['allow_profileviewbyGID']		= $ueConfig['allow_profileviewbyGID'];
		$backup['templatedir']					= $ueConfig['templatedir'];
		$backup['nesttabs']						= $ueConfig['nesttabs'];
		$backup['im_path']						= $ueConfig['im_path'];
		$backup['netpbm_path']					= $ueConfig['netpbm_path'];
		$backup['conversiontype']				= $ueConfig['conversiontype'];
		$backup['allowAvatar']					= $ueConfig['allowAvatar'];
		$backup['allowAvatarUpload']			= $ueConfig['allowAvatarUpload'];
		$backup['showAvatarRules']				= $ueConfig['showAvatarRules'];
		$backup['showAvatarRules_url']			= $ueConfig['showAvatarRules_url'];
		$backup['allowAvatarUploadOnReg']		= $ueConfig['allowAvatarUploadOnReg'];
		$backup['allowAvatarGallery']			= $ueConfig['allowAvatarGallery'];
		$backup['rows_of_gallery']				= $ueConfig['rows_of_gallery'];
		$backup['avatardeljs']					= $ueConfig['avatardeljs'];
		$backup['avatarHeight']					= $ueConfig['avatarHeight'];
		$backup['avatarWidth']					= $ueConfig['avatarWidth'];
		$backup['avatarSize']					= $ueConfig['avatarSize'];
		$backup['thumbHeight']					= $ueConfig['thumbHeight'];
		$backup['thumbWidth']					= $ueConfig['thumbWidth'];
		$backup['wm_force_png']					= $ueConfig['wm_force_png'];
		$backup['wm_force_zoom']				= $ueConfig['wm_force_zoom'];
		$backup['wm_canvas']					= $ueConfig['wm_canvas'];
		$backup['wm_canvas_color']				= $ueConfig['wm_canvas_color'];
		$backup['wm_doit']						= $ueConfig['wm_doit'];
		$backup['wm_stampit']					= $ueConfig['wm_stampit'];
		$backup['wm_stampit_text']				= $ueConfig['wm_stampit_text'];
		$backup['wm_stampit_size']				= $ueConfig['wm_stampit_size'];
		$backup['wm_stampit_color']				= $ueConfig['wm_stampit_color'];
		$backup['imageApproverGid']				= $ueConfig['imageApproverGid'];
		$backup['allowModUserApproval']			= $ueConfig['allowModUserApproval'];
		$backup['moderatorEmail']				= $ueConfig['moderatorEmail'];
		$backup['allowUserReports']				= $ueConfig['allowUserReports'];
		$backup['avatarUploadApproval']			= $ueConfig['avatarUploadApproval'];
		$backup['allowUserBanning']				= $ueConfig['allowUserBanning'];
		$backup['sendMailonProfileUpdate']		= $ueConfig['sendMailonProfileUpdate'];
		$backup['pms']							= $ueConfig['pms'];
		$backup['use_cbe_gallery']				= $ueConfig['use_cbe_gallery'];
		$backup['use_acctexp']					= $ueConfig['use_acctexp'];
		$backup['use_acctexp_version']			= $ueConfig['use_acctexp_version'];
		$backup['use_secimages']				= $ueConfig['use_secimages'];
		$backup['use_secimages_lostpass']		= $ueConfig['use_secimages_lostpass'];
		$backup['use_secimages_login']			= $ueConfig['use_secimages_login'];
		$backup['use_smfBridge']				= $ueConfig['use_smfBridge'];
		$backup['use_fqmulticorreos']			= $ueConfig['use_fqmulticorreos'];
		$backup['use_yanc']						= $ueConfig['use_yanc'];

		$query = 'TRUNCATE TABLE #__cbe_config';
		$database->setQuery($query);
		if (!$database->query())
			echo("SQL error: ".$database->stderr(true));
		foreach ($backup as $key => $value) {
			$query = 'INSERT INTO #__cbe_config ( varname, value ) VALUES ( '.$database->Quote($key).', '.$database->Quote($value).' )';
			$database->setQuery($query);
			if (!$database->query())
				echo("SQL error: ".$database->stderr(true));
		}
		$mainframe->redirect( "index.php?option=com_cbe&task=tools", "Configuration file stored in DB");
	}
	elseif ($func=="restore") {
		global $mainframe;

		//Add code to check if config file is writeable.
		$configfile = "components/com_cbe/ue_config.php";
		@chmod ($configfile, 0766);
		if (!is_writable($configfile)) {
			return JError::raiseWarning( '', JText::_( "Config File not writeable" ) );
		}
	
		$query = "SELECT varname, value FROM #__cbe_config";
        $database->setQuery($query);
        $results = $database->loadObjectList();
		if (!$database->query())
			echo("SQL error: ".$database->stderr(true));
		$txt = "<?php\n";
        foreach ($results as $result) {
			if (substr($result->varname,0,1)!='_'){
				//$config->{$result->varname} = $result->value;
				//if (strpos( $result->varname, 'cfg_' ) === 0) {
					if (!get_magic_quotes_gpc()) {
						$result->value = addslashes( $result->value );
					}
					//$txt .= "\$ueConfig['".substr( $result->varname, 4 )."']='$result->value';\n";
					$txt .= "\$ueConfig['";
					$txt .= $result->varname;
					$txt .= "']='";
					$txt .= $result->value;
					$txt .= "';\n";
				//}
			}
		}
		$txt .= "?>";
		
		if ($fp = fopen( $configfile, "w")) {
			fputs($fp, $txt, strlen($txt));
			fclose ($fp);
			$mainframe->redirect( "index.php?option=com_cbe&task=tools", "Configuration file restored from DB");
		} else {
			return JError::raiseWarning( '', JText::_( "Config File not writeable" ) );
		}
	}
}

function doCBEBackupRestoreEnh($option, $task, $func, $pathtoadmin, $config) {
	global $mainframe;
	$database = JFactory::getDBO();	
	
	if ($func=="backupenh") {
		require(JPATH_ADMINISTRATOR."/components/com_cbe/enhanced_admin/enhanced_config.php");	// enhanced config file

		$backup = array();
		$backup['backupdate']							= date('Y-m-d H:i:s');
		$backup['version']								= $enhanced_Config['version'];
		$backup['guestbook_auto_publish']				= $enhanced_Config['guestbook_auto_publish'];
		$backup['guestbook_allow_anon']					= $enhanced_Config['guestbook_allow_anon'];
		$backup['guestbook_use_pms_notify']				= $enhanced_Config['guestbook_use_pms_notify'];
		$backup['guestbook_use_bbc_code']				= $enhanced_Config['guestbook_use_bbc_code'];
		$backup['guestbook_use_emoticons']				= $enhanced_Config['guestbook_use_emoticons'];
		$backup['use_guestbook_rating']					= $enhanced_Config['use_guestbook_rating'];
		$backup['guestbook_show_avatar']				= $enhanced_Config['guestbook_show_avatar'];
		$backup['allow_gbdirectmail']					= $enhanced_Config['allow_gbdirectmail'];
		$backup['allow_gbdirectanswer']					= $enhanced_Config['allow_gbdirectanswer'];
		$backup['guestbook_use_language_filter']		= $enhanced_Config['guestbook_use_language_filter'];
		$backup['guestbook_entries_per_page']			= $enhanced_Config['guestbook_entries_per_page'];
		$backup['guestbook_set_word_limit']				= $enhanced_Config['guestbook_set_word_limit'];
		$backup['guestbook_allow_sign_own']				= $enhanced_Config['guestbook_allow_sign_own'];
		$backup['guestbook_use_entry_limit']			= $enhanced_Config['guestbook_use_entry_limit'];
		$backup['guestbook_entry_limit']				= $enhanced_Config['guestbook_entry_limit'];
		$backup['guestbook_usewordwrap']				= $enhanced_Config['guestbook_usewordwrap'];
		$backup['guestbook_usewordwrap_limit']  		= $enhanced_Config['guestbook_usewordwrap_limit'];
		$backup['guestbook_timeformat']					= $enhanced_Config['guestbook_timeformat'];
		$backup['guestbook_uselocale']					= $enhanced_Config['guestbook_uselocale'];
		$backup['guestbook_localeformat']				= $enhanced_Config['guestbook_localeformat'];
		$backup['comment_allow_sign_own']				= $enhanced_Config['comment_allow_sign_own'];
		$backup['comment_auto_publish']					= $enhanced_Config['comment_auto_publish'];
		$backup['comment_use_bbc_code']					= $enhanced_Config['comment_use_bbc_code'];
		$backup['comment_use_emoticons']				= $enhanced_Config['comment_use_emoticons'];
		$backup['comment_show_avatar']					= $enhanced_Config['comment_show_avatar'];
		$backup['comment_use_language_filter']			= $enhanced_Config['comment_use_language_filter'];
		$backup['comment_entries_per_page']				= $enhanced_Config['comment_entries_per_page'];
		$backup['comment_set_word_limit']				= $enhanced_Config['comment_set_word_limit'];
		$backup['comment_timeformat']					= $enhanced_Config['comment_timeformat'];
		$backup['comment_uselocale']					= $enhanced_Config['comment_uselocale'];
		$backup['comment_localeformat']					= $enhanced_Config['comment_localeformat'];
		$backup['use_pms_testimonial']					= $enhanced_Config['use_pms_testimonial'];
		$backup['testimonial_entries_per_page']			= $enhanced_Config['testimonial_entries_per_page'];
		$backup['testimonial_set_word_limit']			= $enhanced_Config['testimonial_set_word_limit'];
		$backup['testimonials_use_language_filter']		= $enhanced_Config['testimonials_use_language_filter'];
		$backup['testimonials_timeformat']				= $enhanced_Config['testimonials_timeformat'];
		$backup['testimonials_uselocale']				= $enhanced_Config['testimonials_uselocale'];
		$backup['testimonials_localeformat']			= $enhanced_Config['testimonials_localeformat'];
		$backup['zoomversion']							= $enhanced_Config['zoomversion'];
		$backup['setzoomsize']							= $enhanced_Config['setzoomsize'];
		$backup['zoomimagewidth'] 						= $enhanced_Config['zoomimagewidth'];
		$backup['zoomimageheight']						= $enhanced_Config['zoomimageheight'];
		$backup['show_photos_number']					= $enhanced_Config['show_photos_number'];
		$backup['show_mp3_number']						= $enhanced_Config['show_mp3_number'];
		$backup['use_zoom_mp3_filter']					= $enhanced_Config['use_zoom_mp3_filter'];
		$backup['showzoomimagehits']					= $enhanced_Config['showzoomimagehits'];
		$backup['showzoomimagerating']					= $enhanced_Config['showzoomimagerating'];
		$backup['use_zoom_limiter']						= $enhanced_Config['use_zoom_limiter'];
		$backup['use_zoom_keyword']						= $enhanced_Config['use_zoom_keyword'];
		$backup['use_zoom_maxnr']						= $enhanced_Config['use_zoom_maxnr'];
		$backup['use_zoom_maxnr_mp3']					= $enhanced_Config['use_zoom_maxnr_mp3'];
		$backup['zoom_orderMethod']						= $enhanced_Config['zoom_orderMethod'];
		$backup['zoom_orderMethod_mp3']					= $enhanced_Config['zoom_orderMethod_mp3'];
		$backup['zoom_full_link']						= $enhanced_Config['zoom_full_link'];
		$backup['zoom_full_link_mp3']					= $enhanced_Config['zoom_full_link_mp3'];
		$backup['zoom_popupopen']						= $enhanced_Config['zoom_popupopen'];
		$backup['sb_use_fb']							= $enhanced_Config['sb_use_fb'];
		$backup['show_forum_karma']						= $enhanced_Config['show_forum_karma'];
		$backup['show_forum_ranking']					= $enhanced_Config['show_forum_ranking'];
		$backup['show_forum_post_number']				= $enhanced_Config['show_forum_post_number'];
		$backup['sb_forum_posts_per_page']				= $enhanced_Config['sb_forum_posts_per_page'];
		$backup['sb_forum_chkgid']						= $enhanced_Config['sb_forum_chkgid'];
		$backup['show_add_del_bud_link']				= $enhanced_Config['show_add_del_bud_link'];
		$backup['allow_pmbuddy']						= $enhanced_Config['allow_pmbuddy'];
		$backup['allow_onlinebuddy']					= $enhanced_Config['allow_onlinebuddy'];
		$backup['allow_guestbookbuddy']					= $enhanced_Config['allow_guestbookbuddy'];
		$backup['buddylist_sender']						= $enhanced_Config['buddylist_sender'];
		$backup['buddylist_use_pms_notify']				= $enhanced_Config['buddylist_use_pms_notify'];
		$backup['buddies_per_page']						= $enhanced_Config['buddies_per_page'];
		$backup['allow_cbsearchviewbyGID']				= $enhanced_Config['allow_cbsearchviewbyGID'];
		$backup['allow_cbesearch_module']				= $enhanced_Config['allow_cbesearch_module'];
		$backup['searchtab1']							= $enhanced_Config['searchtab1'];
		$backup['searchtab2']							= $enhanced_Config['searchtab2'];
		$backup['searchtab_color']						= $enhanced_Config['searchtab_color'];
		$backup['show_advanced_search_tab']				= $enhanced_Config['show_advanced_search_tab'];
		$backup['cbsearch_geo_dist']					= $enhanced_Config['cbsearch_geo_dist'];
		$backup['onlinenow']							= $enhanced_Config['onlinenow'];
		$backup['picture']								= $enhanced_Config['picture'];
		$backup['added10']								= $enhanced_Config['added10'];
		$backup['online10']								= $enhanced_Config['online10'];
		$backup['search_age_common_style']				= $enhanced_Config['search_age_common_style'];
		$backup['cbs_allow_profile_popup']				= $enhanced_Config['cbs_allow_profile_popup'];
		$backup['cbsearchlistid']						= $enhanced_Config['cbsearchlistid'];
		$backup['cbsearch_expire_time']					= $enhanced_Config['cbsearch_expire_time'];
		$backup['cbsearch_css1']						= $enhanced_Config['cbsearch_css1'];
		$backup['cbsearch_css2']						= $enhanced_Config['cbsearch_css2'];
		$backup['journal_set_word_limit']				= $enhanced_Config['journal_set_word_limit'];
		$backup['journal_entries_per_page']				= $enhanced_Config['journal_entries_per_page'];
		$backup['journal_timeformat']					= $enhanced_Config['journal_timeformat'];
		$backup['journal_uselocale']					= $enhanced_Config['journal_uselocale'];
		$backup['journal_localeformat']					= $enhanced_Config['journal_localeformat'];
		$backup['author_subscribe']						= $enhanced_Config['author_subscribe'];
		$backup['allow_pmauthor']						= $enhanced_Config['allow_pmauthor'];
		$backup['allow_onlineauthor']					= $enhanced_Config['allow_onlineauthor'];
		$backup['articles_per_page']					= $enhanced_Config['articles_per_page'];
		$backup['profile_allow_colors']					= $enhanced_Config['profile_allow_colors'];
		$backup['profile_color']						= $enhanced_Config['profile_color'];
		$backup['profile_by_name']						= $enhanced_Config['profile_by_name'];
		$backup['tooltip_wz']							= $enhanced_Config['tooltip_wz'];
		$backup['profile_langFilterText']				= $enhanced_Config['profile_langFilterText'];
		$backup['pic2pic']								= $enhanced_Config['pic2pic'];
		$backup['pic2profile']							= $enhanced_Config['pic2profile'];
		$backup['showage']								= $enhanced_Config['showage'];
		$backup['show_zodiacs']							= $enhanced_Config['show_zodiacs'];
		$backup['show_zodiacs_static']					= $enhanced_Config['show_zodiacs_static'];
		$backup['show_zodiacs_ch']						= $enhanced_Config['show_zodiacs_ch'];
		$backup['uhp_integration']						= $enhanced_Config['uhp_integration'];
		$backup['show_easyProfileLink']					= $enhanced_Config['show_easyProfileLink'];
		$backup['flatten_tabs']							= $enhanced_Config['flatten_tabs'];
		$backup['full_editorfield']						= $enhanced_Config['full_editorfield'];
		$backup['rateit_allow']							= $enhanced_Config['rateit_allow'];
		$backup['rateit_form']							= $enhanced_Config['rateit_form'];
		$backup['rateit_self']							= $enhanced_Config['rateit_self'];
		$backup['rateit_guest']							= $enhanced_Config['rateit_guest'];
		$backup['rateit_stars']							= $enhanced_Config['rateit_stars'];
		$backup['rateit_count']							= $enhanced_Config['rateit_count'];
		$backup['rateit_precision']						= $enhanced_Config['rateit_precision'];
		$backup['rateit_result_allow']					= $enhanced_Config['rateit_result_allow'];
		$backup['rateit_days']							= $enhanced_Config['rateit_days'];
		$backup['rateit_mod']							= $enhanced_Config['rateit_mod'];
		$backup['rateit_iconfull']						= $enhanced_Config['rateit_iconfull'];
		$backup['rateit_iconhalf']						= $enhanced_Config['rateit_iconhalf'];
		$backup['rateit_mvalue']						= $enhanced_Config['rateit_mvalue'];
		$backup['rateit_cvalue']						= $enhanced_Config['rateit_cvalue'];
		$backup['profile_txt_wordwrap']					= $enhanced_Config['profile_txt_wordwrap'];
		$backup['lastvisitors_maxentry']				= $enhanced_Config['lastvisitors_maxentry'];
		$backup['lastvisitors_showtime']				= $enhanced_Config['lastvisitors_showtime'];
		$backup['lastvisitors_showgender']				= $enhanced_Config['lastvisitors_showgender'];
		$backup['lastvisitors_countself']				= $enhanced_Config['lastvisitors_countself'];
		$backup['lastvisitors_owneronly']				= $enhanced_Config['lastvisitors_owneronly'];
		$backup['lastvisitors_showonline']				= $enhanced_Config['lastvisitors_showonline'];
		$backup['lastvisitors_showage']					= $enhanced_Config['lastvisitors_showage'];
		$backup['lastvisitors_birthday_field']			= $enhanced_Config['lastvisitors_birthday_field'];
		$backup['lastvisitors_gender_field']			= $enhanced_Config['lastvisitors_gender_field'];
		$backup['lastvisitors_datestring']				= $enhanced_Config['lastvisitors_datestring'];
		$backup['lastvisitors_showvisitcount']			= $enhanced_Config['lastvisitors_showvisitcount'];
		$backup['lastvisitors_showvisitedtab']			= $enhanced_Config['lastvisitors_showvisitedtab'];
		$backup['lastvisitors_showtitlerow']			= $enhanced_Config['lastvisitors_showtitlerow'];
		$backup['lastvisitors_showuserfield']			= $enhanced_Config['lastvisitors_showuserfield'];
		$backup['lastvisitors_userfield']				= $enhanced_Config['lastvisitors_userfield'];
		$backup['lastvisitors_female']					= $enhanced_Config['lastvisitors_female'];
		$backup['lastvisitors_femaleimage']				= $enhanced_Config['lastvisitors_femaleimage'];
		$backup['lastvisitors_male']					= $enhanced_Config['lastvisitors_male'];
		$backup['lastvisitors_maleimage']				= $enhanced_Config['lastvisitors_maleimage'];
		$backup['lastvisitors_couple1']					= $enhanced_Config['lastvisitors_couple1'];
		$backup['lastvisitors_couple1image']			= $enhanced_Config['lastvisitors_couple1image'];
		$backup['lastvisitors_couple2']					= $enhanced_Config['lastvisitors_couple2'];
		$backup['lastvisitors_couple2image']			= $enhanced_Config['lastvisitors_couple2image'];
		$backup['lastvisitors_couple3']					= $enhanced_Config['lastvisitors_couple3'];
		$backup['lastvisitors_couple3image']			= $enhanced_Config['lastvisitors_couple3image'];
		$backup['lastvisitors_neutralimage']			= $enhanced_Config['lastvisitors_neutralimage'];
		$backup['lastvisitors_onlineimage']				= $enhanced_Config['lastvisitors_onlineimage'];
		$backup['lastvisitors_offlineimage']			= $enhanced_Config['lastvisitors_offlineimage'];
		$backup['groupjive_integration']				= $enhanced_Config['groupjive_integration'];
		$backup['show_gj_owned_groups']					= $enhanced_Config['show_gj_owned_groups'];
		$backup['link_gj_owned_groups']					= $enhanced_Config['link_gj_owned_groups'];
		$backup['show_profile_hits']					= $enhanced_Config['show_profile_hits'];
		$backup['show_profile_stats']					= $enhanced_Config['show_profile_stats'];
		$backup['show_core_usertype']					= $enhanced_Config['show_core_usertype'];
		$backup['topMost_active']					 	= $enhanced_Config['topMost_active'];
		$backup['topMostLimit']							= $enhanced_Config['topMostLimit'];
		$backup['geocoder_google_apikey']				= $enhanced_Config['geocoder_google_apikey'];
		$backup['geocoder_geocode_byJS']				= $enhanced_Config['geocoder_geocode_byJS'];
		$backup['geocoder_useragree_usage']				= $enhanced_Config['geocoder_useragree_usage'];
		$backup['geocoder_lock_addr_on_success']		= $enhanced_Config['geocoder_lock_addr_on_success'];
		$backup['geocoder_show_acc']					= $enhanced_Config['geocoder_show_acc'];
		$backup['geocoder_allow_visualverify']			= $enhanced_Config['geocoder_allow_visualverify'];
		$backup['geocoder_allow_visualrelocate']		= $enhanced_Config['geocoder_allow_visualrelocate'];
		$backup['geocoder_allow_visualrelocate_onclick']= $enhanced_Config['geocoder_allow_visualrelocate_onclick'];
		$backup['geocoder_use_addrfield']				= $enhanced_Config['geocoder_use_addrfield'];
		$backup['geocoder_use_addrfield_auto']			= $enhanced_Config['geocoder_use_addrfield_auto'];
		$backup['geocoder_street_dbname']				= $enhanced_Config['geocoder_street_dbname'];
		$backup['geocoder_postcode_dbname']				= $enhanced_Config['geocoder_postcode_dbname'];
		$backup['geocoder_city_dbname']					= $enhanced_Config['geocoder_city_dbname'];
		$backup['geocoder_state_dbname']				= $enhanced_Config['geocoder_state_dbname'];
		$backup['geocoder_country_dbname']				= $enhanced_Config['geocoder_country_dbname'];
		$backup['geocoder_do_export']					= $enhanced_Config['geocoder_do_export'];
		$backup['geocoder_show_usermap']				= $enhanced_Config['geocoder_show_usermap'];
		$backup['geocoder_allow_viewbyGID']				= $enhanced_Config['geocoder_allow_viewbyGID'];
		$backup['geocoder_usermap_height']				= $enhanced_Config['geocoder_usermap_height'];
		$backup['geocoder_usermap_width']				= $enhanced_Config['geocoder_usermap_width'];
		$backup['geocoder_usermap_interval']			= $enhanced_Config['geocoder_usermap_interval'];
		$backup['geocoder_scanwide']					= $enhanced_Config['geocoder_scanwide'];
		$backup['geocoder_usermap_force_center']		= $enhanced_Config['geocoder_usermap_force_center'];
		$backup['geocoder_usermap_center_lat']			= $enhanced_Config['geocoder_usermap_center_lat'];
		$backup['geocoder_usermap_center_lng']			= $enhanced_Config['geocoder_usermap_center_lng'];
		$backup['geocoder_usermap_force_unsharp']		= $enhanced_Config['geocoder_usermap_force_unsharp'];
		$backup['geocoder_usermap_force_unsharp_digit']	= $enhanced_Config['geocoder_usermap_force_unsharp_digit'];
		$backup['geocoder_usermap_showsearch']			= $enhanced_Config['geocoder_usermap_showsearch'];
		$backup['geocoder_usermap_start_zoom']			= $enhanced_Config['geocoder_usermap_start_zoom'];
		$backup['geocoder_usermap_start_type']			= $enhanced_Config['geocoder_usermap_start_type'];

		$query = 'TRUNCATE TABLE #__cbe_config_enh';
		$database->setQuery($query);
		if (!$database->query())
			echo("SQL error: ".$database->stderr(true));
		foreach ($backup as $key => $value) {
			$query = 'INSERT INTO #__cbe_config_enh ( varname, value ) VALUES ( '.$database->Quote($key).', '.$database->Quote($value).' )';
			$database->setQuery($query);
			if (!$database->query())
				echo("SQL error: ".$database->stderr(true));
		}
		$mainframe->redirect( "index.php?option=com_cbe&task=tools", "Enhanced Configuration file stored in DB");
	}
	elseif ($func=="restoreenh") {
		global $mainframe;

		//Add code to check if config file is writeable.
		$configfile = "components/com_cbe/enhanced_admin/enhanced_config.php";
		@chmod ($configfile, 0766);
		if (!is_writable($configfile)) {
			return JError::raiseWarning( '', JText::_( "Enhanced Config File not writeable" ) );
		}
	
		$query = "SELECT varname, value FROM #__cbe_config_enh";
        $database->setQuery($query);
        $results = $database->loadObjectList();
		if (!$database->query())
			echo("SQL error: ".$database->stderr(true));
		$txt = "<?php\n";
        foreach ($results as $result) {
			if (substr($result->varname,0,1)!='_'){
				//if (strpos( $result->varname, 'cfg_' ) === 0) {
					if (!get_magic_quotes_gpc()) {
						$result->value = addslashes( $result->value );
					}
					//$txt .= "\$ueConfig['".substr( $result->varname, 4 )."']='$result->value';\n";
					$txt .= "\$enhanced_Config['";
					$txt .= $result->varname;
					$txt .= "']='";
					$txt .= $result->value;
					$txt .= "';\n";
				//}
			}
		}
		$txt .= "?>";
		
		if ($fp = fopen( $configfile, "w")) {
			fputs($fp, $txt, strlen($txt));
			fclose ($fp);
			$mainframe->redirect( "index.php?option=com_cbe&task=tools", "Enhanced Configuration file restored from DB");
		} else {
			return JError::raiseWarning( '', JText::_( "Enhanced Config File not writeable" ) );
		}
	}
}

?>
