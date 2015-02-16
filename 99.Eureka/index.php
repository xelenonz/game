<?php

require 'engine/init.php';

if (!Session::instance()->auth) {
	header('Location: /login.php');
	exit;
}

require('view/template.php');
$template = new Template('contents/index.php', 'Home');
$template->render();
