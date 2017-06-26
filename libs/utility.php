<?php

/**
 * Helper function to display a message
 * @param $msg
 * @param string $type
 */
function alert($msg, $type = "info") {
  echo "<div class='alert alert-{$type}' role='alert'>{$msg}</div>";
}


/**
 * Helper function that will create a session stored
 * message to be display on the next page load
 *
 * @param $msg
 * @param string $type
 */
function statusMessage($msg, $type = "success") {

  if(!array_key_exists("status", $_SESSION)) {
    $_SESSION['status'] = array();
  }

  $_SESSION['status'][] = array("msg" => $msg, "type" => $type);
}

/**
 * Helper function to display all the status messages
 */
function displayStatusMessages() {
  if(array_key_exists("status", $_SESSION)) {

    foreach($_SESSION['status'] as $status) {
      alert($status['msg'], $status['type']);
    }

    $_SESSION['status'] = array();
  }
}


/**
 * Helper function that can be used from the front-end
 * to spit out an array key if it exists.
 *
 * @param $key
 * @param $data
 * @param null $default
 * @return mixed|null
 */
function arrayValue($key, &$data, $default = null) {
  if($data && is_array($data) && array_key_exists($key, $data)) {
    return $data[$key];
  } else {
    return $default;
  }
}


function checked($key, $data) {
  if(is_array($data) && array_key_exists($key, $data) && $data[$key]) {
    echo 'checked="checked"';
  }
}

function selected($key, $data) {
  if(is_array($data) && in_array($key, $data)) {
    echo 'selected';
  }
}






















