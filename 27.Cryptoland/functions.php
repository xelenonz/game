<?php
mysql_connect("localhost","xxxx","xxxx");
mysql_select_db('xxxxx');
define('KEY', 'XXXXXXXXXXXXXXXXXXXXXXXXX');

function generator($length = 9, $add_dashes = false, $available_sets = 'luds')
{
	$sets = array();
	if(strpos($available_sets, 'l') !== false)
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
	if(strpos($available_sets, 'u') !== false)
		$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
	if(strpos($available_sets, 'd') !== false)
		$sets[] = '23456789';
	if(strpos($available_sets, 's') !== false)
		$sets[] = '!@#$%&*?';
 
	$all = '';
	$password = '';
	foreach($sets as $set)
	{
		$password .= $set[array_rand(str_split($set))];
		$all .= $set;
	}
 
	$all = str_split($all);
	for($i = 0; $i < $length - count($sets); $i++)
		$password .= $all[array_rand($all)];
 
	$password = str_shuffle($password);
 
	if(!$add_dashes)
		return $password;
 
	$dash_len = floor(sqrt($length));
	$dash_str = '';
	while(strlen($password) > $dash_len)
	{
		$dash_str .= substr($password, 0, $dash_len) . '-';
		$password = substr($password, $dash_len);
	}
	$dash_str .= $password;
	return $dash_str;
}

function user_exist($user){
	$result = mysql_query("select * from users where username='$user';");
	return (mysql_num_rows($result))?True:False;
}

function getdata($user){
	$result = mysql_query("select password,salt,priv from users where username='$user';");
	return ($result)?mysql_fetch_assoc($result):False;

}

function register($user){
	$username = mysql_real_escape_string($user);
	!user_exist($username) or die("Error");
	$salt = generator(5,false,'lud');
	$password = generator(8);
	$epasswd = crypt($salt.$password,generator(2));
	$pass = mysql_real_escape_string($epasswd);
	mysql_query("insert into users value ('$user','$pass','$salt','user');");
	return $password;
}

function login($user,$password){
	$data = getdata($user);
	if($data){
		$passwd = crypt($data['salt'].$password,substr($data['password'],0,2));
		if($passwd == $data['password']){
			if($data['priv'] == 'admin'){
				return array('success','here is your flag : '.KEY);
			}else{
				return array('info',"Try to get admin's privilege");
			}
		}
	}
	return array('danger',"Invalid login");
}
?>