<?php return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'seminimenu',
    'version' => '4.0.1',
    'path' => 'application/modules/Seminimenu',
    'title' => 'Social Engine Mini Menu',
    'description' => 'Social Engine Mini Menu',
    'author' => 'Tracy',
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
      0 => 'application/modules/Seminimenu',
    ),
    'files' => 
    array (
      0 => 'application/languages/en/seminimenu.csv',
    ),
  ),
  'routes' => 
  array (
    'seminimenu_friend_requests' => 
    array (
      'route' => 'seminimenu/friend-requests/',
      'defaults' => 
      array (
        'module' => 'seminimenu',
        'controller' => 'index',
        'action' => 'friend-requests',
      ),
    ),
    'seminimenu_notifications' => 
    array (
      'route' => 'seminimenu/notifications/',
      'defaults' => 
      array (
        'module' => 'seminimenu',
        'controller' => 'index',
        'action' => 'notifications',
      ),
    ),
  ),
); ?>