<?php
/**
* @version $Id: af.lib.loadmenus.php v.2.1b7 2007-12-05 16:44:59Z GMT-3 $
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

function afMenuAccess() {

   $db =& JFactory::getDBO();

   $query = "SELECT id AS value, name AS text"
   . "\n FROM #__groups"
   . "\n ORDER BY id"
   ;
   $db->setQuery( $query );
   $groups = $db->loadObjectList();
   $access = JHTML::_('select.genericlist', $groups, 'maccess', 'class="inputbox" size="3"', 'value', 'text', '0' );

   return $access;
   
}


function afmenuLinksSecCat( &$menus ) {

		foreach( $menus as $menu ) {
			?>
			<tr>
				<td colspan="2">
				<hr>
				</td>
			</tr>
			<tr>
				<td width="90px" valign="top">
                                <?php echo JText::_( 'ARTF_FORM_TABMENU' );?>
				</td>
				<td>
				<a href="javascript:go2( 'go2menu', '<?php echo $menu->menutype; ?>' );" title="Go to Menu">
				<?php echo $menu->menutype; ?>
				</a>
				</td>
			</tr>
			<tr>
				<td width="90px" valign="top">
				<?php echo JText::_( 'ARTF_FORM_TYPE' );?>
				</td>
				<td>
				<?php echo $menu->type; ?>
				</td>
			</tr>
			<tr>
				<td width="90px" valign="top">
                                <?php echo JText::_( 'ARTF_FORM_ITEMNAME' );?>
				</td>
				<td>
				<strong>
				<a href="javascript:go2( 'go2menuitem', '<?php echo $menu->menutype; ?>', '<?php echo $menu->id; ?>' );" title="<?php echo JText::_( 'ARTF_FORM_GO2MENUITEM' );?>">
				<?php echo $menu->name; ?>
				</a>
				</strong>
				</td>
			</tr>
			<tr>
				<td width="90px" valign="top">
                                <?php echo JText::_( 'ARTF_FORM_STATE' );?>
				</td>
				<td>
				<?php
				switch ( $menu->published ) {
					case -2:
						echo '<font color="red">'.JText::_( 'ARTF_FORM_TRASHED' ).'</font>';
						break;
					case 0:
						echo JText::_( 'ARTF_FORM_UNPUBLISHED' );
						break;
					case 1:
					default:
						echo '<font color="green">'.JText::_( 'ARTF_FORM_PUBLISHED' ).'</font>';
						break;
				}
				?>
				</td>
			</tr>
			<?php
		}
}

function afmenuLinksSecCatJS() {
		?>
		<input type="hidden" name="menu" value="" />
		<input type="hidden" name="menuid" value="" />
		<script type="text/javascript">
		function go2( pressbutton, menu, id ) {
			var form = document.adminForm;

			if (pressbutton == 'go2menu') {
				form.menu.value = menu;
				submitform( pressbutton );
				return;
			}

			if (pressbutton == 'go2menuitem') {
				form.menu.value 	= menu;
				form.menuid.value 	= id;
				submitform( pressbutton );
				return;
			}
		}
		</script>
		<?php
}


?>
