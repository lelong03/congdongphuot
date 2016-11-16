INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) 
VALUES  ('christmas-snow', 'Christmas Snow', 'Christmas Snow', '4.0.1', 1, 'extra') ;

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_christmas_snow', 'christmas-snow', 'Christmas Snow', '', '{"route":"admin_default","module":"christmas-snow","controller":"manage"}', 'core_admin_main_plugins', '', 1);