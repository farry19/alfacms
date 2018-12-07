<?php
namespace Core\Util;

use Core\Util\Theme;
use Core\Database\DB;

class Installer
{

	public function installed()
	{
		return DB::getInstance('query')->table('options')->exists();
	}

	public function install()
	{
		$theme = new Theme('install/');
		echo $theme->render('index');
		exit;
	}

}