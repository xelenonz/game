<?php

class View
{
	protected $filename;
	protected $data = array();

	public static function display($filename, array $data = array()) {
		if (!empty($data))
			extract($data, EXTR_SKIP);
		include(VIEWPATH.'/'.$filename);
	}

	public static function factory($filename, $data = array()) {
		$view = new View($filename, $data);
		return $view;
	}

	public function __construct($filename, $data = array()) {
		$this->filename = VIEWPATH.'/'.$filename;
		$this->data = $data;
	}

	public function __set($key, $value) {
		$this->data[$key] = $value;
	}

	public function __get($key) {
		if (isset($this->data[$key]))
			return $this->data[$key];
	}

	/**
	 * To automatically render sub view
	 */
	public function __toString() {
		return $this->render(FALSE);
	}

	public function render($print = TRUE) {
		// Buffering on
		ob_start();

		// Import the view variables to local namespace
		extract($this->data, EXTR_SKIP);

		include $this->filename;

		// Fetch the output and close the buffer
		$output = ob_get_clean();

		if ($print)
			echo $output;
		else
			return $output;
	}

}