<?php
namespace Core;

use Core\Util\Disk;

class Config
{
	private static $configs = [];

	public static function initialize()
	{
		$disk = new Disk(root());
		$lines = $disk->readLines('.env');

		foreach($lines as $line)
		{
			if(trim($line) != '')
			{
				$temp = explode('=', $line);
				self::set($temp[0], trim($temp[1]));
			}
		}
	}
	
	public static function set($name, $value)
	{
		self::$configs[$name] = $value;
	}

	public static function has($name)
	{
		if(isset(self::$configs[$name]))
		{
		    return TRUE;
        }

		return FALSE;
	}

	public static function get($name)
	{
		if(isset(self::$configs[$name]))
		{
			return self::$configs[$name];
		}

		return NULL;
	}

}