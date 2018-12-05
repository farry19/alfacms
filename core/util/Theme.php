<?php
namespace Core\Util;

use Core\Util\Disk;

class Theme
{

	private $path;
	private $disk;

	function __construct($theme_path = '')
	{
		$this->path = $theme_path;
		$this->disk = new Disk(root() . '/disk');
	}

	public function render($file)
	{
		$contents = $this->disk->read($this->path . $file . '.php');
		//TODO: add some rendering
		return $contents;
	}

}