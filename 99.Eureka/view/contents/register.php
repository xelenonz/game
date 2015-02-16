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
		<label for="name" class="col-sm-5 control-label">First Name</label>
		<div class="col-sm-3"><input type="text" name="name" class="form-control" /></div>
	</div>
	<div class="form-group">
		<label for="surname" class="col-sm-5 control-label">Surname</label>
		<div class="col-sm-3"><input type="text" name="surname" class="form-control" /></div>
	</div>
	<div class="form-group">
		<label for="phone" class="col-sm-5 control-label">Phone</label>
		<div class="col-sm-3"><input type="text" name="phone" class="form-control" /></div>
	</div>
	<div class="form-group">
		<label for="email" class="col-sm-5 control-label">Email</label>
		<div class="col-sm-3"><input type="text" name="email" class="form-control" /></div>
	</div>
	<div class="form-group">
		<label for="emailpwd" class="col-sm-5 control-label">Email Password</label>
		<div class="col-sm-3"><input type="text" name="emailpwd" class="form-control" /></div>
	</div>
	<div class="form-group">
		<label for="creditcard" class="col-sm-5 control-label">Credit Card</label>
		<div class="col-sm-3"><input type="text" name="creditcard" class="form-control" /></div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-1 col-sm-10">
			<button type="submit" class="btn btn-default">Register</button>
			<a href="login.php" class="btn btn-default" role="button">Back</a>
		</div>
	</div>
</form>
</div>
