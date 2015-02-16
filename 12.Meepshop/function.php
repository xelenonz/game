<?php
require_once 'preparedb.php';

function get_ipaddress(){
	if (getenv('HTTP_CLIENT_IP')) return getenv('HTTP_CLIENT_IP');
	return getenv('REMOTE_ADDR');
}

function get_DBConnection(){
	/* db fullpath limit 100 chars */
	$dbfile = substr($_SESSION['dbfile'],0,100);
	$dbconn	= new SQLite3($dbfile);
	return $dbconn;
}

function generatePassword($length = 16) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
}

function prepare_db(){
	$db = get_DBConnection();
	$db->exec("CREATE TABLE IF NOT EXISTS users (userid INTEGER PRIMARY KEY,user varchar(32),pass varchar(32),role varchar(5));");
	$db->exec("CREATE TABLE IF NOT EXISTS lastlogin (logid INTEGER PRIMARY KEY,userid int(10),lastip varchar(15));");
	$db->exec('INSERT INTO users (userid,user,pass,role) VALUES (NULL,"admin","'.generatePassword().'","admin");');
}

function loginlog($id,$userip){
	$db = get_DBConnection();
	$userip = substr($userip,0,15);
	$stmt = $db->prepare("INSERT INTO lastlogin (logid,userid,lastip) VALUES (NULL,:uid,:userip);");
	$stmt->bindValue(':uid', $id, SQLITE3_INTEGER);
	$stmt->bindValue(':userip', $userip, SQLITE3_TEXT);
	return $stmt->execute();
}

function authenticate($user,$pass){
	$db = get_DBConnection();
	$stmt = $db->prepare("SELECT * FROM users where user=? AND pass=?");
	$stmt->bindValue(1, $user, SQLITE3_TEXT);
	$stmt->bindValue(2, $pass, SQLITE3_TEXT);
	$result = $stmt->execute();
	$data = $result->fetchArray();
	return $data;
}

function checkvalid($string){
	return preg_match('/^[a-zA-Z0-9_]+$/',$string);
}

function register($user,$pass){
	$db = get_DBConnection();
	if(checkvalid($user) && checkvalid($pass)){
		$stmt = $db->prepare("INSERT INTO users (userid,user,pass,role) VALUES (NULL,?,?,'user');");
		$stmt->bindValue(1, $user, SQLITE3_TEXT);
		$stmt->bindValue(2, $pass, SQLITE3_TEXT);
		$result = $stmt->execute();
		return $result;
	}
	return false;
}


?>