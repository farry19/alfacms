<?php
namespace Core\Database\Migration\Interfaces;

interface StructureInterface
{

	public function get();

	public function increments($column);

	public function string($column, $length);

	public function integer($column, $length);

}