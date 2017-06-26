<?php



$db = false;

/**
 * Helper function to return the username we are using
 *
 * @return bool|string
 */
function getDBUser() {

  if(PHP_SAPI == "cli") {
    return MYSQL_USER;
  }

  if(array_key_exists("username", $_SESSION)) {
    return $_SESSION['username'];
  } else if (defined("MYSQL_USER")) {
    return MYSQL_USER;
  }

  return false;
}

/**
 * Helper function to return the password we are using
 *
 * @return bool|string
 */
function getDBPass() {

  if(PHP_SAPI == "cli") {
    return MYSQL_PASSWORD;
  }

  if(array_key_exists("password", $_SESSION)) {
    return $_SESSION['password'];
  } else if (defined("MYSQL_PASSWORD") && !FORCE_LOGIN) {
    return MYSQL_PASSWORD;
  }

  return false;
}


/**
 * Attempt to connect to the MySQL server with either the defined
 * or provided credentials
 *
 * @param null $username
 * @param null $password
 * @return bool
 */
function attemptDBConnect($username = null, $password = null) {
  global $db;


  if(is_null($username)) {
    $username = getDBUser();
    if(!$username) {
      return false;
    }
  }

  if(is_null($password)) {
    $password = getDBPass();
    if(!$password) {
      return false;
    }
  }

  $db = new mysqli(MYSQL_HOST, $username, $password);

  if ($db->connect_errno) {
    return false;
  }

  return true;
}


/**
 * Fetch all the available schemas
 * @return array
 */
function getAllSchemas() {
  global $db;
  $schemas = array();
  $result = $db->query("SHOW SCHEMAS");
  while($name = $result->fetch_assoc()) {
    $schemas[] = $name['Database'];
  }
  return $schemas;
}


/**
 * Helper function to wipe out a schema so it can be restored
 *
 * @param $schema
 * @return bool
 */
function wipeSchema($schema) {
  global $db;
  if(!$db->query("DROP SCHEMA IF EXISTS `{$schema}`;")) {
    return false;
  }
  return $db->query("CREATE SCHEMA `{$schema}`;");
}


/**
 * Helper function to verify that a schema has at
 * least one table created
 *
 * @param $schema
 * @return bool
 */
function verifySchemaNotEmpty($schema) {
  global $db;
  $escapedName = $db->escape_string($schema);
  $sql = "SELECT COUNT(*) AS `count` FROM `information_schema`.`tables` WHERE `table_schema` = '{$escapedName}'";
  $count = $db->query($sql)->fetch_object()->count;
  return ($count > 0);
}