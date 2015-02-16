<div class="navbar navbar-default navbar-static-top">
<? if (Session::instance()->auth): ?>
<div class="container">
<div class="collapse navbar-collapse">
	<ul class="nav navbar-nav">
		<li<?if ($_SERVER['PHP_SELF'] == '/index.php'): ?> class="active"<?endif?>><a href="/index.php">Home</a></li>
		<li<?if ($_SERVER['PHP_SELF'] == '/profile.php'): ?> class="active"<?endif?>><a href="/profile.php">Profile</a></li>
		<? if (Session::instance()->admin): ?>
		<li<?if ($_SERVER['PHP_SELF'] == '/filelist.php'): ?> class="active"<?endif?>><a href="/filelist.php">Files</a></li>
		<? endif ?>
	</ul>
	<ul class="nav navbar-nav navbar-right">
		<li><a href="/logout.php">Logout</a></li>
	</ul>
</div>
</div>
<? endif ?>
</div>