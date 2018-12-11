<?php

namespace Core\Database;

use Core\Config;
use Core\Database\Migration\MysqlSchema;

class DB
{

    private static $database_instance;
    private static $schema_instance;

    // @farrukh please do not change function names without asking
    // it has been used in all over, secondly "query" name is not fit
    // as it will be repeating as MysqlQuery instance also have method
    // query, so it will be like DB::query->query('select * from ...');
    // for now please refactor logic or variable names, avoid functions
	public static function default()
	{
        // @farrukh
        // Let's not optimize these lines
        // there arise many issues, as names in env could be really differ from actual
        // class names in future as well, so we can't rely on mapping it directly to classes
        // i.e.
        // what if env variables changes from DB_DEFAULT=MYSQL to sequel-database
        // or what if we require to rename our class MysqlQuery to something else?
        // in all these cases, your old implementation causes problems.
        // Let's stick to current implementation now
        if(Config::get('DB_DEFAULT') == 'MYSQL'){
            if(self::$database_instance == null) {
                self::$database_instance = new \Core\Database\MysqlQuery;
            }
            return self::$database_instance;
        }
        return new \Core\Database\MysqlQuery; // default fallback
	}

	public static function schema()
    {
        // Same goes for these lines, please read instructions from above method
        if(Config::get('DB_DEFAULT') == 'MYSQL'){
            if(self::$schema_instance == null) {
                self::$schema_instance = new \Core\Database\Migration\MysqlSchema;
            }
            return self::$schema_instance;
        }
        return new \Core\Database\Migration\MysqlSchema; // default fallback
    }

}