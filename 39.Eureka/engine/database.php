<?php

class Database
{
	protected static $inst;
	
	protected $link = NULL; // mysqli connection

	public static function instance() {
		if (self::$inst == NULL) {
			self::$inst = new Database();
		}
		return self::$inst;
	}

	public function __construct(array $config = NULL) {
		if ($config === NULL)
			$config = include('config_db.php');
		$this->link = @mysqli_connect($config['hostname'], $config['username'], $config['password'], $config['database']);
		if (mysqli_connect_errno())
			die("Could connect to database: ".mysqli_connect_error()."\n");
		$this->link->set_charset("utf8");
	}

	public function error() {
		return $this->link->error;
	}

	public function exec($sql) {
		return (bool) $this->link->query($sql);
	}

	public function query($sql) {
		// Fetch the result
		$result = $this->link->query($sql);
		if (gettype($result) == 'boolean')
			return $result;

		// $result is mysqli_result
		// returns result as array, this is very bad if there are many rows
		$rows = array();
		while ($row = $result->fetch_assoc())
			$rows[] = $row;
		$result->close();
		return $rows;
	}
	
	public function quote($txt) {
		return "'".$this->link->real_escape_string($txt)."'";
	}

}
