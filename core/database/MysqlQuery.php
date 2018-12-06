<?php

namespace Core\Database;

use Core\Util\ErrorView;
use Core\Database\Interfaces\QueryInterface;

class MysqlQuery implements QueryInterface
{

    private static $connected = false;
    private static $conn = FALSE;
    private static $lastQuery = '';
    private static $lastTableQuery = '';
    private static $lastTable = NULL;
    private static $mocked_instance = NULL;

    public static function connect()
    {
        if(self::$connected)
            self::close();

        $default = config('DB_DEFAULT');
        self::$conn = @mysqli_connect(
            config($default.'_HOST'), 
            config($default.'_USERNAME'), 
            config($default.'_PASSWORD'), 
            config($default.'_DATABASE'), 
            config($default.'_PORT')
        );
        if(self::$conn)
        {
            self::$connected = true;
            return true;
        }
        MysqlQuery::$connected = false;
        ErrorView::render('Database Error', 'Unable to connect to database. Please check your configs.');
    }

    public static function close()
    {
        if (self::$connected == true)
        {
            mysqli_close(self::$conn);
            self::$connected = false;
            return true;
        }
        return false;
    }

    public static function query($QueryString)
    {
        self::Connect();
        self::$lastQuery = $QueryString;
        $result = mysqli_query(self::$conn, $QueryString);
        if(!$result)
            return [
                'status' => false,
                'message' => mysqli_error(self::$conn)
            ];
        self::Close();        
        return [
            'status' => true,
            'result' => $result
        ];
    }

    public static function getLastQuery()
    {
        return Array(
            'Last Direct Query' => self::$lastQuery,
            'Last Table Query' => self::$lastTable ? self::$lastTable->getLastQuery(): ''
        );
    }

    public static function table($table)
    {
        self::$lastTable = new MysqlTable($table);
        return self::$lastTable;
    }

}



?>