<?php // no direct access
defined('_JEXEC') or die('Restricted access');

$output = '<input style="width: 130px;" name="searchterm" id="mod_search_searchword" alt="'.$button_text.'" class="inputbox'.$moduleclass_sfx.'" type="text" size="'.$width.'" value="'.$text.'"  onblur="if(this.value==\'\') this.value=\''.$text.'\';" onfocus="if(this.value==\''.$text.'\') this.value=\'\';" />';
$select = '
<select name="searchtype">
    <option value="content">'.$label_content.'</option>
    <option value="media">'.$label_media.'</option>
    <option value="countries">'.$label_states.'</option>
    <option value="bio">'.$label_biographies.'</option>
    <option value="flags">'.$label_flags.'</option>
</select>
';

if ($button)
{
    if ($imagebutton)
	$button = '<input type="image" value="'.$button_text.'" class="button'.$moduleclass_sfx.'" src="'.$img.'" onclick="this.form.searchword.focus();"/>';
    else
	$button = '<input type="submit" value="'.$button_text.'" class="button'.$moduleclass_sfx.'" onclick="this.form.searchword.focus();"/>';
}

switch ($button_pos)
{
    case 'top':
	$button = $button.'<br/>';
	$output = $button.$output;
	break;

    case 'bottom':
	$button = '<br/>'.$button;
	$output = $output.$button;
        break;

    case 'right':
	$output = $output.$button;
        break;

    case 'left':

    default:
	$output = $button.$output;
        break;
}

?>
<form action="index.php" method="get">
	<div class="search<?php echo $params->get('moduleclass_sfx') ?>">
		<?php echo $select; ?>
		<?php echo $output;?>
	</div>
	<input type="hidden" name="view"   value="search" />
	<input type="hidden" name="option" value="com_3mpn_guide" />
</form>
