<?php

return array(

/**  [ Backup Storage Settings ]  **/
//Full path to the location where snapshots are stored
//No Trailing Slash
"STORAGE_PATH" => getenv('HOME'). "/msnap/snapshots",

/**  [ Security Settings ]   **/
//When set to true, forces a browser session to authenticate
//this is used so that the cli interface can store credentials
//while forcing a browser to "login"
"FORCE_LOGIN" => false,

//This is the chmod that will be used when creating new
//folders for projects or snapshots
"DEFAULT_CHMOD" => 0777,


/**  [ MySQL Connection Settings ]   **/
//Mysql Hostname
"MYSQL_HOST" => "localhost",

//Mysql Port
"MYSQL_PORT" => "3306",

//MySql Username to use to connect
"MYSQL_USER" => "ubuntu",

//MySql password to use to connect
"MYSQL_PASSWORD" =>  ""
);