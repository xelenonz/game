<?php

require 'engine/init.php';
require 'inc/functions.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
	if (preg_match('/^[A-Za-z0-9_]+$/', $_POST['username']) && strlen($_POST['username']) < 100) {
		$result = register($_POST['username'], $_POST['password'], $_POST);
		if ($result) {
			header('Location: /index.php');
			exit;
		}
		$errorMsg = "Username existed";
	}
	else {
		$errorMsg = "Invalid username";
	}
}

require('view/template.php');
$template = new Template('contents/register.php', 'Register');
if (isset($errorMsg))
	$template->content->errorMsg = $errorMsg;
$template->render();

