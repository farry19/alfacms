<?php

namespace Core\Database;

use Core\Config;
use Core\Database\Migration\MysqlSchema;

class DB {
    private static $instance;

    private function __construct() {}

//	public static function query()
//	{
//	    $class = __NAMESPACE__ . '\\' . ucfirst(Config::get('default_database')) . 'Query';
//
//        if(self::$instance == null) {
//            if(Config::get('default_database')) {
//                self::$instance = new $class;
//            } else {
//                self::$instance = new MysqlQuery;
//            }
//        }
//
//        return self::$instance;
//	}

	public static function getInstance($type = 'Query', $table = null)
    {
        $class = __NAMESPACE__ . '\\Mysql' . ucfirst($type);

        if(self::$instance == null) {
            if(Config::get('default_database')) {
                $class = __NAMESPACE__ . '\\' .Config::get('default_database') . $type;
            }
        }

        self::$instance = $table != null ? new $class($table) : new $class;

        return self::$instance;
    }

}