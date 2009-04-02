<?php
/**
 * sh404SEF support for com_XXXXX component.
 * Author :
 * contact
 * {shSourceVersionTag: Version w - 2007-08-31}
 *
 * This is a sample sh404SEF native plugin file
 *
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

// ------------------  standard plugin initialize function - don't change 
global $sh_LANG, $sefConfig; 

$shLangName = '';;
$shLangIso = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin( $lang, $shLangName, $shLangIso, $option);
// ------------------  standard plugin initialize function - don't change 

// ------------------  load language file - adjust as needed ----------------------------------------
$shLangIso = shLoadPluginLanguage( 'com_artforms', $shLangIso, '_COM_ARTFORMS_FERFORMS');
// ------------------  load language file - adjust as needed ----------------------------------------

if ( isset($formid) ) {

    $query = 'SELECT titel, id '
            .'FROM #__artforms '
            .'WHERE id = '.$formid
            ;  // select clause includes id, even if
    $database->setQuery($query);

    if (shTranslateUrl($option, $shLangName)) // V 1.2.4.m   // get it in the right language
       $database->loadObject( $formTitle );
    else $database->loadObject( $formTitle, false );        // second param at false forces Joomfish to
                                                               // return default language version instead of
    if ($database->getErrorNum())die( $database->stderr());
    
    $title[] = $formTitle->titel;
    shRemoveFromGETVarsList('formid');

} else {

    if ( isset($task) ) {

       if ($task == 'ferforms') {
          $title[] = $sh_LANG[$shLangIso]['_COM_ARTFORMS_FERFORMS'];
          shRemoveFromGETVarsList('task');
       } elseif ($task == 'tferforms') {
          $title[] = $sh_LANG[$shLangIso]['_COM_ARTFORMS_TFERFORMS'];
          shRemoveFromGETVarsList('task');
       } elseif ($task == 'vferforms') {
          $title[] = $sh_LANG[$shLangIso]['_COM_ARTFORMS_VFERFORMS'];
          shRemoveFromGETVarsList('task');

          if ( isset($id) ) {
             $query = 'SELECT id, title '
                     .'FROM #__artforms_inbox '
                     .'WHERE id = '.$id
                     ;  // select clause includes id, even if
             $database->setQuery($query);

             if (shTranslateUrl($option, $shLangName)) // V 1.2.4.m   // get it in the right language
                $database->loadObject( $rformTitle );
             else $database->loadObject( $rformTitle, false );        // second param at false forces Joomfish to
                                                               // return default language version instead of
             if ($database->getErrorNum())die( $database->stderr());

             $title[] = $rformTitle->title;
             shRemoveFromGETVarsList('id');

          }
          
       }
       
    } else {
    
       $title[] = $sh_LANG[$shLangIso]['_COM_ARTFORMS_AFROOT'];

    }
   
}

// do something about that Itemid thing
if (eregi('Itemid=[0-9]+', $string) === false) { // if no Itemid in non-sef URL
  //global $Itemid;
  if ($sefConfig->shInsertGlobalItemidIfNone && !empty($shCurrentItemid)) {
    $string .= '&Itemid='.$shCurrentItemid;  // append current Itemid
    $Itemid = $shCurrentItemid;
    shAddToGETVarsList('Itemid', $Itemid); // V 1.2.4.m
  }
  if ($sefConfig->shInsertTitleIfNoItemid)
  	$title[] = $sefConfig->shDefaultMenuItemName ?
      $sefConfig->shDefaultMenuItemName : getMenuTitle($option, null, $shCurrentItemid );
  $shItemidString = $sefConfig->shAlwaysInsertItemid ?
    _COM_SEF_SH_ALWAYS_INSERT_ITEMID_PREFIX.$sefConfig->replacement.$shCurrentItemid
    : '';
} else {  // if Itemid in non-sef URL
  $shItemidString = $sefConfig->shAlwaysInsertItemid ?
    _COM_SEF_SH_ALWAYS_INSERT_ITEMID_PREFIX.$sefConfig->replacement.$Itemid
    : '';
}
// for contact page we always add something before contact name
$shTemp = $sefConfig->shDefaultMenuItemName ?
            $sefConfig->shDefaultMenuItemName
          : getMenuTitle($option, null, $Itemid );
if (!empty($shTemp) && $shTemp != '/') $title[] = $shTemp;  // V 1.2.4.t

shRemoveFromGETVarsList('option');
shRemoveFromGETVarsList('lang');
//if (isset($afmsg))
//shRemoveFromGETVarsList('afmsg');
//if (isset($afimg))
//shRemoveFromGETVarsList('afimg');
if (isset($af_mod))
shRemoveFromGETVarsList('af_mod');
if (isset($afmod))
shRemoveFromGETVarsList('no_affoo');
if (isset($afmod))
shRemoveFromGETVarsList('no_afjcss');

if (!empty($Itemid)) 
  shRemoveFromGETVarsList('Itemid');
// optional removal of limit and limitstart
if (!empty($limit))      // use empty to test $limit as $limit is not allowed to be zero
  shRemoveFromGETVarsList('limit'); 
if (isset($limitstart))  // use isset to test $limitstart, as it can be zero
  shRemoveFromGETVarsList('limitstart');

// ------------------  standard plugin finalize function - don't change 
if ($dosef){
   $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString,
      (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null),
      (isset($shLangName) ? @$shLangName : null));
}     
// ------------------  standard plugin finalize function - don't change 
?> 
