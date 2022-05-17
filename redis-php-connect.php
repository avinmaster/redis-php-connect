<?php

function get_element_from_argv($idx) {
  global $argv;

  if (!isset($argv[$idx])) {
    echo 'expected argument with index '.$idx.'!';
    exit();
  }

  return $argv[$idx];
}

if (get_element_from_argv(1) === 'redis') {
  $redis = new Redis();
  $redis->connect('localhost', 6379);
  $redis->auth('password');

  $minutes_to_expire = 60;

  $command = get_element_from_argv(2);
  
  if ($command) {
    $key_name = get_element_from_argv(3);
    switch ($command) {
      case 'add':
        $key_value = get_element_from_argv(4);
        $redis->set($key_name, $key_value);
        $redis->expire($key_name, $minutes_to_expire * 60);
        echo $redis->get($key_name)."\n";
        break;
      
      case 'delete':
        $redis->delete($key_name);
        break;
    }
  }
}
