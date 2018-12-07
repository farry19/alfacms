<?php

namespace Core\Database;

use Core\ErrorView;
use Core\Database\MysqlQuery as DB;
use Core\Database\Interfaces\TableInterface;

class MysqlTable Implements TableInterface
{

    private $table_name = '';
    private $query_builder_string = '';
    private $query_builder_where = '';
    private $query_builder_after_where = '';
    private $last_query = '';
    private $join_table = '';

    function __construct($table_name)
    {
        $this->table_name = $table_name;
        $this->query_builder_string .= "SELECT * FROM {$this->table_name}";

        return $this;
    }

    public function getLastQuery()
    {
      return $this->last_query;
    }

    public function getQuery()
    {
      return "{$this->query_builder_string} {$this->query_builder_where} {$this->query_builder_after_where}";
    }

    private function resetQueryBuilder()
    {
      $this->last_query = "{$this->query_builder_string} {$this->query_builder_where} {$this->query_builder_after_where}";
      $this->query_builder_string='';
      $this->query_builder_where='';
      $this->query_builder_after_where='';
    }

    public function with($table, $join_type = '')
    {
        // WIP, not fully qualified method.

        $this->query_builder_where .= " {$join_type} JOIN {$table} ON {$table}.{$this->table_name}._id = {$this->table_name}.id ";

        return $this;
    }

    public function join($table, $join_type = '')
    {
        $this->join_table = $table;
        $this->query_builder_where .= " {$join_type} JOIN {$table} ";

        return $this;
    }

    public function on($array_or_column_name, $column_value = NULL, $condition_type = 'AND')
    {
      if(is_array($array_or_column_name)) {
        $where_string = '';
        if ($array_or_column_name != null) {
            foreach ($array_or_column_name as $key => $value) {
                $where_string .= " {$this->join_table}.{$key} = {$this->table_name}.{$value} {$condition_type} ";
            }

            $this->query_builder_where .= " ON ". rtrim($where_string, $condition_type);
        }
      } else {
        $this->query_builder_where .= " ON {$this->join_table}.{$array_or_column_name} = {$this->table_name}.{$column_value} ";
      }
      return $this;
    }

    public function select($query_string)
    {
      $this->query_builder_string = "SELECT {$query_string} FROM {$this->table_name}";

      return $this;
    }

    public function orWhere($array_or_column_name, $column_value = NULL)
    {
      if(is_array($array_or_column_name)) {
        $where_string = '';
        if ($array_or_column_name != null) {
            foreach ($array_or_column_name as $key => $value) {
                $where_string .= " {$key} ='{$value}' OR ";
            }

            $this->query_builder_where .= ($this->query_builder_where == '' ? ' WHERE ' : ' OR ') . rtrim($where_string, ' OR ');
        }
      } else {
        $this->query_builder_where .= ($this->query_builder_where == '' ? ' WHERE ' : ' OR ') . "{$array_or_column_name} = '{$column_value}' ";
      }
      return $this;
    }

    public function where($array_or_column_name, $column_value = NULL, $condition_type = 'AND')
    {
      if(is_array($array_or_column_name)) {
        $where_string = '';
        if ($array_or_column_name != null) {
            foreach ($array_or_column_name as $key => $value) {
                $where_string .= " {$key} ='{$value}' {$condition_type} ";
            }

            $this->query_builder_where .= ($this->query_builder_where==''?' WHERE ':' '.$condition_type.' ') . rtrim($where_string, " {$condition_type} ");
        }
      } else {
        $this->query_builder_where .= ($this->query_builder_where==''?' WHERE ':' '.$condition_type.' ') . "{$array_or_column_name} = '{$column_value}' ";
      }
      return $this;
    }

    public function whereRaw($array_or_column_name, $column_value = NULL, $condition_type = 'AND')
    {
      if(is_array($array_or_column_name)) {
        $where_string = '';
        if ($array_or_column_name != null) {
            foreach ($array_or_column_name as $key => $value) {
                $where_string .= " {$key} {$value} {$condition_type} ";
            }

            $this->query_builder_where .= ($this->query_builder_where==''?' WHERE ':' '.$condition_type.' ') . rtrim($where_string, " {$condition_type} ");
        }
      } else {
        $this->query_builder_where .= ($this->query_builder_where == '' ? ' WHERE ' : " {$condition_type} ") . "{$array_or_column_name} {$column_value}";
      }
      return $this;
    }

    public function orderBy($columns, $order = 'ASC')
    {
        if(is_array($columns)) {
            $orders = implode(',', $columns);
            $this->query_builder_where .= ' ORDER BY ' . $orders;
        } else {
            $this->query_builder_where .= ' ORDER BY ' . $columns . ' ' .$order;
        }
        return $this;
    }

    public function groupBy($columns)
    {
        if(is_array($columns)) {
            $groups = implode(',', $columns);
            $this->query_builder_where .= ' GROUP BY ' . $groups;
        } else {
            $this->query_builder_where .= ' GROUP BY ' . $columns;
        }
        return $this;
    }

    public function limit($start,$length=NULL){
        $this->query_builder_where .= ' LIMIT '.($length!=NULL?$start.",".$length:$start);
        return $this;
    }

    public function exists()
    {
        $response = DB::Query(MysqlTable::getQuery());
        MysqlTable::resetQueryBuilder();

        if($response['status']) {
            return TRUE;
        }
        return FALSE;
    }

    public function result($mode = 'rows') {
        $sql = DB::Query(MysqlTable::getQuery());
        $record = array();

        if($sql) {
            if ($mode == 'rows') {
                while ($data = mysqli_fetch_assoc($sql)) {
                    $record[] = $data;
                }
            } elseif ($mode == 'row') {
                if ($data = mysqli_fetch_assoc($sql)) {
                    $record = $data;
                }
            }
        }

        MysqlTable::resetQueryBuilder();
        return $record;
    }

    public function get()
    {
      $response = DB::Query(MysqlTable::getQuery());
      $record = array();

      if($response['status']) {
          while ($data = mysqli_fetch_assoc($response['result'])) {
              $record[] = (object)$data;
          }
      }

      MysqlTable::resetQueryBuilder();

      if($record) {
          return $record;
      }
      return FALSE;
    }

    public function first()
    {
      $response = DB::Query(MysqlTable::getQuery());
      MysqlTable::resetQueryBuilder();

      if($response['status']) {
        if ($data = mysqli_fetch_assoc($response['result'])) {
            return (object) $data;
        }
      }

      return FALSE;
    }

    public function insert($data_array)
    {
        $columns = '';
        $values = '';

        if ($data_array) {
            foreach ($data_array as $key => $value) {
                $columns .= "`{$key}`, ";
                $values .= "'{$value}', ";
            }

//            dd("insert into `" . $this->table_name . "` (" . rtrim($columns, ', ') . ") values (" . rtrim($values, ', ') . ");");
            DB::Query("insert into `" . $this->table_name . "` (" . rtrim($columns, ', ') . ") values (" . rtrim($values, ', ') . ");");

            $id = @mysqli_insert_id();

            self::resetQueryBuilder();
            return $id;
        } else {
            self::resetQueryBuilder();
            return FALSE;
        }

        self::resetQueryBuilder();
        return FALSE;
    }

    public function update($data_array, $match_array)
    {
        $updates = '';
        $matches = '';

        if($data_array && $match_array) {
            foreach ($data_array as $key => $value) {
                $updates .= "{$key} ='{$value}', ";
            }

            foreach ($match_array as $key => $value) {
                $matches .= " {$key} = '{$value}' AND ";
            }

            $temp_query = "update `" . $this->table_name . "` set " . rtrim($updates, ', ') . " where " . rtrim($matches, ' AND ');

            $response = DB::Query($temp_query);

            self::resetQueryBuilder();
            return $response;
        } else {
            self::resetQueryBuilder();
            return false;
        }

        self::resetQueryBuilder();
        return false;
    }

    public function delete($match_array)
    {
        $matches = '';

        if ($match_array) {
            foreach ($match_array as $key => $value) {
                $matches .= " {$key} = '{$value}' AND ";
            }

            $query_string = "delete from `" . $this->table_name . "` where " . rtrim($matches, ' AND ');

            $response = DB::Query($query_string);

            self::resetQueryBuilder();
            return $response;
        } else {
            self::resetQueryBuilder();
            return false;
        }

        self::resetQueryBuilder();
        return false;
    }

    public function getPK()
    {
        $response = DB::Query("SELECT * FROM {$this->table_name}");

        if($response['status'] == FALSE) {
            MysqlTable::resetQueryBuilder();
            ErrorView::render('Database Error', $response['message']);
        }

        $key = '';
        $response = DB::Query("SHOW KEYS FROM {$this->table_name} WHERE Key_name = 'PRIMARY'");

        if($response['status']) {
            while ($data = mysqli_fetch_assoc($response['result'])) {
                $key = $data['Column_name'];
                break;
            }
        }

        self::resetQueryBuilder();
        return $key;
    }

    public function truncate()
    {
        DB::Query("truncate table `{$this->table_name}`");

        self::resetQueryBuilder();
        return true;
    }
}