<div class="text-center">
	<form class="form-horizontal" role="form" method="POST">
	<? if (isset($errorMsg)): ?><p class="text-danger"><?=$errorMsg?></p><? endif ?>
	<div class="form-group">
		<label for="username" class="col-sm-5 control-label">Username</label>
		<div class="col-sm-3"><input type="text" name="username" class="form-control" /></div>
	</div>
	<div class="form-group">
		<label for="password" class="col-sm-5 control-label">Password</label>
		<div class="col-sm-3"><input type="password" name="password" class="form-control" /></div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-1 col-sm-10">
			<button type="submit" class="btn btn-default">Login</button>
			<a href="register.php" class="btn btn-default" role="button">Register</a>
		</div>
	</div>
</form>
</div>
