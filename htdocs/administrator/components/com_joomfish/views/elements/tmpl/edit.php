<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

	global  $act, $task, $option;
	$user =& JFactory::getUser();
	$db =& JFactory::getDBO();
	//$this->_JoomlaHeader( JText::_('Content elements'), 'extensions', '', false );
	$contentElement = $this->joomfishManager->getContentElement( $this->id );
?>
<?php if ($this->showMessage) : ?>
<?php echo $this->loadTemplate('message'); ?>
<?php endif; ?>
<?php
	jimport('joomla.html.pane');
	$tabs = & JPane::getInstance('tabs');
	echo $tabs->startPane("contentelements");
	echo $tabs->startPanel(JText::_('CONFIGURATION'),"ElementConfig-page");
	?>
<form action="index.php" method="post" name="adminForm">
  <table class="adminList" cellspacing="1">
    <tr>
      <th colspan="3"><?php echo JText::_('General information');?></th>
    </tr>
    <tr align="center" valign="middle">
      <td width="30%" align="left" valign="top"><strong><?php echo JText::_('TITLE_NAME');?></strong></td>
      <td width="20%" align="left" valign="top"><?php echo $contentElement->Name;?></td>
		  <td align="left"></td>
    </tr>
    <tr align="center" valign="middle">
      <td width="30%" align="left" valign="top"><strong><?php echo JText::_('TITLE_AUTHOR');?></strong></td>
      <td width="20%" align="left" valign="top"><?php echo $contentElement->Author;?></td>
		  <td align="left"></td>
    </tr>
    <tr align="center" valign="middle">
      <td width="30%" align="left" valign="top"><strong><?php echo JText::_('TITLE_VERSION');?></strong></td>
      <td width="20%" align="left" valign="top"><?php echo $contentElement->Version;?></td>
		  <td align="left"></td>
    </tr>
    <tr align="center" valign="middle">
      <td width="30%" align="left" valign="top"><strong><?php echo JText::_('TITLE_DESCRIPTION');?></strong></td>
      <td width="20%" align="left" valign="top"><?php echo $contentElement->Description;?></td>
		  <td align="left"></td>
    </tr>
  </table>
  	<?php
  	echo $tabs->endPanel();
  	echo $tabs->startPanel(JText::_('DB Reference'),"ElementReference-page");

  	$contentTable = $contentElement->getTable();
	?>
  <table class="adminList" cellspacing="1">
    <tr>
      <th colspan="2"><?php echo JText::_('DATABASE_INFORMATION');?></th>
    </tr>
    <tr align="center" valign="middle">
      <td width="15%" align="left" valign="top"><strong><?php echo JText::_('DATABASETABLE');?></strong><br /><?php echo JText::_('DATABASETABLE_HELP');?></td>
      <td width="60%" align="left" valign="top"><?php echo $contentTable->Name;?></td>
    </tr>
    <tr align="center" valign="middle">
      <td width="15%" align="left" valign="top"><strong><?php echo JText::_('DATABASEFIELDS');?></strong><br /><?php echo JText::_('DATABASEFIELDS_HELP');?></td>
      <td width="60%" align="left" valign="top">
		  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
			<tr>
				<th><?php echo JText::_('DBFIELDNAME');?></th>
				<th><?php echo JText::_('DBFIELDTYPE');?></th>
				<th><?php echo JText::_('DBFIELDLABLE');?></th>
				<th><?php echo JText::_('TRANSLATE');?></th>
			</tr>
			<?php
			$k=0;
			foreach( $contentTable->Fields as $tableField ) {
				?>
		  <tr class="<?php echo "row$k"; ?>">
				<td><?php echo $tableField->Name ? $tableField->Name : "&nbsp;";?></td>
				<td><?php echo $tableField->Type ? $tableField->Type : "&nbsp;";?></td>
				<td><?php echo $tableField->Lable ? $tableField->Lable : "&nbsp;";?></td>
				<td><?php echo $tableField->Translate ? JText::_('YES') : JText::_('NO');?></td>
			</tr>
				<?php
				$k=1-$k;
			}
			?>
			</table>
			<?php
			?>
			</td>
    </tr>
  </table>
  	<?php
  	echo $tabs->endPanel();
  	echo $tabs->startPanel(JText::_('Sample data'),"ElementSamples-page");
  	$contentTable = $contentElement->getTable();
	?>
  <table class="adminList" cellspacing="1">
    <tr>
      <th><?php echo JText::_('Sample data');?></th>
    </tr>
    <tr align="center" valign="middle">
      <td width="100%" align="center" valign="top">
		  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
			<tr>
			<?php
			$sqlFields = "";
			foreach( $contentTable->Fields as $tableField ) {
				if( $sqlFields!='' ) $sqlFields .= ',';
				$sqlFields .= '`' .$tableField->Name. '`';
				?>
				<th nowrap><?php echo $tableField->Lable;?></th>
				<?php
			}
			?>
			</tr>
			<?php
			$k=0;
			$idname = $this->joomfishManager->getPrimaryKey($contentTable->Name);
			$sql = "SELECT $sqlFields"
			. "\nFROM #__" .$contentTable->Name
			. "\nORDER BY $idname limit 0,10";
			$db->setQuery( $sql	);
			$rows = $db->loadObjectList();
			if( $rows != null ) {
				foreach ($rows as $row) {
				?>
				  <tr class="<?php echo "row$k"; ?>">
					<?php
					foreach( $contentTable->Fields as $tableField ) {
						$fieldName = $tableField->Name;
						$fieldValue = $row->$fieldName;
						if( $tableField->Type='htmltext' ) {
							$fieldValue = htmlspecialchars( $fieldValue );
						}

						if( $fieldValue=='' ) $fieldValue="&nbsp;";
						if( strlen($fieldValue) > 97 ) {
							$fieldValue = substr( $fieldValue, 0, 100) . '...';
						}

						?>
						<td valign="top"><?php echo $fieldValue;?></td>
						<?php
					}
					?>
					</tr>
						<?php
						$k=1-$k;
				}
			}
			?>
			</table>
			<?php
			?>
			</td>
    </tr>
  </table>
<?php
echo $tabs->endPanel();
echo $tabs->endPane();
	?>
</form>