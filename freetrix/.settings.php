<?php
return array (
  'utf_mode' => 
  array (
    'value' => true,
    'readonly' => true,
  ),
  'cache' => array(
    'value' => array('type' => 'none'),
    'readonly' => false
    ),
  'cache_flags' => 
  array (
    'value' => 
    array (
      'config_options' => 3600,
      'site_domain' => 3600,
    ),
    'readonly' => false,
  ),
  'cookies' => 
  array (
    'value' => 
    array (
      'secure' => false,
      'http_only' => true,
    ),
    'readonly' => false,
  ),
  'exception_handling' => 
  array (
    'value' => 
    array (
      'debug' => true,
      'handled_errors_types' => 4437,
      'exception_errors_types' => 4437,
      'ignore_silence' => false,
      'assertion_throws_exception' => true,
      'assertion_error_type' => 256,
      'log' => NULL,
    ),
    'readonly' => false,
  ),
  'connections' => 
  array (
    'value' => 
    array (
      'default' => 
      array (
        'dbType' => 'mysql',
        'className' => '\\Freetrix\\Main\\DB\\MysqlConnection',
        'host' => 'localhost',
        'database' => 'freetrix_cms',
        'login' => 'root',
        'password' => 'root',
        'options' => 2,
        'debug' => false,
        'debugToFile' => false,
        'charset' => 'utf8'
      ),
    ),
    'readonly' => true,
  ),
);
