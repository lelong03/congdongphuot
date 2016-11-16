<?php return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'christmas-snow',
    'version' => '4.0.1',
    'path' => 'application/modules/ChristmasSnow',
    'title' => 'Christmas Snow',
    'description' => 'Christmas Snow',
    'author' => 'Tracy Dev',
    'callback' => 
    array (
      'class' => 'Engine_Package_Installer_Module',
    ),
    'actions' => 
    array (
      0 => 'install',
      1 => 'upgrade',
      2 => 'refresh',
      3 => 'enable',
      4 => 'disable',
    ),
    'directories' => 
    array (
      0 => 'application/modules/ChristmasSnow',
    ),
    'files' => 
    array (
      0 => 'application/languages/en/christmas-snow.csv',
    ),
  ),
); ?>