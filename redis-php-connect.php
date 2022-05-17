<?php

function get_element_from_argv($idx) {
  global $argv;

  if (!isset($argv[$idx])) {
    echo 'expected argument with index '.$idx.'!';
    exit();
  }

  return $argv[$idx];
}

$db_name = strtolower(get_element_from_argv(1));

switch ($db_name) {
  case 'redis':
    $db = new Redis();
    $db->connect('localhost', 6379);
    
    $data = $db->keys('*');
    echo "All initial data:\n";
    for ($i = 0; $i < count($data); $i++) {
      echo $data[$i] . "\n";
    }
    break;

  case 'memcached':
    $db = new Memcached();
    $db->addServer("127.0.0.1", 11211);
    
    $data = $db->getAllKeys();
    echo "All initial data:\n";
    for ($i = 0; $i < count($data); $i++) {
      echo $data[$i]."\n";
    }
    break;

  default:
    exit('Please, specify db name (redis/memcached as first argument)');
    break;
}

$ttl_in_seconds = 60 * 60;

$command = strtolower(get_element_from_argv(2));

if ($command) {
  $key_name = get_element_from_argv(3);
  switch ($command) {
    case 'add':
      $key_value = get_element_from_argv(4);
      
      switch ($db_name) {
        case 'redis':
          $db->set($key_name, $key_value);
          $db->expire($key_name, $ttl_in_seconds);
        case 'memcached':
          $db->set($key_name, $key_value, $ttl_in_seconds);
      }
      break;
    
    case 'delete':
      $db->delete($key_name);
      break;
  }
}
