<?php

namespace Core\Database;

use Core\Config;
use Core\Database\Migration\MysqlSchema;

class DB {
    private static $instance;

    private function __construct() {}

	public static function query()
	{
	    $class = __NAMESPACE__ . '\\' . ucfirst(Config::get('default_database')) . 'Query';

        if(self::$instance == null) {
            if(Config::get('default_database')) {
                self::$instance = new $class;
            } else {
                self::$instance = new MysqlQuery;
            }
        }

        return self::$instance;
	}

	public static function schema()
    {
        $class = __NAMESPACE__ . '\\' . ucfirst(Config::get('default_database')) . 'Schema';

        if(self::$instance == null) {
            if(Config::get('default_database')) {
                self::$instance = new $class;
            } else {
                self::$instance = new MysqlSchema;
            }
        }

        return self::$instance;
    }

}