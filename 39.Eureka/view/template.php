<?php

class Template extends View
{
	public function __construct($content_filename, $title = NULL) {
		parent::__construct('templates/template-page.php');
		$this->title = $title;
		$this->header = new View('templates/header.php');
		// $content_filename might be only string, not filename
		if (file_exists(VIEWPATH.'/'.$content_filename))
			$this->content = new View($content_filename);
		else
			$this->content = $content_filename;
	}
}
