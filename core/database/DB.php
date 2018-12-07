<?php

namespace Core\Database;

use Core\Config;
use Core\Database\Migration\MysqlSchema;

class DB
{

    private static $instance;

    // @farrukh please do not change function names without asking
    // it has been used in all over, secondly "query" name is not fit
    // as it will be repeating as MysqlQuery instance also have method
    // query, so it will be like DB::query->query('select * from ...');
    // for now please refactor logic or variable names, avoid functions
	public static function default()
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