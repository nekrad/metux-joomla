<?php defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
	
JToolBarHelper::title( JText::_( 'JCE Configuration' ), 'config.png' );
JToolBarHelper::save();
JToolBarHelper::apply();
JToolBarHelper::cancel( 'cancel', JText::_( 'Close' ) );
jceToolbarHelper::help('config');
?>
<form action="index.php" method="post" name="adminForm">
    <div id="config-document">
        <div id="page-setup">
            <table class="noshow">
                <tr>
                    <td>
                        <fieldset class="adminform">
                            <legend><?php echo JText::_( 'Setup' ); ?></legend>
                            <?php if($output = $this->params->render('params', 'setup')) :
                                    echo $output;
                                else :
                                    echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_('No Parameters')."</div>";
                                endif;?>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </div>
        <div id="page-cleanup">
            <table class="noshow">
                <tr>
                    <td>
                        <fieldset class="adminform">
                            <legend><?php echo JText::_( 'Cleanup' ); ?></legend>
                            <?php if($output = $this->params->render('params', 'cleanup')) :
                                    echo $output;
                                else :
                                    echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_('No Parameters')."</div>";
                            endif;?>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </div>
        <div id="page-general">
            <table class="noshow">
                <tr>
                    <td>
                        <fieldset class="adminform">
                            <legend><?php echo JText::_( 'Formatting' ); ?></legend>
                            <?php if($output = $this->params->render('params', 'format')) :
                                        echo $output;
                                    else :
                                        echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_('No Parameters ')."</div>";
                            endif;?>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </div>
        <div id="page-plugins">
            <table class="noshow">
                <tr>
                    <td>
                        <fieldset class="adminform">
                            <legend><?php echo JText::_( 'Plugins' ); ?></legend>
                            <?php if($output = $this->params->render('params', 'plugins')) :
                                        echo $output;
                                    else :
                                        echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_('No Parameters ')."</div>";
                            endif;?>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </div>
        <div id="page-general">
            <table class="noshow">
                <tr>
                    <td>
                        <fieldset class="adminform">
                            <legend><?php echo JText::_( 'General' ); ?></legend>
                            <?php if($output = $this->params->render('params', 'general')) :
                                        echo $output;
                                    else :
                                        echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_('No Parameters ')."</div>";
                            endif;?>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="clr"></div>
    <input type="hidden" name="option" value="com_jce" />
    <input type="hidden" name="client" value="<?php echo $this->client; ?>" />
    <input type="hidden" name="type" value="config" />
    <input type="hidden" name="task" value="" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>