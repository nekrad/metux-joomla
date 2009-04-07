<form action="." name="mod_bugreport">
    <textarea name="mod_bugreport_message"></textarea>
    <input type="hidden" name="option" value="com_frontpage" />
    <input type="submit" value="<?php echo $mod_bugreport_sendbutton; ?>" />
    <input type="hidden" name="mod_bugreport_kickback" value="<?php echo $mod_bugreport_kickback; ?>" />
    <input type="hidden" name="mod_bugreport_url"      value="<?php echo $mod_bugreport_url; ?>" />
</form>
