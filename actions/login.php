<?php

if(isset($_POST) && array_key_exists("username", $_POST) && array_key_exists("username", $_POST)) {

  if(attemptDBConnect($_POST['username'], $_POST['password'])) {
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
    header("location:index.php");
    exit();
  } else {
    alert("Invalid Login Credentials", "danger");
  }
}


$user = "";
if (defined("MYSQL_USER")) {
  $user = MYSQL_USER;
}

if (array_key_exists("username", $_POST)) {
  $user = $_POST['username'];
}

include "templates/login.tpl";

