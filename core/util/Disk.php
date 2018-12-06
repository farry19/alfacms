<?php
namespace Core\Util;

use Core\Util\ErrorView;

class Disk
{

	private $root;

	function __construct($root)
	{
		$this->root = $root;
	}

	public function exists($path)
	{
		if(file_exists($this->root.'/'.$path))
		{	
			return TRUE;
		}
		return FALSE;
	}

	public function goto($path)
	{
		if($this->exists($path) != FALSE)
		{
			$this->root .= '/'.$path;
		}
		return FALSE;
	}

	public function read($filename)
	{
		if(!file_exists($this->root.'/'.$filename))
		{
			ErrorView::render('Disk Read Error', 'Unable to read file <code>'.$this->root.'/'.$filename.'</code>.');
		}
		ob_start();
		$return = include_once $this->root.'/'.$filename;
		return ob_get_clean();
	}

	public function readLines($filename)
	{
		if(!file_exists($this->root.'/'.$filename))
		{
			ErrorView::render('Disk Read Error', 'Unable to read file <code>'.$this->root.'/'.$filename.'</code>.');
		}
		$lines = [];
		$handle = fopen($this->root . '/' . $filename, "r");
		if($handle)
		{
		    while(($line = fgets($handle)) !== false)
		    {
		        $lines[] = $line;
		    }
		    fclose($handle);
		}
		else
		{
		    ErrorView::render('ENV File', 'Unable to read your configs from .env file.');
		} 
		return $lines;
	}

	public function list($type = 'file')
	{
		if($type == 'dir')
		{
			$dirs = array_filter(glob($this->root.'/*'), 'is_dir');
			for($i=0; $i<count($dirs); $i++)
			{
				$dirs[$i] = str_replace($this->root.'/', '', $dirs[$i]);
			}
			return $dirs;
		}
		if($type == 'file')
		{
			$files = scandir($this->root.'/*');
			for($i=0; $i<count($files); $i++)
			{
				$files[$i] = str_replace($this->root.'/', '', $files[$i]);
			}
			return $files;
		}
	}

}