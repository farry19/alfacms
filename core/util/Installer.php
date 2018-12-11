<?php
namespace Core\Util;

use Core\Util\Theme;
use Core\Database\DB;

class Installer
{

	public function installed()
	{
		return DB::default()->table('options')->exists();
	}

	public function install()
	{
		//ignore if target is install
		if(!isset($_GET['target']) && $_GET['target'] != 'install')
			redirect('/?target=install&page=index');
	}

}