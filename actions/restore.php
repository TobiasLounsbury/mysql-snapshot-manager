<?php

$projectName = arrayValue("project", $_GET, false);
$snapshotName = arrayValue("snapshot", $_GET, false);

if($projectName && $snapshotName) {
  $project = loadProjectDef($projectName);
  if($project) {
    $snapshotPath = getSnapshotPath($project['name'], $snapshotName);
    if (is_dir($snapshotPath)) {
      $result = restoreProjectSnapshot($project, $snapshotName);
      if($result === true) {
        statusMessage("Snapshot Restored Successfully", "success");
      } else {
        statusMessage("Unable to restore snapshot '{$snapshotName}': <ul><li>" .implode("</li><li>", $result). "</li></ul>", "warning");
      }
    } else {
      statusMessage("Unknown Snapshot '{$snapshotName}' for the '{$project['title']}' project.", "warning");
    }
  } else {
    statusMessage("Unknown Project: '{$projectName}'", "warning");
  }
} else {
  statusMessage("Missing Parameters: 'project' and 'snapshot' are both required.", "danger");
}
header("location:index.php");