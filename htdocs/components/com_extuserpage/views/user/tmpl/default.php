<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<?php /* user hedeer */ ?>
<table width="100%" style="border: 1px solid red">
    <tr>
	<td>
	    <img src="<?php echo $this->userinfo{'url.avatar'}; ?>">
	</td>
	<td>
	    <h2><a href="<?php echo $this->userinfo{'url.profile'}; ?>"><?php echo $this->userinfo{'user.name'}; ?></a></h2>
	</td>
    </tr>
</table>

<div id="ja-mainnavwrap">
    <div id="ja-mainnav" class="clearfix">
	<ul id="mainlevel-nav">
<?php
foreach ($this->menu as $mwalk => $mcur93)
{
?>
	    <li>
		<a href="<?=$mcur93{'url'};?>" class="mainlevel-nav"><?=$mcur93{'label'};?></a>
	    </li>
<?php    

}

?>
	</ul>
    </div>
</div>

<p> &nbsp; </p>

<?php if ($this->menu_ent{'type'} == 'title') {	?>

<br />
<div>

<?=$this->titlepage_body; ?>

</div>
<?php } ?>
