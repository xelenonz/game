<?php

$name = isset($_POST['name']) ? (string)$_POST['name'] : '';
$surname = isset($_POST['surname']) ? (string)$_POST['surname'] : '';

if (strlen($name) === 0 || strlen($surname) === 0) {
	header('Location: info.html');
	exit(0);
}

require 'inc.php';

$uinfo = array(
	'name' => $name,
	'secret' => SECRET,
	'surname' => $surname
);

$token = base64_encode(ssl3_encrypt(serialize($uinfo)));

setcookie('token', $token);

header('Location: index.php');
