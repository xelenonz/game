<?php
include 'function.php';

$user = (isset($_POST['username'])?$_POST['username']:"");
$pass = (isset($_POST['password'])?$_POST['password']:"");
if($user && $pass){
	$data=authenticate($user,$pass);
	if(isset($data['userid'])){
		$_SESSION['userid'] = $data['userid'];
		$_SESSION['username'] = $data['user'];
		$_SESSION['role'] = $data['role'];
		$res = loginlog($_SESSION['userid'],get_ipaddress());
		header("location: ".$_SESSION['role']);
	}else{
		echo 'login failed';
	}
}
?>