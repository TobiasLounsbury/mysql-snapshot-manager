<?php

/**
 * Helper function to compost the path for a given project
 *
 * @param $projectName
 * @return string
 */
function getProjectPath($projectName) {
  return STORAGE_PATH ."/". $projectName;
}

/**
 * Helper function to compose the path to any snapshot
 *
 * @param $projectName
 * @param $snapshotName
 * @return string
 */
function getSnapshotPath($projectName, $snapshotName) {
  return STORAGE_PATH ."/". $projectName ."/". $snapshotName;
}

/**
 * Fetch a list of all defined projects
 *
 * @return array
 */
function getAllProjects() {
  $list = array();

  $dirs = scandir(STORAGE_PATH);

  foreach ($dirs as $dir) {
    $project = loadProjectDef($dir);
    if($project) {
      $list[$dir] = $project;
      $list[$dir]['snapshots'] = loadProjectSnapshots($dir);
    }
  }

  return $list;
}

/**
 * Helper function to load a project definition
 *
 * @param $project
 * @return bool|mixed
 */
function loadProjectDef($project) {
  $path = getProjectPath($project);
  if(is_dir($path) && is_file("{$path}/project.json")) {
    $json = file_get_contents("{$path}/project.json");
    return json_decode($json, true);
  }
  return false;
}

/**
 * Helper function to load the list of all snapshots for
 * a given project
 *
 * @param $project
 * @return array
 */
function loadProjectSnapshots($project) {
  $snapshots = array();

  $path = getProjectPath($project);
  $dirs = scandir($path);
  foreach ($dirs as $dir) {
    if(is_dir("{$path}/{$dir}") && !in_array($dir, array(".", ".."))) {
      $snapshots[] = $dir;
    }
  }

  return $snapshots;
}


/**
 * Helper function to check for the existence of a project
 * folder and create if it doesn't exist.
 *
 * @param $projectName
 * @return bool
 */
function verifyProjectFolder($projectName) {
  $path = getProjectPath($projectName);
  if(is_dir($path)) {
    return true;
  }

  if(mkdir($path, DEFAULT_CHMOD)) {
    chmod($path, DEFAULT_CHMOD);
    return true;
  }
  return false;
}


/**
 * Helper function that writes a project definition
 *
 * @param $project
 * @param $data
 * @return bool
 */
function saveProject($project, $data) {
  $path = getProjectPath($project) ."/project.json";

  if(array_key_exists("snapshots", $data)) {
    unset($data['snapshots']);
  }

  $json = json_encode($data);
  if(file_put_contents($path, $json) !== false ) {
    chmod($path, DEFAULT_CHMOD);
    return true;
  }

  return false;
}


/**
 * Create a snapshot for a given project.
 *
 * @param $project
 * @param $name
 * @return bool
 */
function createProjectSnapshot($project, $name) {
  $path = getSnapshotPath($project['name'], $name);
  if(mkdir($path, DEFAULT_CHMOD)) {
    chmod($path, DEFAULT_CHMOD);
    foreach($project['schemas'] as $schema) {
      $backupFile = $path ."/". $schema .".sql.gz";
      $command = "mysqldump --opt -h " . MYSQL_HOST . " -P ". MYSQL_PORT ." -u". getDBUser() ." -p".  getDBPass() ." {$schema} | gzip > {$backupFile}";
      system($command);
      if(filesize ( $backupFile ) < 100) {
        return false;
      }
      chmod($backupFile, DEFAULT_CHMOD);
    }

    return true;
  } else {
    return false;
  }
}


/**
 * Restore a snapshot
 *
 * @param $project
 * @param $snapshot
 * @return bool|array
 */
function restoreProjectSnapshot(&$project, $snapshot) {

  $path = getSnapshotPath($project['name'], $snapshot);

  $errors = array();

  //First loop through and make sure we have all the schemas
  //for this project.
  foreach($project['schemas'] as $schema) {
    $schemaFile = $path ."/{$schema}.sql.gz";
    if(!is_file($schemaFile)) {
      $errors[] = "Schema file '{$schemaFile}' is missing";
    }
  }

  if(!empty($errors)) {
    return $errors;
  }

  foreach($project['schemas'] as $schema) {
    $schemaFile = $path ."/{$schema}.sql.gz";

    //First wipe the schema so it is blank
    if(!wipeSchema($schema)) {
      $errors[] = "Unable to wipe schema {$schema}";
      continue;
    }

    //restore the snapshot to the selected schema
    $command = "gunzip < {$schemaFile} | mysql -h " . MYSQL_HOST . " -P ". MYSQL_PORT ." -u". getDBUser() ." -p".  getDBPass() ." {$schema}";
    system($command);

    //Verify the import was successful
    if(!verifySchemaNotEmpty($schema)) {
      $errors[] = "Unable to verify restoration of {$schema}";
    }
  }

  if(!empty($errors)) {
    return $errors;
  }

  return true;
}


/**
 * Helper function to delete a directory tree
 *
 * Taken from the PHP Manual Website
 * Originally posted by nbari at dalmp dot com
 * http://php.net/manual/en/function.rmdir.php
 *
 * @param $dir
 * @return bool
 */
function delTree($dir) {
  $files = array_diff(scandir($dir), array('.','..'));
  foreach ($files as $file) {
    (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
  }
  return rmdir($dir);
}