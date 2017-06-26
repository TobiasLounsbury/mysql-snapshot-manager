<div class="well well-sm">
<a class="btn btn-primary" href="index.php?action=project"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> &nbsp;&nbsp;Create New Project</a>

<?php if(isset($_SESSION) && array_key_exists("password", $_SESSION)) { ?>
<a class="btn btn-info right" href="/?action=logout"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> &nbsp;&nbsp;Logout</a>
<?php } ?>
</div>
