<?php defined('_JEXEC') or die('Restricted access');?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl; ?>/components/com_blog/style.css">
<form action="<?php echo JRoute::_( 'index.php?option=com_blog&view=blog' ); ?>" method="post" id="josForm" name="josForm"  class="form-validate" enctype="multipart/form-data">
<div>
	<div class="clsLinkedBlog"><?php echo JText::_( 'Add/Update Blog Post' ); ?></div>
	<div id="clsTableTdPadd">
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td height="25" valign="top"><label id="post_titlemsg" for="post_title"><?php echo JText::_( 'Title' ); ?>:</label></td>
			<td valign="top"><div id="clsTableTdPadd"><input type="text" maxlength="150" size="50%"  class="inputbox required" name="post_title" id="post_title" value="<?php echo $this->BlogDetails->post_title;?>" /> *</div></td>
		</tr>
		<tr>
			<td width="19%" height="25" valign="top"><label id="post_descmsg" for="post_desc"><?php echo JText::_( 'Description' ); ?>:</label></td>
			<td width="81%" valign="top">
			<div id="clsTableTdPadd">
				<div><textarea cols="45" rows="6" name="post_desc" id="post_desc" class="inputbox required"  onkeyup="textCounter(document.josForm.post_desc,document.josForm.remLen0,240)" onkeydown="textCounter(document.josForm.post_desc,document.josForm.remLen0,240)" ><?php echo $this->BlogDetails->post_desc;?></textarea> *</div>
				<div><input type="text" value="" maxlength="3" size="3" name="remLen0" readonly=""/> <?php echo JText::_( ' ( characters left )' ); ?> </div>
			</div>
			</td>
		</tr>
		<tr>
			<td height="25" valign="top"><?php echo JText::_( 'Upload Image' ); ?></td>
			<td valign="top">
			<div id="clsTableTdPadd">
				<input type="file" name="image" id="file-upload" /> (.jpeg, .gif, .png only)
				<input type="hidden" name="image_old" id="image_old" value="<?php echo $this->BlogDetails->post_image;?>" />
				<?php if($this->BlogDetails->post_image){?>
				<div align="left">
					<img src="<?php echo $this->baseurl; ?>/components/com_blog/Images/blogimages/<?php echo "th".$this->BlogDetails->post_image;?>"  border="0" alt="Blog Image"  class="clsImgPad" />
				</div>
				<? } ?>
			</div>
			</td>
		</tr>
		<tr>
			<td height="25" valign="top" colspan="2" class="clsTDBorderTop"><label id="product_specialmsg" for="product_special"><?php echo JText::_( 'Do you want to publish?' ); ?>:</label>
			<? print $lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"  size="1"', ( isset($this->BlogDetails->published)) ? $this->BlogDetails->published : 1); ?>
			</td>
		</tr>
		<tr>
			<td colspan="2" height="25" align="right" class="clsTDBorderTop">
				<?php echo JText::_( '* Required' ); ?>
			</td>
		</tr>
		<tr>
			<td height="25"></td>
			<td>
				<button class="button validate" type="button"  onClick="javascript:window.location='<?php echo JRoute::_('index.php?option=com_blog&view=blog' ); ?>'"><?php echo JText::_(' Cancel '); ?></button>
				<button class="button validate" type="submit"><?php echo JText::_('Save Post'); ?></button>	</td>
		</tr>
	</table>
	</div>
</div>
<input type="hidden" name="option" value="com_blog" />
<input type="hidden" name="view" value="addpost" />
<input type="hidden" name="user_id" value="<?php echo $this->user->get('id');?>" />
<input type="hidden" name="id" value="<?php echo $this->BlogDetails->id;?>" />
<input type="hidden" name="controller" value="blog" />
<input type="hidden" name="task" value="save_blogpost" />
</form>
<script language="javascript" type="text/javascript">
	var strpost_descLength   = 240 - document.josForm.post_desc.value.length;
	if(document.josForm.remLen0.value == '' ){
		document.josForm.remLen0.value = strpost_descLength;
	}
	function textCounter(field,cntfield,maxlimit) {
		if (field.value.length > maxlimit) // if too long...trim it!
			field.value = field.value.substring(0, maxlimit);
			// otherwise, update 'characters left' counter
		else
			cntfield.value = maxlimit - field.value.length;
	}
	var thisForm = document.josForm; 
 </script>