<form action="." name="mod_bugreport">
    <textarea name="mod_bugreport_message"
              class="inputbox"
              onblur="if (this.value='') this.value='<?php echo $mod_bugreport_comment; ?>'"
              onfocus="if (this.value='<?php echo $mod_bugreport_comment;?>') this.value='';"
    ></textarea>
    <input type="hidden" name="option" value="com_frontpage" />
    <input type="submit" value="<?php echo $mod_bugreport_sendbutton; ?>" class="button" />
    <input type="hidden" name="mod_bugreport_kickback" value="<?php echo $mod_bugreport_kickback; ?>" />
    <input type="hidden" name="mod_bugreport_url"      value="<?php echo $mod_bugreport_url; ?>" />
</form>
