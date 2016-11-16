INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('yhweather', 'Yahoo Weather', 'Yahoo Weather', '4.0.1', 1, 'extra') ;

DROP TABLE IF EXISTS `engine4_yhweather_locations`;
CREATE TABLE IF NOT EXISTS `engine4_yhweather_locations` (
  `location_id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) unsigned default NULL,
  `object_type` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(128) NOT NULL,
  `object_id` int(11) NOT NULL,
  PRIMARY KEY  (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

INSERT INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES
('yhweather_admin_main_settings', 'yhweather', 'Global Settings', '', '{"route":"admin_default","module":"yhweather","controller":"settings"}', 'ynweather_admin_main', '', 1, 0, 1),
('core_admin_main_plugins_yhweather', 'yhweather', 'Yahoo Weather', '', '{"route":"admin_default","module":"yhweather","controller":"settings"}', 'core_admin_main_plugins', '', 1, 0, 888);
