#!/usr/bin/php
<?php
require_once("settings.php");
require_once("libs/snapshot.php");
require_once("libs/database.php");
require_once("libs/utility.php");

$actions = array("snapshot", "restore", "list", "info");

function displayHelp() {
  global $argv;
  echo "Usage:\n";
  echo "{$argv[0]} <action> [project] [snapshot]\n\n";
  echo "Actions:\n";
  echo "\tinfo <project> - Display info for a project\n";
  echo "\tinfo <project> <snapshot> - Display info for a snapshot\n";
  echo "\tlist - List all configured projects\n";
  echo "\tlist <project> - List all snapshots for project\n";
  echo "\trestore <project> <snapshot> - Restore selected snapshot for project\n";
  echo "\tsnapshot <project> <snapshot_name> - Create a snapshot for project with given name\n";
}

if (count($argv) == 1) {
  displayHelp();
  exit();
}

switch ($argv[1]) {
  /**
   * The autocomplete action is not meant for direct
   * usage. It is called from the autocomplete.sh to
   * supply information for bash auto-completion.
   */
  case "autocomplete":

    if (count($argv) == 2) {
      echo implode(" ", $actions);
    } else if (count($argv) == 3) {
      $projects = getAllProjects();
      $list = array_keys($projects);
      echo implode(" ", $list);


      //The third argument depends on what action is being performed
    } else if (count($argv) == 4) {

      switch ($argv[2]) {
        case "snapshot":
          //snapshots only have one additional argument and it is the name for the new snapshot.
          break;

        case "restore":
          $list = loadProjectSnapshots($argv[3]);
          $list[] = "latest";
          echo implode(" ", $list);
          break;
      }
    }

    break;

  /**
   * Create a snapshot
   */
  case "snapshot":
    $projectName = arrayValue(2, $argv, false);
    $snapshotName = strtolower(str_replace(" ", "_", arrayValue(3, $argv, "")));

    if(!$projectName) {
      echo "Error: No Project Selected\n\n";
      displayHelp();
      exit();
    }

    //Load the Project
    $project = loadProjectDef($projectName);

    if(!$project) {
      echo "Error: Unknown Project '{$projectName}'\n";
      exit();
    }

    if(!$snapshotName) {
      echo "Error: No snapshot name supplied\n\n";
      displayHelp();
      exit();
    }

    $snapshotPath = getSnapshotPath($projectName, $snapshotName);

    if(is_dir($snapshotPath)) {
      echo "Error: A snapshot with the name '{$snapshotName}' already exists for project '{$projectName}'\n";
      exit();
    }

    if(!createProjectSnapshot($project, $snapshotName)) {
      echo "Error: Unable to create snapshot '{$snapshotName}'\n";
    }

    break;


  /**
   * Restore a snapshot
   */
  case "restore":

    $projectName = arrayValue(2, $argv, false);
    $snapshotName = arrayValue(3, $argv, false);

    if(!$projectName) {
      echo "Error: No Project Selected\n\n";
      displayHelp();
      exit();
    }

    if(!$snapshotName) {
      echo "Error: No Snapshot Selected\n\n";
      displayHelp();
      exit();
    }

    //Load the Project
    $project = loadProjectDef($projectName);

    if(!$project) {
      echo "Error: Unknown Project '{$projectName}'\n";
      exit();
    }

    $snapshotPath = getSnapshotPath($projectName, $snapshotName);

    if(!is_dir($snapshotPath)) {
      echo "Error: Unknown Snapshot '{$snapshotName}' for project '{$projectName}'\n";
      exit();
    }

    if(!attemptDBConnect()) {
      echo "Error: Unable to connect to MySQL Server. Please Check your settings.\n";
      exit();
    }

    $result = restoreProjectSnapshot($project, $snapshotName);

    if($result !== true) {
      echo "Error Restoring Snapshot '{$snapshotName}':\n";
      foreach ($result as $line) {
        echo "\t* {$line}\n";
      }
    }

    break;


  /**
   * List Projects or Snapshots
   */
  case "list":

    //List the projects
    if (count($argv) == 2) {
      $projects = getAllProjects();
      $list = array_keys($projects);
      echo "Configured Projects: \n";
      echo "\t- " . implode("\n\t- ", $list) . "\n";
    } else if (count($argv) >= 3) {
      echo "Snapshots for {$argv[2]}:\n";
      $list = loadProjectSnapshots($argv[2]);
      echo "\t- " . implode("\n\t- ", $list) . "\n";
    }
    break;


  /**
   * Display info for a project or snapshot
   */
  case "info":
    echo "This has not been implemented yet\n";
    break;
  default:
    echo "Unknown action '{$argv[1]}'\n\n";
    displayHelp();
}
