CREATE TABLE `#__blog_comment` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL COMMENT 'Blog_post_id',
  `comment_title` varchar(150) NOT NULL,
  `comment_desc` varchar(240) NOT NULL,
  `comment_date` datetime NOT NULL,
  `comment_update` datetime default NULL,
  `comment_ip` varchar(15) NOT NULL,
  `comment_hit` int(11) default NULL,
  `checked_out` mediumint(9) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `published` tinyint(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'; 
CREATE TABLE `#__blog_postings` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `post_title` varchar(150) NOT NULL,
  `post_desc` varchar(240) NOT NULL,
  `post_image` varchar(255) default NULL,
  `post_date` datetime NOT NULL,
  `post_update` datetime default NULL,
  `post_ip` varchar(15) default NULL,
  `post_hits` int(11) default '0',
  `checked_out` mediumint(9) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `published` tinyint(1) NOT NULL default '1' COMMENT '1-Active, 2-Deactive',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';