<?php

namespace Core\Database\Migration;

use Core\Database\Migration\Interfaces\StructureInterface;

class MysqlStructure implements StructureInterface
{

	private $query = '';

	public function get()
	{
		return rtrim(trim($this->query),",");
	}

	public function increments($column)
	{
		$this->query .= $column . ' INT(11) PRIMARY KEY auto_increment, ';
	}

	public function string($column, $length=255)
	{
		$this->query .= $column . ' VARCHAR('.$length.'), ';
	}

	public function integer($column, $length=11)
	{
		$this->query .= $column . ' INT('.$length.'), ';
	}

}