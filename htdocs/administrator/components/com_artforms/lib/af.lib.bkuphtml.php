<?php
/**
* @version $Id: af.lib.bkuphtml.php v.2.1b7 2007-12-09 04:52:59Z GMT-3 $
* @package ArtForms 2.1b7
* @subpackage ArtForms Component
* @original name code from MOSTlyDB Admin
* @original author Mambo Foundation Inc
* @copyright Copyright (C) 2005 Andreas Duswald
* @copyright Copyright (C) 2007 InterJoomla. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
* This version may have been modified pursuant to the
* GNU General Public License, and as distributed it includes or is derivative
* of works licensed under the GNU General Public License or other free
* or open source software licenses.
* See COPYRIGHT.txt for copyright notices and details.
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

global $mainframe;

class HTML_dbadmin
{

        function backupIntro( $tablelist, $p_option )
	{
                afLoadSectionTitle( JText::_( 'ARTF_BKUP_DBBACKUP' ), 'backup', 1, 'images/' );
        ?>
		<form action="index.php?option=com_artforms&task=update&dotask=dobackup" name="artforms" id="artforms" method="post">
		<table border="0" align="center" cellspacing="0" cellpadding="2" width="100%" class="adminform">
		</tr>
		<tr>
			<td><?php echo JText::_( 'ARTF_BKUP_BACKUPPLACESEL' );?><br /> <br />
				<input type="radio" name="OutDest" value="screen" />
					<?php echo JText::_( 'ARTF_BKUP_SCREENDISPLAY' );?><br />
				<input type="radio" name="OutDest" value="remote"/>
					<?php echo JText::_( 'ARTF_BKUP_DLUSERPC' );?><br />
				<input type="radio" name="OutDest" value="local" / checked="checked" >
					<?php echo JText::_( 'ARTF_BKUP_STOREINSERVER' );?>
			</td>
			<td>&nbsp;</td>
			<td><?php echo JText::_( 'ARTF_BKUP_BKUPFORMAT' ); ?><br /> <br />
			<?php if (function_exists('gzcompress'))
			{
			?>
			<input type="radio" name="OutType" value="zip" /><?php echo JText::_( 'ARTF_BKUP_ZIPFORMAT' ); ?><br />
			<?php
			}
			if (function_exists('bzcompress'))
			{
			?>
			<input type="radio" name="OutType" value="bzip" /><?php echo JText::_( 'ARTF_BKUP_BZIPFORMAT' );?><br />
			<?php
			}
			if (function_exists('gzencode'))
			{
			?>
			<input type="radio" name="OutType" value="gzip" /><?php echo JText::_( 'ARTF_BKUP_GZIPFORMAT' );?><br />
			<?php
			}
			?>
			<input type="radio" name="OutType" value="sql" checked="checked" /><?php echo JText::_( 'ARTF_BKUP_SQLFORMAT' );?>
			<br />
			<input type="radio" name="OutType" value="html" /><?php echo JText::_( 'ARTF_BKUP_HTMLFORMAT' );?></td>
		</tr>
		<tr>
		<td> <p><?php echo JText::_( 'ARTF_BKUP_BACKUPMODE' );?><br /><br />
			<input type="radio" name="toBackUp" value="data" /><?php echo JText::_( 'ARTF_BKUP_MODEDATAONLY' );?><br />
			<input type="radio" name="toBackUp" value="structure" /><?php echo JText::_( 'ARTF_BKUP_MODESTRUCTONLY' );?><br />
			<input type="radio" name="toBackUp" value="both" checked="checked" /><?php echo JText::_( 'ARTF_BKUP_MODEBOTH' );?></p>
		</td>
		<td>&nbsp;</td>
		<td>
                  <script type="text/javascript">
                  function tables_select() {
                     formblock = document.getElementById('artforms');
                     forminputs = formblock.getElementById('tables');
                     forminputs.options['0'].selected = true;
                     forminputs.options['1'].selected = true;
                     forminputs.options['2'].selected = true;
                  }
                  </script>
                  <p align="left"><?php echo JText::_( 'ARTF_BKUP_DBSELECTOR' );?></p>
		  <?php echo $tablelist; ?><input type="button" onclick="javascript:tables_select();" class="button" value="<?php echo JText::_( 'ARTF_MULTI_SELECTALL' );?>" />
		</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center">&nbsp;<br /> <input type="submit" value="<?php echo JText::_( 'ARTF_BKUP_BACKUPTABLES' );?>" class="button" /></td>
		</tr>
                <tr>
                        <td colspan="3">&nbsp;</td>
                </tr>
        </table>
	</form>
	<?php
	}

	function restoreIntro($enctype,$uploads_okay,$local_backup_path)
	{
                afLoadSectionTitle( JText::_( 'ARTF_BKUP_DBBACKUP' ), 'backup', 1, 'assets/images/' );
                $file = '';
        ?>
		<table border="0" align="center" cellspacing="0" cellpadding="2" width="100%" class="adminform">
		<form action="index.php?option=com_artforms&task=update&dotask=dorestore" method="post" <?php echo $enctype;?>>
		<tr>
			<th class="title" colspan="3"><?php echo JText::_( 'ARTF_BKUP_EXISTBKUP' );?></th>
		</tr>
		<?php
	if (isset($local_backup_path))
	{
		if ($handle = @opendir($local_backup_path))
		{
		?>
		<tr><td>&nbsp;</td><td><b><?php echo JText::_( 'ARTF_BKUP_BKUPFILENAME' );?></b></td><td><b><?php echo JText::_( 'ARTF_BKUP_BKUPDATETIME' );?></b></td></tr>
		<?php
		while ($file = @readdir($handle))
		{
			if (is_file($local_backup_path . $file))
			{
				if (eregi(".\.sql$",$file) || eregi(".\.bz2$",$file) || eregi(".\.gz$",$file) || eregi(".\.zip$",$file))
				{
					echo "\t\t<tr><td align=\"center\"><input type=\"radio\" name=\"file\" value=\"$file\"></td><td>$file</td><td>" . date("m/d/y H:i:sa", filemtime($local_backup_path . $file)) . "</td></tr>\n";
				}
			}
		}
		}
		else
		{
			echo "\t\t<tr><td colspan=\"3\" class=\"error\">". JText::_( 'ARTF_BKUP_PATHERROR' )." <br />" . $local_backup_path . $file . "</td></tr>\n";
		}
		@closedir($handle);
	}
	else
	{
		echo "\t\t<tr><td colspan=\"3\" class=\"error\">". JText::_( 'ARTF_BKUP_PATHERROR' )."</td></tr>\n";
	}
	if ($uploads_okay)
	{
		?>
		<tr>
			<td colspan="3"><br /><?php echo JText::_( 'ARTF_BKUP_RESTOREFROMPC' );?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><br /><input type="file" name="upfile" class="button"></td>
			<td>&nbsp;</td>
		</tr>
		<?php
	}
		?>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;<br />
			<input type="submit" class="button" value="<?php echo JText::_( 'ARTF_BKUP_DORESTORE' );?>" />&nbsp;&nbsp; <input type="reset" class="button" value="<?php echo JText::_( 'ARTF_BKUP_RESET' ); ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
                        <td colspan="3">&nbsp;</td>
                </tr>
		</form>
	</table>
	<?php
	}
	function showDbAdminMessage( $message, $img )
	{
	        global $mainframe;
                $dotaskchk = JArrayHelper::getValue( $_GET, 'dotask' );
                if( $dotaskchk == 'dobackup' )$dotask = 'dbbackup';elseif( $dotaskchk == 'dorestore' )$dotask = 'dbrestore';
                $msg = $message.'&afimg='.$img;
                $mainframe->redirect( 'index.php?option=com_artforms&task=update&dotask='.$dotask.'&afmsg='.$msg );
	}


}
?>
