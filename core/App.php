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