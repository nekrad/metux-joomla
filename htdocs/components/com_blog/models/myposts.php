<?php
/**
 * Hello Model for Hello World Component
 * 
 * @package    Joomla
 * @subpackage Components
 * @license    GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

/**
 * Hello Model
 *
 * @package    Joomla
 * @subpackage Components
 */
class BlogModelMyPosts extends JModel
{
	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * function for Get total Comments
	 **/
	function fncGetTotalComments( $options=array() )
	{
		$db 		=& JFactory::getDBO();
		$id			= @$options['id'];
		
		// WHere conditions
		$wheres[] = 'comment.post_id = ' . (int) $id;
		
		$db		=& JFactory::getDBO();				
		$query	= 	'SELECT COUNT(comment.id)
					FROM #__blog_comment AS comment LEFT JOIN #__users AS user ON comment.user_id = user.id
					WHERE comment.published = "1" AND '. implode( ' AND ', $wheres ).' ORDER BY comment.comment_date ASC';
 		$db->setQuery( $query );
		$count = $db->loadResult();
		return $count;
	}
	
	/***MY POST FUNCTIONS-- Start here*****/
	/**
	 * Gets the Company Profile
	 * @return string The greeting to be displayed to the user
	 */
	function fncGetMyBlogList(  $options=array() )
	{
		global $mainframe, $option;
		
		$config = JFactory::getConfig();
		// Get the pagination request variables
 		
		$this->setState('limit', $mainframe->getUserStateFromRequest('com_blog.limit', 'limit', $config->getValue('config.list_limit'), 'int'));
		$this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
 
		// In case limit has been changed, adjust limitstart accordingly
		$this->setState('limitstart', ($this->getState('limit') != 0 ? (floor($this->getState('limitstart') / $this->getState('limit')) * $this->getState('limit')) : 0));
		
		$db 		=& JFactory::getDBO();
		$id			= @$options['user_id'];
		// WHere conditions
		$wheres[] = 'post.user_id = ' . (int) $id;		
				
		$query	= 'SELECT post.*, user.name AS postedby
				FROM #__blog_postings AS post LEFT JOIN #__users AS user ON post.user_id = user.id
				WHERE  '. implode( ' AND ', $wheres ).' ORDER BY post_date DESC';
		$bloglist = $this->_getList( $query, $this->getState('limitstart'), $this->getState('limit'));
		return @$bloglist;
	}
	// function for getTotal
	function getMyTotal(  $options=array() )
	{
		$db 		=& JFactory::getDBO();
		$id			= @$options['user_id'];
		// WHere conditions
		$wheres[] = 'user_id = ' . (int) $id;	
		
		$query = 'SELECT * FROM #__blog_postings WHERE '. implode( ' AND ', $wheres ).' ORDER BY post_date DESC';
		$bloglist = $this->_getList( $query);
		$this->_total = count($bloglist);
		return $this->_total;
	}
	// Get pagination
	function getMyPagination($options)
    {
      // Lets load the content if it doesn't already exist
      if (empty($this->_pagination))
      {
         jimport('joomla.html.pagination');
         $this->_pagination = new JPagination( $this->getMyTotal($options), $this->getState('limitstart'), $this->getState('limit') );
    }
      return $this->_pagination;
   }
	/***MY POST FUNCTIONS-- End here*****/
}
?>