<?php
/**
* @version $Id: artforms.php v.2.1b7 2007-11-26 04:52:59Z GMT-3 $
* @package ArtForms 2.1b7
* @subpackage ArtForms Component
* @copyright Copyright (C) 2005 Andreas Duswald
* @copyright Copyright (C) 2007 InterJoomla. All rights reserved.
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2, see LICENSE.txt
* This version may have been modified pursuant to the
* GNU General Public License, and as distributed it includes or is derivative
* of works licensed under the GNU General Public License or other free
* or open source software licenses.
* See COPYRIGHT.txt for copyright notices and details.
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

require( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_artforms'.DS.'config.artforms.php' );
require( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_artforms'.DS.'lib'.DS.'af.lib.core.php' );
afLoadLib ( 'loadassets' );
showErrRep();

require_once( JApplicationHelper::getPath( 'front_html' ) );

$formid = JArrayHelper::getValue( $_REQUEST, 'formid' );

$Itemid = JArrayHelper::getValue( $_GET, 'Itemid' );
if($Itemid == '' )$Itemid = afGetItemid( $formid );
if($Itemid == '' )$Itemid = '99999';
      

switch($task) {

   case 'ferforms':

      if ( '1' === $afcfg_loadfrontcss )afLoadFECSS();

      if ( '1' === $afcfg_showferforms ){
         ShowFrontRecivedForms( $option );
      } else {
         $mainframe->redirect( JRoute::_( 'index.php?option=com_artforms&Itemid='.$Itemid ) );
      }
      
      if ( '1' === $afcfg_showfrontfooter )echo afFooter();

   break;

   case 'vferforms':

      if ( '1' === $afcfg_loadfrontcss )afLoadFECSS();

      if ( '1' === $afcfg_showferforms ){
         ShowFrontViewRecivedForms( $option );
      } else {
         $mainframe->redirect( JRoute::_( 'index.php?option=com_artforms&Itemid='.$Itemid ) );
      }
      
      if ( '1' === $afcfg_showfrontfooter )echo afFooter();

   break;

   case 'tferforms':

      if ( '1' === $afcfg_loadfrontcss )afLoadFECSS();

      if ( '1' === $afcfg_showferforms ){
         ShowFrontTableRecivedForms( $option );
      } else {
         $mainframe->redirect( JRoute::_( 'index.php?option=com_artforms&Itemid='.$Itemid ) );
      }
      
      if ( '1' === $afcfg_showfrontfooter )echo afFooter();

   break;
   
   default:
   
      if (isset($formid)){

         ShowFrontArtForms( $formid, $option );
         if ( '1' === $afcfg_showfrontfooter )echo afFooter(0);
         
      } else {

         if ( '1' === $afcfg_loadfrontcss )afLoadFECSS();
         ShowFrontRootForms( $option );
         if ( '1' === $afcfg_showfrontfooter )echo afFooter();
         
      }
      
   break;
   
}


function ShowFrontArtForms( $formid, $option ){

   global $mainframe, $my;
   $db =& JFactory::getDBO();
   
   $now = date("Y-m-d H:i:s",strtotime($mainframe->get('requestTime')));
   $nullDate = $db->getNullDate();

   $form_query = "SELECT *"
   . "\n FROM #__artforms"
   . "\n WHERE id='$formid'"
   . "\n AND ( publish_up = " . $db->Quote( $nullDate ) . " OR publish_up <= " . $db->Quote( $now ) . " )"
   . "\n AND ( publish_down = " . $db->Quote( $nullDate ) . " OR publish_down >= " . $db->Quote( $now ) . " )"
   . "\n AND published = 1"
   //. "\n AND access <= " . (int) $my->gid
   ;
   $db->setQuery( $form_query );
   $rows = $db->loadObjectList();

   if(empty($rows)){
   
      $user =& JFactory::getUser();
      echo JText::_('ALERTNOTAUTH');
      if ($user->get('id') < 1) {
         echo "<br />" . JText::_( 'You need to login.' );
      }
      require( AFPATH_SITE.'version.php' );
      return;
   
   } else {
   
      $row = $rows[0];
   
      $item_query = "SELECT *"
      . "\n FROM #__artforms_items"
      . "\n WHERE form_id='$formid'"
      . "\n ORDER BY `item_ordering` ASC"
      ;
      $db->setQuery( $item_query );
      $items = $db->loadObjectList();
   
      JLoader::register('JParameter' , JPATH_LIBRARIES.DS.'joomla'.DS.'html'.DS.'parameter.php');
      $params = new JParameter( $row->attribs, $mainframe->getPath( 'com_xml', 'com_artforms' ), 'component' );
   
      HTML_beartforms::ShowFrontArtForms( $row, $items, $params, $option );

   }
   
}


function ShowFrontRootForms( $option ){

   global $mainframe, $my;
   $db =& JFactory::getDBO();

   $now = date("Y-m-d H:i:s",strtotime($mainframe->get('requestTime')));
   $nullDate = $db->getNullDate();

   $query = "SELECT id, titel, published, access"
   . "\n FROM #__artforms"
   . "\n WHERE published = 1"
   . "\n AND ( publish_up = " . $db->Quote( $nullDate ) . " OR publish_up <= " . $db->Quote( $now ) . " )"
   . "\n AND ( publish_down = " . $db->Quote( $nullDate ) . " OR publish_down >= " . $db->Quote( $now ) . " )"
  // . "\n AND access <= " . (int) $my->gid
   . "\n ORDER BY ordering ASC"
   ;
   $db->setQuery( $query );
   $rows = $db->loadObjectList();

   $queryc = "SELECT a.id"
   . "\n FROM #__components AS a"
   . "\n WHERE a.option = 'com_artforms'"
   . "\n AND a.parent = '0'"
   ;
   $db->setQuery( $queryc );
   $pid = $db->loadResult();

   JLoader::register('JTableComponent', JPATH_LIBRARIES.DS.'joomla'.DS.'database'.DS.'table'.DS.'component.php');
   $prow = new JTableComponent( $db );
   $prow->load( $pid );

   JLoader::register('JParameter' , JPATH_LIBRARIES.DS.'joomla'.DS.'html'.DS.'parameter.php');
   $params = new JParameter( $prow->params, $mainframe->getPath( 'com_xml', $prow->option ), 'component' );
        
   HTML_beartforms::ShowFrontRootForms( $rows, $params, $option );
   
}


function ShowFrontRecivedForms( $option ){

   global $mainframe, $mosConfig_list_limit;
   $db =& JFactory::getDBO();

   $limit = intval( JArrayHelper::getValue($_REQUEST, 'limit', $mosConfig_list_limit) );
   $limitstart = intval( JArrayHelper::getValue($_REQUEST, 'limitstart', 0) );

   $viewform = JArrayHelper::getValue( $_GET, 'viewform', '' );

   $total_query = "SELECT count(a.id)"
   . "\n FROM #__artforms_inbox AS a"
   . "\n ORDER BY id DESC"
   ;
   $db->setQuery( $total_query );
   $total = $db->loadResult();

   jimport('joomla.html.pagination');
   $pageNav = new JPagination( $total, $limitstart, $limit );

   $getonlyform = '';
   if($viewform != '')$getonlyform = "WHERE a.form_id = $viewform";

   $query = "SELECT *"
   . "\n FROM #__artforms_inbox AS a $getonlyform"
   . "\n ORDER BY id DESC"
   ;
   $db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
   $rows = $database->loadObjectList();
        
   HTML_beartforms::ShowFrontRecivedForms( $rows, $pageNav, $option );
   
}


function ShowFrontViewRecivedForms( $option ){

   $db =& JFactory::getDBO();

   $id = JArrayHelper::getValue( $_GET, 'id' );

   $query = "SELECT *"
   . "\n FROM #__artforms_inbox"
   . "\n WHERE id = $id"
   . "\n ORDER BY id DESC"
   ;
   $db->setQuery( $query );
   $rows = $db->loadObjectList();
   $row = $rows[0];
   
   HTML_beartforms::ShowFrontViewRecivedForms( $row, $option );

}


function ShowFrontTableRecivedForms( $option ){

   global $mainframe, $mosConfig_list_limit;
   $db =& JFactory::getDBO();

   $limit = intval( JArrayHelper::getValue($_REQUEST, 'limit', $mosConfig_list_limit) );
   $limitstart = intval( JArrayHelper::getValue($_REQUEST, 'limitstart', 0) );

   $viewform = JArrayHelper::getValue( $_GET, 'viewform', '' );
   
   $total_query = "SELECT count(a.id)"
   . "\n FROM #__artforms_inbox AS a"
   . "\n ORDER BY id DESC"
   ;
   $db->setQuery( $total_query );
   $total = $db->loadResult();

   jimport('joomla.html.pagination');
   $pageNav = new JPagination( $total, $limitstart, $limit );

   $getonlyform = '';
   if($viewform != '')$getonlyform = "WHERE a.form_id = $viewform";
   
   $query = "SELECT *"
   . "\n FROM #__artforms_inbox AS a $getonlyform"
   . "\n ORDER BY id DESC"
   ;
   $db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
   $rows = $db->loadObjectList();

   HTML_beartforms::ShowFrontTableRecivedForms( $rows, $pageNav, $option );

}


?>
