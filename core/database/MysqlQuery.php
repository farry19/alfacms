<?php

namespace Core\Database;

use Core\Util\ErrorView;
use Core\Database\Interfaces\QueryInterface;

class MysqlQuery implements QueryInterface
{

    private static $connected = false;
    private static $conn = FALSE;
    private static $last_query = '';
    private static $last_table_query = '';
    private static $last_table = NULL;
    private static $mocked_instance = NULL;

    public static function connect()
    {
        if(self::$connected) self::close();

        $default = config('DB_DEFAULT');

        self::$conn = @mysqli_connect(
            config($default.'_HOST'), 
            config($default.'_USERNAME'), 
            config($default.'_PASSWORD'), 
            config($default.'_DATABASE'), 
            config($default.'_PORT')
        );

        if(self::$conn) {
            self::$connected = true;
            return true;
        }

        MysqlQuery::$connected = false;
        ErrorView::render('Database Error', 'Unable to connect to database. Please check your configs.');
    }

    public static function close()
    {
        if (self::$connected) {
            mysqli_close(self::$conn);
            self::$connected = false;
            return true;
        }
        return false;
    }

    public static function query($query_string)
    {
        self::Connect();
        self::$last_query = $query_string;

        $result = mysqli_query(self::$conn, $query_string);

        if(!$result) {
            return [
                'status' => false,
                'message' => mysqli_error(self::$conn)
            ];
        }

        self::Close();

        return [
            'status' => true,
            'result' => $result
        ];
    }

    public static function getLastQuery()
    {
        return Array(
            'Last Direct Query' => self::$last_query,
            'Last Table Query' => self::$last_table ? self::$last_table->getLastQuery(): ''
        );
    }

    public static function table($table)
    {
        self::$last_table = new MysqlTable($table);
        return self::$last_table;
    }

}
