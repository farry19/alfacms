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
		// Simply redirect to selected theme's default page
		redirect('/?target=theme&page=page');
	}

	public static function route()
	{
		// @farrukh, can you find a way to cache these options
		// and only hit database once new options are required,
		// rather hitting every time.
		$options = resolve('\\Models\\Option')->all();
		if($options){
			foreach($options as $option){
				config('option_'.$option->name, $option->value);
			}
		}

		if(isset($_GET['target']) && isset($_GET['page']))
		{
			$target = $_GET['target'];

			// @farrukh, this logic can be improved
			// NOTE: always test all scenarios once you do refactoring!!!
			if($target == 'theme')
				$target = 'disk/' . config('option_app_theme');
			if($target == 'install')
				$target = 'disk/install/';
			if($target == 'admin')
				$target = 'admin/pages/';
			
			$page = $_GET['page'];
			$theme = new Theme($target . '/');
			echo $theme->render($page);
			exit;
		}
		return;
	}

}