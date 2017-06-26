<form method="post">
    <div class="col-xs-12">
        <div class="panel panel-info">
            <div class="panel-heading"><h4>Login</h4></div>
            <div class="panel-body">

                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" value="<?php echo $user; ?>" name="username" id="username">
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>

                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> &nbsp;&nbsp;Login</button>
            </div>
        </div>
    </div>
</form>