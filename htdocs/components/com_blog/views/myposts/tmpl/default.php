<?php defined('_JEXEC') or die('Restricted access');
$Itemid = JRequest::getVar( 'Itemid', 0, 'get', 'int' );

?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl; ?>/components/com_blog/style.css">
<form action="<?php echo JRoute::_( 'index.php?option=com_blog&view=myposts' ); ?>" method="post" id="josForm" name="josForm">
<div>
	<div class="clsLinkedBlog">
	<div class="clsFloatLeft"><?php echo JText::_( 'Smart Blog' ); ?></div>
	<div class="clsFloatRight clsPostTitle">	
			<img src="<?php echo $this->baseurl; ?>/components/com_blog/Images/icons/all_comments.gif"  border="0" width="16px" align="bottom" alt="My Posts" class="clsImgPadLeft" />
			<?php echo JText::_('My Posts');?>
	</div>
	<div class="clsClearBoth"></div>
	</div>
	<div id="clsTableTdPadd">
		
		<div class="clsFloatRight"><img src="<?php echo $this->baseurl; ?>/components/com_blog/Images/icons/add_blog_post.gif"  border="0" width="16px" align="bottom" alt="Add New Post" />
			<a href="<?php echo JRoute::_( 'index.php?option=com_blog&view=addpost&Itemid='.$Itemid ); ?>"><?php echo JText::_('Add New Post');?></a>
			<?php #echo JText::_('Display Posts : '); echo $this->pagination->getLimitBox(true);?>
		</div>
		<div class="clsClearBoth"></div>
	</div>
</div>
	
<div id="clsWebpageBlueBorder" class="clsCompanyOverView">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="table_row_title">
	<td width="7%" align="center" valign="top"><?php echo JText::_('#');?></td>
	<td width="93%" align="left" valign="top"><?php echo JText::_('Blog Titles');?></td>
  </tr>
  <?php 
  $count=1;
  foreach( $this->bloglists as $bloglist):
  	$class = ($count%2 != 0) ? 'table_row_first' : 'table_row_second'; 
  ?>
  <tr class="<?php echo $class;?>">
	<td align="center" valign="top"><?php echo $count+$this->pagination->limitstart;?>. </td>
	<td align="left" valign="top">
		<?php echo JText::_($bloglist->post_title);?>
		<div id="divBlogDetails">
			<div align="right">
				<?php echo JText::_('Posted On '); echo JHTML::_('date',  $bloglist->post_date, JText::_('DATE_FORMAT_LC1')); ?>
				<img src="<?php echo $this->baseurl; ?>/components/com_blog/Images/icons/comments.gif"  border="0" alt="Comments" />
				<a href="<?php echo JRoute::_( 'index.php?option=com_blog&view=comments&pid='.$bloglist->id.'&Itemid='.$Itemid, false); ?>">
				<?php 
				$options['id']	= $bloglist->id;
				$BlogCommentCount	= $this->modelBlogList->fncGetTotalComments( $options );
				echo JText::_('Comments('.$BlogCommentCount.')');?></a>
				<img src="<?php echo $this->baseurl; ?>/components/com_blog/Images/icons/favorite.gif"  border="0" alt="Edit" />
				<a href="<?php echo JRoute::_( 'index.php?option=com_blog&view=addpost&pid='.$bloglist->id.'&Itemid='.$Itemid, false); ?>"><?php echo JText::_('Edit');?></a>
				
				<?php $delLink = JRoute::_( 'index.php?option=com_blog&view=myposts&task=delete_mypost&pid='.$bloglist->id.'&Itemid='.$Itemid, false);?>
				<img src="<?php echo $this->baseurl; ?>/components/com_blog/Images/icons/delete.gif"  border="0" alt="Delete" />
				<a href="javascript:void(0);"  onClick="javascript:__fncDeletePosts('<?php echo $delLink;?>');return false;"><?php echo JText::_('Delete');?></a>
			</div>
		</div>
	</td>
  </tr>
  <?php
	$count++;
  endforeach;?>
</table>
</div>
<div align="center" id="clsDivMarginTop10">
	<?php echo $this->pagination->getPagesLinks(); ?>
	<div><?php echo $this->pagination->getPagesCounter();?></div>
</div>
<input type="hidden" name="option" value="com_blog" />
<input type="hidden" name="view" value="blog" />
<input type="hidden" name="controller" value="blog" />
<input type="hidden" name="task" value="myposts" />
<input type="hidden" name="user_id" value="<?php echo $this->user->get('id');?>" />
</form>
<script language="javascript" type="text/javascript">
	function  __fncDeletePosts( strLink ){
		if( !confirm("Do you want to delete this post?")){
			return false;
		}
		window.location = strLink;
	}
</script>