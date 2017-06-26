<tr>
    <td>
        <?php echo $snapshot; ?>
    </td>
    <td class="snapshot-actions">
        <div class="btn-group btn-group-xs" role="group" aria-label="Snapshot Actions">
            <a class="btn btn-success" href="javascript:restoreSnapshot('<?php echo $project['name']; ?>', '<?php echo $snapshot; ?>')"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span><span class="hidden-xs"> &nbsp;&nbsp;Restore Snapshot</span></a>
            <a class="btn btn-info" href="javascript:snapshotInfo('<?php echo $project['name']; ?>', '<?php echo $snapshot; ?>')"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></span><span class="hidden-xs"> &nbsp;&nbsp;Snapshot Info</span></a>
            <a class="btn btn-danger" href="javascript:deleteSnapshot('<?php echo $project['name']; ?>', '<?php echo $snapshot; ?>')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span><span class="hidden-xs"> &nbsp;&nbsp;Delete Snapshot</span></a>
        </div>
    </td>
</tr>
