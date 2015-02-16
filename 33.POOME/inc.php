<?php

if (!function_exists('hex2bin')) {
    function hex2bin($str) {
        return pack("H*" ,$str);
    }
}

define("FLAG", "flagflagflagflagflag"); // 20 characters
define("SECRET", FLAG);

define("ENC_ALG", MCRYPT_RIJNDAEL_128);
define("BLOCK_SIZE", 16);

define("HMAC_ALG", "sha1");
define("MAC_LEN", 20);

define("AESKEY", "_DUMMY_AES_KEY__"); // secret key
define("MACKEY", "_DUMMY_MAC_KEY__"); // secret key

function ssl3_pad($data)
{
	$pad_len = BLOCK_SIZE - ((strlen($data)+1) % BLOCK_SIZE);
	return $data . openssl_random_pseudo_bytes($pad_len) . chr($pad_len);
}

function ssl3_unpad($data)
{
	$len = strlen($data);
	$pad_len = ord($data[$len-1]);
	return substr($data, 0, -($pad_len+1));
}

function calc_mac($data)
{
	return substr(hash_hmac(HMAC_ALG, $data, MACKEY, TRUE), 0, MAC_LEN);
}

function ssl3_encrypt($data)
{
	// mac
	$mac = calc_mac($data);
	// then encrypt
	$iv = mcrypt_create_iv(BLOCK_SIZE, MCRYPT_DEV_URANDOM);
	return $iv . mcrypt_encrypt(ENC_ALG, AESKEY, ssl3_pad($data.$mac), MCRYPT_MODE_CBC, $iv);
}

function ssl3_decrypt($data)
{
	if (strlen($data) < MAC_LEN || (strlen($data) % BLOCK_SIZE) !== 0)
		return FALSE;
	
	// decrypt
	$iv = substr($data, 0, BLOCK_SIZE);
	$data = mcrypt_decrypt(ENC_ALG, AESKEY, substr($data, BLOCK_SIZE), MCRYPT_MODE_CBC, $iv);
	// unpad
	$data = ssl3_unpad($data);
	
	// check MAC
	$mac = substr($data, -MAC_LEN);
	$data = substr($data, 0, -MAC_LEN);
	
	if (calc_mac($data) !== $mac)
		return FALSE;
	
	return $data;
}

