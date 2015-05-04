<?php

require 'engine/init.php';
require 'inc/functions.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
	if (login($_POST['username'], $_POST['password'])) {
		// login success
		header('Location: /index.php');
		exit;
	}
	$errorMsg = "Invalid username or password";
}

require('view/template.php');
$template = new Template('contents/login.php', 'Login');
if (isset($errorMsg))
	$template->content->errorMsg = $errorMsg;
$template->render();
