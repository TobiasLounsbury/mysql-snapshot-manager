<?php

/**  [ Backup Storage Settings ]  **/
//Full path to the location where snapshots are stored
//No Trailing Slash
define("STORAGE_PATH", "/home/ubuntu/snapshots");

/**  [ Security Settings ]   **/
//When set to true, forces a browser session to authenticate
//this is used so that the cli interface can store credentials
//while forcing a browser to "login"
define("FORCE_LOGIN", false);

//This is the chmod that will be used when creating new
//folders for projects or snapshots
define("DEFAULT_CHMOD", 0777);


/**  [ MySQL Connection Settings ]   **/
//Mysql Hostname
define("MYSQL_HOST", "localhost");

//Mysql Port
define("MYSQL_PORT", "3306");

//MySql Username to use to connect
define("MYSQL_USER", "user");

//MySql password to use to connect
define("MYSQL_PASSWORD", "");