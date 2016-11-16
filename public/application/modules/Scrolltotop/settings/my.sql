INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('scrolltotop', 'Scroll To Top', 'Scroll To Top module', '4.0.1', 1, 'extra') ;

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_scroll_to_top', 'scrolltotop', 'Scroll To Top', '', '{"route":"admin_default","module":"scrolltotop","controller":"manage"}', 'core_admin_main_plugins', '', 1);