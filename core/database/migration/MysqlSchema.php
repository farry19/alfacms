<?php

namespace Core\Database\Migration;

use Core\Database\Migration\Interfaces\SchemaInterface;
use Core\Database\Migration\MysqlStructure;
use Core\Database\MysqlQuery;

class MysqlSchema implements SchemaInterface
{

	public static function create($table, $structure)
	{
		$new_structure = new MysqlStructure;

		$structure($new_structure);
		$query = $new_structure->get();

		MysqlQuery::query("CREATE TABLE {$table} ({$query})");
	}

	public static function drop($table)
	{
		MysqlQuery::query("DROP TABLE {$table}");
	}

}