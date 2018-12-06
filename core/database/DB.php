<?php
namespace Core\Database;

use Core\Database\MysqlQuery;
use Core\Config;

class DB {

    private static $instance;

    private function __construct() {}

    public static function getInstance() {

        if(!isset(self::$instance)) {
            if(Config::get('default_database')) {
                self::$instance = __NAMESPACE__ . '\\' .ucfirst(Config::get('default_database')) . 'Query';
            } else {
                self::$instance = 'MysqlQuery';
            }
        }

        return self::$instance;
	}

}