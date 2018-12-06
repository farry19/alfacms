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

    public function resetQueryBuilder()
    {
      $this->last_query = "{$this->query_builder_string} {$this->query_builder_where} {$this->query_builder_after_where}";
      $this->query_builder_string='';
      $this->query_builder_where='';
      $this->query_builder_after_where='';
    }

    public function with($table, $join_type = '')
    {
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
        $whereString = '';
        if ($array_or_column_name != null) {
            foreach ($array_or_column_name as $key => $value) {
//                if ($whereString == "") {
//                    $whereString = $whereString . " " . $this->join_table . "." . $key . "=" . $this->table_name . "." . $value . " ";
//                } else {
//                    $whereString = $whereString . " ".$condition_type." " .$this->join_table . "." . $key . "=" .$this->table_name . "." . $value . " ";
//                }
                $whereString .= " {$this->join_table}.{$key} = {$this->table_name}.{$value} {$condition_type} ";
            }

            $this->query_builder_where .= " ON ". rtrim($whereString, $condition_type);
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
//                if ($where_string == "") {
//                    $where_string = $where_string . " " . $key . "='" . $value . "' ";
//                } else {
//                    $where_string = $where_string . " OR " . $key . "='" . $value . "' ";
//                }
                $where_string .= " {$key} ='{$value}' OR ";
            }

            $this->query_builder_where .= ($this->query_builder_where == '' ? ' WHERE ' : ' OR ') . rtrim($where_string, ' OR ');
        }
      } else {
        $this->query_builder_where .= ($this->query_builder_where == '' ? ' WHERE ' : ' OR ') . "{$array_or_column_name} = '{$column_value}' ";
      }
      return $this;
    }

    public function andWhere($array_or_column_name, $column_value = NULL)
    {
      if(is_array($array_or_column_name)) {
        $where_string = '';
        if ($array_or_column_name != null) {
            foreach ($array_or_column_name as $key => $value) {
//                if ($where_string == "") {
//                    $where_string = $where_string . " " . $key . "='" . $value . "' ";
//                } else {
//                    $where_string = $where_string . " AND " . $key . "='" . $value . "' ";
//                }
                $where_string .= " {$key} ='{$value}' AND ";
            }

            $this->query_builder_where .= ($this->query_builder_where == '' ? ' WHERE ' : ' AND ') . rtrim($where_string, ' AND ');
        }
      } else {
        $this->query_builder_where .= ($this->query_builder_where==''?' WHERE ':' AND ') . "{$array_or_column_name} = '{$column_value}' ";
      }
      return $this;
    }

    public function where($array_or_column_name, $column_value = NULL, $condition_type = 'AND')
    {
      if(is_array($array_or_column_name)) {
        $whereString = '';
        if ($array_or_column_name != null) {
            foreach ($array_or_column_name as $key => $value) {
//                if ($whereString == "") {
//                    $whereString = $whereString . " " . $key . "='" . $value . "' ";
//                } else {
//                    $whereString = $whereString . " ".$condition_type." " . $key . "='" . $value . "' ";
//                }
                $whereString .= " {$key} ='{$value}' {$condition_type} ";
            }

            $this->query_builder_where .= ($this->query_builder_where==''?' WHERE ':' '.$condition_type.' ') . rtrim($whereString, " {$condition_type} ");
        }
      } else {
        $this->query_builder_where .= ($this->query_builder_where==''?' WHERE ':' '.$condition_type.' ') . "{$array_or_column_name} = '{$column_value}' ";
      }
      return $this;
    }

    public function whereRaw($array_or_column_name, $column_value = NULL, $condition_type = 'AND')
    {
      if(is_array($array_or_column_name)) {
        $whereString = '';
        if ($array_or_column_name != null) {
            foreach ($array_or_column_name as $key => $value) {
//                if ($whereString == "") {
//                    $whereString = $whereString . " " . $key . " " . $value . " ";
//                } else {
//                    $whereString = $whereString . " ".$condition_type." " . $key . " " . $value . " ";
//                }
                $whereString .= " {$key} {$value} {$condition_type} ";
            }

            $this->query_builder_where .= ($this->query_builder_where==''?' WHERE ':' '.$condition_type.' ') . rtrim($whereString, " {$condition_type} ");
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
//            for ($i=0; $i < count($columns); $i++) {
//                $orders .= ($orders==''?$columns[$i]:','.$columns[$i]);
//            }
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
//            for ($i=0; $i < count($columns); $i++) {
//                $groups .= ($groups==''?$columns[$i]:','.$columns[$i]);
//            }
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

        if($response['status']) return TRUE;
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

      if($record)  return $record;
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

    public function insert($dataArray)
    {
        $columns = '';
        $values = '';

        if ($dataArray) {
            foreach ($dataArray as $key => $value) {
//                if ($columns == '') {
//                    $columns .= $key;
//                } else {
//                    $columns .= ",{$key}";
//                }
                $columns .= "{$key}, ";
//
//                if ($values == '') {
//                    $values .= "'{$value}'";
//                } else {
//                    $values .= ",'{$value}'";
//                }
                $values .= "{$value}, ";
            }
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

    public function update($dataArray, $matchArray)
    {
        $updates = '';
        $matches = '';

        if($dataArray && $matchArray) {
            foreach ($dataArray as $key => $value) {
//                if ($updates == '') {
//                    $updates = $updates . $key . "='" . $value . "'";
//                } else {
//                    $updates = $updates . "," . $key . "='" . $value . "'";
//                }
                $updates .= "{$key} ='{$value}', ";
            }

            foreach ($matchArray as $key => $value) {
//                if ($matches == '') {
//                    $matches = $matches . $key . "='" . $value . "'";
//                } else {
//                    $matches = $matches . " and " . $key . "='" . $value . "'";
//                }
                $matches .= " {$key} = '{$value}' AND ";
            }

            $tempQuery = "update `" . $this->table_name . "` set " . rtrim($updates, ', ') . " where " . rtrim($matches, ' AND ');

            $response = DB::Query($tempQuery);

            self::resetQueryBuilder();
            return $response;
        } else {
            self::resetQueryBuilder();
            return false;
        }

        self::resetQueryBuilder();
        return false;
    }

    public function delete($matchArray)
    {
        $matches = '';

        if ($matchArray) {
            foreach ($matchArray as $key => $value) {
//                if ($matches == '') {
//                    $matches = $matches . $key . "='" . $value . "'";
//                } else {
//                    $matches = $matches . " and " . $key . "='" . $value . "'";
//                }
                $matches .= " {$key} = '{$value}' AND ";
            }

            $queryString = "delete from `" . $this->table_name . "` where " . rtrim($matches, ' AND ');

            $response = DB::Query($queryString);

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