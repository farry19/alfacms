<?php
namespace Core\Database;

use Core\Database\MysqlQuery;
use Core\Database\Migration\MysqlSchema;
use Core\Config;

class DB {

	public static function default()
	{
		if(Config::get('default_database') == 'mysql')
			return new MysqlQuery;
		return new MysqlQuery; // fallback
	}

	public static function schema()
	{
		if(Config::get('default_database') == 'mysql')
			return new MysqlSchema;
		return new MysqlSchema; // fallback
	}

}