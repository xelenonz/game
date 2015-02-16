<?php

require 'engine/init.php';

if (!Session::instance()->auth) {
	header('Location: /login.php');
	exit;
}

$db = Database::instance();
$result = $db->query("SELECT * FROM user WHERE id=".Session::instance()->uid);
	
require('view/template.php');
$template = new Template('contents/profile.php', 'Profile');
$template->content->info = $result[0];
$template->render();
