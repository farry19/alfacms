<?php
namespace Core;

use Core\Util\Theme;
use Core\Config;

class App
{

	private static $configs = [];

	public static function boot()
	{
		$theme = new Theme('themes/default/');
		echo $theme->render('page');
	}

}