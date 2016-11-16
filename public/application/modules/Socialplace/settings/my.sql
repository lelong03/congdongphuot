INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('socialplace', 'Social Places', 'Social Places', '4.0.1', 1, 'extra') ;

-- --------------------------------------------------------

--
-- Table structure for table `engine4_socialplace_crawlingdata`
--


CREATE TABLE `engine4_socialplace_crawlingdata` (
  `crawlingdata_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(128) NOT NULL,
  `body` LONGTEXT NOT NULL,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `owner_type` VARCHAR(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `owner_id` INT(11) UNSIGNED NOT NULL,
  `category_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `region_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `photo_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `thumb_image` VARCHAR(255) NULL,
  `creation_date` DATETIME NOT NULL,
  `modified_date` DATETIME NOT NULL,
  `featured` INT(1) DEFAULT '0',
  `price` FLOAT DEFAULT '0' NULL,
  `phone` TEXT NULL,
  `guest_reviews` TEXT NULL,
  `landmarks` TEXT NULL,
  `street_address` VARCHAR(255) NULL,
  `extended_address` VARCHAR(128) NULL,
  `locality` VARCHAR(64) NULL,
  `postal_code` VARCHAR(15) NULL,
  `region` VARCHAR(64) NULL,
  `country` VARCHAR(64) NULL,
  `location` VARCHAR(255) NULL,
  `address` VARCHAR(500) NULL,
  `latitude` VARCHAR(64) NULL, 
  `longitude` VARCHAR(64) NULL,
  `rating` FLOAT NOT NULL DEFAULT '0',
  `view_count` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `comment_count` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `like_count` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `share_count` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `search` TINYINT(1) NOT NULL DEFAULT '1',
  `link_detail` VARCHAR(500) NULL,
  `done` TINYINT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`crawlingdata_id`),
  KEY `title` (`title`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;

-- --------------------------------------------------------

--
-- Table structure for table `engine4_socialplace_places`
--


CREATE TABLE `engine4_socialplace_places` (
  `place_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(128) NOT NULL,
  `body` LONGTEXT NOT NULL,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `owner_type` VARCHAR(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `owner_id` INT(11) UNSIGNED NOT NULL,
  `category_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `region_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `photo_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `thumb_image` VARCHAR(255) NULL,
  `creation_date` DATETIME NOT NULL,
  `modified_date` DATETIME NOT NULL,
  `featured` INT(1) DEFAULT '0',
  `price` FLOAT DEFAULT '0' NULL,
  `phone` TEXT NULL,
  `street_address` VARCHAR(255) NULL,
  `extended_address` VARCHAR(128) NULL,
  `locality` VARCHAR(64) NULL,
  `postal_code` VARCHAR(15) NULL,
  `region` VARCHAR(64) NULL,
  `country` VARCHAR(64) NULL,
  `location` VARCHAR(255) NULL,
  `address` VARCHAR(500) NULL,
  `latitude` VARCHAR(64) NULL, 
  `longitude` VARCHAR(64) NULL,
  `rating` FLOAT NOT NULL DEFAULT '0',
  `view_count` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `comment_count` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `like_count` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `share_count` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `search` TINYINT(1) NOT NULL DEFAULT '1',
  `link_detail` VARCHAR(500) NULL,
  PRIMARY KEY (`place_id`),
  KEY `owner_type` (`owner_type`, `owner_id`),
  KEY `search` (`search`, `creation_date`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;

-- --------------------------------------------------------

--
-- Table structure for table `engine4_socialplace_regions`
--


CREATE TABLE `engine4_socialplace_regions` (
  `region_id` int(11) NOT NULL auto_increment,
  `region_name` varchar(128) NOT NULL,
  `parent_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `photo_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `featured` int(11) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`region_id`),
  KEY `region_id` (`region_id`, `region_name`),
  KEY `region_name` (`region_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;


-- --------------------------------------------------------

--
-- Table structure for table `engine4_socialplace_categories`
--


CREATE TABLE `engine4_socialplace_categories` (
  `category_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) unsigned NOT NULL,
  `category_name` varchar(128) NOT NULL,
  PRIMARY KEY (`category_id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`, `category_name`),
  KEY `category_name` (`category_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;

--
-- Dumping data for table `engine4_socialplace_categories`
--

INSERT IGNORE INTO `engine4_socialplace_categories` (`category_id`, `user_id`, `category_name`) VALUES
(1, 1, 'Hotel'),
(2, 1, 'Resort'),
(3, 1, 'Hostel'),
(4, 1, 'Shared Room');

INSERT IGNORE INTO `engine4_core_menus` (`name`, `type`, `title`) VALUES
('socialplace_main', 'standard', 'Social Place Main Navigation Menu');

-- --------------------------------------------------------

--
-- Dumping data for table `engine4_socialplace_ratings`
--
CREATE TABLE IF NOT EXISTS `engine4_socialplace_ratings` (
  `place_id` int(10) unsigned NOT NULL,
  `user_id` int(9) unsigned NOT NULL,
  `rating` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`place_id`,`user_id`),
  KEY `INDEX` (`place_id`)
);

-- --------------------------------------------------------

--
-- Table structure for table `engine4_socialplace_albums`
--

DROP TABLE IF EXISTS `engine4_socialplace_albums` ;
CREATE TABLE `engine4_socialplace_albums` (
  `album_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `place_id` int(11) unsigned NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` varchar(255) NOT NULL,
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `search` tinyint(1) NOT NULL default '1',
  `photo_id` int(11) unsigned NOT NULL default '0',
  `view_count` int(11) unsigned NOT NULL default '0',
  `comment_count` int(11) unsigned NOT NULL default '0',
  `collectible_count` int(11) unsigned NOT NULL default '0',
   PRIMARY KEY (`album_id`),
   KEY (`place_id`),
   KEY (`search`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;

-- --------------------------------------------------------

--
-- Table structure for table `engine4_socialplace_photos`
--

DROP TABLE IF EXISTS `engine4_socialplace_photos`;
CREATE TABLE `engine4_socialplace_photos` (
  `photo_id` int(11) unsigned NOT NULL auto_increment,
  `album_id` int(11) unsigned NOT NULL,
  `place_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` varchar(255) NOT NULL,
  `collection_id` int(11) unsigned NOT NULL,
  `file_id` int(11) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `view_count` int(11) unsigned NOT NULL default '0',
  `comment_count` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY (`photo_id`),
  KEY (`album_id`),
  KEY (`place_id`),
  KEY (`collection_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;

--
-- Dumping data for table `engine4_core_menuitems`
--

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_main_socialplace', 'socialplace', 'Places', '', '{"route":"socialplace_general"}', 'core_main', '', 4),

('socialplace_main_browse', 'socialplace', 'Browse Places', 'Socialplace_Plugin_Menus::canViewPlaces', '{"route":"socialplace_general"}', 'socialplace_main', '', 1),
('socialplace_main_manage', 'socialplace', 'My Places', 'Socialplace_Plugin_Menus::canCreatePlaces', '{"route":"socialplace_general","action":"manage"}', 'socialplace_main', '', 2),
('socialplace_main_create', 'socialplace', 'Post New Places', 'Socialplace_Plugin_Menus::canCreatePlaces', '{"route":"socialplace_general","action":"create"}', 'socialplace_main', '', 3),

('core_admin_main_plugins_socialplace', 'socialplace', 'Social Places', '', '{"route":"admin_default","module":"socialplace","controller":"manage"}', 'core_admin_main_plugins', '', 999),

('socialplace_admin_main_manage', 'socialplace', 'Manage Places', '', '{"route":"admin_default","module":"socialplace","controller":"manage"}', 'socialplace_admin_main', '', 1),
('socialplace_admin_main_settings', 'socialplace', 'Global Settings', '', '{"route":"admin_default","module":"socialplace","controller":"settings"}', 'socialplace_admin_main', '', 2),
('socialplace_admin_main_level', 'socialplace', 'Member Level Settings', '', '{"route":"admin_default","module":"socialplace","controller":"level"}', 'socialplace_admin_main', '', 3),
('socialplace_admin_main_categories', 'socialplace', 'Categories', '', '{"route":"admin_default","module":"socialplace","controller":"settings", "action":"categories"}', 'socialplace_admin_main', '', 4),
('socialplace_admin_main_regions', 'socialplace', 'Regions', '', '{"route":"admin_default","module":"socialplace","controller":"settings", "action":"regions"}', 'socialplace_admin_main', '', 5),

('authorization_admin_level_socialplace', 'socialplace', 'Places', '', '{"route":"admin_default","module":"socialplace","controller":"level","action":"index"}', 'authorization_admin_level', '', 999);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('socialplace_profile_edit', 'socialplace', 'Edit Profile', 'Socialplace_Plugin_Menus', '', 'socialplace_profile', '', 1),
('socialplace_profile_report', 'socialplace', 'Report Place', 'Socialplace_Plugin_Menus', '', 'socialplace_profile', '', 4),
('socialplace_profile_share', 'socialplace', 'Share', 'Socialplace_Plugin_Menus', '', 'socialplace_profile', '', 5),
('socialplace_profile_delete', 'socialplace', 'Delete Place', 'Socialplace_Plugin_Menus', '', 'socialplace_profile', '', 8);

-- --------------------------------------------------------

--
-- Dumping data for table `engine4_authorization_permissions`
--

-- ALL
-- auth_view, auth_comment, auth_html
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'place' as `type`,
    'auth_view' as `name`,
    5 as `value`,
    '["everyone","owner_network","owner_member_member","owner_member","owner"]' as `params`
  FROM `engine4_authorization_levels` WHERE `type` NOT IN('public');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'place' as `type`,
    'auth_comment' as `name`,
    5 as `value`,
    '["everyone","owner_network","owner_member_member","owner_member","owner"]' as `params`
  FROM `engine4_authorization_levels` WHERE `type` NOT IN('public');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'place' as `type`,
    'auth_html' as `name`,
    3 as `value`,
    'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr' as `params`
  FROM `engine4_authorization_levels` WHERE `type` NOT IN('public');

-- ADMIN, MODERATOR
-- create, delete, edit, view, comment, max
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'place' as `type`,
    'create' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'place' as `type`,
    'delete' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'place' as `type`,
    'edit' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'place' as `type`,
    'view' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'place' as `type`,
    'comment' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'place' as `type`,
    'max' as `name`,
    3 as `value`,
    1000 as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');

-- USER
-- create, delete, edit, view, comment, max
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'place' as `type`,
    'create' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'place' as `type`,
    'delete' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'place' as `type`,
    'edit' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'place' as `type`,
    'view' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'place' as `type`,
    'comment' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'place' as `type`,
    'max' as `name`,
    3 as `value`,
    50 as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');

-- PUBLIC
-- view
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'place' as `type`,
    'view' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('public');
