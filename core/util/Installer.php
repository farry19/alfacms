<?php
namespace Core\Util;

use Core\Util\Theme;
use Core\Database\DB;

class Installer
{

	public function installed()
	{
		$bool = DB::default()->table('options')->exists();
		if($bool)
		{
			return TRUE;
		}
		return FALSE;
	}

	public function install()
	{
		$theme = new Theme('install/');
		echo $theme->render('index');
		exit;
	}

}