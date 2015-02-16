<?php

function on_invalid_token()
{
	header('Location: info.php');
	exit(0);
}

if (!isset($_COOKIE['token']))
	on_invalid_token();

$token = base64_decode($_COOKIE['token']);
if ($token === FALSE)
	on_invalid_token();


require 'inc.php';

$uinfo = ssl3_decrypt($token);
if ($uinfo === FALSE)
	on_invalid_token();

$uinfo = unserialize($uinfo);
if ($uinfo['secret'] !== SECRET)
	on_invalid_token();

// correct token
?>
Welcome <?=$uinfo['name']?> <?=$uinfo['surname']?>
