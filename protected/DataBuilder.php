<?php

class DataBuilder{
	private $field_array=null;

	function __construct(){}
	
	function GenerateData($field_array){
		$comma=null;

		$data=" (";

		foreach ($field_array as $k=>$v){
			$data.=$comma." '".$this->GetCellData($v, $i)."'";
			if(is_null($comma)){
				$comma=", ";
			}
		}
		$data.=")";
			
		return $data;
	}
	
	function GetCellData($field_object, $row_number){
		//$type, $lenght, $name
		switch ($field_object->GetType()) {
			case 'tinyint' :
				return mt_rand ( 0, 127 );
				break;
			case 'smallint' :
				return mt_rand ( 0, 32767 );
				break;
			case 'mediumint' :
				return mt_rand ( 0, 8388607 );
				break;
			case 'int' :
				return mt_rand ( 0, 2147483647 );
				break;
			case 'bigint' :
				return mt_rand ( 0, 9223372036854775807 );
				break;
			case 'float' :
				$rand = mt_rand ( 1, 358 );
				return $rand * cos ( $rand );
				break;
			case 'double' :
				$rand = mt_rand ( 1, 358 );
				return $rand * sin ( $rand );
				break;
			case 'timestamp' :
				$m = mt_rand ( 1, 12 );
				$d = mt_rand ( 1, 27 );
				$y = mt_rand ( 1970, 2037 );
				$h = mt_rand ( 0, 23 );
				$min = mt_rand ( 0, 59 );
				
				return date ( "Y-m-d h:m:s", mktime ( $h, $min, 0, $m, $d, $y ) );
				break;
			case 'date' :
				$m = mt_rand ( 1, 12 );
				$d = mt_rand ( 1, 27 );
				$y = mt_rand ( 1900, 2100 );
				return date ( "Y-m-d ", mktime ( 0, 0, 0, $m, $d, $y ) );
				break;
			case 'time' :
				$h = mt_rand ( 0, 23 );
				$min = mt_rand ( 0, 59 );
				return $h . ":" . $m . ":00";
				break;
			case 'datetime' :
				$m = mt_rand ( 1, 12 );
				$d = mt_rand ( 1, 27 );
				$y = mt_rand ( 1900, 2100 );
				$h = mt_rand ( 0, 23 );
				$min = mt_rand ( 0, 59 );
				return date ( "Y-m-d h:m:s", mktime ( $h, $min, 0, $m, $d, $y ) );
				break;
			case 'year' :
				return mt_rand ( 1901, 2155 );
				break;
			case 'enum' :
				break;
			case 'tinyblob' :
			case 'mediumblob' :
			case 'longblob' :
			case 'blob' :
				return $this->GetText ();
				break;
			case 'varchar' :
			case 'char' :
				return $this->GetText ( $field_object->GetLength() );
				break;
			case 'decimal' :
				break;
		
		}
	}
	
	function GetText($lendth=0) {
		$text='Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
		if($lendth){
			$text=substr($text,0,$lendth);
		}
		
		return $text;
	}
}