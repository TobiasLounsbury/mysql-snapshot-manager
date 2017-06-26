<?php

//Default Form Actions
$formAction = "Create";
$editName = true;
$project = array("schemas" => array());


//Handle loading a project if we have one.
if(isset($_GET) && array_key_exists("project", $_GET)) {
  $project = loadProjectDef($_GET['project']);
  if($project) {
    $formAction = "Edit";
    $editName = false;
  }
}

//Process the submitted form
if(isset($_POST) && array_key_exists("process", $_POST) && $_POST['process'] == 1) {


  //Validate form input

  //flag for form errors
  $error = false;

  //check / massage the name
  $name = arrayValue("name", $_POST);
  if($name) {
    $project['name'] = strtolower(str_replace(" ", "_", $name));
  } else {
    $error = true;
    alert("Name is a required field", "danger");
  }

  //Check the selected schemas
  $projectSchemas = arrayValue("schemas", $_POST);
  if(!empty($projectSchemas)) {
    $project['schemas'] = $projectSchemas;
  } else {
    $error = true;
    alert("You must select at least one schema to associate with this project.", "danger");
  }

  //load the project title and descriptions
  $project['title'] = arrayValue("title", $_POST, $name);
  $project['description'] = arrayValue("description", $_POST, "");



  //Save the project.
  if(!$error) {
    //Create the folder
    if(verifyProjectFolder($project['name'])) {

      //save the metadata
      if(saveProject($project['name'], $project)) {
        statusMessage("Project Saved", "success");
        //redirect to the index page
        header("location:index.php");
        exit();
      } else {
        alert("Unable to save project metadata", "danger");
      }

    } else {
      alert("Unable to create or update project folder", "danger");
    }
  }
}


//fetch the available schemas so we can generate the form
//elements for selecting related project schemas
$schemas = getAllSchemas();

//render the template
include("templates/project-form.tpl");
