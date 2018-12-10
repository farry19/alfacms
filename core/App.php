<?php
namespace Core;

use Core\Util\Theme;
use Core\Config;

// App Class
// This app class is entry point to the front-end user's application
// it also implements theme & routing for now.
// TODO:
// 1. This app class requires a interface
// 2. App class should be made intelligent to throw up errors if something went wrong
// 3. Class should be capable of caching frequently used values either from db or env
// 4. Need to some how introduce cache clear functionality.
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