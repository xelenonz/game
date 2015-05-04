<?php

$basepath = realpath(__DIR__.'/..');
define('BASEPATH', $basepath);
define('VIEWPATH', $basepath.'/view');
unset($basepath);

if (!function_exists('hex2bin')) {
	function hex2bin($str) {
		return pack("H*" ,$str);
	}
}

require 'config.php';
require 'view.php';
require 'session.php';
require 'database.php';
