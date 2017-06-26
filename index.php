<?php

require_once("settings.php");
require_once "libs/utility.php";
require_once "libs/database.php";
require_once "libs/snapshot.php";


$action = "list";

if(isset($_GET) && array_key_exists("action", $_GET)) {
  $action = $_GET['action'];
}

session_start();

if(!attemptDBConnect()) {
  $action = "login";
} else {
  $showMenu = true;
}




include "templates/header.tpl";

if($showMenu) {
  include "templates/menu.tpl";
}

include "templates/status.tpl";
include "actions/{$action}.php";
include "templates/modal.tpl";
include "templates/loading.tpl";
include "templates/footer.tpl";
