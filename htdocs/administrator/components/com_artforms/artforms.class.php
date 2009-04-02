<?php
/**
* @version $Id: artforms.class.php v.2.1b7 2007-12-16 16:44:59Z GMT-3 $
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


class mosartforms extends JTable {

  var $id=null;
  var $text=null;
  var $danktext=null;
  var $titel=null;
  var $email=null;
  var $html=null;
  var $seccode=null;
  var $emailfield=null;
  var $ccmail=null;
  var $bccmail=null;
  var $allowatt=null;
  var $allowattfiles=null;
  var $allowattfilesize=null;
  var $published=null;
  var $created=null;
  var $created_by=null;
  var $checked_out=null;
  var $checked_out_time=null;
  var $access=null;
  var $ordering=null;
  var $publish_up=null;
  var $publish_down=null;
  var $modified=null;
  var $modified_by=null;
  var $created_by_alias=null;
  var $author=null;
  var $modifier=null;
  var $afeditor=null;
  var $customjscode=null;
  var $customcss=null;
  var $metadesc=null;
  var $metakey=null;
  var $hits=null;
  var $version=null;
  var $attribs=null;

  function __construct( &$db ) {
    parent::__construct( '#__artforms', 'id', $db );
  }

  function load( $oid=null ){
    parent::load( $oid );
  }
  
}


class mosartforms_item extends JTable {

  var $item_id=null;
  var $form_id=null;
  var $name=null;
  var $type=null;
  var $required=null;
  var $validation=null;
  var $values=null;
  var $default_values=null;
  var $readonly=null;
  var $customcode=null;
  var $item_ordering=null;
  var $layout=null;

  function __construct( &$db ) {
    parent::__construct( '#__artforms_items', 'item_id', $db );
  }

  function load( $oid=null ){
    if( $oid != null ){
       $this->items = null;
    }
    parent::load( $oid );
  }
  
}


class mosartforms_inbox extends JTable {

  var $id=null;
  var $title=null;
  var $form_id=null;
  var $item_name=null;
  var $item_data=null;
  var $form_date=null;

  function __construct( &$db ) {
    parent::__construct( '#__artforms_inbox', 'id', $db );
  }
  
}

?>
