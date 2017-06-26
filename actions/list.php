<?php


$projects = getAllProjects();

if(empty($projects)) {
  alert("There are no Project configured", "info");
} else {
  foreach ($projects as $project) {
    include("templates/project-list.tpl");
  }
}