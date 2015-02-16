<?php
session_start();
if(!isset($_SESSION['dbcon'])){
	$_SESSION['userip'] = get_ipaddress();
	$_SESSION['dbpath'] = dirname(__FILE__)."/db/";
	$_SESSION['dbfile'] = $_SESSION['dbpath'].$_SESSION['userip'].".sql";
	$_SESSION['dbcon'] = true;
	prepare_db();
}
?>