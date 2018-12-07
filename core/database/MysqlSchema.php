<?php

namespace Core\Database;

use Core\Database\Migration\Interfaces\SchemaInterface;

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