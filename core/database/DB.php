<?php
namespace Core\Database;

use Core\Database\MysqlQuery;
use Core\Config;

class DB {

	public static function default(){
		if(Config::get('default_database') == 'mysql')
			return new MysqlQuery;
		return new MysqlQuery; // fallback
	}

}