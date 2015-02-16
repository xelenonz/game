<?php

class Session
{
	private static $instance;
	
	protected static $default = array(
		'username' => '',
		'auth' => FALSE,
		'admin' => FALSE,
		'fileview' => 'filedetail.php'
	);
	
	protected $info = array();
	
	public static function instance() {
		if (!self::$instance) {
			self::$instance = new Session;
			self::$instance->loadCookieSession();
		}
		return self::$instance;
	}
	
	// Note: silently discard session data if anything goes wrong
	protected function loadCookieSession() {
		$key = $GLOBALS['AESKEY'];
		$mac_key = $GLOBALS['MACKEY'];
		$this->info = array();
		
		if (!isset($_COOKIE['session']))
			return;
		$sessdata = json_decode($_COOKIE['session'], TRUE);
		if (!$sessdata || !isset($sessdata['info']) || !isset($sessdata['iv']) || !isset($sessdata['mac']))
			return;
		
		$einfo = base64_decode($sessdata['info']);
		$iv = hex2bin($sessdata['iv']);
		$mac = $sessdata['mac'];
		
		// also rtrim because mcrypt_decrypt() does not remove trailing NULL(s)
		$data = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $einfo, MCRYPT_MODE_CBC, $iv));
		if ($mac != hash_hmac('sha1', $data, $mac_key)) {
			// invalid MAC, ignore sessdata
			return;
		}
		
		// MAC is valid, unserialize it
		$info = unserialize($data);
		if (!isset($info['expire']) || $info['expire'] < time()) {
			// this session is expired
			return;
		}
		
		$this->info = $info;
	}
	
	public function save() {
		$key = $GLOBALS['AESKEY'];
		$mac_key = $GLOBALS['MACKEY'];
		
		if (empty($this->info))
			return;
		
		// fixed IV to 16 bytes for AES
		$iv = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
		$expire = time() + (30 * 60); // 30 min
		$this->info['expire'] = $expire;
		$data = serialize($this->info);
		$mac = hash_hmac('sha1', $data, $mac_key);
		$einfo = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, $iv);
		$sessdata = json_encode(array(
			'info' => base64_encode($einfo),
			'iv' => bin2hex($iv),
			'mac' => $mac,
		));
		setcookie('session', $sessdata, $expire, '/', '', FALSE, TRUE);
	}
	
	// for logout
	public function clear() {
		$this->info = array();
		setcookie('session', '', time()-3600, '/', '', FALSE, TRUE);
	}
	
	public function __get($key) {
		if (isset($this->info[$key]))
			return $this->info[$key];
		//if (isset($this->default[$key]))
		// access $key without checking to raising warning/error
		// message if $key does not exist
		return self::$default[$key];
	}
	
	public function __set($key, $value) {
		// limit username length to be 100
		if ($key == 'username')
			$value = substr($value, 0, 100);
		// allow all $key to be able to add extra session data
		$this->info[$key] = $value;
	}
}
