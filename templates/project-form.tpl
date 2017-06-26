<div class="panel panel-primary">
    <div class="panel-heading"><h4><?php echo $formAction; ?> Project</h4></div>
    <div class="panel-body">
        <form action="index.php?action=project" method="post">
            <input type="hidden" name="process" value="1" />

            <?php if ($editName) { ?>
                <div class="form-group">
                    <label for="project_name">Project Name:</label>
                    <input type="text" class="form-control" name="name" id="project_name" value="<?php echo arrayValue("name", $project); ?>" required />
                </div>
            <?php } else { ?>
                <div class="form-group">
                    <label for="project_name">Project Name: <?php echo arrayValue("name", $project); ?></label>
                    <input type="hidden" name="name" value="<?php echo arrayValue("name", $project); ?>" />
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="project_title">Project Title:</label>
                <input type="text" class="form-control" name="title" id="project_title" value="<?php echo arrayValue("title", $project); ?>" />
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" name="description" id="description"><?php echo arrayValue("description", $project); ?></textarea>
            </div>

            <div class="form-group">
                <label for="schemas">Schemas:</label>
                <select name="schemas[]" id="schemas" multiple="multiple"  class="autoload-select2 full-width">
                    <?php foreach($schemas as $schema) { ?>
                    <option value="<?php echo $schema; ?>" <?php selected($schema, $project['schemas']); ?>><?php echo $schema; ?></option>
                    <?php } ?>
                </select>
            </div>

            <script type="text/javascript">

            </script>
            <a class="btn btn-default" href="index.php"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> &nbsp;&nbsp;Cancel</a>
            <button class="btn btn-info" type="submit"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> &nbsp;&nbsp;Save Project</button>
        </form>
    </div>
</div>