<?php
namespace Core;

use Core\Util\Theme;
use Core\Config;

class App
{

	private static $configs = [];

	public static function boot()
	{
		// @farrukh, can you find a way to cache these options
		// and only hit database once new options are required,
		// rather hitting every time.
		$options = resolve('\\Models\\Option')->all();
		foreach($options as $option){
			config('option_'.$option->name, $option->value);
		}
		// Loading theme
		$theme = new Theme(config('option_app_theme'));
		echo $theme->render('page');
	}

	public static function route()
	{
		if(isset($_GET['page']))
		{
			$page = $_GET['page'];
			$theme = new Theme();
			echo $theme->render($page);
			exit;
		}
		return;
	}

}