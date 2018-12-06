<?php
namespace Core\Database\Migration\Interfaces;

interface SchemaInterface
{

	public static function create($table, $structure);

	public static function drop($table);

}