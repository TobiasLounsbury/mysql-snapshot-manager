<?php

$projectName = arrayValue("project", $_GET, false);
$snapshotName = arrayValue("snapshotName", $_GET, false);

if($projectName && $snapshotName) {
  $project = loadProjectDef($projectName);
  if($project) {
    $snapshotPath = getSnapshotPath($project['name'], $snapshotName);
    if (!is_dir($snapshotPath)) {
      if(createProjectSnapshot($project, $snapshotName)) {
        statusMessage("Snapshot Created Successfully", "success");
      } else {
        statusMessage("Unable to create snapshot: '{$snapshotName}'. Please check folder permissions", "warning");
      }
    } else {
      statusMessage("A snapshot with the name '{$snapshotName}' already exists for the '{$project['name']}' project.", "warning");
    }
  } else {
    statusMessage("Unknown Project: '{$projectName}'", "warning");
  }
} else {
  statusMessage("Missing Parameters: 'project' and 'snapshotName' are both required.", "danger");
}
header("location:index.php");