<?php

function login($username, $password)
{
	$sess = Session::instance();
	$sess->username = $username;
	$db = Database::instance();
	$result = $db->query("SELECT * FROM user".
					" WHERE username=".$db->quote($username).
					"   AND password=".$db->quote(sha1($password)) );
	if (!$result || count($result) != 1) {
		// login failed
		$sess->auth = FALSE;
	}
	else {
		$result = $result[0];
		// login success
		$sess->auth = TRUE;
		$sess->uid = (int) $result['id'];
		if ($result['admin'])
			$sess->admin = TRUE;
	}
	$sess->save();
	
	return $sess->auth;
}

function register($username, $password, $info)
{
	$db = Database::instance();
	$result = $db->query("SELECT id FROM user".
					" WHERE username=".$db->quote($username));
	if (!$result) {
		$values = array();
		$fields = array('name', 'surname', 'phone', 'email', 'emailpwd', 'creditcard');
		foreach ($fields as $field) {
			$val = isset($_POST[$field]) ? $_POST[$field] : '';
			$values[] = $db->quote($val);
		}
		// no one use this user, add a new one
		$sql = "INSERT INTO user(username, password, admin, ".implode(',', $fields).") VALUES".
			" (".$db->quote($username).",".$db->quote(sha1($password)).", 0, ".implode(',', $values).")";
		$result = $db->exec($sql);
		if ($result) {
			login($username, $password);
		}
		return $result;
	}
	
	// user existed
	return FALSE;
}

