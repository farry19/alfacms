<?php

namespace Core\Database\Interfaces;

interface TableInterface {

	public function getLastQuery();

    public function with($table, $join_type);

    public function join($table, $join_type);

    public function on($array_or_column_name, $column_value, $condition_type);

    public function select($query_string);

    public function orWhere($array_or_column_name, $column_value);

    public function andWhere($array_or_column_name, $column_value);

    public function where($array_or_column_name, $column_value, $condition_type);

    public function whereRaw($array_or_column_name, $column_value, $condition_type);

    public function orderBy($columns,$order);

    public function groupBy($columns);

    public function limit($start,$length);

    public function exists();

    public function result($mode);

    public function get();

    public function first();

    public function insert($dataArray);

    public function update($dataArray, $matchArray);

    public function delete($matchArray);

    public function getPK();

    public function truncate();
	
}