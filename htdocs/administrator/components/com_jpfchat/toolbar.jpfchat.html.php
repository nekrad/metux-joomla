<?php
/**
 * jPFChat15 - A joomla 1.5.x chatroom component
 *
 * @version $Id: jPFChat.php
 * @author Tim Milo
 * @link http://www.jPFChat.com
 * @copyright (C) 2008 ViziMetrics, Inc - All rights reserved.
 * @license GNU/GPL License
 */

defined( '_JEXEC' ) or die( 'Restricted Access' );

class TOOLBAR_jPFChat {

    function _DEFAULT() {

    JToolBarHelper::title(JText::_('jPFChat Administration'),'generic.png');

    JToolBarHelper::save();
    JToolBarHelper::cancel();

   }
}
?>
