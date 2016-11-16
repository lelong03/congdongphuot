<?php return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'yhweather',
    'version' => '4.0.1',
    'path' => 'application/modules/Yhweather',
    'title' => 'Yahoo Weather',
    'description' => 'Yahoo Weather',
    'author' => 'Tracy Dev',
    'callback' => 
    array (
        'path' => 'application/modules/Yhweather/settings/install.php',    
        'class' => 'Yhweather_Installer',
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
      0 => 'application/modules/Yhweather',
    ),
    'files' => 
    array (
      0 => 'application/languages/en/yhweather.csv',
    ),
  ),
); ?>