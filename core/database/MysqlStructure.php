<?php

namespace Core\Database;

use Core\Database\Migration\Interfaces\StructureInterface;

class MysqlStructure implements StructureInterface
{

	private $query = '';

	public function get()
	{
		return rtrim(trim($this->query),', ');
	}

	public function increments($column)
	{
		$this->query .= "{$column} INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT, ";
	}

	public function string($column, $length = 255)
	{
		$this->query .= "{$column} VARCHAR({$length}), ";
	}

	public function integer($column, $length = 11)
	{
		$this->query .= "{$column}  INT({$length}), ";

		return $this;
	}

    public function unsigned()
    {
        $this->query .= rtrim($this->query, ', ') . " UNSIGNED, ";

        return $this;
    }

    public function unsignedInteger($column, $length = 11)
    {
        $this->query .= "{$column}  INT({$length}) unsigned, ";

        return $this;
    }

	public function text($column)
    {
	    $this->query .= "{$column} TEXT, ";
    }

    public function enum($column, $default_values = [])
    {
        $default_values = "'" . implode("', '", $default_values) . "'";

        $this->query = "{$column} ENUM ({$default_values}), ";

        return $this;
    }

    public function default($default_value)
    {
        $this->query = rtrim($this->query, ', ') . " DEFAULT '{$default_value}', ";

        return $this;
    }

    public function timestamps()
    {
	    $this->query .= "created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, ";
    }

    public function nullable()
    {
        $this->query = rtrim($this->query, ', ') . ' null, ';

        return $this;
    }
}
