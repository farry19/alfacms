<?php

namespace Core\Database\Interfaces;

interface QueryInterface {

	public static function getLastQuery();

	public static function connect();

	public static function close();

	public static function query($query_string);

	public static function table($table_name);
	
}