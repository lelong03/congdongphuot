<?php return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'scrolltotop',
    'version' => '4.0.1',
    'path' => 'application/modules/Scrolltotop',
    'title' => 'Scroll To Top',
    'description' => 'Scroll To Top module',
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
      0 => 'application/modules/Scrolltotop',
    ),
    'files' => 
    array (
      0 => 'application/languages/en/scrolltotop.csv',
    ),
  ),
); ?>