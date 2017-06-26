<div class="panel panel-primary">
    <div class="panel-heading">
        <h5 class="inlineTitle"><?php echo $project['title']; ?></h5>
        <div class="btn-group btn-group-sm right" role="group" aria-label="Project Actions">
            <a class="btn btn-default" href="index.php?action=project&project=<?php echo $project['name']; ?>"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span><span class="hidden-xs"> &nbsp;&nbsp;Edit</span></a>
            <a class="btn btn-success" href="javascript:createSnapshot('<?php echo $project['name']; ?>')"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span><span class="hidden-xs"> &nbsp;&nbsp;Snapshot</span></a>
            <a class="btn btn-danger" href="javascript:deleteProject('<?php echo $project['name']; ?>')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span><span class="hidden-xs"> &nbsp;&nbsp;Delete</span></a>
            <a class="btn btn-info" data-toggle="collapse" data-target="#<?php echo $project['name']; ?>" href="#" title="Show Snapshots"><span class="glyphicon glyphicon-chevron-down"></span></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body collapse" id="<?php echo $project['name']; ?>">
        <p><?php echo $project['description']; ?></p>
        <strong>Snapshots</strong>
        <div class="well well-sm">
            <?php
                if (empty($project['snapshots'])) {
                    echo "There are no Snapshots for this Project";
                } else {
                ?>
                <table class="table table-striped">
                <?php
                    foreach($project['snapshots'] as $snapshot) {
                        include("templates/snapshot.tpl");
                    }
                ?>
                </table>
                <?php
                }
            ?>
        </div>
    </div>
</div>