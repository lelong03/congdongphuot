<?php
defined('_ENGINE') or die('Access Denied');
return array (
  'default_backend' => 'File',
  'frontend' => 
  array (
    'core' => 
    array (
      'automatic_serialization' => true,
      'cache_id_prefix' => 'Engine4_',
      'lifetime' => '300',
      'caching' => true,
      'gzip' => true,
    ),
  ),
  'backend' => 
  array (
    'Memcached' => 
    array (
      'servers' => 
      array (
        0 => 
        array (
          'host' => '127.0.0.1',
          'port' => 11211,
        ),
      ),
      'compression' => true,
    ),
  ),
  'default_file_path' => '/home/nginx/domains/congdongphuot.com/public/temporary/cache',
); ?>