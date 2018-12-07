<?php

namespace Core\Database;

class Model extends DB {

	private static function getTableName(){
		$childClassPath = get_called_class();
		$childClassParsed = explode('\\',$childClassPath);
		$childClassName = $childClassParsed[count($childClassParsed)-1];
		return (isset(static::$table)?static::$table:$childClassName);
	}

	public static function exists()
	{
		return self::default()->table(self::getTableName())->exists();
	}

	public static function all(){		
		return self::default()->table(self::getTableName())->get();
	}

	public static function create($data)
	{
		return self::default()->table(self::getTableName())->insert($data);	
	}

	public static function first(){
		return self::default()->table(self::getTableName())->first();
	}

	public static function where($arrayOrColumnName, $columnValue=NULL, $conditionType = 'AND'){
		return self::default()->table(self::getTableName())->where($arrayOrColumnName, $columnValue, $conditionType);
	}

	public static function find($id){
		$pkColumn = self::default()->table(self::getTableName())->getPK();
		$className = get_called_class();
		$cls = new $className();
		$tbl = self::default()->table(self::getTableName())->where($pkColumn,$id)->first();
		if($tbl){
			foreach($tbl as $key => $value){
				$cls->$key = $value;
			}
		}
		return $cls;
	}

	public function delete(){
		$pkColumn = self::default()->table(self::getTableName())->getPK();
		$vars = get_object_vars($this);
		$where = array($pkColumn => $vars[$pkColumn]);
		return self::default()->table(Self::getTableName())->delete($where);
	}

	public function save(){
		$state = 'create';
		$pkColumn = self::default()->table(self::getTableName())->getPK();
		$vars = get_object_vars($this);
		$where = array();
		if($vars){
			foreach($vars as $key => $value){
				if($key == $pkColumn){
					$where = array(
						$key => $value
					);
					unset($vars[$key]);
					$state = 'update';
					break;
				}
			}
		}
		if($state=='create')
			return self::default()->table(self::getTableName())->insert($vars);
		self::default()->table(Self::getTableName())->update($vars,$where);
	}

}