<?php


$projectName = arrayValue("project", $_GET, false);
$snapshotName = arrayValue("snapshot", $_GET, false);

if($projectName) {
  $project = loadProjectDef($projectName);
  if($project) {

    //Deleting a Project
    if($snapshotName === false) {
      $path = getProjectPath($project['name']);
      if(delTree($path)) {
        statusMessage("Project deleted successfully: '{$projectName}'", "success");
      } else {
        statusMessage("Unable to completely delete project: '{$projectName}'", "warning");
      }

    //Deleting a snapshot
    } else {
      $path = getSnapshotPath($project['name'], $snapshotName);
      if(is_dir($path)) {
        if(delTree($path)) {
          statusMessage("Snapshot deleted successfully: '{$snapshotName}'", "success");
        } else {
          statusMessage("Unable to completely delete snapshot '{$snapshotName}' for project '{$projectName}'", "warning");
        }
      } else {
        statusMessage("Unknown Snapshot '{$snapshotName}' for project {$projectName}'", "warning");
      }
    }
  } else {
    statusMessage("Unknown Project: '{$projectName}'", "warning");
  }
} else {
  statusMessage("Error: 'project' is a required parameter", "danger");
}
header("location:index.php");